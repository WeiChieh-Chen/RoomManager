/**
 * Created by User on 2017/5/20.
 */
// let edited = 0;
// drop = $("#selectRoom");
// function show() {
//
// 	if(edited === 1){
// 		if(confirm("目前教室資料尚未儲存，是否要儲存目前教室資料?")){
// 			save();
// 		}
// 	}
// 	let week = {
// 		1:"000000000000000",
// 		2:"000000000000000",
// 		3:"000000000000000",
// 		4:"000000000000000",
// 		5:"000000000000000",
// 		6:"000000000000000",
// 		7:"000000000000000"
// 	};
//
// 	let table = document.getElementById("roomTable");
//
// 	if(drop.find(":selected").val() === "0")
// 	{
// 		$("#buttonDiv").attr("hidden",true);
// 		table.innerHTML = "";
// 		edited = 0;
// 		return;
// 	}
//
// 	room = section.filter(function (arr) {
// 		return arr.room_id === drop.find(":selected").val();
// 	});
// 	Object.values(room).filter(function (data) {
// 		week[data['week']] = data['class'];
// 	});
//
// 	$("#buttonDiv").attr("hidden",false);
//
// 	let list =  "<tr><td colspan='8' style='text-align: center;font-size: 16px'>"+
// 				drop.find(":selected").text()+
// 				"(橘色代表已借出)</td></tr>" +
// 				"<tr>"+
// 				"<th bgcolor='#666'>節  \\  星期</th>"+
// 				"<th bgcolor='#2ea879'>星期一</th>"+
// 				"<th bgcolor='#2ea879'>星期二</th>"+
// 				"<th bgcolor='#2ea879'>星期三</th>"+
// 				"<th bgcolor='#2ea879'>星期四</th>"+
// 				"<th bgcolor='#2ea879'>星期五</th>"+
// 				"<th bgcolor='#2ea879'>星期六</th>"+
// 				"<th bgcolor='#2ea879'>星期日</th>"+
// 				"</tr>";
//
// 	Object.values(period).map(function (times,i) {
// 		list += "<tr>" +
// 			"<th bgcolor='#2ea879'>"+
// 			sectionControl(i,times['start'],times['end'])+
// 			"</th>";
// 		for(let j = 1 ; j < 8 ; j++){
// 			list += init(week[j].charAt(i),i,j);
// 		}
// 	});
// 	$("#roomTable").delegate("td", "click", function () {
// 		changeColor(this);
// 	});
// 	table.innerHTML = list;
// }

function checkColor(obj) {
	alertify.defaults.glossary.title = "租借申請時段";
	alertify.defaults.glossary.ok = "確定";
	alertify.defaults.glossary.cancel = "取消";
	edited = 1;
	if(obj.bgColor === "orange"){
		$.notify({
			icon: 'pe-7s-shield',
			message: "該時段已被使用!"
		}, {
			type: 'warning',
			timer: 100
		});
	}
	// else if(obj.style.color === "red"){
	// 	alertify.confirm("<span style='font-size: 2em'>是否取消開始的時段</span>", function () {
	// 		// obj.bgColor = "#00FFF2";
	// 		obj.innerHTML = "";
	// 		obj.style.fontSize = "2.5em";
	// 		obj.style.color = 'white';
	//
	// 	},function () { });
	// }
	else{
		alertify.confirm("<span style='font-size: 2em'>確定要從這時段<span style='color: red'>開始</span>租借?</span>", function () {
			obj.bgColor = "#00FFF2";
			obj.innerHTML = "<span class='glyphicon glyphicon-arrow-down''></span>";
			obj.style.fontSize = "2.5em";
			obj.style.color = 'red';
			// $("#shortApp").modal("show");
		},function () { });

	}
}

function sectionControl(number,start,end) {
	let str = ["","第一節","第二節","第三節","第四節","中午午休","第五節","第六節","第七節","第八節","第九節"
		,"第十節","第十一節","第十二節","第十三節","第十四節"];
	return str[number]+"<br>"+start+"~"+end;
}

function init(at,i,j) {
	return at === "0"?
		"<td id='"+i+"_"+j+"' style='color: white;font-size: 0' >0</td>":
		"<td id='"+i+"_"+j+"' style='color: orange;font-size: 0' bgcolor='orange' >1</td>";
}

// function save() {
// 	let postdata = {
// 		"data" :{
// 			1:"",
// 			2:"",
// 			3:"",
// 			4:"",
// 			5:"",
// 			6:"",
// 			7:""
// 		}
// 	};
//
// 	if(confirm("確定要儲存資料?")){
// 		// alert(document.getElementById("roomTable").rows[2].cells.namedItem("0_1").innerHTML);
// 		for(let i = 0;i < 15 ; i++)
// 		{
// 			for(let j = 1 ; j < 8 ; j++){
// 				postdata["data"][j] += document.getElementById("roomTable").rows[2+i].cells.namedItem(i+"_"+j).innerHTML;
// 			}
// 		}
// 	}
// 	console.log(postdata["data"]);
// 	$.post("/Auth/saveClassRoom",postdata);
//
// }
//
// function reset() {
// 	if(confirm("確定要重置這間教室資料嗎?")){
// 		edited = 0;
// 		show();
// 	}
// }