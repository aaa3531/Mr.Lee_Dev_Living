<?php 
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// 선택옵션으로 인해 셀합치기가 가변적으로 변함
$colspan = 1;

//if ($is_category) $colspan++;
if ($is_checkbox) $colspan++;
//if ($is_good) $colspan++;
//if ($is_nogood) $colspan++;

$row1 = sql_fetch( "select count(*) as cnt from $write_table where wr_is_comment = '0' and wr_2 = '5' ");
$row2 = sql_fetch( "select count(*) as cnt from $write_table where wr_is_comment = '0' and wr_2 = '1' ");
$qna_waiting  = $row1['cnt'];
$qna_done  = $row2['cnt'];

$stx1 = ($stx == "") ? "bo_cate_on" : "";
$stx2 = ($stx == "5") ? "bo_cate_on" : "";
$stx3 = ($stx == "1") ? "bo_cate_on" : "";

if(!$write_href) $write_href = "javascript:alert('회원 로그인이 필요합니다');";

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
//add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);
?>

<!-- 게시판 목록 시작 -->
<div id="bo_list" style="width:<?php echo $width; ?>">
<div class="heading">   
<h3><?php echo $board['bo_subject']; ?></h3>
<p>퍼닝의 다양한 전문가들에게 조언을 받으세요</p>
	
	<!-- 게시판 검색 시작 { -->
<fieldset id="bo_sch">
	<legend>게시물 검색</legend>

	<form name="fsearch" method="get">
	<input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
	<input type="hidden" name="sca" value="<?php echo $sca ?>">
	<input type="hidden" name="sop" value="and">
	<label for="sfl" class="sound_only">검색대상</label>
	<select name="sfl" id="sfl">
		<option value="wr_subject"<?php echo get_selected($sfl, 'wr_subject', true); ?>>제목</option>
		<option value="wr_content"<?php echo get_selected($sfl, 'wr_content'); ?>>내용</option>
		<option value="wr_subject||wr_content"<?php echo get_selected($sfl, 'wr_subject||wr_content'); ?>>제목+내용</option>
		<option value="mb_id,1"<?php echo get_selected($sfl, 'mb_id,1'); ?>>회원아이디</option>
		<option value="mb_id,0"<?php echo get_selected($sfl, 'mb_id,0'); ?>>회원아이디(코)</option>
		<option value="wr_name,1"<?php echo get_selected($sfl, 'wr_name,1'); ?>>글쓴이</option>
		<option value="wr_name,0"<?php echo get_selected($sfl, 'wr_name,0'); ?>>글쓴이(코)</option>
	</select>
	<label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
	<input type="text" name="stx" value="<?php echo stripslashes($stx) ?>" required id="stx" class="ed required" maxlength="20" style="width:120px;"autocomplete="off">
	<input type="submit" value=" 검색 " class="btn s">
	</form>
</fieldset>
<!-- } 게시판 검색 끝 -->
</div> 
	<!-- 분류 셀렉트 박스, 게시물 몇건, 관리자화면 링크 -->
	
	<?php if ($is_category) { ?> 
	<ul id="board_category_ul"> 
	<?php 
		$arr = explode("|", $board[bo_category_list]); 
		$str = '<li><a href="'.G5_BBS_URL.'/board.php?bo_table='.$bo_table.'"'; 
		if($sca == '') $str .= ' id="cate_select"'; 
		$str .= '>전체분류</a></li>'; 

		for ($i=0; $i<count($arr); $i++) 
		{ 
			$category = trim($arr[$i]); 
			if($category=='') continue; 
			$str .= '<li><a href="'.G5_BBS_URL.'/board.php?bo_table='.$bo_table.'&amp;sca='.urlencode($category).'"'; 
			if($sca == $category) $str .= ' id="cate_select"'; 
			$str .= '>'.$category.'</a></li>'; 
		} 
		echo $str; 
	?> 
	</ul>	
	<?php } ?> 
	<div class="bbs_li_top at-container">
	    <p>전체 <?php echo number_format($total_count)?> 개의 질문이 등록되었습니다.</p>
	    <ul>
	        <li><a href="<?php echo G5_BBS_URL?>/board.php?bo_table=<?php echo $bo_table?>&amp;sca=<?php echo $sca?>" id="<?php echo $stx1?>">전체질문</a></li>
	        <li><a href="<?php echo G5_BBS_URL?>/board.php?bo_table=<?php echo $bo_table?>&amp;sca=<?php echo $sca?>&amp;sfl=wr_2&amp;stx=5" id="<?php echo $stx2?>">답변을 기다리는 질문</a></li>
	        <li><a href="<?php echo G5_BBS_URL?>/board.php?bo_table=<?php echo $bo_table?>&amp;sca=<?php echo $sca?>&amp;sfl=wr_2&amp;stx=1" id="<?php echo $stx3?>">답변 완료된 질문</a></li>
	        <?php if ($is_member) {?>
	        <li class="entry"><a href="<?php echo $write_href?>">질문 하기</a></li>
	        <?php }?>
	    </ul>
	</div>

	<form name="fboardlist" id="fboardlist" action="./board_list_update.php" onsubmit="return fboardlist_submit(this);" method="post" class="at-container">
	<input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
	<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
	<input type="hidden" name="stx" value="<?php echo $stx ?>">
	<input type="hidden" name="spt" value="<?php echo $spt ?>">
	<input type="hidden" name="sca" value="<?php echo $sca ?>">
	<input type="hidden" name="sst" value="<?php echo $sst ?>">
	<input type="hidden" name="sod" value="<?php echo $sod ?>">
	<input type="hidden" name="page" value="<?php echo $page ?>">
	<input type="hidden" name="sw" value="">
    <div class="know-li">
        <ul>
           <?php for ($i=0; $i<count($list); $i++) 
		    { ?>
            <?php if ($list[$i]['is_notice']){?> 
            <li class="notice">
                <p>공지</p>
                <h3><a href='<?php echo $list[$i][href]?>'><?php echo $list[$i]['subject'] ?></a></h3>
                <h5><?php echo $list[$i]['datetime2'] ?></h5>
            </li>
            <?php }?>
            <li>
                <div class="list">
                   <?php if ($is_checkbox) { ?>
                    <div class="cheked">
                        <label for="chk_wr_id_<?php echo $i ?>" class="sound_only"><?php echo $list[$i]['subject'] ?></label>
                        <input type="checkbox" name="chk_wr_id[]" value="<?php echo $list[$i]['wr_id'] ?>" id="chk_wr_id_<?php echo $i ?>">
                    </div>
                     <?php } ?>
                     <p>
                     <?php
					
					echo $list[$i]['icon_reply'];
					
					if ($is_category && $list[$i]['ca_name']) {
					?>
					<a href="<?php echo $list[$i]['ca_name_href'] ?>" class="bo_cate_link"><?php echo $ca_name[$i] ?></a>
					<?php } ?>

					<span style='color:#cc3300; font-weight:600;'>
					<?php
					if($list[$i][wr_2] == '1')
						echo "<span style='color:#0080cc;'>[완료]</span>"; 
					else
						echo "[ 채택 포인트 : ".number_format($list[$i][wr_1] + $board[bo_comment_point])."]";
					?>
					</span>	
                    </p>
                    <h3><a href='<?php echo $list[$i][href]?>'><?php echo $list[$i]['subject'] ?></a></h3>
                    <p class="cont"><?php echo $list[$i]['content'] ?></p>
                    <h5><?php echo $list[$i]['name'] ?></h5><span>등록 <?php echo $list[$i]['datetime2'] ?> | 조회 <?php echo $list[$i]['wr_hit'] ?> | 추천 <?php echo $list[$i]['wr_good'] ?></span>
                </div>
                
            </li>
            <?php } ?>
            
        </ul>
    </div>
	<?php if ($is_checkbox || $setup_href || $admin_href) { ?>
    <?php if ($is_checkbox) { ?>
              <button type="submit" name="btn_submit" value="선택삭제" onclick="document.pressed=this.value" class="btn btn-black btn-sm"><i class="fa fa-times"></i><span class="hidden-xs"> 선택삭제</span></button>
				<button type="submit" name="btn_submit" value="선택복사" onclick="document.pressed=this.value" class="btn btn-black btn-sm"><i class="fa fa-clipboard"></i><span class="hidden-xs"> 선택복사</span></button>
				<button type="submit" name="btn_submit" value="선택이동" onclick="document.pressed=this.value" class="btn btn-black btn-sm"><i class="fa fa-arrows"></i><span class="hidden-xs"> 선택이동</span></button>
				<button type="button" id="btn_chkall" class="btn btn-black btn-sm"><i class="fa fa-check"></i><span class="hidden-xs"> 전체선택</span></button>
				<?php } ?>
				<?php if ($admin_href) { ?>
					<a href="<?php echo $admin_href; ?>" class="btn btn-black btn-sm"><i class="fa fa-cog"></i></a>
				<?php } ?>
					<?php if ($setup_href) { ?>
						<a href="<?php echo $setup_href; ?>" class="btn btn-color btn-sm win_memo"><i class="fa fa-cogs"></i><span class="hidden-xs"> 설정</span></a>
					<?php } ?>
				<?php } ?>
	</form>
	<?php if($total_count > 0) { ?>
			<div class="list-page text-center at-container">
				<ul class="pagination pagination-sm en">
					<?php if($prev_part_href) { ?>
						<li><a href="<?php echo $prev_part_href;?>">이전검색</a></li>
					<?php } ?>
					<?php echo apms_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, './board.php?bo_table='.$bo_table.$qstr.'&amp;page=');?>
					<?php if($next_part_href) { ?>
						<li><a href="<?php echo $next_part_href;?>">다음검색</a></li>
					<?php } ?>
				</ul>
			</div>
		<?php } ?>
