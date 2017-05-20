/**
 * Created by User on 2017/5/20.
 */
function show() {
	let week = {
		1:"11001110011100",
		2:"11011101111100",
		3:"00001110010011",
		4:"11001011010000",
		5:"11001110001100",
		6:"11110000011000",
		7:"00000110000000"
	};
	let list = "<tr>"+
	"<td>節  \\  星期</td>"+
	"<td>星期一</td>"+
	"<td>星期二</td>"+
	"<td>星期三</td>"+
	"<td>星期四</td>"+
	"<td>星期五</td>"+
	"<td>星期六</td>"+
	"<td>星期日</td>"+
	"</tr>";
	// alert($("#selectRoom").find(":selected").text());
	// Object.values(week).filter(function (val,index) {
	//
	// });第一節<br>08:10~09:00

	for(let i = 0;i < 15 ; i++)
	{
		list += "<tr>" +
			"<td>"+
			sectionControl(i)+
			"</td>"+
			"<td></td>" +
			"<td></td>" +
			"<td></td>" +
			"<td></td>" +
			"<td></td>" +
			"<td></td>" +
			"<td></td>" +
			"</tr>";
		for(let j = 1 ; j < 8 ; j++){
		}
	}
	document.getElementById("roomTable").insertAdjacentHTML("beforeend",list);
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