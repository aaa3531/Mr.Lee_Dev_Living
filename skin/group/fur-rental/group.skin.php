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
//        $('.slick-slider').slick({
//            infinite:true,
//            slidesToShow:3,
//            slidesToScroll:1,
//            rows:2,
//            autoplay:true,
//            dots:true,
//            arrows:false,
//            autoplaySpeed: 2000,
//            responsive: [
//                {
//                    breakpoint:768,
//                    settings: {
//                      slidesToShow:3,
//                      slidesToScroll:1,
//                      dots:true,
//                      arrows:false,
//                      autoplay:true,
//                      autoplaySpeed: 2000,
//                    },
//                },
//                {
//                    breakpoint:640,
//                    settings:{
//                      slidesToShow:2,
//                      slidesToScroll: 1,
//                      autoplay:true,
//                      dots:true,
//                      arrows:false,
//                      autoplaySpeed: 2000,
//                    },
//                },
//            ],
//        });
            $('.slick-slider-main').slick({
            infinite:true,
            slidesToShow:1,
            slidesToScroll:1,
            autoplay:true,
            arrows:true,
            dots:true,
            autoplaySpeed:5000,
        });
    });
</script>
<!--카테고리 표시-->
<aside class="category-left">
<div class="at-container">
<ul class="ca-sub">
<?php 
$hsql = " select ca_id, ca_name from {$g5['g5_shop_category_table']} where length(ca_id) = '2' and ca_use = '1' order by ca_order, ca_id ";
$hresult = sql_query($hsql);    
for ($i=0; $row=sql_fetch_array($hresult); $i++){
    $cate[$i]['ca_id'] = $row['ca_id'];
    $sql2 = " select ca_id, ca_name from {$g5['g5_shop_category_table']} where LENGTH(ca_id) = '4' and SUBSTRING(ca_id,1,2) = '{$row['ca_id']}' and ca_use = '1' order by ca_order, ca_id ";
    $result2 = sql_query($sql2);
    if($cate[$i]['ca_id'] == 30){
        for ($j = 0; $row2 = sql_fetch_array($result2); $j++) { ?>
           <li><a href="#<?php echo $row2['ca_id']; ?>">
<!--               <img src="<?php echo THEMA_URL;?>/assets/img/<?php echo $row2['ca_id']; ?>.svg" alt="">-->
               <p><?php echo $row2['ca_name']; ?></p>
           </a></li>      
        <?php }
      }
   } ?>
</ul>
</div>
</aside>
<?php echo display_banner('렌탈메인', 'mainbanner.30.skin.php'); ?>
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
<?php 
$hsql = " select ca_id, ca_name from {$g5['g5_shop_category_table']} where length(ca_id) = '2' and ca_use = '1' order by ca_order, ca_id ";
$hresult = sql_query($hsql); 
for ($i=0; $row=sql_fetch_array($hresult); $i++){
    $cate[$i]['ca_id'] = $row['ca_id'];
    $sql2 = " select ca_id, ca_name from {$g5['g5_shop_category_table']} where LENGTH(ca_id) = '4' and SUBSTRING(ca_id,1,2) = '{$row['ca_id']}' and ca_use = '1' order by ca_order, ca_id ";
    $result2 = sql_query($sql2);
    if($cate[$i]['ca_id'] == 30){
        for ($j = 0; $row2 = sql_fetch_array($result2); $j++) { 
    $ca = sql_fetch(" select * from {$g5['g5_shop_category_table']} where ca_id = '{$row2['ca_id']}' ");    ?>
    <div id="fur-<?php echo $row2['ca_id']; ?>" class="fur-4"><div class="at-container"><div id="<?php echo $row2['ca_id']; ?>" class="target fur-store-section">
        <h3 class="notice-tit"><?php echo $ca['ca_1']; ?></h3>
        <p class="notice-sub"><?php echo $row2['ca_name']; ?></p>
         <?php $wn = $row2['ca_id']; ?>
        <?php// echo apms_widget('main-rental-item-slider', $wid.'-wm'.$wn, 'ca_id='.$wn); ?>
        <div class="store-main">
            <?php if($default['de_type5_list_use']) { ?>
            <?php
                 $list = new item_list();
                 $list->set_type(3); // 히트상품유형
//                 $list->set_order_by('it_8 asc');
                 $list->set_category( $wn, 1); // 1단계 분류코드 10
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
        <a class="button-store" href="<?php echo G5_URL; ?>/shop/list.php?ca_id=<?php echo $row2['ca_id']; ?>"><?php echo $row2['ca_name']; ?> 전체보기</a>
     </div>
       </div>
   
   </div>
        <?php }
      }
   } ?>
    <form name="tsearch" method="get" onsubmit="return tsearch_submit(this);" role="form" class="form">
   <div class="group-search-3">
								<label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
								<input type="hidden" name="url"	value="<?php echo G5_URL; ?>/bbs/search.php">
								<input autocomplete="off" id="main-search" type="text" name="stx" value="<?php echo stripslashes($stx) ?>" required id="stx" class="form-control input-sm" maxlength="20" placeholder="검색어를 입력해주세요.">
								<button type="submit" class="btn btn-color">검색</button>
								 <?php echo apms_widget('basic-keyword', $wid.'-fc93'); ?>
								<script>
                               $(document).ready(function(){
                                   $('#main-search').val('');
                               });
                               </script>
                              
							</div>
     </form>
<?php if($setup_href) { ?>
	<p class="text-center">
		<a class="btn btn-color btn-sm win_memo" href="<?php echo $setup_href;?>">
			<i class="fa fa-cogs"></i> 스킨설정
		</a>
	</p>
<?php } ?>
<!--
<div class="custom-center">
    <ul>
        <li>
            <a href="#">
                <div id="sns-1"></div>
                <p>카톡상담</p>
            </a>
        </li>
        <li>
            <a href="#">
                <div id="sns-2"></div>
                <p>상담예약</p>
            </a>
        </li>
        <li>
            <a href="#">
                <div id="sns-3"></div>
                <p>네이버블로그</p>
            </a>
        </li>
        <li>
            <a href="#">
                <div id="sns-4"></div>
                <p>인스타그램</p>
            </a>
        </li>
        <li>
            <a href="#">
               <div id="sns-5"></div>
                <p>페이스북</p>
            </a>
        </li>
    </ul>
</div>-->
