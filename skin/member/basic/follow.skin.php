<?php
if (!defined('_GNUBOARD_')) exit; //개별 페이지 접근 불가

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

$g5['title'] = $member['mb_nick'].'님 팔로우';

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
        <div class="at-container">
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
    </div>
    <div class="content-wrap">
       <div class="at-container">
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
               <li><a href="<?php echo $at_href['mypost'];?>">게시글/상품후기</a></li>
               <li><a href="<?php echo $at_href['response'];?>">게시글 반응</a></li>
                <li class="on"><a href="<?php echo $at_href['follow'];?>">팔로우</a></li>
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
             <div class="follow-skin">
	<div class="btn-group btn-group-justified">
		<a href="<?php echo $follow_href;?>" class="btn btn-sm btn-black<?php echo ($follow_on) ? ' active' : '';?>">팔로우(<?php echo $member['follow'];?>)</a>
		<a href="<?php echo $followed_href;?>" class="btn btn-sm btn-black<?php echo ($followed_on) ? ' active' : '';?>">팔로워 (<?php echo $member['followed'];?>)</a>
		<a href="<?php echo $like_href;?>" class="btn btn-sm btn-black<?php echo ($like_on) ? ' active' : '';?>">나의 추천 (<?php echo $member['like'];?>)</a>
		<a href="<?php echo $liked_href;?>" class="btn btn-sm btn-black<?php echo ($liked_on) ? ' active' : '';?>">받은 추천(<?php echo $member['liked'];?>)</a>
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


	<script>
	function mb_delete(url) {
		if(confirm("리스트에서 삭제하시겠습니까?")) {
			document.location.href = url;
		}
	}
	</script>
</div>
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