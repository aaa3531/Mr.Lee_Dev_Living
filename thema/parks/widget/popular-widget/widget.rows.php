<?php
if (!defined('_GNUBOARD_')) exit; //개별 페이지 접근 불가

// 추출하기
$list = apms_popular_rows($wset);
$list_cnt = count($list);

// 섞기
if($list_cnt > 0 && !$wset['rank'] && $wset['rdm']) {
	shuffle($list);
}


// 리스트
for ($i=0; $i < $list_cnt; $i++) { 
?>
	<li class="ellipsis">
		<a href="<?php echo $list[$i]['href'];?>">
			<?php echo $list[$i]['word'];?>
		</a> 
	</li>
<?php } ?>
<?php if(!$list_cnt) { ?>
	<li class="item-none text-muted text-center">
		자료가 없습니다.
	</li>
<?php } ?>