<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
?>
<link rel="stylesheet" href="<?php echo $skin_url;?>/assets/css/morris.css">
<link rel="stylesheet" href="<?php echo $skin_url;?>/assets/css/morris.css">
<script src="<?php echo $skin_url;?>/assets/js/raphael-min.js"></script>
<script src="<?php echo $skin_url;?>/assets/js/morris.min.js"></script>
<?php 
$ct_it = implode(",", $g5['apms_automation']);

$fr_date = ($fr_date) ? $fr_date : date("Ymd", G5_SERVER_TIME - 15*86400); //보름전
$to_date = ($to_date) ? $to_date : date("Ymd", G5_SERVER_TIME); //오늘

$fr_day = preg_replace("/([0-9]{4})([0-9]{2})([0-9]{2})/", "\\1-\\2-\\3", $fr_date);
$to_day = preg_replace("/([0-9]{4})([0-9]{2})([0-9]{2})/", "\\1-\\2-\\3", $to_date);

$sql1 = " from {$g5['g5_shop_cart_table']} where find_in_set(ct_status, '주문') and find_in_set(pt_it, '{$ct_it}')=0 and pt_id = '{$member['mb_id']}' and ct_select = '1' $sql_search and SUBSTRING(ct_select_time,1,10) between '$fr_day' and '$to_day' group by od_id ";

$cnt1 = sql_query(" select count(*) as cnt $sql1 ");
$total_1 = @sql_num_rows($cnt1); 

$sql2 = " from {$g5['g5_shop_cart_table']} where find_in_set(ct_status, '입금') and find_in_set(pt_it, '{$ct_it}')=0 and pt_id = '{$member['mb_id']}' and ct_select = '1' $sql_search and SUBSTRING(ct_select_time,1,10) between '$fr_day' and '$to_day' group by od_id ";

$cnt2 = sql_query(" select count(*) as cnt $sql2 ");
$total_2 = @sql_num_rows($cnt2); 


$sql3 = " from {$g5['g5_shop_cart_table']} where find_in_set(ct_status, '준비') and find_in_set(pt_it, '{$ct_it}')=0 and pt_id = '{$member['mb_id']}' and ct_select = '1' $sql_search and SUBSTRING(ct_select_time,1,10) between '$fr_day' and '$to_day' group by od_id ";

$cnt3 = sql_query(" select count(*) as cnt $sql3 ");
$total_3 = @sql_num_rows($cnt3); 

$sql4 = " from {$g5['g5_shop_cart_table']} where find_in_set(ct_status, '배송') and find_in_set(pt_it, '{$ct_it}')=0 and pt_id = '{$member['mb_id']}' and ct_select = '1' $sql_search and SUBSTRING(ct_select_time,1,10) between '$fr_day' and '$to_day' group by od_id ";

$cnt4 = sql_query(" select count(*) as cnt $sql4 ");
$total_4 = @sql_num_rows($cnt4); 

$sql5 = " from {$g5['g5_shop_cart_table']} where find_in_set(ct_status, '완료') and find_in_set(pt_it, '{$ct_it}')=0 and pt_id = '{$member['mb_id']}' and ct_select = '1' $sql_search and SUBSTRING(ct_select_time,1,10) between '$fr_day' and '$to_day' group by od_id ";

$cnt5 = sql_query(" select count(*) as cnt $sql5 ");
$total_5 = @sql_num_rows($cnt5); 

$sql_common = " from {$g5['g5_shop_cart_table']} a left join {$g5['g5_shop_order_table']} b on ( a.od_id = b.od_id ) where a.pt_id = '{$member['mb_id']}' and a.ct_status = '취소' and a.ct_select = '1' and b.od_refund_price > 0 and '$to_day' ";
$sql6 = " select count(*) as cnt " . $sql_common;
$row6 = sql_fetch($sql6);
$total_6 = $row6['cnt'];


