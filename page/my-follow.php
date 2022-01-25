<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once('./header.php');
if ($is_guest) {
	alert_close('회원만 이용가능합니다.');
}

if(!$mode) $mode = 'follow';

if($del) { //삭제하기
	if($mode == 'follow' || $mode == 'like') { // 자신이 follow하고, like한 것만 가능함
		$row = sql_fetch(" select * from {$g5['apms_like']} where id = '{$id}' and mb_id = '{$member['mb_id']}' ", false);
		if(!$row['mb_id']) {
			alert('자료가 없습니다.');
		}

		if($row['mb_id'] != $member['mb_id']) {
			alert('자신의 것만 삭제할 수 있습니다.');
		}

		if($mode == 'follow') {
			$flag_me = 'as_follow';
			$flag_to = 'as_followed';
		} else {
			$flag_me = 'as_like';
			$flag_to = 'as_liked';
		}

		// 상대편 차감	
		sql_query("update {$g5['member_table']} set $flag_to = $flag_to - 1 where mb_id = '{$row['to_id']}' ");

		// 내꺼 차감
		sql_query("update {$g5['member_table']} set $flag_me = $flag_me - 1 where mb_id = '{$member['mb_id']}' ");

		// 내역삭제
		sql_query("delete from {$g5['apms_like']} where id = '{$id}' ");
	}

	goto_url('./follow.php?mode='.$mode);
}

if($rc) { //리카운트
	// 내가 친구로 맺은 회원들 재계산
	$row1 = sql_fetch(" select count(*) as cnt from {$g5['apms_like']} where mb_id = '{$member['mb_id']}' and flag = 'follow' ", false);

	// 나를 친구로 맺은 회원들 재계산
	$row2 = sql_fetch(" select count(*) as cnt from {$g5['apms_like']} where to_id = '{$member['mb_id']}' and flag = 'follow' ", false);

	// 내가 종아하는 회원들 재계산
	$row3 = sql_fetch(" select count(*) as cnt from {$g5['apms_like']} where mb_id = '{$member['mb_id']}' and flag = 'like' ", false);

	// 나를 종아하는 회원들 재계산
	$row4 = sql_fetch(" select count(*) as cnt from {$g5['apms_like']} where to_id = '{$member['mb_id']}' and flag = 'like' ", false);

	// 업데이트
	sql_query(" update {$g5['member_table']} set as_follow = '{$row1['cnt']}', as_followed = '{$row2['cnt']}', as_like = '{$row3['cnt']}', as_liked = '{$row4['cnt']}' where mb_id = '{$member['mb_id']}' ");

	goto_url('./follow.php?mode='.$mode);
} 

if($mode == 'follow') { // 내가 친구로 맺은 회원들
	$sql_common = " from `{$g5['apms_like']}` a left join `{$g5['member_table']}` b on (a.to_id = b.mb_id) where a.mb_id = '{$member['mb_id']}' and a.flag = 'follow' and b.mb_leave_date = '' ";
} else if($mode == 'followed') { // 나를 친구로 맺은 회원들
	$sql_common = " from `{$g5['apms_like']}` a left join `{$g5['member_table']}` b on (a.mb_id = b.mb_id) where a.to_id = '{$member['mb_id']}' and a.flag = 'follow' and b.mb_leave_date = '' ";
} else if($mode == 'like') { // 내가 좋아하는 회원들
	$sql_common = " from `{$g5['apms_like']}` a left join `{$g5['member_table']}` b on (a.to_id = b.mb_id) where a.mb_id = '{$member['mb_id']}' and a.flag = 'like' and b.mb_leave_date = '' ";
} else if($mode == 'liked') { // 나를 좋아하는 회원들
	$sql_common = " from `{$g5['apms_like']}` a left join `{$g5['member_table']}` b on (a.mb_id = b.mb_id) where a.to_id = '{$member['mb_id']}' and a.flag = 'like' and b.mb_leave_date = '' ";
} else {
	exit;
}

// Page ID
$pid = ($pid) ? $pid : '';
$at = apms_page_thema($pid);
include_once(G5_LIB_PATH.'/apms.thema.lib.php');

