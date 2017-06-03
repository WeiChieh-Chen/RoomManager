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

function checkColor(obj,st) {
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
	else{
		alertify.confirm("<span style='font-size: 2em'>確定要從這時段<span style='color: red'>開始</span>租借?</span>", function () {
			let id = obj.id.split('_');
			st = new Date(st);
			st.setDate((st.getDate() + parseInt(id[1]) - 1 ) );

			form.date = st.getUTCFullYear() + format(st.getMonth()+1)+ format(st.getDate()); //date

			// document.getElementById("form_date").value = form.date;
			document.getElementById(room_id).click();                           //room_id
			document.getElementById("start_" + (parseInt(id[0])+1)).click();    //start_sec
			document.getElementById(parseInt(id[0])+1).click();                 //end_sec
			document.getElementById("shortBtn").click();                        //show modal
		},function () { });

	}
}

function format(num) {
	return num < 10? "-0" + num :"-" + num;
}


function sectionControl(number,start,end) {
	return sec[number]+"<br>"+start+"~"+end;
}

function init(statue,i,j) {
	return statue === "0"?
		"<td id='"+i+"_"+j+"' style='color: white;font-size: 0' >0</td>":
		"<td id='"+i+"_"+j+"' style='color: orange;font-size: 0' bgcolor='orange' >1</td>";
}
