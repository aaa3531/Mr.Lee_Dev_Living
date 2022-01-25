<?php
if (!defined('_GNUBOARD_')) exit; //개별 페이지 접근 불가



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

<script src="<?php echo THEMA_URL;?>/assets/js/slick.js"></script>
<script>
    $(document).ready(function(){
        $('.ca-sub li:first-child a').addClass('active');
        $('.ca-sub li a').on('click', function(event) {
        $(this).parent().find('a').removeClass('active');
        $(this).addClass('active');
        });

        $(window).on('scroll', function() {
            $('.target').each(function() {
                if($(window).scrollTop() >= $(this).offset().top) {
                    var id = $(this).attr('id');
                    $('.ca-sub li a').removeClass('active');
                    $('.ca-sub li a[href="#'+ id +'"]').addClass('active');
                }
            });
        });
        $('.slick-slider').slick({
            infinite:true,
            slidesToShow:3,
            slidesToScroll:1,
            rows:2,
            autoplay:true,
            dots:true,
            arrows:false,
            autoplaySpeed: 2000,
            responsive: [
                {
                    breakpoint:768,
                    settings: {
                      slidesToShow:3,
                      slidesToScroll:1,
                      dots:true,
                      arrows:false,
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
                      dots:true,
                      arrows:false,
                      autoplaySpeed: 2000,
                    },
                },
            ],
        });
    });
</script>
<!--카테고리 표시-->
<aside class="category-left">
<h3>카테고리</h3>
<ul class="ca-sub">
<?php 
$hsql = " select ca_id, ca_name from {$g5['g5_shop_category_table']} where length(ca_id) = '2' and ca_use = '1' order by ca_order, ca_id ";
$hresult = sql_query($hsql);    
for ($i=0; $row=sql_fetch_array($hresult); $i++){
    $cate[$i]['ca_id'] = $row['ca_id'];
    $sql2 = " select ca_id, ca_name from {$g5['g5_shop_category_table']} where LENGTH(ca_id) = '4' and SUBSTRING(ca_id,1,2) = '{$row['ca_id']}' and ca_use = '1' order by ca_order, ca_id ";
    $result2 = sql_query($sql2);
    if($cate[$i]['ca_id'] == 50){
        for ($j = 0; $row2 = sql_fetch_array($result2); $j++) { ?>
           <li><a href="#<?php echo $row2['ca_id']; ?>">
               <img src="<?php echo THEMA_URL;?>/assets/img/<?php echo $row2['ca_id']; ?>.svg" alt="">
           </a></li>      
        <?php }
      }
   } ?>
</ul>
</aside>
<?php echo display_banner('중고메인', 'mainbanner.10.skin.php'); ?>
<!--
<div class="store-banner">
    <div class="banner-img">
        <img src="/assets/img/test.jpg" alt="">
    </div>
    <div class="content-link">
        <ul>
            <li><a href="#">고품격 인테리어의 정석 가구 BRAND</a></li>
            <li><a href="#">고품격 인테리어의 정석 가구 BRAND</a></li>
            <li><a href="#">고품격 인테리어의 정석 가구 BRAND</a></li>
            <li><a href="#">고품격 인테리어의 정석 가구 BRAND</a></li>
            <li><a href="#">고품격 인테리어의 정석 가구 BRAND</a></li>
        </ul>
    </div>
</div>
-->
<div class="tag-section">
            <h5>인기 키워드</h5>
            <?php echo apms_widget('basic-tag-list', $wid.'-wm221'); ?>
</div>
<?php 
$hsql = " select ca_id, ca_name from {$g5['g5_shop_category_table']} where length(ca_id) = '2' and ca_use = '1' order by ca_order, ca_id ";
$hresult = sql_query($hsql); 
for ($i=0; $row=sql_fetch_array($hresult); $i++){
    $cate[$i]['ca_id'] = $row['ca_id'];
    $sql2 = " select ca_id, ca_name from {$g5['g5_shop_category_table']} where LENGTH(ca_id) = '4' and SUBSTRING(ca_id,1,2) = '{$row['ca_id']}' and ca_use = '1' order by ca_order, ca_id ";
    $result2 = sql_query($sql2);
    if($cate[$i]['ca_id'] == 50){
        for ($j = 0; $row2 = sql_fetch_array($result2); $j++) { ?>
    <div id="<?php echo $row2['ca_id']; ?>" class="target fur-store-section">
    <div class="title">
        <h3><?php echo $row2['ca_name']; ?></h3>
        <a href="<?php echo G5_URL; ?>/shop/list.php?ca_id=<?php echo $row2['ca_id']; ?>">더보기</a>
    </div>
    <?php $wn = $row2['ca_id']; ?>
    <?php echo apms_widget('main-item-slider', $wid.'-wm'.$wn, 'ca_id='.$wn); ?>
   </div>
        <?php }
      }
   } ?>
<?php if($setup_href) { ?>
	<p class="text-center">
		<a class="btn btn-color btn-sm win_memo" href="<?php echo $setup_href;?>">
			<i class="fa fa-cogs"></i> 스킨설정
		</a>
	</p>
<?php } ?>
