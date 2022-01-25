<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가 
include_once(THEMA_PATH.'/assets/thema.php');
?>
<link rel="stylesheet" href="<?php echo THEMA_URL;?>/assets/css/furning.css" type="text/css">
<meta http-equiv="Pragma" content="no-cache">
<script src="<?php echo THEMA_URL;?>/assets/js/script.js"></script>
<div id="thema_wrapper" class="wrapper <?php echo $is_thema_layout;?> <?php echo $is_thema_font;?>">
       <script>
    $(document).ready(function(){
        
        var mobileOpenBtn = $('#mobile-button');
    var mobileMenu = $('.mobile-menu');
    var mobileCloseBtn = $('.mobile-close');
    var windowWidth = $(window).width();
    
    mobileOpenBtn.click(function(){
        mobileMenu.show();
        mobileMenu.stop().animate({
            right: 0,
            opacity:1
        });
    });
    mobileCloseBtn.click(function(){
        mobileMenu.stop().animate({
            right: -300,
            opacity:0
        },function(){
            mobileMenu.hide();
        });
    });
    function checkwidth(){
        if(windowWidth > 1024){
        mobileMenu.hide();
        }
    }
    checkwidth();
    $(window).resize(checkwidth);
        
    var searchBtn = $('.searchbtn');
    var searchBg = $('.search-div');
    var backBg = $('.main-search-btn');
    var backBg2 = $('.at-body');
    var backBg3 = $('.main-lnb');
    var backBg4 = $('.lnb');
    var backBg5 = $('.sub-menu');
    var backBg6 = $('.store-banner');
    var backBg7 = $('.page-wrap');
    var backBg8 = $('.event');
    var backBg9 = $('.category-left');
    var backBg10 = $('.fur-4');
    var openbind = 0;
    searchBtn.click(function(){
        searchBg.addClass('open');
        openbind = 1;
        console.log(openbind); 
    });
       backBg.click(function(e){
                searchBg.removeClass('open');
                openbind = 0;
                console.log(openbind);
            });
       backBg2.click(function(e){
                searchBg.removeClass('open');
                openbind = 0;
                console.log(openbind);
            });
       backBg3.click(function(e){
                searchBg.removeClass('open');
                openbind = 0;
                console.log(openbind);
            });
         backBg4.click(function(e){
                searchBg.removeClass('open');
                openbind = 0;
                console.log(openbind);
            });
         backBg5.click(function(e){
                searchBg.removeClass('open');
                openbind = 0;
                console.log(openbind);
            });
         backBg6.click(function(e){
                searchBg.removeClass('open');
                openbind = 0;
                console.log(openbind);
            });
         backBg7.click(function(e){
                searchBg.removeClass('open');
                openbind = 0;
                console.log(openbind);
            });
         backBg8.click(function(e){
                searchBg.removeClass('open');
                openbind = 0;
                console.log(openbind);
            });
           backBg9.click(function(e){
                searchBg.removeClass('open');
                openbind = 0;
                console.log(openbind);
            });
           backBg10.click(function(e){
                searchBg.removeClass('open');
                openbind = 0;
                console.log(openbind);
            });
    });
    </script>
	<!-- LNB -->
	<script>
        function setCookie( name, value, expiredays ) { 
		var todayDate = new Date(); 
		todayDate.setDate( todayDate.getDate() + expiredays ); 
		document.cookie = name + "=" + escape( value ) + "; path=/; expires=" + todayDate.toGMTString() + ";" 
	}

	$(document).ready(function(){
		$("#promo-banner #banner-close").click(function(){
			//오늘만 보기 체크박스의 체크 여부를 확인 해서 체크되어 있으면 쿠키를 생성한다.
			if($("#chkday").is(':checked')){
				setCookie( "topPop", "done" , 1 ); 
				//alert("쿠키를 생성하였습니다.");
			}
			//팝업창을 위로 애니메이트 시킨다. 혹은 slideUp()
			//$('#promotionBanner').animate({height: 0}, 500);
			$('#promo-banner').slideUp(500); 
		});
	   });
    </script>
	<!-- LNB -->
   <!--   상단 띠배너 -->
<!--
   <?php echo display_banner('상단', 'mainbanner.20.skin.php','1'); ?>
   <script language="Javascript">
	//저장된 해당 쿠키가 있으면 창을 안 띄운다 없으면 뛰운다.
	    cookiedata = document.cookie;    
	    if ( cookiedata.indexOf("topPop=done") < 0 ){      
		    document.all['promo-banner'].style.display = "block";
         } 
	    else {
	    	document.all['promo-banner'].style.display = "none"; 
	    }
    </script>
