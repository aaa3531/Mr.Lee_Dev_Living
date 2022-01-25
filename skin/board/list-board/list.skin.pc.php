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
<div class="list-table">
    <ul class="th">
       <?php if ($is_checkbox) { ?>
        <li class="chked">
            <label for="chkall" class="sound_only">현재 페이지 게시물 전체</label>
			<input type="checkbox" id="chkall" onclick="if (this.checked) all_checked(true); else all_checked(false);">
        </li>
        <?php } ?>
        <li class="num">번호</li>
        <?php if($boset['img']) { $icon = apms_fa($boset['icon']); //포토용 아이콘 ?>
        <li class="photo">포토</li>
        <?php } ?>
        <?php if($is_category) { ?>
        <li class="categ">분류</li>
        <?php } ?>
        <li class="subject">제목</li>
        <li class="member">글쓴이</li>
        <li class="date"><?php echo subject_sort_link('wr_datetime', $qstr2, 1) ?>날짜</a></li>
        <li class="keyword">키워드</li>
<!--        <li class="view"><?php echo subject_sort_link('wr_hit', $qstr2, 1) ?><nobr>조회</nobr></a></li>-->
<!--        <li class="good"><?php echo subject_sort_link('wr_good', $qstr2, 1) ?><nobr>추천</nobr></a></li>-->
    </ul>
    <?php for ($i=0; $i < $list_cnt; $i++) { ?>
    <ul class="cont-li">
        
       <?php //아이콘 체크
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
			$tr_css = ' list-now';
			$subject_css = ' now';
			$num = '<span class="wr-text">열람중</span>';
		} else if ($list[$i]['is_notice']) { // 공지사항
			$tr_css = ' notice';
			$subject_css = ' notice';
			$num = '<span class="notice">퍼닝</span>';
			$list[$i]['ca_name'] = '공지';
		} else {
			$num = '<span class="en">'.$list[$i]['num'].'</span>';
		}
	?>
  <?php if ($is_checkbox) { ?>
   <li class="chked <?php echo $tr_css; ?>">
       <label for="chk_wr_id_<?php echo $i ?>" class="sound_only"><?php echo $list[$i]['subject'] ?></label>
       <input type="checkbox" name="chk_wr_id[]" value="<?php echo $list[$i]['wr_id'] ?>" id="chk_wr_id_<?php echo $i ?>">
   </li>
   <?php } ?>
   <li class="num <?php echo $tr_css; ?>"><?php echo $num;?></li>
   <li class="photo <?php echo $tr_css; ?>"><?php if ($boset['img']) { 
			$img = apms_wr_thumbnail($bo_table, $list[$i], 50, 50, false, true); // 썸네일
			$img['src'] = (!$img['src'] && $boset['photo']) ? apms_photo_url($list[$i]['mb_id']) : $img['src']; // 회원사진		
		?>
        <a href="<?php echo $list[$i]['href'];?>">
					<?php if($img['src']) { ?>
						<img src="<?php echo $img['src'];?>" alt="<?php echo $img['alt'];?>">
					<?php } else { ?>
						<?php echo $icon;?>
					<?php } ?>
         </a>
   </li>
   <?php } ?>
   <?php if ($is_category) { ?>
   <li class="categ <?php echo $tr_css; ?>"><a href="<?php echo $list[$i]['ca_name_href'] ?>"><?php echo $list[$i]['ca_name'] ?></a></li>
    <?php } ?>
    <li class="subject <?php echo $tr_css; ?>">
        <a href="<?php echo $list[$i]['href'];?>">
				<?php echo $list[$i]['icon_reply']; ?>
				<?php echo $wr_icon;?>
				<?php echo $list[$i]['subject']; ?>
				<?php if ($list[$i]['comment_cnt']) { ?>
					<span class="sound_only">댓글</span><span class="count orangered">[<?php echo $list[$i]['comment_cnt']; ?>]</span><span class="sound_only">개</span>
				<?php } ?>
			</a>
    </li>
    <li class="member <?php echo $tr_css; ?>"><b><?php echo $list[$i]['name'] ?></b></li>
    <li class="date<?php echo $tr_css; ?>"><?php echo apms_date($list[$i]['date'], 'orangered', 'H:i', 'm.d', 'Y.m.d'); ?></li>
    <li class="keyword<?php echo $tr_css; ?>"><?php echo $list[$i]['wr_1']; ?><?php// echo $list[$i]['wr_hit'];?></li>
    <?php if ($is_good) { ?>
<!--         <li class="good <?php echo $tr_css; ?>"><?php echo $list[$i]['wr_good'] ?></li>-->
    <?php } ?>
    <?php if($is_good == 0) { ?>
<!--         <li class="good <?php echo $tr_css; ?>">0</li>-->
    <?php } ?>
    </ul>
    <?php } ?>
    <?php if (!$is_list) { ?>
		<tr><td colspan="<?php echo $colspan;?>" class="text-center text-muted list-none">게시물이 없습니다.</td></tr>
	<?php } ?>
</div>

