<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

?>
		<?php if($col_name) { ?>
			<?php if($col_name == "two") { ?>
					</div>
					<div class="col-md-<?php echo $col_side;?><?php echo ($at_set['side']) ? ' pull-left' : '';?> at-col at-side">
						<?php include_once($is_side_file); // Side ?>
					</div>
				</div>
			<?php } else { ?>
				</div><!-- .at-content -->
			<?php } ?>
			</div><!-- .at-container -->
		<?php } ?>
	</div><!-- .at-body -->

	<?php if(!$is_main_footer) { ?>
		<footer class="at-footer">
		    
			<div class="at-infos">
				<div class="at-container">
				        <div class="copy">
				            <ul>
                                <li><p>PARKSDESIGN</p><p><b><?php echo $default['de_admin_company_addr']; ?></b></p></li>
                                <li><p>대표</p><p><b><?php echo $default['de_admin_company_owner']; ?></b></p></li>
				                <li><p>대표전화</p><p><b><?php echo $default['de_admin_company_tel']; ?></b></p></li>
				                <li><p>사업자등록번호</p><p><b><?php echo $default['de_admin_company_saupja_no']; ?>(<a href="http://www.ftc.go.kr/info/bizinfo/communicationList.jsp" target="_blank">사업자정보확인</a>)</b></p></li>
<!--
				                <li><b>통신판매업신고</b><?php echo $default['de_admin_tongsin_no']; ?></li>
				                <li><b>개인정보관리책임자</b><?php echo $default['de_admin_info_name']; ?></li>
-->
				                <li><p>이메일</p><p><b><a href="mailto:<?php echo $default['de_admin_info_email']; ?>"><?php echo $default['de_admin_info_email']; ?></a></b></p></li>
				                
				            </ul>
				            
				        </div>
				        
				        
				</div>
			</div>
			<div class="footer-link at-container">
		        <ul>
		            <li><a href="<?php echo G5_BBS_URL;?>/page.php?hid=intro">사이트 소개</a></li> 
						<li><a href="<?php echo G5_BBS_URL;?>/page.php?hid=provision">이용약관</a></li> 
						<li><a href="<?php echo G5_BBS_URL;?>/page.php?hid=privacy">개인정보처리방침</a></li>
						<li><a href="<?php echo G5_BBS_URL;?>/page.php?hid=noemail">이메일 무단수집거부</a></li>
						<li><a href="<?php echo G5_BBS_URL;?>/page.php?hid=disclaimer">책임의 한계와 법적고지</a></li>
                        <li><a href="<?php echo $as_href['pc_mobile'];?>"><?php echo (G5_IS_MOBILE) ? 'PC' : '모바일';?>버전</a></li>
		        </ul>
		        <p>민원담당자 연락처 : <?php echo $default['de_admin_info_name']; ?> (<?php echo $default['de_admin_company_tel']; ?>)</p>
		        <h6>Copyrights &copy; 2021 . PARKSDESIGN All rights Reserved</h6>
		    </div>
		</footer>
	<?php } ?>
</div><!-- .wrapper -->

<div class="at-go">
	<div id="go-btn" class="go-btn">
		<span class="go-top cursor"><i class="fa fa-chevron-up"></i></span>
		<span class="go-bottom cursor"><i class="fa fa-chevron-down"></i></span>
	</div>
</div>

<!--[if lt IE 9]>
<script type="text/javascript" src="<?php echo THEMA_URL;?>/assets/js/respond.js"></script>
<![endif]-->

<!-- JavaScript -->
<script>
var sub_show = "<?php echo $at_set['subv'];?>";
var sub_hide = "<?php echo $at_set['subh'];?>";
var menu_startAt = "<?php echo ($m_sat) ? $m_sat : 0;?>";
var menu_sub = "<?php echo $m_sub;?>";
var menu_subAt = "<?php echo ($m_subsat) ? $m_subsat : 0;?>";
</script>
<script src="<?php echo THEMA_URL;?>/assets/bs3/js/bootstrap.min.js"></script>
<script src="<?php echo THEMA_URL;?>/assets/js/sly.min.js"></script>
<script src="<?php echo THEMA_URL;?>/assets/js/custom.js"></script>
<?php if($is_sticky_nav) { ?>
<script src="<?php echo THEMA_URL;?>/assets/js/sticky.js"></script>
<?php } ?>

<?php echo apms_widget('basic-sidebar'); //사이드바 및 모바일 메뉴(UI) ?>

<?php if($is_designer || $is_demo) include_once(THEMA_PATH.'/assets/switcher.php'); //Style Switcher ?>
