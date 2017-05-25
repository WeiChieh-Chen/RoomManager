<script>
    var borrow_count = [];
    var room_id_array= [];
    var reasoncount = [];
</script>
<?php foreach($reasoncount as $key => $row){ ?>
    <script>
        reasoncount.push("<?php echo $row; ?>");
    </script>
<?php } ?>
<div id="page-wrapper">
    <div class="row">
    <br>
    <br>
        <div class="col-lg-6">
            <div style="width:450px;height:300px;text-align:center;margin:10px">
                <div id="flot-placeholder" style="width:100%;height:100%;"></div>
            </div>
            <div style="width:450px;height:300px;text-align:center;margin:10px">
                <div id="flot-placeholder2" style="width:100%;height:100%;"></div>
            </div>
        </div>
            <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    各教室借用次數紀錄
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">

                <table width="100%" class="table table-striped table-bordered table-hover" id="classroomTables">
                    <thead>
                        <tr>
                            <th>教室代碼</th>
                            <th>教室名稱</th>
                            <th>啟用狀況</th>
                            <th>借用次數</th>        
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($calssroom as $key => $row){ ?>
                        <tr>
                            <td><?php echo $row->room_id; ?></td>
                            <td><?php echo $row->room_name; ?></td>      
                            <td><?php 
                                    if($row->active){
                                        echo "啟用中"; 
                                    }else{
                                        echo "未啟用";
                                    }
                                ?>
                            </td> 
                            <td><?php echo $row->borrow_count; ?></td>
                            <script>
                                borrow_count.push("<?php echo $row->borrow_count; ?>");
                                room_id_array.push("<?php echo $row->room_id; ?>");
                                i++;
                            </script> 
                        </tr>
                    <?php } ?>
                    </tbody>
                    </table>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        
    </div>
    <!-- /.row -->
</div>
<!-- /#page-wrapper -->

<script type="text/javascript">
    //******* 2012 Average Temperature - BAR CHART
    var date = new Date();

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
        label: date.getFullYear()+" 各教室借用次數",
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

    $(document).ready(function() {
        $.plot($("#flot-placeholder"), dataset, options);
        $("#flot-placeholder").UseTooltip();
    });

    function gd(year, month, day) {
        return new Date(year, month, day).getTime();
    }

    var previousPoint = null,
        previousLabel = null;

    $.fn.UseTooltip = function() {
        $(this).bind("plothover", function(event, pos, item) {
            if (item) {
                if ((previousLabel != item.series.label) || (previousPoint != item.dataIndex)) {
                    previousPoint = item.dataIndex;
                    previousLabel = item.series.label;
                    $("#tooltip").remove();

                    var x = item.datapoint[0];
                    var y = item.datapoint[1];

                    var color = item.series.color;

                    //console.log(item.series.xaxis.ticks[x].label);                

                    showTooltip(item.pageX-170,
                        item.pageY-90,
                        color,
                         "<strong>" + y + "</strong> 次");
                }
            } else {
                $("#tooltip").remove();
                previousPoint = null;
            }
        });
    };

    function showTooltip(x, y, color, contents) {
        $('<div id="tooltip">' + contents + '</div>').css({
            position: 'absolute',
            display: 'none',
            top: y - 40,
            left: x - 120,
            border: '2px solid ' + color,
            padding: '3px',
            'font-size': '9px',
            'border-radius': '5px',
            'background-color': '#fff',
            'font-family': 'Verdana, Arial, Helvetica, Tahoma, sans-serif',
            opacity: 0.9
        }).appendTo("#flot-placeholder").fadeIn(200);
    }
</script>

<script type="text/javascript">
    //******* 2012 Average Temperature - BAR CHART
    var date = new Date();

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
        label: date.getFullYear()+" 各教室借用次數",
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

    $(document).ready(function() {
        $.plot($("#flot-placeholder2"), dataset2, options2);
        $("#flot-placeholder2").UseTooltip();
    });

    function gd(year, month, day) {
        return new Date(year, month, day).getTime();
    }

    var previousPoint = null,
        previousLabel = null;

    $.fn.UseTooltip = function() {
        $(this).bind("plothover", function(event, pos, item) {
            if (item) {
                if ((previousLabel != item.series.label) || (previousPoint != item.dataIndex)) {
                    previousPoint = item.dataIndex;
                    previousLabel = item.series.label;
                    $("#tooltip").remove();

                    var x = item.datapoint[0];
                    var y = item.datapoint[1];

                    var color = item.series.color;

                    //console.log(item.series.xaxis.ticks[x].label);                

                    showTooltip2(item.pageX-170,
                        item.pageY-220,
                        color,
                         "<strong>" + y + "</strong> 次");
                }
            } else {
                $("#tooltip").remove();
                previousPoint = null;
            }
        });
    };
    
    function showTooltip2(x, y, color, contents) {
        $('<div id="tooltip">' + contents + '</div>').css({
            position: 'absolute',
            display: 'none',
            top: y - 40,
            left: x - 120,
            border: '2px solid ' + color,
            padding: '3px',
            'font-size': '9px',
            'border-radius': '5px',
            'background-color': '#fff',
            'font-family': 'Verdana, Arial, Helvetica, Tahoma, sans-serif',
            opacity: 0.9
        }).appendTo("#flot-placeholder2").fadeIn(200);
    }
</script>