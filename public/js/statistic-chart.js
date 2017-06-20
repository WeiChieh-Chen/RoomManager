// var scrolls = 0;
var i = 0;
var j = 0;
var data = [
    [0, borrow_count[0]],
    [1, borrow_count[1]],
    [2, borrow_count[2]],
    [3, borrow_count[3]],
    [4, borrow_count[4]],
    [5, borrow_count[5]],
    [6, borrow_count[6]],
    [7, borrow_count[7]]
];
var dataset = [{
    label: "借用次數",
    data: data,
    color: "#5482FF"
}];
var ticks = [
    [0, room_id_array[0].substr(4)],
    [1, room_id_array[1].substr(4)],
    [2, room_id_array[2].substr(4)],
    [3, room_id_array[3].substr(4)],
    [4, room_id_array[4].substr(4)],
    [5, room_id_array[5].substr(4)],
    [6, room_id_array[6].substr(4)],
    [7, room_id_array[7].substr(4)]
];

var options = {
    series: {
        bars: {
            show: true
        }
    },
    bars: {
        align: "center",
        barWidth: 0.5
    },
    xaxis: {
        axisLabel: "教室代碼",
        axisLabelUseCanvas: true,
        axisLabelFontSizePixels: 12,
        axisLabelFontFamily: 'Verdana, Arial',
        axisLabelPadding: 10,
        ticks: ticks
    },
    yaxis: {
        axisLabel: "借用次數",
        axisLabelUseCanvas: true,
        axisLabelFontSizePixels: 12,
        axisLabelFontFamily: 'Verdana, Arial',
        axisLabelPadding: 3,
        tickDecimals: 0,
        tickFormatter: function(v, axis) {
            return v + "次";
        }
    },
    legend: {
        noColumns: 0,
        labelBoxBorderColor: "#000000",
        position: "nw"
    },
    grid: {
        hoverable: true,
        borderWidth: 2,
        backgroundColor: {
            colors: ["#ffffff", "#EDF5FF"]
        }
    }
};

var data2 = [
    [0, reasoncount[0]],
    [1, reasoncount[1]],
    [2, reasoncount[2]],
    [3, reasoncount[3]],
    [4, reasoncount[4]],
    [5, reasoncount[5]],
    [6, reasoncount[6]]
];
var dataset2 = [{
    label: "問題發生次數",
    data: data2,
    color: "#5482FF"
}];
var ticks2 = [
    [0, "大門未鎖"],
    [1, "電源未關"],
    [2, "冷氣未關"],
    [3, "風扇未關"],
    [4, "電燈未關"],
    [5, "未維持環境整潔"],
    [6, "設備損壞"]
];

var options2 = {
    series: {
        bars: {
            show: true
        }
    },
    bars: {
        align: "center",
        barWidth: 0.5
    },
    xaxis: {
        axisLabel: "代碼",
        axisLabelUseCanvas: true,
        axisLabelFontSizePixels: 12,
        axisLabelFontFamily: 'Verdana, Arial',
        axisLabelPadding: 10,
        ticks: ticks2
    },
    yaxis: {
        axisLabel: "次數",
        axisLabelUseCanvas: true,
        axisLabelFontSizePixels: 12,
        axisLabelFontFamily: 'Verdana, Arial',
        axisLabelPadding: 3,
        tickDecimals: 0,
        tickFormatter: function(v, axis) {
            return v + "次";
        }
    },
    legend: {
        noColumns: 0,
        labelBoxBorderColor: "#000000",
        position: "nw"
    },
    grid: {
        hoverable: true,
        borderWidth: 2,
        backgroundColor: {
            colors: ["#ffffff", "#EDF5FF"]
        }
    }
};

var data3 = [
    [0, roomBreakcount[0]],
    [1, roomBreakcount[1]],
    [2, roomBreakcount[2]],
    [3, roomBreakcount[3]],
    [4, roomBreakcount[4]],
    [5, roomBreakcount[5]],
    [6, roomBreakcount[6]],
    [7, roomBreakcount[7]]
];
var dataset3 = [{
    label: "教室問題發生次數",
    data: data3,
    color: "#5482FF"
}];
var ticks3 = [
    [0, room_id_array[0].substr(4)],
    [1, room_id_array[1].substr(4)],
    [2, room_id_array[2].substr(4)],
    [3, room_id_array[3].substr(4)],
    [4, room_id_array[4].substr(4)],
    [5, room_id_array[5].substr(4)],
    [6, room_id_array[6].substr(4)],
    [7, room_id_array[7].substr(4)]
];

