<div class="sidebar" data-color="<?= $color ?>" data-image="assets/img/sidebar-5.jpg">
    <!--
        Tip 1: you can change the color of the sidebar using: data-color="blue | azure | green | orange | red | purple"
        Tip 2: you can also add an image using data-image tag
    -->

    <div class="sidebar-wrapper">
        <div class="logo">
            <?=anchor("/Home","教室借用系統",['class'=>'simple-text'])?>
<!--            <a href="http://www.creative-tim.com" class="simple-text">-->
<!--                Creative Tim-->
<!--            </a>-->
        </div>

        <ul id="navbar" class="nav">
            <li>
                <a href="dashboard.html">
                    <i class="pe-7s-graph"></i>
                    <p>Dashboard</p>
                </a>
            </li>
            <li>
                <a href="user.html">
                    <i class="pe-7s-user"></i>
                    <p>User Profile</p>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="pe-7s-note2"></i>
                    <p>Table List</p>
                </a>
            </li>
            <li>
                <?=anchor("Admin/#","<i class='pe-7s-config'></i><p>教室狀態</p>")?>
            </li>
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
                <a class="navbar-brand" href="#">Dashboard</a>
            </div>
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav navbar-left">
                    <li>
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-dashboard"></i>
                        </a>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-globe"></i>
                            <b class="caret"></b>
                            <span class="notification">5</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Notification 1</a></li>
                            <li><a href="#">Notification 2</a></li>
                            <li><a href="#">Notification 3</a></li>
                            <li><a href="#">Notification 4</a></li>
                            <li><a href="#">Another notification</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="">
                            <i class="fa fa-search"></i>
                        </a>
                    </li>
                </ul>

                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <?php
                            if($this->session->has_userdata('name')):
                                echo "<li class='dropdown'>".
                                    "<a href='#' class='dropdown-toggle' data-toggle='dropdown'>{$this->session->name}<b class='caret'></b></a>".
                                    "<ul class='dropdown-menu'>".
                                        "<li>".anchor('Auth/logout','登出')."</li>".
                                    "</ul>".
                                "</li>";
                            else:
                                echo "<li>".anchor("#","登入",['data-toggle'=>'modal','data-target'=>'#loginModal'])."</li>";
                            endif;
                        ?>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <script>
        $("#navbar li").eq(parseInt(localStorage.getItem("nav_active"))).addClass("active");
        $("#navbar").delegate("li", "click", function () {
            $('.active').removeClass();
            localStorage.setItem("nav_active",$(this).index());
        });
    </script>
