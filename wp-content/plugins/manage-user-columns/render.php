<?php
// Exit if accessed directly
if ( ! defined('ABSPATH') ) {
   exit;
}

// Add-New-Column button on the Users page
if (!function_exists('dpk_muc_users_page_html')) {
	function dpk_muc_users_page_html(){
		$screen = get_current_screen();
		if ( $screen->id != "users" )
			return;
		?>
		<div id="muc-popup">
			<div class="muc-popup-inner">
				<span id="muc-close-pp">X</span>
				<div id="colInfo">
					<div class="toggleOptions">
						<?php
						$un_chk = $name_chk = $email_chk = $role_chk = $posts_chk = $reg_chk = 'checked';
						$muc_defaults = get_option('muc_def_cols');
						if($muc_defaults){
							if($muc_defaults['username'] != 1){ $un_chk = ''; }
							if($muc_defaults['name'] != 1){ $name_chk = ''; }
							if($muc_defaults['email'] != 1){ $email_chk = ''; }
							if($muc_defaults['role'] != 1){ $role_chk = ''; }
							if($muc_defaults['posts'] != 1){ $posts_chk = ''; }
							if($muc_defaults['reg'] != 1){ $reg_chk = ''; }
						}
						?>
						<h3>Toggle Default Columns</h3>
						<form action="" id="toggleForm" method="POST">
							<table>
								<tr><td><label>Username</label></td><td><input name="tgl_uname" type="checkbox" <?php echo $un_chk; ?>></td></tr>
								<tr><td><label>Name</label></td><td><input name="tgl_name" type="checkbox" <?php echo $name_chk; ?>></td></tr>
								<tr><td><label>Email</label></td><td><input name="tgl_email" type="checkbox" <?php echo $email_chk; ?>></td></tr>
								<tr><td><label>Role</label></td><td><input name="tgl_role" type="checkbox" <?php echo $role_chk; ?>></td></tr>
								<tr><td><label>Posts</label></td><td><input name="tgl_posts" type="checkbox" <?php echo $posts_chk; ?>></td></tr>
								<tr><td><label>Registration Date</label></td><td><input name="tgl_reg" type="checkbox" <?php echo $reg_chk; ?>></td></tr>
							</table>
							<p><input type="submit" value="Save" name="save_muc_def"></p>
						</form>
					</div>
					<div class="newOne">
						<h3>Add New Column</h3>
						<form action="" id="newColForm" method="POST">
							<table>
								<tr><td><label for="col_name">Column Name</label></td><td><input type="text" name="col_name" id="col_name" placeholder="Custom Column Name" required=""></td></tr>
								<tr><td><label for="col_id">User Meta Field</label></td><td><input type="text" name="col_id" id="col_id" placeholder="Type to search..." required=""></td></tr>
								<tr><td></td><td><ul class="muc-search-sug"></ul></td></tr>
							</table>
							<p><input type="submit" name="save_muc_col" value="Add Column"></p>
						</form>
					</div>
				</div>
			</div>
			<div style="display: none;">
				<form action="" id="dlt_col_frm" method="POST"><input type="hidden" name="delt_col" id="delt_col"></form>
			</div>
		</div>
		<script type="text/javascript">
			jQuery(document).ready(function($) {
				$("<span id='mucAddNewCol' class='button'>Manage Columns</span>").insertAfter(".tablenav.top #changeit");
				
				$(".tablenav").on('click', '#mucAddNewCol', function(){
					$("#muc-popup").fadeIn('fast');
				});
				
				$("#muc-close-pp").on('click', function(){
					$("#muc-popup").fadeOut('fast');
				});
				
				<?php 
				$muc_cc = get_option('muc_custom_cols');
				if($muc_cc){
					foreach($muc_cc as $col_id=>$val){ 
						$col_id = esc_html($col_id);
					?>
						$('.table-view-list.users').find("th#<?php echo $col_id; ?>").append('<span class="dlt-col tooltip">x<span class="tooltiptext">Delete Column</span></span>');
						$('.table-view-list.users').find("th#<?php echo $col_id; ?>").find('a').css('display', 'inline').css('padding', '0');
					<?php }
				}
				?>
				
				$('.table-view-list.users th').on('click', '.dlt-col', function(){
					$('#delt_col').val($(this).closest('th').attr('id'));
					$('#dlt_col_frm').submit();
				})
				
			});
		</script>
		<?php
	}
}
