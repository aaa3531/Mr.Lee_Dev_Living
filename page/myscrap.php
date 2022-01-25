<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once('./header.php');
if (!$is_member)
    alert_close('회원만 조회하실 수 있습니다.');

$sql_common = " from {$g5['scrap_table']} where mb_id = '{$member['mb_id']}' ";
$sql_order = " order by ms_id desc ";

$sql = " select count(*) as cnt $sql_common ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$list = array();

$sql = " select *
            $sql_common
            $sql_order
            limit $from_record, $rows ";
$result = sql_query($sql);
for ($i=0; $row=sql_fetch_array($result); $i++) {

    $list[$i] = $row;

    // 순차적인 번호 (순번)
    $num = $total_count - ($page - 1) * $rows - $i;

    // 게시판 제목
    $sql2 = " select bo_subject from {$g5['board_table']} where bo_table = '{$row['bo_table']}' ";
    $row2 = sql_fetch($sql2);
    if (!$row2['bo_subject']) $row2['bo_subject'] = '[게시판 없음]';

    // 게시물 제목
    $tmp_write_table = $g5['write_prefix'] . $row['bo_table'];
    $sql3 = " select wr_subject from $tmp_write_table where wr_id = '{$row['wr_id']}' ";
    $row3 = sql_fetch($sql3, FALSE);
    $subject = ($row3['wr_subject']) ? get_text(cut_str($row3['wr_subject'], 100)) : '글이 없습니다.';

    $list[$i]['num'] = $num;
    $list[$i]['opener_href'] = '/bbs/board.php?bo_table='.$row['bo_table'];
    $list[$i]['opener_href_wr_id'] = '/bbs/board.php?bo_table='.$row['bo_table'].'&amp;wr_id='.$row['wr_id'];
    $list[$i]['bo_subject'] = $row2['bo_subject'];
    $list[$i]['subject'] = $subject;
    $list[$i]['del_href'] = '/bbs/scrap_delete.php?ms_id='.$row['ms_id'].'&amp;page='.$page;
}

$write_page_rows = (G5_IS_MOBILE) ? $config['cf_mobile_pages'] : $config['cf_write_pages'];
$list_page = $_SERVER['PHP_SELF'].'?'.$qstr.'&amp;page=';

// Page ID
$pid = ($pid) ? $pid : '';
$at = apms_page_thema($pid);
include_once(G5_LIB_PATH.'/apms.thema.lib.php');

// 스킨 체크
list($member_skin_path, $member_skin_url) = apms_skin_thema('member', $member_skin_path, $member_skin_url); 

// 설정값 불러오기
$is_scrap_sub = true;
@include_once($member_skin_path.'/config.skin.php');

$g5['title'] = get_text($member['mb_nick']).'님의 스크랩';

if($is_scrap_sub) {
	include_once(G5_PATH.'/head.sub.php');
	if(!USE_G5_THEME) @include_once(THEMA_PATH.'/head.sub.php');
} else {
	include_once('./_head.php');
}

