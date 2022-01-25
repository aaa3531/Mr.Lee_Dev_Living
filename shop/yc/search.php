<?php
include_once('./_common.php');
 
if(USE_G5_THEME && defined('G5_THEME_PATH')) {
    require_once(G5_SHOP_PATH.'/yc/search.php');
    return;
}
 
// QUERY 문에 공통적으로 들어가는 내용
// 상품명에 검색어가 포한된것과 상품판매가능인것만
$sql_common = " from {$g5['g5_shop_item_table']} a, {$g5['g5_shop_category_table']} b ";
 
$where = array();
$where[] = " (a.ca_id = b.ca_id and a.it_use = 1 and b.ca_use = 1) ";
 
$search_all = true;
// 상세검색 이라면
if (isset($_GET['qname']) || isset($_GET['qexplan']) || isset($_GET['qid']) || isset($_GET['qtag']))
    $search_all = false;
 
$q = ($stx) ? $stx : $_GET['q'];
$qname  = isset($_GET['qname']) ? trim($_GET['qname']) : '';
$qexplan = isset($_GET['qexplan']) ? trim($_GET['qexplan']) : '';
$qid    = isset($_GET['qid']) ? trim($_GET['qid']) : '';
$qtag    = isset($_GET['qtag']) ? trim($_GET['qtag']) : '';
$qcaid  = isset($_GET['qcaid']) ? preg_replace('#[^a-z0-9]#i', '', trim($_GET['qcaid'])) : '';
$qfrom  = isset($_GET['qfrom']) ? preg_replace('/[^0-9]/', '', trim($_GET['qfrom'])) : '';
$qto    = isset($_GET['qto']) ? preg_replace('/[^0-9]/', '', trim($_GET['qto'])) : '';
if (isset($_GET['qsort']))  {
    $qsort = trim($_GET['qsort']);
    $qsort = preg_replace("/[\<\>\'\"\\\'\\\"\%\=\(\)\s]/", "", $qsort);
} else {
    $qsort = '';
}
if (isset($_GET['qorder']))  {
    $qorder = preg_match("/^(asc|desc)$/i", $qorder) ? $qorder : '';
} else {
    $qorder = '';
}
 
if(!($qname || $qexplan || $qid || $qtag))
    $search_all = true;
 
// 검색범위 checkbox 처리
$qname_check = false;
$qexplan_check = false;
$qid_check = false;
$qtag_check = false;
 
if($search_all) {
    $qname_check = true;
    $qexplan_check = true;
    $qid_check = true;
    $qtag_check = true;
} else {
    if($qname)
        $qname_check = true;
    if($qexplan)
        $qexplan_check = true;
    if($qid)
        $qid_check = true;
    if($qtag)
        $qtag_check = true;
}
 
if ($q) {
    $arr = explode(" ", $q);
    $detail_where = array();
    for ($i=0; $i<count($arr); $i++) {
        $word = trim($arr[$i]);
        if (!$word) continue;
 
        $concat = array();
        if ($search_all || $qname)
            $concat[] = "a.it_name";
        if ($search_all || $qexplan)
            $concat[] = "a.it_explan2";
        if ($search_all || $qid)
            $concat[] = "a.it_id";
        if ($search_all || $qtag)
            $concat[] = "a.pt_tag";
$concat_fields = "concat(".implode(",' ',",$concat).")";
 
        $detail_where[] = $concat_fields." like '%$word%' ";
 
        // 인기검색어
insert_popular($concat, $word);
 
}
 
    $where[] = "(".implode(" and ", $detail_where).")";
}
 
// 분류
$ca_qstr = '';
if ($qcaid) {
    $where[] = " a.ca_id like '$qcaid%' ";
$ca_qstr .= '&amp;ca_id='.urlencode($qcaid);
}
 
if ($qfrom && $qto)
    $where[] = " a.it_price between '$qfrom' and '$qto' ";
 
$sql_where = " where " . implode(" and ", $where);
 
// 상품 출력순서가 있다면
$qsort  = strtolower($qsort);
$qorder = strtolower($qorder);
 
// 아래의 $qsort 필드만 정렬이 가능하게 하여 다른 필드로 하여금 유추해 볼수 없게함
if (($qsort == "it_sum_qty" || $qsort == "it_price" || $qsort == "it_use_avg" || $qsort == "it_use_cnt" || $qsort == "it_update_time" || $qsort == "pt_good" || $qsort == "pt_comment") &&
    ($qorder == "asc" || $qorder == "desc")) {
    $order_by = ' order by ' . $qsort . ' ' . $qorder . ' , it_order, pt_num desc, it_id desc';
} else {
    $order_by = ' order by it_order, pt_num desc, it_id desc';
}
 
