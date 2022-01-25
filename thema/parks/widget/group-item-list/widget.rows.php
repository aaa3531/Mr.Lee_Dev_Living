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
<ul class="store-item-li slick-slider">
   <?php 
			for ($i=0; $i < $list_cnt; $i++) { 
            $img_src = ($is_lazy) ? 'data-src="'.$list[$i]['img']['src'].'" class="lazyOwl"' : 'src="'.$list[$i]['img']['src'].'"';
    ?>		
    <li>
       <a href="<?php echo $list[$i]['href'];?>">
           <div class="thumb">
                <img <?php echo $img_src;?> alt="<?php echo $list[$i]['img']['alt'];?>">
            </div>
            <p><?php echo $list[$i]['it_brand'];?></p>
            <h4><?php echo $list[$i]['it_name'];?></h4>
            <h5><span>\</span><?php echo number_format($list[$i]['it_price']);?> 원</h5>
            <h6><span>판매자 |</span> <?php echo $list[$i]['pt_id']; ?></h6>
            <p><span class="star"><i class="fa fa-star fa-lg red"></i><?php echo $list[$i]['it_use_avg'] ?>점 | <?php echo $list[$i]['it_use_cnt'] ?> 명 참여</span></p>
       </a>
    </li>
    <?php } ?>
</ul>
<?php } else { ?>
	<div class="item-none">
		등록된 상품이 없습니다.
	</div>
<?php } ?>