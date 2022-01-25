<?php
$sub_menu = '400610';
include_once('./_common.php');

auth_check($auth[$sub_menu], "r");

$doc = strip_tags($doc);

$g5['title'] = '상품유형관리';
include_once (G5_ADMIN_PATH.'/admin.head.php');

/*
$sql_search = " where 1 ";
if ($search != "") {
	if ($sel_field != "") {
    	$sql_search .= " and $sel_field like '%$search%' ";
    }
}

if ($sel_ca_id != "") {
    $sql_search .= " and (ca_id like '$sel_ca_id%' or ca_id2 like '$sel_ca_id%' or ca_id3 like '$sel_ca_id%') ";
}

if ($sel_field == "")  $sel_field = "it_name";
*/

$where = " where ";
$sql_search = "";
if ($stx != "") {
    if ($sfl != "") {
        $sql_search .= " $where $sfl like '%$stx%' ";
        $where = " and ";
    }
    if ($save_stx != $stx)
        $page = 1;
}

if ($sca != "") {
    $sql_search .= " $where (ca_id like '$sca%' or ca_id2 like '$sca%' or ca_id3 like '$sca%') ";
}

if ($sfl == "")  $sfl = "it_name";

$pts = '';
if (!$sst)  {
	$pts = 'pt_num desc,';
    $sst  = "it_id";
    $sod = "desc";
}
$sql_order = "order by $pts $sst $sod";

$sql_common = "  from {$g5['g5_shop_item_table']} ";
$sql_common .= $sql_search;

// 테이블의 전체 레코드수만 얻음
$sql = " select count(*) as cnt " . $sql_common;
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

// APMS - 2014.07.20
$sql  = " select it_id,
                 it_name,
                 it_type1,
                 it_1,
                 it_type2,
                 it_2,
                 it_type3,
                 it_3,
                 it_type4,
                 it_4,
                 it_type5,
                 it_5,
                 it_type6,
                 it_6,
                 it_type7,
                 it_7,
                 it_type8,
                 it_8,
				 ca_id,
				 pt_it,
				 pt_id
          $sql_common
          $sql_order
          limit $from_record, $rows ";
$result = sql_query($sql);

$qstr  = $qstr.'&amp;sca='.$sca.'&amp;page='.$page.'&amp;save_stx='.$stx;

$listall = '<a href="'.$_SERVER['SCRIPT_NAME'].'" class="ov_listall">전체목록</a>';
?>

<script src="<?php echo G5_ADMIN_URL;?>/apms_admin/apms.admin.js"></script>

<div class="local_ov01 local_ov">
    <?php echo $listall; ?>
	<span class="btn_ov01"><span class="ov_txt">전체 상품</span><span class="ov_num">  <?php echo $total_count; ?>개</span></span>
</div>

<form name="flist" class="local_sch01 local_sch">
<input type="hidden" name="doc" value="<?php echo $doc; ?>">
<input type="hidden" name="page" value="<?php echo $page; ?>">

<label for="sca" class="sound_only">분류선택</label>
<select name="sca" id="sca">
    <option value="">전체분류</option>
    <?php
    $sql1 = " select ca_id, ca_name, as_line from {$g5['g5_shop_category_table']} order by ca_order, ca_id ";
    $result1 = sql_query($sql1);
    for ($i=0; $row1=sql_fetch_array($result1); $i++) {
        $len = strlen($row1['ca_id']) / 2 - 1;
        $nbsp = "";
        for ($i=0; $i<$len; $i++) $nbsp .= "&nbsp;&nbsp;&nbsp;";
		if($row1['as_line']) {
			echo "<option value=\"\">".$nbsp."------------</option>\n";
		}
        echo '<option value="'.$row1['ca_id'].'" '.get_selected($sca, $row1['ca_id']).'>'.$nbsp.$row1['ca_name'].PHP_EOL;
    }
    ?>
</select>

<label for="sfl" class="sound_only">검색대상</label>
<select name="sfl" id="sfl">
    <option value="it_name" <?php echo get_selected($sfl, 'it_name'); ?>>상품명</option>
    <option value="it_id" <?php echo get_selected($sfl, 'it_id'); ?>>상품코드</option>
	<!-- APMS - 2014.07.20 -->
	    <option value="pt_id" <?php echo get_selected($sfl, 'pt_id'); ?>>파트너 아이디</option>
	<!-- // -->
</select>

<label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
<input type="text" name="stx" value="<?php echo $stx; ?>" id="stx" required class="frm_input required">
<input type="submit" value="검색" class="btn_submit">

</form>

<form name="fitemtypelist" method="post" action="./itemtypelistupdate.php">
<input type="hidden" name="sca" value="<?php echo $sca; ?>">
<input type="hidden" name="sst" value="<?php echo $sst; ?>">
<input type="hidden" name="sod" value="<?php echo $sod; ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl; ?>">
<input type="hidden" name="stx" value="<?php echo $stx; ?>">
<input type="hidden" name="page" value="<?php echo $page; ?>">

