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
		<div class="row">
			<div class="col-xs-1"></div>
			<div class="col-xs-10">
				<p align="right">
					<button id='submitBtn' class='btn btn-lg btn-primary' onclick="formSubmit();">提交</button>
				</p>
				<div class="content table-responsive table-full-width">
					<table class="table table-hover table-striped" id='auditTable'>
						<thead>
							<th style='font-size: 1.2em'>申請代碼</th>
							<th style='font-size: 1.2em'>申請日期</th>
							<th style='font-size: 1.2em'>教室代號</th>
							<th style='font-size: 1.2em'>開始節次</th>
							<th style='font-size: 1.2em'>結束節次</th>
							<th style='font-size: 1.2em'>申請人</th>
							<th style='font-size: 1.2em'>學號</th>
							<th style='font-size: 1.2em'>申請事由</th>
							<th style='font-size: 1.2em'>指導老師</th>
							<th style='font-size: 1.2em'>審核結果</th>
						</thead>
						
						<tbody>
							<?php
								foreach($list as $item) {
									$result = ($item->apply_result);
									$code = ($item->application_id);
									echo 
										"<tr>".
											"<td>{$item->application_id}</td>".
											"<td>{$item->borrow_date}</td>".
											"<td>{$item->room_id}</td>".
											"<td>{$item->borrow_start}</td>".
											"<td>{$item->borrow_end}</td>".
											"<td>{$namelist[$item->student_id]}</td>".
											"<td>{$item->student_id}</td>".
											"<td>{$item->reason}</td>".
											"<td>{$item->teacher}</td>".
									        '<td>'.
											    "<div class='funkyradio'>".
													"<div class='funkyradio-primary'>".									
														"<input type='radio' name={$code} id={$code}_1 value='1'/>".
														"<label for={$code}_1>通過</label>".
													"</div>".
													"<div class='funkyradio-primary'>".									
														"<input type='radio' name={$code} id={$code}_0 value='0'/>".
														"<label for={$code}_0>不通過</label>".
													"</div>".
											    "</div>".
                                                "<input type='hidden' class='form-control' placeholder='(選填)告知借用者理由' id={$code}_2 value=''/>".
										    '</td>'.
									    "</tr>";
								}
							?>
						</tbody>
					</table>
				</div>
			</div>
			<div class="col-xs-1"></div>
		</div>
	</div>
</div>

<script>
	let newInfo = {};

	function formSubmit(){
		$.post("<?=base_url('/Admin/Audit_Sending')?>", newInfo, function (msg) {
//			 console.log(msg);
            location.reload();
        });
	}

	$("#auditTable").delegate('input[type=radio]','click',function(e){
	    let apply_id =  e.target.id.substring(0,e.target.id.indexOf("_"));
	    let hideText =  document.getElementById(apply_id+"_2");
	    if(e.target.value === '0'){
	        hideText.type = "text";
            hideText.onblur = function(){
                newInfo[apply_id]['reason'] = this.value;
            };
        }else {
            hideText.type = "hidden";
        }

		newInfo[apply_id] = {'result' : e.target.value};

	});
</script>