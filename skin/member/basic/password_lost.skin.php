<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$skin_url.'/style.css" media="screen">', 0);

?>
<link rel="stylesheet" href="<?php echo THEMA_URL;?>/assets/css/furning.css" type="text/css">
<form class="form-horizontal" role="form" name="fpasswordlost" action="<?php echo $action_url ?>" onsubmit="return fpasswordlost_submit(this);" method="post" autocomplete="off">

	<div class="lost panel panel-default">
		<div class="panel-heading"><strong><i class="fa fa-search fa-lg"></i> 회원정보찾기</strong></div>
		<div class="panel-body">
			<p class="help-block">
				회원가입 시 등록하신 이메일 주소를 입력해 주세요. 해당 이메일로 아이디와 비밀번호 정보를 보내드립니다.
				( 비밀번호는 회원님의 정보보호를 위하여 임시 비밀번호로 발급해드립니다.)
			</p>
			<div class="form-group has-feedback">
				<label class="sound_only" for="mb_email"><b>이메일</b><strong class="sound_only">필수</strong></label>			
					<input type="text" name="mb_email" id="mb_email" required class="form-control input-sm email" size="30" maxlength="100" placeholder="가입하실때 등록하신 이메일을 입력해주세요.">
					<span class="fa fa-envelope form-control-feedback"></span>
			</div>

			<div class="form-group">
				<div class="col-xs-10">
					
				</div>
			</div>
		</div>
	</div>

	<div class="lost-button text-center" style="margin:15px 0px 0px;">
		<button type="submit" class="btn btn-color btn-sm">확인</button>
        <button type="button" class="btn btn-black btn-sm" onclick="window.close();">닫기</button>
	</div>
</form>

<script>
function fpasswordlost_submit(f) {

    return true;
}

$(function() {
    var sw = screen.width;
    var sh = screen.height;
    var cw = document.body.clientWidth;
    var ch = document.body.clientHeight;
    var top  = sh / 2 - ch / 2 - 100;
    var left = sw / 2 - cw / 2;
    moveTo(left, top);
});
</script>
<!-- } 회원정보 찾기 끝 -->