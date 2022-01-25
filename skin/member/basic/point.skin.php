<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$skin_url.'/style.css" media="screen">', 0);
if (!$is_member)
    goto_url(G5_BBS_URL."/login.php?url=".urlencode(G5_BBS_URL."/mypage.php"));

$mb_homepage = set_http(clean_xss_tags($member['mb_homepage']));
$mb_profile = ($member['mb_profile']) ? conv_content($member['mb_profile'],0) : '';
$mb_signature = ($member['mb_signature']) ? apms_content(conv_content($member['mb_signature'], 1)) : '';

// Page ID
$pid = ($pid) ? $pid : 'mypage';
$at = apms_page_thema($pid);
include_once(G5_LIB_PATH.'/apms.thema.lib.php');

// 스킨 체크
list($member_skin_path, $member_skin_url) = apms_skin_thema('member', $member_skin_path, $member_skin_url); 

// 설정값 불러오기
$is_mypage_sub = false;
@include_once($member_skin_path.'/config.skin.php');

$g5['title'] = $member['mb_nick'].'님 포인트 내역';

if($is_mypage_sub) {
	include_once(G5_PATH.'/head.sub.php');
	if(!USE_G5_THEME) @include_once(THEMA_PATH.'/head.sub.php');
} else {
	include_once('./_head.php');
}

$skin_path = $member_skin_path;
$skin_url = $member_skin_url;

// 스킨설정
$wset = (G5_IS_MOBILE) ? apms_skin_set('member_mobile') : apms_skin_set('member');

$setup_href = '';
if(is_file($skin_path.'/setup.skin.php') && ($is_demo || $is_designer)) {
	$setup_href = './skin.setup.php?skin=member&amp;ts='.urlencode(THEMA);
}
?>
<div class="mypage-skin">
    <div class="my-profile">
        <h3>My Page</h3>
        <div class="my-photo">
           <div class="photo-thumb">
            <?php echo ($member['photo']) ? '<img src="'.$member['photo'].'" alt="">' : '<i class="fa fa-user"></i>'; ?>
            </div>
        </div>
        <div class="my-info">
            <ul>
                <li><h3><?php echo $member['name']; ?></h3><a href="<?php echo $at_href['edit'];?>">회원정보 수정</a></li>
                <li><p>Level <?php echo $member['level'];?> , <?php echo $member['grade'];?></p></li>
                <li><h6>가입날짜 <?php echo $member['mb_datetime']; ?></h6></li>
                <li>
                <div class="div-progress progress progress-striped no-margin">
					<div class="progress-bar progress-bar-exp" role="progressbar" aria-valuenow="<?php echo round($member['exp_per']);?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo round($member['exp_per']);?>%;">
						<span class="sr-only"><?php echo number_format($member['exp']);?> (<?php echo $member['exp_per'];?>%)</span>
					</div>
				</div>
               </li>
                
            </ul>
            <ul class="my-info-ul">
                <li><p><img src="<?php echo THEMA_URL;?>/assets/img/my-point.svg" alt=""><span>포인트</span><a href="<?php echo $at_href['point'];?>"><?php echo number_format($member['mb_point']); ?>점</a></p></li>
                <li><p><img src="<?php echo THEMA_URL;?>/assets/img/my-coupon.svg" alt=""><span>보유쿠폰</span><a href="<?php echo $at_href['coupon'];?>"><?php echo number_format($cp_count); ?></a></p></li>
                <li><p><img src="<?php echo THEMA_URL;?>/assets/img/my-phone.svg" alt=""><span>연락처</span><?php echo ($member['mb_tel'] ? $member['mb_tel'] : '미등록'); ?></p></li>
                <li><p><img src="<?php echo THEMA_URL;?>/assets/img/my-mail.svg" alt=""><span>이메일</span><?php echo ($member['mb_email'] ? $member['mb_email'] : '미등록'); ?></p></li>
                <?php if($member['mb_addr1']) { ?>
						<li><p><span>주소</span>
							<?php echo sprintf("(%s-%s)", $member['mb_zip1'], $member['mb_zip2']).' '.print_address($member['mb_addr1'], $member['mb_addr2'], $member['mb_addr3'], $member['mb_addr_jibeon']); ?></p>
						</li>
					<?php } ?>
            </ul>
        </div>        
    </div>
    <div class="content-wrap">
        <div class="mypage-menu">
            
            <ul>
              <h4>나의 정보 설정</h4>
               <?php if ($is_admin == 'super') { ?>
                <li><a href="<?php echo G5_ADMIN_URL; ?>">관리자</a></li>
                <?php } ?>
                <li><a href="<?php echo $at_href['myphoto'];?>">사진등록</a></li>
				<?php if (IS_YC && ($is_admin == 'super' || IS_PARTNER)) { ?>
                <li><a href="<?php echo $at_href['myshop'];?>">마이 파트너샵</a></li>
                <?php } ?>
                <li><a href="<?php echo $at_href['edit'];?>">회원정보 수정</a></li>
                
                <li class="leave"><a href="<?php echo $at_href['leave'];?>">탈퇴하기</a></li>
            </ul>
            
            <ul>
                <h4>나의 쇼핑</h4>
                <li><a href="<?php echo $at_href['shopping'];?>">주문조회</a></li>
                <li><a href="<?php echo G5_SHOP_URL; ?>/orderinquiry.php">주문내역</a></li>               
                <li><a href="<?php echo $at_href['cart'];?>">장바구니</a></li>                
                <li><a href="<?php echo $at_href['wishlist'];?>">위시리스트</a></li>
                <li><a href="<?php echo $at_href['coupon'];?>">마이쿠폰</a></li>
            </ul>
            
            <ul>
              <h4>나의 활동</h4>
               <li><a href="<?php echo $at_href['mypost'];?>">내가 등록한 게시글</a></li>
               <li><a href="<?php echo $at_href['response'];?>">내 게시글 반응</a></li>
                <li><a href="<?php echo $at_href['follow'];?>">팔로우</a></li>
                <li><a href="<?php echo $at_href['memo'];?>">쪽지함<?php if ($member['memo']) echo '('.number_format($member['memo']).')'; ?></a></li>
                <li><a href="<?php echo $at_href['scrap'];?>">스크랩</a></li>
                <li><a href="<?php echo G5_URL; ?>/bbs/qalist.php">1:1문의</a></li>
            </ul>
        </div>
        <div class="page-info">
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

