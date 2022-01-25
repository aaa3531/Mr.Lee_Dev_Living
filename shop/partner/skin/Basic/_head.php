<?php 
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가 

add_stylesheet('<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,400italic,700,800" type="text/css">',0);
add_stylesheet('<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway:300,200,100" type="text/css">',0);
add_stylesheet('<link rel="stylesheet" href="'.G5_URL.'/shop/partner/skin/Basic/assets/css/bootstrap.min.css" type="text/css" media="screen">',0);
add_stylesheet('<link rel="stylesheet" href="'.G5_URL.'/shop/partner/skin/Basic/style.css" type="text/css" media="screen">',0);
add_stylesheet('<link rel="stylesheet" href="'.G5_URL.'/js/font-awesome/css/font-awesome.min.css" type="text/css" media="screen">',0);
add_stylesheet('<link rel="icon" type="image/png" sizes="32x32" href="'.THEMA_URL.'/favi/favi-32.png">',0);
add_stylesheet('<link rel="icon" type="image/png" sizes="96x96" href="'.THEMA_URL.'/favi/favi-96.png">',0);
add_stylesheet('<link rel="icon" type="image/png" sizes="128x128" href="'.THEMA_URL.'/favi/favi-128.png">',0);
add_stylesheet('<link rel="icon" type="image/png" sizes="16x16" href="'.THEMA_URL.'/favi/favi-16.png">',0);
?>
<!--
<link rel="icon" type="image/png" sizes="32x32" href="<?php echo THEMA_URL;?>/favi/favi-32.png"> 
<link rel="icon" type="image/png" sizes="96x96" href="<?php echo THEMA_URL;?>/favi/favi-96.png"> 
<link rel="icon" type="image/png" sizes="128x128" href="<?php echo THEMA_URL;?>/favi/favi-128.png"> 
<link rel="icon" type="image/png" sizes="16x16" href="<?php echo THEMA_URL;?>/favi/favi-16.png">
-->
<script src="https://use.fontawesome.com/releases/v5.2.0/js/all.js"></script>
<link rel="stylesheet" href="<?php echo G5_URL;?>/shop/partner/skin/Basic/assets/css/furning-pt.css">
<div id="wrapper">
	<!-- Sidebar -->
	<div class="header">
	    <div class="furning-logo"><a href="<?php echo G5_URL;?>"><img src="<?php echo $skin_url;?>/images/logo-partner.svg" alt=""></a></div>
	    <div class="my-info">
	        <ul>
	            <li><a href="<?php echo G5_SHOP_URL;?>/partner/">
	                <?php echo ($member['photo']) ? '<img src="'.$member['photo'].'" alt="" class="photo">' : '<i class="fa fa-cubes fa-lg"></i>'; //사진 ?>
					<?php echo $member['mb_nick'];?>
	            </a></li>
	        </ul>
	    </div>
	    <div class="my-menu-ul">
            <h5>상품 관리</h5>
	        <ul>
                <?php if(IS_SELLER) { ?>
                <li>
				   <a href="<?php echo G5_SHOP_URL;?>/myshop.php?id=<?php echo urlencode($member['mb_id']);?>"> 파트너샵</a>
					</li>
	            <li<?php if($ap == 'item') echo ' class="active"';?>><a href="<?php echo G5_SHOP_URL;?>/partner/?ap=item">상품등록</a></li>
	            <li<?php if($ap == 'list') echo ' class="active"';?>><a href="<?php echo G5_SHOP_URL;?>/partner/?ap=list">상품조회/수정</a></li>
	            <li<?php if($ap == 'itemalarm') echo ' class="active"';?>><a href="<?php echo G5_SHOP_URL;?>/partner/?ap=itemalarm">상품알림</a></li>
	            
                
                <?php } ?>
				<?php if(IS_MARKETER) { ?>
               
                <?php } ?>
	        </ul>
	        <h5>주문 관리</h5>
	        <ul>
                <li<?php if($ap == 'searchorder') echo ' class="active"';?>><a href="<?php echo G5_SHOP_URL;?>/partner/?ap=searchorder"> 주문자 검색</a></li>
	            <li<?php if($ap == 'delivery') echo ' class="active"';?>><a href="<?php echo G5_SHOP_URL;?>/partner/?ap=delivery"> 주문/배송 관리</a></li>
	            <li<?php if($ap == 'sendcost') echo ' class="active"';?>><a href="<?php echo G5_SHOP_URL;?>/partner/?ap=sendcost"> 배송 비용</a></li>
	            <li<?php if($ap == 'cancelitem') echo ' class="active"';?>><a href="<?php echo G5_SHOP_URL;?>/partner/?ap=cancelitem"> 취소 관리</a></li>
	            <li<?php if($ap == 'returned') echo ' class="active"';?>><a href="<?php echo G5_SHOP_URL;?>/partner/?ap=returned">반품 관리</a></li>
	            <li<?php if($ap == 'saleitem') echo ' class="active"';?>><a href="<?php echo G5_SHOP_URL;?>/partner/?ap=saleitem"> 판매 완료내역</a></li>
	        </ul>
	        <h5>정산 관리</h5>
	        <ul> 
	            <li<?php if($ap == 'paylist') echo ' class="active"';?>><a href="<?php echo G5_SHOP_URL;?>/partner/?ap=paylist">정산 관리</a></li>
	            <li<?php if($ap == 'costrev') echo ' class="active"';?>><a href="<?php echo G5_SHOP_URL;?>/partner/?ap=costrev">송금 완료</a></li>
	        </ul>
	        <h5>고객 관리</h5>  
              <ul>
               <li<?php if($ap == 'comment') echo ' class="active"';?>><a href="<?php echo G5_SHOP_URL;?>/partner/?ap=comment">고객 관리</a></li> 
	           <li<?php if($ap == 'qalist') echo ' class="active"';?>><a href="<?php echo G5_SHOP_URL;?>/partner/?ap=qalist">상품문의내역</a></li> 
               <li<?php if($ap == 'uselist') echo ' class="active"';?>><a href="<?php echo G5_SHOP_URL;?>/partner/?ap=uselist">리뷰 관리</a></li>
            </ul>
            <h5>입점사 정보</h5>
            <ul>
                <li<?php if($ap == 'editpartner') echo ' class="active"';?>><a href="<?php echo G5_SHOP_URL;?>/partner/?ap=editpartner">입점사 정보관리</a></li>
            </ul>
            <h5>통계</h5>
            <ul>
                <li<?php if($ap == 'salelist') echo ' class="active"';?>><a href="<?php echo G5_SHOP_URL;?>/partner/?ap=salelist">매출 분석</a></li>
                <li<?php if($ap == 'viewsale') echo ' class="active"';?>><a href="<?php echo G5_SHOP_URL;?>/partner/?ap=viewsale">통계요약</a></li>
            </ul>
	        <h5>고객센터</h5>
            <ul>
                <li<?php if($bo_table == 'partner_notice') echo ' class="active"';?>><a href="<?php echo G5_URL;?>/bbs/board.php?bo_table=partner_notice">공지사항</a></li>
                <li<?php if($ap == 'faq_part') echo ' class="active"';?>><a href="<?php echo G5_SHOP_URL;?>/partner/?ap=faq_part">판매자 온라인문의</a></li>
            </ul>
	    </div>
	</div>
	
	<div id="page-wrapper">
