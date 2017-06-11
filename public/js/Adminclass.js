/**
 * Created by User on 2017/6/11.
 */
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
	console.log(data);
	//set status of day from section
	Object.values(data['class_data']).map(function (obj) {
		now = new Date(obj.date);
		day = now.getDay();
		if(day !== 0){
			for(let i = parseInt(obj.start)-1; i < parseInt(obj.end) ; i++){
				week[day] = week[day].replaceAt(i,"1");
			}
		}else{
			for(let i = parseInt(obj.start)-1; i < parseInt(obj.end) ; i++){
				week[7] = week[7].replaceAt(i,"1");
			}
		}
	});

	// set table title
	period = data["period"];
	let list =  "<tr><th colspan='8' style='text-align: center;font-size: 16px;color: black'>"+
		room_id+
		"(<span style='color: orange'>橘色</span>代表已借出，<span style='color: #00E3E3'>青藍色</span>代表申請時段)</th></tr>" +
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
			list += init(week[j].charAt(i),i,j);
		}
	});
	if(!isdelegate){
		isdelegate = true;
	}else{
		$("#roomTable").undelegate("td", "click");
	}
	$("#roomTable").delegate("td", "click", function () {
		changeColor(this);
	});
	table.innerHTML = list;
}

function changeColor(obj) {
	if(obj.innerText === "2"){
		$.notify({
			icon: 'pe-7s-shield',
			message: "該時段無法借用"
		}, {
			type: 'warning',
			timer: 500
		});
	}else if(obj.innerText === "0"){
		obj.bgColor = "#00E3E3";
		obj.innerText = "1";
	}else if(obj.innerText === "1"){
		obj.bgColor = "white";
		obj.innerText = "0";
	}
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
