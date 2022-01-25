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
if ($i==0) 
    echo '<div class="store-banner">'.PHP_EOL;
    echo '<div class="banner-img slick-slider-main">'.PHP_EOL;
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
            $banner .= '<a class="sv" href="'.$row['bn_url'].'">';
        else if ($row['bn_url'] && $row['bn_url'] != 'http://') {
            $banner .= '<a class="sv" target="_blank" href="'.G5_SHOP_URL.'/bannerhit.php?bn_id='.$row['bn_id'].'"'.$bn_new_win.'>';
        }
        echo $banner.'<img class="slides-banner" src="'.G5_DATA_URL.'/banner/'.$row['bn_id'].'" width="'.$size[0].'" alt="'.get_text($row['bn_alt']).'"'.$bn_border.'>';
        if($banner)
            echo '</a>'.PHP_EOL;
    }      
}
 echo '</div>'.PHP_EOL;
   echo '</div>'.PHP_EOL;
?>
<script>
var slideIndex = 1;
showSlides(slideIndex);

function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  var i;
  var slides = document.getElementsByClassName("slides-banner");
  var sv = document.getElementsByClassName("sv");
  var aLink = document.getElementsByClassName("link-banner");
  if (n > slides.length) {slideIndex = 1}    
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "block";      
  }
  for (i = 0; i < aLink.length; i++) {
      aLink[i].className = aLink[i].className.replace(" active", "");
  }
  for (i = 0; i < sv.length; i++) {
      sv[i].className = sv[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";  
  aLink[slideIndex-1].className += " active";
  sv[slideIndex-1].className += " active";
}
</script>