// 스킨 체크
list($member_skin_path, $member_skin_url) = apms_skin_thema('member', $member_skin_path, $member_skin_url); 

// 설정값 불러오기
$is_follow_sub = true;
@include_once($member_skin_path.'/config.skin.php');

$g5['title'] = $member['mb_nick'].' 님의 팔로우';

if($is_follow_sub) {
	include_once(G5_PATH.'/head.sub.php');
	if(!USE_G5_THEME) @include_once(THEMA_PATH.'/head.sub.php');
} else {
	include_once('./_head.php');
}

$skin_path = $member_skin_path;
$skin_url = $member_skin_url;

// 전체 페이지 계산
$rows = 5;
$row = sql_fetch(" select count(*) as cnt $sql_common ");
$total_count = $row['cnt'];
$total_page  = ceil($total_count / $rows);
$page = ($page > 1) ? $page : 1;
$from_record = ($page - 1) * $rows;

// 리스트
$list = array();
$result = sql_query(" select * $sql_common order by b.mb_today_login desc limit $from_record, $rows ");
for ($i=0; $row=sql_fetch_array($result); $i++) { 

	// Member
	$list[$i] = apms_member($row['mb_id']);

	$list[$i]['del_href'] = ($mode == 'follow' || $mode == 'like') ? G5_BBS_URL.'/follow.php?id='.$row['id'].'&amp;mode='.$mode.'&amp;&del=1' : '';

	$list[$i]['myshop_href'] = '';
	$list[$i]['myrss_href'] = '';
	if(IS_YC && $list[$i]['partner']) {
		$list[$i]['myshop_href'] = G5_SHOP_URL.'/myshop.php?id='.$row['mb_id'];
		$list[$i]['myrss_href'] = G5_URL.'/rss/?id='.$row['mb_id'];
	}

	// Item
	$j = 0;
	if(IS_YC) { 
		$result2 = sql_query(" select it_id, it_name, pt_comment, it_time from {$g5['g5_shop_item_table']} where pt_id = '{$row['mb_id']}' and it_use = '1' order by it_id desc limit 0, 3 ", false);
		for ($j=0; $row2=sql_fetch_array($result2); $j++) {
			$list[$i]['it'][$j]['subject'] = $row2['it_name'];
			$list[$i]['it'][$j]['comment'] = $row2['pt_comment'];
			$list[$i]['it'][$j]['date'] = strtotime($row2['it_time']);
			$list[$i]['it'][$j]['href'] = G5_SHOP_URL.'/item.php?it_id='.$row2['it_id'];
		}
	}
	$list[$i]['is_it'] = ($j > 0) ? true : false;

	// Post
	$result3 = sql_query(" select bo_table, wr_id from {$g5['board_new_table']} where mb_id = '{$row['mb_id']}' and wr_parent = wr_id order by bn_id desc limit 0, 3 ", false);
	for ($j=0; $row3=sql_fetch_array($result3); $j++) {
		$tmp_write_table = $g5['write_prefix'] . $row3['bo_table']; 
		$wr = sql_fetch(" select wr_subject, wr_comment, wr_datetime from $tmp_write_table where wr_id = '{$row3['wr_id']}' ", false);
		$list[$i]['wr'][$j]['subject'] = $wr['wr_subject'];
		$list[$i]['wr'][$j]['comment'] = $wr['wr_comment'];
		$list[$i]['wr'][$j]['date'] = strtotime($wr['wr_datetime']);
		$list[$i]['wr'][$j]['href'] = G5_BBS_URL.'/board.php?bo_table='.$row3['bo_table'].'&amp;wr_id='.$row3['wr_id'];
	}

	$list[$i]['is_wr'] = ($j > 0) ? true : false;

	// Login
	$row4 = sql_fetch(" select count(*) as cnt from {$g5['login_table']} where mb_id = '{$row['mb_id']}' ");
	$list[$i]['online'] = $row4['cnt'];
}

