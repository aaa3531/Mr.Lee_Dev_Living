<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
global $list;
// 위젯 대표아이디 설정
$wid = 'CMBL';

// 게시판 제목 폰트 설정
$font = 'font-16 en';

// 게시판 제목 하단라인컬러 설정 - red, blue, green, orangered, black, orange, yellow, navy, violet, deepblue, crimson..
$line = 'navy';

// 사이드 위치 설정 - left, right
//$side = ($at_set['side']) ? 'left' : 'right';

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
<script src="<?php echo THEMA_URL;?>/assets/js/slick.js"></script>
<script>
    $(document).ready(function(){
        $('.slick-slider').slick({
            infinite:true,
            slidesToShow:3,
            slidesToScroll:3,
            rows:2,
            autoplay:true,
            arrows:true,
            dots:true,
            autoplaySpeed: 4000,
            responsive: [
                {
                    breakpoint:768,
                    settings: {
                      slidesToShow:3,
                      rows:2,
                      slidesToScroll:1,
                      autoplay:true,
                      arrows:true,
                      dots:true,
                      autoplaySpeed: 2000,
                    },
                },
                {
                    breakpoint:640,
                    settings:{
                      slidesToShow:2,
                      rows:2,
                      slidesToScroll: 1,
                      autoplay:true,
                      arrows:false,
                      dots:true,
                      autoplaySpeed: 2000,
                    },
                },
            ],
        });
        $('.slick-slider-3').slick({
            infinite:true,
            slidesToShow:4,
            slidesToScroll:4,
            rows:2,
            autoplay:true,
            arrows:true,
            dots:true,
            autoplaySpeed: 4000,
            responsive: [
                {
                    breakpoint:768,
                    settings: {
                      slidesToShow:3,
                      rows:2,
                      slidesToScroll:1,
                      autoplay:true,
                      arrows:true,
                      dots:true,
                      autoplaySpeed: 2000,
                    },
                },
                {
                    breakpoint:640,
                    settings:{
                      slidesToShow:2,
                      rows:2,
                      slidesToScroll: 1,
                      autoplay:true,
                      arrows:false,
                      dots:true,
                      autoplaySpeed: 2000,
                    },
                },
            ],
        });
        $('.slick-slider-2').slick({
            infinite:false,
            slidesToShow:3,
            slidesToScroll:3,
            rows:2,
            autoplay:true,
            arrows:true,
            dots:true,
            autoplaySpeed: 4000,
            responsive: [
                {
                    breakpoint:768,
                    settings: {
                      slidesToShow:3,
                      rows:2,
                      slidesToScroll:1,
                      autoplay:true,
                      arrows:true,
                      dots:true,
                      autoplaySpeed: 2000,
                    },
                },
                {
                    breakpoint:640,
                    settings:{
                      slidesToShow:2,
                      rows:2,
                      slidesToScroll: 1,
                      autoplay:true,
                      arrows:false,
                      dots:true,
                      autoplaySpeed: 2000,
                    },
                },
            ],
        });
        $('.index-slider').slick({
            infinite:true,
            slidesToShow:1,
            slidesToScroll:1,
            autoplay:true,
            arrows:false,
            dots:false,
            autoplaySpeed:2000,
        });
        $('.slick-slider-main').slick({
            infinite:true,
            slidesToShow:1,
            slidesToScroll:1,
            autoplay:true,
            arrows:true,
            dots:true,
            autoplaySpeed:5000,
        });
        $('.index-slider-video').slick({
            infinite:true,
            slidesToShow:1,
            rows:2,
            slidesToScroll:1,
            autoplay:true,
            arrows:false,
            dots:false,
            autoplaySpeed:2000,
        });
    });
