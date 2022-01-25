<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
$btn3 = (isset($wset['btn3']) && $wset['btn3']) ? $wset['btn3'] : 'black';
?>
 <div class="item-partner-info">
        <div class="at-container">
        <div class="heading-info">
            <h3>파트너샵</h3>
            <?php if($author['partner']) { ?>
            <h2><?php echo $author['mb_3']?></h2>
            <h4><?php echo $author['mb_4']?></h4>
				<?php } ?>
        </div>
        <div class="info-list">
            <div class="info-pic">
                <?php echo ($author['photo']) ? '<img src="'.$author['photo'].'" alt="">' : '<i class="fa fa-user"></i>'; ?>
            </div>
            <div class="info-content">
                <h3><?php echo $author['name']; ?>
                <button type="button" class="btn btn-color btn-sm" onclick="apms_like('<?php echo $author['mb_id'];?>', 'like', 'it_like'); return false;" title="Like">좋아요</button>
                <button type="button" class="btn btn-color btn-sm" onclick="apms_like('<?php echo $author['mb_id'];?>', 'follow', 'it_follow'); return false;" title="Follow">팔로우</button>
                </h3>
                <h4>Lv.<?php echo $author['level'];?> | <b><?php echo $author['grade'];?></b></h4>
                <p>좋아요 <?php echo number_format($author['liked']) ?>  | 팔로우 <?php echo $author['followed']; ?></p>
<!--
                <div class="div-progress progress progress-striped no-margin">
					<div class="progress-bar progress-bar-exp" role="progressbar" aria-valuenow="<?php echo round($author['exp_per']);?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo round($author['exp_per']);?>%;">
						<span class="sr-only"><?php echo number_format($author['exp']);?> (<?php echo $author['exp_per'];?>%)</span>
					</div>
				</div>
-->
                <h5><a href="http://<?php echo $author['mb_homepage'];?>"><?php echo $author['mb_homepage'];?></a></h5>
                
            </div>
        </div>
        </div>
    </div>	
    <div class="at-container">
<section class="search-filter">
    <div class="filter myshop">
        <h3>카테고리</h3>
        <div class="input-group">
				<span class="input-group-addon"><i class="fa fa-tags"></i></span>
				<select name="ca_id" onchange="location='./myshop.php?id=<?php echo $id;?>&ca_id=' + this.value;" class="form-control input-sm">
					<option value="">카테고리</option>
					<?php echo $category_options;?>
				</select>
			</div>
    </div>
    <div class="filter">
        <h3>필터</h3>
        <ul>
            <li>
            <a <?php echo ($sort == 'it_price' && $sortodr == 'desc') ? 'class="on" ' : '';?>href="<?php echo $list_sort_href; ?>it_price&amp;sortodr=desc">높은가격순</a>
            </li>
            <li>
            <a <?php echo ($sort == 'it_price' && $sortodr == 'asc') ? 'class="on" ' : '';?>href="<?php echo $list_sort_href; ?>it_price&amp;sortodr=asc">낮은가격순</a>
            </li>
            <li>
            <a <?php echo ($sort == 'it_sum_qty') ? 'class="on" ' : '';?>href="<?php echo $list_sort_href; ?>it_sum_qty&amp;sortodr=desc">인기순</a>
            </li>
            <li>
            <a <?php echo ($sort == 'it_use_avg') ? 'class="on" ' : '';?>href="<?php echo $list_sort_href; ?>it_use_avg&amp;sortodr=desc">평점순</a>
            </li>
            <li>
            <a <?php echo ($sort == 'it_use_cnt') ? 'class="on" ' : '';?>href="<?php echo $list_sort_href; ?>it_use_cnt&amp;sortodr=desc">후기순</a>
            </li>
            <li>
            <a <?php echo ($sort == 'it_update_time') ? 'class="on" ' : '';?>href="<?php echo $list_sort_href; ?>it_update_time&amp;sortodr=desc">최신순</a>
            </li>
           
        </ul>
    </div>
<!--
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
-->
</section>
