<link href="<?= base_url('public/css/component.css')?>" rel="stylesheet"/>
<link href="<?= base_url('public/components/alertify.min.css')?>" rel="stylesheet"/>
<style>
    input[type="date"]:hover::-webkit-calendar-picker-indicator {
        color: red;
    }
    input[type="date"]:hover:after {
        content: "選擇日期";
        color: #555;
        padding-right: 5px;
    }
    input[type="date"]::-webkit-inner-spin-button {
        /* display: none; <- Crashes Chrome on hover */
        -webkit-appearance: none;
        margin: 0;
    }
	
	td,li {
		cursor: pointer ;
	}
</style>
<div class="content">
	<div class="container-fluid">
		<div class='row' id="table">
<!--			<div class='col-xs-4'>-->
<!--				<div class='form-group'>-->
<!--					<input v-model='date'  type='date' class='form-control' />-->
<!--				</div>-->
<!--			</div>-->
			<?=
			"<div class='col-xs-2'>".
			"<input v-model='date' id='form_date'  type='date' class='form-control' />".
			"</div>".
			"<div class='col-xs-2'>".
				"<bs-drop title='教室代號' bs-class='bs-default' model='room_id' :opt-arr=".json_encode($rooms)."></bs-drop>".
			"</div>".
			"<div class='col-xs-2'>".
			"<button type='button' class='btn btn-block' :class=[check?'btn-primary':'btn-default'] :disabled=!check @click='search(0)'>查詢</button>".
			"</div>"
			?>
			<div class="col-xs-3 " hidden id="button_list">
				<button type="button" class="btn btn-fill" @click = "search(-7)">
					<i class="long arrow left icon"></i>
				</button>
				<button type="button" class="btn btn-fill" @click = "search(0)">
					<i class="circle icon"></i>
				</button>
				<button type="button" class="btn btn-fill" @click = "search(7)">
					<i class="long arrow right icon"></i>
				</button>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-4 ">
				<div id="calendar" class="container">
					<div class="component">
						<table id="roomTable" border="1">
						</table>
					</div>
				</div>
			</div>
			
		</div>
	</div>
<script>
	new Vue({
		el:"#table",
		data: { room_id: "",total:0,date:"",mode:0},
		computed:{
			check: function () {
				if(this.room_id !== "" && this.date !== ""){
					mode = 2;
					return true;
				}
				else if(this.room_id !== "" || this.date !== ""){
					mode = this.room_id !== "" ? 0 : 1 ;
					return true;
				}
				return false;
			}
		},
		methods: {
			search(diff){
				if(mode === 0)
				{
					$("#button_list").attr("hidden",false);
					$("#button_list").find(":button").attr("disabled",true);
					if(diff === 0) this.total = 0;
					else this.total += diff;
					room_id = this.room_id;
					let application = {
						'room_id': this.room_id,
						'start':"",
						'end':""
					};
					today = new Date();
					if(today.getDay() !== 0){ //set back Monday
						today.setDate((today.getDate() - today.getDay() + 1 + this.total));
					}else{//set to next week Monday
						today.setDate((today.getDate() + 1 + this.total));
					}
					application['start'] = today.getUTCFullYear() + format(today.getMonth()+1) + format(today.getDate());
					today.setDate((today.getDate() + 6));//set today to Sunday
					application['end'] = today.getUTCFullYear() + format(today.getMonth()+1) + format(today.getDate());
					let st = application['start'];
					let end = application['end'];
					$.post("<?=base_url("Home/searchRoom")?>",application,function(jsonData){
						setTimeout(function () {
							$("#button_list").find(":button").attr("disabled",false);
						},1000);
						show_class(JSON.parse(jsonData),st,end);
					});
				}else if(mode === 1){
					room_id = "";
					let application = {
						'start':this.date
					};
					let st = this.date;
					$.post("<?=base_url("Home/searchDate")?>",application,function(jsonData){
						$("#button_list").find(":button").attr("disabled",false);
						show_date(JSON.parse(jsonData),st);
					});
				}else if(mode === 2){
					room_id = this.room_id;
					let application = {
						'room_id': this.room_id,
						'start':this.date
					};
					let st = this.date;
					$.post("<?=base_url("Home/searchBoth")?>",application,function(jsonData){
						$("#button_list").find(":button").attr("disabled",false);
						show_both(JSON.parse(jsonData),st);
					});
				}
			}
		}
	});
</script>
	<script src="<?= base_url('public/js/course.js')?>"></script>
	<script src="<?= base_url('public/js/classRoomCourse.js')?>"></script>
	<script src="<?= base_url('public/components/alertify.min.js')?>"></script>