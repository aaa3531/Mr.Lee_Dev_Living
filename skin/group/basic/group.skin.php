<?php
if (!defined('_GNUBOARD_')) exit; //개별 페이지 접근 불가

// 헤더 출력
if(isset($wset['hskin']) && $wset['hskin']) {
	$header_skin = $wset['hskin'];
	$header_color = $wset['hcolor'];
	include_once('./header.php');
}
add_stylesheet('<link rel="stylesheet" href="'.$group_skin_url.'/style.css" media="screen">', 0);
?>
<!-- 메인 커뮤니티 영역  -->
<script src="<?php echo THEMA_URL;?>/assets/js/slick.js"></script>
<script>
    $(document).ready(function(){
        $('.slick-slider').slick({
            infinite:true,
            slidesToShow:3,
            slidesToScroll:1,
            rows:2,
            arrows:true,
            dots:true,
            autoplay:true,
            autoplaySpeed: 4000,
            responsive: [
                {
                    breakpoint:768,
                    settings: {
                      slidesToShow:3,
                      slidesToScroll:1,
                      autoplay:true,
                      autoplaySpeed: 2000,
                    },
                },
                {
                    breakpoint:640,
                    settings:{
                      slidesToShow:2,
                      slidesToScroll: 1,
                      autoplay:true,
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
            dots:true,
            autoplaySpeed:2000,
        });
    });
</script>
	<section class="main-3">
    <div class="header">
    <h3>CONTENTS</h3>
    <p>컨텐츠</p>
    </div>
    <div class="at-container">
    <?php echo apms_widget('fur-content-main', $wid.'-fc13','bo_list=fur_content'); ?>
    <a class="more-button" href="<?php echo G5_URL; ?>/bbs/board.php?bo_table=fur_content&sca=+실전꿀팁+">컨텐츠 전체보기</a>
        </div>
</section>
<!-- 메인 커뮤니티 영역 끝  -->
<section class="main-4">
    <div class="header">
            <h3>YOUTUBE</h3>
            <p>유튜브</p>
        </div>
    <?php echo apms_widget('main-commu-post-2', $wid.'-pm12','bo_list=fur_content'); ?>
    <a class="more-button" href="<?php echo G5_URL; ?>/bbs/board.php?bo_table=fur_content&sca=퍼닝유튜브+">유튜브 전체보기</a>
</section>
<div class="fur-2">
<div class="at-container">
<div class="fur-content-list">
    <h3>SHOP</h3>
    <p>가게들</p>   
    <?php echo apms_widget('fur-tomorrow', $wid.'-fc23','bo_list=tomorrow'); ?>
    <a class="point" href="<?php echo G5_URL; ?>/bbs/board.php?bo_table=tomorrow">전체 보기</a>
</div>
    </div>
    <?php if($setup_href) { ?>
	<p class="text-center">
		<a class="btn btn-color btn-sm win_memo" href="<?php echo $setup_href;?>">
			<i class="fa fa-cogs"></i> 스킨설정
		</a>
	</p>
<?php } ?>
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