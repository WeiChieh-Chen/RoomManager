/**
 * Created by Cforce on 2017/05/21.
 */
localStorage.setItem("edit","false");
let editBtn = document.getElementById("editBtn");
let fnBtn = $(".fnBtn");
let dataTable;
$(document).ready(function(){
    // dataTable 文字設定
    dataTable = $('#showRoom').dataTable({
        "sPaginationType": "full_numbers",
        "oLanguage": {
            "sLengthMenu": "每頁 _MENU_ 筆資料",
            "sZeroRecords": "抱歉， 没有找到",
            "sInfo": "從 _START_ 到 _END_ /共 _TOTAL_ 筆資料",
            "sInfoEmpty": "沒有資料",
            "sInfoFiltered": "(從 _MAX_ 筆資料中搜尋)",
            "sSearch": "搜尋:",
            "oPaginate": {
                "sFirst": "首頁",
                "sPrevious": "上一頁",
                "sNext": "下一頁",
                "sLast": "尾頁"
            }
        },
        "autoWidth": false,
    });

    $("#showRoom .select_col").hide();

    $('.actBtn').change(function(){
        let id = $(this).closest('tr').attr('id');
        newInfo[id]['info']['active'] = (newInfo[id]['info']['active'] === "1")?'0':'1';
        if(newInfo[id]['info']['active'] !== oldInfo[id]['info']['active']){
            newInfo[id]['status'] = "UPDATE";
        } else newInfo[id]['status'] = "NORMAL";
    });
});
// 教室資料列 「移除」功能處理
function select(id){
    var domOfChild = document.getElementById(id).childNodes;
    if(domOfChild[0].innerHTML.length === 0){
        domOfChild[0].innerHTML = "<i class='red remove icon'></i>";

        // 如果是一個未上傳至資料庫的新列，則移除時直接將該列刪去。
        if(newInfo[id]['status'] === "INSERT"){
            delete newInfo[id];
            $('#'+id).remove();
        }else{
            newInfo[id]['status']=  "DELETE";
        }

    } else {
        domOfChild[0].innerHTML = "";
        newInfo[id]['status'] = "NORMAL";
    }
}

// 切換「變更、新增、取消」按紐組
function showExcolum(){
    localStorage.setItem("edit","true");
    // Let button and column of disabled to enable.
    $(".select_col").show();
    $(".select_col_reverse").hide();
    $("input[type='checkbox']").bootstrapToggle('enable');
    // Change button of edit
    editBtn.hidden = true;
    fnBtn.show();
}

// 靜態頁面復原
function recover(){
    localStorage.setItem("edit","false");
    // Let button and column of disabled to enable.
    $(".select_col").hide();
    $(".select_col_reverse").show();
    $("input[type='checkbox']").bootstrapToggle('disable');
    // Change button of edit
    editBtn.hidden = false;
    fnBtn.hide();

    Object.keys(newInfo).forEach(function(id){
        if(newInfo[id]['status'] === "INSERT"){ // 新增狀態的列，則不存在
            delete newInfo[id];
            $('#'+id).remove();
        }else if(newInfo[id]['status'] === "DELETE") { // 移除狀態的列，變為正常
            document.getElementById(id).firstChild.innerHTML = "";
            newInfo[id]["status"] = "NORMAL";
        }else if(newInfo[id]['status'] === "UPDATE"){ // 更新狀態的列，恢複原來的資料
            document.getElementById(id).childNodes[2].childNodes[1].firstChild.value = oldInfo[id]['info']['room_name'];
            changeName(id,oldInfo[id]['info']['room_name']);
        }
    });
}

function changeName(id,context) {
    // If the row of new was "DELETE" or "INSERT",representing it is not old data.
    if(newInfo[id]['status'] !== "DELETE" && newInfo[id]['status'] !== "INSERT"){
        if(context !== oldInfo[id]['info']['room_name']){
            newInfo[id]['status'] = "UPDATE";
        }else {
            newInfo[id]['status'] = "NORMAL";
        }
    }

    if(newInfo[id]['status'] === "DELETE"){
        select(id);
        newInfo[id]['status'] = "UPDATE";
    }
    newInfo[id]['info']['room_name'] = context;
}