// 리카운트
if($mode == 'follow') { // 내가 친구로 맺은 회원들
	if($member['as_follow'] != $total_count) {
		sql_query(" update {$g5['member_table']} set as_follow = '$total_count' where mb_id = '{$member['mb_id']}' ", false);
		$member['follow'] = $member['as_follow'] = $total_count;
	}
} else if($mode == 'followed') { // 나를 친구로 맺은 회원들
	if($member['as_followed'] != $total_count) {
		sql_query(" update {$g5['member_table']} set as_followed = '$total_count' where mb_id = '{$member['mb_id']}' ", false);
		$member['followed'] = $member['as_followed'] = $total_count;
	}
} else if($mode == 'like') { // 내가 좋아하는 회원들
	if($member['as_like'] != $total_count) {
		sql_query(" update {$g5['member_table']} set as_like = '$total_count' where mb_id = '{$member['mb_id']}' ", false);
		$member['like'] = $member['as_like'] = $total_count;
	}
} else if($mode == 'liked') { // 나를 좋아하는 회원들
	if($member['as_liked'] != $total_count) {
		sql_query(" update {$g5['member_table']} set as_liked = '$total_count' where mb_id = '{$member['mb_id']}' ", false);
		$member['liked'] = $member['as_liked'] = $total_count;
	}
}

$write_page_rows = G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'];
$list_page = '/bbs/page.php?hid=myfollow&mode='.$mode.'&amp;page=';
$recount_href = '/bbs/page.php?hid=myfollow&mode='.$mode.'&amp;rc=1';
$follow_href = '/bbs/page.php?hid=myfollow&mode=follow';
$follow_on = ($mode == 'follow') ? true : false;
$followed_href = '/bbs/page.php?hid=myfollow&mode=followed';
$followed_on = ($mode == 'followed') ? true : false;
$like_href = '/bbs/page.php?hid=myfollow&mode=like';
$like_on = ($mode == 'like') ? true : false;
$liked_href = '/bbs/page.php?hid=myfollow&mode=liked';
$liked_on = ($mode == 'liked') ? true : false;

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