$sql7 = " from {$g5['g5_shop_cart_table']} where find_in_set(ct_status, '반품접수,반품회수중,반품') and find_in_set(pt_it, '{$ct_it}')=0 and pt_id = '{$member['mb_id']}' and ct_select = '1' $sql_search and SUBSTRING(ct_select_time,1,10) between '$fr_day' and '$to_day' group by od_id ";

$cnt7 = sql_query(" select count(*) as cnt $sql7 ");
$total_7 = @sql_num_rows($cnt7);
?>
<?php if(IS_SELLER) { ?>
	<h1>대시보드</h1>
    <div class="box-1 view-info">
        <ul class="info-inner">
            <li>
                <div class="myphoto">
                    <div class="img"><?php echo ($member['photo']) ? '<img src="'.$member['photo'].'" alt="" class="photo">' : '<i class="fa fa-cubes fa-lg"></i>'; //사진 ?>
                    </div>
                    <div class="conte">
				    <h5><?php echo $member['mb_nick'];?></h5>
                    <p>Level <?php echo $member['level'];?> , <?php echo $member['grade'];?></p>
                    <h6>팔로워 <span><?php echo $member['followed'];?></span>명</h6>
                    <h6>좋아요 <span><?php echo $member['like'];?></span>명</h6>
                    </div>
                </div>
            </li>
            <li>
                <div class="info-sec">
                    <img src="<?php echo $skin_url;?>/images/sale-items.svg" alt="">
                    <h4>오늘 판매량</h4>
                    <p><?php echo number_format($today_sales);?></p>
                    <a href="./?ap=saleitem">더 보기</a>
                </div>
            </li>
            <li>
                <div class="info-sec">
                    <img src="<?php echo $skin_url;?>/images/comments-img.svg" alt="">
                    <h4>오늘 댓글수</h4>
                    <p><?php echo number_format($today_comments);?></p>
                    <a href="./?ap=comment">더 보기</a>
                </div>
            </li>
            <li>
                <div class="info-sec">
                    <img src="<?php echo $skin_url;?>/images/review-img.svg" alt="">
                    <h4>오늘 리뷰수</h4>
                    <p><?php echo number_format($today_reviews);?></p>
                    <a href="./?ap=uselist">더 보기</a>
                </div>
            </li>
            <li>
                <div class="info-sec">
                    <img src="<?php echo $skin_url;?>/images/qna-img.svg" alt="">
                    <h4>질문 현황</h4>
                    <p><?php echo number_format($today_questions);?></p>
                    <a href="./?ap=qalist">더 보기</a>
                </div>
            </li>
        </ul>
    </div>
    <div class="box-wrap">
    <div class="box-2 view-sales">
       <h4>주문/발송 현황</h4>
        <ul>
            <li class="t">주문</li>
            <li class="c"><?php echo $total_1; ?> 건</li>
            <li class="t">결제완료</li>
            <li class="c"><?php echo $total_2; ?> 건</li>
            <li class="t">배송준비</li>
            <li class="c"><?php echo $total_3; ?> 건</li>
            <li class="t">배송중</li>
            <li class="c"><?php echo $total_4; ?> 건</li>
            <li class="t">배송완료</li>
            <li class="c"><?php echo $total_5; ?> 건</li>
        </ul>
    </div>
    <div class="box-2 view-return">
       <h4>취소/반품 현황</h4>
        <ul>
            <li class="t">취소</li>
            <li class="c"><?php echo $total_6; ?> 건</li>
            <li class="t">반품</li>
            <li class="c"><?php echo $total_7; ?> 건</li>
        </ul>
    </div>
     <div class="box-2 view-sales">
       <h4>공지사항</h4>
       <?php echo apms_widget('basic-post-list', $wid.'-wm1211','bo_list=partner_notice'); ?>
       </div>
    <div class="box-2 view-goods">
       <h4>상품</h4>
       <a href="<?php echo G5_SHOP_URL;?>/partner/?ap=list">상품 더보기</a>
        <ul><?php for ($i=0; $i < count(4); $i++) { ?>
             <li>
             <h5><?php echo $list3[$i]['it_name'];?></h5>
             <p><?php echo number_format($list3[$i]['it_price']); ?> 원</p>
             </li>
            <?php } ?>
        </ul>
    </div>
<!--
	<div class="box-3 panel panel-primary">
		<div class="panel-heading">
			<a href="./?ap=salelist">
				<h3 class="panel-title white">
					<i class="fa fa-arrow-circle-right pull-right"></i>
					최근 30일간 판매 현황
				</h3>
			</a>
		</div>
		<div class="panel-body">
			<div id="morris-chart-sales"></div>
		</div>
	</div>
-->
    </div>
<!--
	<script>
		Morris.Area({
		  // ID of the element in which to draw the chart.
		  element: 'morris-chart-sales',
		  // Chart data records -- each entry in this array corresponds to a point on
		  // the chart.
		  data: [
			<?php for ($i=0; $i < count($list); $i++) { ?>
			  { d: '<?php echo $list[$i]['date'];?>', sales: <?php echo $list[$i]['sale'];?> },
			<?php } ?>
		  ],
		  // The name of the data record attribute that contains x-visitss.
		  xkey: 'd',
		  // A list of names of data record attributes that contain y-visitss.
		  ykeys: ['sales'],
		  // Labels for the ykeys -- will be displayed when you hover over the
		  // chart.
		  labels: ['Sales'],
		  // Disables line smoothing
		  smooth: false,
		});
	</script>
-->
<?php } ?>

