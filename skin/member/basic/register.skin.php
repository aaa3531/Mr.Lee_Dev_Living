<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$skin_url.'/style.css" media="screen">', 0);

//if($header_skin)
//	include_once('./header.php');

if($config['cf_social_login_use']) { //소셜 로그인 사용시 

	$social_pop_once = false;

	$self_url = G5_BBS_URL."/login.php";

	//새창을 사용한다면
	if( G5_SOCIAL_USE_POPUP ) {
		$self_url = G5_SOCIAL_LOGIN_URL.'/popup.php';
	}
?>
<meta name="viewport" content="width=device-width, user-scalable=no">
<link rel="stylesheet" href="<?php echo THEMA_URL;?>/assets/css/furning.css">
   <div class="furning-wrap">
   <div class="furning-login">
	<div class="form-box sns-wrap-over" id="sns_register">
	    <div id="logo">
            <a href="<?php echo G5_URL;?>">
             <img src="<?php echo THEMA_URL;?>/assets/img/logo.svg" alt="">
             </a>
        </div>
        <h3 class="sns-join">SNS 계정으로 간편하게 회원가입</h3>
		<div class="panel panel-primary">
			
			<div class="panel-body">
			   <div class="sns-wrap">
					<?php if( social_service_check('naver') ) {     //네이버 로그인을 사용한다면 ?>
					<a href="<?php echo $self_url;?>?provider=naver&amp;url=<?php echo $urlencode;?>" class="sns-icon social_link sns-naver" title="네이버">
						<img src="<?php echo THEMA_URL;?>/assets/img/sns_naver-big.png" alt="">
					</a>
					<?php }     //end if ?>
					<?php if( social_service_check('kakao') ) {     //카카오 로그인을 사용한다면 ?>
					<a href="<?php echo $self_url;?>?provider=kakao&amp;url=<?php echo $urlencode;?>" class="sns-icon social_link sns-kakao" title="카카오">
						<img src="<?php echo THEMA_URL;?>/assets/img/sns_kakao-big.png" alt="">
					</a>
					<?php }     //end if ?>
					<?php if( social_service_check('facebook') ) {     //페이스북 로그인을 사용한다면 ?>
					<a href="<?php echo $self_url;?>?provider=facebook&amp;url=<?php echo $urlencode;?>" class="sns-icon social_link sns-facebook" title="페이스북">
					    <img src="<?php echo THEMA_URL;?>/assets/img/sns_fb-big.png" alt="">
					</a>
					<?php }     //end if ?>
					<?php if( social_service_check('google') ) {     //구글 로그인을 사용한다면 ?>
					<a href="<?php echo $self_url;?>?provider=google&amp;url=<?php echo $urlencode;?>" class="sns-icon social_link sns-google" title="구글">
						<span class="ico"></span>
						<span class="txt">구글+로 회원가입하기</span>
					</a>
					<?php }     //end if ?>
					<?php if( social_service_check('twitter') ) {     //트위터 로그인을 사용한다면 ?>
					<a href="<?php echo $self_url;?>?provider=twitter&amp;url=<?php echo $urlencode;?>" class="sns-icon social_link sns-twitter" title="트위터">
						<span class="ico"></span>
						<span class="txt">트위터로 회원가입하기</span>
					</a>
					<?php }     //end if ?>
					<?php if( social_service_check('payco') ) {     //페이코 로그인을 사용한다면 ?>
					<a href="<?php echo $self_url;?>?provider=payco&amp;url=<?php echo $urlencode;?>" class="sns-icon social_link sns-payco" title="페이코">
						<span class="ico"></span>
						<span class="txt">페이코로 회원가입하기</span>
					</a>
					<?php }     //end if ?>

					<?php if( G5_SOCIAL_USE_POPUP && !$social_pop_once ){
					$social_pop_once = true;
					?>
					<script>
						jQuery(function($){
							$(".sns-wrap").on("click", "a.social_link", function(e){
								e.preventDefault();

								var pop_url = $(this).attr("href");
								var newWin = window.open(
									pop_url, 
									"social_sing_on", 
									"location=0,status=0,scrollbars=1,width=600,height=500"
								);

								if(!newWin || newWin.closed || typeof newWin.closed=='undefined')
									 alert('브라우저에서 팝업이 차단되어 있습니다. 팝업 활성화 후 다시 시도해 주세요.');

								return false;
							});
						});
					</script>
					<?php } ?>

				</div>
			</div>
		</div>
	</div>
<?php } ?>

<div class="alert alert-info" role="alert">
	<strong> 회원가입약관 및 개인정보처리방침안내의 내용에 동의하셔야 회원가입 하실 수 있습니다.</strong>
</div>

<form  name="fregister" id="fregister" action="<?php echo $action_url ?>" onsubmit="return fregister_submit(this);" method="POST" autocomplete="off" class="form" role="form">
<input type="hidden" name="pim" value="<?php echo $pim;?>">
	<div class="sns-panel">		
		<div class="panel-term">
            <label class="checkbox-inline"><input type="checkbox" name="agree" value="1" id="agree11"> 서비스이용약관 동의 <a href="<?php echo G5_URL;?>/bbs/page.php?hid=provision" target="_blank">(보기)</a></label>
		</div>
		<div class="panel-term">
            <label class="checkbox-inline"><input type="checkbox" name="agree2" value="1" id="agree21" > 개인정보처리방침 동의 <a href="<?php echo G5_URL;?>/bbs/page.php?hid=privacy" target="_blank">(보기)</a></label>
		</div>
	</div>
    <div class="join-button-gr">
        <button type="submit" class="join-button">일반 회원가입</button>
        <button type="button" class="join-button" onclick="fregister_submit2(this.form);">파트너 회원가입</button>
  <script>
   function fregister_submit2(f){
    if(fregister_submit(f) == true){
     f.action='<?php echo G5_BBS_URL; ?>/register_form_partner.php';
     f.submit();
    }
   }
  </script>
</div>
</form>

<script>
    function fregister_submit(f) {
        if (!f.agree.checked) {
            alert("회원가입약관의 내용에 동의하셔야 회원가입 하실 수 있습니다.");
            f.agree.focus();
            return false;
        }

        if (!f.agree2.checked) {
            alert("개인정보처리방침안내의 내용에 동의하셔야 회원가입 하실 수 있습니다.");
            f.agree2.focus();
            return false;
        }

        return true;
    }
</script>
</div>
</div>