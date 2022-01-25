<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
?>

<h1>송금 완료</h1>
<div class="table-responsive">
	<table class="table">
	<tbody>
	<tr class="bg-black">
		<th class="text-center" scope="col">번호</th>
		<th class="text-center" scope="col">상태</th>
		<th class="text-center" scope="col">접수번호</th>
		<th class="text-center" scope="col">신청일</th>
		<th class="text-center" scope="col">출금방법</th>
		<th class="text-center" scope="col">정산유형</th>
		<th class="text-center" scope="col">신청금액</th>
		<th class="text-center" scope="col">공급가</th>
		<th class="text-center" scope="col">부가세</th>
		<th class="text-center" scope="col">제세공과</th>
		<th class="text-center" scope="col">실지급액</th>
		<th class="text-center" scope="col">메모</th>
		<th class="text-center" scope="col">비고</th>
	</tr>
	<?php for ($i=0; $i < count($list); $i++) { ?>
		<tr>
			<td class="text-center"><?php echo $list[$i]['pp_num'];?></td>
			<td class="text-center"><?php echo $list[$i]['pp_confirm'];?></td>
			<td class="text-center"><?php echo $list[$i]['pp_no'];?></td>
			<td class="text-center"><?php echo $list[$i]['pp_date'];?></td>
			<td class="text-center"><?php echo $list[$i]['pp_means'];?></td>
			<td class="text-center"><?php echo $list[$i]['pp_company'];?></td>
			<td class="text-right"><?php echo number_format($list[$i]['pp_amount']);?></td>
			<td class="text-right"><?php echo number_format($list[$i]['pp_net']);?></td>
			<td class="text-right"><?php echo number_format($list[$i]['pp_vat']);?></td>
			<td class="text-right"><?php echo number_format($list[$i]['pp_tax']);?></td>
			<td class="text-right"><?php echo number_format($list[$i]['pp_pay']);?></td>
			<td class="text-center">
				<?php if($list[$i]['pp_memo']) { ?>
					<a class="cursor" role="button" data-container="body" data-toggle="popover" data-placement="top" data-html="true" data-content="<span class='font-12'><?php echo $list[$i]['pp_memo'];?></span>">
					  <i class="fa fa-volume-up fa-lg"></i>
					</a>
				<?php } ?>
			</td>
			<td class="text-center">
				<?php if($list[$i]['pp_ans']) { ?>
					<a class="cursor" role="button" data-container="body" data-toggle="popover" data-placement="top" data-html="true" data-content="<span class='font-12'><?php echo $list[$i]['pp_ans'];?></span>">
					  <i class="fa fa-bell fa-lg"></i>
					</a>
				<?php } ?>			
			</td>
		</tr>
	<?php } ?>
	<?php if ($i == 0) { ?>
		<tr><td colspan="13" class="text-center">등록된 자료가 없습니다.</td></tr>
	<?php } ?>
	</tbody>
	</table>
</div>

<script>
$(function () {
  $('[data-toggle="popover"]').popover()
})
 </script>