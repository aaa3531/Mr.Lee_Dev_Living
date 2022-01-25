<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 분류항목 출력
if($sca && $boset['cateshow']) {
	$is_category = false;
}

// 선택옵션으로 인해 셀합치기가 가변적으로 변함
$colspan = 5;

if ($is_checkbox) $colspan++;
if ($boset['img']) $colspan++;
if ($is_category) $colspan++;
if ($is_good) $colspan++;
if ($is_nogood) $colspan++;

$list_cnt = count($list);

?>

<div class="notice-board">
<?php for ($i=0; $i < $list_cnt; $i++) { 

		//아이콘 체크
		$wr_icon = '';
		$is_lock = false;
		if ($list[$i]['icon_secret'] || $list[$i]['is_lock']) {
			$wr_icon = '<span class="wr-icon wr-secret"></span>';
			$is_lock = true;
		} else if ($list[$i]['icon_hot']) {
			$wr_icon = '<span class="wr-icon wr-hot"></span>';
		} else if ($list[$i]['icon_new']) {
			$wr_icon = '<span class="wr-icon wr-new"></span>';
		}

		// 공지, 현재글 스타일 체크
		$tr_css = $subject_css = '';
		if ($wr_id == $list[$i]['wr_id']) {
			$tr_css = ' class="list-now"';
			$subject_css = ' now';
			$num = '<span class="wr-text red">열람중</span>';
		} else if ($list[$i]['is_notice']) { // 공지사항
			$tr_css = ' class="active"';
			$subject_css = ' notice';
			$num = '<span class="wr-icon wr-notice"></span>';
			$list[$i]['ca_name'] = '공지';
		} else {
			$num = '<span class="en">'.$list[$i]['num'].'</span>';
		}
	?>
	<ul>
	    <li>
	        <ul>
	            <li class="subject">
                    <h4><a href="<?php echo $list[$i]['href'];?>">
	                <?php if ($is_category) { ?>
	                <span>[<?php echo $list[$i]['ca_name'] ?>]</span>
	                <?php } ?><?php echo $list[$i]['subject']; ?>
	                </a></h4>
	                <p><?php echo apms_date($list[$i]['date'], 'orangered', 'H:i', 'm.d', 'Y.m.d'); ?></p>
	            </li>
	        </ul>
	    </li>
	</ul>
	<?php } ?>
</div>
