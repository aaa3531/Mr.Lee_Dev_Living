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

$g5['title'] = $member['mb_nick'].'님의 글반응';

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
               <li class="on"><a href="<?php echo $at_href['response'];?>">게시글 반응</a></li>
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

<div class="btn-group btn-group-justified">
	<a href="./response.php" class="btn btn-sm btn-black<?php echo (!$read) ? ' active' : '';?>">미확인 반응내역(<b><?php echo number_format($member['response']);?></b>건)</a>
	<a href="./response.php?read=1" class="btn btn-sm btn-black<?php echo ($read) ? ' active' : '';?>">확인 반응내역(180일)</a>
</div>

<div class="myresponse-skin table-responsive" style="border-left:0px; border-right:0px;">
	<table class="div-table table">
	<col width="40">
	<col width="50">
	<col>
	<col width="80">
	<tbody> 
	<?php for ($i=0; $i < count($list); $i++) { ?>
		<tr>
		<td class="text-center text-muted ">
			<?php echo ($read) ? $list[$i]['num'] : '<i class="fa fa-commenting fa-2x"></i>';?>
		</td>
		<td class="photo text-center">
			<?php echo ($list[$i]['photo']) ? '<img src="'.$list[$i]['photo'].'" alt="">' : '<i class="fa fa-user"></i>'; ?>
		</td>
		<td style="white-space:normal !important;">
			<a href="#" onclick="<?php echo $list[$i]['href'];?>">
				<b><?php echo $list[$i]['subject'];?></b>
			</a>
			<div class="media-info text-muted font-11" style="margin-top:4px;">
				<?php echo $list[$i]['name'];?> 외
				&nbsp;
				<?php if($list[$i]['reply_cnt']) { ?>
					<i class="fa fa-comments-o"></i> <?php echo $list[$i]['reply_cnt'];?>
				<?php } ?>
				<?php if($list[$i]['comment_cnt']) { ?>
					<i class="fa fa-comment"></i> <?php echo $list[$i]['comment_cnt'];?>
				<?php } ?>
				<?php if($list[$i]['comment_reply_cnt']) { ?>
					<i class="fa fa-comments"></i> <?php echo $list[$i]['comment_reply_cnt'];?>
				<?php } ?>
				<?php if($list[$i]['good_cnt']) { ?>
					<i class="fa fa-thumbs-up"></i> <?php echo $list[$i]['good_cnt'];?>
				<?php } ?>
				<?php if($list[$i]['nogood_cnt']) { ?>
					<i class="fa fa-thumbs-down"></i> <?php echo $list[$i]['nogood_cnt'];?>
				<?php } ?>
				<?php if($list[$i]['use_cnt']) { ?>
					<i class="fa fa-pencil"></i> <?php echo $list[$i]['use_cnt'];?>
				<?php } ?>
				<?php if($list[$i]['qa_cnt']) { ?>
					<i class="fa fa-question-circle"></i> <?php echo $list[$i]['qa_cnt'];?>
				<?php } ?>
			</div>
		</td>
		<td class="text-muted">
			<?php echo apms_date($list[$i]['date'], 'orangered', 'before', 'm.d', 'Y.m.d');?>
		</td>
		</tr>		
	<?php } ?>
	<?php if($i == 0) { ?>
		<tr>
		<td colspan="4">
			<div class="text-center text-muted" style="padding:80px 0px;">등록된 내글반응이 없습니다.</div>
		</td>
		</tr>
	<?php } ?>
	</tbody>
	</table>
</div>

<div class="clearfix"></div>

<div class="text-center">
	<ul class="pagination pagination-sm en" style="margin-top:0;">
		<?php echo apms_paging($write_page_rows, $page, $total_page, $list_page); ?>
	</ul>
</div>

<p class="text-center">
	<a class="btn btn-color btn-sm" href="<?php echo $all_href;?>">일괄확인</a>
</p>
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