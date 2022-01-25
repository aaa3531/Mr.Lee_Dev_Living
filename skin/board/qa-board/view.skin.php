<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$view_skin_url.'/view.css" media="screen">', 0);

$attach_list = '';
if (implode('', $view['link'])) {
	// 링크
	for ($i=1; $i<=count($view['link']); $i++) {
		if ($view['link'][$i]) {
			$attach_list .= '<a class="list-group-item break-word" href="'.$view['link_href'][$i].'" target="_blank">';
			$attach_list .= '<span class="label label-warning pull-right view-cnt">'.number_format($view['link_hit'][$i]).'</span>';
			$attach_list .= '<i class="fa fa-link"></i> '.cut_str($view['link'][$i], 70).'</a>'.PHP_EOL;
		}
	}
}

// 가변 파일
$j = 0;
for ($i=0; $i<count($view['file']); $i++) {
	if (isset($view['file'][$i]['source']) && $view['file'][$i]['source'] && !$view['file'][$i]['view']) {
		if ($board['bo_download_point'] < 0 && $j == 0) {
			$attach_list .= '<a class="list-group-item"><i class="fa fa-bell red"></i> 다운로드시 <b>'.number_format(abs($board['bo_download_point'])).'</b>'.AS_MP.' 차감 (최초 1회 / 재다운로드시 차감없음)</a>'.PHP_EOL;
		}
		$file_tooltip = '';
		if($view['file'][$i]['content']) {
			$file_tooltip = ' data-original-title="'.strip_tags($view['file'][$i]['content']).'" data-toggle="tooltip"';
		}
		$attach_list .= '<a class="list-group-item break-word view_file_download at-tip" href="'.$view['file'][$i]['href'].'"'.$file_tooltip.'>';
		$attach_list .= '<span class="label label-primary pull-right view-cnt">'.number_format($view['file'][$i]['download']).'</span>';
		$attach_list .= '<i class="fa fa-download"></i> '.$view['file'][$i]['source'].' ('.$view['file'][$i]['size'].') &nbsp;';
		$attach_list .= '<span class="en font-11 text-muted"><i class="fa fa-clock-o"></i> '.apms_datetime(strtotime($view['file'][$i]['datetime']), "Y.m.d").'</span></a>'.PHP_EOL;
		$j++;
	}
}

?>
<div class="at-container">
<h1>
	<?php if($view['photo']) { ?><span class="talker-photo hidden-xs"><?php echo $view['photo'];?></span><?php } ?><?php echo cut_str(get_text($view['wr_subject']), 70); ?>
</h1>

<div class="panel panel-default view-head<?php echo ($attach_list) ? '' : ' no-attach';?>">
	<div class="panel-heading">
		<div class="font-12 text-muted">
			<i class="fa fa-user"></i>
			<?php echo $view['name']; //등록자 ?><?php echo ($is_ip_view) ? '<span class="hidden-xs">&nbsp;('.$ip.')</span>' : ''; ?>
			<?php if($view['ca_name']) { ?>
				<span class="hidden-xs">
					<span class="sp"></span>
					<i class="fa fa-tag"></i>
					<?php echo $view['ca_name']; //분류 ?>
				</span>
			<?php } ?>

			<span class="sp"></span>
			<i class="fa fa-comment"></i>
			<?php echo ($view['wr_comment']) ? '<b class="red">'.number_format($view['wr_comment']).'</b>' : 0; //댓글수 ?>

			<span class="sp"></span>
			<i class="fa fa-eye"></i>
			<?php echo number_format($view['wr_hit']); //조회수 ?>

			<span class="hidden-xs pull-right">
				<i class="fa fa-clock-o"></i>
				<?php echo apms_datetime($view['date'], 'Y.m.d H:i'); //시간 ?>
			</span>
		</div>
	</div>
   <?php
		if($attach_list) {
			echo '<div class="list-group font-12">'.$attach_list.'</div>'.PHP_EOL;
		}
	?>
</div>

