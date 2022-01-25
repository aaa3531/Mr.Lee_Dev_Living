<?php
if (!defined('_GNUBOARD_')) exit; //개별 페이지 접근 불가

// 링크
$is_modal_js = $wset['modal_js'];
$is_link_target = ($wset['modal'] == "2") ? ' target="_blank"' : '';

if(!$wset['rows']) {
	$wset['rows'] = 6;
}

// 리스트글
$post_cnt = $wset['rows'];

$img_post_cnt = (isset($wset['irows']) && $wset['irows'] > 0) ? $wset['irows'] : 1;

// 이미지글수
$img = array();
$img_arr = array();
$wset['image'] = 1; //이미지글만 추출
$wset['rows'] = $img_post_cnt;
$img = apms_board_rows($wset);
$img_cnt = count($img);
for($i=0; $i < $img_cnt; $i++) {
	$img_arr[$i] = $img[$i]['bo_table'].'-'.$img[$i]['wr_id']; 
}

// 리스트글 - 중복글 제외
$tmp = array();
$wset['image'] = '';
$wset['rows'] = $post_cnt + $img_cnt;
$tmp = apms_board_rows($wset);
$tmp_cnt = count($tmp);
$z = 0;
for($i=0; $i < $tmp_cnt; $i++) {
	
	$chk_wr = $tmp[$i]['bo_table'].'-'.$tmp[$i]['wr_id'];

	if($img_cnt && in_array($chk_wr, $img_arr)) continue;

	$list[$z] = $tmp[$i];

	$z++;

	if($z == $post_cnt) break;
}

unset($tmp);

$list_cnt = count($list);

// 아이콘
$icon = (isset($wset['icon']) && $wset['icon']) ? '<span class="lightgray">'.apms_fa($wset['icon']).'</span>' : '';

// 랭킹
$rank = apms_rank_offset($wset['rows'], $wset['page']); 

// 날짜
$is_idate = (isset($wset['idate']) && $wset['idate']) ? true : false;
$is_date = (isset($wset['date']) && $wset['date']) ? true : false;
$is_dtype = (isset($wset['dtype']) && $wset['dtype']) ? $wset['dtype'] : 'm.d';
$is_dtxt = (isset($wset['dtxt']) && $wset['dtxt']) ? true : false;

// 새글
$is_new = (isset($wset['new']) && $wset['new']) ? $wset['new'] : 'red'; 

// 글내용 - 줄이 1줄보다 크고
$is_cont = ($wset['line'] > 1 && isset($wset['cont']) && $wset['cont']) ? false : true; 

// 분류
$is_cate = (isset($wset['cate']) && $wset['cate']) ? true : false;

// 동영상아이콘
$is_vicon = (isset($wset['vicon']) && $wset['vicon']) ? '' : '<i class="fa fa-play-circle-o post-vicon"></i>'; 

// 스타일
$is_right = (isset($wset['right']) && $wset['right']) ? 'right' : 'left'; 
$is_bold = (isset($wset['bold']) && $wset['bold']) ? true : false;
$is_ticon = (isset($wset['ticon']) && $wset['ticon']) ? true : false;

