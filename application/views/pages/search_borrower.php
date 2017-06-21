<style type="text/css">
	table {
		font-size: 1.3em;
	}
	
	th{
		text-align: center;
	}
	
	tr {
		text-align: center;
	}
</style>

<div class="cotent">
	<div class="container-fluid">
		<form style='font-size: 1.2em' id="form_search">
			<div class="row">
				<div class="col-xs-4">
					<label class='control-label'>日期</label>
					<input v-model='date' id='form_date'  type='date' class='form-control '/>
				</div>
				<div class="col-xs-4">
					<text-field text='姓名' model='sName' placeholder='完整姓名(最多5個字)'></text-field>
				</div>
				<div class="col-xs-4">
					<text-field text='學號' model='sNumber' placeholder='OOOOOOOO'></text-field>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-4">
					<text-field text='指導老師' model='teacher' placeholder='老師姓名'></text-field>
				</div>
				<div class="col-xs-4">
					<text-field text='電話' model='cellphone' placeholder='手機號碼，找不到人才會聯絡！'></text-field>
				</div>
				<div class="col-xs-4">
					<?=	 "<label class='control-label'>教室代號</label>".
					"<bs-drop title='選擇教室' bs-class='btn-default' model='room_id' :opt-arr=".json_encode($rooms)."></bs-drop>";
					?>
				</div>
				
			</div>
			<div class='col-xs-2 col-xs-push-10'>
				<button type='button' class='btn btn-lg' :class=[!right?'btn-primary':'btn-default'] :disabled=right @click='search'>搜尋</button>
			</div>
			
		</form>
		<table class="table table-hover table-striped" id='auditTable'>
			<thead>
			<th style='font-size: 1.2em'>申請日期</th>
			<th style='font-size: 1.2em'>開始節次</th>
			<th style='font-size: 1.2em'>結束節次</th>
			<th style='font-size: 1.2em'>申請人</th>
			<th style='font-size: 1.2em'>信箱</th>
			<th style='font-size: 1.2em'>電話</th>
			</thead>
		</table>
	</div>
</div>
<script>
	new Vue({
		el: "#form_search",
		data: {date: "",sName:"",sNumber:"",teacher:"",room_id:"",cellphone:""},
		computed: {
			right: function () {
				return Object.values(this.$data).every(function (value) {
					return value === "";
				});
			}
			
		},
		methods: {
			search(){
				let search_data = {
					'sName': this.sName, 'sNumber': this.sNumber,
					'cellphone': this.cellphone,'teacher': this.teacher,
					'room_id': this.room_id,'date':this.date
				};
				$.post("<?=base_url('Admin/borrower_search')?>",search_data,function(msg){
					console.log(msg);
//					location.reload();
				});
			}
		}
	});
</script>

