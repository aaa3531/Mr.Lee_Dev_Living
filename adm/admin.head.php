<?php
if (!defined('_GNUBOARD_')) exit;

if($is_demo) {
	if($pva) set_session('pva', $pva);
	$tmp_pva = get_session('pva');
	
	if($tmp_pva && is_dir(G5_SKIN_PATH.'/admin/'.$tmp_pva)) {
		$admin_skin = $tmp_pva;
	}
}

$begin_time = get_microtime();

$files = glob(G5_ADMIN_PATH.'/css/admin_extend_*');
if (is_array($files)) {
    foreach ((array) $files as $k=>$css_file) {
        
        $fileinfo = pathinfo($css_file);
        $ext = $fileinfo['extension'];
        
        if( $ext !== 'css' ) continue;
        
        $css_file = str_replace(G5_ADMIN_PATH, G5_ADMIN_URL, $css_file);
        add_stylesheet('<link rel="stylesheet" href="'.$css_file.'">', $k);
    }
}

// 스킨설정
function apms_admin_skin($save='', $str='') {
    global $g5, $admin_skin, $is_demo;

	$set = array();

	if($is_demo) {
		if($save) {
			$pva_set = apms_pack($str);
			set_session($admin_skin.'_ademo_set', $pva_set);
		}
		$aset = get_session($admin_skin.'_ademo_set');
		$set = apms_unpack($aset);
	} else {
		$data = sql_fetch(" select * from {$g5['apms_data']} where type = '5' and data_q = '{$admin_skin}' ", false);
		if($save) {
			//스킨설정
			$aset = apms_pack($str);

			if($data['id']) {
				sql_query(" update {$g5['apms_data']} set data_set = '{$aset}' where id = '{$data['id']}'", false);
			} else {
				sql_query(" insert {$g5['apms_data']} set type = '5', data_q = '{$admin_skin}', data_set = '{$aset}' ", false);
			}

			$set = $str;
		} else {
			$set = apms_unpack($data['data_set']);
		}
	}

    return $set;
}

include_once(G5_PATH.'/head.sub.php');
include_once(ADMIN_SKIN_PATH.'/head.php');
?>