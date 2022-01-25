<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$skin_url.'/style.css" media="screen">', 0);
if (!$is_member)
    goto_url(G5_BBS_URL."/login.php?url=".urlencode(G5_BBS_URL."/mypage.php"));

$mb_homepage = set_http(clean_xss_tags($member['mb_homepage']));
$mb_profile = ($member['mb_profile']) ? conv_content($member['mb_profile'],0) : '';
$mb_signature = ($member['mb_signature']) ? apms_content(conv_content($member['mb_signature'], 1)) : '';

// Page ID
$pid = ($pid) ? $pid : 'mypage';
$at = apms_page_thema($pid);
include_once(G5_LIB_PATH.'/apms.thema.lib.php');

// 스킨 체크
list($member_skin_path, $member_skin_url) = apms_skin_thema('member', $member_skin_path, $member_skin_url); 

// 설정값 불러오기
$is_mypage_sub = false;
@include_once($member_skin_path.'/config.skin.php');

$g5['title'] = $member['mb_nick'].'님 스크랩';

if($is_mypage_sub) {
	include_once(G5_PATH.'/head.sub.php');
	if(!USE_G5_THEME) @include_once(THEMA_PATH.'/head.sub.php');
} else {
	include_once('./_head.php');
}

$skin_path = $member_skin_path;
$skin_url = $member_skin_url;

// 스킨설정
$wset = (G5_IS_MOBILE) ? apms_skin_set('member_mobile') : apms_skin_set('member');

$setup_href = '';
if(is_file($skin_path.'/setup.skin.php') && ($is_demo || $is_designer)) {
	$setup_href = './skin.setup.php?skin=member&amp;ts='.urlencode(THEMA);
}
?>

<div class="sub-title">
	<h4>
		<i class="fa fa-thumb-tack scrap-icon"></i>
		스크랩하기
	</h4>
</div>
<div class="scrap-skin">
	<h3 class="scrap-head">
		<i class="fa fa-quote-left"></i> <?php echo get_text(cut_str($write['wr_subject'], 255)) ?> <i class="fa fa-quote-right"></i>
	</h3>
	<div class="scrap-form">
		<form class="form-horizontal" role="form" name="f_scrap_popin" action="./scrap_popin_update.php" method="post">
		<input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
		<input type="hidden" name="wr_id" value="<?php echo $wr_id ?>">

			<div class="form-group">
				<label class="col-xs-2 control-label" for="wr_content"><i class="fa fa-comment fa-lg"></i> <b>댓글</b></label>
				<div class="col-xs-10">
					<textarea name="wr_content" id="wr_content" rows="10" class="form-control input-sm"></textarea>
					<p class="help-block">
						<i class="fa fa-smile-o fa-lg"></i> 스크랩을 하시면서 감사 혹은 격려의 댓글을 남기실 수 있습니다.
					</p>
				</div>
			</div>

			<p class="text-center">
				<button type="submit" class="btn btn-color btn-sm">스크랩 확인</button>
			</p>
		</form>
	</div>
</div>
<?php
if($is_mypage_sub) {
	if(!USE_G5_THEME) @include_once(THEMA_PATH.'/tail.sub.php');
	include_once(G5_PATH.'/tail.sub.php');
} else {
	include_once('./_tail.php');
}

?>