// 분류
$category = array();
 
$sql = " select b.ca_id, b.ca_name, count(*) as cnt $sql_common $sql_where group by b.ca_id order by b.ca_id ";
$result = sql_query($sql);
for ($i=0; $row=sql_fetch_array($result); $i++) {
$category[$i] = $row;
}
 
// Page ID
$pid = ($pid) ? $pid : 'isearch';
$at = apms_page_thema($pid);
include_once(G5_LIB_PATH.'/apms.thema.lib.php');
 
// 리스트
$list = array();
$skin_row = array();
$skin_row = apms_rows('search_'.MOBILE_.'set');
$skin_name = $default['de_'.MOBILE_.'search_list_skin'];
$thumb_w = $default['de_'.MOBILE_.'search_img_width'];
$thumb_h = $default['de_'.MOBILE_.'search_img_height'];
$list_mods = $default['de_'.MOBILE_.'search_list_mod'];
$list_rows = $default['de_'.MOBILE_.'search_list_row'];
 
// 스킨설정
$wset = array();
if($skin_row['search_'.MOBILE_.'set']) {
$wset = apms_unpack($skin_row['search_'.MOBILE_.'set']);
}
 
// 데모
if($is_demo) {
@include ($demo_setup_file);
}
 
$skin_path = G5_SKIN_PATH.'/apms/search/'.$skin_name;
$skin_url = G5_SKIN_URL.'/apms/search/'.$skin_name;
 
// 스킨 체크
list($skin_path, $skin_url) = apms_skin_thema('shop/search', $skin_path, $skin_url);
 
// 설정값 불러오기
$is_search_sub = false;
@include_once($skin_path.'/config.skin.php');
 
if(!$list_mods) $list_mods = 3;
if(!$list_rows) $list_rows = 1;
 
$items = $list_mods * $list_rows;
 
// 페이지가 없으면 첫 페이지 (1 페이지)
if ($page < 1) $page = 1;
 
// 시작 레코드 구함
$from_record = ($page - 1) * $items;
 
// 검색된 내용이 몇행인지를 얻는다
$sql = " select COUNT(*) as cnt $sql_common $sql_where ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];
$total_page  = ceil($total_count / $items); // 전체 페이지 계산
 
$num = $total_count - ($page - 1) * $items;
$result = sql_query(" select * $sql_common $sql_where {$order_by} limit $from_record, $items ");
for ($i=0; $row=sql_fetch_array($result); $i++) {
$list[$i] = $row;
$list[$i]['href'] = './item.php?it_id='.$row['it_id'].$ca_qstr;
$list[$i]['num'] = $num;
$num--;
}
 
$admin_href = ($is_admin) ? G5_ADMIN_URL.'/shop_admin/configform.php#anc_scf_etc' : '';
 
$write_pages = G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'];
 
if($search_all) {
$qname = $qexplan = $qid = $qtag = 1;
}
$query_string = 'ca_id='.$ca_id.'&amp;q='.urlencode($q);
$query_string .= '&amp;qname='.$qname.'&amp;qexplan='.$qexplan.'&amp;qid='.$qid.'&amp;qtag='.$qtag;
if($qcaid) $query_string .= '&amp;qcaid='.$qcaid;
if($qfrom && $qto) $query_string .= '&amp;qfrom='.$qfrom.'&amp;qto='.$qto;
$query_string .='&amp;qsort='.$qsort.'&amp;qorder='.$qorder;
 
$list_page = $_SERVER['SCRIPT_NAME'].'?'.$query_string.'&amp;page=';
 
$g5['title'] = "상품검색";
 
if($is_search_sub) {
include_once(G5_PATH.'/head.sub.php');
if(!USE_G5_THEME) @include_once(THEMA_PATH.'/head.sub.php');
} else {
include_once('./_head.php');
}
 
$lm = 'search'; // 리스트 모드
$ls = $skin_name; // 리스트 스킨
 
// 셋업
$setup_href = '';
if (is_file($skin_path.'/setup.skin.php') && ($is_demo || $is_designer)) {
    $setup_href = './skin.setup.php?skin=search&amp;name='.urlencode($ls).'&amp;ts='.urlencode(THEMA);
}
 
include_once($skin_path.'/search.skin.php');
 
 
 
