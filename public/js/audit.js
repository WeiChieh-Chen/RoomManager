// newInfo announce from audit.php
$(document).ready(function(){
    $("#auditTable").delegate('input[type=radio]','click',function(e){
        let day = e.target.id.substring(0,e.target.id.lastIndexOf("-"));// Y-mm-dd
        let id =  e.target.id.substring(e.target.id.lastIndexOf("-")+1,e.target.id.lastIndexOf("_")); // id
        let apply_id = day+"-"+id; // Y-m-d-id is every button of rule of id for audit.php

        let hideText =  document.getElementById(apply_id+"_2");

        newInfo[day][id].update = '1';

        if(e.target.value === '0'){
            hideText.type = "text";
            hideText.onblur = function(){
                newInfo[day][id].reason = this.value;
            };
        }else {
            hideText.type = "hidden";

            hideText.value = '';
            delete newInfo[day][id].reason;

            let setNode = document.querySelectorAll("[id*='"+day+"']");

            setNode.forEach(function(node){
                let tmpDay = node.id.substring(0,node.id.lastIndexOf("-"));
                let tmpId =  node.id.substring(node.id.lastIndexOf("-")+1,node.id.lastIndexOf("_"));
                if(tmpId === id) return; //continue

                if(timeJudge(newInfo[day][id].start,newInfo[day][id].end,newInfo[day][tmpId].start,newInfo[day][tmpId].end)) return;

                switch (node.value){
                    case '1': // pass
                        // node.disabled = true;
                        break;
                    case '0': // nonpass
                        node.click();
                        newInfo[tmpDay][tmpId].reason = "當日借用的時段中，已有人進行申請。";
                        break;
                    case '': // hide text
                        node.value = "當日借用的時段中，已有人進行申請。";
                        break;
                }
            });
        }
        newInfo[day][id].result = e.target.value;
    });
});


function timeJudge(st,en,tmpSt,tmpEn){
    return st < tmpEn || tmpSt > st && en > tmpEn || tmpSt < en ;
}
