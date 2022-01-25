<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가 
?>
<script src="<?php echo THEMA_URL;?>/assets/js/slick.js"></script>
<script>
    $(document).ready(function(){
        $('.slick-slider').slick({
            infinite:true,
            slidesToShow:3,
            slidesToScroll:1,
            rows:1,
            arrows:false,
            dots:false,
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
            dots:false,
            autoplaySpeed:2000,
        });
    });
</script>
<div class="fur-1">
<div class="at-container">
<div class="fur-content-list">
    <h3>BEST</h3>
    <p>베스트</p>
    <a class="point" href="<?php echo G5_URL; ?>/bbs/board.php?bo_table=fur_all_shop&sca=잘되는+가게">잘되는 가게 더 보기</a>
    <?php echo apms_widget('fur-tomorrow-best', $wid.'-fc32','bo_list=fur_all_shop'); ?>
    </div>
    </div>
</div>
<div class="fur-2">
<div class="at-container">
<div class="fur-content-list">
    <h3>ALL SHOP</h3>
    <p>전체 가게</p>
    <a class="point" href="<?php echo G5_URL; ?>/bbs/board.php?bo_table=fur_all_shop">전체 보기</a>
    <?php echo apms_widget('fur-tomorrow', $wid.'-fc33','bo_list=fur_all_shop'); ?>
    </div>
    </div>
</div>