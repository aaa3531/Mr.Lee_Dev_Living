<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_SKIN_URL.'/style.css">', 0);
?>

<!-- 상품진열 10 시작 { -->
<?php
for ($i=1; $row=sql_fetch_array($result); $i++) {
    if ($this->list_mod >= 2) { // 1줄 이미지 : 2개 이상
        if ($i%$this->list_mod == 0) $sct_last = 'sct_last'; // 줄 마지막
        else if ($i%$this->list_mod == 1) $sct_last = 'sct_clear'; // 줄 첫번째
        else $sct_last = '';
    } else { // 1줄 이미지 : 1개
        $sct_last = 'sct_clear';
    }

    if ($i == 1) {
        if ($this->css) {
            echo "<ul class=\"{$this->css}\">\n";
        } else {
            echo "<ul class=\"store-item-li slick-slider-3 main\">\n";
        }
    }

    echo "<li>\n";

  

    if ($this->href) {
        echo "<a href=\"{$this->href}{$row['it_id']}\">\n";
    }

    if ($this->view_it_img) {
        echo "<div class=\"thumb\">\n";
        echo get_it_image($row['it_id'], $this->img_width, $this->img_height, '', '', stripslashes($row['it_name']))."\n";
        echo "</div>\n";
    }



    echo  "<div class=\"cont-bg\">\n";
        echo "<p>\n";
    echo stripslashes($row['it_brand']);
   //     echo stripslashes(
//            if($row['pt_id']) { //파트너아이디가 있으면...
//                 $mb = get_member($row['pt_id']);
//                    echo $row['mb_nick']; //회원닉네임
//               })."\n";
        echo "</p>\n";



    if ($this->view_it_name) {
        echo "<h4>".stripslashes($row['it_name'])."</h4>\n";
    }

    if ($this->view_it_cust_price || $this->view_it_price) {

        echo "<h5>\n";

        if ($this->view_it_cust_price && $row['it_cust_price']) {
            echo "<span class=\"sct_discount\">".display_price($row['it_cust_price'])."</span>\n";
        }

        if ($this->view_it_price) {
            echo display_price(get_price($row), $row['it_tel_inq'])."\n";
        }

        echo "</h5>\n";

    }

     echo  "</div>\n";
    if ($this->href) {
        echo "</a>\n";
    }
    
    echo "</li>\n";
}

if ($i > 1) echo "</ul>\n";

if($i == 1) echo "<p class=\"sct_noitem\">등록된 상품이 없습니다.</p>\n";
?>
<!-- } 상품진열 10 끝 -->