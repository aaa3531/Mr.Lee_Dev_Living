<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
global $menu, $menu_cnt, $at_href, $ca_id;
$widget_id = apms_id();
// 헤더 출력
if(isset($wset['hskin']) && $wset['hskin']) {
	$header_skin = $wset['hskin'];
	$header_color = $wset['hcolor'];
	include_once('./header.php');
}
add_stylesheet('<link rel="stylesheet" href="'.$group_skin_url.'/style.css" media="screen">', 0);
?>
<script type="text/javascript">
        $(document).ready(function() {

            //When page loads...
            $(".tab-cont").hide(); //Hide all content
            $("ul.tabs li:first").addClass("active").show(); //Activate first tab
            $(".tab-cont:first").show(); //Show first tab content

            //On Click Event
            $("ul.tabs li").click(function() {

                $("ul.tabs li").removeClass("active"); //Remove any "active" class
                $(this).addClass("active"); //Add "active" class to selected tab
                $(".tab-cont").hide(); //Hide all tab content

                var activeTab = $(this).find("a").attr("href"); //Find the href attribute value to identify the active tab + content
                $(activeTab).fadeIn(); //Fade in the active ID content
                return false;
            });

        });
</script>
<div class="new-best-header">
    <h3>중고 베스트 상품</h3>
    <div class="cates-banner">
    <a href="#">
        <img src="https://indebox.co.kr/_wg/img/JS_mainBnr/cm2.jpg" alt="">
    </a>
</div>
    <ul class="tabs">
        <li class="active"><a href="#tab-1">오늘의 인기상품</a></li>
        <li><a href="#tab-2">주간 베스트</a></li>
        <li><a href="#tab-3">월간 베스트</a></li>
    </ul>
</div>
<div class="tab-container">
    <div id="tab-1" class="tab-cont">
        <p><?php echo date('y년 m월 d일');?>기준</p>
        <?php echo apms_widget('main-best-item-list', $wid.'-wm3101'.$wn, 'ca_id=50 frm_input=30 sort=qty term=today'); ?>
    </div>
    <div id="tab-2" class="tab-cont">
       <p><?php echo date('y년 m월 d일');?>기준</p>
        <?php echo apms_widget('main-best-item-list', $wid.'-wm3102'.$wn, 'ca_id=50 frm_input=30 sort=qty term=week'); ?>
    </div>
    <div id="tab-3" class="tab-cont">
       <p><?php echo date('y년 m월 d일');?>기준</p>
        <?php echo apms_widget('main-best-item-list', $wid.'-wm3103'.$wn, 'ca_id=50 frm_input=30 sort=qty term=month'); ?>
    </div>
</div>