$skin_path = $member_skin_path;
$skin_url = $member_skin_url;
?>
<div class="mypage-skin">
    <div class="my-profile">
        <h3>회원 정보</h3>
        <div class="my-photo">
            <?php echo ($member['photo']) ? '<img src="'.$member['photo'].'" alt="">' : '<i class="fa fa-user"></i>'; ?>
        </div>
        <div class="my-info">
            <ul>
                <li><h3><?php echo $member['name']; ?><span><?php echo $member['grade'];?></span></h3></li>
                <li><div class="div-progress progress progress-striped no-margin">
					<div class="progress-bar progress-bar-exp" role="progressbar" aria-valuenow="<?php echo round($member['exp_per']);?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo round($member['exp_per']);?>%;">
						<span class="sr-only"><?php echo number_format($member['exp']);?> (<?php echo $member['exp_per'];?>%)</span>
					</div>
				</div></li>
                <li><h6><span>서명</span><?php echo ($mb_signature) ? $mb_signature : '등록된 서명이 없습니다.'; ?></h6></li>
                <li><p><span>포인트</span><a href="<?php echo $at_href['point'];?>" target="_blank"><?php echo number_format($member['mb_point']); ?>점</a></p></li>
                <li><p><span>보유쿠폰</span><a href="<?php echo $at_href['coupon'];?>" target="_blank"><?php echo number_format($cp_count); ?></a></p></li>
                <li><p><span>연락처</span><?php echo ($member['mb_tel'] ? $member['mb_tel'] : '미등록'); ?></p></li>
                <li><p><span>이메일</span><?php echo ($member['mb_email'] ? $member['mb_email'] : '미등록'); ?></p></li>
                <li><p><span>최종접속일</span><?php echo $member['mb_today_login']; ?></p></li>
                <li><p><span>가입날짜</span><?php echo $member['mb_datetime']; ?></p></li>
                <?php if($member['mb_addr1']) { ?>
						<li><p><span>주소</span>
							<?php echo sprintf("(%s-%s)", $member['mb_zip1'], $member['mb_zip2']).' '.print_address($member['mb_addr1'], $member['mb_addr2'], $member['mb_addr3'], $member['mb_addr_jibeon']); ?></p>
						</li>
					<?php } ?>
            </ul>
        </div>
        <div class="mypage-menu">
            <ul>
               <?php if ($is_admin == 'super') { ?>
                <li><a href="<?php echo G5_ADMIN_URL; ?>">관리자</a></li>
                <?php } ?>
				<?php if (IS_YC && ($is_admin == 'super' || IS_PARTNER)) { ?>
                <li><a href="<?php echo $at_href['myshop'];?>">마이 파트너샵</a></li>
                <?php } ?>
                <li><a href="<?php echo $at_href['edit'];?>">회원정보 수정</a></li>
                <li><a href="<?php echo $at_href['myphoto'];?>" target="_blank">사진등록</a></li>
                <li><a href="<?php echo $at_href['mypost'];?>" target="_blank">내글 관리</a></li>
                <li><a href="<?php echo $at_href['response'];?>" target="_blank">내글 반응
							<?php if ($member['response']) echo '('.number_format($member['response']).')'; ?></a></li>
                <li><a href="<?php echo $at_href['memo'];?>" target="_blank">쪽지함<?php if ($member['memo']) echo '('.number_format($member['memo']).')'; ?></a></li>
                <li><a href="<?php echo G5_URL; ?>/bbs/page.php?hid=myfollow">팔로우</a></li>
                <li><a href="<?php echo G5_URL; ?>/bbs/page.php?hid=myscrap">스크랩</a></li>
                <li><a href="<?php echo $at_href['coupon'];?>" target="_blank">마이쿠폰</a></li>
                <li><a href="<?php echo $at_href['shopping'];?>" target="_blank">쇼핑리스트</a></li>
                <li><a href="<?php echo $at_href['wishlist'];?>" target="_blank">위시리스트</a></li>
                <li class="leave"><a href="<?php echo $at_href['leave'];?>" target="_blank">탈퇴하기</a></li>
            </ul>
        </div>
    </div>
</div>
<div class="sub-title">
	<h4>
		<?php if($member['photo']) { ?>
			<img src="<?php echo $member['photo'];?>" alt="">
		<?php } else { ?>
			<i class="fa fa-user"></i>
		<?php } ?>
		<?php echo $g5['title'];?>
	</h4>
</div>

<table class="div-table table">
<tbody>
<tr class="bg-black">
	<th class="text-center" scope="col">번호</th>
	<th class="text-center" scope="col">게시판</th>
	<th class="text-center" scope="col">제목</th>
	<th class="text-center" scope="col">보관일시</th>
	<th class="text-center" scope="col">삭제</th>
</tr>
<?php for ($i=0; $i<count($list); $i++) {  ?>
<tr>
	<td class="text-center"><?php echo $list[$i]['num'] ?></td>
	<td class="text-center"><a href="<?php echo $list[$i]['opener_href'] ?>" target="_blank" onclick="opener.document.location.href='<?php echo $list[$i]['opener_href'] ?>'; return false;"><?php echo $list[$i]['bo_subject'] ?></a></td>
	<td><a href="<?php echo $list[$i]['opener_href_wr_id'] ?>" target="_blank" onclick="opener.document.location.href='<?php echo $list[$i]['opener_href_wr_id'] ?>'; return false;"><?php echo $list[$i]['subject'] ?></a></td>
	<td class="text-center"><?php echo $list[$i]['ms_datetime'] ?></td>
	<td class="text-center"><a href="<?php echo $list[$i]['del_href'];  ?>" onclick="del(this.href); return false;">삭제</a></td>
</tr>
<?php }  ?>
<?php if ($i == 0) echo '<tr><td colspan="5" class="text-center text-muted" height=150>자료가 없습니다.</td></tr>';  ?>
</tbody>
</table>

<?php if($total_count > 0) { ?>
	<div class="text-center">
		<ul class="pagination pagination-sm en" style="margin-top:0px;">
			<?php echo apms_paging($write_page_rows, $page, $total_page, $list_page); ?>
		</ul>
	</div>
<?php } ?>