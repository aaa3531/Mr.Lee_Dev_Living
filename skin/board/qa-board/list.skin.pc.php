<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>

<div class="table-responsive list-table">
	<table class="table list-tbl">
	<thead>
	<tr class="list-head">
		<?php if ($is_checkbox) { ?>
		<th scope="col">
			<label for="chkall" class="sound_only">현재 페이지 게시물 전체</label>
			<input type="checkbox" id="chkall" onclick="if (this.checked) all_checked(true); else all_checked(false);">
		</th>
		<?php } ?>
		<th scope="col">번호</th>
		<?php if($is_category) { ?>
			<th scope="col">분류</th>
		<?php } ?>
		<th scope="col">제목</th>
		<th scope="col">글쓴이</th>
		<th scope="col"><?php echo subject_sort_link('wr_datetime', $qstr2, 1) ?>날짜</a></th>
		<th scope="col"><?php echo subject_sort_link('wr_hit', $qstr2, 1) ?>상태</a></th>
		<?php if ($is_good) { ?><th scope="col"><?php echo subject_sort_link('wr_good', $qstr2, 1) ?>추천</a></th><?php } ?>
		<?php if ($is_nogood) { ?><th scope="col"><?php echo subject_sort_link('wr_nogood', $qstr2, 1) ?>비추</a></th><?php } ?>
	</tr>
	</thead>
	<tbody>
	<?php for ($i=0; $i<count($list); $i++) { 

			// 공지, 현재글 스타일 체크
			if ($wr_id == $list[$i]['wr_id']) {
				$tr_css = ' class="list-now"';
				$subject_css = ' now';
				$num = "<span class=\"red\">열람중</span>";
			} else if ($list[$i]['is_notice']) { // 공지사항
				$tr_css = ' class="active"';
				$subject_css = ' notice';
				$num = '<img src="'.$board_skin_url.'/img/icon_notice.gif" alt=""><strong class="sound_only">공지</strong>';
			} else {
				$tr_css = $subject_css = '';
				$num = '<span class="en">'.$list[$i]['num'].'</span>';
			}		
	
	?>
	<tr<?php echo $tr_css; ?>>
		<?php if ($is_checkbox) { ?>
			<td class="text-center">
				<label for="chk_wr_id_<?php echo $i ?>" class="sound_only"><?php echo $list[$i]['subject'] ?></label>
				<input type="checkbox" name="chk_wr_id[]" value="<?php echo $list[$i]['wr_id'] ?>" id="chk_wr_id_<?php echo $i ?>">
			</td>
		<?php } ?>
		<td class="text-center font-11">
			<?php echo $num;?>
		</td>
		<?php if ($is_category) { ?>
			<td class="text-center">
				<a href="<?php echo $list[$i]['ca_name_href'] ?>"><span class="text-muted font-11"><?php echo $list[$i]['ca_name'] ?></span></a>
			</td>
		<?php } ?>
		<td class="list-subject<?php echo $subject_css;?>">

			<a href="<?php echo $list[$i]['href'] ?>">
				
				<?php echo $list[$i]['subject'] ?>
				<?php if ($list[$i]['comment_cnt']) { ?>
					<span class="sound_only">댓글</span><span class="list-cnt"><?php echo $list[$i]['comment_cnt']; ?></span><span class="sound_only">개</span>
				<?php } ?>
				<?php
							if($list[$i]['wr_10']=="답변대기"){
					$response ='<span style="color:rgb(41, 41, 41)">답변대기</span>';
				} else{
					$response ='<span style="color:rgb(223, 17, 25)">답변완료</span>';
				}

					if (isset($list[$i]['icon_secret'])) echo PHP_EOL.$list[$i]['icon_secret'];
					if (isset($list[$i]['icon_new'])) echo PHP_EOL.$list[$i]['icon_new'];
					if (isset($list[$i]['icon_hot'])) echo PHP_EOL.$list[$i]['icon_hot'];
					if (isset($list[$i]['icon_file'])) echo PHP_EOL.$list[$i]['icon_file'];
					if (isset($list[$i]['icon_link'])) echo PHP_EOL.$list[$i]['icon_link'];
				 ?>
			</a>
		</td>
		<td><b><?php echo $list[$i]['name'] ?></b></td>
		<td class="text-right en font-11"><?php echo apms_datetime($list[$i]['date']); ?></td>
		<td class="td_name"><?php echo $response ?></td>
		<?php if ($is_good) { ?><td class="text-center en font-11"><?php echo $list[$i]['wr_good'] ?></td><?php } ?>
		<?php if ($is_nogood) { ?><td class="text-center en font-11"><?php echo $list[$i]['wr_nogood'] ?></td><?php } ?>
	</tr>


                </a>

                <?php
				

                 ?>


	<?php } ?>
	<?php if (count($list) == 0) { echo '<tr><td colspan="'.$colspan.'" class="text-center text-muted list-none">게시물이 없습니다.</td></tr>'; } ?>
	</tbody>
	</table>
</div>