<?php if(IS_MARKETER) { ?>
	<h1><i class="fa fa-database"></i> Marketer's Summary</h1>

	<div class="row en font-14">
		<div class="col-lg-3 col-md-6">
			<div class="panel panel-info">
				<div class="panel-heading">
					<div class="row">
						<div class="col-sm-4 hidden-xs">
							<i class="fa fa-database fa-5x"></i>
						</div>
						<div class="col-sm-8 col-xs-12 text-right">
							<p class="announcement-heading"><?php echo number_format($today_profit);?></p>
							<p class="announcement-text">오늘 현황</p>
						</div>
					</div>
				</div>
				<a href="./?ap=profititem">
					<div class="panel-footer announcement-bottom">
						<div class="row">
							<div class="col-xs-6">
								View Profit Items
							</div>
							<div class="col-xs-6 text-right">
								<i class="fa fa-arrow-circle-right"></i>
							</div>
						</div>
					</div>
				</a>
			</div>
		</div>
		<div class="col-lg-3 col-md-6">
			<div class="panel panel-warning">
				<div class="panel-heading">
					<div class="row">
						<div class="col-xs-4">
							<i class="fa fa-fire fa-5x"></i>
						</div>
						<div class="col-xs-8 text-right">
							<p class="announcement-heading">Level <?php echo $partner['pt_level'];?></p>
							<p class="announcement-text">My Level</p>
						</div>
					</div>
				</div>
				<div class="panel-footer announcement-bottom">
					<div class="text-right">
						<i class="fa fa-fire"></i> Basic Profit × <?php echo number_format($partner['pt_level_benefit']);?>% Bonus
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-3 col-md-6">
			<div class="panel panel-danger">
				<div class="panel-heading">
					<div class="row">
						<div class="col-xs-4">
							<i class="fa fa-gift fa-5x"></i>
						</div>
						<div class="col-xs-8 text-right">
							<p class="announcement-heading"><?php echo number_format($partner['pt_benefit']);?>%</p>
							<p class="announcement-text">My Incentive</p>
						</div>
					</div>
				</div>
				<div class="panel-footer announcement-bottom">
					<div class="text-right">
						<i class="fa fa-gift"></i> Basic Profit × <?php echo number_format($partner['pt_benefit']);?>% Bonus
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-3 col-md-6">
			<div class="panel panel-success">
				<div class="panel-heading">
					<div class="row">
						<div class="col-xs-4">
							<i class="fa fa-cubes fa-5x"></i>
						</div>
						<div class="col-xs-8 text-right">
							<p class="announcement-heading"><?php echo number_format($partner['pt_level_benefit'] + $partner['pt_benefit']);?>%</p>
							<p class="announcement-text">Total Incentive</p>
						</div>
					</div>
				</div>
				<div class="panel-footer announcement-bottom">
					<div class="text-right">
						<i class="fa fa-cube"></i> Basic Profit × <?php echo number_format($partner['pt_level_benefit'] + $partner['pt_benefit']);?>% Bonus
					</div>
				</div>
			</div>
		</div>
	</div><!-- /.row -->

	<div class="panel panel-primary">
		<div class="panel-heading">
			<a href="./?ap=mlist">
				<h3 class="panel-title white">
					<i class="fa fa-arrow-circle-right pull-right"></i>
					<i class="fa fa-line-chart"></i> My Profit Statistics for 30 days
				</h3>
			</a>
		</div>
		<div class="panel-body">
			<div id="morris-chart-profit"></div>
		</div>
	</div>

	<script>
		Morris.Area({
		  // ID of the element in which to draw the chart.
		  element: 'morris-chart-profit',
		  // Chart data records -- each entry in this array corresponds to a point on
		  // the chart.
		  data: [
			<?php for ($i=0; $i < count($list2); $i++) { ?>
			  { d: '<?php echo $list2[$i]['date'];?>', profit: <?php echo $list2[$i]['profit'];?> },
			<?php } ?>
		  ],
		  // The name of the data record attribute that contains x-visitss.
		  xkey: 'd',
		  // A list of names of data record attributes that contain y-visitss.
		  ykeys: ['profit'],
		  // Labels for the ykeys -- will be displayed when you hover over the
		  // chart.
		  labels: ['Profit'],
		  // Disables line smoothing
		  smooth: false,
		});
	</script>
<?php } ?>

