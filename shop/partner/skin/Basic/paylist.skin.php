<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
?>

<h1><i class="fa fa-calculator"></i> 정산관리</h1>

<div class="row">
	<div class="col-md-6">

		<table class="table bg-white">
		<tbody>
		<tr class="bg-black">
			<th class="text-center">구분</th>
			<th class="text-center">금액(원)</th>
			<th class="text-center">비고</th>
		</tr>
		<tr>
			<td>① 총판매액</td>
			<td class="text-right"><nobr><?php echo number_format($account['sale']);?></nobr></td>
			<td></td>
		</tr>
		<tr>
			<td>② 총수수료</td>
			<td class="text-right"><?php echo number_format($account['commission']);?></td>
			<td></td>
		</tr>
		<tr>
			<td>③ 총포인트</td>
			<td class="text-right"><?php echo number_format($account['point']);?></td>
			<td></td>
		</tr>
		<tr>
			<td><nobr>④ 총인센티브</nobr></td>
			<td class="text-right"><?php echo number_format($account['intensive']);?></td>
			<td></td>
		</tr>
		<tr>
			<td>⑤ 총매출액</td>
			<td class="text-right"><?php echo number_format($account['netsale']);?></td>
			<td>①-②-③+④</td>
		</tr>
		<tr>
			<td>⑥ 총배송비</td>
			<td class="text-right"><?php echo number_format($account['sendcost']);?></td>
			<td></td>
		</tr>
		<tr class="active">
			<td><b>⑦ 총적립액</b></td>
			<td class="text-right"><b><?php echo number_format($account['netgross']);?></b></td>
			<td>⑤+⑥</td>
		</tr>
		<tr>
			<td>⑧ 총지급액</td>
			<td class="text-right"><?php echo number_format($account['payment']);?></td>
			<td>신청금액 기준</td>
		</tr>
		<tr>
			<td>⑨ 지급요청</td>
			<td class="text-right"><?php echo number_format($account['request']);?></td>
			<td>신청금액 기준</td>
		</tr>
		<tr class="success">
			<td><b>⑩ 현재잔액</b></td>
			<td class="text-right"><b><?php echo number_format($account['balance']);?></b></td>
			<td>⑦-⑧-⑨</td>
		</tr>
		<tr>
			<td>⑪ 출금기준</td>
			<td class="text-right"><b><?php echo number_format($account['deposit']);?></b></td>
			<td>이상 잔액</td>
		</tr>
		<tr class="warning">
			<td><b>⑫ 출금가능</b></td>
			<td class="text-right"><b><?php echo number_format($account['possible']);?></b></td>
			<td>⑩-⑪</td>
		</tr>
		</tbody>
		</table>
	</div>
	<div class="col-md-6">

		<table class="table bg-white">
		<tbody>
		<tr class="bg-black">
			<th class="text-center">정산/입금안내</th>
		</tr>
		<tr>
			<td>정산유형 : <?php echo ($partner['pt_company']) ? $partner['pt_company'] : '미등록'; ?></td>
		</tr>
		<tr>
			<td>입금계좌 :
				<?php if($partner['pt_bank_name']) { ?>
					<?php echo $partner['pt_bank_name'];?>
					<?php echo $partner['pt_bank_account'];?>
					<?php echo $partner['pt_bank_holder'];?>
				<?php } else { ?>
					미등록
				<?php } ?>
			</td>
		</tr>
		<tr>
			<td>
			<?php if($partner['pt_type'] == "1") { ?>
				간이과세사업자는 세금계산서 교부 불가로 부가세를 제한 금액만 입금됩니다.
			<?php } else { ?>
				개인 파트너는 부가세를 제한 금액에 대해 원천징수 후 입금됩니다.
			<?php } ?>
			</td>
		</tr>
		</tbody>
		</table>
		<div class="panel panel-primary">
			<div class="panel-heading text-center">
				최대 <strong><?php echo number_format($account['max']);?></strong>원까지 신청할 수 있습니다.
			</div>
			<div class="panel-body">
				<form class="form" role="form" name="frm_amount" action="<?php echo $action_url;?>" onsubmit="return frm_submit(this);" method="post">
				<input type="hidden" name="ap" value="<?php echo $ap;?>">
				<input type="hidden" name="pp_field" value="0">
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label for="pp_means" class="sr-only">출금방법</label>
								<select name="pp_means" id="pp_means" class="form-control input-sm">
									<option value="0">통장입금</option>
									<option value="1"><?php echo AS_MP;?>전환</option>
								</select>
							</div>
						</div>
						<div class="col-sm-6">
							<label for="pp_amount" class="sr-only">출금액</label>
							<div class="form-group input-group input-group-sm">
								<input type="text" name="pp_amount" value="" id="pp_amount" required class="form-control input-sm" placeholder="<?php echo number_format($account['unit']);?>원 단위 양수">
								<span class="input-group-addon">원</span>
							</div>
						</div>
					</div>
					<div class="form-group">
						<textarea name="pp_memo" id="pp_memo" rows="4" class="form-control input-sm" placeholder="메모<?php echo ($pp_limit) ? ' : '.$pp_limit : '';?>"></textarea>
					</div>

					<button type="submit" id="btn_submit" class="btn btn-danger btn-block"><b>출금신청하기</b></button>

				</form>
			    <script>
				function frm_right(str, n){
					if (n <= 0)
					   return "";
					else if (n > String(str).length)
					   return str;
					else {
					   var iLen = String(str).length;
					   return String(str).substring(iLen, iLen - n);
					}
				}

				function frm_submit(f) {
					var pp_possible = "<?php echo $account['possible'];?>";
					var pp_amount = f.pp_amount.value;
					var pp_unit = String(frm_right(pp_amount, <?php echo $account['num'];?>));

					if (pp_possible > 0) {
						;
					} else {
						alert("출금가능한 잔액이 없습니다.");
						f.pp_amount.focus();
						return false;
					}

					if (pp_amount > 0) {
						;
					} else {
						alert("신청금액은 0보다 큰 양수로 입력하셔야 합니다.");
						f.pp_amount.focus();
						return false;
					}

					if (pp_amount > parseInt(pp_possible)) {
						alert("출금가능한 잔액보다 큰 금액을 신청하셨습니다.");
						f.pp_amount.focus();
						return false;
					}

					if(pp_unit == "<?php echo $account['txt'];?>") {
						;
					} else {
						alert("신청금액을 <?php echo number_format($account['unit']);?>원 단위로 입력해 주세요.");
						f.pp_amount.focus();
						return false;
					}

					newWin = window.open("about:blank", "_frm", "width=500,height=600,scrollbars=yes,resizable=yes");

					f.target = "_frm";
					f.submit();

					return false;
				}
				</script>
			</div>
			<div class="panel-footer text-center">
				신청금액은 <b><?php echo number_format($account['unit']);?></b>원 단위로 입력할 수 있습니다.
			</div>
		</div>
	</div>
</div>


<script>
$(function () {
  $('[data-toggle="popover"]').popover()
})
 </script>
