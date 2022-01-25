<?php
if (!defined('_GNUBOARD_')) exit; //개별 페이지 접근 불가

global $at_href,$member;

//add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$widget_url.'/widget.css">', 0);

switch($wset['search']) {
	case 'item'	: $link = $at_href['isearch'].'?q='; break;
	case 'tag'	: $link = $at_href['tag'].'?q='; break;
	default		: $link = $at_href['search'].'?stx='; break;
}

$q = explode(",", $wset['q']);
$q_cnt = count($q);

if($q_cnt) shuffle($q);

?>
<div class="basic-keyword">
     <span class="title">인기검색어</span><span class="sp">|</span>
	<?php for($i=0; $i < $q_cnt; $i++) { ?>
		<span class="stx">
			<?php if($i > 0) { ?>
				<span class="sp">|</span>
			<?php } ?>
			<a href="<?php echo $link.urlencode($q[$i]);?>"><?php echo $q[$i];?></a>
		</span>
	<?php if($i == 9) break; } //10개만 출력 ?>
	<?php if($member['admin']) { // 로그인 상태 ?>
    <span class="setup">
		<a href="<?php echo $setup_href;?>" class="win_memo">
			<span class="text-muted"><i class="fa fa-cog"></i> 위젯설정</span>
		</a>
    </span>	
<?php } ?>
</div>

