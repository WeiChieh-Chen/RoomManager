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
			        <!--<label >選擇教室</label>-->
			        
					<form action="<?=base_url('Admin/uploadClass');?>" method="post" accept-charset="utf-8" enctype='multipart/form-data' accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" >
						<label>匯入課表</label>
						<input type="file" id="upload" name="upload" >
						<button type="submit" class="btn btn-success btn-lg" >儲存</button>
					</form>

		        </div>
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
