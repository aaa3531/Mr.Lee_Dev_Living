<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if(!$wset['ucont']) $wset['ucont'] = 60;

$list_cnt = count($list);

$답변권한 = false;
if($member['mb_id']){
	$sql = " select count(*) as cnt
						from {$g5['g5_shop_cart_table']}
						where it_id = '$it_id'
						  and mb_id = '{$member['mb_id']}'
						  and ct_status = '완료' ";
	$row = sql_fetch($sql);
	if($is_admin || $member['mb_id']=="chk" || $row['cnt']>0){
		$답변권한 = true;
	}
}
?>
<script>
$(document).ready(function(){
	$(".리뷰정렬").click(function(){
		chk_order = $(this).attr("val");		
		apms_page('itemuse', './itemuse.php?it_id=<?=$it_id?>&amp;urows=20&amp;page=1', '1')		
	});
});
</script>

<div class="req-title-text">
	<span>리뷰<b><?php echo $it_use_cnt;?></b>
		
	</span>
	<span class="리뷰정렬" style='border-bottom:0px;<?=$chk_order=="a1" ? "color:#2149f2;" : ""?>margin-left:35px;margin-right:5px;cursor:pointer;'  val="a1">
		베스트
	</span>
	|
	<span class="리뷰정렬" style='border-bottom:0px;<?=$chk_order=="a1" ? "" : "color:#2149f2;"?>margin-left:5px;cursor:pointer;' val="a2">
		최신순
	</span>
	
		
		
	
	
</div>
<div class="use-media<?php echo (G5_IS_MOBILE) ? ' use-mobile' : '';?>">	
	<?php for ($i=0; $i < $list_cnt; $i++) { ?>
		<div class="media">
			<div class="media-body">
				<div class="media-info text-muted">
					<?php echo apms_get_star($list[$i]['is_score'],'red font-14'); //별점 ?>
					<span class="sp"></span>
					<?php echo $list[$i]['is_name']; ?>
					<span class="sp"></span>
					<time datetime="<?php echo date('Y-m-d\TH:i:s+09:00', $list[$i]['is_time']) ?>"><?php echo apms_date($list[$i]['is_time'], 'orangered', 'before');?></time>
					
					<?php if($답변권한){ ?>
					<button style='margin-left:20px;' type="button" class="btn btn-<?php echo $btn2;?> btn-sm" onclick="apms_form('itemuse_form', '<?php echo $itemuse_form; ?>&is_re=1&is_id=<?=$list[$i]['is_id']?>');">
					댓글쓰기</button>
					<?php } ?>
					
				</div>
				<div class="media-desc">
					<a href="#" onclick="more_is('more_is_<?php echo $i; ?>'); return false;">
						<span class="text-muted"><?php echo apms_cut_text($list[$i]['is_content'], $wset['ucont'], '… <span class="font-11 text-muted">더보기</span>'); ?></span>
					</a>
				</div>
				<?php
                $pattern = "/<img.*?src=[\"']?(?P<url>[^(http)].*?)[\"' >]/i";
                preg_match($pattern,stripslashes(str_replace('&','&',$row["content"])), $match);
                $img = substr($match['url'],1);
                ?>
			</div>
			<div class="clearfix media-content" id="more_is_<?php echo $i; ?>" style="display:none;">
				<?php echo get_view_thumbnail($list[$i]['is_content'], $default['pt_img_width']); // 후기 내용 ?>
				<?php if ($list[$i]['is_btn']) { ?>
					<div class="print-hide media-btn text-right">
						<a href="#" onclick="apms_form('itemuse_form', '<?php echo $list[$i]['is_edit_href'];?>'); return false; ">
							<span class="text-muted"><i class="fa fa-plus"></i> 수정</span>
						</a>
						&nbsp;
						<a href="#" onclick="apms_delete('itemuse', '<?php echo $list[$i]['is_del_href'];?>', '<?php echo $list[$i]['is_del_return'];?>'); return false; ">
							<span class="text-muted"><i class="fa fa-times"></i> 삭제</span>
						</a>
					</div>
				<?php } ?>
				<?php if ($list[$i]['is_reply']) { 
					//답글제목 : $list[$i]['is_reply_subject']
					//답글작성 : $list[$i]['is_reply_name']
				?>
					<div class="well well-sm">
						<?php echo get_view_thumbnail($list[$i]['is_reply_content'], $default['pt_img_width']); ?>
					</div>
				<?php } ?>
				
				<?php 
				$sql = "select a.*,b.mb_nick from g5_shop_item_use_re a , g5_member b where it_id='{$it_id}' and is_id='{$list[$i]['is_id']}' and a.mb_id=b.mb_id order by reg_date desc";	
				$r = sql_query($sql);
				while($data = sql_fetch_array($r)){
				?>				
					<div class="well well-sm" style='margin-top: 20px;'>
						<div style='margin-bottom:10px;'>
							<span style='font-weight:bold;'><?=$data['mb_nick']?></span>
							<span style='margin-left:10px;'><?=str_replace("-",".",substr($data['reg_date'],5,11))?></span>
							
							<?php
							if($is_admin || ($member['mb_id']==$data['mb_id'])){
							?>
							<span onclick="apms_form('itemuse_form', '<?php echo $itemuse_form; ?>&is_re=1&no=<?=$data['no']?>');" style='cursor:pointer;margin-left:5px;'>[수정]</span>
							<span onclick="javascript:if(confirm('삭제 하시겠습니까?')){location.href='/shop/del_re.php?it_id=<?=$it_id?>&no=<?=$data['no']?>'}" style='cursor:pointer;margin-left:5px;'>[삭제]</span>
							<?php } ?>
							
						</div>
						<?php echo get_view_thumbnail($data['memo'], $default['pt_img_width']); ?>
					</div>
				<?php 
				}
				?>
				
				
			</div>
			
			<?php  if($r->num_rows>0 || $list[$i]['is_reply']){?>
			<div onclick="more_is('more_is_<?php echo $i; ?>'); return false;" style='cursor:pointer;margin-top:10px;color:#2149f2'><?=$r->num_rows+($list[$i]['is_reply']?1:0)?>개의 답글이 더 있습니다.</div>
			<?php } ?>
		</div>
	<?php } ?>
