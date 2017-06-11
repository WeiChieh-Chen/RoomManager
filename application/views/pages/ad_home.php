<script>
    var borrow_count = [];
    var room_id_array= [];
    var reasoncount = [];
    var roomBreakcount = [];
    var roomAllbreakcount = [];
    var roomperfectrate = [];
</script>
<?php foreach($reasoncount as $key => $row){ ?>
    <script>
        reasoncount.push("<?php echo $row; ?>");
    </script>
<?php } ?>

<?php foreach($roomBreakcount as $key => $row){ ?>
    <script>
        roomBreakcount.push("<?php echo $row; ?>");
    </script>
<?php } ?>

<?php foreach($roomperfectrate as $key => $row){ ?>
    <script>
        var Oneroomperfectrate = [];
    </script>
    <?php foreach ($row as $key => $value){ ?>
        <script>
            Oneroomperfectrate.push("<?php echo $value; ?>");
        </script>
    <?php } ?>
    <script>
        roomperfectrate.push(Oneroomperfectrate);
    </script>
<?php } ?>

<?php foreach($roomAllbreakcount as $key => $row){ ?>
    <script>
        var roomOnebreakcount = [];
    </script>
    <?php foreach ($row as $key => $value){ ?>
        <script>
            roomOnebreakcount.push("<?php echo $value; ?>");
        </script>
    <?php } ?>
    <script>
        roomAllbreakcount.push(roomOnebreakcount);
    </script>
<?php } ?>
<div id="page-wrapper">
    <br>
    <br>
    <div class="row">
        <nav class = "col-sm-12">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <ul id="year" class="pagination">
                <li id="yearchange">
                    <button type="button" class="btn btn-link btn-md" onclick="changeroomdown()">&laquo;</button>
                </li>

                <li id="yearchange">
                    <button type="button" class="btn btn-link btn-md">BGC0305</button>
                </li>

                <li id="yearchange"> 
                    <button type="button" class="btn btn-link btn-md" onclick="changeroomup()">&raquo;</button>
                </li>
            </ul>
        </nav>
        <div class="col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    各教室各問題發生次數
                </div>
                <div id="plotlypanel" class="panel-body">
                    <div id="plotly-placeholder" style="width:100%;height:100%;"></div>
                </div>
            </div>
            <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;本學期各教室借用次數</label>
            <div style="width:450px;height:300px;text-align:center;margin:10px">
                <div id="flot-placeholder" style="width:100%;height:100%;"></div>
            </div>
            <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;本學期各教室問題發生次數</label>
            <div style="width:450px;height:300px;text-align:center;margin:10px">
                <div id="flot-placeholder3" style="width:100%;height:100%;"></div>
            </div>           
        </div>
            <div class="col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    各教室借用次數紀錄
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">

                <table width="100%" class="table table-striped table-bordered table-hover" id="classroomTables">
                    <thead>
                        <tr>
                            <th>教室代碼</th>
                            <th>教室名稱</th>
                            <th>啟用狀況</th>
                            <th>借用次數</th>        
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($calssroom as $key => $row){ ?>
                        <tr>
                            <td><?php echo $row['room_id']; ?></td>
                            <td><?php echo $row['room_name']; ?></td>      
                            <td><?php 
                                    if($row['active']){
                                        echo "啟用中"; 
                                    }else{
                                        echo "未啟用";
                                    }
                                ?>
                            </td> 
                            <td><?php echo $row['borrow_count']; ?></td>
                            <script>
                                borrow_count.push("<?php echo $row['borrow_count']; ?>");
                                room_id_array.push("<?php echo $row['room_id']; ?>");
                            </script> 
                        </tr>
                    <?php } ?>
                    </tbody>
                    </table>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
            <br>
            <br>
            <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;本學期各問題發生次數</label>
            <div style="width:450px;height:300px;text-align:center;margin:10px">
                <div id="flot-placeholder2" style="width:100%;height:100%;"></div>
            </div>
            <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;本學期各教室完善率</label>
            <div style="width:450px;height:300px;text-align:center;margin:10px">
                <div id="flot-placeholder4" style="width:100%;height:100%;"></div>
            </div>
        </div>
    </div>
    <!-- /.row -->
</div>
<script src="<?= base_url('public/js/statistic-chart.js')?>"></script>