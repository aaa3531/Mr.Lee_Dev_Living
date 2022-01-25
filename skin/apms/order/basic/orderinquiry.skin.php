<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$skin_url.'/style.css" media="screen">', 0);

// 목록헤드
if(isset($wset['ihead']) && $wset['ihead']) {
	add_stylesheet('<link rel="stylesheet" href="'.G5_CSS_URL.'/head/'.$wset['ihead'].'.css" media="screen">', 0);
	$head_class = 'list-head';
} else {
	$head_class = (isset($wset['icolor']) && $wset['icolor']) ? 'tr-head border-'.$wset['icolor'] : 'tr-head border-black';
}
$g5['title'] = $member['mb_nick'].'님 주문내역';
// 헤더 출력
if($header_skin)
	include_once('./header.php');

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
                <li class="on"><a href="<?php echo G5_SHOP_URL; ?>/orderinquiry.php">주문내역</a></li>               
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
             <div class="well well-sm">
	<i class="fa fa-bell fa-lg"></i> 주문서번호 링크를 누르시면 주문상세내역을 조회하실 수 있습니다.
</div>

<div class="table-responsive">
    <table class="div-table table bsk-tbl bg-white">
    <tbody>
    <tr class="<?php echo $head_class;?>">
        <th scope="col"><span>주문서번호</span></th>
        <th scope="col"><span>주문일시</span></th>
        <th scope="col"><span>상품수</span></th>
        <th scope="col"><span>주문금액</span></th>
        <th scope="col"><span>입금액</span></th>
        <th scope="col"><span>미입금액</span></th>
        <th scope="col"><span class="last">상태</span></th>
    </tr>
    <?php for ($i=0; $i < count($list); $i++) { ?>
		<tr<?php echo ($i == 0) ? ' class="tr-line"' : '';?>>
			<td class="text-center">
				<input type="hidden" name="ct_id[<?php echo $i; ?>]" value="<?php echo $list[$i]['ct_id']; ?>">
				<a href="<?php echo $list[$i]['od_href']; ?>"><?php echo $list[$i]['od_id']; ?></a>
			</td>
			<td class="text-center"><?php echo substr($list[$i]['od_time'],2,14); ?> (<?php echo get_yoil($list[$i]['od_time']); ?>)</td>
			<td class="text-center"><?php echo $list[$i]['od_cart_count']; ?></td>
			<td class="text-right"><?php echo display_price($list[$i]['od_total_price']); ?></td>
			<td class="text-right"><?php echo display_price($list[$i]['od_receipt_price']); ?></td>
			<td class="text-right"><?php echo display_price($list[$i]['od_misu']); ?></td>
			<td class="text-center"><?php echo $list[$i]['od_status']; ?></td>
		</tr>
    <?php } ?>
	<?php if ($i == 0) { ?>
        <tr><td colspan="7" class="text-center">주문 내역이 없습니다.</td></tr>
	<?php } ?>
    </tbody>
    </table>
</div>

<div class="text-center">
	<ul class="pagination pagination-sm en">
		<?php echo apms_paging($write_pages, $page, $total_page, $list_page); ?>
	</ul>
</div>

<?php if($setup_href) { ?>
	<p class="text-center">
		<a class="btn btn-color btn-sm win_memo" href="<?php echo $setup_href;?>">
			<i class="fa fa-cogs"></i> 스킨설정
		</a>
	</p>
<?php } ?>
        </div>
    </div>
</div>
</div>