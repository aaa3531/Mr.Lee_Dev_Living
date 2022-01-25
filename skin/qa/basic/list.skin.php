<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$skin_url.'/style.css" media="screen">', 0);

// 헤더 출력
if($header_skin)
	include_once('./header.php');

$is_view = false;
$list_cnt = count($list);

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
                <li class="on"><a href="<?php echo G5_URL; ?>/bbs/qalist.php">1:1문의</a></li>
            </ul>
        </div>
        <div class="page-info">
<section class="qa-list<?php echo (G5_IS_MOBILE) ? ' font-14' : '';?>"> 

	<div class="qsearch-box">
		<form name="fsearch" method="get" role="form" class="form">
			<input type="hidden" name="sca" value="<?php echo $sca ?>">
			<div class="row row-15">
				<div class="col-sm-4 col-sm-offset-3 col-xs-7 col-15">
					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-search"></i></span>
							<input type="text" name="stx" value="<?php echo stripslashes($stx) ?>" required id="stx" class="form-control input-sm" maxlength="15" placeholder="검색어">
						</div>
					</div>
				</div>
				<div class="col-sm-2 col-xs-5 col-15">
					<div class="form-group">
						<button type="submit" class="btn btn-black btn-sm btn-block"><i class="fa fa-search"></i> 검색</button>
					</div>
				</div>
			</div>
		</form>
	</div>

	<?php if($category_option) include_once($skin_path.'/category.skin.php'); // 카테고리	?>

	<div class="list-wrap">

		<form name="fqalist" id="fqalist" action="./qadelete.php" onsubmit="return fqalist_submit(this);" method="post" role="form" class="form">
		<input type="hidden" name="stx" value="<?php echo $stx; ?>">
		<input type="hidden" name="sca" value="<?php echo $sca; ?>">
		<input type="hidden" name="page" value="<?php echo $page; ?>">
		<input type="hidden" name="token" value="<?php echo $token; ?>">

		<?php include_once($skin_path.'/list.rows.php'); ?>

		<div class="list-btn-box">
			<?php if ($list_href || $write_href) { ?>
				<div class="form-group pull-right list-btn">
					<div class="btn-group">
						<?php if ($list_href) { ?>
							<a href="<?php echo $list_href ?>" class="btn btn-black btn-sm"><i class="fa fa-bars"></i> 목록</a>
						<?php } ?>
						<?php if ($write_href) { ?>
							<a href="<?php echo $write_href ?>" class="btn btn-color btn-sm"><i class="fa fa-pencil"></i> 글쓰기</a>
						<?php } ?>
					</div>
				</div>
			<?php } ?>
			<?php if ($is_checkbox || $admin_href || $setup_href) { ?>
				<div class="form-group list-btn">
					<div class="btn-group btn-group-sm">
						<?php if ($is_checkbox) { ?>
							<input type="submit" name="btn_submit" value="선택삭제" onclick="document.pressed=this.value" class="btn btn-black btn-sm">
						<?php } ?>
						<?php if ($admin_href) { ?>
							<a href="<?php echo $admin_href ?>" class="btn btn-black btn-sm"><i class="fa fa-cog"></i></a>
						<?php } ?>
						<?php if($setup_href) { ?>
							<a class="btn btn-color btn-sm win_memo" href="<?php echo $setup_href;?>">
								<i class="fa fa-cogs"></i> 스킨설정
							</a>
						<?php } ?>
					</div>
				</div>
			<?php } ?>
			<div class="clearfix"></div>
		</div>
		</form>
	</div>

	<?php if($is_checkbox) { ?>
		<noscript>
		<p>자바스크립트를 사용하지 않는 경우<br>별도의 확인 절차 없이 바로 선택삭제 처리하므로 주의하시기 바랍니다.</p>
		</noscript>
	<?php } ?>

	<div class="list-page text-center">
		<ul class="pagination pagination-sm en">
			<?php echo preg_replace('/(\.php)(&amp;|&)/i', '$1?', apms_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, './qalist.php'.$qstr.'&amp;page='));?>
		</ul>
	</div>

	<div class="clearfix"></div>

</section>

        </div>
    </div>
</div>

<?php if ($is_checkbox) { ?>
<script>
function all_checked(sw) {
    var f = document.fqalist;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_qa_id[]")
            f.elements[i].checked = sw;
    }
}

function fqalist_submit(f) {
    var chk_count = 0;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_qa_id[]" && f.elements[i].checked)
            chk_count++;
    }

    if (!chk_count) {
        alert(document.pressed + "할 게시물을 하나 이상 선택하세요.");
        return false;
    }

    if(document.pressed == "선택삭제") {
        if (!confirm("선택한 게시물을 정말 삭제하시겠습니까?\n\n한번 삭제한 자료는 복구할 수 없습니다"))
            return false;
    }

    return true;
}
</script>
<?php } ?>
