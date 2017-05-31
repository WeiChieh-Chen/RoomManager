<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">&nbsp;&nbsp;黑名單</h1>
        </div>
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
    $options = array(
        'BGC0305'         => 'BGC0305',
        'BGC0316'         => 'BGC0316',
        'BGC0402'         => 'BGC0402',
        'BGC0501'         => 'BGC0501',
        'BGC0508'         => 'BGC0508',
        'BGC0513'         => 'BGC0513',
        'BGC0601'         => 'BGC0601',
        'BGC0614'         => 'BGC0614',   
    );
?>
<div id="blacklistModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
    <form action="http://localhost:8000/Admin/insertBlacklist" method="post" accept-charset="utf-8">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">新增黑名單</h4>
      </div>
      <div class="modal-body">
            <div class="form-group">
                <?= form_label("學號","stduentID",['class' => 'control-label'])?>
                <?= form_input(['id'=> 'stduentID' ,'class' => 'form-control', 'type'=>'text','placeholder'=> 'stduentID','name'=>'stduentID'])?>
            </div>
            <div class="form-group">
                <?= form_label("教室代碼","roomID",['class' => 'control-label'])?>
                <?= form_dropdown('roomID', $options, 'BGC0301')?>
            </div>
            <div class="form-group">
                <?= form_label("原因","reason",['class' => 'control-label'])?>
            </div>
            <div class="form-group">
                <?= form_checkbox(['name'=> 'reason1','value'=> '1','checked'=> false])?>
                <?= form_label("大門未鎖上","reason1",['class' => 'control-label'])?>
                <br>
                <?= form_checkbox(['name'=> 'reason2','value'=> '2','checked'=> false])?>
                <?= form_label("冷氣未關閉","reason2",['class' => 'control-label'])?>
                <br>
                <?= form_checkbox(['name'=> 'reason3','value'=> '3','checked'=> false])?>
                <?= form_label("風扇未關閉","reason3",['class' => 'control-label'])?>
                <br>
                <?= form_checkbox(['name'=> 'reason4','value'=> '4','checked'=> false])?>
                <?= form_label("電燈未關閉","reason4",['class' => 'control-label'])?>
                <br>
                <?= form_checkbox(['name'=> 'reason5','value'=> '5','checked'=> false])?>
                <?= form_label("電源未關閉","reason5",['class' => 'control-label'])?>
                <br>
                <?= form_checkbox(['name'=> 'reason6','value'=> '6','checked'=> false])?>
                <?= form_label("未維持環境整潔","reason6",['class' => 'control-label'])?>
                <br>
                <?= form_checkbox(['name'=> 'reason7','value'=> '7','checked'=> false])?>
                <?= form_label("設備損壞","reason7",['class' => 'control-label'])?>
                <br>   
            </div>
      </div>
      <div class="modal-footer">
        <?= form_button(null,'關閉',['class' => 'btn btn-default','data-dismiss'=>'modal'])?>
                <button type="submit" class="btn btn-primary">送出</button>
      </div>
    </div>

  </div>
</div>

<th  style="display: none;">移除教室</th>