var options3 = {
    series: {
        bars: {
            show: true
        }
    },
    bars: {
        align: "center",
        barWidth: 0.5
    },
    xaxis: {
        axisLabel: "代碼",
        axisLabelUseCanvas: true,
        axisLabelFontSizePixels: 12,
        axisLabelFontFamily: 'Verdana, Arial',
        axisLabelPadding: 10,
        ticks: ticks3
    },
    yaxis: {
        axisLabel: "次數",
        axisLabelUseCanvas: true,
        axisLabelFontSizePixels: 12,
        axisLabelFontFamily: 'Verdana, Arial',
        axisLabelPadding: 10,
        tickDecimals: 0,
        tickFormatter: function(v, axis) {
            return v + "次";
        }
    },
    legend: {
        noColumns: 0,
        labelBoxBorderColor: "#000000",
        position: "nw"
    },
    grid: {
        hoverable: true,
        borderWidth: 2,
        backgroundColor: {
            colors: ["#ffffff", "#EDF5FF"]
        }
    }
};

var data5 = [
    [0, roomperfectrate[0][0]],
    [1, roomperfectrate[1][0]],
    [2, roomperfectrate[2][0]],
    [3, roomperfectrate[3][0]],
    [4, roomperfectrate[4][0]],
    [5, roomperfectrate[5][0]],
    [6, roomperfectrate[6][0]],
    [7, roomperfectrate[7][0]]
];
var data6 = [
    [0, roomperfectrate[0][1]],
    [1, roomperfectrate[1][1]],
    [2, roomperfectrate[2][1]],
    [3, roomperfectrate[3][1]],
    [4, roomperfectrate[4][1]],
    [5, roomperfectrate[5][1]],
    [6, roomperfectrate[6][1]],
    [7, roomperfectrate[7][1]]
];
var dataset5 = [{
        label: "借用次數(左)",
        data: data5,
        color: "#5482FF"
    },
    {
        label: "問題發生次數(右)",
        data: data6,
        yaxis: 2
    }
];
var ticks5 = [
    [0, room_id_array[0].substr(4)],
    [1, room_id_array[1].substr(4)],
    [2, room_id_array[2].substr(4)],
    [3, room_id_array[3].substr(4)],
    [4, room_id_array[4].substr(4)],
    [5, room_id_array[5].substr(4)],
    [6, room_id_array[6].substr(4)],
    [7, room_id_array[7].substr(4)]
];

var options5 = {
    series: {
        lines: {
            show: true
        },
        points: {
            radius: 3,
            fill: true,
            show: true
        }
    },
    xaxis: {
        axisLabel: "代碼",
        axisLabelUseCanvas: true,
        axisLabelFontSizePixels: 12,
        axisLabelFontFamily: 'Verdana, Arial',
        axisLabelPadding: 10,
        ticks: ticks5
    },
    yaxes: [{
        axisLabel: "Gold Price(USD)",
        axisLabelUseCanvas: true,
        axisLabelFontSizePixels: 12,
        axisLabelFontFamily: 'Verdana, Arial',
        axisLabelPadding: 3,
        tickDecimals: 0,
        tickFormatter: function(v, axis) {
            return v + "次";
        }
    }, {
        position: "right",
        axisLabel: "Change(%)",
        axisLabelUseCanvas: true,
        axisLabelFontSizePixels: 12,
        axisLabelFontFamily: 'Verdana, Arial',
        axisLabelPadding: 3,
        tickDecimals: 0,
        tickFormatter: function(v, axis) {
            return v + "次";
        }
    }],
    legend: {
        noColumns: 0,
        labelBoxBorderColor: "#000000",
        position: "nw"
    },
    grid: {
        hoverable: true,
        borderWidth: 2,
        borderColor: "#633200",
        backgroundColor: { colors: ["#ffffff", "#EDF5FF"] }
    },
    colors: ["#FF0000", "#0022FF"]
};

