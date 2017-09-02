/**
 * Created by User on 2017/5/20.
 */
function checkColor(obj,st,mode) {
	alertify.defaults.glossary.title = "<h2 style='font-size: 2em'>租借申請借用須知</h2>";
	alertify.defaults.glossary.ok = "確定";
	alertify.defaults.glossary.cancel = "取消";
	
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

		alertify.confirm(
			"<span style='font-size: 1.5em;'>借用須知：<br><br></span>"+
			"<span style='font-size: 1.5em'>１. 填寫借用表單之前，請先確認教室是否空堂。<br></span>"+
			"<span style='font-size: 1.5em'>本校教室使用時間表查詢--<a href='http://osa.nfu.edu.tw/query/classroom.php'>連結在這</a><br></span>"+
			"<span style='font-size: 1.5em'>本系教室借用表查詢--<a href='https://goo.gl/mKzhr9'>連結在這<br></a><br></span>"+
			"<span style='font-size: 1.5em'>２. <span style='color: red'>本系師生優先</span>借用，以<span style='color: red'>教學使用</span>為第一優先順序<br><br></span>"+
			"<span style='font-size: 1.5em'>３. <span style='color: red'>平日借用</span>請於 ５個工作天前登記，<span style='color: red'>假日借用</span>請於 ３個工作天前登記，並請自行查詢是否審核通過。核可後請借用人自行於係辦(上班時間)登記借用鑰匙，需抵押有照片的證件。<br><br></span>"+
		"<span style='font-size: 1.5em'>４. 借用空間使用完畢，借用人需負責電器設備電源及門窗關閉、清潔等工作，若發現有未關閉電源或環境髒亂之情況，當學期<span style='color: red'>不得</span>再借用本系教室。<br><br></span>"+
		"<span style='font-size: 1.5em'>５. 系辦保有審核及撤銷使用的權利。<br><br></span>"
			, function () {
			let id = obj.id.split('_');
			console.log(mode);
			if(mode === 0){
				st = new Date(st);
				st.setDate((st.getDate() + parseInt(id[1]) - 1 ) );                             //set next date
				form.date = st.getUTCFullYear() + format(st.getMonth()+1)+ format(st.getDate()); //date
				document.getElementById(room_id).click();                           //room_id
			}else if(mode === 1){
				form.date = st;                                                     //date
				document.getElementById(idArr[parseInt(id[1]) - 1]).click();        //room_id
			}else if(mode === 2){
				form.date = st;                                                     //date
				document.getElementById(room_id).click();                           //room_id
			}
			document.getElementById("start_" + (parseInt(id[0])+1)).click();        //start_sec
			document.getElementById(parseInt(id[0])+1).click();                     //end_sec
			document.getElementById("shortBtn").click();                            //show modal
		},function () { }).set('resizable',true).resizeTo('50%','60%');

	}
}


function format(num) {
	return num < 10? "-0" + num :"-" + num;
}


function sectionControl(number,start,end) {
	return sec[number]+"<br>"+start+"~"+end;
}

function init(statue,i,j,reason) {
	reason = reason !== undefined?reason:"";
	reason = reason.split(',');
	if(statue === '2')return "<td title='申請人："+reason[0]+"&#10;事由："+reason[1]+"' id='"+i+"_"+j+"' style='color: 4F5155;font-size: 0' bgcolor='4F5155' >2</td>";
	return statue === "0"?
		"<td id='"+i+"_"+j+"' style='color: white;font-size: 0' >0</td>":
		"<td title='申請人："+reason[0]+"&#10;事由："+reason[1]+"' id='"+i+"_"+j+"' style='color: orange;font-size: 0' bgcolor='orange' >2</td>";
}
