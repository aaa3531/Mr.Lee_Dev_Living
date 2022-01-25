<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

$btn3 = (isset($wset['btn3']) && $wset['btn3']) ? $wset['btn3'] : 'black';

?>
<aside class="category-left">
<div class="at-container">
<ul class="ca-sub">
        <?php if($is_cate) { 
		$ca_cnt = count($cate);
		$wset['ctype'] = (isset($wset['ctype']) && $wset['ctype']) ? $wset['ctype'] : '';
		$wset['mctab'] = (isset($wset['mctab']) && $wset['mctab']) ? $wset['mctab'] : 'color';

		//탭
		$category_tabs = (isset($wset['tab']) && $wset['tab']) ? $wset['tab'] : '';
		switch($category_tabs) {
			case '-top'		: $category_tabs .= ' tabs-'.$wset['mctab'].'-top'; break;
			case '-bottom'	: $category_tabs .= ' tabs-'.$wset['mctab'].'-bottom'; break;
			case '-line'	: $category_tabs .= ' tabs-'.$wset['mctab'].'-top tabs-'.$wset['mctab'].'-bottom'; break;
			case '-btn'		: $category_tabs .= ' tabs-'.$wset['mctab'].'-bg'; break;
			case '-box'		: $category_tabs .= ' tabs-'.$wset['mctab'].'-bg'; break;
			default			: $category_tabs .= ($wset['tabline']) ? ' tabs-'.$wset['mctab'].'-top' : ' trans-top'; break;
		}

		$cate_w = ($wset['ctype'] == "2") ? apms_bunhal($ca_cnt, $wset['bunhal']) : '';				
	    ?>
            <?php for ($i=0; $i < $ca_cnt; $i++) { ?>
            <li<?php echo ($cate[$i]['on']) ? ' class="active"' : '';?>>
              <a href="./list.php?ca_id=<?php echo urlencode($cate[$i]['ca_id']);?>">
								<p><?php echo $cate[$i]['name'];?></p>
				</a>
            </li>
            <?php } ?>
					
        <?php } ?>
    </ul>
    </div>
</aside>
<!--

<div class="store-item-header">
    <?php if($nav_title) { ?>
        <h3><?php echo $nav_title;?></h3>
         <ul>
            <li>
            <span>홈<?php
					if($is_nav) {		
						$nav_cnt = count($nav);
						for($i=0;$i < $nav_cnt; $i++) { 
							$nav[$i]['cnt'] = ($nav[$i]['cnt']) ? '('.number_format($nav[$i]['cnt']).')' : '';
				?>
             </span>
            </li>
            <li>
                <a href="./list.php?ca_id=<?php echo $nav[$i]['ca_id'];?>"><span><?php echo $nav[$i]['name'];?><?php echo $nav[$i]['cnt'];?></span></a>
            </li>
            <?php } ?>
            <?php } else {
					echo ($page_nav1) ? ' > '.$page_nav1 : '';
					echo ($page_nav2) ? ' > '.$page_nav2 : '';
					echo ($page_nav3) ? ' > '.$page_nav3 : '';
					} 
				?>
         </ul>
    <?php } ?>
</div>
-->

<!--
    <section class="search-filter">
    <div class="filter">
        <h3>기획전</h3>
        <ul>
             <li>
            <a <?php echo ($sort == 'it_type5') ? 'class="on" ' : '';?>href="<?php echo $list_sort_href; ?>it_type5&amp;sortodr=desc">할인상품</a>
            </li>
            <li><a <?php echo ($sort == 'it_type2') ? 'class="on" ' : '';?>href="<?php echo $list_sort_href; ?>it_type2&amp;sortodr=desc">추천상품</a></li>
            <li>
            <a <?php echo ($sort == 'it_type3') ? 'class="on" ' : '';?>href="<?php echo $list_sort_href; ?>it_type3&amp;sortodr=desc">최신상품</a>
            </li>
            <li><a <?php echo ($sort == 'it_type4') ? 'class="on" ' : '';?>href="<?php echo $list_sort_href; ?>it_type4&amp;sortodr=desc">인기상품 기획전</a></li>
        </ul>
    </div>
</section>-->
