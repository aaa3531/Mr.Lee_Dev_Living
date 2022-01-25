<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 이름, 닉네임, 이메일 정리
$user_nick = isset($user_nick) ? get_text($user_nick) : '';
$user_name = ($user_name) ? get_text($user_name) : $user_nick;
$user_email = isset($user_email) ? $user_email : '';

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$skin_url.'/style.css">', 13);

$email_msg = $is_exists_email ? '등록할 이메일이 중복되었습니다.다른 이메일을 입력해 주세요.' : '';

if($header_skin)
	include_once('./header.php');
?>

<!-- 회원정보 입력/수정 시작 { -->
<div class="mbskin" id="register_member">

    <script src="<?php echo G5_JS_URL ?>/jquery.register_form.js"></script>
    
    <!-- 새로가입 시작 -->
    <form class="form-horizontal register-form" id="fregisterform" name="fregisterform" action="<?php echo $register_action_url; ?>" onsubmit="return fregisterform_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off">
    <input type="hidden" name="w" value="<?php echo $w; ?>">
    <input type="hidden" name="url" value="<?php echo $urlencode; ?>">
    <input type="hidden" name="provider" value="<?php echo $provider_name;?>" >
    <input type="hidden" name="action" value="register">
    <input type="hidden" name="mb_id" value="<?php echo $user_id; ?>" id="reg_mb_id">

	<div class="panel-group" id="agree_accordion" role="tablist" aria-multiselectable="true">
		<div class="panel panel-default">
			<div class="panel-heading" role="tab" id="agreeheadingOne">
				<label class="checkbox-inline pull-left">
					<input type="checkbox" name="agree" value="1" id="agree11"> 회원가입약관 동의
				</label>
				<a data-toggle="collapse" data-parent="#agree_accordion" href="#agreeOne" aria-expanded="true" aria-controls="agreeOne" class="pull-right checkbox-inline">
					<b>자세히보기</b>
				</a>
				<div class="clearfix"></div>
			</div>
			<div id="agreeOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="agreeheadingOne">
				<div class="panel-body">
					<?php if($provision) { ?>
						<div class="register-term">
							<?php echo $provision; ?>
						</div>
					<?php } else { ?>
						<textarea class="form-control input-sm" rows="10" readonly><?php echo get_text($config['cf_stipulation']) ?></textarea>
					<?php } ?>
				</div>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading" role="tab" id="agreeheadingTwo">
				<label class="checkbox-inline pull-left">
					<input type="checkbox" name="agree2" value="1" id="agree21" > 개인정보처리방침안내 동의
				</label>
				<a data-toggle="collapse" data-parent="#agree_accordion" href="#agreeTwo" aria-expanded="true" aria-controls="agreeTwo" class="pull-right checkbox-inline">
					<b>자세히보기</b>
				</a>
				<div class="clearfix"></div>
			</div>
			<div id="agreeTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="agreeheadingTwo">
				<div class="panel-body">
					<table class="table" style="border-top:0px; border-bottom:1px solid #ddd; margin-bottom:10px;">
						<colgroup>
							<col width="40%">
							<col width="30%">
						</colgroup>
						<tbody>
						<tr>
							<th style="border-top:0px;">목적</th>
							<th style="border-top:0px;">항목</th>
							<th style="border-top:0px;">보유기간</th>
						</tr>
						<tr>
							<td>이용자 식별 및 본인여부 확인</td>
							<td>아이디, 이름, 비밀번호</td>
							<td>회원 탈퇴 시까지</td>
						</tr>
						<tr>
							<td>고객서비스 이용에 관한 통지, CS대응을 위한 이용자 식별</td>
							<td>연락처 (이메일, 휴대전화번호)</td>
							<td>회원 탈퇴 시까지</td>
						</tr>
						</tbody>
					</table>
					<?php if($privacy) { ?>
						<a data-toggle="collapse" href="#privacy" aria-expanded="false" aria-controls="privacy" class="pull-right">전문보기</a>
						<div class="clearfix"></div>
						<div class="collapse" id="privacy" style="padding-top:10px;">
							<div class="register-term">
								<?php echo $privacy; ?>
							</div>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
		<div class="panel panel-info">
			<div class="panel-heading">
				<label class="checkbox-inline" for="chk_all">
					<input type="checkbox" name="chk_all" value="1" id="chk_all"> <strong>전체약관에 동의합니다.</strong>
				</label>
			</div>
		</div>
	</div>

	<div class="panel panel-default">
		<div class="panel-heading"><strong><i class="fa fa-user fa-lg"></i> 개인정보 입력</strong></div>
		<div class="panel-body">

			<div class="form-group has-feedback">
				<label class="col-sm-2 control-label" for="reg_mb_name"><b>이름</b><strong class="sound_only">필수</strong></label>
				<div class="col-sm-3">
					<input type="text" id="reg_mb_name" name="mb_name" value="<?php echo $user_name;?>" required class="form-control input-sm" size="10">
					<span class="fa fa-check form-control-feedback"></span>
				</div>
			</div>

			<div class="form-group has-feedback">
				<label class="col-sm-2 control-label" for="reg_mb_nick"><b>닉네임</b><strong class="sound_only">필수</strong></label>
				<div class="col-sm-3">
					<input type="text" name="mb_nick" value="<?php echo $user_nick; ?>" id="reg_mb_nick" required class="form-control input-sm" size="10" maxlength="20">
					<span class="fa fa-user form-control-feedback"></span>
				</div>
				<div class="col-sm-7">
					<p class="form-control-static" style="padding-bottom:0;">
						공백없이 한글,영문,숫자만 가능 (한글2자, 영문4자 이상, 가입 후 <?php echo (int)$config['cf_nick_modify'] ?>일 이내 변경 불가)
					</p>
				</div>
			</div>

			<div class="form-group has-feedback text-gap">
				<label class="col-sm-2 control-label" for="reg_mb_email"><b>E-mail</b><strong class="sound_only">필수</strong></label>
				<div class="col-sm-5">
					<input type="text" name="mb_email" value="<?php echo $user_email; ?>" id="reg_mb_email" required class="form-control input-sm email" size="70" maxlength="100" placeholder="이메일을 입력해주세요." >
					<span class="fa fa-envelope form-control-feedback"></span>
					<?php if($email_msg) { ?>
						<div class="help-block"><?php echo $email_msg; ?></div>
					<?php } ?>
				</div>
			</div>

		</div>
	</div>

	<div class="text-center" style="margin:30px 0px;">
		<button type="submit" id="btn_submit" class="btn btn-color" accesskey="s">회원가입</button>
		<a href="<?php echo G5_URL ?>" class="btn btn-black" role="button">취소</a>
	</div>

    </form>
    <!-- 새로가입 끝 -->

    <!-- 아미나 소셜계정 연결 -->
	<?php if($is_apms_social) { ?>
		<div class="well text-center">
			<p><strong>혹시 기존 소셜계정 회원이신가요?</strong></p>
			<button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#socialModal">
				<b>기존 소셜계정에 연결하기</b>
				<i class="fa fa-angle-double-right"></i>
			</button>
		</div>

		<div class="modal fade" id="socialModal" tabindex="-2" role="dialog" aria-labelledby="socialModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-sm">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h5 class="modal-title" id="socialModalLabel">기존 소셜계정에 연결하기</h5>
					</div>
					<div class="modal-body">

						<form class="form" role="form" method="post" action="<?php echo $login_action_url ?>">
						<input type="hidden" id="url" name="url" value="<?php echo $login_url ?>">
						<input type="hidden" id="provider" name="provider" value="<?php echo $provider_name ?>">
						<input type="hidden" id="action" name="action" value="social_account_linking">
						<input type="hidden" id="apms_social" name="apms_social" value="1">

						<div class="alert alert-success">
							기존 소셜계정 아이디에 SNS 아이디를 재연결합니다.<br>
							이 후 SNS 아이디로 로그인 하시면 기존 소셜계정 아이디로 로그인 할 수 있습니다.
						</div>

						<div class="form-group has-feedback">
							<label for="apms_mb_email"><b>E-mail</b><strong class="sound_only"> 필수</strong></label>
							<input type="text" name="mb_email" value="<?php echo $is_apms_email; ?>" id="apms_mb_email" required class="form-control input-sm email" size="70" maxlength="100" placeholder="이메일을 입력해주세요." >
							<span class="fa fa-envelope form-control-feedback"></span>
						</div>

						<button type="submit" class="btn btn-color btn-block">연결하기</button>

						</form>					
					</div>
				</div>
			</div>
		</div>
	<?php } ?>

	<!-- 기존 계정 연결 -->
	<div class="well text-center">
        <p><strong>혹시 기존 일반계정 회원이신가요?</strong></p>
        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#connectModal">
            <b>기존 일반계정에 연결하기</b>
            <i class="fa fa-angle-double-right"></i>
        </button>
	</div>

	<div class="modal fade" id="connectModal" tabindex="-1" role="dialog" aria-labelledby="connectModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h5 class="modal-title" id="connectModalLabel">기존 일반계정에 연결하기</h5>
				</div>
				<div class="modal-body">

					<form class="form" role="form" method="post" action="<?php echo $login_action_url ?>" onsubmit="return social_obj.flogin_submit(this);">
					<input type="hidden" id="url" name="url" value="<?php echo $login_url ?>">
					<input type="hidden" id="provider" name="provider" value="<?php echo $provider_name ?>">
					<input type="hidden" id="action" name="action" value="social_account_linking">

					<div class="alert alert-success">
						기존 일반계정 아이디에 SNS 아이디를 연결합니다.<br>
						이 후 SNS 아이디로 로그인 하시면 기존 일반계정 아이디로 로그인 할 수 있습니다.
					</div>

					<div class="form-group has-feedback">
						<label for="login_id"><b>아이디</b><strong class="sound_only"> 필수</strong></label>
						<input type="text" name="mb_id" id="login_id" required class="form-control input-sm" size="20" maxLength="20">
						<span class="fa fa-user form-control-feedback"></span>
					</div>
					<div class="form-group has-feedback">
						<label for="login_pw"><b>비밀번호</b><strong class="sound_only"> 필수</strong></label>
						<input type="password" name="mb_password" id="login_pw" required class="form-control input-sm" size="20" maxLength="20">
						<span class="fa fa-lock form-control-feedback"></span>
					</div>

					<button type="submit" class="btn btn-color btn-block">연결하기</button>

					</form>					
				</div>
			</div>
		</div>
	</div>

    <script>

    // submit 최종 폼체크
    function fregisterform_submit(f)
    {

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

        // E-mail 검사
        if ((f.w.value == "") || (f.w.value == "u" && f.mb_email.defaultValue != f.mb_email.value)) {
            var msg = reg_mb_email_check();
            if (msg) {
                alert(msg);
                jQuery(".email_msg").html(msg);
                f.reg_mb_email.select();
                return false;
            }
        }

        document.getElementById("btn_submit").disabled = "disabled";

        return true;
    }

    function flogin_submit(f)
    {
        var mb_id = $.trim($(f).find("input[name=mb_id]").val()),
            mb_password = $.trim($(f).find("input[name=mb_password]").val());

        if(!mb_id || !mb_password){
            return false;
        }

        return true;
    }

    jQuery(function($){
        // 모두선택
        $("input[name=chk_all]").click(function() {
            if ($(this).prop('checked')) {
                $("input[name^=agree]").prop('checked', true);
            } else {
                $("input[name^=agree]").prop("checked", false);
            }
        });
    });
    </script>

</div>
<!-- } 회원정보 입력/수정 끝 -->