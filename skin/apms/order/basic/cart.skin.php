<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$skin_url.'/style.css" media="screen">', 0);

// 목록헤드
if(isset($wset['chead']) && $wset['chead']) {
	add_stylesheet('<link rel="stylesheet" href="'.G5_CSS_URL.'/head/'.$wset['chead'].'.css" media="screen">', 0);
	$head_class = 'list-head';
} else {
	$head_class = (isset($wset['ccolor']) && $wset['ccolor']) ? 'tr-head border-'.$wset['ccolor'] : 'tr-head border-black';
}

$g5['title'] = $member['mb_nick'].'님의 장바구니';
// 헤더 출력
if($header_skin)
	include_once('./header.php');

?>

<script src="<?php echo $skin_url;?>/shop.js"></script>

<!-- Modal -->
<div class="mypage-skin">
   <?php if($is_member){ ?>
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
    <?php } ?>
    <div class="content-wrap">
        <?php if($is_member){ ?>
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
                <li class="on"><a href="<?php echo $at_href['cart'];?>">장바구니</a></li>                
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
<!--
	             <h4>
	             	<?php //if ($member['photo']) { ?>
	             		<img src="<?php // echo $member['photo'];?>" alt="">
	             	<?php// } else { ?>
	             		<i class="fa fa-user"></i>
	             	<?php // } ?>
	             	<?php // echo $g5['title'];?>
	             </h4>
-->
             </div>
           <div class="modal fade" id="cartModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
		<div id="mod_option_box"></div>
	  </div>
    </div>
  </div>
</div>

<form name="frmcartlist" id="sod_bsk_list" method="post" action="<?php echo $action_url; ?>" class="form cart-form" role="form">
   <div class="cart-top">
        <ul>
            <li class="ck"><label for="ct_all" class="sound_only">상품 전체</label>
                <span><input type="checkbox" name="ct_all" value="1" id="ct_all" checked="checked"></span></li>
             <li><button type="button" onclick="return form_check('seldelete');" class="btn btn-black btn-block btn-sm"><i class="fa fa-times"></i> 선택삭제</button></li>
        </ul>
    </div>
    <div class="cart-cont option">
       <?php for($i=0;$i < count($item); $i++) { ?>
        <ul>
            <li class="ck">
                <label for="ct_chk_<?php echo $i; ?>" class="sound_only">상품</label>
				<input type="checkbox" name="ct_chk[<?php echo $i; ?>]" value="1" id="ct_chk_<?php echo $i; ?>" checked="checked">
            </li>
            <li class="cont">
                <div class="thumb">
                    <?php echo get_it_image($item[$i]['it_id'], 400, 400); ?>
                </div>
                <div class="words">
                   <input type="hidden" name="it_id[<?php echo $i; ?>]" value="<?php echo $item[$i]['it_id']; ?>">
					<input type="hidden" name="it_name[<?php echo $i; ?>]" value="<?php echo get_text($item[$i]['it_name']); ?>">
                    <h3>
                    <a href="./item.php?it_id=<?php echo $item[$i]['it_id'];?>"><?php echo stripslashes($item[$i]['it_name']); ?></a></h3>
                    <?php if($item[$i]['it_options']) { ?>
                        <h4><?php echo $item[$i]['it_options'];?></h4>
						<button type="button" class="btn btn-primary btn-sm btn-block mod_options">선택사항수정</button>
					<?php } ?>
                    <p><?php echo number_format($item[$i]['ct_price']); ?><b>원</b></p>
                </div>
            </li>
            <li class="price">
                <h4>상품금액 <span><?php echo number_format($item[$i]['sell_price']); ?></span> 원 + 배송비 <?php  
    if($item[$i]['ct_send_cost']=='선불'){
        echo 0 ;
    }else{
       echo $item[$i]['ct_send_cost'];
    }; ?> 원</h4>
                <p></p>
            </li>
        </ul>
        <?php } ?>
    </div>
<!--
    <div class="table-responsive">
		<table class="div-table table bsk-tbl bg-white">
        <tbody>
        <tr class="<?php echo $head_class;?>">
            <th scope="col">
                <label for="ct_all" class="sound_only">상품 전체</label>
                <span><input type="checkbox" name="ct_all" value="1" id="ct_all" checked="checked"></span>
            </th>
			<th scope="col"><span>이미지</span></th>
            <th scope="col"><span>상품명</span></th>
            <th scope="col"><span>총수량</span></th>
            <th scope="col"><span>판매가</span></th>
            <th scope="col"><span>소계</span></th>
            <th scope="col"><span>포인트</span></th>
            <th scope="col"><span class="last">배송비</span></th>
		</tr>
		<?php for($i=0;$i < count($item); $i++) { ?>
			<tr<?php echo ($i == 0) ? ' class="tr-line"' : 'class="option"';?> >
				<td class="text-center">
					<label for="ct_chk_<?php echo $i; ?>" class="sound_only">상품</label>
					<input type="checkbox" name="ct_chk[<?php echo $i; ?>]" value="1" id="ct_chk_<?php echo $i; ?>" checked="checked">
				</td>
				<td class="text-center">
					<div class="item-img">
						<?php echo get_it_image($item[$i]['it_id'], 100, 100); ?>
						<div class="item-type">
							<?php echo $item[$i]['pt_it']; ?>
						</div>
					</div>
				</td>
				<td>
					<input type="hidden" name="it_id[<?php echo $i; ?>]" value="<?php echo $item[$i]['it_id']; ?>">
					<input type="hidden" name="it_name[<?php echo $i; ?>]" value="<?php echo get_text($item[$i]['it_name']); ?>">
					<a href="./item.php?it_id=<?php echo $item[$i]['it_id'];?>">
						<b><?php echo stripslashes($item[$i]['it_name']); ?></b>
					</a>
					<?php if($item[$i]['it_options']) { ?>
						<div class="well well-sm"><?php echo $item[$i]['it_options'];?></div>
						<button type="button" class="btn btn-primary btn-sm btn-block mod_options">선택사항수정</button>
					<?php } ?>
				</td>
				<td class="text-center"><?php echo number_format($item[$i]['qty']); ?></td>
				<td class="text-right"><?php echo number_format($item[$i]['ct_price']); ?></td>
				<td class="text-right"><span id="sell_price_<?php echo $i; ?>"><?php echo number_format($item[$i]['sell_price']); ?></span></td>
				<td class="text-right"><?php echo number_format($item[$i]['point']); ?></td>
				<td class="text-center"><?php echo $item[$i]['ct_send_cost']; ?></td>
			</tr>
		<?php } ?>
        <?php if ($i == 0) { ?>
            <tr><td colspan="8" class="text-center text-muted"><p style="padding:50px 0;">장바구니가 비어 있습니다.</p></td></tr>
		<?php } ?>
        </tbody>
        </table>
    </div>
-->
    <?php if ($tot_price > 0 || $send_cost > 0) { ?>
		<div class="well bg-white">
			<div class="row">
				
				<?php if ($tot_price > 0) { ?>
					<div class="col-xs-6">총 상품 금액</div>
					<div class="col-xs-6 text-right">
						<strong><?php echo number_format($tot_price); ?> 원 / 포인트 <?php echo number_format($tot_point); ?> 점</strong>
					</div>
				<?php } ?>
					<div class="col-xs-6">배송비</div>
					<div class="col-xs-6 text-right">
						<strong><?php echo number_format($send_cost); ?> 원</strong>
					</div>
					<div class="col-xs-6">결제금액</div>
					<div class="col-xs-6 text-right">
						<strong><?php
    $ver_cost = $tot_price + $send_cost;
                            echo number_format($ver_cost);?>
     원</strong>
					</div>
			</div>
		</div>
	<?php } ?>
    
    <div style="margin-bottom:15px; text-align:center;">
        <?php if ($i == 0) { ?>
	        <a href="<?php echo G5_SHOP_URL; ?>/" class="btn btn-color btn-sm">계속하기</a>
        <?php } else { ?>
			<input type="hidden" name="url" value="./orderform.php">
			<input type="hidden" name="records" value="<?php echo $i; ?>">
			<input type="hidden" name="act" value="">
			<div class="row">
				<div class="col-sm-6 col-sm-offset-3">
					<div class="form-group">
						<button type="button" onclick="return form_check('buy');" class="btn btn-color btn-block btn-lg">주문하기</button>
					</div>
				</div>
			</div>
<!--
			<div class="row">
				<div class="col-sm-6 col-sm-offset-3">
					<div class="btn-group btn-group-justified">
						<div class="btn-group">
							<a href="<?php echo G5_SHOP_URL; ?>/list.php?ca_id=<?php echo $continue_ca_id; ?>" class="btn btn-black btn-block btn-sm"><i class="fa fa-cart-plus"></i> 계속하기</a>
						</div>
						<div class="btn-group">
							<button type="button" onclick="return form_check('seldelete');" class="btn btn-black btn-block btn-sm"><i class="fa fa-times"></i> 선택삭제</button>
						</div>
						<div class="btn-group">
							<button type="button" onclick="return form_check('alldelete');" class="btn btn-black btn-block btn-sm"><i class="fa fa-trash"></i> 비우기</button>
						</div>
					</div>
					<?php if ($naverpay_button_js) { ?>
						<div style="margin-top:20px;"><?php echo $naverpay_request_js.$naverpay_button_js; ?></div>
					<?php } ?>
				</div>
			</div>
-->
		<?php } ?>
    </div>

</form>

<?php if($setup_href) { ?>
	<p class="text-center">
		<a class="btn btn-color btn-sm win_memo" href="<?php echo $setup_href;?>">
			<i class="fa fa-cogs"></i> 스킨설정
		</a>
	</p>
<?php } ?>
        </div>
<?php } else { ?>
   <div class="page-guest-info">
        <div class="sub-title">
	             <h4>
	             	장바구니
	             </h4>
             </div>
           <div class="modal fade" id="cartModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
		<div id="mod_option_box"></div>
	  </div>
    </div>
  </div>
</div>

<form name="frmcartlist" id="sod_bsk_list" method="post" action="<?php echo $action_url; ?>" class="form cart-form" role="form">
    <div class="cart-top">
        <ul>
            <li class="ck"><label for="ct_all" class="sound_only">상품 전체</label>
                <span><input type="checkbox" name="ct_all" value="1" id="ct_all" checked="checked"></span></li>
             <li><button type="button" onclick="return form_check('seldelete');" class="btn btn-black btn-block btn-sm"><i class="fa fa-times"></i> 선택삭제</button></li>
        </ul>
    </div>
    <div class="cart-cont option">
       <?php for($i=0;$i < count($item); $i++) { ?>
        <ul>
            <li class="ck">
                <label for="ct_chk_<?php echo $i; ?>" class="sound_only">상품</label>
				<input type="checkbox" name="ct_chk[<?php echo $i; ?>]" value="1" id="ct_chk_<?php echo $i; ?>" checked="checked">
            </li>
            <li class="cont">
                <div class="thumb">
                    <?php echo get_it_image($item[$i]['it_id'], 400, 400); ?>
                </div>
                <div class="words">
                   <input type="hidden" name="it_id[<?php echo $i; ?>]" value="<?php echo $item[$i]['it_id']; ?>">
					<input type="hidden" name="it_name[<?php echo $i; ?>]" value="<?php echo get_text($item[$i]['it_name']); ?>">
                    <h3>
                    <a href="./item.php?it_id=<?php echo $item[$i]['it_id'];?>"><?php echo stripslashes($item[$i]['it_name']); ?></a></h3>
                    <?php if($item[$i]['it_options']) { ?>
                        <h4><?php echo $item[$i]['it_options'];?></h4>
						<button type="button" class="btn btn-primary btn-sm btn-block mod_options">선택사항수정</button>
					<?php } ?>
                    <p><?php echo number_format($item[$i]['ct_price']); ?><b>원</b></p>
                </div>
            </li>
            <li class="price">
                <h4>상품금액 <span><?php echo number_format($item[$i]['sell_price']); ?></span> 원 + 배송비 <?php  
    if($item[$i]['ct_send_cost']=='선불'){
        echo 0 ;
    }else{
       echo $item[$i]['ct_send_cost'];
    }; ?> 원</h4>
                <p></p>
            </li>
        </ul>
        <?php } ?>
    </div>
<!--
    <div class="table-responsive">
		<table class="div-table table bsk-tbl bg-white">
        <tbody>
        <tr class="<?php echo $head_class;?>">
            <th scope="col">
                <label for="ct_all" class="sound_only">상품 전체</label>
                <span><input type="checkbox" name="ct_all" value="1" id="ct_all" checked="checked"></span>
            </th>
			<th scope="col"><span>이미지</span></th>
            <th scope="col"><span>상품명</span></th>
            <th scope="col"><span>총수량</span></th>
            <th scope="col"><span>판매가</span></th>
            <th scope="col"><span>소계</span></th>
            <th scope="col"><span>포인트</span></th>
            <th scope="col"><span class="last">배송비</span></th>
		</tr>
		<?php for($i=0;$i < count($item); $i++) { ?>
			<tr<?php echo ($i == 0) ? ' class="tr-line"' : '';?>>
				<td class="text-center">
					<label for="ct_chk_<?php echo $i; ?>" class="sound_only">상품</label>
					<input type="checkbox" name="ct_chk[<?php echo $i; ?>]" value="1" id="ct_chk_<?php echo $i; ?>" checked="checked">
				</td>
				<td class="text-center">
					<div class="item-img">
						<?php echo get_it_image($item[$i]['it_id'], 300, 300); ?>
						<div class="item-type">
							<?php echo $item[$i]['pt_it']; ?>
						</div>
					</div>
				</td>
				<td>
					<input type="hidden" name="it_id[<?php echo $i; ?>]" value="<?php echo $item[$i]['it_id']; ?>">
					<input type="hidden" name="it_name[<?php echo $i; ?>]" value="<?php echo get_text($item[$i]['it_name']); ?>">
					<a href="./item.php?it_id=<?php echo $item[$i]['it_id'];?>">
						<b><?php echo stripslashes($item[$i]['it_name']); ?></b>
					</a>
					<?php if($item[$i]['it_options']) { ?>
						<div class="well well-sm"><?php echo $item[$i]['it_options'];?></div>
						<button type="button" class="btn btn-primary btn-sm btn-block mod_options">선택사항수정</button>
					<?php } ?>
				</td>
				<td class="text-center"><?php echo number_format($item[$i]['qty']); ?></td>
				<td class="text-right"><?php echo number_format($item[$i]['ct_price']); ?></td>
				<td class="text-right"><span id="sell_price_<?php echo $i; ?>"><?php echo number_format($item[$i]['sell_price']); ?></span></td>
				<td class="text-right"><?php echo number_format($item[$i]['point']); ?></td>
				<td class="text-center"><?php echo $item[$i]['ct_send_cost']; ?></td>
			</tr>
		<?php } ?>
        <?php if ($i == 0) { ?>
            <tr><td colspan="8" class="text-center text-muted"><p style="padding:50px 0;">장바구니가 비어 있습니다.</p></td></tr>
		<?php } ?>
        </tbody>
        </table>
    </div>
-->

    <?php if ($tot_price > 0 || $send_cost > 0) { ?>
		<div class="well bg-white">
			<div class="row">
				
				<?php if ($tot_price > 0) { ?>
					<div class="col-xs-6">총 상품 금액</div>
					<div class="col-xs-6 text-right">
						<strong><?php echo number_format($tot_price); ?> 원 / 포인트 <?php echo number_format($tot_point); ?> 점</strong>
					</div>
				<?php } ?>
					<div class="col-xs-6">배송비</div>
					<div class="col-xs-6 text-right">
						<strong><?php echo number_format($send_cost); ?> 원</strong>
					</div>
					<div class="col-xs-6">결제금액</div>
					<div class="col-xs-6 text-right">
						<strong><?php
    $ver_cost = $tot_price + $send_cost;
                            echo number_format($ver_cost);?>
     원</strong>
					</div>
			</div>
		</div>
	<?php } ?>

    <div style="margin-bottom:15px; text-align:center;">
        <?php if ($i == 0) { ?>
	        <a href="<?php echo G5_SHOP_URL; ?>/" class="btn btn-color btn-sm">계속하기</a>
        <?php } else { ?>
			<input type="hidden" name="url" value="./orderform.php">
			<input type="hidden" name="records" value="<?php echo $i; ?>">
			<input type="hidden" name="act" value="">
			<div class="row">
				<div class="col-sm-6 col-sm-offset-3">
					<div class="form-group">
						<button type="button" onclick="return form_check('buy');" class="btn btn-color btn-block btn-lg">주문하기</button>
					</div>
				</div>
			</div>
<!--
			<div class="row">
				<div class="col-sm-6 col-sm-offset-3">
					<div class="btn-group btn-group-justified">
						<div class="btn-group">
							<a href="<?php echo G5_SHOP_URL; ?>/list.php?ca_id=<?php echo $continue_ca_id; ?>" class="btn btn-black btn-block btn-sm"><i class="fa fa-cart-plus"></i> 계속하기</a>
						</div>
						<div class="btn-group">
							
						</div>
						<div class="btn-group">
							<button type="button" onclick="return form_check('alldelete');" class="btn btn-black btn-block btn-sm"><i class="fa fa-trash"></i> 비우기</button>
						</div>
					</div>
					<?php if ($naverpay_button_js) { ?>
						<div style="margin-top:20px;"><?php echo $naverpay_request_js.$naverpay_button_js; ?></div>
					<?php } ?>
				</div>
			</div>
-->
		<?php } ?>
    </div>

</form>

<?php if($setup_href) { ?>
	<p class="text-center">
		<a class="btn btn-color btn-sm win_memo" href="<?php echo $setup_href;?>">
			<i class="fa fa-cogs"></i> 스킨설정
		</a>
	</p>
<?php } ?>
   </div>
   <?php } ?>
    </div>
