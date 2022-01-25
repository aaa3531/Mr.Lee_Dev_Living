<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>
<div class="notice gall-list">
    <h3>소문난 가게를 소개합니다.</h3>
    <ul>
        <?php 
        for ($i=0; $i < $list_cnt; $i++) { 
                $list[$i]['no_img'] = $board_skin_url.'/img/no-img.jpg'; // No-Image
                $img = apms_wr_thumbnail($bo_table, $list[$i], $thumb_w, $thumb_h, false, true);
             if(!$list[$i]['is_notice']) break; //공지가 아니면 끝냄 
		?>
        <li>
           <a href="<?php echo $list[$i]['href'];?>">
           <div class="thumb">
               <?php echo $wr_label;?>
				<?php if ($is_checkbox) { ?>
					<div class="label-tack">
						<input type="checkbox" name="chk_wr_id[]" value="<?php echo $list[$i]['wr_id'] ?>" id="chk_wr_id_<?php echo $i ?>">
					</div>	
				<?php } ?>
                <img src="<?php echo $img['src'];?>" alt="<?php echo $img['alt'];?>">
           </div>
           <h4><?php echo $list[$i]['subject'];?></h4>
           <h5><div class="photo-thumb">
            <?php echo ($member['photo']) ? '<img src="'.$member['photo'].'" alt="">' : '<i class="fa fa-user"></i>'; ?>
            </div><?php echo $list[$i]['name'];?></h5>
           <?php $sql = " select count(*) as cnt from {$g5['scrap_table']} where bo_table = '$bo_table' and wr_id = '$wr_id' ";
           $row = sql_fetch($sql);
           $scrap_count = $row['cnt'];?>
           <h6>스크랩 <?php echo $scrap_count; ?> | 좋아요 <?php echo $list[$i]['wr_good'] ?> | 구경 <?php echo $list[$i]['wr_hit'] //조회수 ?></h6>
           </a>
        </li>
        <?php } ?>
    </ul>
</div>
