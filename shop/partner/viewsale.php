<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

$today = date("Y-m-d", G5_SERVER_TIME);
$pre_date = G5_SERVER_TIME - (30 * 86400); // 30일전까지
$preday = date("Y-m-d", $pre_date);

//매출 추이
	$list = array();

	$sql = " select *, SUBSTRING(pt_datetime,1,10) as sale_date from {$g5['g5_shop_cart_table']} where ct_status = '완료' and pt_id = '{$member['mb_id']}' and ct_select = '1' and SUBSTRING(pt_datetime,1,10) between '$preday' and '$today' order by pt_datetime desc ";

	$z = 0;
	$result = sql_query($sql);
	for ($i=0; $row=sql_fetch_array($result); $i++) {

		if ($i == 0) {
			$save['date'] = $row['sale_date'];
		}

		if ($save['date'] != $row['sale_date']) {
			$list[$z] = $save;
			$z++;
			unset($save);
			$save['date'] = $row['sale_date'];
		}

		// 매출
		$netsale = $row['pt_sale'] - $row['pt_commission'] - $row['pt_point'] + $row['pt_incentive'];
		$save['count']++;
		$save['sale']    += $row['pt_sale'];
		$save['qty']    += $row['ct_qty'];
		$save['commission']   += $row['pt_commission'];
		$save['point']   += $row['pt_point'];
		$save['incentive']   += $row['pt_incentive'];
		$save['netsale']   += $netsale;
		$save['net']   += $row['pt_net'];
		$save['vat']   += ($netsale - $row['pt_net']);
	}

	// 오늘 매출
	if($today_sales > 0) {
		$list[$z]['date'] = $today;
		$list[$z]['sale'] = $today_sales;
	}


include_once($skin_path.'/viewsale.skin.php');
?>
