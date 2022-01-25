<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가 

?>
<script src="<?php echo THEMA_URL;?>/assets/js/slick.js"></script>
<script>
    $(document).ready(function(){
        $('.slick-slider').slick({
            infinite:true,
            slidesToShow:3,
            slidesToScroll:3,
            rows:2,
            arrows:false,
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
<div class="fur-1">
<div class="at-container">
<div class="fur-content-list fur-youte">
    <h3>YOUTUBE</h3>
    <p>유튜브</p>    
    <?php echo apms_widget('fur-content-youtube', $wid.'-fc12','bo_list=fur_content'); ?>
    <a class="point" href="<?php echo G5_URL; ?>/bbs/board.php?bo_table=fur_content&sca=유튜브+">유튜브 전체보기</a>
</div>
    </div>
</div>
<div class="fur-2">
<div class="at-container">
<div class="fur-content-list fur-tips">
    <h3>TIP</h3>
    <p>전문가의 팁</p>
    <?php echo apms_widget('fur-content-content', $wid.'-fc13','bo_list=fur_content'); ?>
    <a class="point" href="<?php echo G5_URL; ?>/bbs/board.php?bo_table=fur_content&sca=+실전꿀팁+">전체보기</a>
</div>
    </div>
    </div>