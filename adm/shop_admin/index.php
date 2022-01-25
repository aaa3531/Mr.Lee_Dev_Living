<?php
$sub_menu = '400000';
include_once('./_common.php');

//아미나빌더 설치체크
if(!isset($config['as_thema'])) { 
	goto_url(G5_ADMIN_URL.'/apms_admin/apms.admin.php');
}

$g5['title'] = '쇼핑몰관리';
include_once ('../admin.head.php');
include_once (ADMIN_SKIN_PATH.'/shop.php');
include_once ('../admin.tail.php');
?>