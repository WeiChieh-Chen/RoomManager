// Login
new Vue({
    el : "#loginModal",
    data : {
        pwd : '',
        repwd : '',
        isEqual : true,
        text : '登入'
    },
    watch : {
        repwd : function() {
            this.isEqual = this.pwd === this.repwd;
            this.text = this.isEqual ?'登入':'密碼不相符';
        }
    }
});