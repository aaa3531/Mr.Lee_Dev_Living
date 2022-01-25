<?php
if (!defined('_GNUBOARD_')) exit; //개별 페이지 접근 불가

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
<style>
	.myphoto img { width:<?php echo $photo_width;?>px; height:<?php echo $photo_height;?>px; }
	.myphoto i { width:80px; height:80px; }
</style>
<div class="fur-4">
<div class="photo">
<form name="fphotoform" class="form" role="form" method="post" enctype="multipart/form-data" autocomplete="off">
	<input type="hidden" name="mode" value="u">
	<div class="panel panel-default">
       <h3>프로필 사진 등록하기</h3>
		<div class="panel-body">
			<div class="row">
				<div class="col-lg-2 col-sm-3 text-center">
					<div class="myphoto">
						<?php echo ($myphoto) ? '<img src="'.$myphoto.'" alt="">' : '<i class="fa fa-user"></i>'; ?>
					</div>
				</div>
				<div class="col-lg-10 col-sm-9">
					<p>
						회원사진은 이미지(gif/jpg/png) 파일만 가능하며, 등록시 <?php echo $photo_width;?>x<?php echo $photo_height;?> 사이즈로 자동 리사이즈됩니다.
					</p>
					<p><input type=file name="mb_icon2"></p>

					<?php if ($is_photo) { ?>
						<p><label><input type="checkbox" name="del_mb_icon2" value="1"> 삭제하기</label></p>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>

	<div class="text-center">
		<button type="submit" class="btn btn-color btn-sm">등록</button>
	</div>		
</form>
</div>
</div>
<script>
$(function() {
	window.resizeTo(320, 440);
});
</script>
<?php
if($is_mypage_sub) {
	if(!USE_G5_THEME) @include_once(THEMA_PATH.'/tail.sub.php');
	include_once(G5_PATH.'/tail.sub.php');
} else {
	include_once('./_tail.php');
}

?>