<div class="follow-skin">
	<div class="btn-group btn-group-justified">
		<a href="<?php echo $follow_href;?>" class="btn btn-sm btn-black<?php echo ($follow_on) ? ' active' : '';?>">Follow (<?php echo $member['follow'];?>)</a>
		<a href="<?php echo $followed_href;?>" class="btn btn-sm btn-black<?php echo ($followed_on) ? ' active' : '';?>">Followed (<?php echo $member['followed'];?>)</a>
		<a href="<?php echo $like_href;?>" class="btn btn-sm btn-black<?php echo ($like_on) ? ' active' : '';?>">Like (<?php echo $member['like'];?>)</a>
		<a href="<?php echo $liked_href;?>" class="btn btn-sm btn-black<?php echo ($liked_on) ? ' active' : '';?>">Liked (<?php echo $member['liked'];?>)</a>
	</div>

	<?php for($i=0; $i < count($list); $i++) { ?>
		<div class="panel panel-default sp-follow"<?php if($i == 0) echo ' style="border-top:0;"';?>>
			<div class="panel-heading">
				<h3 class="panel-title">
					<?php if($list[$i]['del_href']) { ?>
						<span class="pull-right"><a href="#" onclick="mb_delete('<?php echo $list[$i]['del_href'];?>'); return false;"><i class="fa fa-times text-muted"></i></a></span>
					<?php } ?>
					<?php echo ($list[$i]['online']) ? '<span class="red">Online</span>' : 'Offline'; ?>
				</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-xs-2 text-center col-follow">
						<div class="img-photo">
							<?php echo ($list[$i]['photo']) ? '<img src="'.$list[$i]['photo'].'" alt="">' : '<i class="fa fa-user"></i>'; ?>
						</div>
					</div>
					<div class="col-xs-10 col-follow">
						<div style="margin-bottom:6px;">
							<span class="pull-right">Lv.<?php echo $list[$i]['level'];?></span>
							<b><?php echo $list[$i]['name']; ?></b> &nbsp;<small class="text-muted font-11"><?php echo $list[$i]['grade'];?></small>
						</div>
						<div class="at-tip" data-original-title="<?php echo number_format($list[$i]['exp_up']);?>점 추가획득시 레벨업합니다." data-toggle="tooltip" data-placement="top" data-html="true">
							<div class="div-progress progress progress-striped" style="margin:0px 0px 6px;">
								<div class="progress-bar progress-bar-exp" role="progressbar" aria-valuenow="<?php echo $list[$i]['exp_per'];?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo round($list[$i]['exp_per']);?>%;">
									<span class="sr-only"><?php echo number_format($list[$i]['exp']);?> (<?php echo $list[$i]['exp_per'];?>%)</span>
								</div>
							</div>
						</div>
						<div class="myinfo font-12">
							<?php if($list[$i]['myshop_href']) { ?>
								<a href="<?php echo $list[$i]['myshop_href'];?>" target="_blank"><i class="fa fa-shopping-cart"></i> 마이샵</a>
							<?php } ?>
							<?php if($list[$i]['myrss_href']) { ?>
								<a href="<?php echo $list[$i]['myrss_href'];?>" target="_blank"><i class="fa fa-rss"></i> 구독하기</a>
							<?php } ?>
							<a><i class="fa fa-clock-o"></i> <?php echo $list[$i]['mb_today_login'];?></a>
						</div>
					</div>
				</div>
			</div>
			<div class="list-group">
				<?php if($list[$i]['is_it']) { // 최근 아이템 ?>
					<a href="#" class="list-group-item bg-heading">
						<b class="black"><i class="fa fa-gift"></i> 최근 아이템</b>
					</a>
					<?php for($j=0; $j < count($list[$i]['it']);$j++) { ?>
						<a href="<?php echo $list[$i]['it'][$j]['href'];?>" target="_blank" class="list-group-item">
							<?php echo $list[$i]['it'][$j]['subject'];?>
							<?php if($list[$i]['it'][$j]['comment']) { ?>
								 &nbsp;<span class="text-muted font-11 en"><i class="fa fa-comment"></i> <?php echo $list[$i]['it'][$j]['comment'];?></span>
							<?php } ?>
							<span class="text-muted font-11 en">
								 &nbsp;<i class='fa fa-clock-o'></i>
								<?php echo apms_datetime($list[$i]['it'][$j]['date']);?>
							</span>
						</a>
					<?php } ?>
				<?php } ?>

				<?php if($list[$i]['is_wr']) { // 최근글 ?>
					<a href="#" class="list-group-item bg-heading">
						<b class="black"><i class="fa fa-pencil"></i> 최근 게시물</b>
					</a>
					<?php for($j=0; $j < count($list[$i]['wr']);$j++) { ?>
						<a href="<?php echo $list[$i]['wr'][$j]['href'];?>" target="_blank" class="list-group-item">
							<?php echo $list[$i]['wr'][$j]['subject'];?>
							<?php if($list[$i]['wr'][$j]['comment']) { ?>
								 &nbsp;<span class="text-muted font-11 en"><i class="fa fa-comment"></i> <?php echo $list[$i]['wr'][$j]['comment'];?></span>
							<?php } ?>
							<span class="text-muted font-11 en">
								 &nbsp;<i class='fa fa-clock-o'></i>
								<?php echo apms_datetime($list[$i]['wr'][$j]['date']);?>
							</span>
						</a>
					<?php } ?>
				<?php } ?>
			</div>
		</div>
	<?php } ?>
	<?php if($i == 0) { ?>
		<p class="text-center text-muted" style="padding:50px 0;">자료가 없습니다.</p>
	<?php } ?>

	<?php if($total_count > 0) { ?>
		<div class="text-center">
			<ul class="pagination pagination-sm en">
				<?php echo apms_paging($write_page_rows, $page, $total_page, $list_page); ?>
			</ul>
		</div>
	<?php } ?>

	<p class="text-center">
		<a class="btn btn-color btn-sm" href="<?php echo $recount_href;?>">리카운트</a>
	</p>

	<script>
	function mb_delete(url) {
		if(confirm("리스트에서 삭제하시겠습니까?")) {
			document.location.href = url;
		}
	}
	</script>
</div>