</div>



<script>
	$(function() {
		var close_btn_idx;

		// 선택사항수정
		$(".mod_options").click(function() {
			var it_id = $(this).closest(".option").find("input[name^=it_id]").val();
			var $this = $(this);
			close_btn_idx = $(".mod_options").index($(this));
			$('#cartModal').modal('show');
			$.post(
				"./cartoption.php",
				{ it_id: it_id },
				function(data) {
					$("#mod_option_form").remove();
					//$this.after("<div id=\"mod_option_frm\"></div>");
					$("#mod_option_box").html(data);
					price_calculate();
				}
			);
		});

		// 모두선택
		$("input[name=ct_all]").click(function() {
			if($(this).is(":checked"))
				$("input[name^=ct_chk]").attr("checked", true);
			else
				$("input[name^=ct_chk]").attr("checked", false);
		});

		// 옵션수정 닫기
	    $(document).on("click", "#mod_option_close", function() {
			$('#cartModal').modal('hide');
			//$("#mod_option_frm").remove();
			$("#mod_option_form").remove();
			$(".mod_options").eq(close_btn_idx).focus();
		});
		$("#win_mask").click(function () {
			$('#cartModal').modal('hide');
			//$("#mod_option_frm").remove();
			$("#mod_option_form").remove();
			$(".mod_options").eq(close_btn_idx).focus();
		});

	});

	function fsubmit_check(f) {
		if($("input[name^=ct_chk]:checked").length < 1) {
			alert("구매하실 상품을 하나이상 선택해 주십시오.");
			return false;
		}

		return true;
	}

	function form_check(act) {
		var f = document.frmcartlist;
		var cnt = f.records.value;

		if (act == "buy")
		{
			if($("input[name^=ct_chk]:checked").length < 1) {
				alert("주문하실 상품을 하나이상 선택해 주십시오.");
				return false;
			}

			f.act.value = act;
			f.submit();
		}
		else if (act == "alldelete")
		{
			f.act.value = act;
			f.submit();
		}
		else if (act == "seldelete")
		{
			if($("input[name^=ct_chk]:checked").length < 1) {
				alert("삭제하실 상품을 하나이상 선택해 주십시오.");
				return false;
			}

			f.act.value = act;
			f.submit();
		}

		return true;
	}
</script>
