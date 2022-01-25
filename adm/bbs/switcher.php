<?php
define('G5_IS_ADMIN', true);
include_once('./_common.php');

// common.lib.php에 있는 is_include_path_check() 함수 차용
function apms_file_path_check($path='', $is_input='')
{
    if( $path ){
        if ($is_input){
            // 장태진 @jtjisgod <jtjisgod@gmail.com> 추가
            // 보안 목적 : rar wrapper 차단

            if( stripos($path, 'rar:') !== false || stripos($path, 'php:') !== false || stripos($path, 'zlib:') !== false || stripos($path, 'bzip2:') !== false || stripos($path, 'zip:') !== false || stripos($path, 'data:') !== false || stripos($path, 'phar:') !== false ){
                return false;
            }
            
            $replace_path = str_replace('\\', '/', $path);
            $slash_count = substr_count(str_replace('\\', '/', $_SERVER['SCRIPT_NAME']), '/');
            $peer_count = substr_count($replace_path, '../');

            if ( $peer_count && $peer_count > $slash_count ){
                return false;
            }

            try {
                // whether $path is unix or not
                $unipath = strlen($path)==0 || $path{0}!='/';
                $unc = substr($path,0,2)=='\\\\'?true:false;
                // attempts to detect if path is relative in which case, add cwd
                if(strpos($path,':') === false && $unipath && !$unc){
                    $path=getcwd().DIRECTORY_SEPARATOR.$path;
                    if($path{0}=='/'){
                        $unipath = false;
                    }
                }

                // resolve path parts (single dot, double dot and double delimiters)
                $path = str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $path);
                $parts = array_filter(explode(DIRECTORY_SEPARATOR, $path), 'strlen');
                $absolutes = array();
                foreach ($parts as $part) {
                    if ('.'  == $part){
                        continue;
                    }
                    if ('..' == $part) {
                        array_pop($absolutes);
                    } else {
                        $absolutes[] = $part;
                    }
                }
                $path = implode(DIRECTORY_SEPARATOR, $absolutes);
                // resolve any symlinks
                // put initial separator that could have been lost
                $path = !$unipath ? '/'.$path : $path;
                $path = $unc ? '\\\\'.$path : $path;
            } catch (Exception $e) {
                //echo 'Caught exception: ',  $e->getMessage(), "\n";
                return false;
            }

            if( preg_match('/\/data\/(file|editor|qa|cache|member|member_image|session|tmp)\/[A-Za-z0-9_]{1,20}\//i', $replace_path) ){
                return false;
            }
            if( preg_match('/\.\.\//i', $replace_path) || preg_match('/plugin\//i', $replace_path) || preg_match('/okname\//i', $replace_path) ){
                return false;
            }
        }
    }

    return true;
}

if (($mode == 'del' || $mode == 'up') && !$is_designer) {
    alert("관리자만 가능합니다.");
}

switch($type) {
	case 'banner'	: $title = 'Banner Box'; $filedir = '/apms/banner/'; break;
	case 'title'	: $title = 'Title Box'; $filedir = '/apms/title/'; break;
	case 'image'	: $title = 'Image Box'; $filedir = '/apms/image/'; break;
	default			: $title = 'Background Box'; $filedir = '/apms/background/'; break;
}

// 폴더생성
if(!is_dir(G5_DATA_PATH.$filedir)) {
	@mkdir(G5_DATA_PATH.$filedir, G5_DIR_PERMISSION);
	@chmod(G5_DATA_PATH.$filedir, G5_DIR_PERMISSION);
}

if(!apms_file_path_check($filename, 1)) {
	alert('올바른 방법으로 이용해 주세요.');
}

$filename = basename(urlencode($filename));

if($mode == "del") {
	if(is_file(G5_DATA_PATH.$filedir.$filename)) {
		@unlink(G5_DATA_PATH.$filedir.$filename);
	} else {
		alert('올바른 방법으로 이용해 주세요.');
	}
} else if ($mode == "up") {
	if(!$_FILES['upload_file']['tmp_name']) alert("파일을 등록해 주세요.");

	if (!preg_match("/(\.(jpg|gif|png))$/i", $_FILES['upload_file']['name'])) {
		alert('JPG, GIF, PNG 파일만 등록이 가능합니다.');
	}

	if(strlen($_FILES['upload_file']['name']) > 40) {
		alert('확장자 포함해서 파일명을 40자 이내로 등록할 수 있습니다.'); 
	}
	if (!preg_match("/([-A-Za-z0-9_])$/", $_FILES['upload_file']['name'])) { 
		alert('파일명은 10자 이내로 공백없이 영문자, 숫자, -, _ 만 사용 가능합니다.'); 
	}

	list($thumb) = explode('-', $_FILES['upload_file']['name']);
	if($thumb == 'thumb') {
		alert('파일명이 thumb- 일 경우 썸네일 파일로 인식되기 때문에 등록할 수 없습니다.'); 
	}

	if (is_uploaded_file($_FILES['upload_file']['tmp_name'])) {
		$dest_file = G5_DATA_PATH.$filedir.$_FILES['upload_file']['name'];

		//있으면 삭제합니다.
		@unlink($dest_file);

		// 업로드가 안된다면 에러메세지 출력하고 죽어버립니다.
		move_uploaded_file($_FILES['upload_file']['tmp_name'], $dest_file) or die($_FILES['upload_file']['error'][$i]);

		// 올라간 파일의 퍼미션을 변경합니다.
		chmod($dest_file, G5_FILE_PERMISSION);
	}

	goto_url(G5_BBS_URL.'/switcher.php?type='.$type.'&fid='.$fid.'&cid='.$cid);
}