$(document).ready(function() {
    $.plot($("#flot-placeholder"), dataset, options);
    $.plot($("#flot-placeholder2"), dataset2, options2);
    $.plot($("#flot-placeholder3"), dataset3, options3);
    $.plot($("#flot-placeholder4"), dataset5, options5);
    let data4 = [{
        values: [roomAllbreakcount[0][0], roomAllbreakcount[0][1], roomAllbreakcount[0][2], roomAllbreakcount[0][3], roomAllbreakcount[0][4], roomAllbreakcount[0][5], roomAllbreakcount[0][6]],
        labels: ["大門未鎖", "電源未關", "冷氣未關", "風扇未關", "電燈未關", "未維持環境整潔", "設備損壞"],
        type: 'pie'
    }];
    Plotly.newPlot('plotly-placeholder', data4, null);
    // $("#flot-placeholder").UseTooltip();
    // $("#flot-placeholder2").UseTooltip();
    // $("#flot-placeholder3").UseTooltip();
});

function gd(year, month, day) {
    return new Date(year, month, day).getTime();
}

var previousPoint = null,
    previousLabel = null;

function changeroomup() {
    i++;
    if (i > 7) i = 7;
    $("#yearchange").remove();
    $("#yearchange").remove();
    $("#yearchange").remove();
    $("#plotly-placeholder").remove();
    $('<li id="yearchange"> <button type="button" class="btn btn-link btn-md" onclick="changeroomdown()">&laquo;</button> </li><li id="yearchange"><button type="button" class="btn btn-link btn-md">' + room_id_array[i] + '</button></li><li id="yearchange"> <button type="button" class="btn btn-link btn-md" onclick="changeroomup()">&raquo;</button></li>').appendTo("#year");
    $('<div id="plotly-placeholder" style="width:100%;height:100%;"></div>').appendTo("#plotlypanel");
    let data4 = [{
        values: [roomAllbreakcount[i][0], roomAllbreakcount[i][1], roomAllbreakcount[i][2], roomAllbreakcount[i][3], roomAllbreakcount[i][4], roomAllbreakcount[i][5], roomAllbreakcount[i][6]],
        labels: ["大門未鎖", "電源未關", "冷氣未關", "風扇未關", "電燈未關", "未維持環境整潔", "設備損壞"],
        type: 'pie'
    }];
    Plotly.newPlot('plotly-placeholder', data4,null);
}

function changeroomdown() {
    i--;
    if (i < 0) i = 0;
    $("#yearchange").remove();
    $("#yearchange").remove();
    $("#yearchange").remove();
    $("#plotly-placeholder").remove();
    $('<li id="yearchange"> <button type="button" class="btn btn-link btn-md" onclick="changeroomdown()">&laquo;</button> </li><li id="yearchange"><button type="button" class="btn btn-link btn-md">' + room_id_array[i] + '</button></li><li id="yearchange"> <button type="button" class="btn btn-link btn-md" onclick="changeroomup()">&raquo;</button></li>').appendTo("#year");
    $('<div id="plotly-placeholder" style="width:100%;height:100%;"></div>').appendTo("#plotlypanel");
    let data4 = [{
        values: [roomAllbreakcount[i][0], roomAllbreakcount[i][1], roomAllbreakcount[i][2], roomAllbreakcount[i][3], roomAllbreakcount[i][4], roomAllbreakcount[i][5], roomAllbreakcount[i][6]],
        labels: ["大門未鎖", "電源未關", "冷氣未關", "風扇未關", "電燈未關", "未維持環境整潔", "設備損壞"],
        type: 'pie'
    }];
    Plotly.newPlot('plotly-placeholder', data4, null);
}

// $.fn.UseTooltip = function() {
//     $(this).bind("plothover", function(event, pos, item) {
//         if (item) {
//             if ((previousLabel != item.series.label) || (previousPoint != item.dataIndex)) {
//                 previousPoint = item.dataIndex;
//                 previousLabel = item.series.label;
//                 $("#tooltip").remove();

//                 var x = item.datapoint[0];
//                 var y = item.datapoint[1];

//                 var color = item.series.color;

//                 showTooltip(item.pageX - 160,
//                     item.pageY,
//                     color,
//                     "<strong>" + y + "</strong> 次");
//             }
//         } else {
//             $("#tooltip").remove();
//             previousPoint = null;
//         }
//     });
// };

// function showTooltip(x, y, color, contents) {
//     $('<div id="tooltip">' + contents + '</div>').css({
//         position: 'absolute',
//         display: 'none',
//         top: y - 30 + scrolls,
//         left: x - 120,
//         border: '2px solid ' + color,
//         padding: '3px',
//         'font-size': '9px',
//         'border-radius': '5px',
//         'background-color': '#fff',
//         'font-family': 'Verdana, Arial, Helvetica, Tahoma, sans-serif',
//         opacity: 0.9
//     }).appendTo(".row").fadeIn(200);
//     console.log(scrolls);
// }