<?php if($notice) { // 전체 알림 ?>
	<div class="alert alert-success alert-dismissable">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<?php echo $notice;?>
	</div>
<?php } ?>
    <div class="box-wrap">
     
    </div>
    
     <div class="box-wrap">
  	<div class="box-4 col-md-6">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">나의 정산 정보</h3>
			</div>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table" style="margin-bottom:13px;">
					<tbody>
					<tr class="active" style="font-weight:bold;">
						<td class="text-center" scope="col">상태</td>
						<td class="text-center" scope="col">신청일</td>
						<td class="text-center" scope="col">접수번호</td>
						<td class="text-center" scope="col">신청금액</td>
						<td class="text-center" scope="col">출금방법</td>
					</tr>
					<?php for ($i=0; $i < count($account); $i++) { ?>
						<tr>
							<td class="text-center"><?php echo $account[$i]['pp_confirm'];?></td>
							<td class="text-center"><?php echo $account[$i]['pp_date'];?></td>
							<td class="text-center"><?php echo $account[$i]['pp_no'];?></td>
							<td class="text-right"><?php echo number_format($account[$i]['pp_amount']);?></td>
							<td class="text-center"><?php echo $account[$i]['pp_means'];?></td>
						</tr>
					<?php } ?>
					<?php if ($i == 0) { ?>
						<tr><td colspan="5" class="text-center">등록된 자료가 없습니다.</td></tr>
					<?php } ?>
					</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<div class="box-4 col-md-6">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">나의 정보</h3>
			</div>
			<div class="panel-body">
				<div class="table-responsive" style="margin-bottom:0px;">
					<table class="table" style="margin-bottom:0px;">
					<tbody>
					<tr>
						<td>기업정보 : <?php echo $company_info; ?></td>
					</tr>
					<tr>
						<td>담당정보 : <?php echo ($partner['pt_name']) ? $partner['pt_name'].' ('.$partner['pt_hp'].', '.$partner['pt_email'].')' : '미등록'; ?></td>
					</tr>
					<tr>
						<td>정산유형 : <?php echo ($partner['pt_company']) ? $partner['pt_company'] : '미등록'; ?></td>
					</tr>
					<tr>
						<td>정산방법 : <?php echo $account_info;?></td>
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
					</tbody>
					</table>

					<?php if($message) { // 메시지 ?>
						<div class="well" style="margin:10px 0px 0px;">
							<?php echo $message;?>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div><!-- /.row -->
</div>