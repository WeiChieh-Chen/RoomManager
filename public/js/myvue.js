// Login
new Vue({
    el : "#loginModal",
    data : {
        pwd : '',
        repwd : '',
        text : '登入'
    },
    computed: {
        isEqual : function(){
            return this.pwd === this.repwd;
        }
    },
    watch : {
        isEqual : function() {
            this.text = this.isEqual ?'登入':'密碼不相符';
        }
    },
    components: {
        TextField: {
            props: {
                'text':{
                    type: String,
                    required: true
                },
                'name':{
                    type: String,
                    required: true
                },
                'placeholder':{
                    type: String
                }
            },
            template: "<div class='form-group'>"+
                "<label :for=name class='control-label'>{{text}}</label>"+
                "<input type='text' :name=name class='form-control' :placeholder=placeholder />"+
                "</div>"
        },
        PassField:{
            props: {
                'text': {
                    type: String,
                    required: true
                },
                'model':{
                    type: String,
                    required: true
                },
                'name':{
                    type: String,
                    required: true
                },
                'placeholder':{
                    type: String
                }
            },
            template: "<div class='form-group'>"+
            "<label :for=name class='control-label'>{{text}}</label>"+
            "<input type='password'  :name=name class='form-control' :placeholder=placeholder @input='streamBack' />"+
            "</div>",
            methods: {
                streamBack: function(e){
                    this.$parent[this.model] = e.target.value;
                }
            }
        }
    }
});