</script>
<?php echo display_banner('메인', 'mainbanner.30.skin.php'); ?>
<section class="main-2">
    <div class="header">
        <h3>PARKSDESIGN</h3>
        <p>상업용 전문 가구플랫폼 PARKSDESIGN 의 주요 서비스를 소개합니다.</p>
    </div>
    <ul class="fur-service at-container">
            <li><a href="<?php echo G5_URL; ?>/bbs/main.php?gid=community">
                <img src="<?php echo THEMA_URL; ?>/assets/img/fur-service1.svg" alt="">
                <h3>커뮤니티</h3>
                <p>다른사장님과의 소통 / 전문가의 팁<br>
                사업장인터뷰 / 가게 자랑하기</p>
            </a></li>
            <li><a href="<?php echo G5_URL; ?>/bbs/main.php?gid=shop">
                <img src="<?php echo THEMA_URL; ?>/assets/img/fur-service2.svg" alt="">
                <h3>스토어</h3>
                <p>전문 상업용 가구 판매<br>
                종류별, 업종별 가구 판매</p>
            </a></li>
            <li><a href="<?php echo G5_URL; ?>/bbs/main.php?gid=rental">
                <img src="<?php echo THEMA_URL; ?>/assets/img/fur-service3.svg" alt="">
                <h3>렌탈전용</h3>
                <p>전문 상업용 가구 렌탇<br>
                인수, 반납, 단기 대여 서비스</p>
            </a></li>
            <li><a href="<?php echo G5_URL; ?>/bbs/page.php?hid=fur-all-shop">
                <img src="<?php echo THEMA_URL; ?>/assets/img/fur-service4.svg" alt="">
                <h3>업체검색</h3>
                <p>온라인 상권분석<br>
                분야별 사업장 인테리어 분석</p>
            </a></li>
        </ul>
    
</section>

<section class="main-3">
    <h3>CONTENTS</h3>
    <p>컨텐츠</p>
    <div class="at-container">
    <?php echo apms_widget('fur-content-main', $wid.'-fc13','bo_list=fur_content'); ?>
    <a class="more-button" href="<?php echo G5_URL; ?>/bbs/board.php?bo_table=fur_content&sca=+실전꿀팁+">컨텐츠 전체보기</a>
    </div> 
</section>
<section class="main-4">
    <div class="header">
            <h3>YOUTUBE</h3>
            <p>유튜브</p>
        </div>
    <?php echo apms_widget('main-commu-post-2', $wid.'-pm12','bo_list=fur_content'); ?>
    <a class="more-button" href="<?php echo G5_URL; ?>/bbs/board.php?bo_table=fur_content&sca=유튜브+">유튜브 전체보기</a>
</section>
<div class="widget-index main-5">
<!-- 메인 커뮤니티 영역  -->
<!-- 메인 커뮤니티 영역 끝  -->
    <!-- 스토어 상품 시작 -->
    <section class="at-container main-sec store-section">
        <div class="header">
            <h3>STORE</h3>
            <p>스토어</p>
        </div>
        <?php // echo apms_widget('main-item-list', $wid.'-wm111','ca_id=10'); ?>
        <div class="store-main">
            <?php if($default['de_type5_list_use']) { ?>
            <?php
                 $list = new item_list();
                 $list->set_type(5); // 히트상품유형
                 $list->set_order_by('it_5 asc');
                 $list->set_category('10', 1); // 1단계 분류코드 10
                 $list->set_view('it_img', true);
                 $list->set_view('it_id', true);
                 $list->set_view('it_name', true);
                 $list->set_view('it_basic', true);
                 $list->set_view('it_cust_price', true);
                 $list->set_view('it_price', true);
                 $list->set_view('it_icon', true);
                 $list->set_view('sns', true);
                 echo $list->run();
             ?>
            <?php }?>
        </div>
        <a class="more-button" href="<?php echo G5_URL; ?>/bbs/main.php?gid=shop">스토어 전체보기</a>
    </section>	
	<!-- 스토어 상품 끝 -->
    <!-- 렌탈 상품 시작 -->
<!--
    <section class="main-sec rental-section">
        <div class="header">
            <h3>렌탈 인기 상품</h3>
            <p>FURNING 렌탈 스토어에서 인기 있는 상품들을 소개합니다.</p>
            <a href="<?php echo G5_URL; ?>/bbs/main.php?gid=rental">렌탈 상품 더보기</a>
        </div>
        
    </section>	