//////////////////////////////////////////////////////////////////////////////////////////////////
$stx=$q;
$tmp_gr_id = $gr_id;
 
if(!$sfl) $sfl = 'wr_subject||wr_content';
 
// Page ID
$pid = ($pid) ? $pid : 'search';
$at = apms_page_thema($pid);
include_once(G5_LIB_PATH.'/apms.thema.lib.php');
 
// 스킨 체크
list($search_skin_path, $search_skin_url) = apms_skin_thema('search', $search_skin_path, $search_skin_url);
 
// 설정값 불러오기
$is_search_sub = false;
@include_once($search_skin_path.'/config.skin.php');
 
$g5['title'] = '전체검색 결과';
 
 
 
$skin_path = $search_skin_path;
$skin_url = $search_skin_url;
 
$gr_id = $tmp_gr_id;
 
$bo_list = array();
$search_table = Array();
$table_index = 0;
$write_pages = "";
$text_stx = "";
$srows = 0;
 
$stx = strip_tags($stx);
//$stx = preg_replace('/[[:punct:]]/u', '', $stx); // 특수문자 제거
$stx = get_search_string($stx); // 특수문자 제거
if ($stx) {
    $stx = preg_replace('/\//', '\/', trim($stx));
    $sop = strtolower($sop);
    if (!$sop || !($sop == 'and' || $sop == 'or')) $sop = 'and'; // 연산자 and , or
    $srows = isset($_GET['srows']) ? (int)preg_replace('#[^0-9]#', '', $_GET['srows']) : 10;
    if (!$srows) $srows = 10; // 한페이지에 출력하는 검색 행수
 
    $g5_search['tables'] = Array();
    $g5_search['read_level'] = Array();
$sql = " select gr_id, bo_table, bo_read_level, as_grade, as_equal, as_min, as_max from {$g5['board_table']} where bo_use_search <> '0' and bo_use_search <= '{$member['mb_level']}' and bo_list_level <= '{$member['mb_level']}' ";
    if ($gr_id)
        $sql .= " and gr_id = '{$gr_id}' ";
    $onetable = isset($onetable) ? $onetable : "";
    if ($onetable) // 하나의 게시판만 검색한다면
        $sql .= " and bo_table = '{$onetable}' ";
    $sql .= " order by bo_order, gr_id, bo_table ";
    $result = sql_query($sql);
    for ($i=0; $row=sql_fetch_array($result); $i++)
    {
        if ($is_admin != 'super')
        {
// 메뉴접근에 따른 검색차단
if(apms_auth($row['as_grade'], $row['as_equal'], $row['as_min'], $row['as_max'], 1)) {
continue;
}

// 그룹접근 사용에 대한 검색 차단
            $sql2 = " select gr_use_access, gr_admin, as_show, as_grade, as_equal, as_min, as_max from {$g5['group_table']} where gr_id = '{$row['gr_id']}' ";
            $row2 = sql_fetch($sql2);
            // 그룹접근을 사용한다면
if (!$row2['as_show']) {
continue;
            } else if (apms_auth($row2['as_grade'], $row2['as_equal'], $row2['as_min'], $row2['as_max'], 1)) {
continue;
} else if ($row2['gr_use_access']) {
                // 그룹관리자가 있으며 현재 회원이 그룹관리자라면 통과
                if ($row2['gr_admin'] && $row2['gr_admin'] == $member['mb_id']) {
                    ;
                } else {
                    $sql3 = " select count(*) as cnt from {$g5['group_member_table']} where gr_id = '{$row['gr_id']}' and mb_id = '{$member['mb_id']}' and mb_id <> '' ";
                    $row3 = sql_fetch($sql3);
                    if (!$row3['cnt'])
                        continue;
                }
}
        }
        $g5_search['tables'][] = $row['bo_table'];
        $g5_search['read_level'][] = $row['bo_read_level'];
    }
 
    $search_query = 'sfl='.urlencode($sfl).'&amp;stx='.urlencode($stx).'&amp;sop='.$sop;
 
 
    $text_stx = get_text(stripslashes($stx));
 
    $op1 = '';
 
    // 검색어를 구분자로 나눈다. 여기서는 공백
    $s = explode(' ', strip_tags($stx));
 
    // 검색필드를 구분자로 나눈다. 여기서는 +
    $field = explode('||', trim($sfl));
 
    $str = '(';
    for ($i=0; $i<count($s); $i++) {
        if (trim($s[$i]) == '') continue;
 
        $search_str = $s[$i];
 
        // 인기검색어
        insert_popular($field, $search_str);
 
        $str .= $op1;
        $str .= "(";
 
        $op2 = '';
        // 필드의 수만큼 다중 필드 검색 가능 (필드1+필드2...)
        for ($k=0; $k<count($field); $k++) {
            $str .= $op2;
            switch ($field[$k]) {
                case 'mb_id' :
                case 'wr_name' :
                    $str .= "$field[$k] = '$s[$i]'";
                    break;
                case 'wr_subject' :
                case 'wr_content' :
                    if (preg_match("/[a-zA-Z]/", $search_str))
                        $str .= "INSTR(LOWER({$field[$k]}), LOWER('{$search_str}'))";
                    else
                        $str .= "INSTR({$field[$k]}, '{$search_str}')";
                    break;
                default :
                    $str .= "1=0"; // 항상 거짓
                    break;
            }
            $op2 = " or ";
        }
        $str .= ")";
 
        $op1 = " {$sop} ";
 
    }
    $str .= ")";
 
    $sql_search = $str;
 
    $str_board_list = "";
    $board_count = 0;
 
    $time1 = get_microtime();
 
$z = 0;
    $total_count = 0;
    for ($i=0; $i<count($g5_search['tables']); $i++) {
        $tmp_write_table  = $g5['write_prefix'] . $g5_search['tables'][$i];
 
        //$sql = " select wr_id from {$tmp_write_table} where {$sql_search} ";
        //$result = sql_query($sql, false);
        //$row['cnt'] = @sql_num_rows($result);
 
        $sql = " select count(wr_id) as cnt from {$tmp_write_table} where {$sql_search} ";
        $result = sql_fetch($sql, false);
        $row['cnt'] = (int)$result['cnt'];
 
        $total_count += $row['cnt'];
        if ($row['cnt']) {
            $board_count++;
            $search_table[] = $g5_search['tables'][$i];
            $read_level[]  = $g5_search['read_level'][$i];
            $search_table_count[] = $total_count;
 
            $sql2 = " select bo_subject, bo_mobile_subject from {$g5['board_table']} where bo_table = '{$g5_search['tables'][$i]}' ";
            $row2 = sql_fetch($sql2);
            $sch_class = "";
            $sch_all = "";
            if ($onetable == $g5_search['tables'][$i]) {
$sch_class = "class=sch_on";
            } else {
$sch_all = "class=sch_on";
            $bo_list[$z]['href'] = $_SERVER['SCRIPT_NAME'].'?'.$search_query.'&amp;gr_id='.$gr_id.'&amp;onetable='.$g5_search['tables'][$i];
$bo_list[$z]['name'] = (G5_IS_MOBILE && $row2['bo_mobile_subject']) ? $row2['bo_mobile_subject'] : $row2['bo_subject'];
$bo_list[$z]['cnt'] = $row['cnt'];
$z++;
}
            $str_board_list .= '<li><a href="'.$_SERVER['SCRIPT_NAME'].'?'.$search_query.'&amp;gr_id='.$gr_id.'&amp;onetable='.$g5_search['tables'][$i].'" '.$sch_class.'><strong>'.((G5_IS_MOBILE && $row2['bo_mobile_subject']) ? $row2['bo_mobile_subject'] : $row2['bo_subject']).'</strong><span class="cnt_cmt">'.$row['cnt'].'</span></a></li>';
}
    }
 
    $rows = $srows;
    $total_page = ceil($total_count / $rows);  // 전체 페이지 계산
    if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
    $from_record = ($page - 1) * $rows; // 시작 열을 구함
 
    for ($i=0; $i<count($search_table); $i++) {
        if ($from_record < $search_table_count[$i]) {
            $table_index = $i;
            $from_record = $from_record - $search_table_count[$i-1];
            break;
        }
    }
 
    $bo_subject = array();
    $list = array();
 
    $k=0;
    for ($idx=$table_index; $idx<count($search_table); $idx++) {
        $sql = " select bo_subject, bo_mobile_subject from {$g5['board_table']} where bo_table = '{$search_table[$idx]}' ";
        $row = sql_fetch($sql);
        $bo_subject[$idx] = ((G5_IS_MOBILE && $row['bo_mobile_subject']) ? $row['bo_mobile_subject'] : $row['bo_subject']);
 
        $tmp_write_table = $g5['write_prefix'] . $search_table[$idx];
 
        $sql = " select * from {$tmp_write_table} where {$sql_search} order by wr_id desc limit {$from_record}, {$rows} ";
        $result = sql_query($sql);
        for ($i=0; $row=sql_fetch_array($result); $i++) {
            // 검색어까지 링크되면 게시판 부하가 일어남
            $list[$idx][$i] = $row;
            $list[$idx][$i]['href'] = './board.php?bo_table='.$search_table[$idx].'&amp;wr_id='.$row['wr_parent'];
 
            if ($row['wr_is_comment'])
            {
                $sql2 = " select wr_subject, wr_option from {$tmp_write_table} where wr_id = '{$row['wr_parent']}' ";
                $row2 = sql_fetch($sql2);
                //$row['wr_subject'] = $row2['wr_subject'];
                $row['wr_subject'] = get_text($row2['wr_subject']);
            }
 
            $subject = apms_get_text($row['wr_subject']);
            if (strstr($sfl, 'wr_subject'))
                $subject = search_font($stx, $subject);
 
            if ($read_level[$idx] <= $member['mb_level']) {
 
// 비밀글은 검색 불가
if (strstr($row['wr_option'].$row2['wr_option'], 'secret')) {
$content = '[비밀글 입니다.]';
} else {
// 확장 데이터
if($row['as_extend']) {
$wr_extend = apms_unpack($row['wr_content']);
$content = $wr_extend['content'];
unset($wr_extend);
} else {
$content = $row['wr_content'];
}

//$content = cut_str(strip_tags($row['wr_content']), 300, "…");
$content = apms_cut_text($content, 300);
$content = str_replace('&nbsp;', ' ', $content);
 
if (strstr($sfl, 'wr_content'))
$content = search_font($stx, $content);
}
} else {
                $content = '[열람권한이 없습니다.]';
}
 
$list[$idx][$i]['bo_table'] = $search_table[$idx];
            $list[$idx][$i]['subject'] = $subject;
            $list[$idx][$i]['content'] = $content;
            $list[$idx][$i]['name'] = apms_sideview($row['mb_id'], get_text(cut_str($row['wr_name'], $config['cf_cut_name'])), $row['wr_email'], $row['wr_homepage'], $row['as_level']);
            $list[$idx][$i]['date'] = strtotime($row['wr_datetime']);
 
            $k++;
            if ($k >= $rows)
                break;
        }
        sql_free_result($result);
 
        if ($k >= $rows)
            break;
 
        $from_record = 0;
    }
 
    $write_pages = get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'].'?'.$search_query.'&amp;gr_id='.$gr_id.'&amp;srows='.$srows.'&amp;onetable='.$onetable.'&amp;page=');
    $write_page_rows = (G5_IS_MOBILE) ? $config['cf_mobile_pages'] : $config['cf_write_pages'];
$list_page = $_SERVER['SCRIPT_NAME'].'?'.$search_query.'&amp;gr_id='.$gr_id.'&amp;srows='.$srows.'&amp;onetable='.$onetable.'&amp;page=';
}
 
