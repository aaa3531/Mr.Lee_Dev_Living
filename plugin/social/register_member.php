<?php
include_once('./_common.php');
//include_once(G5_CAPTCHA_PATH.'/captcha.lib.php');
include_once(G5_LIB_PATH.'/register.lib.php');

define('ASIDE_DISABLE', 1);

if( ! $config['cf_social_login_use'] ){
    alert('소셜 로그인을 사용하지 않습니다.');
}

if( $is_member ){
    alert('이미 회원가입 하였습니다.', G5_URL);
}

$provider_name = social_get_request_provider();
$user_profile = social_session_exists_check();
if( ! $user_profile ){
    alert( "소셜로그인을 하신 분만 접근할 수 있습니다.", G5_URL);
}

// 소셜 가입된 내역이 있는지 확인 상수 G5_SOCIAL_DELETE_DAY 관련
$is_exists_social_account = social_before_join_check($url);

$user_nick = social_relace_nick($user_profile->displayName);
$user_email = isset($user_profile->emailVerified) ? $user_profile->emailVerified : $user_profile->email;
$user_id = $user_profile->sid ? preg_replace("/[^0-9a-z_]+/i", "", $user_profile->sid) : get_social_convert_id($user_profile->identifier, $provider_name);

//$is_exists_id = exist_mb_id($user_id);
//$is_exists_name = exist_mb_nick($user_nick, '');
$user_id = exist_mb_id_recursive($user_id);
$user_nick = exist_mb_nick_recursive($user_nick, '');
$is_exists_email = $user_email ? exist_mb_email($user_email, '') : false;
$user_name = isset($user_profile->username) ? $user_profile->username : ''; 

// 기존 소셜계정 체크
$is_apms_social = false;
$mb_sn = $user_profile->identifier;
$row = sql_fetch(" select mb_id, mb_email from {$g5['member_table']} where mb_sn = '{$mb_sn}' ", false);
if(isset($row['mb_id']) && $row['mb_id']){
	set_session('mb_sn', $mb_sn);
	$is_apms_email = ($row['mb_email']) ? $row['mb_email'] : $is_exists_email;
	$is_apms_social = true;
}

// 불법접근을 막도록 토큰생성
$token = md5(uniqid(rand(), true));
set_session("ss_token", $token);

$g5['title'] = '소셜 회원 가입 - '.social_get_provider_service_name($provider_name);

// Page ID
$pid = ($pid) ? $pid : 'social_regform';
$at = apms_page_thema($pid);
include_once(G5_LIB_PATH.'/apms.thema.lib.php');

$skin_path = get_social_skin_path();
$skin_url = get_social_skin_url();

// 설정값 불러오기
$is_social_regform_sub = false;
@include_once($skin_path.'/config.skin.php');

if($is_social_regform_sub) {
	include_once(G5_PATH.'/head.sub.php');
	if(!USE_G5_THEME) @include_once(THEMA_PATH.'/head.sub.php');
} else {
	include_once(G5_BBS_PATH.'/_head.php');
}

// 약관 등
$provision = $privacy = '';

// 가입약관
$row = sql_fetch(" select co_id, as_file from {$g5['apms_page']} where html_id = 'provision' and as_html = '1' ", false);
if($row['co_id']) {
	$co = sql_fetch(" select * from {$g5['content_table']} where co_id = '{$row['co_id']}' ");
	if ($co['co_id'])
		$provision = conv_content($co['co_content'], $co['co_html'], $co['co_tag_filter_use']);

} else if($row['as_file'] && is_file(G5_PATH.'/page/'.$row['as_file'])) {
	$page_file = G5_PATH.'/page/'.$row['as_file'];
	$page_path = str_replace("/".basename($page_file), "", $page_file);
	$page_url = str_replace(G5_PATH, G5_URL, $page_path);
	ob_start();
	@include_once($page_file);
	$provision = ob_get_contents();
	ob_end_clean();
	$provision = str_replace("./", $page_url."/", $provision);
}

// 개인정보처리방침
$row = sql_fetch(" select co_id, as_file from {$g5['apms_page']} where html_id = 'privacy' and as_html = '1' ", false);
if($row['as_file'] && is_file(G5_PATH.'/page/'.$row['as_file'])) {
	$page_file = G5_PATH.'/page/'.$row['as_file'];
	$page_path = str_replace("/".basename($page_file), "", $page_file);
	$page_url = str_replace(G5_PATH, G5_URL, $page_path);
	ob_start();
	@include_once($page_file);
	$privacy = ob_get_contents();
	ob_end_clean();
	$privacy = str_replace("./", $page_url."/", $privacy);
}

$register_action_url = https_url(G5_PLUGIN_DIR.'/'.G5_SOCIAL_LOGIN_DIR, true).'/register_member_update.php';
$login_action_url = G5_HTTPS_BBS_URL."/login_check.php";
$req_nick = !isset($member['mb_nick_date']) || (isset($member['mb_nick_date']) && $member['mb_nick_date'] <= date("Y-m-d", G5_SERVER_TIME - ($config['cf_nick_modify'] * 86400)));
$required = ($w=='') ? 'required' : '';
$readonly = ($w=='u') ? 'readonly' : '';

include_once($skin_path.'/social_register_member.skin.php');

if($is_social_regform_sub) {
	if(!USE_G5_THEME) @include_once(THEMA_PATH.'/tail.sub.php');
	include_once(G5_PATH.'/tail.sub.php');
} else {
	include_once(G5_BBS_PATH.'/_tail.php');
}
?>
