<?php
include_once('./_common.php');

// clean the output buffer
ob_end_clean();

include_once(G5_ADMIN_PATH.'/admin.head.sub.php');

if($act == 'ok') {

	check_admin_token();

	//자료가 많을 경우 대비 설정변경
	@ini_set('memory_limit', '-1');

	$directory = array();
	$photo_path = G5_DATA_PATH.'/apms/photo';

	if(is_dir($photo_path) && $handle = opendir($photo_path)) {
		while(false !== ($entry = readdir($handle))) {
			if($entry == '.' || $entry == '..')
				continue;

			$directory[] = $photo_path.'/'.$entry;
		}
	}

	flush();

	//폴더생성
	if(!is_dir(G5_DATA_PATH.'/member_image')) {
		@mkdir(G5_DATA_PATH.'/member_image', G5_DIR_PERMISSION);
		@chmod(G5_DATA_PATH.'/member_image', G5_DIR_PERMISSION);
	}

	$num = 0;
	foreach($directory as $dir) {
		$files = glob($dir.'/*');
		if (is_array($files) && count($files) > 0) {

			//회원별 폴더
			$photo_dir = str_replace('/apms/photo/', '/member_image/', $dir);

			//폴더생성
			if(!is_dir($photo_dir)) {
				@mkdir($photo_dir, G5_DIR_PERMISSION);
				@chmod($photo_dir, G5_DIR_PERMISSION);
			}

			$k = 0;
			foreach($files as $thumbnail) {

				//jpg 파일만 체크
				if(apms_get_ext($thumbnail) != 'jpg') continue;

				//경로 및 확장자 변경
				$org = str_replace('/apms/photo/', '/member_image/', $thumbnail);
				$org = str_replace('.jpg', '.gif', $org);
				
				//사진이 없으면 이동시킴
				if(!is_file($org)) {
					@copy($thumbnail, $org);
					@chmod($org, G5_FILE_PERMISSION);
					//@unlink($thumbnail); //삭제는 안시킴
					$k++;
					$num++;
				}
			}
			
			if(!$k) continue;

		}
	}
?>	
	<script type='text/javascript'> 
		alert('총 <?php echo number_format($num);?>개의 회원사진을 이동시켰습니다.');
		self.close();
	</script>
<?php } else { ?>
	<script src="<?php echo G5_ADMIN_URL ?>/admin.js"></script>
	<form id="defaultform" name="defaultform" method="post" onsubmit="return update_submit(this);">
	<input type="hidden" name="act" value="ok">
	<div style="padding:10px">
		<div style="border:1px solid #ddd; background:#f5f5f5; color:#000; padding:10px; line-height:20px;">
			<b><i class="fa fa-video-camera"></i> 회원사진 정리</b>
		</div>
		<div style="border:1px solid #ddd; border-top:0px; padding:10px;line-height:22px;">
			<ul>
				<li>/data/apms/photo 내 회원사진을 /data/member_image 폴더로 이동</li>
				<li>/data/member_image 폴더는 그누 5.3 이상부터 적용된 그누 자체 회원사진 폴더입니다.</li>
				<li>전체 회원사진에 대해 처리되므로 시간이 걸릴 수 있습니다.</li>
			</ul>
		</div>
		<br>
		<div class="btn_confirm01 btn_confirm">
			<input type="submit" value="실행하기" class="btn_submit btn" accesskey="s">
		</div>
	</div>
	</form>
	<script>
		function update_submit(f) {
			if(!confirm("실행후 완료메시지가 나올 때까지 기다려 주세요.\n\n정말 실행하시겠습니까?")) {
				return false;	
			} 

			return true;
		}
	</script>
<?php } ?>
<?php include_once(G5_PATH.'/tail.sub.php'); ?>