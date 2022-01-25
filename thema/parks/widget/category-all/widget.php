<?php
if (!defined('_GNUBOARD_')) exit; //개별 페이지 접근 불가

global $menu, $menu_cnt, $at_href;

//add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$widget_url.'/widget.css" media="screen">', 0);

// Random ID
$widget_id = apms_id();

?>
	<?php 
		for($i=1; $i < $menu_cnt; $i++) { 
			$cate_id = 'cate_c'.$i;
			$sub_id =  'cate_s'.$i;
	?>
		<?php if($menu[$i]['is_sub']) { //서브메뉴가 있을 때 ?>
			<div class="panel">
				<div id="<?php echo $sub_id;?>" class="panel-collapse collapse<?php echo ($menu[$i]['on'] == "on") ? ' in' : '';?>" role="tabpanel" aria-labelledby="<?php echo $cate_id;?>">
					<ul class="ca-sub">
					<?php for($j=0; $j < count($menu[$i]['sub']); $j++) { ?>
						<?php if($menu[$i]['sub'][$j]['line']) { //구분라인 ?>
							<li class="ca-line">
								<div class="div-title-underline-thin no-margin">
									<b><?php echo $menu[$i]['sub'][$j]['line'];?></b>
								</div>
							</li>
						<?php } ?>
						<li<?php echo ($menu[$i]['sub'][$j]['on'] == "on") ? ' class="on"' : '';?>>
							<a href="<?php echo $menu[$i]['sub'][$j]['href'];?>"<?php echo $menu[$i]['sub'][$j]['target'];?>>
								<?php echo $menu[$i]['sub'][$j]['name']; //서브메뉴 ?>
								<?php if($menu[$i]['sub'][$j]['count']) { //글수 ?>
									(<?php echo number_format($menu[$i]['sub'][$j]['count']);?>)
								<?php } ?>
								<?php if($menu[$i]['sub'][$j]['new'] == "new") { //새글표시 ?>
									<i class="fa fa-bolt sub-new"></i>
								<?php } ?>
							</a>
						</li>
					<?php } ?>
					</ul>
				</div>
			</div>
		<?php } else { ?>
		<?php } ?>
	<?php } ?>
