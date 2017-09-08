Vue.component('TextField', {
    props: {
        'text': {
            type: String,
            required: true
        },
        'model': {
            type: String,
            required: true
        },
        'placeholder': {
            type: String
        },
        'preset': {
            type: String
        }
    },
    template: "<div class='form-group'>" +
    "<label :for=model class='control-label' style='font-size: 1.2em'>{{text}}</label>" +
    "<input type='text' :name=model class='form-control' :value=preset :placeholder=placeholder @input='streamBack' required='required'/>" +
    "</div>",
    methods: {
        streamBack: function (e) {
            this.$parent[this.model] = e.target.value;
        }
    },
    mounted: function () {  // If DOM has value of default then it must be hooked to indicate model.
        if(this.preset !== undefined){
            this.$parent[this.model] = this.preset;
        }
    }
});

Vue.component('PassField', {
    props: {
        'text': {
            type: String,
            required: true
        },
        'model': {
            type: String,
            required: true
        },
        'placeholder': {
            type: String
        }
    },
    template: "<div class='form-group'>" +
    "<label :for=model class='control-label' style='font-size: 1.2em'>{{text}}</label>" +
    "<input type='password'  :name=model class='form-control' :placeholder=placeholder @input='streamBack' />" +
    "</div>",
    methods: {
        streamBack: function (e) {
            this.$parent[this.model] = e.target.value;
        }
    }
});

Vue.component('BsDrop', {
    props: {
        'title': {
            type: String,
            required: true
        },
        'bsClass': {
            type: String,
            required: true
        },
        'model': {
            type: String,
            required: true
        },
        'optArr': {
            type: Array,
            required: true
        }
    },
    data : function(){
      return {
           optText: this.title
      }
    },
	template: "<div class='form-group'><div class='dropdown'>" +
	"<button class='btn dropdown-toggle' :class=bsClass type='button'  data-toggle='dropdown' aria-haspopup='true' aria-expanded='true'>" +
	"{{optText}}&emsp;<span class='caret'></span>" +
	"</button>" +
	"<ul class='dropdown-menu'>" +
	"<li v-for='opt in optArr' @click=changOpt(opt)><a v-if='model === \"start_sec\" ' :id=\"'start_'+opt.value\">{{opt.name}}</a>" +
    "<a v-else :id=opt.value>{{opt.name}}</a></li>"+
	// "<li role='separator' class='divider'></li>" +
	// "<li><a href='#'>Separated link</a></li>" +
	"</ul>" +
	"</div></div>",
    methods:{
        changOpt(opt){
            this.optText =  opt.name.replace(/\(.*\)/g,'');
            this.$parent[this.model] = opt.value;
        }
    }
});
