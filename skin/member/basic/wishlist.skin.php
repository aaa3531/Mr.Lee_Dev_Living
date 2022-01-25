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

$g5['title'] = $member['mb_nick'].'님 위시리스트';

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
                <li class="on"><a href="<?php echo $at_href['wishlist'];?>">위시리스트</a></li>
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
	             	<?php echo $g5['title'];?>
	             </h4>
             </div>
<form class="wishlist" name="fwishlist" method="post" action="./cartupdate.php">
<input type="hidden" name="act"       value="multi">
<input type="hidden" name="sw_direct" value="">
<input type="hidden" name="prog"      value="wish">
<h4>총 <?php echo count($list); ?> 개의 상품이 담겨져 있습니다.</h4>
<div class="item-list-inner wish">
    <ul>
        <?php 
	for($i=0; $i < count($list);$i++) { 
		$list[$i]['img'] = apms_it_thumbnail($list[$i], 400, 400, false, true);	
	?>
      <li>
         <?php if($list[$i]['is_soldout']) { // 품절검사 ?>
					품절
				<?php } else { //품절이 아니면 체크할수 있도록한다 ?>
					<label for="chk_it_id_<?php echo $i; ?>" class="sound_only"><?php echo $list[$i]['it_name']; ?></label>
					<input type="checkbox" name="chk_it_id[<?php echo $i; ?>]" value="1" id="chk_it_id_<?php echo $i; ?>" onclick="out_cd_check(this, '<?php echo $list[$i]['out_cd']; ?>');">
				<?php } ?>
          
              <div class="thumb">
	            <?php if($list[$i]['img']['src']) {?>
					<img src="<?php echo $list[$i]['img']['src'];?>" alt="<?php echo $list[$i]['img']['alt'];?>">
				<?php } else { ?>
					<i class="fa fa-camera img-fa"></i>
				<?php } ?>
	          </div>
	          <p><?php echo $list[$i]['it_brand'];?></p>
	        <a href="./item.php?it_id=<?php echo $list[$i]['it_id']; ?>"><h4><?php echo $list[$i]['it_name'];?></h4></a>
	        <h5><?php echo number_format($list[$i]['it_price']);?></h5>
	        <a class="del" href="./wishupdate.php?w=d&amp;wi_id=<?php echo $list[$i]['wi_id']; ?>">삭제</a>
          
      </li>
      <?php } ?>
    </ul>
</div>
       <p class="text-center">
	<button type="submit" class="btn btn-black btn-sm" onclick="return fwishlist_check(document.fwishlist,'');">장바구니 담기</button>
	<button type="submit" class="btn btn-color btn-sm" onclick="return fwishlist_check(document.fwishlist,'direct_buy');">주문하기</button>
</p>
</form>
        </div>
    </div>
    

<!---<div class="wishlist-skin">
	<table class="div-table table bg-white">
	<tbody>
	<tr class="bg-black">
		<th class="text-center" scope="col" width="60">선택</th>
		<th class="text-center" scope="col">이미지</th>
		<th class="text-center" scope="col">상품명</th>
		<th class="text-center" scope="col">보관일시</th>
		<th class="text-center" scope="col">삭제</th>
	</tr>
	<?php 
	for($i=0; $i < count($list);$i++) { 
		$list[$i]['img'] = apms_it_thumbnail($list[$i], 40, 40, false, true);	
	?>
		<tr>
			<td class="text-center">
				<?php if($list[$i]['is_soldout']) { // 품절검사 ?>
					품절
				<?php } else { //품절이 아니면 체크할수 있도록한다 ?>
					<label for="chk_it_id_<?php echo $i; ?>" class="sound_only"><?php echo $list[$i]['it_name']; ?></label>
					<input type="checkbox" name="chk_it_id[<?php echo $i; ?>]" value="1" id="chk_it_id_<?php echo $i; ?>" onclick="out_cd_check(this, '<?php echo $list[$i]['out_cd']; ?>');">
				<?php } ?>
				<input type="hidden" name="it_id[<?php echo $i; ?>]" value="<?php echo $list[$i]['it_id']; ?>">
				<input type="hidden" name="io_type[<?php echo $list[$i]['it_id']; ?>][0]" value="0">
				<input type="hidden" name="io_id[<?php echo $list[$i]['it_id']; ?>][0]" value="">
				<input type="hidden" name="io_value[<?php echo $list[$i]['it_id']; ?>][0]" value="<?php echo $list[$i]['it_name']; ?>">
				<input type="hidden" name="ct_qty[<?php echo $list[$i]['it_id']; ?>][0]" value="1">
			</td>
			<td class="text-center">
				<a href="./item.php?it_id=<?php echo $list[$i]['it_id']; ?>">
				<?php if($list[$i]['img']['src']) {?>
					<img src="<?php echo $list[$i]['img']['src'];?>" alt="<?php echo $list[$i]['img']['alt'];?>">
				<?php } else { ?>
					<i class="fa fa-camera img-fa"></i>
				<?php } ?>
				</a>
			</td>
			<td><a href="./item.php?it_id=<?php echo $list[$i]['it_id']; ?>"><?php echo stripslashes($list[$i]['it_name']); ?></a></td>
			<td class="text-center"><?php echo $list[$i]['wi_time']; ?></td>
			<td class="text-center"><a href="./wishupdate.php?w=d&amp;wi_id=<?php echo $list[$i]['wi_id']; ?>">삭제</a></td>
		</tr>
	<?php } ?>
	<?php if ($i == 0) { ?>
		<tr><td colspan="5" class="text-center text-muted" height="150">보관함이 비었습니다.</td></tr>
	<?php } ?>
	</tr>
	</tbody>
	</table>
</div>
-->


</div>
</div>
<script>
    function out_cd_check(fld, out_cd) {
        if (out_cd == 'no'){
            alert("옵션이 있습니다.\n\n클릭하여 상세내용페이지에서 옵션을 선택한 후 주문하십시오.");
            fld.checked = false;
            return;
        }

        if (out_cd == 'tel'){
            alert("전화로 문의해 주십시오.\n\n장바구니에 담아 구입하실 수 없습니다.");
            fld.checked = false;
            return;
        }
    }

    function fwishlist_check(f, act) {
        var k = 0;
        var length = f.elements.length;

        for(i=0; i<length; i++) {
            if (f.elements[i].checked) {
                k++;
            }
        }

        if(k == 0) {
            alert("하나 이상 체크 하십시오");
            return false;
        }

        if (act == "direct_buy") {
            f.sw_direct.value = 1;
        } else {
            f.sw_direct.value = 0;
        }

        return true;
    }
</script>
