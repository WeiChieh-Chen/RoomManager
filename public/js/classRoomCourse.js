/**
 * Created by User on 2017/5/20.
 */
let edited = 0;
drop = $("#selectRoom");
function show() {

	if(edited === 1){
		if(confirm("目前教室資料尚未儲存，是否要儲存目前教室資料?")){
			save();
		}
	}
	let week = {
		1:"000000000000000",
		2:"000000000000000",
		3:"000000000000000",
		4:"000000000000000",
		5:"000000000000000",
		6:"000000000000000",
		7:"000000000000000"
	};

	let table = document.getElementById("roomTable");

	if(drop.find(":selected").val() === "0")
	{
		$("#buttonDiv").attr("hidden",true);
		table.innerHTML = "";
		edited = 0;
		return;
	}

	room = section.filter(function (arr) {
		return arr.room_id === drop.find(":selected").val();
	});
	Object.values(room).filter(function (data) {
		week[data['week']] = data['class'];
	});

	$("#buttonDiv").attr("hidden",false);

	let list =  "<tr><td colspan='8' style='text-align: center;font-size: 16px'>"+
				drop.find(":selected").text()+
				"(橘色代表已借出)</td></tr>" +
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
		for(let j = 1 ; j < 8 ; j++){
			list += init(week[j].charAt(i),i,j);
		}
	});
	$("#roomTable").delegate("td", "click", function () {
		changeColor(this);
	});
	table.innerHTML = list;
}

function changeColor(obj) {
	edited = 1;
	if(obj.bgColor === "orange"){
		obj.bgColor = "";
		obj.innerText = "0";
	}else{
		obj.bgColor = "orange";
		obj.innerText = "1";
	}
	// obj.bgColor= obj.bgColor === "orange"?"":"orange";
}

function sectionControl(number,start,end) {
	switch (number){
		case 0:
			return "第一節<br>"+start+"~"+end;
			break;
		case 1:
			return "第二節<br>"+start+"~"+end;
			break;
		case 2:
			return "第三節<br>"+start+"~"+end;
			break;
		case 3:
			return "第四節<br>"+start+"~"+end;
			break;
		case 4:
			return "中午午休<br>"+start+"~"+end;
			break;
		case 5:
			return "第五節<br>"+start+"~"+end;
			break;
		case 6:
			return "第六節<br>"+start+"~"+end;
			break;
		case 7:
			return "第七節<br>"+start+"~"+end;
			break;
		case 8:
			return "第八節<br>"+start+"~"+end;
			break;
		case 9:
			return "第九節<br>"+start+"~"+end;
			break;
		case 10:
			return "第十節<br>"+start+"~"+end;
			break;
		case 11:
			return "第十一節<br>"+start+"~"+end;
			break;
		case 12:
			return "第十二節<br>"+start+"~"+end;
			break;
		case 13:
			return "第十三節<br>"+start+"~"+end;
			break;
		case 14:
			return "第十四節<br>"+start+"~"+end;
			break;
	}
}

function init(at,i,j) {
	return at === "0"?
		"<td id='"+i+"_"+j+"' style='color: white;font-size: 0' >0</td>":
		"<td id='"+i+"_"+j+"' style='color: orange;font-size: 0' bgcolor='orange' >1</td>";
}

function save() {
	let postdata = {
		"data" :{
			1:"",
			2:"",
			3:"",
			4:"",
			5:"",
			6:"",
			7:""
		}
	};

	if(confirm("確定要儲存資料?")){
		// alert(document.getElementById("roomTable").rows[2].cells.namedItem("0_1").innerHTML);
		for(let i = 0;i < 15 ; i++)
		{
			for(let j = 1 ; j < 8 ; j++){
				postdata["data"][j] += document.getElementById("roomTable").rows[2+i].cells.namedItem(i+"_"+j).innerHTML;
			}
		}
	}
	console.log(postdata["data"]);
	$.post("/Auth/saveClassRoom",postdata);

}

function reset() {
	if(confirm("確定要重置這間教室資料嗎?")){
		edited = 0;
		show();
	}
}