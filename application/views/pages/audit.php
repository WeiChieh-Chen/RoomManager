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
				<div class="content table-responsive table-full-width">
					<table class="table table-hover table-striped" id='auditTable'>
						<thead>
							<th>申請代碼</th>
							<th>申請日期</th>
							<th>教室代號</th>
							<th>開始時間</th>
							<th>結束時間</th>
							<th>申請人</th>
							<th>學號</th>
							<th>申請事由</th>
							<th>指導老師</th>
							<th>審核結果</th>
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
											"<td>{$item->teacher}</td>";
										
										echo '<td>';
											
											echo "<div class='funkyradio'>";
												echo 
													"<div class='funkyradio-primary'>".									
														"<input type='radio' name='".$code."' id=$code,1 value='1'";
															if($result) echo "checked";
												echo		"/>".
														"<label for=$code,1>通過</label>";
													"</div>";

												echo 
													"<div class='funkyradio-primary'>".									
														"<input type='radio' name='".$code."' id=$code,0 value='0'";
															if(!$result) echo "checked";
												echo		"/>".
														"<label for=$code,0>不通過</label>";
													"</div>";
											echo "</div>";
										echo '</td>';
									echo "</tr>";
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

<button id='submitBtn' class='btn btn-lg btn-info' onclick="formSubmit()" style="align-items: left">提交</button>

<script>
	let newInfo = {};

	function formSubmit(){
		$.post("<?=base_url('/Admin/Audit_Sending')?>", newInfo, function () {
			// console.log(msg);
            location.reload();
        });
	}

	$("#auditTable").delegate('input[type=radio]','click',function(e){
		newInfo[e.target.id.substring(0,1)] = e.target.value;
	});
</script>