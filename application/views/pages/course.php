<link href="<?= base_url('public/css/component.css') ?>" rel="stylesheet"/>
<link href="<?= base_url('public/components/alertify.min.css') ?>" rel="stylesheet"/>
<style type="text/css">
    .monkeyb-cust-file {
        overflow: hidden;
        position: relative;
        display: inline-block;
        background-color: #9cf;
        color: #fff;
        text-align: center;
        -web-border-radius: 10px;
        -moz-border-radius: 10px;
        border-radius: 10px;
        padding: 10px 30px;
        font-size: 26px;
        font-family: Arial, Microsoft JhengHei;
    }

    .monkeyb-cust-file input {
        position: absolute;
        opacity: 0;
        filter: alpha(opacity=0);
        top: 0;
        right: 0;
        width: 100%;
        height: 100%;
    }
    li {
        cursor: pointer;
    }
</style>
<div class="content">
    <div class="container-fluid">
        <div class="row" id="table">
            <div class="col-xs-2 scrollFix">
                <form role="form">
                    <bs-drop title='教室代號' bs-class='bs-default' model='room_id' :opt-arr=<?= json_encode($rooms,JSON_UNESCAPED_UNICODE) ?> ></bs-drop>
                    <div class="form-group">
                        <label class='control-label' for='startDate'>選擇課表的開始日期</label>
                        <input id='startDate' v-model='start_date' type='date'  class='form-control'/>
                    </div>
                    <button type='button' class='btn btn-block btn-success' hidden id='saveBtn' onclick='save()'>儲存課表</button>
                </form>
            </div>
            <div class="col-xs-10">
                <div id="calendar" class="container">
                    <div class="component">
                        <table id="roomTable" border="1"></table>
                    </div>
                </div>
            </div>
        </div>


        <!--		    <div class="form-group col-xs-2 col-xs-push-3">-->
        <!--			    <form action="-->
        <? //=base_url('Admin/importClass');?><!--" method="post" accept-charset="utf-8" enctype='multipart/form-data' id="upload_form" >-->
        <!--				    <div class="doc-container">-->
        <!--					    <div class="monkeyb-cust-file">-->
        <!--						    <span>匯入課表</span>-->
        <!--						    <input type="file" id="upload" name="upload" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" onchange="sub()"/>-->
        <!--					    </div>-->
        <!--				    </div>-->
        <!--			    </form>-->
        <!--		    </div>-->
    </div>
</div>
<script type="text/javascript">
    let start_date = '';
    String.prototype.replaceAt = function (index, chr) {
        if (index > this.length - 1) return this;
        return this.substr(0, index) + chr + this.substr(index + 1);
    };
    new Vue({
        el: "#table",
        data: {room_id: "", total: 0, date: "", mode: 0, start_date: ""},
        watch: {
            start_date: function () {
                if (this.room_id !== "" && this.start_date !== "") {
                    this.search(0);
                }
            },
            room_id: function () {
                if (this.room_id !== "" && this.start_date !== "") {
                    this.search(0);
                }
            }
        },
        methods: {
            search(diff) {
                $("#saveBtn").attr("hidden", false);
                room_id = this.room_id;
                start_date = this.start_date;
                let application = {
                    'room_id': this.room_id,
                    'start': this.start_date,
                    'end': ""
                };
                today = new Date(this.start_date);
                if (today.getDay() !== 0) { //set back Monday
                    today.setDate((today.getDate() - today.getDay() + 1 + this.total));
                } else {//set to next week Monday
                    today.setDate((today.getDate() + 1 + this.total));
                }
                application['start'] = today.getUTCFullYear() + format(today.getMonth() + 1) + format(today.getDate());
                today.setDate((today.getDate() + 6));//set today to Sunday
                application['end'] = today.getUTCFullYear() + format(today.getMonth() + 1) + format(today.getDate());
                let end = application['end'];
                $.post("<?=base_url("Admin/searchRoom")?>", application, function (jsonData) {
                    show_class(JSON.parse(jsonData), application['start'], end);
                });
            }
        }
    });

    function sub() {
        document.getElementById("upload_form").submit();
    }

    function save() {
        alertify.defaults.glossary.title = "<h2 style='font-size: 2em'>系統通知</h2>";
        alertify.defaults.glossary.ok = "確定";
        alertify.defaults.glossary.cancel = "取消";
        let status = ["", "", "", "", "", "", ""];
        let postdata = {
            "data": {}
        };

        alertify.confirm(
            "<label>選擇該課表的結束日期</label><input id='alert_endDate'  type='date' class='form-control' />"
            , function () {
                let endDate = document.getElementById("alert_endDate").value;

                if (endDate === "") {
                    alertify.warning("請選擇結束日期");
                    return;
                }
                let today = new Date(start_date);
                if (today.getDay() !== 0) { //set back Monday
                    today.setDate((today.getDate() - today.getDay() + 1));
                } else {//set to next week Monday
                    today.setDate((today.getDate() + 1));
                }
                let count = 0;
                for (let j = 1; j < 8; j++) {
                    let isStart = true;
                    for (let i = 0; i < 15; i++) {
                        let x = document.getElementById("roomTable").rows[2 + i].cells.namedItem(i + "_" + j).innerHTML;

                        status[j - 1] += x === "2" ? "0" : x;

                        if (status[j - 1][i] === "1" && isStart) {
                            postdata["data"][count] = {};
                            postdata["data"][count]["start"] = i + 1;
                            isStart = false;
                            if (i === 14) {
                                postdata["data"][count]["end"] = i + 1;
                                postdata["data"][count]["date"] = today.getUTCFullYear() + format(today.getMonth() + 1) + format(today.getDate());
                                postdata["data"][count]["room_id"] = room_id;
                                count++;
                            }
                        } else if (status[j - 1][i] === "0" && !isStart) {
                            postdata["data"][count]["end"] = i;
                            postdata["data"][count]["date"] = today.getUTCFullYear() + format(today.getMonth() + 1) + format(today.getDate());
                            postdata["data"][count]["room_id"] = room_id;
                            count++;
                            isStart = true;
                        } else if (i === 14 && !isStart && status[j - 1][i] === "1") {
                            postdata["data"][count]["end"] = i + 1;
                            postdata["data"][count]["date"] = today.getUTCFullYear() + format(today.getMonth() + 1) + format(today.getDate());
                            postdata["data"][count]["room_id"] = room_id;
                            count++;
                        }
                    }
                    today.setDate((today.getDate() + 1));
                }
                postdata["endDate"] = endDate;

                $.post("<?=base_url("Admin/update_class")?>", postdata, function (msg) {
                    if (msg === "SUCCESS") {
                        $.notify({
                            icon: 'pe-7s-shield',
                            message: "儲存成功"
                        }, {
                            type: 'success',
                            timer: 10
                        });
                    } else {
                        $.notify({
                            icon: 'pe-7s-shield',
                            message: "儲存發生錯誤"
                        }, {
                            type: 'danger',
                            timer: 10
                        });
                    }

                    setTimeout("location.reload()", 500);
                });
            });
    }

</script>
<script src="<?= base_url('public/js/Adminclass.js') ?>"></script>
<script src="<?= base_url('public/js/classRoomCourse.js') ?>"></script>
<script src="<?= base_url('public/components/alertify.min.js') ?>"></script>
<script src="<?= base_url('public/js/scrollFix.js') ?>"></script>
