<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// input의 name을 wset[배열키] 형태로 등록
// 모바일 설정값은 동일 배열키에 배열변수만 wmset으로 지정 → wmset[배열키]

?>

<div class="tbl_head01 tbl_wrap">
	<table>
	<caption>위젯설정</caption>
	<colgroup>
		<col class="grid_2">
		<col>
	</colgroup>
	<thead>
	<tr>
		<th scope="col">구분</th>
		<th scope="col">설정</th>
	</tr>
	</thead>
	<tbody>
	<tr>
		<td align="center">아이콘</td>
		<td>
			<input type="text" name="wset[icon]" id="fcon" value="<?php echo ($wset['icon']);?>" size="30" class="frm_input"> 
			<a href="<?php echo G5_BBS_URL;?>/icon.php?fid=fcon" class="btn_frmline win_scrap">아이콘 선택</a>
			&nbsp;
			<select name="wset[icolor]">
				<option value=""<?php echo get_selected('', $wset['icolor']); ?>>기본컬러</option>
				<?php echo apms_color_options($wset['icolor']);?>
			</select>
		</td>
	</tr>
	<tr>
		<td align="center">분류지정</td>
		<td>
			<input type="text" name="wset[ca_id]" value="<?php echo $wset['ca_id']; ?>" size="20" class="frm_input">
			(분류는 1개만 지정가능, 분류코드 입력)
		</td>
	</tr>
	<tr>
		<td align="center">출력설정</td>
		<td>
			<label>
				<input type="checkbox" name="wset[rdm]" value="1"<?php echo get_checked('1', $wset['rdm']); ?>> 랭크 표시안할 때 단어섞기
			</label>
			<label>
				<input type="checkbox" name="wset[cnt]" value="1"<?php echo get_checked('1', $wset['cnt']); ?>> 통계값 출력
			</label>
		</td>
	</tr>
	<tr>
		<td align="center">추출갯수</td>
		<td>
			<input type="text" name="wset[rows]" value="<?php echo $wset['rows']; ?>" class="frm_input" size="3"> 개 - PC
			&nbsp;
			<input type="text" name="wmset[rows]" value="<?php echo $wmset['rows']; ?>" class="frm_input" size="3"> 개 - 모바일
			&nbsp;
			<input type="text" name="wset[page]" value="<?php echo $wset['page'];?>" size="3" class="frm_input"> 페이지 자료
		</td>
	</tr>
	<tr>
		<td align="center">추출방법</td>
		<td>
			<select name="wset[new]">
				<option value=""<?php echo get_selected('', $wset['new']); ?>>인기순</option>
				<option value="1"<?php echo get_selected('1', $wset['new']); ?>>최근순</option>
			</select>
		</td>
	</tr>
	<tr>
		<td align="center">랭크표시</td>
		<td>
			<select name="wset[rank]">
				<option value=""<?php echo get_selected('', $wset['rank']); ?>>표시안함</option>
				<?php echo apms_color_options($wset['rank']);?>
			</select>
		</td>
	</tr>
	<tr>
		<td align="center">캐시사용</td>
		<td>
			<input type="text" name="wset[cache]" value="<?php echo $wset['cache']; ?>" class="frm_input" size="4"> 초 간격으로 캐싱
		</td>
	</tr>
	</tbody>
	</table>
</div>