$group_option = '';
$sql = " select gr_id, gr_subject, as_grade, as_equal, as_min, as_max from {$g5['group_table']} where as_show <> '0' order by gr_order, gr_id ";
$result = sql_query($sql);
for ($i=0; $row=sql_fetch_array($result); $i++) {
if(apms_auth($row['as_grade'], $row['as_equal'], $row['as_min'], $row['as_max'], 1)) {
continue;
}
$group_option .= "<option value=\"".$row['gr_id']."\"".get_selected($_GET['gr_id'], $row['gr_id']).">".$row['gr_subject']."</option>";
}
 
$group_select = '<label for="gr_id" class="sound_only">게시판 그룹선택</label><select name="gr_id" id="gr_id" class="select"><option value="">전체 분류';
$group_select .= $group_option;
$group_select .= '</select>';
 
if (!$sfl) $sfl = 'wr_subject';
if (!$sop) $sop = 'or';
 
// 스킨설정
$wset = (G5_IS_MOBILE) ? apms_skin_set('search_mobile') : apms_skin_set('search');
 
$setup_href = '';
if(is_file($skin_path.'/setup.skin.php') && ($is_demo || $is_designer)) {
$setup_href = './skin.setup.php?skin=search&amp;ts='.urlencode(THEMA);
}
 
include_once($skin_path.'/search.skin.php');
//////////////////////////////////////////////////////////////////////////////////////////////////
 
 
 
 
if($is_search_sub) {
if(!USE_G5_THEME) @include_once(THEMA_PATH.'/tail.sub.php');
include_once(G5_PATH.'/tail.sub.php');
} else {
include_once('./_tail.php');
}
?>