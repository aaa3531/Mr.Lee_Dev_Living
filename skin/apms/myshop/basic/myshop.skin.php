<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

//자동높이조절
apms_script('imagesloaded');
apms_script('height');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$skin_url.'/style.css" media="screen">', 0);

// 버튼컬러
$btn1 = (isset($wset['btn1']) && $wset['btn1']) ? $wset['btn1'] : 'black';
$btn2 = (isset($wset['btn2']) && $wset['btn2']) ? $wset['btn2'] : 'color';

// 헤더 출력
if($header_skin)
	include_once('./header.php');

// 썸네일
$thumb_w = (isset($wset['thumb_w']) && $wset['thumb_w'] > 0) ? $wset['thumb_w'] : 400;
$thumb_h = (isset($wset['thumb_h']) && $wset['thumb_h'] > 0) ? $wset['thumb_h'] : 540;
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

include_once($skin_path.'/myshop.skin.head.php');
?>

<style>
	.list-wrap { margin-right:<?php echo $minus_right;?>px; margin-bottom:<?php echo $minus_bottom;?>px; }
	.list-wrap .item-row { width:<?php echo apms_img_width($item);?>%; }
	.list-wrap .item-list { margin-right:<?php echo $gap_right;?>px; margin-bottom:<?php echo $gap_bottom;?>px; }
	.list-wrap .item-name { height:<?php echo $line_height;?>px; }
	.list-wrap .img-wrap { padding-bottom:<?php echo $img_h;?>%; }
	<?php if(_RESPONSIVE_) { // 반응형일 때만 작동 ?>
		<?php if($lg) { ?>
		@media (max-width:1199px) { 
			.responsive .list-wrap .item-row { width:<?php echo apms_img_width($lg);?>%; } 
		}
		<?php } ?>
		<?php if($md) { ?>
		@media (max-width:991px) { 
			.responsive .list-wrap .item-row { width:<?php echo apms_img_width($md);?>%; } 
		}
		<?php } ?>
		<?php if($sm) { ?>
		@media (max-width:767px) { 
			.responsive .list-wrap .item-row { width:<?php echo apms_img_width($sm);?>%; } 
		}
		<?php } ?>
		<?php if($xs) { ?>
		@media (max-width:480px) { 
			.responsive .list-wrap .item-row { width:<?php echo apms_img_width($xs);?>%; } 
		}
		<?php } ?>
	<?php } ?>
</style>

<div class="item-list-inner my-shop">
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
	        <p><?php if($list[$i]['pt_id']) { //파트너아이디가 있으면...
                                         $mb = get_member($list[$i]['pt_id']);
                                         echo $mb['mb_nick']; //회원닉네임
    } ?></p>
	        <h4><?php echo $list[$i]['it_name'];?></h4>	        
	        <h5><?php if($list[$i]['it_tel_inq']) { ?>Call<?php } else { ?><span><?php echo $cur_price;?></span><i class="fa fa-krw"></i> <?php echo number_format($list[$i]['it_price']);?><?php } ?><?php if($dc_per) { ?><span class="dc"><?php echo $dc_per;?>% DC</span><?php } ?></h5>
	        <!---<h6>판매자 |  <?php if($list[$i]['pt_id']) { //파트너아이디가 있으면...
                                         $mb = get_member($list[$i]['pt_id']);
                                         echo $mb['mb_nick']; //회원닉네임
    } ?></h6>--->
	        <!---<p><span class="star"><i class="fa fa-star fa-lg red"></i><?php echo $list[$i]['it_use_avg'] ?>점 | <?php echo $list[$i]['it_use_cnt'] ?> 명 참여</span></p>--->
	    </a>
	    </li>
	<?php } // end for ?>
    </ul>
	<?php if(!$list_cnt) { ?>
		<div class="list-none">등록된 상품이 없습니다.</div>
	<?php } ?>
	<div class="clearfix"></div>
</div>
<script>
$(document).ready(function(){
	$('.list-wrap').imagesLoaded(function(){
		$('.list-wrap .item-content').matchHeight();
	});
});
</script>

<div class="list-page text-center">
	<ul class="pagination en">
		<?php echo apms_paging($write_pages, $page, $total_page, $list_page); ?>
	</ul>
	<div class="clearfix"></div>
</div>

<?php if ($is_admin || $setup_href || $myshop_href) { ?>
	<div class="text-center">
		<?php if($myshop_href) { ?>
			<a href="<?php echo $myshop_href;?>" class="btn btn-<?php echo $btn2;?> btn-sm"><i class="fa fa-th-large"></i> 마이샵관리</a>
		<?php } ?>
		<?php if($is_admin) { ?>
			<a class="btn btn-<?php echo $btn1;?> btn-sm" href="<?php echo G5_ADMIN_URL;?>/apms_admin/apms.admin.php?ap=thema"><i class="fa fa-cog"></i> 설정</a>
		<?php } ?>
		<?php if($setup_href) { ?>
			<a class="btn btn-<?php echo $btn2;?> btn-sm win_memo" href="<?php echo $setup_href;?>"><i class="fa fa-cogs"></i> 스킨설정</a>
		<?php } ?>
		<div class="h30"></div>
	</div>
<?php } ?>
</div>