-->
	<header>
	    <div class="header-left">
	        <ul>
	            <li><a href="http://www.furning.kr" target="_blank">입점안내</a></li>
	            <li><a href="#">회사소개</a></li>
	            <li><a href="<?php echo G5_URL; ?>/bbs/faq.php">고객센터</a></li>
	           
	        </ul>
	    </div>
	    <div class="logo">
	        <a href="<?php echo G5_URL; ?>">
	            <img class="logo-pc" src="<?php echo THEMA_URL;?>/assets/img/logo.svg" alt="">
	        </a>
	    </div>
		
   <!-- LNB Right -->
			<div class="right-menu">
				<ul>
					<?php if($is_member) { // 로그인 상태 ?>
                            <li>
								<a href="<?php echo $at_href['cart'];?>"> 
<!--									<img src="<?php echo THEMA_URL;?>/assets/img/cart.svg" alt="장바구니">-->
                              <span>장바구니</span>
								</a>
							</li>
					    <?php if($member['mb_1'] =='customer'){ ?>
					       <li><a href="<?php echo G5_URL; ?>/bbs/mypage.php">
<!--					       <img src="<?php echo THEMA_URL;?>/assets/img/mypage.svg" alt="마이페이지">-->
                          <span>마이페이지</span>
					       </a></li>
					    <?php } ?>
						<?php if($member['mb_1'] =='partner'){ ?>
						 <li><a href="<?php echo G5_URL; ?>/bbs/mypage.php">
						 <!--					       <img src="<?php echo THEMA_URL;?>/assets/img/mypage.svg" alt="마이페이지">-->
                          <span>마이페이지</span></a></li>
						 <?php } ?>
						<?php if($member['admin']) {?>
						    <li><a href="<?php echo G5_URL; ?>/bbs/mypage.php"><!--					       <img src="<?php echo THEMA_URL;?>/assets/img/mypage.svg" alt="마이페이지">-->
                          <span>마이페이지</span></a></li>
							<li><a href="<?php echo G5_ADMIN_URL;?>">
<!--							<img src="<?php echo THEMA_URL;?>/assets/img/admin.svg" alt="관리자 모드">-->
                           <span>관리자</span>
							</a></li>
						<?php } ?>
						<?php if($member['mb_1']=='partner' && !$member['partner']){?>
						    <li><a href="<?php echo G5_URL; ?>/shop/partner/register.php">
<!--						    <img src="<?php echo THEMA_URL;?>/assets/img/partner.svg" alt="파트너 등록">-->
                           <span>파트너등록</span>
						    </a></li>
						<?php } ?>
						<?php if($member['partner']&&$member['mb_1']=='partner') { ?>
							<li><a href="<?php echo $at_href['myshop'];?>">
<!--							<img src="<?php echo THEMA_URL;?>/assets/img/partner.svg" alt="파트너샵 관리">-->
                        <span>파트너샵 관리</span>
							</a></li>
						<?php } ?>
						<?php if($member['admin']) { ?>
						    <li><a href="<?php echo $at_href['myshop'];?>">
	<!--							<img src="<?php echo THEMA_URL;?>/assets/img/partner.svg" alt="파트너샵 관리">-->
                        <span>파트너샵 관리</span>
						    </a></li>
						  <?php } ?>
						  
						<li class="sidebarLabel"<?php echo ($member['response'] || $member['memo']) ? '' : ' style="display:none;"';?>>
							<a href="<?php echo $at_href['response'];?>"> 
<!--								<img src="<?php echo THEMA_URL;?>/assets/img/alarm.svg" alt="알람">-->
                        <span>알림</span>
							</a>
						</li>
					<?php } else { // 로그아웃 상태 ?>
                    <li><a href="<?php echo G5_URL; ?>/shop/orderinquiry.php">비회원 주문조회</a></li>
                          <li><a href="<?php echo G5_URL; ?>/bbs/login.php">로그인</a></li>
					     <?php if($member['cart'] || $member['today']) { ?>
							<li>
								<a href="<?php echo $at_href['cart'];?>"> 
									장바구니
								</a>
							</li>
						<?php } else { ?>
                            <li>
								<a href="<?php echo $at_href['cart'];?>"> 
									장바구니
								</a>
							</li>
                       <?php  } ?>		
					<?php } ?>
					<?php if(IS_YC) { // 영카트 사용하면 ?>
						
					<?php } ?>
					<?php if($is_member) { ?>
						<li><a href="<?php echo $at_href['logout'];?>">
<!--						<img src="<?php echo THEMA_URL;?>/assets/img/logout.svg" alt="로그아웃">-->
                     <span>로그아웃</span>
						</a></li>
					<?php } ?>
					 <li class="searchbtn"></li>
	            <form name="tsearch" method="get" onsubmit="return tsearch_submit(this);" role="form" class="form">
				<input type="hidden" name="url"	value="<?php echo G5_URL; ?>/bbs/search.php">
					<div class="search-div">
						<input autocomplete="off" id="main-search" type="text" name="stx" class="main-search" value="<?php echo $stx;?>" placeholder="검색어를 입력해주세요">
						<span class="input-group-btn">
							<button type="submit" class="main-search-btn"><img src="<?php echo THEMA_URL;?>/assets/img/search-icon.svg" alt=""></button>
						</span>
						<script>
                        $(document).ready(function(){
                            $('#main-search').val('');
                        });
                        </script>
						<?php echo apms_widget('basic-keyword', $wid.'-fc93'); ?>
					</div>
				</form>
				</ul>
			</div>
    </header>
     <?php if(defined('_INDEX_')){ ?>
    <div class="lnb main-lnb">
  <?php } else { ?>
    <div class="lnb">
    <?php } ?>
			<!-- LNB Left -->
			<div class="mobile-button" id="mobile-button">
			    <img src="<?php echo THEMA_URL;?>/assets/img/mobile-menu.svg" alt="">
			</div>
			 <div class="nav-main">
                <ul class="menu">
                    <li <?php echo ($gr_id=='community' || $pid == 'faq' ||  $pid == 'qalist' ||$hid =='fur-content' ||$hid =='fur-tomorrow'  ) ? 'class="on" ' : 'class="off"';?>class="menu-li">
                        <a class="menu-a nav-height" href="<?php echo G5_URL; ?>/bbs/main.php?gid=community">커뮤니티</a>
                    </li>
                    <li  <?php echo ($gr_id=='shop' ||  $hid == 'best-store' ||  $hid == 'new-store' || ($ca_id >= '10' && $ca_id <='19') || ($ca_id >='1010' && $ca_id <='1099') || ($ca_id >= '20' && $ca_id <='29') || ($ca_id >='2010' && $ca_id <='2099')) ? 'class="on" ' : 'class="off"';?>class="menu-li">
                        <a class="menu-a nav-height" href="<?php echo G5_URL; ?>/bbs/main.php?gid=shop">
							스토어
						</a>
                    </li>
                    <li  <?php echo ($gr_id=='rental' ||  $hid == 'rental-best' ||  $hid == 'new-rental'|| ($ca_id >= '30' && $ca_id <='39') || ($ca_id >='3010' && $ca_id <='3099') || ($ca_id >= '40' && $ca_id <='49') || ($ca_id >='4010' && $ca_id <='4099')) ? 'class="on" ' : 'class="off"';?>class="menu-li">
                        <a class="menu-a nav-height" href="<?php echo G5_URL; ?>/bbs/main.php?gid=rental">
							렌탈전용
						</a>
                    </li>
                    <li <?php echo ($hid =='fur-all-shop' || $bo_table =='fur_all_shop'  ) ? 'class="on" ' : 'class="off"';?>class="menu-li">
                        <a class="menu-a nav-height" href="<?php echo G5_URL; ?>/bbs/page.php?hid=fur-all-shop">업체검색</a>
                    </li>
                    <li <?php echo ($bo_table =='event') ? 'class="on" ' : 'class="off"';?>class="menu-li">
                        <a href="<?php echo G5_URL; ?>/bbs/board.php?bo_table=event">이벤트</a>
                    </li>
                    
                </ul>
            </div>		
   </div>
    <div class="mobile-menu">
       <div class="mobile-close"></div>
        <div class="my-menu">
            <ul>
					<?php if($is_member) { // 로그인 상태 ?>
                            <li>
								<a href="<?php echo $at_href['cart'];?>"> 
									<img src="<?php echo THEMA_URL;?>/assets/img/cart.svg" alt="">
								</a>
							</li>
					    <?php if($member['mb_1'] =='customer'){ ?>
					       <li><a href="<?php echo G5_URL; ?>/bbs/mypage.php"><img src="<?php echo THEMA_URL;?>/assets/img/mypage.svg" alt=""></a></li>
					    <?php } ?>
						<?php if($member['mb_1'] =='partner'){ ?>
						 <li><a href="<?php echo G5_URL; ?>/bbs/mypage.php"><img src="<?php echo THEMA_URL;?>/assets/img/mypage.svg" alt=""></a></li>
						 <?php } ?>
						<?php if($member['admin']) {?>
						    <li><a href="<?php echo G5_URL; ?>/bbs/mypage.php"><img src="<?php echo THEMA_URL;?>/assets/img/mypage.svg" alt=""></a></li>
							<li><a href="<?php echo G5_ADMIN_URL;?>"><img src="<?php echo THEMA_URL;?>/assets/img/admin.svg" alt=""></a></li>
						<?php } ?>
						<?php if($member['mb_1']=='partner' && !$member['partner']){?>
						    <li><a href="<?php echo G5_URL; ?>/shop/partner/register.php"><img src="<?php echo THEMA_URL;?>/assets/img/partner.svg" alt=""></a></li>
						<?php } ?>
						<?php if($member['partner']&&$member['mb_1']=='partner') { ?>
							<li><a href="<?php echo $at_href['myshop'];?>"><img src="<?php echo THEMA_URL;?>/assets/img/partner.svg" alt=""></a></li>
						<?php } ?>
						<?php if($member['admin']) { ?>
						    <li><a href="<?php echo $at_href['myshop'];?>"><img src="<?php echo THEMA_URL;?>/assets/img/partner.svg" alt=""></a></li>
						  <?php } ?>
						<li class="sidebarLabel"<?php echo ($member['response'] || $member['memo']) ? '' : ' style="display:none;"';?>>
							<a href="<?php echo $at_href['response'];?>"> 
								<img src="<?php echo THEMA_URL;?>/assets/img/alarm.svg" alt="">
							</a>
						</li>
					<?php } else { // 로그아웃 상태 ?>
						
						<?php if($member['cart'] || $member['today']) { ?>
							<li>
								<a href="<?php echo $at_href['cart'];?>"> 
									<img src="<?php echo THEMA_URL;?>/assets/img/cart.svg" alt="">
								</a>
							</li>
						<?php } else { ?>
                            <li>
								<a href="<?php echo $at_href['cart'];?>"> 
									<img src="<?php echo THEMA_URL;?>/assets/img/cart.svg" alt="">
								</a>
							</li>
                       <?php  } ?>
                       <li class="login"><a href="<?php echo G5_URL; ?>/bbs/login.php">로그인/회원가입</a></li>
						<li class="inquiry"><a href="<?php echo G5_URL; ?>/shop/orderinquiry.php">비회원 주문조회</a></li>
					<?php } ?>
					<?php if($is_member) { ?>
						<li><a href="<?php echo $at_href['logout'];?>"><img src="<?php echo THEMA_URL;?>/assets/img/logout.svg" alt=""></a></li>
					<?php } ?>
				</ul>
        </div>
        <div class="mobile-search">
				<form name="tsearch" method="get" onsubmit="return tsearch_submit(this);" role="form" class="form">
				<input type="hidden" name="url"	value="<?php echo G5_URL; ?>/bbs/search.php">
					<div>
						<input type="text" name="stx" class="main-search" value="<?php echo $stx;?>" placeholder="검색어를 입력해주세요">
						<span class="input-group-btn">
							<button type="submit" class="main-search-btn"><img src="<?php echo THEMA_URL;?>/assets/img/search-icon.svg" alt=""></button>
						</span>
					</div>
				</form>
			</div>
			<div class="mobile-main">
                <ul class="menu">
                    <li class="menu-li off">
                        <a class="menu-a nav-height" href="<?php echo G5_URL; ?>/bbs/main.php?gid=community">커뮤니티</a>
                       <ul class="sub-dl">
          <li class="sub-1dli off">
              <a href="<?php echo G5_URL; ?>/bbs/main.php?gid=community" class="sub-1da">홈</a>
          </li>
          <li class="sub-1dli off">
              <a href="<?php echo G5_URL; ?>/bbs/board.php?bo_table=free_board" class="sub-1da">자유게시판</a>
          </li>
          <li class="sub-1dli off">
              <a href="<?php echo G5_URL; ?>/bbs/board.php?bo_table=tomorrow" class="sub-1da">내일의 가게</a>
          </li>
          <li class="sub-1dli off">
              <a href="<?php echo G5_URL; ?>/bbs/page.php?hid=fur-content" class="sub-1da">Parks 컨텐츠</a>
          </li>
          <li class="sub-1dli off">
              <a href="<?php echo G5_URL; ?>/bbs/board.php?bo_table=knowledge" class="sub-1da">묻고답하기</a>
          </li>
        </ul>
                    </li>
                    <li class="menu-li off">
                        <a class="menu-a nav-height" href="<?php echo G5_URL; ?>/bbs/main.php?gid=shop">
							스토어
						</a>
                       <ul class="sub-dl">
          <li class="sub-1dli off">
              <a href="<?php echo G5_URL; ?>/bbs/main.php?gid=shop" class="sub-1da">홈</a>
          </li>
          <li class="sub-1dli off">
              <a href="<?php echo G5_URL; ?>/shop/list.php?ca_id=10" class="sub-1da store-cat">종류별</a>
          </li>
          <li class="sub-1dli off">
              <a href="<?php echo G5_URL; ?>/shop/list.php?ca_id=40" class="sub-1da">업종별</a>
          </li>
          <li class="sub-1dli off">
              <a href="<?php echo G5_URL; ?>/bbs/page.php?hid=best-store" class="sub-1da">베스트</a>
          </li>
          <li class="sub-1dli off">
              <a href="<?php echo G5_URL; ?>/bbs/page.php?hid=new-store" class="sub-1da">최신상품</a>
          </li>
        </ul>
                    </li>
                    <li class="menu-li off">
                        <a class="menu-a nav-height" href="<?php echo G5_URL; ?>/bbs/main.php?gid=rental">렌탈전용</a>
                       <ul class="sub-dl">
          <li class="sub-1dli off">
              <a href="<?php echo G5_URL; ?>/bbs/main.php?gid=rental" class="sub-1da">홈</a>
          </li>
          <li class="sub-1dli off">
              <a href="<?php echo G5_URL; ?>/shop/list.php?ca_id=30" class="sub-1da store-cat">종류별</a>       
          </li>
          <li class="sub-1dli off">
              <a href="<?php echo G5_URL; ?>/shop/list.php?ca_id=40" class="sub-1da">업종별</a>
          </li>
          <li class="sub-1dli off">
              <a href="<?php echo G5_URL; ?>/bbs/page.php?hid=rental-best" class="sub-1da">베스트</a>
          </li>
          <li class="sub-1dli off">
              <a href="<?php echo G5_URL; ?>/bbs/page.php?hid=new-rental" class="sub-1da">최신상품</a>
          </li>
        </ul>
                    </li>
