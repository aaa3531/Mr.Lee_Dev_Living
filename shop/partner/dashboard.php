<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

//전체알림
$notice = conv_content(trim($apms['apms_notice']), 0);

//개별알림
$message = conv_content(trim($partner['pt_memo']), 0);

// 오늘
$today = date("Y-m-d", G5_SERVER_TIME);
$pre_date = G5_SERVER_TIME - (30 * 86400); // 30일전까지
$preday = date("Y-m-d", $pre_date);

//분류권한
$is_cauth = apms_is_cauth();

// 분류
$category = array();
$category_options  = '';
$sql = " select * from {$g5['g5_shop_category_table']} ";
if (!$is_cauth)
    $sql .= " where pt_use = '1' ";
$sql .= " order by ca_order, ca_id ";
$result = sql_query($sql);
for ($i=0; $row=sql_fetch_array($result); $i++) {
	$c = $row['ca_id'];
	$category[$c] = $row['ca_name'];

	$len = strlen($row['ca_id']) / 2 - 1;
    $nbsp = '';
    for ($i=0; $i<$len; $i++) {
        $nbsp .= '&nbsp;&nbsp;&nbsp;';
    }

	if($row['as_line']) {
		$category_options .= "<option value=\"\">".$nbsp."------------</option>\n";
	}

    $category_options .= '<option value="'.$row['ca_id'].'">'.$nbsp.$row['ca_name'].'</option>'.PHP_EOL;
}

$list3 = array();

$sfl = '';
$where = " and ";
$sql_search = "";
if ($stx != "") {
	$sfl = 'it_name';
    if ($sfl != "") {
        $sql_search .= " $where $sfl like '%$stx%' ";
        $where = " and ";
    }
    if ($save_stx != $stx)
        $page = 1;
}

if ($sca != "") {
    $sql_search .= " $where (a.ca_id like '$sca%' or a.ca_id2 like '$sca%' or a.ca_id3 like '$sca%') ";
}

