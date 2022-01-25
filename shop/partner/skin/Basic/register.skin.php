<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가 

add_stylesheet('<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,400italic,700,800" type="text/css">',0);
add_stylesheet('<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Raleway:300,200,100" type="text/css">',0);
add_stylesheet('<link rel="stylesheet" href="'.$skin_url.'/assets/css/bootstrap.min.css" type="text/css" media="screen">',0);
add_stylesheet('<link rel="stylesheet" href="'.$skin_url.'/style.css" type="text/css" media="screen">',0);
if(!defined('THEMA_PATH')) {
	include_once(G5_LIB_PATH.'/apms.thema.lib.php');
}

if(USE_G5_THEME && defined('G5_THEME_PATH')) {
    require_once(G5_THEME_PATH.'/head.php');
    return;
}

//Change Mode
$as_href['pc_mobile'] = (G5_DEVICE_BUTTON_DISPLAY) ? get_device_change_url() : '';

// Page Iframe Modal
if(APMS_PIM || $is_layout_sub) {
	include_once(G5_PATH.'/head.sub.php');
	@include_once(THEMA_PATH.'/head.sub.php');
	return;
}

// Head Sub
include_once(G5_PATH.'/head.sub.php');
include_once(G5_LIB_PATH.'/latest.lib.php');

// Thema Preview
if($is_designer) {
	if (defined('THEMA_PREVIEW')) {
		echo '<div class="hidden-xs font-12" style="position:fixed; left:0; bottom:100px; z-index:1000;"><a class="btn_admin" href="'.G5_URL.'/?pv=1"><span class="white">미리보기 해제</span></a></div>';
	}
}

$page_title = apms_fa($page_title);
$page_desc = apms_fa($page_desc);

$menu = apms_auto_menu();
$menu = apms_multi_menu($menu, $at['id'], $at['multi']);

if($is_member) thema_member();

//Statistics
$stats = apms_stats();

if($is_main && !$hid && !$gid ) {
	$newwin_path = (G5_IS_MOBILE) ? G5_MOBILE_PATH : G5_BBS_PATH;
	@include_once ($newwin_path.'/newwin.inc.php'); // 팝업레이어
}

if(IS_YC) {
	if(IS_SHOP) {
		if(file_exists(THEMA_PATH.'/shop.head.php')) {
			include_once(THEMA_PATH.'/shop.head.php');
		} else {
			include_once(THEMA_PATH.'/head.php');
		}
	} else {
		if(file_exists(THEMA_PATH.'/head.php')) {
			include_once(THEMA_PATH.'/head.php');
		} else {
			include_once(THEMA_PATH.'/shop.head.php');
		}
	}	
} else {
	include_once(THEMA_PATH.'/head.php');
}
?>
<style>
	html { width:100%; height:100%; }
	body { width:100%; height:100%; }