<!--
                    <li class="menu-li off">
                        <a class="menu-a nav-height" href="<?php echo G5_URL; ?>/bbs/main.php?gid=used">중고판매</a>
                        <ul class="sub-dl">
          <li class="sub-1dli off">
              <a href="<?php echo G5_URL; ?>/bbs/main.php?gid=used" class="sub-1da">홈</a>
          </li>
          <li class="sub-1dli off">
              <a href="<?php echo G5_URL; ?>/shop/list.php?ca_id=50" class="sub-1da store-cat">종류별</a>       
          </li>
          <li class="sub-1dli off">
              <a href="<?php echo G5_URL; ?>/shop/list.php?ca_id=60" class="sub-1da">업종별</a>
          </li>
          <li class="sub-1dli off">
              <a href="<?php echo G5_URL; ?>/bbs/page.php?hid=best-used" class="sub-1da">베스트</a>
          </li>
          <li class="sub-1dli off">
              <a href="<?php echo G5_URL; ?>/bbs/page.php?hid=new-used" class="sub-1da">최신상품</a>
          </li>
        </ul>
                    </li>
-->
                    <li class="menu-li off">
                        <a class="menu-a nav-height" href="<?php echo G5_URL; ?>/bbs/page.php?hid=fur-all-shop">업체검색</a>
                    </li>
                </ul>
            </div> 
            <div class="mobile-customer">
             <ul class="right-mobile">
            <li><a href="http://furning.kr" target="_blank">입점안내</a></li>
            <li><a href="<?php echo G5_URL; ?>/bbs/qalist.php">고객센터</a></li>
            <li><a href="<?php echo G5_URL; ?>/bbs/board.php?bo_table=event">이벤트</a></li>
             </ul>   
        </div>   
    </div>
	<!-- PC Header -->
	<!--   sup header	-->