</div>

<?php if($is_checkbox) { ?>
<noscript>
<p>자바스크립트를 사용하지 않는 경우<br>별도의 확인 절차 없이 바로 선택삭제 처리하므로 주의하시기 바랍니다.</p>
</noscript>
<?php } ?>

<!-- 페이지 -->
<div class="board_page">
<?php echo $write_pages;  ?>
</div>



<?php if ($is_checkbox) { ?>
<script>
function all_checked(sw) {
	var f = document.fboardlist;

	for (var i=0; i<f.length; i++) {
		if (f.elements[i].name == "chk_wr_id[]")
			f.elements[i].checked = sw;
	}
}

function fboardlist_submit(f) {
	var chk_count = 0;

	for (var i=0; i<f.length; i++) {
		if (f.elements[i].name == "chk_wr_id[]" && f.elements[i].checked)
			chk_count++;
	}

	if (!chk_count) {
		alert(document.pressed + "할 게시물을 하나 이상 선택하세요.");
		return false;
	}

	if(document.pressed == "선택복사") {
		select_copy("copy");
		return;
	}

	if(document.pressed == "선택이동") {
		select_copy("move");
		return;
	}

	if(document.pressed == "선택삭제") {
		if (!confirm("선택한 게시물을 정말 삭제하시겠습니까?\n\n한번 삭제한 자료는 복구할 수 없습니다\n\n답변글이 있는 게시글을 선택하신 경우\n답변글도 선택하셔야 게시글이 삭제됩니다."))
			return false;

		f.removeAttribute("target");
		f.action = "./board_list_update.php";
	}

	return true;
}

// 선택한 게시물 복사 및 이동
function select_copy(sw) {
	var f = document.fboardlist;

	if (sw == "copy")
		str = "복사";
	else
		str = "이동";

	var sub_win = window.open("", "move", "left=50, top=50, width=500, height=550, scrollbars=1");

	f.sw.value = sw;
	f.target = "move";
	f.action = "./move.php";
	f.submit();
}
</script>
<?php } ?>
<!-- } 게시판 목록 끝 -->
