<div class="sidebar" data-color="<?= $color ?>" data-image="assets/img/sidebar-5.jpg">
    <!--
        Tip 1: you can change the color of the sidebar using: data-color="blue | azure | green | orange | red | purple"
        Tip 2: you can also add an image using data-image tag
    -->

    <div class="sidebar-wrapper">
        <div class="logo">
            <a href="http://www.creative-tim.com" class="simple-text">
                Creative Tim
            </a>
        </div>

        <ul class="nav">
            <li class="active">
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
                <a href=<?= base_url("Admin/course")?>>
                    <i class="pe-7s-note2"></i>
                    <p>編輯課程時間</p>
                </a>
            </li>
            <li>
                <a href="typography.html">
                    <i class="pe-7s-news-paper"></i>
                    <p>Typography</p>
                </a>
            </li>
            <li>
                <a href="icons.html">
                    <i class="pe-7s-science"></i>
                    <p>Icons</p>
                </a>
            </li>
            <li>
                <a href="notifications.html">
                    <i class="pe-7s-bell"></i>
                    <p>Notifications</p>
                </a>
            </li>
        </ul>
    </div>
</div>

<div class="main-panel">
    <nav class="navbar navbar-default navbar-fixed">
        <div class="container-fluid">
            
            <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                    <li>
                        <?php
                            if($this->session->has_userdata('name')):
                                echo "<li class='dropdown'>
                                    <a href='#' class='dropdown-toggle' data-toggle='dropdown'>
                                        {$this->session->name}
                                        <b class='caret'></b>
                                    </a>
                                    <ul class='dropdown-menu'>
                                        <li><a href='".base_url('Auth/logout')."'>登出</a></li>
                                     <!--   <li class='divider'></li>
                                        <li><a href='#'>Separated link</a></li>-->
                                    </ul>
                                </li>";
                            else:
                                echo "<li>".anchor("#","登入",['data-toggle'=>'modal','data-target'=>'#loginModal'])."</li>";
                            endif;
                        ?>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

