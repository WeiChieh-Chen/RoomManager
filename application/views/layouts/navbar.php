<div class="sidebar" data-color="<?= $color ?>" data-image="<?=base_url('public/img/'.$image)?>">
    <!--
        Tip 1: you can change the color of the sidebar using: data-color="blue | azure | green | orange | red | purple"
        Tip 2: you can also add an image using data-image tag
    -->

    <div class="sidebar-wrapper">
        <div class="logo">

            <?= anchor($anchor, "教室借用系統", ['class' => 'simple-text']) ?>
            <!--            <a href="http://www.creative-tim.com" class="simple-text">-->
            <!--                Creative Tim-->
            <!--            </a>-->
        </div>

        <ul id="navbar" class="nav">
            <li v-for="(items,key) in list" @click='selected(key)' :class={'active':key===datus}>
                <a :href=items.href>
                    <i :class=items.icon></i>
                    <p>{{items.item}}</p>
                </a>
            </li>
            <?php
            if (!$this->session->has_userdata('name')):
                echo "<li><a id='shortBtn' data-target='#shortApp' data-toggle='modal'><i class='pe-7s-note'></i><p>短期申請</p></a></li>";
            endif;
            ?>
        </ul>
    </div>
</div>

<div class="main-panel">
    <nav class="navbar navbar-default navbar-fixed">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse"
                        data-target="#navigation-example-2">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#"><?= $title ?></a>
            </div>
            <div class="collapse navbar-collapse">
                <?php
                if ($this->session->has_userdata('name')):
                    echo "<ul class='nav navbar-nav navbar-left'>" .
//                        "<li>".
//                        "<a href='#' class='dropdown-toggle' data-toggle='dropdown'>".
//                        "<i class='fa fa-dashboard'></i>".
//                        "</a>".
//                        "</li>".
                        "<li class='dropdown'>".
                        "<a href='#' class='dropdown-toggle' data-toggle='dropdown'>".
                        "<i class='fa fa-envelope-o'></i>".
                        "<b class='caret'></b><span class='notification'>{$this->session->noaudit}</span>".
                        "</a>".
                        "<ul class='dropdown-menu'>".
                        "<li><a href=".base_url('Admin/Audit')." onclick=localStorage.setItem('nav_active','2')>前往審核列表頁面</a></li>".
                        "</ul>".
                        "</li>".
