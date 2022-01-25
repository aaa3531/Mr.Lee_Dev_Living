<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

$gr_id ='shop';

//자동높이조절
apms_script('imagesloaded');
apms_script('height');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$list_skin_url.'/style.css" media="screen">', 0);

// 버튼컬러
$btn1 = (isset($wset['btn1']) && $wset['btn1']) ? $wset['btn1'] : 'black';
$btn2 = (isset($wset['btn2']) && $wset['btn2']) ? $wset['btn2'] : 'color';

// 썸네일
$thumb_w = (isset($wset['thumb_w']) && $wset['thumb_w'] > 0) ? $wset['thumb_w'] : 400;
$thumb_h = (isset($wset['thumb_h']) && $wset['thumb_h'] > 0) ? $wset['thumb_h'] : 400;
$img_h = apms_img_height($thumb_w, $thumb_h, '135');

$wset['line'] = (isset($wset['line']) && $wset['line'] > 0) ? $wset['line'] : 2;
$line_height = 20 * $wset['line'];

// 간격
$gap_right = (isset($wset['gap']) && ($wset['gap'] > 0 || $wset['gap'] == "0")) ? $wset['gap'] : 15;
$minus_right = ($gap_right > 0) ? '-'.$gap_right : 0;

$gap_bottom = (isset($wset['gapb']) && ($wset['gapb'] > 0 || $wset['gapb'] == "0")) ? $wset['gapb'] : 30;
$minus_bottom = ($gap_bottom > 0) ? '-'.$gap_bottom : 0;

// 가로수
$item = (isset($wset['item']) && $wset['item'] > 0) ? $wset['item'] : 4;

// 반응형
if(_RESPONSIVE_) {
	$lg = (isset($wset['lg']) && $wset['lg'] > 0) ? $wset['lg'] : 3;
	$md = (isset($wset['md']) && $wset['md'] > 0) ? $wset['md'] : 3;
	$sm = (isset($wset['sm']) && $wset['sm'] > 0) ? $wset['sm'] : 2;
	$xs = (isset($wset['xs']) && $wset['xs'] > 0) ? $wset['xs'] : 2;
}

// 새상품
$is_new = (isset($wset['new']) && $wset['new']) ? $wset['new'] : 'red'; 
$new_item = ($wset['newtime']) ? $wset['newtime'] : 24;

// DC
$is_dc = (isset($wset['dc']) && $wset['dc']) ? $wset['dc'] : 'orangered'; 

// 그림자
$shadow_in = '';
$shadow_out = (isset($wset['shadow']) && $wset['shadow']) ? apms_shadow($wset['shadow']) : '';
if($shadow_out && isset($wset['inshadow']) && $wset['inshadow']) {
	$shadow_in = '<div class="in-shadow">'.$shadow_out.'</div>';
	$shadow_out = '';	
}

$list_cnt = count($list);