</div>

<!--
<div class="print-hide well text-center"> 
	<?php if ($is_free_write) { ?>
		구매와 상관없이 후기를 등록할 수 있습니다.
	<?php } else { ?>
		구매하신 분만 후기를 등록할 수 있습니다.
	<?php } ?>
</div>
-->

<div class="print-hide use-btn">
	<div class="use-page pull-left">
		<ul class="pagination pagination-sm en">
			<?php echo apms_ajax_paging('itemuse', $write_pages, $page, $total_page, $list_page); ?>
		</ul>
		<div class="clearfix"></div>
	</div>
	<div class="pull-right">
		<div class="btn-group">
		    <?php if($is_member){ ?>
			<button type="button" class="btn btn-<?php echo $btn2;?> btn-sm" onclick="apms_form('itemuse_form', '<?php echo $itemuse_form; ?>');">
				리뷰쓰기<span class="sound_only"> 새 창</span>
			</button>
            <?php } ?>
            <?php if(!$is_member){ ?>
             <button type="button" class="btn btn-<?php echo $btn2;?> btn-sm" onclick="location.href='<?php echo G5_URL; ?>/bbs/login.php'">
				리뷰쓰기
			</button>
             <?php } ?>
<!--			<a class="btn btn-<?php echo $btn1;?> btn-sm" href="<?php echo $itemuse_list; ?>"><i class="fa fa-plus"></i> 더보기</a>-->
			<?php if($admin_href) { ?>
				<a class="btn btn-<?php echo $btn1;?> btn-sm" href="<?php echo $admin_href; ?>"><i class="fa fa-th-large"></i><span class="hidden-xs"> 관리</span></a>
			<?php } ?>
		</div>
		<div class="h30"></div>
	</div>
	<div class="clearfix"></div>
</div>

<script>
function more_is(id) {
	$("#" + id).toggle();
}
</script>