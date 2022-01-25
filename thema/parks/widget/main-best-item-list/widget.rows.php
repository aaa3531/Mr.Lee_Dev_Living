<?php
if (!defined('_GNUBOARD_')) exit; //개별 페이지 접근 불가

if(!$wset['rows']) {
	$wset['rows'] = 8;
}

// 추출하기
$list = apms_item_rows($wset);
$list_cnt = count($list);

$rank = apms_rank_offset($wset['rows'], $wset['page']);

// 새상품
$is_new = (isset($wset['new']) && $wset['new']) ? $wset['new'] : 'red'; 
$new_item = ($wset['newtime']) ? $wset['newtime'] : 24;

// DC
$is_dc = (isset($wset['dc']) && $wset['dc']) ? $wset['dc'] : 'orangered'; 


// owl-hide : 모양유지용 프레임
if($list_cnt) {
?> 
<ul class="best-item store-item-li">
   <?php 
			for ($i=0; $i < $list_cnt; $i++) { 
                
                $cur_price = $dc_per = '';
		if($list[$i]['it_cust_price'] > 0 && $list[$i]['it_price'] > 0) {
			$cur_price = '<strike><i class="fa fa-krw"></i>&nbsp;'.number_format($list[$i]['it_cust_price']).'&nbsp;</strike>';
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

            
                
                $img_src = ($is_lazy) ? 'data-src="'.$list[$i]['img']['src'].'" class="lazyOwl"' : 'src="'.$list[$i]['img']['src'].'"';
    ?>		
    <li>
       <a href="<?php echo $list[$i]['href'];?>">
           <span class="rank-thumb rank-<?php echo $rank; ?>"><?php echo $rank;$rank++;?></span>
           <div class="thumb">
                <img <?php echo $img_src;?> alt="<?php echo $list[$i]['img']['alt'];?>">
            </div>
            <p><?php if($list[$i]['pt_id']) { //파트너아이디가 있으면...
                                         $mb = get_member($list[$i]['pt_id']);
                                         echo $mb['mb_nick']; //회원닉네임
    } ?></p>
            <h4><?php echo $list[$i]['it_name'];?></h4>
            <h5><?php if($list[$i]['it_tel_inq']) { ?>Call<?php } else { ?><span><?php echo $cur_price;?></span><?php echo number_format($list[$i]['it_price']);?> 원<?php } ?><?php if($dc_per) { ?><span class="dc"><?php echo $dc_per;?>% DC</span><?php } ?></h5>
            <!--<h6><span>판매자 |</span><?php if($list[$i]['pt_id']) { //파트너아이디가 있으면...
                                         $mb = get_member($list[$i]['pt_id']);
                                         echo $mb['mb_nick']; //회원닉네임
    } ?></h6>
            <p><span class="star"><i class="fa fa-star fa-lg red"></i><?php echo $list[$i]['it_use_avg'] ?>점 | <?php echo $list[$i]['it_use_cnt'] ?> 명 참여</span></p>-->
       </a>
    </li>
    <?php } ?>
</ul>
<?php } else { ?>
	<div class="item-none">
		등록된 상품이 없습니다.
	</div>
<?php } ?>
	 <?php if($total_count > 0) { ?>
			<div class="list-page text-center">
				<ul class="pagination pagination-sm en">
					<?php if($prev_part_href) { ?>
						<li><a href="<?php echo $prev_part_href;?>">이전검색</a></li>
					<?php } ?>
					<?php echo apms_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, './board.php?bo_table='.$bo_table.$qstr.'&amp;page=');?>
					<?php if($next_part_href) { ?>
						<li><a href="<?php echo $next_part_href;?>">다음검색</a></li>
					<?php } ?>
				</ul>
			</div>
<?php } ?>