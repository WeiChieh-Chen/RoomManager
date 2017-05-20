<footer class="footer">
    <div class="container-fluid">
        <nav class="pull-left">
            <ul>
                <li>
                    <a href="#">
                        Home
                    </a>
                </li>
                <li>
                    <a href="#">
                        Company
                    </a>
                </li>
                <li>
                    <a href="#">
                        Portfolio
                    </a>
                </li>
                <li>
                    <a href="#">
                        Blog
                    </a>
                </li>
            </ul>
        </nav>
        <p class="copyright pull-right">
            Viewport by &copy; 2016 <a href="http://www.creative-tim.com">Creative Tim</a>, made with love for a better web
        </p>
    </div>
</footer>
</div> <!--main-panel -->


<div class="modal fade" tabindex="-1" role="dialog" id="loginModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="Auth/login" method="post" accept-charset="utf-8">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">管理者登入</h4>
            </div>
            <div class="modal-body">
                    <div class="form-group">
                        <?= form_label("帳號","account",['class' => 'control-label'])?>
                        <?= form_input(['id'=> 'account' ,'class' => 'form-control', 'type'=>'text','placeholder'=> 'Account','name'=>'account'])?>
                    </div>
                    <div class="form-group">
                        <?= form_label("密碼","password",['class' => 'control-label'])?>
                        <?= form_input(['v-model'=> 'pwd' ,'class' => 'form-control', 'type'=>'password','placeholder'=> 'Password','name'=>'password'])?>
                    </div>
                    <div class="form-group">
                        <?= form_label("確認密碼","password_confirmation",['class' => 'control-label'])?>
                        <?= form_input(['v-model'=> 'repwd' ,'class' => 'form-control', 'type'=>'password','placeholder'=> 'Repeat Password','name'=>'password_confirmation'])?>
                    </div>
            </div>
            <div class="modal-footer">
                <?= form_button(null,'關閉',['class' => 'btn btn-default','data-dismiss'=>'modal'])?>
                <button type="submit" class="btn" :class="[isEqual?'btn-primary':'btn-danger']" :disabled="!isEqual">{{text}}</button>
            </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

</div> <!--wrapper -->
</body>
<!--   Core JS Files   -->
<script src="<?= base_url('public/js/jquery-3.1.1.min.js')?>" type="text/javascript"></script>
<script src="<?= base_url('public/js/bootstrap.min.js')?>" type="text/javascript"></script>

<!--  Checkbox, Radio & Switch Plugins -->
<script src="<?= base_url('public/js/bootstrap-checkbox-radio-switch.js')?>" type="text/javascript"></script>

<!--  Notifications Plugin    -->
<script src="<?= base_url('public/js/bootstrap-notify.js')?>"></script>

<!-- Light Bootstrap Table Core javascript and methods for Demo purpose -->
<script src="<?= base_url('public/js/light-bootstrap-dashboard.js')?>"></script>

<!-- vue.js -->
<script src="<?= base_url('public/js/vue.js')?>"></script>
<script src="<?= base_url('public/js/myvue.js')?>"></script>
<!-- Other JS-->
<script src="<?= base_url('public/js/semantic.min.js')?>"></script>
<script src="<?= base_url('public/js/dataTables.min.js')?>"></script>
<script src="<?= base_url('public/js/dataTables.semanticui.min.js')?>"></script>
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

<script type="text/javascript">

    $(document).ready(function () {
        // Very very important, it could resolve conflict of modal of bootstrap and semantic.
        $.fn.bsModal = $.fn.modal.noConflict();
        $('#loginModal').modal({
            show: false,
            backdrop: false
        });
    });

    // Login Response
    var login_state = "<?= $this->session->flashdata("LoginState")?>";
    if(login_state === "SUCCESS"){
        $.notify({
            icon: 'pe-7s-user',
            message: "歡迎 <b><?=$this->session->name?></b> 登入教室租借系統！"
        }, {
            type: 'success',
            timer: 1000
        });
    }else if(login_state === "NOPE"){
        $.notify({
            icon: 'pe-7s-shield',
            message: "登入失敗：帳密錯誤！"
        }, {
            type: 'danger',
            timer: 1000
        });
    }

    // room_status.php
    $('#showRoom').DataTable({
        "sPaginationType": "full_numbers",
        "oLanguage": {
            "sLengthMenu": "每頁 _MENU_ 筆資料",
            "sZeroRecords": "抱歉， 没有找到",
            "sInfo": "從 _START_ 到 _END_ /共 _TOTAL_ 筆資料",
            "sInfoEmpty": "沒有資料",
            "sInfoFiltered": "(從 _MAX_ 筆資料中搜尋)",
            "sZeroRecords": "沒有找到",
            "sSearch": "搜尋:",
            "oPaginate": {
                "sFirst": "首頁",
                "sPrevious": "上一頁",
                "sNext": "下一页",
                "sLast": "尾頁"
            }
        }
    });
    $("#showRoom .select_col").hide();
    // end of room_status.php
</script>
</html>
