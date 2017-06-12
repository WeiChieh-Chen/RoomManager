<div id="page-wrapper">
    <div class="row">
        <br>
        <br>
        <div class="col-lg-2">
        </div>
        <div class="col-lg-10">
            <button class="btn btn-success btn-md" data-toggle="modal" data-target="#blacklistModal" >新增</button>
        </div>
        <div class="col-lg-12">
        <br>
        </div>
        <div class="col-lg-2">
        </div>
        <div class="col-lg-9">
            <div class="panel panel-default">
                <table width="100%" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th style="font-size: 20px;">學號</th>
                            <th style="font-size: 20px;">教室代碼</th>
                            <th style="font-size: 20px;">原因</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $i=0; ?>
                    <?php foreach($blacklist as $key => $row){ ?>
                        <tr class="odd">
                            <td style="font-size: 20px;"><?php echo $row->student_id; ?></td>
                            <td style="font-size: 20px;"><?php echo $row->room_id; ?></td>
                            <td style="font-size: 20px;"><?php echo $reasonlist[$i] ?></td>
                            <?php $i++; ?>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-lg-1">
        </div>
    </div>
</div>
<?php
    $options = [
        ['name' => 'BGC0305', 'value' => 'BGC0305'],
        ['name' => 'BGC0316', 'value' => 'BGC0316'],
        ['name' => 'BGC0402', 'value' => 'BGC0402'],
        ['name' => 'BGC0501', 'value' => 'BGC0501'],
        ['name' => 'BGC0508', 'value' => 'BGC0508'],
        ['name' => 'BGC0513', 'value' => 'BGC0513'],
        ['name' => 'BGC0601', 'value' => 'BGC0601'],
        ['name' => 'BGC0614', 'value' => 'BGC0614']
    ];
?>
<div id="blacklistModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h2 class="modal-title">新增黑名單</h2>
      </div>
      <div class="modal-body">
            <div class="row">
                <div class="col-xs-6">
                    <text-field text="學號" model="studentID" placeholder="請輸入學號" ></text-field>
                </div>
                <div class="col-xs-6">
                    <?= form_label("選擇教室","roomID",['class' => 'control-label'])?>
                    <bs-drop title='教室代碼' bs-class='btn-primary' model='roomID' :opt-arr=<?=json_encode($options,JSON_UNESCAPED_UNICODE)?>></bs-drop>
                </div>
            </div>
            <div class="form-group">
                <?= form_label("原因","reason",['class' => 'control-label','style' => 'font-size: 1.2em'])?>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-xs-3" v-for="(reason,id) in list">
                        <button type="button" class="btn" :id="id" @click="toggle(id)">{{reason}}</button>
                    </div>
                </div>
            </div>
      </div>
      <div class="modal-footer">
        <?= form_button(null,'關閉',['class' => 'btn btn-default','data-dismiss'=>'modal'])?>
        <button type="button" class="btn btn-primary" :disabled="!isSubmit" @click="submit">送出</button>
      </div>
    </div>

  </div>
</div>

<script language=javascript>
    new Vue({
        el: "#blacklistModal",
        data: {
            list: <?= json_encode($reasonAll,JSON_UNESCAPED_UNICODE)?>,
            studentID:"",
            roomID:"",
            reason:""
        },
        computed:{
          isSubmit(){
              return this.studentID !== "" && this.roomID !== "" && this.reason !== "";
          }
        },
        methods: {
            toggle: function(id){
                let node = document.getElementById(id).classList.toggle("btn-danger");
                let judge = this.reason.split(",").every(function(ids){
                    return ids !== id;
                });
                if(judge){
                    this.reason += id+',';
                }else {
                    let regx = new RegExp(id+',',"g");
                    this.reason = this.reason.replace(regx,"");
                }
            },
            submit(){
                this.reason = this.reason.substring(0,this.reason.length-1); // 6,2, -> 6,2
                let arr = this.reason.split(","); // ['6','2']
                arr.sort(function(a,b){return a-b}); // ['2','6']
                this.reason = arr.toString(); // 2,6

                let data = {};
                data[this.studentID] = {};
                data[this.studentID][this.roomID] = this.reason;
                $.post("<?=base_url('/Admin/insertBlacklist')?>",data,function(msg){
                    location.reload();
                });
            }
        }
    });
//function chkData()
//{
//    var choose = true;
//    for(var i=1;i<8;i++){
//        if(document.getElementsByName("reason"+i)[0].checked){
//            choose = false;
//            break;
//        }
//    }
//    if (document.getElementsByName("stduentID")[0].value == "" && choose){
//        alert("尚未輸入資料");
//        return false;    //return false;程式就不會往下執行，防呆用
//    }else if(isNaN(document.getElementsByName("stduentID")[0].value)){
//        alert("學號格式錯誤");
//        return false;    //return false;程式就不會往下執行，防呆用
//    }else if(document.getElementsByName("stduentID")[0].value == ""){
//        alert("學號尚未填入");
//        return false;    //return false;程式就不會往下執行，防呆用
//    }else if(choose){
//        alert("尚未選擇理由");
//        return false;    //return false;程式就不會往下執行，防呆用
//    }
//}
</script>