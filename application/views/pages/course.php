<div class="content">
    <div class="container-fluid">
        <div class="row">
<!--            <div class="col-md-4">-->
<!--                <div class="card">-->
<!--                    <div class="header">-->
<!--                        <h4 class="title">Email Statistics</h4>-->
<!--                        <p class="category">Last Campaign Performance</p>-->
<!--                    </div>-->
<!--                    <div class="content">-->
<!--                        <div id="chartPreferences" class="ct-chart ct-perfect-fourth"></div>-->
<!---->
<!--                        <div class="footer">-->
<!--                            <div class="legend">-->
<!--                                <i class="fa fa-circle text-info"></i> Open-->
<!--                                <i class="fa fa-circle text-danger"></i> Bounce-->
<!--                                <i class="fa fa-circle text-warning"></i> Unsubscribe-->
<!--                            </div>-->
<!--                            <hr>-->
<!--                            <div class="stats">-->
<!--                                <i class="fa fa-clock-o"></i> Campaign sent 2 days ago-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!---->


	        <div class="col-md-3">
		        <div class="form-group">
			        <label >選擇教室</label>
			        
			        <select class="form-control" id="selectRoom" name="selectRoom" onchange="show()">
				        <option value="0">選擇教室</option>
				        <?php
				            foreach ($list as $room){
				            	if($room->active === "1")//I have to use type of String with 1,because it isn't integer.
				            	    echo "<option value='". $room->room_id ."'>". $room->room_name ."(". $room->room_id .")</option>";
				            }
				        ?>
			        </select>
		        </div>
	        </div>
	        <div id="buttonDiv" class="col-md-9" hidden>
	        <button type='button' class='btn btn-info btn-lg col-md-2' style='float: left;' onclick="save()">儲存</button>
	        <button type='button' class='btn btn-danger btn-lg col-md-2 col-md-push-1' style='float: left;' onclick="reset()">重置</button>
	        </div>
        </div>
	    <div class="row">
		    <div id="calendar" class="container　col-md-5">
			    <div class="component">
				    <table id="roomTable" border="1" >
				    </table>
			    </div>
		    </div>
	    </div>
</div>
