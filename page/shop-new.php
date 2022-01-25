<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가 
?>
<div id="idx_new" class="sct_wrap">
    <?php
    $list = new item_list();
    $list->set_category('10', 1);
    $list->set_list_mod(3);
    $list->set_list_row(1);
    $list->set_img_size(230, 230);
    $list->set_list_skin(G5_SHOP_SKIN_PATH.'/list.10.skin.php');
    $list->set_view('it_img', true);
    $list->set_view('it_id', true);
    $list->set_view('it_name', true);
    $list->set_view('it_basic', true);
    $list->set_view('it_cust_price', true);
    $list->set_view('it_price', true);
    $list->set_view('it_icon', true);
    $list->set_view('sns', true);
    echo $list->run();
    ?>
    </div>

<div class="h30"></div>