</style>
<div id="sub-wrapper" class="sub-container">
	<div class="box-register">
		<div class="box-block">
			<div class="header">							
				<h3 class="text-center">파트너 등록</h3>
			</div>
			<form class="form" role="form" name="fregister" id="fregister" action="<?php echo $action_url ?>" onsubmit="return fregister_submit(this);" method="POST" enctype="multipart/form-data" autocomplete="off">
			<div class="content" style="padding-bottom:20px;">
				<div class="form-group">
					<textarea class="form-control input-sm" rows="8" readonly><?php echo $partner_stipulation; ?></textarea>
				</div>

				<?php if($is_seller && $is_marketer) { ?>
					<div class="form-group text-center">
						<label><input type="checkbox" name="pt_partner" value="1"> 판매자(셀러) 신청</label>
						&nbsp; &nbsp; &nbsp;
						<label><input type="checkbox" name="pt_marketer" value="1"> 추천인(마케터) 신청</label>
					</div>
				<?php } else if($is_seller) { ?>
					<input type="hidden" name="pt_partner" value="1">
					<input type="hidden" name="pt_marketer" value="0">
				<?php } else if($is_marketer) { ?>
					<input type="hidden" name="pt_partner" value="0">
					<input type="hidden" name="pt_marketer" value="1">
				<?php } ?>

				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label for="pt_type"><b>파트너 유형</b><strong class="sound_only"> 필수</strong></label>
							<select name="pt_type" required class="form-control input-sm">
								<option value="">파트너 유형을 선택해 주세요.</option>
								<?php if($is_company) { ?>
									<option value="1">기업 파트너</option>
								<?php } ?>
								<?php if($is_personal) { ?>
									<option value="2">개인 파트너</option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group has-feedback">
							<label for="pt_name"><b>담당자 이름</b><strong class="sound_only"> 필수</strong></label>
							<input type="text" name="pt_name" id="pt_name" class="form-control input-sm" required placeholder="실명입력">
							<span class="fa fa-user form-control-feedback"></span>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-sm-6">
						<div class="form-group has-feedback">
							<label for="pt_hp"><b>담당자 연락처</b><strong class="sound_only"> 필수</strong></label>
							<input type="text" name="pt_hp" id="pt_hp" class="form-control input-sm" required placeholder="대표전화 또는 핸드폰 번호입력">
							<span class="fa fa-phone form-control-feedback"></span>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group has-feedback">
							<label for="pt_email"><b>담당자 이메일</b><strong class="sound_only"> 필수</strong></label>
							<input type="text" name="pt_email" id="pt_email" class="form-control input-sm" required placeholder="이메일 주소입력">
							<span class="fa fa-envelope form-control-feedback"></span>
						</div>
					</div>
				</div>
				
				<div class="well well-sm" style="margin-bottom:10px;">
					사업자등록증(기업) 또는 신분증(개인) 사본과 입금 통장사본을 스캔하여 반드시 첨부해 주셔야 출금신청을 할 수 있습니다.
				</div>

				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label><b>서류사본</b><strong class="sound_only">필수</strong></label>
							<input type="file" name="pf_file[]" class="form-control input-sm" required title="사업자등록증 또는 신분증 사본 : 용량 <?php echo $upload_max_filesize; ?> 이하만 업로드 가능">
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label><b>통장사본</b><strong class="sound_only">필수</strong></label>
							<input type="file" name="pf_file[]" class="form-control input-sm" required title="입금 통장사본 : 용량 <?php echo $upload_max_filesize; ?> 이하만 업로드 가능">
						</div>			
					</div>
				</div>
				
				<div class="form-group">
					<label>
						<input type="checkbox" name="agree" value="1" id="agree11"> 파트너가입약관과 상기 정보제공에 동의합니다.
					</label>
				</div>
				<div class="form-group">
					<button type="submit" class="btn btn-primary btn-block btn-lg">파트너 신청하기</button>
				</div>
			</div>
			</form>
		</div>
	</div> 
</div>

<script>
    function fregister_submit(f) {
        if (!f.agree.checked) {
            alert("파트너가입약관과 정보제공에 동의하셔야 가입하실 수 있습니다.");
            f.agree.focus();
            return false;
        }
		<?php if($is_seller && $is_marketer) { ?>
        if (!f.pt_partner.checked && !f.pt_marketer.checked) {
            alert("판매자 또는 추천인 중 하나를 선택하셔야 가입하실 수 있습니다.");
            f.pt_partner.focus();
            return false;
        }
		<?php } ?>
		<?php if($use_company && $use_personal) { ?>
			var type = false;
			for(var i=0;i<f.pt_type.length;i++) {
				if(f.pt_type[i].checked == true) {
					type = true;
					break;
				}
			}
			if (!type) {
	            alert("등록할 파트너 유형을 선택해 주세요.");
				return false;
		    }
		<?php } ?>

		//이메일
		var regex = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
		if(regex.test(f.pt_email.value) === false) {  
			alert("잘못된 이메일 형식입니다.");  
            f.pt_email.focus();
			return false;  
		}

		if (confirm("파트너 등록을 신청하시겠습니까?")) {
			f.action = "<?php echo $action_url;?>";
			return true;
		}

		return false;
    }
</script>

<!-- JavaScript -->
<script type="text/javascript" src="<?php echo $skin_url;?>/assets/js/bootstrap.min.js"></script>
<?php
if(IS_SHOP) echo '<script src="'.G5_JS_URL.'/sns.js"></script>'.PHP_EOL;

if(USE_G5_THEME && defined('G5_THEME_PATH')) {
    require_once(G5_THEME_PATH.'/tail.php');
    return;
}

if (isset($config['cf_analytics']) && $config['cf_analytics']) {
    echo $config['cf_analytics'];
}

// Page Iframe Modal
if(APMS_PIM || $is_layout_sub) {
	@include_once(THEMA_PATH.'/tail.sub.php');
	include_once(G5_PATH.'/tail.sub.php');
	return;
}

if(IS_SHOP) {
	if(file_exists(THEMA_PATH.'/shop.tail.php')) {
		include_once(THEMA_PATH.'/shop.tail.php');
	} else {
		include_once(THEMA_PATH.'/tail.php');
	}
} else {
	if(file_exists(THEMA_PATH.'/tail.php')) {
		include_once(THEMA_PATH.'/tail.php');
	} else {
		include_once(THEMA_PATH.'/shop.tail.php');
	}
}	

include_once(G5_PATH."/tail.sub.php");
?>