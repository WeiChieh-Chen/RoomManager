<link href="<?= base_url('public/css/component.css')?>" rel="stylesheet"/>
<link href="<?= base_url('public/components/alertify.min.css')?>" rel="stylesheet"/>
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
			"<div class='col-xs-1'>".
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
		String.prototype.replaceAt = function (index, chr) {
			if (index > this.length - 1) return this;
			return this.substr(0, index) + chr + this.substr(index + 1);
		};
		
		let room_id = "";
		let today;
		let period ={};
		
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
				search(diff,obj){
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
		let isdelegate = false;
		let table = document.getElementById("roomTable");
		function show_class(data,st,ed) {
			start = new Date(st);
			end = new Date(ed);

			let week = {
				1:"000000000000000",
				2:"000000000000000",
				3:"000000000000000",
				4:"000000000000000",
				5:"000000000000000",
				6:"000000000000000",
				7:"000000000000000"
			};

			Object.values(data['class_data']).map(function (obj) {
				now = new Date(obj.date);
				day = now.getDay();
				if(day !== 0){
					for(let i = parseInt(obj.start); i <= parseInt(obj.end) ; i++){
						week[day] = week[day].replaceAt(i,"1");
					}
				}else{
					for(let i = parseInt(obj.start); i <= parseInt(obj.end) ; i++){
						week[day] = week[7].replaceAt(i,"1");
					}
				}
			});

			Object.values(data['apply_data']).map(function (obj) {
				now = new Date(obj.borrow_date);
				day = now.getDay();
				if(day !== 0){
					for(let i = parseInt(obj.borrow_start); i <= parseInt(obj.borrow_end) ; i++){
						week[day] = week[day].replaceAt(i,"1");
					}
				}else{
					for(let i = parseInt(obj.borrow_start); i <= parseInt(obj.borrow_end) ; i++){
						week[day] = week[7].replaceAt(i,"1");
					}
				}
			});

			period = data["period"];
			let list =  "<tr><th colspan='8' style='text-align: center;font-size: 16px;color: black'>"+
				room_id+
				"(橘色代表已借出)<br>"+st+" ~ "+ed+"</th></tr>" +
				"<tr>"+
				"<th bgcolor='#666'>節  \\  星期</th>"+
				set_week(st);
			"</tr>";

			Object.values(period).map(function (times,i) {
				list += "<tr>" +
					"<th bgcolor='#2ea879' >"+
					sectionControl(parseInt(times['period_id']),times['start'],times['end'])+
					"</th>";
				for(let j = 1 ; j < 8 ; j++){
					list += init(week[j].charAt(i),i,j);
				}
			});
			if(!isdelegate){
				isdelegate = true;
			}else{
				$("#roomTable").undelegate("td", "click");
			}
			$("#roomTable").delegate("td", "click", function () {
				checkColor(this,st,mode);
			});
			table.innerHTML = list;
		}
		let idArr = [];             //save room_id while mode is 2
		function show_date(data,st) {
			let day = new Date(st);
			console.log(data);
			let classroom = {};
			Object.values(data['classroom']).map(function (room) {
				classroom[room['room_id']] ="000000000000000";
			});
			
			Object.values(data['class_data']).map(function (obj) {
				if(classroom[obj.room_id] !== undefined){
					for(let i = parseInt(obj.start)-1; i < parseInt(obj.end) ; i++){
						classroom[obj.room_id]	 = classroom[obj.room_id].replaceAt(i,"1");
					}
				}
			});

			Object.values(data['apply_data']).map(function (obj) {
				if(classroom[obj.room_id] !== undefined){
					for(let i = parseInt(obj.borrow_start)-1; i < parseInt(obj.borrow_end) ; i++){
						classroom[obj.room_id]	 = classroom[obj.room_id].replaceAt(i,"1");
					}
				}
			});
			console.log(classroom);
			
			period = data["period"];
			let list =  "<tr><th colspan='"+(period.length+2)+
				"' style='text-align: center;font-size: 16px;color: black'>資工系教室使用查詢表(橘色代表已借出)<br></th></tr>" +
				"<tr><td rowspan='"+(period.length+1)+ "'>"+(day.getMonth()+1) +"/" +day.getDate()+"<br>("+zhtwWeek(day.getDay())+")</td>" +
				"<td bgcolor='#666'>節次 \\ 教室</td>";
			
			
			Object.keys(classroom).map(function (key,i) {
				list += "<th bgcolor='#2ea879'>"+key+"</th>";
				idArr[i] = key;
			});
			list  +=	"</tr>";
		
			Object.values(period).map(function (times,i) {
				list += "<tr>" +
					"<th bgcolor='#2ea879' >"+
					sectionControl(parseInt(times['period_id']),times['start'],times['end'])+
					"</th>";
				for(let j = 1 ; j <= idArr.length ; j++){
					list += init(classroom[idArr[j-1]].charAt(i),i,j);
				}
			});

			if(!isdelegate){
				isdelegate = true;
			}else{
				$("#roomTable").undelegate("td", "click");
			}
			$("#roomTable").delegate("td", "click", function () {
				checkColor(this,st,mode);
			});
			table.innerHTML = list;
		}

		function show_both(data,st) {
			let status = "000000000000000";
			
			Object.values(data['class_data']).map(function (obj) {
				for(let i = parseInt(obj.start)-1; i < parseInt(obj.end) ; i++){
					status	 = status.replaceAt(i,"1");
				}
			});
		

			Object.values(data['apply_data']).map(function (obj) {
				for(let i = parseInt(obj.borrow_start)-1; i < parseInt(obj.borrow_end) ; i++){
					status	 = status.replaceAt(i,"1");
				}
			});


			period = data["period"];
			let list =  "<tr><th colspan='2' style='text-align: center;font-size: 16px;color: black'>"+
				"(橘色代表已借出)<br>"+st+"</th></tr>" +
				"<tr>"+
				"<th bgcolor='#666' style='text-align: center'>節  \\  教室</th>"+
				"<th  bgcolor='#2ea879' style='text-align: center'>"+room_id+"</th>"+
				"</tr>";

			Object.values(period).map(function (times,i) {
				list += "<tr>" +
					"<th bgcolor='#2ea879' >"+
					sectionControl(parseInt(times['period_id']),times['start'],times['end'])+
					"</th>";
				list += init(status.charAt(i),i,1);             // id = i_j     period_classroom  || period_week
				
			});
			if(!isdelegate){
				isdelegate = true;
			}else{
				$("#roomTable").undelegate("td", "click");
			}
			$("#roomTable").delegate("td", "click", function () {
				checkColor(this,st,mode);
			});
			table.innerHTML = list;
		}
		
		function set_week(start) {
			let str = "";
			let weekArr =["星期一","星期二","星期三","星期四","星期五","星期六","星期日"];
			day = new Date(start);
			for(let i = 0 ; i < 7 ; i++){
				str += "<th bgcolor='#2ea879'>"+weekArr[i]+"<br>("+day.getUTCFullYear() + "/" + (day.getMonth()+1) + "/" + day.getDate()+")</th>";
				day.setDate((day.getDate() + 1));
			}
			return str;
		}
		function zhtwWeek(day) {
			switch (day){
				case 0:
					return "日";
					break;
				case 1:
					return "一";
					break;
				case 2:
					return "二";
					break;
				case 3:
					return "三";
					break;
				case 4:
					return "四";
					break;
				case 5:
					return "五";
					break;
				case 6:
					return "六";
					break;
			}
		}
	</script>
	<script src="<?= base_url('public/js/classRoomCourse.js')?>"></script>
	<script src="<?= base_url('public/components/alertify.min.js')?>"></script>