$sql_common = " from {$g5['g5_shop_item_table']} a ,
                     {$g5['g5_shop_category_table']} b
               where (a.ca_id = b.ca_id";
if ($is_auth) {
	$sql_common .= " and (a.pt_id = '' or a.pt_id = '{$mb_id}')";
} else {
	$sql_common .= " and a.pt_id = '{$mb_id}'";
}
$sql_common .= ") ";
$sql_common .= $sql_search;

// 테이블의 전체 레코드수만 얻음
$sql = " select count(*) as cnt " . $sql_common;
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_'.MOBILE_.'page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql_order = "order by a.pt_show, a.pt_num desc, a.it_id desc";

$sql  = " select *
           $sql_common
           $sql_order
           limit $from_record, $rows ";
$result = sql_query($sql);
for ($i=0; $row=sql_fetch_array($result); $i++) {
	$list3[$i] = $row;
	$list3[$i]['href'] = G5_SHOP_URL.'/item.php?it_id='.$row['it_id'];

	$c1 = $row['ca_id'];
	$c2 = ($row['ca_id2']) ? $row['ca_id2'] : substr($c1,0,4);
	$c3 = ($row['ca_id3']) ? $row['ca_id3'] : substr($c1,0,2);

	$list3[$i]['ca_name1'] = $category[$c1];
	$list3[$i]['ca_name2'] = $category[$c2];
	$list3[$i]['ca_name3'] = $category[$c3];
}

if(IS_SELLER) {
	//오늘 매출
	$row = sql_fetch(" select sum(pt_sale) as sale from {$g5['g5_shop_cart_table']} where ct_status = '완료' and pt_id = '{$member['mb_id']}' and ct_select = '1' and SUBSTRING(pt_datetime,1,10) = '$today' ");
	$today_sales = $row['sale'];

	//오늘 댓글
	$row = sql_fetch(" select count(*) as cnt from {$g5['apms_comment']} where pt_id = '{$member['mb_id']}' and mb_id <> '{$member['mb_id']}' and SUBSTRING(wr_datetime,1,10) = '$today' ");
	$today_comments = $row['cnt'];

	//오늘 문의
	$row = sql_fetch(" select count(*) as cnt from {$g5['g5_shop_item_qa_table']} where pt_id = '{$member['mb_id']}' and mb_id <> '{$member['mb_id']}' and SUBSTRING(iq_time,1,10) = '$today' ");
	$today_questions = $row['cnt'];

	//오늘 후기
	$row = sql_fetch(" select count(*) as cnt from {$g5['g5_shop_item_use_table']} where pt_id = '{$member['mb_id']}' and SUBSTRING(is_time,1,10) = '$today' ");
	$today_reviews = $row['cnt'];

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
}

if(IS_MARKETER) {
	unset($save);

	//오늘 적립
	$row = sql_fetch(" select sum(mk_profit) as profit, sum(mk_benefit) as benefit from {$g5['g5_shop_cart_table']} where ct_status = '완료' and mk_id = '{$member['mb_id']}' and ct_select = '1' and SUBSTRING(pt_datetime,1,10) = '$today' ");
	$today_profit = $row['profit'] + $row['benefit'];

	//매출 추이
	$list2 = array();

	$sql = " select *, SUBSTRING(pt_datetime,1,10) as sale_date from {$g5['g5_shop_cart_table']} where ct_status = '완료' and mk_id = '{$member['mb_id']}' and ct_select = '1' and SUBSTRING(pt_datetime,1,10) between '$preday' and '$today' order by pt_datetime desc ";

	$z = 0;
	$result = sql_query($sql);
	for ($i=0; $row=sql_fetch_array($result); $i++) {

		if ($i == 0) {
			$save['date'] = $row['sale_date'];
		}

		if ($save['date'] != $row['sale_date']) {
			$list2[$z] = $save;
			$z++;
			unset($save);
			$save['date'] = $row['sale_date'];
		}

		// 매출
		$save['count']++;
		$save['profit']    += $row['mk_profit'] + $row['mk_benefit'];
		$save['qty']    += $row['ct_qty'];
	}

	// 오늘 매출
	if($today_profit > 0) {
		$list2[$z]['date'] = $today;
		$list2[$z]['profit'] = $today_profit;
	}
}

// 기업정보
switch($partner['pt_type']) {
	case '1'	: $company_info = ($partner['pt_company_name']) ? $partner['pt_company_name'].' ('.$partner['pt_company_president'].', '.$partner['pt_company_saupja'].')' : '미등록'; break;
	case '2'	: $company_info = '개인 파트너'; break;
	default		: $company_info = '미등록'; break;
}

// 정산방법
switch($partner['pt_flag']) {
	case '1'	: $account_info = '신청금액'; break;
	case '2'	: $account_info = '신청금액 - 부가세'; break;
	case '3'	: $account_info = '신청금액 - 부가세 - 제세공제(원천징수 3.3% 등)'; break;
	case '4'	: $account_info = '기타'; break;
	default		: $account_info = '미등록'; break;
}

// 출금내역 - 최근 5건
$account = array();
$sql  = " select * from {$g5['apms_payment']} where mb_id = '{$member['mb_id']}' order by pp_id desc limit 0, 3";
$result = sql_query($sql);
for ($i=0; $row=sql_fetch_array($result); $i++) {
	$account[$i] = $row;
	$account[$i]['pp_no'] = $row['pp_id'];
	$account[$i]['pp_date'] = date("Y/m/d", strtotime($row['pp_datetime']));

	switch($row['pp_means']) {
		case '1'	: $pp_means = AS_MP.'전환'; break;
		default		: $pp_means = '통장입금'; break;
	}
	$account[$i]['pp_means'] = $pp_means;

	switch($row['pp_confirm']) {
		case '1'	: $pp_confirm = '완료'; break;
		case '2'	: $pp_confirm = '취소'; break;
		default		: $pp_confirm = '신청'; break;
	}

	$account[$i]['pp_confirm'] = $pp_confirm;
}

include_once($skin_path.'/dashboard.skin.php');

?>
