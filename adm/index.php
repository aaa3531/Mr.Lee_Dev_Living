<?php
$sub_menu = '100000';
include_once('./_common.php');

//아미나빌더 설치체크
if(!isset($config['as_thema'])) { 
	goto_url(G5_ADMIN_URL.'/apms_admin/apms.admin.php');
}

@include_once('./safe_check.php');
if(function_exists('social_log_file_delete')){
    social_log_file_delete(86400);      //소셜로그인 디버그 파일 24시간 지난것은 삭제
}

$g5['title'] = '관리자메인';
include_once ('./admin.head.php');
include_once (ADMIN_SKIN_PATH.'/index.php');
include_once ('./admin.tail.php');
?>