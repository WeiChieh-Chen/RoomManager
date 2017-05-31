<link href="<?= base_url('public/css/component.css')?>" rel="stylesheet"/>
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
				"<bs-drop title='教室代號' bs-class='bs-default' model='room_id' :opt-arr=".json_encode($rooms)."></bs-drop>".
			"</div>".
			"<div class='col-xs-1'>".
			"<button type='button' class='btn' :class=[check?'btn-primary':'btn-default'] :disabled=!check @click='search(0)'>查詢</button>".
			"</div>"
			?>
			<div class="col-xs-3 col-xs-push-6">
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
			<div class="col-xs-3">

			</div>
		</div>
		
		<div class="row">
			<div id="calendar" class="container　col-md-5 col-md-push-3">
				<div class="component">
					<table id="roomTable" border="1" >
					</table>
				</div>
			</div>
		</div>
	</div>
	
	<script>
		let room_id = "";
		let today;
		let period ={};
		new Vue({
			el:"#table",
			data: { room_id: "",total:0},
			computed:{
				check: function () {
					if(this.room_id === "" ){
						return false;
					}
					return true;
				}
			},
			methods: {
				search(diff){
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
					application['start'] = today.getUTCFullYear() + "-" + (today.getMonth()+1) + "-" + today.getDate();
					today.setDate((today.getDate() + 6));//set today to Sunday
					application['end'] = today.getUTCFullYear() + "-" + (today.getMonth()+1) + "-" + today.getDate();
					let st = application['start'];
					let end = application['end'];
					$.post("<?=base_url("Home/search")?>",application,function(jsonData){
						show(JSON.parse(jsonData),st,end);
					});
				}
			}
		});
		let table = document.getElementById("roomTable");
		function show(data,st,end) {console.log(data);
			period = data["period"];
			let list =  "<tr><td colspan='8' style='text-align: center;font-size: 16px'>"+
				room_id+
				"(橘色代表已借出)<br>"+st+" ~ "+end+"</td></tr>" +
				"<tr>"+
				"<th bgcolor='#666'>節  \\  星期</th>"+
				"<th bgcolor='#2ea879'>星期一</th>"+
				"<th bgcolor='#2ea879'>星期二</th>"+
				"<th bgcolor='#2ea879'>星期三</th>"+
				"<th bgcolor='#2ea879'>星期四</th>"+
				"<th bgcolor='#2ea879'>星期五</th>"+
				"<th bgcolor='#2ea879'>星期六</th>"+
				"<th bgcolor='#2ea879'>星期日</th>"+
				"</tr>";

			Object.values(period).map(function (times,i) {
		        list += "<tr>" +
		            "<th bgcolor='#2ea879'>"+
		            sectionControl(i,times['start'],times['end'])+
		            "</th>";
//		        for(let j = 1 ; j < 8 ; j++){
//		            list += init(week[j].charAt(i),i,j);
//		        }
		    });
			table.innerHTML = list;
		}
	</script>
	<script src="<?= base_url('public/js/classRoomCourse.js')?>"></script>