//                        "<li><a href=''><i class='fa fa-search'></i></a></li>".
                        "</ul>";
                endif;
                ?>
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <?php
                        if ($this->session->has_userdata('name')):
                            echo "<li class='dropdown'>" . "<a href='#' class='dropdown-toggle' data-toggle='dropdown'>{$this->session->name}<b class='caret'></b></a>" . "<ul class='dropdown-menu'>" . "<li>" . anchor('Auth/logout', '登出',['onclick'=>"localStorage.setItem('nav_active',0)"]) . "</li>" . "</ul>" . "</li>";
                        else:
                            echo "<li>" . anchor("#", "登入", ['data-toggle' => 'modal', 'data-target' => '#loginModal']) . "</li>";
                        endif;
                        ?>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <script type="text/javascript">
	    let formData = { sName: "", sNumber: "", email: "", cellphone: "", department:"",teacher: "", events: "", room_id: "",date:"",start_sec: "", end_sec: "",send: false};
	    let sec = ["","第一節","第二節","第三節","第四節","中午午休","第五節","第六節","第七節","第八節","第九節"
		    ,"第十節","第十一節","第十二節","第十三節","第十四節"];
        let form;
        $(document).ready(function () {
            new Vue({
                el: "#navbar",
                data: {
                    datus: parseInt(localStorage.getItem("nav_active")),
                    list: <?php
                    if ($this->session->has_userdata('name')):
                        $items = [
                            ["href" => base_url('Admin'), "icon" => "pe-7s-graph", "item" => "教室數據統計"],
                            ["href" => base_url('Admin/showBlacklist'), "icon" => "pe-7s-user", "item" => "黑名單列表"],
                            ["href" => base_url('Admin/Audit'), "icon" => "pe-7s-pen", "item" => "審核列表"],
	                        ["href" => base_url('Admin/search_borrower'), "icon" => "pe-7s-search", "item" => "借用申請單查詢"],
                            ["href" => base_url('Admin/course'), "icon" => "pe-7s-note2", "item" => "長期申請"],
                            ["href" => base_url('Admin/RoomStatus'), "icon" => "pe-7s-config", "item" => "教室狀態"]
                        ];
                    else:
                        $items = [];
                    endif;
                    echo json_encode($items, JSON_UNESCAPED_UNICODE);
                    ?>
                },
                methods: {
                    selected(key){
                        localStorage.setItem("nav_active", key);
                    }
                }
            });
            
            if(document.getElementById("shortApp")){
                form = new Vue({
                    el: "#shortApp",
                    data: formData,
                    computed: {
                        right: function () {
                            if (this.start_sec !== "" && this.end_sec !== "" && parseInt(this.start_sec) > parseInt(this.end_sec)) {
                                $.notify({
                                    icon: 'pe-7s-shield',
                                    message: "結束節次在開始結次前面！"
                                }, {
                                    type: 'danger',
                                    timer: 1000
                                });

                                return false;
                            }

                            return !this.send;
//                            return Object.values(this.$data).every(function (value) {
//                                return value !== "";
//                            }) && !this.send;
                        }
                    },
                    methods: {
                        apply(){
                            this.send = true;
//                            let application = {
//                                'sName': this.sName, 'sNumber': this.sNumber,
//                                'email': this.email, 'cellphone': this.cellphone,
//                                'department':this.department,'teacher': this.teacher,
//                                'events': this.events, 'room_id': this.room_id,
//                                'date':this.date,'start_sec': this.start_sec, 'end_sec': this.end_sec
//                            };

                            $.notify({
                                icon: 'pe-7s-paper-plane',
                                message: "申請單寄送中……<br>請等候管理員審核及回覆！"
                            }, {
                                type: 'success',
                                timer: 1000
                            });

                            $('form').submit();
                        }
                    }
                });
                
            }
        });


        // 讓它在第一次初始時，設為1
        runOnce(function(){
            localStorage.setItem('nav_active',0);
        });

        // 控制只讓函式執行一次
        function runOnce(fn, context) {
            return function () {
                try {
                    fn.apply(context || this, arguments);
                }
                catch (e) {
                    //console.error(e);//一般可以注解掉這一行
                }
                finally {
                    fn = null;
                }
            }
        }
    </script>

    <!-- For application of shortcut -->
    <?php
    if(!$this->session->has_userdata('name')):

     echo
     "<div class='modal fade' tabindex='-1' role='dialog' id='shortApp'>".
         "<form action='".base_url('Home/apply')."' @submit.prevent='apply' method='post' >".
            "<div class='modal-dialog' role='document'>".
                "<div class='modal-content'>".
                    "<div class='modal-header'>".
                        "<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>".
                        "<h2 class='modal-title'>短期借用申請單</h2><br>".
                        "<div class='row'>".
                            "<div class='col-xs-12'>".
                                "<div class='form-group'>".
                                    "<input type='date' id='form_date' name='date' v-model='date' class='form-control' />".
                                "</div>".
                            "</div>".
                        "</div>".
                        "<div class='row' id='dropList'>".
                            "<div class='col-xs-3'>".
                                "<label class='control-label'>教室代號</label>".
                                "<input type='hidden' name='room_id' v-model='room_id'>".
                                "<bs-drop title='選擇教室' bs-class='btn-default' model='room_id' :opt-arr=".json_encode($rooms)."></bs-drop>".
                            "</div>".
                            "<div class='col-xs-4'>".
                                "<label class='control-label'>開始節次</label>".
                                "<input type='hidden' name='start_sec' v-model='start_sec'>".
                                "<bs-drop title='選擇開始節次' bs-class='btn-default' model='start_sec' :opt-arr=".json_encode($periods)."></bs-drop>".
                            "</div>".
                            "<div class='col-xs-4'>".
                                "<label class='control-label'>結束節次</label>".
                                "<input type='hidden' name='end_sec' v-model='end_sec'>".
                                "<bs-drop title='選擇結束節次' bs-class='btn-default' model='end_sec' :opt-arr=".json_encode($periods)."></bs-drop>".
                            "</div>".
                        "</div>".
                    "</div>".
                    "<div class='modal-body'>".
                        "<div class='row'>".
                            "<div class='col-xs-6'>".
                                "<text-field text='姓名' model='sName' placeholder='完整姓名(最多5個字)' regex='[\u4e00-\u9fa5]{1,5}' title='請輸入中文1~5個字' :required='true'></text-field>".
                            "</div>".
                            "<div class='col-xs-6'>".
                                "<text-field text='學號/員工編號' model='sNumber' placeholder='40123456' regex='\w+' title='只能輸入英文或數字' :required='true'></text-field>".
                            "</div>".
                        "</div>".
                        "<div class='row'>".
                            "<div class='col-xs-6'>".
                                "<text-field text='E-Mail' model='email' placeholder='請輸人常用信箱，以取得結果信件！' :required='true'></text-field>".
                            "</div>".
                            "<div class='col-xs-6'>".
                                "<text-field text='電話' model='cellphone' placeholder='手機號碼，找不到人才會聯絡！' :required='true'></text-field>".
                            "</div>".
                        "</div>".
                        "<div class='row'>".
                            "<div class='col-xs-6'>".
                                "<text-field text='科系' model='department' preset='資訊工程系' placeholder='科系' :required='true'></text-field>".
                            "</div>".
                            "<div class='col-xs-6'>".
                                "<text-field text='指導老師' model='teacher' placeholder='老師姓名' :required='true'></text-field>".
                            "</div>".
                        "</div>".
                        "<div class='row'>".
                            "<div class='col-xs-12'>".
                                "<text-field text='借用事由' model='events' placeholder='簡單描述借用原因'></text-field>".
                            "</div>".
                        "</div>".
                    "</div>".
                    "<div class='modal-footer'>".
                        "<button type='submit' class='btn' :class=[right?'btn-primary':'btn-default'] :disabled=!right >送出申請單</button>".
                    "</div>".
                "</div>". //.modal-content
            "</div>".//.modal-dialog
        "</form>".
    "</div>"; //.modal
    endif;
?>
