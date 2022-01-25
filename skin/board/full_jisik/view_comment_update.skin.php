<?php
include_once("_common.php"); 

$wr_id = $_GET[wr_id];
$comment_id = $_GET[comment_id];
$c_mb_id = $_GET[c_mb_id];
$bo_table = $_GET[bo_table];

if($member[mb_id] && $comment_id && $c_mb_id) 
{
	sql_query(" update $write_table set wr_2 = '1' where wr_id = '$comment_id' "); //채택답변 코멘트 완료추가
	sql_query(" update $write_table set wr_2 = '1' where wr_id = '$wr_id' "); //채택답변 게시물 완료 추가
		
	$res = sql_fetch(" select wr_1 from $write_table where wr_parent = '$wr_id' "); //채택 포인트   

	
	///////////  답변 채택시 본인 포인트 차감 ///////////

	$wr_1 = $res['wr_1'] * (-1); //차감 포인트 
	$mb_point = $member['mb_point'] - $res['wr_1'];  //포인트 합계

	//포인트 테이블 추가 
	$sql = " insert into $g5[point_table] 
			set mb_id = '$member[mb_id]', 
			po_datetime = '".G5_TIME_YMDHIS."', 
			po_content = '$wr_id-지식인 답변채택 포인트 차감',
			po_point = '$wr_1', 
			po_mb_point = '$mb_point',  
			po_rel_table = '$bo_table', 
			po_rel_id = '$wr_id',
			po_rel_action = '지식인 답변채택' 
		"; 
	sql_query($sql); 

	//멤버 테이블 포인트 업데이트  
	sql_query(" update $g5[member_table] set mb_point = '$mb_point' where mb_id = '$member[mb_id]' ");



	/////////// 답변 채택자 포인트 추가 ////////////

	//채택자 현재 포인트 
	$mb = sql_fetch(" select mb_point from $g5[member_table] where mb_id = '$c_mb_id' "); 
	
	$wr_1 = $res['wr_1'];//추가 포인트 
	$mb_point = $mb['mb_point'] + $res['wr_1'];  //포인트 합계

	//포인트 건별 생성 
	$sql = " insert into $g5[point_table] 
				set mb_id = '$c_mb_id', 
				po_datetime = '".G5_TIME_YMDHIS."', 
				po_content = '$wr_id-지식인 답변채택 포인트 획득',
				po_point = '$wr_1', 
				po_mb_point = '$mb_point', 
				po_rel_table = '$bo_table', 
				po_rel_id = '$wr_id',
				po_rel_action = '지식인 답변채택'  
			"; 
	sql_query($sql); 

	//멤버 테이블 포인트 업데이트  
	$sql = " update $g5[member_table] set mb_point = '$mb_point' where mb_id = '$c_mb_id' "; 
	sql_query($sql);
 
}		

goto_url(G5_BBS_URL."/board.php?bo_table=$bo_table&wr_id=$wr_id&page=$page" . $qstr . "&cwin=$cwin#c_{$comment_id}");
?>
