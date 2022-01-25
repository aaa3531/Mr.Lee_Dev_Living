<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 위젯 대표아이디 설정
$wid = 'SMBW';

// 게시판 제목 폰트 설정
$font = 'font-18 en';

// 게시판 제목 하단라인컬러 설정 - red, blue, green, orangered, black, orange, yellow, navy, violet, deepblue, crimson..
$line = 'navy';

?>
<style>
	.widget-index { overflow:hidden; }
	.widget-index .div-title-underbar { margin-bottom:15px; }
	.widget-index .div-title-underbar span { padding-bottom:4px; }
	.widget-index .div-title-underbar span b { font-weight:500; }
	.widget-index h2.div-title-underbar { font-size:22px; text-align:center; margin-bottom:15px; /* 위젯 타이틀 */ }
	.widget-index h2 .div-title-underbar-bold { font-weight:bold; padding-bottom:4px; border-bottom-width:4px; margin-bottom:-3px; }
	.widget-index .widget-box { margin-bottom:40px; }
	.widget-index .widget-img img { display:block; max-width:100%; /* 배너 이미지 */ }
	@media all and (max-width:767px) {
		.responsive .widget-index .widget-box { margin-bottom:30px; }
	}
</style>

<div class="at-container widget-index">
<!-- 메인 커뮤니티 영역  -->
	<div class="index-content-1">
	    <div class="index-img">
	        <img src="<?php echo THEMA_URL;?>/assets/img/index-sample.jpg" alt="">
	    </div>
	    <div class="community-list">
	        <h3>실시간 인기 게시글</h3>
	        <a class="more" href="#">더보기</a>
	        <ul>
	            <li><span class="index-rank">1</span><a href="#">새로운 인기글입니다.</a></li>
	            <li><span class="index-rank">1</span><a href="#">새로운 인기글입니다.</a></li>
	            <li><span class="index-rank">1</span><a href="#">새로운 인기글입니다.</a></li>
	            <li><span class="index-rank">1</span><a href="#">새로운 인기글입니다.</a></li>
	            <li><span class="index-rank">1</span><a href="#">새로운 인기글입니다.</a></li>
	            <li><span class="index-rank">1</span><a href="#">새로운 인기글입니다.</a></li>
	            <li><span class="index-rank">1</span><a href="#">새로운 인기글입니다.</a></li>
	            <li><span class="index-rank">1</span><a href="#">새로운 인기글입니다.</a></li>
	            <li><span class="index-rank">1</span><a href="#">새로운 인기글입니다.</a></li>
	            <li><span class="index-rank">1</span><a href="#">새로운 인기글입니다.</a></li>
	        </ul>
	    </div>
	</div>
<!-- 메인 커뮤니티 영역 끝  -->
    <!-- 스토어 상품 시작 -->
    <section class="main-sec store-section">
        <div class="header">
            <h3>스토어 인기 상품</h3>
            <p>FURNING 스토어에서 인기 있는 상품들을 소개합니다.</p>
            <a href="<?php echo G5_URL; ?>/bbs/main.php?gid=shop">스토어 상품 더보기</a>
        </div>
        <div class="widget-box">
		     <?php echo apms_widget('basic-shop-item-slider', $wid.'-wm1', 'type1=1 type4=1 auto=0 nav=1 item=5 lg=4', 'auto=0'); ?>
	    </div>
    </section>	
	<!-- 스토어 상품 끝 -->
    <!-- 렌탈 상품 시작 -->
    <section class="main-sec rental-section">
        <div class="header">
            <h3>렌탈 인기 상품</h3>
            <p>FURNING 렌탈 스토어에서 인기 있는 상품들을 소개합니다.</p>
            <a href="<?php echo G5_URL; ?>/bbs/main.php?gid=rental">렌탈 상품 더보기</a>
        </div>
        <div class="widget-box">
		     <?php echo apms_widget('basic-shop-item-slider', $wid.'-wm1', 'type1=1 type4=1 auto=0 nav=1 item=5 lg=4', 'auto=0'); ?>
	    </div>
    </section>	
	<!-- 렌탈 상품 끝 -->
    <!-- 중고 판매 상품 시작 -->
    <section class="main-sec used-section">
        <div class="header">
            <h3>중고 인기 상품</h3>
            <p>FURNING 중고 스토어에서 인기 있는 상품들을 소개합니다.</p>
            <a href="<?php echo G5_URL; ?>/bbs/main.php?gid=used">중고 판매 상품 더보기</a>
        </div>
        <div class="widget-box">
		     <?php echo apms_widget('basic-shop-item-slider', $wid.'-wm1', 'type1=1 type4=1 auto=0 nav=1 item=5 lg=4', 'auto=0'); ?>
	    </div>
    </section>	
	<!-- 중고 판매 상품 끝 -->


</div>
