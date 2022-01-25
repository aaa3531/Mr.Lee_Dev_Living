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

$g5['title'] = $member['mb_nick'].'님 마이페이지';

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
                <li class="on"><a href="<?php echo $at_href['shopping'];?>">주문조회</a></li>
                <li><a href="<?php echo G5_SHOP_URL; ?>/orderinquiry.php">주문내역</a></li>               
                <li><a href="<?php echo $at_href['cart'];?>">장바구니</a></li>                
                <li><a href="<?php echo $at_href['wishlist'];?>">위시리스트</a></li>
                <li><a href="<?php echo $at_href['coupon'];?>">마이쿠폰</a></li>
            </ul>
            
            <ul>
              <h4>나의 활동</h4>
               <li><a href="<?php echo $at_href['mypost'];?>">게시글/상품후기</a></li>
               <li><a href="<?php echo $at_href['response'];?>">게시글 반응</a></li>
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
		<?php echo $member['mb_nick'];?> 님의 주문조회
	</h4>
</div>  
       <div class="btn-group btn-group-justified">
	<a href="./shopping.php?mode=1" class="btn btn-sm btn-black<?php echo ($mode == "1") ? ' active' : '';?>">구매완료</a>
	<a href="./shopping.php?mode=2" class="btn btn-sm btn-black<?php echo ($mode == "2") ? ' active' : '';?>">배송중</a>
	<a href="./shopping.php?mode=3" class="btn btn-sm btn-black<?php echo ($mode == "3") ? ' active' : '';?>">주문접수</a>
</div>

<style>
	.shopping-skin table > tr > td { line-height:22px; }
	.it-opt ul { margin:0px; padding:0px; padding-left:15px; }
	.it-info ul { margin:0px; padding:0px; padding-left:15px; }
	.it-info ul li { white-space:nowrap; }
</style>
<div class="shopping-skin">
	<table class="div-table table">
	<tbody>
	<tr class="active">
		<th class="text-center" scope="col"><nobr>번호</nobr></th>
		<th class="text-center" scope="col">이미지</th>
		<th class="text-center" scope="col">아이템명</th>
		<th class="text-center" scope="col">주문번호</th>
		<th class="text-center" scope="col">배송/이용정보</th>
	</tr>
	<?php for ($i=0; $i<count($list); $i++)	{ ?>
		<tr>
			<td class="text-center">
				<?php echo $list[$i]['num']; ?>
			</td>
			<td class="text-center">
				<a href="<?php echo $list[$i]['it_href'];?>" target="_blank">
					<?php echo get_it_image($list[$i]['it_id'], 50, 50);?>
				</a>
			</td>
			<td>
				<a href="<?php echo $list[$i]['it_href'];?>" target="_blank">
					<b><?php echo $list[$i]['it_name']; ?></b>
					<?php if($list[$i]['option']) { ?>
						<div class="it-opt text-muted">
							<?php echo $list[$i]['option'];?>
						</div>
					<?php } ?>
				</a>
			</td>
			<td class="text-center">
				<a href="<?php echo $list[$i]['od_href'];?>" target="_blank">
					<nobr><?php echo $list[$i]['od_num']; ?></nobr>
				</a>
				<?php if($list[$i]['seller']) { ?>
					<div>
						<b><?php echo $list[$i]['seller'];?></b>
					</div>
				<?php } ?>
			</td>
			<td class="it-info">
				<ul>
				<?php if($mode == "3") { //입금 ?>
					<li>
						<a href="<?php echo $list[$i]['od_href'];?>" target="_blank">
							주문서확인
						</a>
					</li>
				<?php } else if ($list[$i]['is_delivery']) { // 배송가능 ?>

					<?php if($list[$i]['de_company'] && $list[$i]['de_invoice']) { ?>
						<li>
							<?php echo $list[$i]['de_company'];?>
							<?php echo $list[$i]['de_invoice'];?>
						</li>
						<?php if($list[$i]['de_check']) { ?>
							<li>
								<?php echo str_replace("문의전화: ", "", $list[$i]['de_check']);?>
							</li>
						<?php } ?>
					<?php } ?>
					<?php if($list[$i]['de_confirm']) { //수령확인 ?>
						<li>
							<a href="<?php echo $list[$i]['de_confirm'];?>" class="delivery-confirm">
								<span class="orangered">수령확인</span>
							</a>
						</li>
					<?php } ?>

				<?php } else { //배송불가 - 컨텐츠 ?>

					<?php if($list[$i]['use_date']) { ?>
						<li>최종일시 : <?php echo $list[$i]['use_date'];?></li>
					<?php } ?>
					<?php if($list[$i]['use_file']) { ?>
						<li>최종자료 : <?php echo $list[$i]['use_file'];?></li>
					<?php } ?>
					<?php if($list[$i]['use_cnt']) { ?>
						<li>이용횟수 : <?php echo number_format($list[$i]['use_cnt']);?>회</li>
					<?php } ?>

				<?php } ?>
				</ul>
			</td>
		</tr>
	<?php }  ?>
	<?php if ($i == 0) { ?>
		<tr>
			<td colspan="5" class="text-center text-muted" height="150">
				자료가 없습니다.
			</td>
		</tr>
	<?php } ?>
	</tbody>
	<tfoot>
	<tr class="active">
		<td colspan="5" class="text-center">
			<?php if($mode == "2") { ?>
				수령확인된 아이템에 한해 포인트 등이 적립됩니다.
			<?php } else if($mode == "3") { ?>
				주문서 기준으로 현재 입금 및 배송 준비 중인 아이템 내역입니다.
			<?php } else { ?>
				주문서 기준으로 구매가 최종완료된 아이템 내역입니다.
			<?php } ?>
		</td>
	</tr>
	</tfoot>
	</table>

	<?php if($total_count > 0) { ?>
		<div class="text-center">
			<ul class="pagination pagination-sm" style="margin-top:10px;">
				<?php echo apms_paging($write_page_rows, $page, $total_page, $list_page); ?>
			</ul>
		</div>
	<?php } ?>
</div>

        </div>
    </div>
</div>

</div>


<script>
$(function(){
	$(".delivery-confirm").click(function(){
		if(confirm("상품을 수령하셨습니까?\n\n확인시 배송완료 처리가됩니다.")) {
			return true;
		}
		return false;
	});
});
</script>
<?php
if($is_mypage_sub) {
	if(!USE_G5_THEME) @include_once(THEMA_PATH.'/tail.sub.php');
	include_once(G5_PATH.'/tail.sub.php');
} else {
	include_once('./_tail.php');
}

?>