<div class="tbl_head01 tbl_wrap">
    <table>
    <caption><?php echo $g5['title']; ?> 목록</caption>
    <thead>
    <tr>
        <th scope="col"><?php echo subject_sort_link("it_id", $qstr, 1); ?>상품코드</a></th>
        <th scope="col"><?php echo subject_sort_link("it_name"); ?>상품명</a></th>
        
        <th scope="col"><?php echo subject_sort_link("it_type1", $qstr, 1); ?>스토어 종류별 랭킹</a></th>
        <th scope="col"><?php echo subject_sort_link("it_1"); ?>노출순서</a></th>
        <th scope="col"><?php echo subject_sort_link("it_type2", $qstr, 1); ?>스토어 업종별 랭킹</a></th>
        <th scope="col"><?php echo subject_sort_link("it_2"); ?>노출순서</a></th>
        <th scope="col"><?php echo subject_sort_link("it_type3", $qstr, 1); ?>렌탈 종류별 랭킹</a></th>
        <th scope="col"><?php echo subject_sort_link("it_3"); ?>노출순서</a></th>
        <th scope="col"><?php echo subject_sort_link("it_type4", $qstr, 1); ?>렌탈 업종별 랭킹</a></th>
        <th scope="col"><?php echo subject_sort_link("it_4"); ?>노출순서</a></th>
        <th scope="col"><?php echo subject_sort_link("it_type5", $qstr, 1); ?>메인 스토어 상품</a></th>
        <th scope="col"><?php echo subject_sort_link("it_5"); ?>노출순서</a></th>
        <th scope="col"><?php echo subject_sort_link("it_type6", $qstr, 1); ?>메인 렌탈 상품</a></th>
        <th scope="col"><?php echo subject_sort_link("it_6"); ?>노출순서</a></th>
        <th scope="col"><?php echo subject_sort_link("it_type7", $qstr, 1); ?>스토어 홈 상품</a></th>
        <th scope="col"><?php echo subject_sort_link("it_7"); ?>노출순서</a></th>
        <th scope="col"><?php echo subject_sort_link("it_type8", $qstr, 1); ?>렌탈 홈 상품</a></th>
        <th scope="col"><?php echo subject_sort_link("it_8"); ?>노출순서</a></th>
        <th scope="col">관리</th>
    </tr>
    </thead>
    <tbody>
    <?php for ($i=0; $row=sql_fetch_array($result); $i++) {
        $href = G5_SHOP_URL.'/item.php?it_id='.$row['it_id'];

        $bg = 'bg'.($i%2);
    ?>
    <tr class="<?php echo $bg; ?>">
		<!-- APMS - 2014.07.20 -->
        <td class="td_code" style="white-space:nowrap">
            <input type="hidden" name="it_id[<?php echo $i; ?>]" value="<?php echo $row['it_id']; ?>">
			<div style="font-size:11px; letter-spacing:-1px;"><?php echo apms_pt_it($row['pt_it'],1);?></div>
			<b><?php echo $row['it_id']; ?></b>
			<?php if($row['pt_id']) { ?>
				<div style="font-size:11px; letter-spacing:-1px;"><?php echo $row['pt_id'];?></div>
			<?php } ?>
        </td>
		<!-- // -->
		<td class="td_left"><a href="<?php echo $href; ?>"><?php echo get_it_image($row['it_id'], 50, 50); ?><?php echo cut_str(stripslashes($row['it_name']), 60, "&#133"); ?></a></td>
       
        <td class="td_chk2">
            <label for="type1_<?php echo $i; ?>" class="sound_only">스토어 종류별 랭킹</label>
            <input type="checkbox" name="it_type1[<?php echo $i; ?>]" value="1" id="type1_<?php echo $i; ?>" <?php echo ($row['it_type1'] ? 'checked' : ''); ?>>
        </td>
        <td class="td_mngsmall">
            <label for="1_<?php echo $i; ?>" class="sound_only">순서</label>
            <input type="text" name="it_1[<?php echo $i; ?>]" value="<?php echo $row['it_1']; ?>" id="1_<?php echo $i; ?>" class="frm_input" size="3">
        </td>
        <td class="td_chk2">
            <label for="type2_<?php echo $i; ?>" class="sound_only">스토어 업종별 랭킹</label>
            <input type="checkbox" name="it_type2[<?php echo $i; ?>]" value="1" id="type2_<?php echo $i; ?>" <?php echo ($row['it_type2'] ? 'checked' : ''); ?>>
        </td>
        <td class="td_mngsmall">
            <label for="2_<?php echo $i; ?>" class="sound_only">순서</label>
            <input type="text" name="it_2[<?php echo $i; ?>]" value="<?php echo $row['it_2']; ?>" id="2_<?php echo $i; ?>" class="frm_input" size="3">
        </td>
        <td class="td_chk2">
            <label for="type3_<?php echo $i; ?>" class="sound_only">렌탈 종류별 랭킹</label>
            <input type="checkbox" name="it_type3[<?php echo $i; ?>]" value="1" id="type3_<?php echo $i; ?>" <?php echo ($row['it_type3'] ? 'checked' : ''); ?>>
        </td>
        <td class="td_mngsmall">
            <label for="3_<?php echo $i; ?>" class="sound_only">순서</label>
            <input type="text" name="it_3[<?php echo $i; ?>]" value="<?php echo $row['it_3']; ?>" id="3_<?php echo $i; ?>" class="frm_input" size="3">
        </td>
        <td class="td_chk2">
            <label for="type4_<?php echo $i; ?>" class="sound_only">렌탈 업종별 랭킹</label>
            <input type="checkbox" name="it_type4[<?php echo $i; ?>]" value="1" id="type4_<?php echo $i; ?>" <?php echo ($row['it_type4'] ? 'checked' : ''); ?>>
        </td>
        <td class="td_mngsmall">
            <label for="4_<?php echo $i; ?>" class="sound_only">순서</label>
            <input type="text" name="it_4[<?php echo $i; ?>]" value="<?php echo $row['it_4']; ?>" id="4_<?php echo $i; ?>" class="frm_input" size="3">
        </td>
        <td class="td_chk2">
            <label for="type5_<?php echo $i; ?>" class="sound_only">메인 스토어 상품</label>
            <input type="checkbox" name="it_type5[<?php echo $i; ?>]" value="1" id="type5_<?php echo $i; ?>" <?php echo ($row['it_type5'] ? 'checked' : ''); ?>>
        </td>
        <td class="td_mngsmall">
            <label for="5_<?php echo $i; ?>" class="sound_only">순서</label>
            <input type="text" name="it_5[<?php echo $i; ?>]" value="<?php echo $row['it_5']; ?>" id="5_<?php echo $i; ?>" class="frm_input" size="3">
        </td>
        <td class="td_chk2">
            <label for="type6_<?php echo $i; ?>" class="sound_only">메인 렌탈 상품</label>
            <input type="checkbox" name="it_type6[<?php echo $i; ?>]" value="1" id="type6_<?php echo $i; ?>" <?php echo ($row['it_type6'] ? 'checked' : ''); ?>>
        </td>
        <td class="td_mngsmall">
            <label for="6_<?php echo $i; ?>" class="sound_only">순서</label>
            <input type="text" name="it_6[<?php echo $i; ?>]" value="<?php echo $row['it_6']; ?>" id="6_<?php echo $i; ?>" class="frm_input" size="3">
        </td>
        <td class="td_chk2">
            <label for="type7_<?php echo $i; ?>" class="sound_only">스토어 홈 상품</label>
            <input type="checkbox" name="it_type7[<?php echo $i; ?>]" value="1" id="type7_<?php echo $i; ?>" <?php echo ($row['it_type7'] ? 'checked' : ''); ?>>
        </td>
        <td class="td_mngsmall">
            <label for="7_<?php echo $i; ?>" class="sound_only">순서</label>
            <input type="text" name="it_7[<?php echo $i; ?>]" value="<?php echo $row['it_7']; ?>" id="7_<?php echo $i; ?>" class="frm_input" size="3">
        </td>
        <td class="td_chk2">
            <label for="type8_<?php echo $i; ?>" class="sound_only">렌탈 홈 상품</label>
            <input type="checkbox" name="it_type8[<?php echo $i; ?>]" value="1" id="type8_<?php echo $i; ?>" <?php echo ($row['it_type8'] ? 'checked' : ''); ?>>
        </td>
         <td class="td_mngsmall">
            <label for="8_<?php echo $i; ?>" class="sound_only">순서</label>
            <input type="text" name="it_8[<?php echo $i; ?>]" value="<?php echo $row['it_8']; ?>" id="8_<?php echo $i; ?>" class="frm_input" size="3">
        </td>
        <td class="td_mng td_mng_s">
            <a href="./itemform.php?w=u&amp;it_id=<?php echo $row['it_id']; ?>&amp;ca_id=<?php echo $row['ca_id']; ?>&amp;<?php echo $qstr; ?>" class="btn btn_03"><span class="sound_only"><?php echo cut_str(stripslashes($row['it_name']), 60, "&#133"); ?> </span>수정</a>
         </td>
    </tr>
    <?php
    }

    if (!$i)
        echo '<tr><td colspan="8" class="empty_table"><span>자료가 없습니다.</span></td></tr>';
    ?>
    </tbody>
    </table>
</div>

<div class="btn_fixed_top">
    <input type="submit" value="일괄수정" class="btn_submit btn">
</div>
</form>

<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, "{$_SERVER['SCRIPT_NAME']}?$qstr&amp;page="); ?>

<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>