<?php if ($is_torrent) { // 토렌트 파일정보 ?>
	<?php for($i=0; $i < count($torrent); $i++) { ?>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-share-alt fa-lg"></i> <?php echo $torrent[$i]['name'];?></h3>
			</div>
			<div class="panel-body">
				<span class="pull-right hidden-xs text-muted en font-11"><i class="fa fa-clock-o"></i> <?php echo date("Y-m-d H:i", $torrent[$i]['date']);?></span>
				<?php if ($torrent[$i]['is_size']) { ?>
						<b class="en font-16"><i class="fa fa-cube"></i> <?php echo $torrent[$i]['info']['name'];?> (<?php echo $torrent[$i]['info']['size'];?>)</b>
				<?php } else { ?>
					<p><b class="en font-16"><i class="fa fa-cube"></i> Total <?php echo $torrent[$i]['info']['total_size'];?></b></p>
					<div class="text-muted font-12">
						<?php for ($j=0;$j < count($torrent[$i]['info']['file']);$j++) { 
							echo ($j + 1).'. '.implode(', ', $torrent[$i]['info']['file'][$j]['name']).' ('.$torrent[$i]['info']['file'][$j]['size'].')<br>'."\n";
						} ?>
					</div>
				<?php } ?>
			</div>
			<ul class="list-group">
				<li class="list-group-item en font-14 break-wrod"><i class="fa fa-magnet"></i> <?php echo $torrent[$i]['magnet'];?></li>
				<li class="list-group-item break-word">
					<div class="text-muted font-12">
						<?php for ($j=0;$j < count($torrent[$i]['tracker']);$j++) { ?>
							<i class="fa fa-tags"></i> <?php echo $torrent[$i]['tracker'][$j];?><br>
						<?php } ?>
					</div>
				</li>
				<?php if($torrent[$i]['comment']) { ?>
					<li class="list-group-item en font-14 break-word"><i class="fa fa-bell"></i> <?php echo $torrent[$i]['comment'];?></li>
				<?php } ?>
			</ul>
		</div>
	<?php } ?>
<?php } ?>

<?php
	// 이미지 상단 출력
	$v_img_count = count($view['file']);
	if($v_img_count && $is_img_head) {
		echo '<div class="view-img">'.PHP_EOL;
		for ($i=0; $i<=count($view['file']); $i++) {
			if ($view['file'][$i]['view']) {
				echo get_view_thumbnail($view['file'][$i]['view']);
			}
		}
		echo '</div>'.PHP_EOL;
	}
 ?>

<div class="view-content">
	<?php echo get_view_thumbnail($view['content']); ?>
</div>

<?php
	// 이미지 하단 출력
	if($v_img_count && $is_img_tail) {
		echo '<div class="view-img">'.PHP_EOL;
		for ($i=0; $i<=count($view['file']); $i++) {
			if ($view['file'][$i]['view']) {
				echo get_view_thumbnail($view['file'][$i]['view']);
			}
		}
		echo '</div>'.PHP_EOL;
	}
?>

<?php if ($good_href || $nogood_href) { ?>
	<div class="view-good-box">
		<?php if ($good_href) { ?>
			<span class="view-good">
				<a href="#" onclick="apms_good('<?php echo $bo_table;?>', '<?php echo $wr_id;?>', 'good', 'wr_good'); return false;">
					<b id="wr_good"><?php echo number_format($view['wr_good']) ?></b>
					<br>
					<i class="fa fa-thumbs-up"></i>
				</a>
			</span>
		<?php } ?>
		<?php if ($nogood_href) { ?>
			<span class="view-nogood">
				<a href="#" onclick="apms_good('<?php echo $bo_table;?>', '<?php echo $wr_id;?>', 'nogood', 'wr_nogood'); return false;">
					<b id="wr_nogood"><?php echo number_format($view['wr_nogood']) ?></b>
					<br>
					<i class="fa fa-thumbs-down"></i>
				</a>
			</span>
		<?php } ?>
	</div>
	<p></p>
<?php } ?>

<?php if ($is_tag) { // 태그 ?>
	<p class="view-tag font-12"><i class="fa fa-tags"></i> <?php echo $tag_list;?></p>
<?php } ?>

<div class="view-icon">
	<div class="pull-right">
		<div class="form-group">
			<?php if ($scrap_href) { ?>
				<a href="<?php echo $scrap_href;  ?>" target="_blank" class="btn btn-black btn-xs" onclick="win_scrap(this.href); return false;"><i class="fa fa-tags"></i> <span class="hidden-xs">스크랩</span></a>
			<?php } ?>
			<?php if ($is_shingo) { ?>
				<button onclick="apms_shingo('<?php echo $bo_table;?>', '<?php echo $wr_id;?>');" class="btn btn-black btn-xs"><i class="fa fa-bell"></i> <span class="hidden-xs">신고</span></button>
			<?php } ?>
			<?php if ($is_admin) { ?>
				<?php if ($view['is_lock']) { // 글이 잠긴상태이면 ?>
					<button onclick="apms_shingo('<?php echo $bo_table;?>', '<?php echo $wr_id;?>', 'unlock');" class="btn btn-black btn-xs"><i class="fa fa-unlock"></i> <span class="hidden-xs">해제</span></button>
				<?php } else { ?>
					<button onclick="apms_shingo('<?php echo $bo_table;?>', '<?php echo $wr_id;?>', 'lock');" class="btn btn-black btn-xs"><i class="fa fa-lock"></i> <span class="hidden-xs">잠금</span></button>
				<?php } ?>
			<?php } ?>
		</div>
	</div>
	<div class="pull-left">
		<div class="form-group">
			<?php include_once(G5_SNS_PATH."/view.sns.skin.php"); // SNS ?>
		</div>
	</div>
	<div class="clearfix"></div>
</div>

