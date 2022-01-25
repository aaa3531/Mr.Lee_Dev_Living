<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/apms.account.lib.php');

?>
<h1>스토어 정보관리</h1>
<?php 
$pt_id = $member['mb_id'];
$mb = apms_partner($pt_id);
if (!$mb['pt_id']) {
	alert('존재하지 않는 파트너입니다.');
}

if($ap == "editstore"){

	check_token();

//	//삭제시
//	if(isset($_POST['pt_del']) && $_POST['pt_del']) {
//
//		//파일 삭제
//		apms_delete_file("partner", $pt_id);
//
//		//파트너 삭제
//		sql_query(" delete from {$g5['apms_partner']} where pt_id = '$pt_id' ");
//
//		//회원정보에서 정보변경
//		sql_query(" update {$g5['member_table']} set as_partner = '0', as_marketer = '0' where mb_id = '$pt_id' ", false);
//
//		//이동하기
//		goto_url('./index.php?ap=editstore&amp;'.$qstr);
//	}

	//업데이트
    $sql = " update {$g5['member_table']}
                set   mb_3					= '{$_POST['pt_3']}'
					, mb_4					= '{$_POST['pt_4']}'
					, mb_5					= '{$_POST['pt_5']}'
					, mb_6					= '{$_POST['pt_6']}'
					, mb_7					= '{$_POST['pt_7']}'
					, mb_8					= '{$_POST['pt_8']}'
					, mb_9					= '{$_POST['pt_9']}'
					, mb_10					= '{$_POST['pt_10']}'
				where mb_id					= '{$pt_id}' ";
    sql_query($sql);

	if($_POST['pt_register']) { // 승인정보가 있을 경우
		sql_query(" update {$g5['member_table']} set as_partner = '{$_POST['pt_partner']}', as_marketer = '{$_POST['pt_marketer']}' where mb_id = '$pt_id' ", false);
	}
//    else { // 없다면
//		sql_query(" update {$g5['member_table']} set as_partner = '0', as_marketer = '0' where mb_id = '$pt_id' ", false);
//	}

//	//파일등록
//	$file_upload_msg = apms_upload_file('partner', $pt_id);
//
//	$go_url = $go_url.'&amp'.$qstr.'&amp;pt_id='.$pt_id;
//
//	if ($file_upload_msg) {
//		alert($file_upload_msg, $go_url);
//	} else {
//		goto_url($go_url);
//	}
}

$token = get_token();


$mb['pt_1'] = get_text($mb['pt_1']);
$mb['pt_2'] = get_text($mb['pt_2']);
$mb['pt_3'] = get_text($mb['pt_3']);
$mb['pt_4'] = get_text($mb['pt_4']);
$mb['pt_5'] = get_text($mb['pt_5']);
$mb['pt_6'] = get_text($mb['pt_6']);
$mb['pt_7'] = get_text($mb['pt_7']);
$mb['pt_8'] = get_text($mb['pt_8']);
$mb['pt_9'] = get_text($mb['pt_9']);
$mb['pt_10'] = get_text($mb['pt_10']);

?>

<style>
	.apms-helper { font-size:12px;font-weight:normal;color:#888; }
</style>
<form name="fmember" id="fmember" action="./index.php" onsubmit="return fmember_submit(this);" method="post" enctype="multipart/form-data">
<input type="hidden" name="ap" value="editstore">
<input type="hidden" name="mode" value="pform">
<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
<input type="hidden" name="stx" value="<?php echo $stx ?>">
<input type="hidden" name="sst" value="<?php echo $sst ?>">
<input type="hidden" name="sod" value="<?php echo $sod ?>">
<input type="hidden" name="page" value="<?php echo $page ?>">
<input type="hidden" name="token" value="<?php echo $token ?>">
<input type="hidden" name="pt_id" value="<?php echo $pt_id ?>">

<div class="tbl_frm01 tbl_wrap">
    <table>
    <colgroup>
        <col class="grid_4">
        <col>
        <col class="grid_4">
        <col>
    </colgroup>
    <tbody>
	<tr>
	<td colspan="4" style="border-top:0px;padding-left:0px;">
        <h2 class="h2_frm" style="margin:0px;padding:0px;">
			기본스토어정보
		</h2>
	</td>
	</tr>


	<tr>
        <th scope="row">스토어이름</th>
        <td><input type="text" name="pt_3" value="<?php echo $mb['pt_3'] ?>" class="frm_input" size="30"></td>
	</tr>
	<tr>
        <th scope="row">스토어소개</th>
        <td><input type="text" name="pt_4" value="<?php echo $mb['pt_4'] ?>" class="frm_input" size="30"></td>
    </tr>
    <tr>
        <th scope="row">스토어 대표 이미지1</th>
        <td><input type="text" name="pt_5" value="<?php echo $mb['pt_5'] ?>" class="frm_input" size="30"></td>
	</tr>
	<tr>
        <th scope="row">대표 소제목 1</th>
        <td><input type="text" name="pt_6" value="<?php echo $mb['pt_6'] ?>" class="frm_input" size="30"></td>
    </tr>
    <tr>
        <th scope="row">스토어 대표 이미지2</th>
        <td><input type="text" name="pt_7" value="<?php echo $mb['pt_7'] ?>" class="frm_input" size="30"></td>
	</tr>
	<tr>
        <th scope="row">대표 소제목 2</th>
        <td><input type="text" name="pt_8" value="<?php echo $mb['pt_8'] ?>" class="frm_input" size="30"></td>
    </tr>
	
	</tbody>
    </table>
</div>

<div class="btn_fixed_top">
<!--    <a href="./?ap=plist&amp;<?php echo $qstr ?>" class="btn btn_02">목록</a>-->
    <input type="submit" value="확인" class="btn_submit btn" accesskey='s'>
</div>

</form>

<script>
function fmember_submit(f) {

    return true;
}
</script>
