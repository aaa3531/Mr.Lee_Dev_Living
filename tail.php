<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

//Level Up
if($member['mb_id']) { 
	//Auto Grade
	$level = (int)$member['mb_level'];
	$xp_level = (int)$member['as_level'];
	$xp_from = (int)$xp['xp_from'];
	$xp_to = (int)$xp['xp_to'];
	if($xp_from > 1 && $xp_to >= $xp_from) {
		if($level >= $xp_from && $level <= $xp_to) {
			$is_maxlevel = true;
			$n = 1;
			for($i = $xp_from; $i <= $xp_to; $i++) {
				if($xp_level < (int)$xp['xp_auto'.$n]) {
					$level = $i;
					$is_maxlevel = false;
					break;
				}
				$n++;
			}

			//최종등급 체크
			if($is_maxlevel) {
				if($xp_level >= (int)$xp['xp_auto'.$xp_to]) {
					$level = $xp_to;
				}
			}

			if($level == (int)$member['mb_level']) {
				;
			} else {
				$member['as_msg'] = ((int)$member['mb_level'] > $level) ? 4 : 3; //3 : 등업, 4 : 다운
				$member['mb_level'] = $level;
			}
		}
	}

	switch($member['as_msg']) { //Message
		case '1' : //레벨업
			$levelup_msg = aslang('alert', 'level_up', array($member['as_level'])); 
			break;
		case '2' : //레벨다운
			$levelup_msg = aslang('alert', 'level_down', array($member['as_level']));
			break;
		case '3' : //등업
			$mg = 'xp_grade'.$member['mb_level']; 
			$levelup_msg = aslang('alert', 'grade_up', array($xp[$mg], $member['mb_level'])); 
			break;
		case '4' : //등급다운	
			$mg = 'xp_grade'.$member['mb_level']; 
			$levelup_msg = aslang('alert', 'grade_down', array($xp[$mg], $member['mb_level'])); 
			break;
	}

	if($member['as_msg']) {
		// 회원정보 업데이트
		sql_query(" update {$g5['member_table']} set mb_level = '{$member['mb_level']}', as_msg = '0' where mb_id = '{$member['mb_id']}' ", false);

		// 회원자료 업데이트
		change_xp($member['mb_id'], $member['as_level']);

		echo "<script> alert('".$levelup_msg."');</script>";
	}
}

if(IS_SHOP) echo '<script src="'.G5_JS_URL.'/sns.js"></script>'.PHP_EOL;

if(USE_G5_THEME && defined('G5_THEME_PATH')) {
    require_once(G5_THEME_PATH.'/tail.php');
    return;
}

if (isset($config['cf_analytics']) && $config['cf_analytics']) {
    echo $config['cf_analytics'];
}

// Page Iframe Modal
if(APMS_PIM || $is_layout_sub) {
	@include_once(THEMA_PATH.'/tail.sub.php');
	include_once(G5_PATH.'/tail.sub.php');
	return;
}

if(IS_SHOP) {
	if(file_exists(THEMA_PATH.'/shop.tail.php')) {
		include_once(THEMA_PATH.'/shop.tail.php');
	} else {
		include_once(THEMA_PATH.'/tail.php');
	}
} else {
	if(file_exists(THEMA_PATH.'/tail.php')) {
		include_once(THEMA_PATH.'/tail.php');
	} else {
		include_once(THEMA_PATH.'/shop.tail.php');
	}
}	

include_once(G5_PATH."/tail.sub.php");
?>