<?php if($is_signature) { // 서명 ?>
	<div class="panel panel-default view-author">
		<div class="panel-heading">
			<h3 class="panel-title">
				<?php if($author['partner']) { ?>
					<a href="<?php echo $at_href['myshop'];?>?id=<?php echo $author['mb_id'];?>" class="pull-right">
						<span class="label label-primary"><span class="font-11 en">My Shop</span></span>
					</a>
				<?php } ?>
				Author
			</h3>
		</div>
		<div class="panel-body">
			<div class="pull-left text-center auth-photo">
				<div class="img-photo">
					<?php echo ($author['photo']) ? '<img src="'.$author['photo'].'" alt="">' : '<i class="fa fa-user"></i>'; ?>
				</div>
				<div class="btn-group" style="margin-top:-30px;white-space:nowrap;">
					<button type="button" class="btn btn-color btn-sm" onclick="apms_like('<?php echo $author['mb_id'];?>', 'like', 'it_like'); return false;" title="Like">
						<i class="fa fa-thumbs-up"></i> <span id="it_like"><?php echo number_format($author['liked']) ?></span>
					</button>
					<button type="button" class="btn btn-color btn-sm" onclick="apms_like('<?php echo $author['mb_id'];?>', 'follow', 'it_follow'); return false;" title="Follow">
						<i class="fa fa-users"></i> <span id="it_follow"><?php echo $author['followed']; ?></span>
					</button>
				</div>
			</div>
			<div class="auth-info">
				<div style="margin-bottom:4px;">
					<span class="pull-right">Lv.<?php echo $author['level'];?></span>
					<b><?php echo $author['name']; ?></b> &nbsp;<span class="text-muted font-11"><?php echo $author['grade'];?></span>
				</div>
				<div class="div-progress progress progress-striped no-margin">
					<div class="progress-bar progress-bar-exp" role="progressbar" aria-valuenow="<?php echo round($author['exp_per']);?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo round($author['exp_per']);?>%;">
						<span class="sr-only"><?php echo number_format($author['exp']);?> (<?php echo $author['exp_per'];?>%)</span>
					</div>
				</div>
				<p style="margin-top:10px;">
					<?php echo ($signature) ? $signature : '등록된 서명이 없습니다.'; ?>
				</p>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>	
<?php } ?>

<h3 class="view-comment">Comments</h3>

<?php include_once('./view_comment.php'); ?>

<div class="clearfix"></div>

	<div class="view-btn">
		<div class="btn-group btn-group-justified">
			<?php if ($prev_href) { ?>
				<a href="<?php echo $prev_href ?>" class="btn btn-black btn-sm" title="이전글">
					<i class="fa fa-chevron-circle-left big-fa"></i><span class="hidden-xs">이전</span>
				</a>
			<?php } ?>
			<?php if ($next_href) { ?>
				<a href="<?php echo $next_href ?>" class="btn btn-black btn-sm" title="다음글">
					<i class="fa fa-chevron-circle-right big-fa"></i><span class="hidden-xs">다음</span>
				</a>
			<?php } ?>
			<?php if ($copy_href) { ?>
				<a href="<?php echo $copy_href ?>" class="btn btn-black btn-sm" onclick="board_move(this.href); return false;" title="복사"><i class="fa fa-clipboard big-fa"></i><span class="hidden-xs">복사</span></a>
			<?php } ?>
			<?php if ($move_href) { ?>
				<a href="<?php echo $move_href ?>" class="btn btn-black btn-sm" onclick="board_move(this.href); return false;" title="이동"><i class="fa fa-share big-fa"></i><span class="hidden-xs">이동</span></a>
			<?php } ?>
			<?php if ($delete_href) { ?>
				<a href="<?php echo $delete_href ?>" class="btn btn-black btn-sm" title="삭제" onclick="del(this.href); return false;"><i class="fa fa-times big-fa"></i><span class="hidden-xs">삭제</span></a>
			<?php } ?>
			<?php if ($update_href) { ?>
				<a href="<?php echo $update_href ?>" class="btn btn-black btn-sm" title="수정"><i class="fa fa-plus big-fa"></i><span class="hidden-xs">수정</span></a>
			<?php } ?>
			<?php if ($search_href) { ?>
				<a href="<?php echo $search_href ?>" class="btn btn-black btn-sm"><i class="fa fa-search big-fa"></i><span class="hidden-xs">검색</span></a>
			<?php } ?>
			<a href="<?php echo $list_href ?>" class="btn btn-black btn-sm"><i class="fa fa-bars big-fa"></i><span class="hidden-xs">목록</span></a>
			<?php if ($reply_href) { ?>
				<a href="<?php echo $reply_href ?>" class="btn btn-black btn-sm"><i class="fa fa-comments big-fa"></i><span class="hidden-xs">답변</span></a>
			<?php } ?>
			<?php if ($write_href) { ?>
				<a href="<?php echo $write_href ?>" class="btn btn-color btn-sm"><i class="fa fa-pencil big-fa"></i><span class="hidden-xs">글쓰기</span></a>
			<?php } ?>
		</div>
		<div class="clearfix"></div>
	</div>
</div>