<div class="point-skin">
	<table class="div-table table">
	<col width="160">
	<tbody>
	<tr class="bg-black">
		<th class="text-center" scope="col">
            <select name="sca" class="form-control input-sm" onchange="location='./point.php?sca='+encodeURIComponent(this.value);">
            <option value="">전체</option>
            <option value="write"<?php echo get_selected('write', $sca);?>>등록</option>
            <option value="read"<?php echo get_selected('read', $sca);?>>열람</option>
            <option value="good"<?php echo get_selected('good', $sca);?>>추천</option>
            <option value="download"<?php echo get_selected('download', $sca);?>>다운</option>
            <option value="choice"<?php echo get_selected('choice', $sca);?>>채택</option>
            <option value="login"<?php echo get_selected('login', $sca);?>>출석</option>
			<?php if(IS_YC) { ?>
	            <option value="buy"<?php echo get_selected('buy', $sca);?>>구매</option>
			<?php } ?>
            <option value="event"<?php echo get_selected('event', $sca);?>>이벤트</option>
			<option value="poll"<?php echo get_selected('poll', $sca);?>>별점/설문</option>
			</select>		
		</th>
		<th class="text-center" scope="col">내용</th>
		<th class="text-center" scope="col">만료</th>
		<th class="text-center" scope="col">지급</th>
		<th class="text-center" scope="col">사용</th>
		<th width="20"></th>
	</tr>
	<?php
	$sum_point1 = $sum_point2 = $sum_point3 = 0;

	$sql = " select *
				{$sql_common}
				{$sql_order}
				limit {$from_record}, {$rows} ";
	$result = sql_query($sql);
	for ($i=0; $row=sql_fetch_array($result); $i++) {
		$point1 = $point2 = 0;
		if ($row['po_point'] > 0) {
			$point1 = '+' .number_format($row['po_point']);
			$sum_point1 += $row['po_point'];
		} else {
			$point2 = number_format($row['po_point']);
			$sum_point2 += $row['po_point'];
		}

		$po_content = $row['po_content'];

		$expr = '';
		if($row['po_expired'] == 1)
			$expr = ' red';
	?>
	<tr>
		<td class="text-center"><?php echo $row['po_datetime']; ?></td>
		<td class="po-content"><?php echo $po_content; ?></td>
		<td class="text-center font-11<?php echo $expr; ?>">
			<?php if ($row['po_expired'] == 1) { ?>
			만료<?php echo substr(str_replace('-', '', $row['po_expire_date']), 2); ?>
			<?php } else echo $row['po_expire_date'] == '9999-12-31' ? '&nbsp;' : $row['po_expire_date']; ?>
		</td>
		<td class="text-right"><?php echo $point1; ?></td>
		<td class="text-right"><?php echo $point2; ?></td>
		<td></td>
	</tr>
	<?php
	}

	if ($i == 0)
		echo '<tr><td class="text-center" colspan="6">자료가 없습니다.</td></tr>';
	else {
		if ($sum_point1 > 0)
			$sum_point1 = "+" . number_format($sum_point1);
		$sum_point2 = number_format($sum_point2);
	}
	?>
	</tbody>
	<tfoot>
	<tr class="active">
		<th></th>
		<th scope="row">소계</th>
		<th></th>
		<td align="right"><b><?php echo $sum_point1; ?></b></td>
		<td align="right"><b><?php echo $sum_point2; ?></b></td>
		<td></td>
	</tr>
	<tr class="bg-black">
		<th></th>
		<th scope="row">보유포인트</th>
		<th></th>
		<td align="right"><b><?php echo number_format($member['mb_point']); ?></b></td>
		<td></td>
		<td></td>
	</tr>
	</tfoot>
	</table>

	<?php if($total_count > 0) { ?>
		<div class="text-center">
			<ul class="pagination pagination-sm en" style="margin-top:0px;">
				<?php echo apms_paging($write_page_rows, $page, $total_page, $list_page); ?>
			</ul>
		</div>
	<?php } ?>

</div>
        </div>
    </div>
</div>
<?php
if($is_mypage_sub) {
	if(!USE_G5_THEME) @include_once(THEMA_PATH.'/tail.sub.php');
	include_once(G5_PATH.'/tail.sub.php');
} else {
	include_once('./_tail.php');
}

?>