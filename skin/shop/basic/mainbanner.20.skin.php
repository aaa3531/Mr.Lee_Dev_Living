<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_SKIN_URL.'/style.css">', 0);
add_javascript('<script src="'.G5_JS_URL.'/jquery.bxslider.js"></script>', 10);
?>

<?php
$max_width = $max_height = 0;
$bn_first_class = ' class="bn_first"';
$bn_slide_btn = '';
$bn_sl = ' class="bn_sl"';

$main_banners = array();
if ($i==0) ?>
   
   <div id="promo-banner">
    <div class="content">
<?php
for ($i=0; $row=sql_fetch_array($result); $i++)
{

    $main_banners[] = $row;

    
    //print_r2($row);
    // 테두리 있는지
    // 새창 띄우기인지

    $bimg = G5_DATA_PATH.'/banner/'.$row['bn_id'];
    if (file_exists($bimg))
    {
        $banner = '';
        $size = getimagesize($bimg);

        
        if($size[2] < 1 || $size[2] > 16)
            continue;

        if($max_width < $size[0])
            $max_width = $size[0];

        if($max_height < $size[1])
            $max_height = $size[1];
        
        
        if ($row['bn_url'][0] == '#')
            $banner .= '<a href="'.$row['bn_url'].'">';
        else if ($row['bn_url'] && $row['bn_url'] != 'http://') {
            $banner .= '<a href="'.G5_SHOP_URL.'/bannerhit.php?bn_id='.$row['bn_id'].'"'.$bn_new_win.'>';
        }
         echo $banner.'<img src="'.G5_DATA_URL.'/banner/'.$row['bn_id'].'" width="'.$size[0].'" alt="'.get_text($row['bn_alt']).'"'.$bn_border.'>';
        if($banner)
        echo '</a>'.PHP_EOL;
    }      
} 
?> 
           <div class="close-banner at-container">
               <input type="checkbox" value="checkbox"name="chkbox" id="chkday"/>
               <label for="chkday">오늘하루 그만보기</label>
               <a id="banner-close" href="#">닫기</a>
           </div>
     </div>
</div>
