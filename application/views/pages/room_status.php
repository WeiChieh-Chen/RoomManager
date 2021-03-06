<link href="<?= base_url('public/components/alertify.min.css')?>" rel="stylesheet"/>
<style>
    .display {
        font-size: 1.5em;
    }

    .select_col {
        cursor: pointer;
    }
</style>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <button id='editBtn' class='btn btn-lg btn-info' onclick="showExcolum()">編輯</button>
            <button class='fnBtn btn btn-lg btn-primary' onclick="submit()" hidden>變更</button>
            <button class='fnBtn btn btn-lg btn-success' data-toggle='modal' data-target='#addRoom' hidden>新增</button>
            <button class='fnBtn btn btn-lg btn-warning' onclick="recover()" hidden>取消</button>
        </div>
        <br/>
        <div class="row">
            <div class="col-xs-12">
                <table id="showRoom" class="display" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th class="select_col">移除教室</th>
                        <th>教室代號</th>
                        <th>教室名稱</th>
                        <th>啟用狀態</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($classroom as $room_id => $room):
                        echo "<tr id='{$room_id}'>" . "<td class='select_col' onclick=select('{$room_id}')></td>" . "<td>{$room_id}</td>" . "<td><span class='select_col_reverse'>{$room['info']['room_name']}</span><div class='ui input'>" . "<input type='text' class='select_col' value='{$room['info']['room_name']}' onkeyup=changeName('{$room_id}',this.value) />" . "</div></td>" . "<td>";
                        if ($room['info']['active'] == 1):
                            echo "<input type='checkbox' class='actBtn' data-toggle='toggle' data-on='啟動' data-off='關閉' data-height='10' data-onstyle='primary' data-offstyle='danger' disabled checked>";
                        else:
                            echo "<input type='checkbox' class='actBtn' data-toggle='toggle' data-on='啟動' data-off='關閉' data-height='10' data-onstyle='primary' data-offstyle='danger' disabled>";
                        endif;
                        echo "</td></tr>";
                    endforeach;
                    ?>
                    </tbody>
                    <tfoot></tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="addRoom">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h3 class="modal-title">新增可借用教室</h3>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <?= form_label("教室代號&emsp;<span style='color:red'>設定後不可更改</span>", "room_id", ['class' => 'control-label']) ?>
                    <?= form_input(['v-model' => 'id', 'id' => 'room_id', 'class' => 'form-control', 'type' => 'text', 'placeholder' => 'BGC000', 'name' => 'room_id']) ?>
                </div>
                <div class="form-group">
                    <?= form_label("教室名稱", "room_name", ['class' => 'control-label']) ?>
                    <?= form_input(['v-model' => 'name', 'class' => 'form-control', 'type' => 'text', 'placeholder' => '綜三館會議室', 'name' => 'room_name']) ?>
                </div>
            </div>
            <div class="modal-footer">
                <h4 style="color: red">本系統允許分次加入教室，當全部設定完畢後，請記得點選&nbsp;<button class='btn btn-info' disabled>變更</button>
                    ！
                </h4>
                <?= form_button(null, '關閉', ['class' => 'btn btn-lg btn-default', 'data-dismiss' => 'modal']) ?>
                <button type='button' class="btn btn-lg" :class="[ok?'btn-success':'btn-default']" :disabled="!ok" @click="add"
                        data-dismiss='modal'>加入
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script src="<?= base_url('public/js/room_status.js') ?>"></script>
<script src="<?= base_url('public/components/alertify.min.js')?>"></script>
<script>
    let oldInfo = <?= json_encode($classroom, JSON_UNESCAPED_UNICODE)?>;
    let newInfo = <?= json_encode($classroom, JSON_UNESCAPED_UNICODE)?>;;

    function submit() {
        alertify.defaults.glossary.title = "<h2 style='font-size: 2em'>教室變更再確認</h2>";
        alertify.defaults.glossary.ok = "確定";
        alertify.defaults.glossary.cancel = "取消";
        let content = "<h3>您確定將進行以下變更？</h3>";
        Object.keys(newInfo).forEach(function(room_id){
            if(newInfo[room_id]['status'] !== "NORMAL"){
                switch (newInfo[room_id]['status']){
                    case "INSERT":
                        content += "<h3><span style='color: green'>增加教室</span>&emsp;"+room_id+"&emsp;"+newInfo[room_id]['info']['room_name']+"</h3>";
                        break;
                    case "UPDATE":
                        let str = "";
                        if(oldInfo[room_id]['info']['room_name'] !== newInfo[room_id]['info']['room_name']){
                            str +=  "<span style='color: orangered'>"+newInfo[room_id]['info']['room_name']+"</span>&emsp;";
                        }
                        if(oldInfo[room_id]['info']['active'] !== newInfo[room_id]['info']['active']){
                            let text = newInfo[room_id]['info']['active'] === "1"?"啟動":"關閉";
                            if(text === "啟動") {
                                str += "<span style='color: dodgerblue'>" + text + "</span>&emsp;";
                            } else {
                                str += "<span style='color: darkred'>" + text + "</span>&emsp;";
                            }
                        }
                        content += "<h3><span style='color: orangered'>更新資訊</span>&emsp;"+room_id+"&emsp;"+str+"</h3>";
                        break;
                    case "DELETE":
                        content += "<h3><span style='color: red'>移除教室</span>&emsp;"+room_id+"</h3>";
                        break;
                }
            }
        });
        alertify.confirm(
            content
            ,function () {
                $.post("<?=base_url('/Admin/uploadData')?>", newInfo, function () {
                    location.reload();
                });
            },function (){
                location.reload();
            }).set('resizable',true).resizeTo('50%','60%');
    }

    // room_status
    let addRoom = new Vue({
        el: "#addRoom",
        data: {
            id: "",
            name: "",
        },
        computed: {
            ok: function () {
                let tmpId = this.id;
                let judge = Object.keys(newInfo).every(function (room_id) {
                    return room_id !== tmpId;
                });

                if (!judge) {
                    $.notify({
                        icon: 'pe-7s-repeat',
                        message: "教室代號已存在！"
                    }, {
                        type: 'danger',
                        timer: 100,
                        animate: {
                            enter: 'animated rollIn',
                            exit: 'animated rollOut'
                        }
                    });
                }
                return this.id !== "" && this.name !== "" && judge;
            }

        },
        methods: {
            add: function () {
                let tbody = document.getElementsByTagName("tbody")[0];
                let newRow = "<td class='select_col' onclick=select('" + this.id + "')></td>" +
                    "<td>" + this.id + "</td>" +
                    "<td><span class='select_col_reverse' hidden>" + this.name + "</span><div class='ui input'>" +
                    "<input type='text' class='select_col' value=" + this.name + " onblur=changeName('" + this.id + "',this.value) />" +
                    "</div></td>" +
                    "<td>" +
                    "<input type='checkbox' class='actBtn' data-toggle='toggle' data-on='啟動' data-off='關閉' data-height='10' data-onstyle='primary' data-offstyle='danger' checked>" +
                    "</td>";
                let newDom = document.createElement("tr");
                newDom.setAttribute("id", this.id);
                newDom.innerHTML = newRow;
                tbody.insertBefore(newDom, tbody.childNodes[0]);
                // initial button of active as bootstrapToggle.
                $('.actBtn').first().bootstrapToggle();
                // Inserts new datus into array.
                newInfo[this.id] = {
                    "status": "INSERT",
                    "info": {
                        "room_name": this.name,
                        "active": "1"
                    }
                };
            }
        }
    });

    $(document).click(function () {
        $('.actBtn').bootstrapToggle();
        if (localStorage.getItem("edit") === "true") {
            showExcolum();
        } else {
            recover();
        }
    });

    $('#addRoom').on('hidden.bs.modal',function(){
        addRoom.id='';
        addRoom.name='';
    });
</script>