<?php if(defined('_INDEX_') || $bo_table == 'event' || $hid=='fur-all-shop' || $bo_table == 'fur_all_shop') { ?>
<?php } else {?> 
<div class="sub-menu">
    <div  class="at-container">
         <?php if($gr_id=='community' ||  $pid == 'faq' ||  $pid == 'qalist' ||  $hid =='fur-content' ||$hid =='fur-tomorrow'){ ?>
          <ul class="sub-dl">
          <li class="sub-1dli off">
              <a href="<?php echo G5_URL; ?>/bbs/main.php?gid=community" class="sub-1da">홈</a>
          </li>
          <li class="sub-1dli off">
              <a href="<?php echo G5_URL; ?>/bbs/board.php?bo_table=free_board" class="sub-1da">자유게시판</a>
          </li>
          <li class="sub-1dli off">
              <a href="<?php echo G5_URL; ?>/bbs/board.php?bo_table=tomorrow" class="sub-1da">내일의 가게</a>
          </li>
          <li class="sub-1dli off">
              <a href="<?php echo G5_URL; ?>/bbs/page.php?hid=fur-content" class="sub-1da">Parks 컨텐츠</a>
          </li>
          <li class="sub-1dli off">
              <a href="<?php echo G5_URL; ?>/bbs/board.php?bo_table=knowledge" class="sub-1da">묻고답하기</a>
          </li>
        </ul>
        <?php } else if($gr_id=='shop' || ($ca_id >= '10' && $ca_id <='19') || ($ca_id >='1010' && $ca_id <='1099') || ($ca_id >= '20' && $ca_id <='29') || ($ca_id >='2010' && $ca_id <='2099') || $hid == 'best-store' || $hid == 'new-store' ){ ?>
          <ul class="sub-dl">
          <li class="sub-1dli off">
              <a <?php echo ($gid == 'shop') ? 'class="on" ' : '';?> href="<?php echo G5_URL; ?>/bbs/main.php?gid=shop" class="sub-1da">홈</a>
          </li>
          <li class="sub-1dli off">
              <a <?php echo (($ca_id >= '10' && $ca_id <='19') || ($ca_id >='1010' && $ca_id <='1099')) ? 'class="on" ' : '';?>href="<?php echo G5_URL; ?>/shop/list.php?ca_id=10" class="sub-1da store-cat">종류별</a>
          </li>
          <li class="sub-1dli off">
              <a <?php echo (($ca_id >= '20' && $ca_id <='29') || ($ca_id >='2010' && $ca_id <='2099')) ? 'class="on" ' : '';?>href="<?php echo G5_URL; ?>/shop/list.php?ca_id=20" class="sub-1da store-s-cat">업종별</a>
          </li>
          <li class="sub-1dli off">
              <a <?php echo ($hid == 'best-store') ? 'class="on" ' : '';?>href="<?php echo G5_URL; ?>/bbs/page.php?hid=best-store" class="sub-1da">베스트</a>
          </li>
          <li class="sub-1dli off">
              <a <?php echo ($hid == 'new-store') ? 'class="on" ' : '';?>href="<?php echo G5_URL; ?>/bbs/page.php?hid=new-store" class="sub-1da">최신상품</a>
          </li>
        </ul>
<!--
        <section id="s2" class="category-top store-category-top">
        <ul class="at-container top-ca-sub">
<?php 
$hsql = " select ca_id, ca_name from {$g5['g5_shop_category_table']} where length(ca_id) = '2' and ca_use = '1' order by ca_order, ca_id ";
$hresult = sql_query($hsql); 
$row=sql_fetch_array($hresult);
$row['ca_id'] = 10;
$sql2 = " select ca_id, ca_name from {$g5['g5_shop_category_table']} where LENGTH(ca_id) = '4' and SUBSTRING(ca_id,1,2) = '{$row['ca_id']}' and ca_use = '1' order by ca_order, ca_id ";
$result2 = sql_query($sql2);
if($row['ca_id'] == 10){
        for ($j = 0; $row2 = sql_fetch_array($result2); $j++) { ?>             	
	               	<li>
	               		<a href="<?php echo G5_URL; ?>/shop/list.php?ca_id=<?php echo $row2['ca_id']; ?>">
                       <img src="<?php echo THEMA_URL;?>/assets/img/t-<?php echo $row2['ca_id']; ?>.png" alt="">
	                    <?php echo $row2['ca_name']; ?>
	               </a>
	           </li>
	              <?php }
          } ?>
    </ul>
</section>	
-->
<!--
       <section id="s2" class="category-top store-s-category-top">
        <ul class="at-container top-ca-sub">
<?php 
$hsql = " select ca_id, ca_name from {$g5['g5_shop_category_table']} where length(ca_id) = '2' and ca_use = '1' order by ca_order, ca_id ";
$hresult = sql_query($hsql); 
$row=sql_fetch_array($hresult);
$row['ca_id'] = 20;
$sql2 = " select ca_id, ca_name from {$g5['g5_shop_category_table']} where LENGTH(ca_id) = '4' and SUBSTRING(ca_id,1,2) = '{$row['ca_id']}' and ca_use = '1' order by ca_order, ca_id ";
$result2 = sql_query($sql2);
if($row['ca_id'] == 20){
        for ($j = 0; $row2 = sql_fetch_array($result2); $j++) { ?>             	
	               	<li>
	               		<a href="<?php echo G5_URL; ?>/shop/list.php?ca_id=<?php echo $row2['ca_id']; ?>">
                        <img src="<?php echo THEMA_URL;?>/assets/img/t-<?php echo $row2['ca_id']; ?>.png" alt="">
	                    <?php echo $row2['ca_name']; ?>
	               </a>
	           </li>
	              <?php }
          } ?>
    </ul>
</section>	
-->
        <?php } else if($gr_id == 'rental' || ($ca_id >= '30' && $ca_id <='39') || ($ca_id >='3010' && $ca_id <='3099') || ($ca_id >= '40' && $ca_id <='49') || ($ca_id >='4010' && $ca_id <='4099') || $hid == 'rental-best' || $hid == 'new-rental'){ ?>
          <ul class="sub-dl">
          <li class="sub-1dli off">
              <a href="<?php echo G5_URL; ?>/bbs/main.php?gid=rental" class="sub-1da">홈</a>
          </li>
          <li class="sub-1dli off">
              <a <?php echo (($ca_id >= '30' && $ca_id <='39') || ($ca_id >='3010' && $ca_id <='3099')) ? 'class="on" ' : '';?>href="<?php echo G5_URL; ?>/shop/list.php?ca_id=30" class="sub-1da">종류별</a>
          </li>
          <li class="sub-1dli off">
              <a <?php echo (($ca_id >= '40' && $ca_id <='49') || ($ca_id >='4010' && $ca_id <='4099')) ? 'class="on" ' : '';?> href="<?php echo G5_URL; ?>/shop/list.php?ca_id=40" class="sub-1da">업종별</a>
          </li>
          <li class="sub-1dli off">
              <a <?php echo ($hid== 'rental-best') ? 'class="on" ' : '';?>href="<?php echo G5_URL; ?>/bbs/page.php?hid=rental-best" class="sub-1da">베스트</a>
          </li>
          <li class="sub-1dli off">
              <a <?php echo ($hid== 'new-rental') ? 'class="on" ' : '';?>href="<?php echo G5_URL; ?>/bbs/page.php?hid=new-rental" class="sub-1da">최신상품</a>
          </li>
        </ul>
<!--
        <section id="s2" class="category-top store-category-top">
        <ul class="at-container top-ca-sub">
<?php 
$hsql = " select ca_id, ca_name from {$g5['g5_shop_category_table']} where length(ca_id) = '2' and ca_use = '1' order by ca_order, ca_id ";
$hresult = sql_query($hsql); 
$row=sql_fetch_array($hresult);
$row['ca_id'] = 30;
$sql2 = " select ca_id, ca_name from {$g5['g5_shop_category_table']} where LENGTH(ca_id) = '4' and SUBSTRING(ca_id,1,2) = '{$row['ca_id']}' and ca_use = '1' order by ca_order, ca_id ";
$result2 = sql_query($sql2);
if($row['ca_id'] == 30){
    for ($j = 0; $row2 = sql_fetch_array($result2); $j++) { ?>             	
	               	<li>
	               		<a href="<?php echo G5_URL; ?>/shop/list.php?ca_id=<?php echo $row2['ca_id']; ?>">
                       <img src="<?php echo THEMA_URL;?>/assets/img/t-<?php echo $row2['ca_id']; ?>.png" alt="">
	                    <?php echo $row2['ca_name']; ?>
	               </a>
	           </li>
	              <?php }
          } ?>
    </ul>
</section>	
-->
<!--
       <section id="s2" class="category-top store-s-category-top">
        <ul class="at-container top-ca-sub">
<?php 
$hsql = " select ca_id, ca_name from {$g5['g5_shop_category_table']} where length(ca_id) = '2' and ca_use = '1' order by ca_order, ca_id ";
$hresult = sql_query($hsql); 
$row=sql_fetch_array($hresult);
$row['ca_id'] = 40;
$sql2 = " select ca_id, ca_name from {$g5['g5_shop_category_table']} where LENGTH(ca_id) = '4' and SUBSTRING(ca_id,1,2) = '{$row['ca_id']}' and ca_use = '1' order by ca_order, ca_id ";
$result2 = sql_query($sql2);
if( $row['ca_id'] == 40){
    for ($j = 0; $row2 = sql_fetch_array($result2); $j++) { ?>             	
	               	<li>
	               		<a href="<?php echo G5_URL; ?>/shop/list.php?ca_id=<?php echo $row2['ca_id']; ?>">
                        <img src="<?php echo THEMA_URL;?>/assets/img/t-<?php echo $row2['ca_id']; ?>.png" alt="">
	                    <?php echo $row2['ca_name']; ?>
	               </a>
	           </li>
	              <?php }
     }?>
    </ul>
</section>	
-->
        <?php } else if($gr_id=='used' || ($ca_id >= '50' && $ca_id <='59') || ($ca_id >='5010' && $ca_id <='5099') || ($ca_id >= '60' && $ca_id <='69') || ($ca_id >='6010' && $ca_id <='6099') || $hid == 'best-used'|| $hid == 'new-used'){ ?>
          <ul class="sub-dl">
          <li class="sub-1dli off">
              <a href="<?php echo G5_URL; ?>/bbs/main.php?gid=used" class="sub-1da">홈</a>
          </li>
          <li class="sub-1dli off">
              <a href="<?php echo G5_URL; ?>/shop/list.php?ca_id=50" class="sub-1da store-cat">종류별</a>       
          </li>
          <li class="sub-1dli off">
              <a href="<?php echo G5_URL; ?>/shop/list.php?ca_id=60" class="sub-1da store-s-cat">업종별</a>
          </li>
          <li class="sub-1dli off">
              <a href="<?php echo G5_URL; ?>/bbs/page.php?hid=best-used" class="sub-1da">베스트</a>
          </li>
          <li class="sub-1dli off">
              <a href="<?php echo G5_URL; ?>/bbs/page.php?hid=new-used" class="sub-1da">최신상품</a>
          </li>
        </ul>
<!--
        <section id="s2" class="category-top store-category-top">
        <ul class="at-container top-ca-sub">
<?php 
$hsql = " select ca_id, ca_name from {$g5['g5_shop_category_table']} where length(ca_id) = '2' and ca_use = '1' order by ca_order, ca_id ";
$hresult = sql_query($hsql); 
$row=sql_fetch_array($hresult);
$row['ca_id'] = 50;
$sql2 = " select ca_id, ca_name from {$g5['g5_shop_category_table']} where LENGTH(ca_id) = '4' and SUBSTRING(ca_id,1,2) = '{$row['ca_id']}' and ca_use = '1' order by ca_order, ca_id ";
$result2 = sql_query($sql2);
if($row['ca_id']  == 50){
    for ($j = 0; $row2 = sql_fetch_array($result2); $j++) { ?>             	
	               	<li>
	               		<a href="<?php echo G5_URL; ?>/shop/list.php?ca_id=<?php echo $row2['ca_id']; ?>">
                       <img src="<?php echo THEMA_URL;?>/assets/img/t-<?php echo $row2['ca_id']; ?>.png" alt="">
	                    <?php echo $row2['ca_name']; ?>
	               </a>
	           </li>
	              <?php }
} ?>
    </ul>
</section>	
       <section id="s2" class="category-top store-s-category-top">
        <ul class="at-container top-ca-sub">
<?php 
$hsql = " select ca_id, ca_name from {$g5['g5_shop_category_table']} where length(ca_id) = '2' and ca_use = '1' order by ca_order, ca_id ";
$hresult = sql_query($hsql); 
$row=sql_fetch_array($hresult);
$row['ca_id'] = 60;
$sql2 = " select ca_id, ca_name from {$g5['g5_shop_category_table']} where LENGTH(ca_id) = '4' and SUBSTRING(ca_id,1,2) = '{$row['ca_id']}' and ca_use = '1' order by ca_order, ca_id ";
$result2 = sql_query($sql2);
if($row['ca_id'] == 60){
    for ($j = 0; $row2 = sql_fetch_array($result2); $j++) { ?>             	
	               	<li>
	               		<a href="<?php echo G5_URL; ?>/shop/list.php?ca_id=<?php echo $row2['ca_id']; ?>">
                        <img src="<?php echo THEMA_URL;?>/assets/img/t-<?php echo $row2['ca_id']; ?>.png" alt="">
	                    <?php echo $row2['ca_name']; ?>
	               </a>
	           </li>
	              <?php }
} ?>
    </ul>
</section>	
-->
       <?php } else {  } ?>
<!--
        <ul class="right-sub">
            <li><a href="http://furning.kr" target="_blank">입점안내</a></li>
            <li><a href="<?php echo G5_URL; ?>/bbs/board.php?bo_table=event">이벤트</a></li>
            <li><a href="#">고객센터</a>
                <ul class="right-sub-ul">
                    <li><a href="<?php echo G5_URL; ?>/bbs/faq.php">자주하는 질문</a></li>
                    <li><a href="<?php echo G5_URL; ?>/bbs/qalist.php">1:1문의</a></li>
                    <li><a href="<?php echo G5_URL; ?>/bbs/board.php?bo_table=notice">공지 사항</a></li>
                </ul>
            </li>
        </ul>
-->
    </div>
</div>
<?php } ?>
	<!-- Mobile Header -->
	<header class="m-header">
		<div class="at-container">
			<div class="header-wrap">
				<div class="header-icon">
					<a href="javascript:;" onclick="sidebar_open('sidebar-user');">
						<i class="fa fa-user"></i>
					</a>
				</div>
				<div class="header-logo en">
					<!-- Mobile Logo -->
				</div>
				<div class="header-icon">
					<a href="javascript:;" onclick="sidebar_open('sidebar-search');">
						<i class="fa fa-search"></i>
					</a>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
	</header>

	<!-- Menu -->
	<nav>
		<!-- Mobile Menu -->
		<div class="m-menu">
			<?php// include_once(THEMA_PATH.'/menu-m.php');	// 메뉴 불러오기 ?>
		</div><!-- .m-menu -->
	</nav><!-- .at-menu -->

	<div class="clearfix"></div>
	
	<?php if($page_title) { // 페이지 타이틀 ?>
		<div class="at-title">
			<div class="at-container">
				<div class="page-title en">
					<strong<?php echo ($bo_table) ? " class=\"cursor\" onclick=\"go_page('".G5_BBS_URL."/board.php?bo_table=".$bo_table."');\"" : "";?>>
						<?php echo $page_title;?>
					</strong>
				</div>
				<?php if($page_desc) { // 페이지 설명글 ?>
					<div class="page-desc hidden-xs">
						<?php echo $page_desc;?>
					</div>
				<?php } ?>
				<div class="clearfix"></div>
			</div>
		</div>
	<?php } ?>
<?php if ($hid == 'fur-tomorrow' || $hid =='fur-content' || $bo_table == 'tomorrow' || $gr_id=='community'|| $pid=='myshop' || $pid == 'faq'  || $pid == 'mypage' || $pid == 'wishlist' ||$gr_id== 'shop'|| $gr_id== 'rental' || $hid=='fur-all-shop' || $bo_table == 'fur_all_shop' || $bo_table == 'event' || $bo_table == 'notice'  ||  $bo_table == 'free_board'|| ($ca_id >= '10' && $ca_id <='4099') || $hid == 'best-store' ||  $hid == 'rental-best' ||  $hid == 'new-rental' ||  $hid == 'new-store'){ ?>
    
<?php } else { ?>
<div class="at-body">
		<?php if($col_name) { ?>
			<div class="at-container">
			<?php if($col_name == "two") { ?>
				<div class="row at-row">
					<div class="col-md-<?php echo $col_content;?><?php echo ($at_set['side']) ? ' pull-right' : '';?> at-col at-main">		
			<?php } else { ?>
			    <div class="at-content">
            <?php } ?>
	<?php } else if($pid == 'faq'){ ?>
		   <div class="faq-bg">
		  <?php } ?>

<?php } ?>