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
	let table = document.getElementById("roomTable");
	let week = {
		1:"110011100111000",
		2:"110111011111000",
		3:"000011100100110",
		4:"110010110100000",
		5:"110011100011000",
		6:"111100000110000",
		7:"000001100000000"
	};

	if(drop.find(":selected").val() === "0")
	{
		$("#buttonDiv").attr("hidden",true);
		table.innerHTML = "";
		edited = 0;
		return;
	}

	$("#buttonDiv").attr("hidden",false);
	let list ="<tr><td colspan='8' style='text-align: center;font-size: 16px'>"+
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
	// alert($("#selectRoom").find(":selected").text());
	// Object.values(week).filter(function (val,index) {
	//
	// });

	for(let i = 0;i < 15 ; i++)
	{
		list += "<tr>" +
			"<th bgcolor='#2ea879'>"+
			sectionControl(i)+
			"</th>";
		for(let j = 1 ; j < 8 ; j++){
			list += init(week[j].charAt(i),i,j);
		}
		list +="</tr>";
	}

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

function sectionControl(number) {
	switch (number){
		case 0:
			return "第一節<br>08:10~09:00";
			break;
		case 1:
			return "第二節<br>09:10~10:00";
			break;
		case 2:
			return "第三節<br>10:10~11:00";
			break;
		case 3:
			return "第四節<br>11:10~12:00";
			break;
		case 4:
			return "中午午休<br>12:00~13:20";
			break;
		case 5:
			return "第五節<br>13:20~14:10";
			break;
		case 6:
			return "第六節<br>14:20~15:10";
			break;
		case 7:
			return "第七節<br>15:20~16:10";
			break;
		case 8:
			return "第八節<br>16:20~17:10";
			break;
		case 9:
			return "第九節<br>17:20~18:10";
			break;
		case 10:
			return "第十節<br>18:30~19:20";
			break;
		case 11:
			return "第十一節<br>19:20~20:05";
			break;
		case 12:
			return "第十二節<br>20:05~20:55";
			break;
		case 13:
			return "第十三節<br>20:55~21:40";
			break;
		case 14:
			return "第十四節<br>21:40~22:30";
			break;

	}
}

function init(at,i,j) {
	return at === "0"?
		"<td id='"+i+"_"+j+"' style='color: white;font-size: 0' onclick='changeColor(this)'>0</td>":
		"<td id='"+i+"_"+j+"' style='color: orange;font-size: 0' bgcolor='orange' onclick='changeColor(this)'>1</td>";
}

function save() {
	let data = {
		1:"",
		2:"",
		3:"",
		4:"",
		5:"",
		6:"",
		7:""
	};

	if(confirm("確定要儲存資料?")){
		// alert(document.getElementById("roomTable").rows[2].cells.namedItem("0_1").innerHTML);
		for(let i = 0;i < 15 ; i++)
		{
			for(let j = 1 ; j < 8 ; j++){
				data[j] += document.getElementById("roomTable").rows[2+i].cells.namedItem(i+"_"+j).innerHTML;
			}
		}
	}
	console.log(data);
}

function reset() {
	if(confirm("確定要重置這間教室資料嗎?")){
		edited = 0;
		show();
	}
}