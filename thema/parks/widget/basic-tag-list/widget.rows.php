<?php
if (!defined('_GNUBOARD_')) exit; //개별 페이지 접근 불가


$list = apms_item_rows($wset);
$list_cnt = count($list);

// 섞기
if($list_cnt > 0 && !$wset['rank'] && $wset['rdm']) {
	shuffle($list);
}

// 랭킹
$rank = apms_rank_offset($wset['rows'], $wset['page']); 

$icolor = ($wset['icolor']) ? $wset['icolor'] : 'icon';
if($list_cnt){
   $list = apms_tag_rows($wset);
   $list_cnt = count($list);
   for ($i=0; $i < $list_cnt; $i++) { 
    ?>  
    <li><a href="<?php echo $list[$i]['href'];?>">#<?php echo $list[$i]['name'];?></a></li>
<?php } 
}?>
