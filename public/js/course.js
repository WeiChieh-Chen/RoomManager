/**
 * Created by User on 2017/6/11.
 */
String.prototype.replaceAt = function (index, chr) {
	if (index > this.length - 1) return this;
	return this.substr(0, index) + chr + this.substr(index + 1);
};

let room_id = "";
let today;
let period ={};
let isdelegate = false;
let table = document.getElementById("roomTable");
function show_class(data,st,ed) {
	start = new Date(st);
	end = new Date(ed);

	// initial status of day
	let week = {
		1:"000000000000000",
		2:"000000000000000",
		3:"000000000000000",
		4:"000000000000000",
		5:"000000000000000",
		6:"000000000000000",
		7:"000000000000000"
	};
	let reason ={
		1:{},
		2:{},
		3:{},
		4:{},
		5:{},
		6:{},
		7:{},
	}

	//set status of day from section
	Object.values(data['class_data']).map(function (obj) {
		now = new Date(obj.date);
		day = now.getDay();
		if(day !== 0){
			for(let i = parseInt(obj.start)-1; i < parseInt(obj.end) ; i++){
				week[day] = week[day].replaceAt(i,"1");
				reason[day][i] = "課程上課使用";
			}
		}else{
			for(let i = parseInt(obj.start)-1; i < parseInt(obj.end) ; i++){
				week[7] = week[7].replaceAt(i,"1");
				reason[7][i] = "課程上課使用";
			}
		}
	});
	
	// set status of day from application
	Object.values(data['apply_data']).map(function (obj) {
		now = new Date(obj.borrow_date);
		day = now.getDay();
		if(day !== 0){
			for(let i = parseInt(obj.borrow_start)-1; i < parseInt(obj.borrow_end) ; i++){
				week[day] = week[day].replaceAt(i,"1");
				reason[day][i] = obj.reason;
			}
		}else{
			for(let i = parseInt(obj.borrow_start)-1; i < parseInt(obj.borrow_end) ; i++){
				week[7] = week[7].replaceAt(i,"1");
				reason[7][i] = obj.reason;
			}
		}
	});
	
	// set table title
	period = data["period"];
	let list =  "<tr><th colspan='8' style='text-align: center;font-size: 16px;color: black'>"+
		room_id+
		"(橘色代表已借出)<br>"+st+" ~ "+ed+"</th></tr>" +
		"<tr>"+
		"<th bgcolor='#666'>節  \\  星期</th>"+
		set_week(st)+
		"</tr>";

	Object.values(period).map(function (times,i) {
		//set time text
		list += "<tr>" +
			"<th bgcolor='#2ea879' >"+
			sectionControl(parseInt(times['period_id']),times['start'],times['end'])+
			"</th>";
		for(let j = 1 ; j < 8 ; j++){ //set column status			
			list += init(week[j].charAt(i),i,j,reason[j][i]);
		}
		list += "</tr>";
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
	// console.log(data);
	let classroom = {};
	let reason ={}
	Object.values(data['classroom']).map(function (room) {
		classroom[room['room_id']] ="000000000000000";
		reason[room['room_id']] ={};
	});

	Object.values(data['class_data']).map(function (obj) {
		if(classroom[obj.room_id] !== undefined){
			for(let i = parseInt(obj.start)-1; i < parseInt(obj.end) ; i++){
				classroom[obj.room_id]	= classroom[obj.room_id].replaceAt(i,"1");
				reason[obj.room_id][i]	= "課程上課使用";
			}
		}
	});

	Object.values(data['apply_data']).map(function (obj) {
		if(classroom[obj.room_id] !== undefined){
			for(let i = parseInt(obj.borrow_start)-1; i < parseInt(obj.borrow_end) ; i++){
				classroom[obj.room_id]	 = classroom[obj.room_id].replaceAt(i,"1");
				reason[obj.room_id][i]	= obj.reason;
			}
		}
	});
	// console.log(classroom);

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
			list += init(classroom[idArr[j-1]].charAt(i),i,j,reason[idArr[j-1]][i]);
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
	let reason = {};
	Object.values(data['class_data']).map(function (obj) {
		for(let i = parseInt(obj.start)-1; i < parseInt(obj.end) ; i++){
			status	 = status.replaceAt(i,"1");
			reason[i]="課程上課使用";
		}
	});


	Object.values(data['apply_data']).map(function (obj) {
		for(let i = parseInt(obj.borrow_start)-1; i < parseInt(obj.borrow_end) ; i++){
			status	 = status.replaceAt(i,"1");
			reason[i]= obj.reason;
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
		list += init(status.charAt(i),i,1,reason[i]);             // id = i_j     period_classroom  || period_week

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
	let day = new Date(start);
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
