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
            <form action="<?=base_url('Auth/login')?>" method="post" accept-charset="utf-8">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">管理者登入</h4>
            </div>
            <div class="modal-body">
                    <text-field text="帳號" model="account" placeholder="Account"></text-field>
                    <pass-field text="密碼" model="pwd" placeholder="Password"></pass-field>
                    <pass-field text="確次密碼" model="repwd" placeholder="Repeat Password"></pass-field>
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
<script src="<?= base_url('public/js/bootstrap.min.js')?>" type="text/javascript"></script>

<!--  Checkbox, Radio & Switch Plugins -->
<script src="<?= base_url('public/js/bootstrap-checkbox-radio-switch.js')?>" type="text/javascript"></script>

<!--  Notifications Plugin    -->
<script src="<?= base_url('public/js/bootstrap-notify.js')?>"></script>

<!-- Light Bootstrap Table Core javascript and methods for Demo purpose -->
<script src="<?= base_url('public/js/light-bootstrap-dashboard.js')?>"></script>

<!-- Other JS-->
<script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/numeric/1.2.6/numeric.min.js"></script>
<script src="<?= base_url('public/js/semantic.min.js')?>"></script>
<script src="<?= base_url('public/components/dataTables.min.js')?>"></script>
<script src="<?= base_url('public/components/dataTables.semanticui.min.js')?>"></script>
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

<script type="text/javascript">

    $(document).ready(function () {
        // Very very important, it could resolve conflict of modal of bootstrap and semantic.
        $.fn.bsModal = $.fn.modal.noConflict();
        $('#loginModal').modal({
            show: false,
            backdrop: false
        });

        $('#blacklistModal').modal({
            show: false,
            backdrop: false
        });

        $('#classroomTables').DataTable();
    });

    // Login Response
    var login_state = "<?= $this->session->flashdata("LoginState")?>";

    if (login_state === "SUCCESS") {
        $.notify({
            icon: 'pe-7s-user',
            message: "歡迎 <b><?=$this->session->name?></b> 登入教室租借系統！"
        }, {
            type: 'success',
            timer: 1000
        });
    } else if (login_state === "NOPE") {
        $.notify({
            icon: 'pe-7s-shield',
            message: "登入失敗：帳密錯誤！"
        }, {
            type: 'danger',
            timer: 1000
        });
    }

    // Login
    new Vue({
        el: "#loginModal",
        data: {pwd: '', repwd: '', text: '登入'},
        computed: {
            isEqual: function () {
                return this.pwd === this.repwd;
            }
        },
        watch: {
            isEqual: function () {
                this.text = this.isEqual ? '登入' : '密碼不相符';
            }
        }
    });

    // // blacklistsubmit
    // new Vue({
    //     el: "#blacklistModal",
    //     data: {stduentID: 'BGC0305',roomID: 'BGC0305', text: '送出'},
    //     computed: {
    //         isEqual: function () {
    //             return this.stduentID === this.roomID;
    //         }
    //     },
    //     watch: {
    //         isEqual: function () {
    //             this.text = this.isEqual ? '送出' : '尚未填寫完畢';
    //         }
    //     }
    // });
</script>
</html>
