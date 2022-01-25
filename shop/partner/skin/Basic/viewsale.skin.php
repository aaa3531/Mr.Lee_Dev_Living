<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
?>
<link rel="stylesheet" href="<?php echo $skin_url;?>/assets/css/morris.css">
<link rel="stylesheet" href="<?php echo $skin_url;?>/assets/css/morris.css">
<script src="<?php echo $skin_url;?>/assets/js/raphael-min.js"></script>
<script src="<?php echo $skin_url;?>/assets/js/morris.min.js"></script>


<h1> 통계요약</h1>
<div class="table-responsive">
<div class="panel-heading">
	<a href="./?ap=salelist">
		<h3 class="panel-title">
			<i class="fa fa-arrow-circle-right pull-right"></i>
			최근 30일간 판매 현황
		</h3>
	</a>
</div>
<div class="panel-body">
     <div id="morris-chart-sales"></div>
</div>
</div>
<!--
<div class="table-responsive">
<div class="panel-heading">
     <h3 class="panel-title">
			최근 스토어 팔로워/좋아요 현황
     </h3>
     <ul>
         <li>팔로워 <span><?php echo $member['followed'];?></span></li>
         <li>좋아요 <span><?php echo $member['like'];?></span></li>
     </ul>
</div>
<div class="panel-body">
     <div id="morris-chart-sales"></div>
</div>
</div>
-->
<!--
<div class="table-responsive">
    <div class="panel-heading">
        <h3>최근 인기상품</h3>
    </div>
    <div class="viewsale-inner">
        <h4>스토어 인기상품</h4>
    </div>
    <div class="viewsale-inner">
        <h4>렌탈 인기상품</h4>
    </div>
</div>
-->
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