include_once($list_skin_path.'/category.skin.php');
?>
<script src="<?php echo THEMA_URL;?>/assets/js/slick.js"></script>
<script>
    $(document).ready(function(){
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
<?php if (($ca_id >= '30' && $ca_id <='39') || ($ca_id >='3010' && $ca_id <='3099')){
    echo display_banner('렌탈종류별', 'mainbanner.30.skin.php');
} else if (($ca_id >= '40' && $ca_id <='49') || ($ca_id >='4010' && $ca_id <='4099')){
    echo display_banner('렌탈업종별', 'mainbanner.30.skin.php');
}  ?>
<div class="fur-4">
<div class="at-container">
<div class="item-list-inner">
<div class="filter">
        <ul>
           
            <li>
            <a <?php echo ($sort == 'it_sum_qty') ? 'class="on" ' : '';?>href="<?php echo $list_sort_href; ?>it_sum_qty&amp;sortodr=desc">인기순</a>
            </li>
            <li>
            <a <?php echo ($sort == 'it_use_avg') ? 'class="on" ' : '';?>href="<?php echo $list_sort_href; ?>it_use_avg&amp;sortodr=desc">평점순</a>
            </li>
            <li>
            <a <?php echo ($sort == 'it_update_time') ? 'class="on" ' : '';?>href="<?php echo $list_sort_href; ?>it_update_time&amp;sortodr=desc">최신순</a>
            </li>
            <li>
            <a <?php echo ($sort == 'it_price' && $sortodr == 'desc') ? 'class="on" ' : '';?>href="<?php echo $list_sort_href; ?>it_price&amp;sortodr=desc">높은가격순</a>
            </li>
            <li>
            <a <?php echo ($sort == 'it_price' && $sortodr == 'asc') ? 'class="on" ' : '';?>href="<?php echo $list_sort_href; ?>it_price&amp;sortodr=asc">낮은가격순</a>
            </li>
            <li>
            <?php if($ca_id == 30) { ?>
            <a <?php echo ($type == 1) ? 'class="on" ' : '';?> href="<?php echo G5_SHOP_URL; ?>/listtype.php?ca_id=30&type=3">퍼닝랭킹순</a>
            <?php } else if($ca_id == 40){ ?>
            <a <?php echo ($type == 1) ? 'class="on" ' : '';?> href="<?php echo G5_SHOP_URL; ?>/listtype.php?ca_id=40&type=4">퍼닝랭킹순</a>
            <?php } ?>
            </li>
        </ul>
</div>
	<ul>
    <?php
	// 리스트
	for ($i=0; $i < $list_cnt; $i++) {

		// DC
		$cur_price = $dc_per = '';
		if($list[$i]['it_cust_price'] > 0 && $list[$i]['it_price'] > 0) {
			$cur_price = '<strike>&nbsp;'.number_format($list[$i]['it_cust_price']).'&nbsp;</strike>';
			$dc_per = round((($list[$i]['it_cust_price'] - $list[$i]['it_price']) / $list[$i]['it_cust_price']) * 100);
		}

		// 라벨
		$item_label = '';
		if($dc_per || $list[$i]['it_type5']) {
			$item_label = '<div class="label-cap bg-red">DC</div>';	
		} else if($list[$i]['it_type3'] || $list[$i]['pt_num'] >= (G5_SERVER_TIME - ($new_item * 3600))) {
			$item_label = '<div class="label-cap bg-'.$wset['new'].'">New</div>';
		}

		// 아이콘
		$item_icon = item_icon($list[$i]);
		$item_icon = ($item_icon) ? '<div class="label-tack">'.$item_icon.'</div>' : '';

		// 이미지
		$img = apms_it_thumbnail($list[$i], $thumb_w, $thumb_h, false, true);

	?> 
	    <li>
        <a href="<?php echo $list[$i]['href'];?>">
	        <div class="thumb">
	            <img src="<?php echo $img['src'];?>" alt="<?php echo $img['alt'];?>">
	        </div>
	        <p><?php echo $list[$i]['it_brand'];?></p>
	        <h4><?php echo $list[$i]['it_name'];?></h4>	        
	        <h5><?php if($list[$i]['it_tel_inq']) { ?>Call<?php } else { ?>월<?php echo $cur_price;?> <?php echo number_format($list[$i]['it_price']);?> 원 <?php } ?><?php if($dc_per) { ?><span class="dc"><?php echo $dc_per;?>% DC</span><?php } ?></h5>
	 <!--       <h6>판매자 |  <?php if($list[$i]['pt_id']) { //파트너아이디가 있으면...
                                         $mb = get_member($list[$i]['pt_id']);
                                         echo $mb['mb_nick']; //회원닉네임
    } ?></h6>
	        <p><span class="star"><i class="fa fa-star fa-lg red"></i><?php echo $list[$i]['it_use_avg'] ?>점 | <?php echo $list[$i]['it_use_cnt'] ?> 명 참여</span></p>-->
	    </a>
	    </li>
	    <?php } // end for ?>
	   </ul>
	<?php if(!$list_cnt) { ?>
		<div class="list-none">등록된 상품이 없습니다.</div>
	<?php } ?>
	<div class="clearfix"></div>
	<div class="list-page pull-left">
		<ul class="pagination pagination-sm en">
			<?php echo apms_paging($write_pages, $page, $total_page, $list_page); ?>
		</ul>
		<div class="clearfix"></div>
	</div>
</div>
<script>
$(document).ready(function(){
	$('.list-wrap').imagesLoaded(function(){
		$('.list-wrap .item-content').matchHeight();
	});
});
</script>
<div class="list-btn">
	
	<div class="pull-right">
		<div class="btn-group">
			<?php if ($is_event) { ?>
				<a class="btn btn-<?php echo $btn2;?> btn-sm" href="./event.php"><i class="fa fa-gift"></i> 이벤트</a>
			<?php } ?>
			<?php if ($write_href) { ?>
				<a class="btn btn-<?php echo $btn1;?> btn-sm" href="<?php echo $write_href;?>"><i class="fa fa-upload"></i><span class="hidden-xs"> 등록</span></a>
			<?php } ?>
			<?php if ($admin_href) { ?>
				<a class="btn btn-<?php echo $btn1;?> btn-sm" href="<?php echo $admin_href;?>"><i class="fa fa-th-large"></i><span class="hidden-xs"> 관리</span></a>
			<?php } ?>
			<?php if ($config_href) { ?>
				<a class="btn btn-<?php echo $btn1;?> btn-sm" href="<?php echo $config_href;?>"><i class="fa fa-cog"></i><span class="hidden-xs"> 설정</span></a>
			<?php } ?>
			<?php if($setup_href) { ?>
				<a class="btn btn-<?php echo $btn1;?> btn-sm win_memo" href="<?php echo $setup_href;?>"><i class="fa fa-cogs"></i><span class="hidden-xs"> 스킨설정</span></a>
			<?php } ?>
		</div>
	</div>
	<div class="clearfix"></div>
</div>
</div>
</div>