// Login
new Vue({
    el: "#loginModal",
    data: {
        pwd: '',
        repwd: '',
        text: '登入'
    },
    computed: {
        isEqual: function() {
            return this.pwd === this.repwd;
        }
    },
    watch: {
        isEqual: function() {
            this.text = this.isEqual ? '登入' : '密碼不相符';
        }
    }
});