// 강조글
$bold = array();
$strong = explode(",", $wset['strong']);
$is_strong = count($strong);
for($i=0; $i < $is_strong; $i++) {

	list($n, $bc) = explode("|", $strong[$i]);

	if(!$n) continue;

	$n = $n - 1;
	$bold[$n]['num'] = true;
	$bold[$n]['color'] = ($bc) ? ' class="'.$bc.'"' : '';
}
function passing_time($datetime) {
	$time_lag = time() - strtotime($datetime);
	
	if($time_lag < 60) {
		$posting_time = "방금";
	} elseif($time_lag >= 60 and $time_lag < 3600) {
		$posting_time = floor($time_lag/60)."분 전";
	} elseif($time_lag >= 3600 and $time_lag < 86400) {
		$posting_time = floor($time_lag/3600)."시간 전";
	} elseif($time_lag >= 86400 and $time_lag < 2419200) {
		$posting_time = floor($time_lag/86400)."일 전";
	} else {
		$posting_time = date("y-m-d", strtotime($datetime));
	} 
	
	return $posting_time;
}
?>
<!---<div class="fur-img-wrap">
	<?php // 이미지글
	for ($i=0; $i < $img_cnt; $i++) {

		//아이콘 체크
		$wr_icon = '';
		$is_lock = false;
		if ($img[$i]['secret'] || $img[$i]['is_lock']) {
			$is_lock = true;
			$wr_icon = '<span class="rank-icon en bg-orange en">Lock</span>';	
		} else if($img[$i]['new']) {
			$wr_icon = '<span class="rank-icon txt-normal en bg-'.$is_new.'">New</span>';	
		} 

		//링크이동
		$target = '';
		if($is_link_target && $img[$i]['wr_link1']) {
			$target = $is_link_target;
			$img[$i]['href'] = $img[$i]['link_href'][1];
		}

		//볼드체
		if($is_bold) {
			$img[$i]['subject'] = '<b>'.$img[$i]['subject'].'</b>';
		}
	?>   
     <?php if($img[$i]['img']['src']) { // 있으면 출력 ?>
     <a href="<?php echo $img[$i]['href'];?>"<?php echo $is_modal_js;?><?php echo $target;?>>
	     <div class="thumb">
	         <img src="<?php echo $img[$i]['img']['src'];?>" alt="<?php echo $img[$i]['img']['alt'];?>">
	     </div>
	     <h4><?php echo $img[$i]['subject'];?></h4>
	     <p><b><?php echo $img[$i]['name'];?></b> | 조회수<?php echo $img[$i]['wr_hit'];?> | <?php echo passing_time($img[$i]['wr_datetime']); ?></p>
	</a>
	     <?php } ?>
	<?php } ?>
</div> --->
<ul class="post-list">
<?php
// 리스트
for ($i=0; $i < $list_cnt; $i++) { 

	//아이콘 체크
	$wr_icon = $icon;
	$is_lock = false;
	if ($list[$i]['secret'] || $list[$i]['is_lock']) {
		$is_lock = true;
		$wr_icon = '<span class="wr-icon wr-secret"></span>';
	} else if ($wset['rank']) {
		$wr_icon = '<span class="rank-icon en bg-'.$wset['rank'].'">'.$rank.'</span>';	
		$rank++;
	} else if($list[$i]['new']) {
		$wr_icon = '<span class="wr-icon wr-new"></span>';
	} else if($is_ticon) {
		if ($list[$i]['icon_video']) {
			$wr_icon = '<span class="wr-icon wr-video"></span>';
		} else if ($list[$i]['icon_image']) {
			$wr_icon = '<span class="wr-icon wr-image"></span>';
		} else if ($list[$i]['wr_file']) {
			$wr_icon = '<span class="wr-icon wr-file"></span>';
		}
	}

	//링크이동
	$target = '';
	if($is_link_target && $list[$i]['wr_link1']) {
		$target = $is_link_target;
		$list[$i]['href'] = $list[$i]['link_href'][1];
	}

	//강조글
	if($is_strong) {
		if($bold[$i]['num']) {
			$list[$i]['subject'] = '<b'.$bold[$i]['color'].'>'.$list[$i]['subject'].'</b>';
		}
	}
    
?>
	<li>
		<a href="<?php echo $list[$i]['href'];?>"<?php echo $is_modal_js;?><?php echo $target;?>>
		<div class="rank">
		    <span><?php echo $rank;$rank++;?></span>
		</div>
		<div class="subject"><?php echo $list[$i]['subject'];?><?php if ($list[$i]['comment']) { ?>
						<b>[<?php echo $list[$i]['comment']; ?>]</b>
					<?php } ?>
        </div>
        <div class="name"><?php echo $list[$i]['wr_1'];?></div>
        <div class="date"><?php echo passing_time($list[$i]['wr_datetime']); ?>
         </div>
		</a> 
	</li>
<?php } ?>
</ul>
<?php if(!$list_cnt) { ?>
	<div class="post-none">등록된 글이 없습니다.</div>
<?php } ?>