-->
	<!-- 렌탈 상품 끝 -->
</div>
<div class="widget-index rent main-5">
<!-- 메인 커뮤니티 영역  -->
<!-- 메인 커뮤니티 영역 끝  -->
    <!-- 스토어 상품 시작 -->
    <section class="at-container main-sec rent-section">
        <div class="header">
            <h3>RENTAL</h3>
            <p>대여</p>
        </div>
        <?php // echo apms_widget('main-rental-item-slider', $wid.'-wm112','ca_id=30'); ?>
        <?php //echo apms_widget('main-item-list', $wid.'-wm111','ca_id=30'); ?>
        <div class="store-main">
            <?php if($default['de_type6_list_use']) { ?>
            <?php
                 $list = new item_list();
                 $list->set_type(6); // 히트상품유형
                 $list->set_order_by('it_6 asc');
                 $list->set_category('30', 1); // 1단계 분류코드 10
                 $list->set_view('it_img', true);
                 $list->set_view('it_id', true);
                 $list->set_view('it_name', true);
                 $list->set_view('it_basic', true);
                 $list->set_view('it_cust_price', true);
                 $list->set_view('it_price', true);
                 $list->set_view('it_icon', true);
                 $list->set_view('sns', true);
                 echo $list->run();
             ?>
            <?php }?>
        </div>
        <a class="more-button" href="<?php echo G5_URL; ?>/bbs/main.php?gid=rental">렌탈 전체보기</a>
    </section>	
	<!-- 스토어 상품 끝 -->
    <!-- 렌탈 상품 시작 -->
<!--
    <section class="main-sec rental-section">
        <div class="header">
            <h3>렌탈 인기 상품</h3>
            <p>FURNING 렌탈 스토어에서 인기 있는 상품들을 소개합니다.</p>
            <a href="<?php echo G5_URL; ?>/bbs/main.php?gid=rental">렌탈 상품 더보기</a>
        </div>
        <?php// echo apms_widget('main-rental-item-slider', $wid.'-wm112','ca_id=30'); ?>
    </section>	
-->
	<!-- 렌탈 상품 끝 -->
</div>
<div class="new-furning">
    <a href="http://furning.kr" target="_blank" class="at-container">
        <h3>처음 오신분들이라면,</h3>
        <p>How To PARKSDESIGN</p>
        <img src="<?php echo THEMA_URL;?>/assets/img/main-bg.png" alt="">
    </a>
</div>
<div class="custom-center">
    <ul>
        <li>
            <a href="void(0);" onclick="alert('현재 준비중입니다.');return false;">
                <div id="sns-1"></div>
                <p>카톡상담</p>
            </a>
        </li>
        <li>
            <a href="void(0);" onclick="alert('현재 준비중입니다.');return false;">
                <div id="sns-2"></div>
                <p>서비스소개</p>
            </a>
        </li>
        <li>
            <a href="void(0);" onclick="alert('현재 준비중입니다.');return false;">
                <div id="sns-3"></div>
                <p>네이버블로그</p>
            </a>
        </li>
        <li>
            <a href="void(0);" onclick="alert('현재 준비중입니다.');return false;">
                <div id="sns-4"></div>
                <p>인스타그램</p>
            </a>
        </li>
        <li>
            <a href="void(0);" onclick="alert('현재 준비중입니다.');return false;">
               <div id="sns-5"></div>
                <p>페이스북</p>
            </a>
        </li>
    </ul>
</div>
 <!--<div class="at-container widget-index">
    중고 판매 상품 시작 -->
<!--
    <section class="main-sec used-section">
        <div class="header">
            <h3>중고 인기 상품</h3>
            <p>FURNING 중고 스토어에서 인기 있는 상품들을 소개합니다.</p>
            <a href="<?php echo G5_URL; ?>/bbs/main.php?gid=used">중고 판매 상품 더보기</a>
        </div>
        <?php echo apms_widget('main-item-slider', $wid.'-wm113','ca_id=50'); ?>
    </section>	
-->
	<!-- 중고 판매 상품 끝


</div> -->