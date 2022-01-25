<?php
if (!defined('_GNUBOARD_')) exit;

if($mode == "install") {

	//DB 등록
	include_once('./apms.sql.php');

	//Move
    alert("아미나빌더 설치가 완료되었습니다.", $go_url);
}

?>

<form action="./apms.admin.php" method="post" onsubmit="return install_submit(this);">
<input type="hidden" name="mode" value="install">
<div class="local_ov01 local_ov">
	<b><label for="agree"><input type="checkbox" name="agree" value="동의함" id="agree"> 다음의 아미나빌더 라이센스에 동의합니다.</label></b>
</div>
<div class="tbl_head01 tbl_wrap">
	<textarea name="textarea" id="apms_license" rows="<?php echo (G5_IS_MOBILE) ? 20 : 40;?>" readonly style="width:100%; line-height:1.4; padding:10px;"><?php echo implode('', file('./LICENSE.txt')); ?></textarea>
</div>

<div class="btn_fixed_top">
	<input type="submit" accesskey="s" class="btn btn_submit" value="설치하기">
</div>

</form>

<script>
	function install_submit(f) {
	    if (!f.agree.checked) {
		    alert("라이센스에 동의하셔야 설치하실 수 있습니다.");
	        f.agree.focus();
		    return false;
	    }

		if (!confirm("아미나빌더를 설치하시겠습니까?")) {
			return false;
		}

		return true;
	}
</script>