include_once(G5_ADMIN_PATH.'/admin.head.sub.php');
?>
<style>
	body { margin:0 0 30px; padding:0; font:normal 12px dotum; -webkit-text-size-adjust:100%; background:#fafafa;}
	a, a:hover { text-decoration:none; }
	h2 { padding:15px; text-align:center; color:#fff; background:#000; font-size:18px; font-family:tahoma; font-weight:bold; margin:0; }
	ul { padding:0px; margin:15px; list-style:none; }
	ul li { float:left; padding:10px; margin:0px; position:relative; }
	ul li img { display:block; cursor:pointer; border:4px solid #efefef; width:80px; height:80px; }
	ul li img:hover { border:4px solid #000; }
	p.del { color:#ccc !important; margin:0px; padding:5px 0px 0px; text-align:center; }
	p.del a { color:#ccc !important; }
	p.del a:hover { color:orangered !important; }
	.uploader { background:#eee; text-align:center; padding:15px; }
	.upload-css { position:absolute; top:45px; line-height:20px; font-size:10px; font-family:verdana; text-align:center; background:#000; font-weight:bold; color:#fff; width:88px; }
	.bg-none { display:block; width:80px; height:80px; line-height:80px; text-align:center; cursor:pointer; background:#ddd; color:#fff; font-size:60px; border:4px solid #efefef; }
	.left { float:left; }
</style>
<h2><?php echo $title;?></h2>

<form id="switcherForm" name="switcherForm" method="post" enctype="multipart/form-data">
	<input type="hidden" name="type" value="<?php echo $type;?>">
	<input type="hidden" name="fid" value="<?php echo $fid;?>">
	<input type="hidden" name="cid" value="<?php echo $cid;?>">
	<input type="hidden" name="mode" value="up">
	<div class="uploader">
		<input type="file" name="upload_file" value="">
		<button type="submit" class="btn_frmline">등록하기</button>
	</div>
</form>

<ul class="switcher-wrap">
	<li>
		<span class="switcher-select" title="none"><b class="bg-none"><i class="fa fa-times"></i></b></span>
		<p class="del"></p>
	</li>
	<?php //Background
		$srow = thema_switcher('file', G5_DATA_PATH.$filedir, '', "jpg|png|gif");
		for($i=0; $i < count($srow); $i++) {
			//썸네일은 제외 : 접두어가 thumb- 로 시작
			list($thumb) = explode('-', $srow[$i]['name']);
			if($thumb == 'thumb') {
				continue;			
			}
	?>
	<li>
		<img src="<?php echo G5_DATA_URL.$filedir.$srow[$i]['name'];?>" alt="<?php echo $srow[$i]['name'];?>" class="switcher-select">
		<p class="del">
			<a href="<?php echo G5_BBS_URL;?>/switcher.php?type=<?php echo $type;?>&amp;mode=del&amp;fid=<?php echo $fid;?>&amp;cid=<?php echo $cid;?>&amp;filename=<?php echo $srow[$i]['name'];?>&amp;filecss=<?php echo $srow[$i]['value'];?>" title="삭제" class="del-file">
				<i class="fa fa-times"></i>
			</a>
		</p>
	</li>
	<?php } ?>
</ul>
<div style="clear:both;"></div>
<p align="center">
	<button type="button" onclick="self.close();" class="btn_frmline">창닫기</button>
</p>
<script>
	jQuery(document).ready(function($) {
		$('.del-file').click(function() {
			if(confirm("삭제하시겠습니까?")) {
				location.href = this.href;
			}
			return false;
		});

		$('.switcher-select').click(function() {
			opener.switcher_background('<?php echo $type;?>', '<?php echo $fid;?>', '<?php echo $cid;?>', this.src);
			return false;
		});
	});
</script>
<?php include_once(G5_PATH."/tail.sub.php"); ?>