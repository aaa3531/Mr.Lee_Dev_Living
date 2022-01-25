<?php
if (!defined('_GNUBOARD_')) exit; //개별 페이지 접근 불가

// 링크
$is_modal_js = $wset['modal_js'];
$is_link_target = ($wset['modal'] == "2") ? ' target="_blank"' : '';

$wset['thumb_w'] = (isset($wset['thumb_w']) && $wset['thumb_w'] > 0) ? $wset['thumb_w'] : 400;
$wset['thumb_h'] = (isset($wset['thumb_h']) && $wset['thumb_h'] > 0) ? $wset['thumb_h'] : 300;
$img_h = apms_img_height($wset['thumb_w'], $wset['thumb_h'], '75');

if(!$wset['rows']) {
	$wset['rows'] = 6;
}

// 리스트글
$post_cnt = $wset['rows'];

$img_post_cnt = (isset($wset['irows']) && $wset['irows'] > 0) ? $wset['irows'] : 6;
if($img_post_cnt > 6) {
	$img_post_cnt = 6;
}

switch($img_post_cnt) {
	case '1'	: $is_dadan = ''; break;
	case '2'	: $is_dadan = ' is-2'; break;
	default		: $is_dadan = ' is-3'; break;
}

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

// 이미지글 제목크기
$wset['line'] = (isset($wset['line']) && $wset['line'] > 0) ? $wset['line'] : 1;
$text_height = 20 * $wset['line'];
if($wset['line'] > 1) $line_height = $line_height + 4;

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
$is_cont = ($wset['line'] > 1) ? true : false; 
$is_details = ($is_cont) ? '' : ' no-margin'; 

// 분류
$is_cate = (isset($wset['cate']) && $wset['cate']) ? true : false;

// 동영상아이콘
$is_vicon = (isset($wset['vicon']) && $wset['vicon']) ? '' : '<i class="fa fa-play-circle-o post-vicon"></i>'; 

// 스타일
$is_center = (isset($wset['center']) && $wset['center']) ? ' text-center' : ''; 
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

// 그림자
$shadow_in = '';
$shadow_out = (isset($wset['shadow']) && $wset['shadow']) ? apms_shadow($wset['shadow']) : '';
if($shadow_out && isset($wset['inshadow']) && $wset['inshadow']) {
	$shadow_in = '<div class="in-shadow">'.$shadow_out.'</div>';
	$shadow_out = '';	
}

?>
<div class="community-list">
	        <ul><?php
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
	            <a href="<?php echo $list[$i]['href'];?>">
	            <div class="thumb">
	                <img src="<?php echo $list[$i]['img']['src'];?>" alt="<?php echo $list[$i]['img']['alt'];?>">
	            </div>
	            <h4><?php echo $list[$i]['subject'];?></h4>
	            <p><?php echo $list[$i]['wr_2'];?></p>
	            </a></li>
	            <?php } ?>
	        </ul>
	    </div>
<?php if(!$list_cnt) { ?>
	<div class="post-none">등록된 글이 없습니다.</div>
<?php } ?>
