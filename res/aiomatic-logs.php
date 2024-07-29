<?php
   function aiomatic_logs()
   {
       global $wp_filesystem;
       if ( ! is_a( $wp_filesystem, 'WP_Filesystem_Base') ){
           include_once(ABSPATH . 'wp-admin/includes/file.php');$creds = request_filesystem_credentials( site_url() );
           wp_filesystem($creds);
       }
       if(isset($_POST['aiomatic_delete']) && isset($_POST['aiomatic_nonce']) && wp_verify_nonce( $_POST['aiomatic_nonce'], 'openai-secret-nonce'))
       {
           if($wp_filesystem->exists(WP_CONTENT_DIR . '/aiomatic_info.log'))
           {
               $wp_filesystem->delete(WP_CONTENT_DIR . '/aiomatic_info.log');
           }
       }
       if(isset($_POST['aiomatic_delete_rules']) && isset($_POST['aiomatic_nonce']) && wp_verify_nonce( $_POST['aiomatic_nonce'], 'openai-secret-nonce'))
       {
           $running = array();
           update_option('aiomatic_running_list', $running);
           $flock_disabled = explode(',', ini_get('disable_functions'));
           if(!in_array('flock', $flock_disabled))
           {
               foreach (glob(get_temp_dir() . 'aiomatic_*') as $filename) 
               {
                  $f = fopen($filename, 'w');
                  if($f !== false)
                  {
                     flock($f, LOCK_UN);
                     fclose($f);
                  }
                  $wp_filesystem->delete($filename);
               }
           }
       }
       if(isset($_POST['aiomatic_restore_defaults']) && isset($_POST['aiomatic_nonce']) && wp_verify_nonce( $_POST['aiomatic_nonce'], 'openai-secret-nonce'))
       {
            aiomatic_activation_callback(true);
       }
       if(isset($_POST['aiomatic_delete_all']) && isset($_POST['aiomatic_nonce']) && wp_verify_nonce( $_POST['aiomatic_nonce'], 'openai-secret-nonce'))
       {
            aiomatic_delete_all_posts();
       }
       if(isset($_POST['aiomatic_delete_all_rules']) && isset($_POST['aiomatic_nonce']) && wp_verify_nonce( $_POST['aiomatic_nonce'], 'openai-secret-nonce'))
       {
            aiomatic_delete_all_rules();
       }
   ?>
<div class="wp-header-end"></div>
<div class="wrap gs_popuptype_holder seo_pops">
<div>
<div class="wrap gs_popuptype_holder seo_pops">
   <h2 class="cr_center"><?php echo esc_html__("Activity & Logging", 'aiomatic-automatic-ai-content-writer');?></h2>
<nav class="nav-tab-wrapper">
        <a href="#tab-0" class="nav-tab"><?php echo esc_html__("Activity Logs", 'aiomatic-automatic-ai-content-writer');?></a>
        <a href="#tab-1" class="nav-tab"><?php echo esc_html__("Maintenance", 'aiomatic-automatic-ai-content-writer');?></a>
        <a href="#tab-2" class="nav-tab"><?php echo esc_html__("System Info", 'aiomatic-automatic-ai-content-writer');?></a>
    </nav>
<div id="tab-2" class="tab-content">
      <h3>
         <?php echo esc_html__("General System Info:", 'aiomatic-automatic-ai-content-writer');?> 
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
            <div class="bws_hidden_help_text cr_min_260px">
               <?php
                  echo esc_html__("Some general system information.", 'aiomatic-automatic-ai-content-writer');
                  ?>
            </div>
         </div>
      </h3>
      <hr/>
      <table class="cr_server_stat">
         <tr class="cdr-dw-tr">
            <td class="cdr-dw-td"><?php echo esc_html__("Your User Agent:", 'aiomatic-automatic-ai-content-writer');?></td>
            <td class="cdr-dw-td-value"><?php echo esc_html($_SERVER['HTTP_USER_AGENT']); ?></td>
         </tr>
         <tr class="cdr-dw-tr">
            <td class="cdr-dw-td"><?php echo esc_html__("PHP Memory Limit:", 'aiomatic-automatic-ai-content-writer');?></td>
            <td class="cdr-dw-td-value"><?php echo esc_html(ini_get('memory_limit')); ?></td>
         </tr>
         <tr class="cdr-dw-tr">
            <td class="cdr-dw-td"><?php echo esc_html__("PHP DateTime Class:", 'aiomatic-automatic-ai-content-writer');?></td>
            <td class="cdr-dw-td-value"><?php echo (class_exists('DateTime') && class_exists('DateTimeZone')) ? '<span class="cdr-green">' . esc_html__('Available', 'aiomatic-automatic-ai-content-writer') . '</span>' : '<span class="cdr-red">' . esc_html__('Not available', 'aiomatic-automatic-ai-content-writer') . '</span> | <a href="http://php.net/manual/en/datetime.installation.php" target="_blank">more info&raquo;</a>'; ?> </td>
         </tr>
         <tr class="cdr-dw-tr">
            <td class="cdr-dw-td"><?php echo esc_html__("PHP Curl:", 'aiomatic-automatic-ai-content-writer');?></td>
            <td class="cdr-dw-td-value"><?php echo (function_exists('curl_version')) ? '<span class="cdr-green">' . esc_html__('Available', 'aiomatic-automatic-ai-content-writer') . '</span>' : '<span class="cdr-red">' . esc_html__('Not available', 'aiomatic-automatic-ai-content-writer') . '</span>'; ?> </td>
         </tr>
         <?php do_action('coderevolution_dashboard_widget_server') ?>
      </table>
      <h3>
         <?php echo esc_html__("Detailed System Info:", 'aiomatic-automatic-ai-content-writer');?> 
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
            <div class="bws_hidden_help_text cr_min_260px">
               <?php
                  echo esc_html__("More advanced and detailed system information.", 'aiomatic-automatic-ai-content-writer');
                  ?>
            </div>
         </div>
      </h3>
      <hr/>
<h4 class="screen-reader-text"><?php esc_html_e( 'WordPress Environment', 'aiomatic-automatic-ai-content-writer' ); ?></h4>
<table class="widefat" cellspacing="0">
    <thead>
    <tr>
        <th colspan="3" data-export-label="<?php echo esc_attr__( 'WordPress Environment', 'aiomatic-automatic-ai-content-writer' ); ?>"><?php esc_html_e( 'WordPress Environment', 'aiomatic-automatic-ai-content-writer' ); ?></th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td data-export-label="<?php echo esc_attr__( 'Home URL', 'aiomatic-automatic-ai-content-writer' ); ?>"><?php esc_html_e( 'Home URL:', 'aiomatic-automatic-ai-content-writer' ); ?></td>
        <td class="help">
			<?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'The URL of your site\'s homepage.', 'aiomatic-automatic-ai-content-writer' ) . '">[?]</a>'; ?>
		</td>
        <td><?php echo esc_url_raw( home_url('/') ); ?></td>
    </tr>
    <tr>
        <td data-export-label="<?php echo esc_attr__( 'Site URL', 'aiomatic-automatic-ai-content-writer' ); ?>"><?php esc_html_e( 'Site URL:', 'aiomatic-automatic-ai-content-writer' ); ?></td>
        <td class="help"><?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'The root URL of your site.', 'aiomatic-automatic-ai-content-writer' ) . '">[?]</a>'; ?></td>
        <td><?php echo esc_url_raw( site_url() ); ?></td>
    </tr>
    <tr>
        <td data-export-label="<?php echo esc_attr__( 'WP Version', 'aiomatic-automatic-ai-content-writer' ); ?>"><?php esc_html_e( 'WP Version:', 'aiomatic-automatic-ai-content-writer' ); ?></td>
        <td class="help">
			<?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'The version of WordPress installed on your site.', 'aiomatic-automatic-ai-content-writer' ) . '">[?]</a>'; ?></td>
        <td><?php echo esc_html( bloginfo( 'version' ) ); ?></td>
    </tr>
    <tr>
        <td data-export-label="<?php echo esc_attr__( 'WP Multisite', 'aiomatic-automatic-ai-content-writer' ); ?>"><?php esc_html_e( 'WP Multisite:', 'aiomatic-automatic-ai-content-writer' ); ?></td>
        <td class="help">
			<?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'Whether or not you have WordPress Multisite enabled.', 'aiomatic-automatic-ai-content-writer' ) . '">[?]</a>'; ?>
		</td>
        <td><?php echo ( is_multisite() ) ? '&#10004;' : '&ndash;'; ?></td>
    </tr>
    <tr>
        <td data-export-label="<?php echo esc_attr__('WP Memory Limit', 'aiomatic-automatic-ai-content-writer'); ?>"><?php esc_html_e( 'WP Memory Limit:', 'aiomatic-automatic-ai-content-writer' ); ?></td>
        <td class="help">
			<?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'The maximum amount of memory (RAM) that your site can use at one time.', 'aiomatic-automatic-ai-content-writer' ) . '">[?]</a>'; ?>
		</td>
        <td>
			<?php
				$memory = aiomatic_let_to_num( WP_MEMORY_LIMIT );
				if ( $memory < 64000000 ) {
					echo '<mark class="error">' . sprintf( wp_kses_post( __( '%1$s - We recommend setting memory to at least <strong>64MB</strong>. To learn how, see: <a href="%2$s" target="_blank" rel="noopener noreferrer">Increasing memory allocated to PHP.</a>', 'aiomatic-automatic-ai-content-writer' ) ), size_format( $memory ), 'https://coderevolution.ro/knowledge-base/faq/my-allocated-wordpress-memory-is-too-low-how-do-i-increase-it/' ) . '</mark>';
				} else {
					echo '<mark class="yes">' . esc_html( size_format( $memory ) ) . '</mark>';
				}
			?>
        </td>
    </tr>
    <tr>
        <td data-export-label="<?php echo esc_attr__('WP Debug Mode','aiomatic-automatic-ai-content-writer'); ?>"><?php esc_html_e( 'WP Debug Mode:', 'aiomatic-automatic-ai-content-writer' ); ?></td>
        <td class="help">
			<?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'Displays whether or not WordPress is in Debug Mode.', 'aiomatic-automatic-ai-content-writer' ) . '">[?]</a>'; ?>
		</td>
        <td>
			<?php if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) : ?>
                <mark class="yes">&#10004;</mark>
			<?php else : ?>
                <mark class="no">&ndash;</mark>
			<?php endif; ?>
        </td>
    </tr>
    <tr>
        <td data-export-label="<?php echo esc_attr__('Language', 'aiomatic-automatic-ai-content-writer'); ?>"><?php esc_html_e( 'Language:', 'aiomatic-automatic-ai-content-writer' ); ?></td>
        <td class="help">
			<?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'The current language used by WordPress. Default = English', 'aiomatic-automatic-ai-content-writer' ) . '">[?]</a>'; ?>
		</td>
        <td><?php echo get_locale(); ?></td>
    </tr>
    </tbody>
</table>

<h3 class="screen-reader-text"><?php esc_html_e( 'Server Environment', 'aiomatic-automatic-ai-content-writer' ); ?></h3>
<table class="widefat" cellspacing="0">
    <thead>
    <tr>
        <th colspan="3" data-export-label="<?php echo esc_attr__('Server Environment', 'aiomatic-automatic-ai-content-writer'); ?>"><?php esc_html_e( 'Server Environment', 'aiomatic-automatic-ai-content-writer' ); ?></th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td data-export-label="<?php echo esc_attr__('PHP Version', 'aiomatic-automatic-ai-content-writer'); ?>"><?php esc_html_e( 'PHP Version:', 'aiomatic-automatic-ai-content-writer' ); ?></td>
        <td class="help"><?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'The version of PHP installed on your hosting server.', 'aiomatic-automatic-ai-content-writer' ) . '">[?]</a>'; ?></td>
        <td><?php if ( function_exists( 'phpversion' ) ) {
				echo esc_html( phpversion() );
		} ?></td>
    </tr>

	<?php if ( function_exists( 'ini_get' ) ) : ?>
        <tr>
            <td data-export-label="<?php echo esc_attr__('PHP Post Max Size', 'aiomatic-automatic-ai-content-writer'); ?>"><?php esc_html_e( 'PHP Post Max Size:', 'aiomatic-automatic-ai-content-writer' ); ?></td>
            <td class="help"><?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'The largest file size that can be contained in one post.', 'aiomatic-automatic-ai-content-writer' ) . '">[?]</a>'; ?></td>
            <td><?php echo size_format( aiomatic_let_to_num( ini_get( 'post_max_size' ) ) ); ?></td>
        </tr>
        <tr>
            <td data-export-label="<?php echo esc_attr__('PHP Time Limit', 'aiomatic-automatic-ai-content-writer'); ?>"><?php esc_html_e( 'PHP Time Limit:', 'aiomatic-automatic-ai-content-writer' ); ?></td>
            <td class="help"><?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'The amount of time (in seconds) that your site will spend on a single operation before timing out (to avoid server lockups)', 'aiomatic-automatic-ai-content-writer' ) . '">[?]</a>'; ?></td>
            <td>
				<?php
					$time_limit = ini_get( 'max_execution_time' );
					if ( 600 > $time_limit && 0 != $time_limit ) {
						echo '<mark class="error">' . sprintf( wp_kses_post( __( '%1$s - We recommend setting max execution time to at least 600. <br /> To generate long articles, <strong>1000</strong> seconds of max execution time is recommended.<br />See: <a href="%2$s" target="_blank" rel="noopener noreferrer">Increasing max execution to PHP</a>', 'aiomatic-automatic-ai-content-writer' ) ), $time_limit, 'https://coderevolution.ro/knowledge-base/faq/how-to-increase-the-max_execution_time-settings-on-your-server/' ) . '</mark>';
					} else {
						echo '<mark class="yes">' . esc_html( $time_limit ) . '</mark>';
						if ( 1000 > $time_limit && 0 != $time_limit ) {
							echo '<br /><mark class="error">' . sprintf( wp_kses_post( __( '%1$s - We recommend setting max execution time to at least 600. <br /> To generate long articles, <strong>1000</strong> seconds of max execution time is recommended.<br />See: <a href="%2$s" target="_blank" rel="noopener noreferrer">Increasing max execution to PHP</a>', 'aiomatic-automatic-ai-content-writer' ) ), $time_limit, 'https://coderevolution.ro/knowledge-base/faq/how-to-increase-the-max_execution_time-settings-on-your-server/' ) . '</mark>';
						}
					}
				?>
            </td>
        </tr>
        <tr>
            <td data-export-label="<?php echo esc_attr__('PHP Max Input Vars', 'aiomatic-automatic-ai-content-writer'); ?>"><?php esc_html_e( 'PHP Max Input Vars (optional):', 'aiomatic-automatic-ai-content-writer' ); ?></td>
            <td class="help">
				<?php echo 	'<a href="#" class="help_tip" data-tip="' . esc_attr__( 'The maximum number of variables your server can use for a single function to avoid overloads. This is an optional settings, as the plugin can handle also cases when this is lower than the required value.', 'aiomatic-automatic-ai-content-writer' ) . '">[?]</a>'; ?>
			</td>
			<?php
				$registered_navs  = get_nav_menu_locations();
				$menu_items_count = array( '0' => '0' );
				foreach ( $registered_navs as $handle => $registered_nav ) {
					$menu = wp_get_nav_menu_object( $registered_nav );
					if ( $menu ) {
						$menu_items_count[] = $menu->count;
					}
				}
				$max_items = max( $menu_items_count );
				$required_input_vars = $max_items * 12;
			?>
            <td>
				<?php
					$max_input_vars      = ini_get( 'max_input_vars' );
					$required_input_vars = $required_input_vars + ( 500 + 1000 );
					if ( $max_input_vars < $required_input_vars ) {
						echo '<mark class="error">' . sprintf( wp_kses_post( __( '%1$s - Recommended Value: %2$s.<br />Max input vars limitation will truncate POST data such as menus. See: <a href="%3$s" target="_blank" rel="noopener noreferrer">Increasing max input vars limit.</a>', 'aiomatic-automatic-ai-content-writer' ) ), $max_input_vars, '<strong>' . $required_input_vars . '</strong>', 'http://sevenspark.com/docs/ubermenu-3/faqs/menu-item-limit' ) . '</mark>';
					} else {
						echo '<mark class="yes">' . esc_html( $max_input_vars ) . '</mark>';
					}
				?>
            </td>
        </tr>
        <tr>
            <td data-export-label="<?php echo esc_attr__('SUHOSIN Installed', 'aiomatic-automatic-ai-content-writer'); ?>"><?php esc_html_e( 'SUHOSIN Installed:', 'aiomatic-automatic-ai-content-writer' ); ?></td>
            <td class="help"><?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'Suhosin is an advanced protection system for PHP installations. It was designed to protect your servers on the one hand against a number of well known problems in PHP applications and on the other hand against potential unknown vulnerabilities within these applications or the PHP core itself.
		If enabled on your server, Suhosin may need to be configured to increase its data submission limits.', 'aiomatic-automatic-ai-content-writer' ) . '">[?]</a>';?></td>
            <td><?php echo extension_loaded( 'suhosin' ) ? '&#10004;' : '&ndash;'; ?></td>
        </tr>
		<?php if ( extension_loaded( 'suhosin' ) ) : ?>
            <tr>
                <td data-export-label="<?php echo esc_attr__('Suhosin Post Max Vars', 'aiomatic-automatic-ai-content-writer'); ?>"><?php esc_html_e( 'Suhosin Post Max Vars:', 'aiomatic-automatic-ai-content-writer' ); ?></td>
                <td class="help"><?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'The maximum number of variables your server can use for a single function to avoid overloads.', 'aiomatic-automatic-ai-content-writer' ) . '">[?]</a>'; ?></td>
				<?php
					$registered_navs  = get_nav_menu_locations();
					$menu_items_count = array( '0' => '0' );
					foreach ( $registered_navs as $handle => $registered_nav ) {
						$menu = wp_get_nav_menu_object( $registered_nav );
						if ( $menu ) {
							$menu_items_count[] = $menu->count;
						}
					}
					$max_items = max( $menu_items_count );
					
					$required_input_vars = $max_items * 12;
				?>
                <td>
					<?php
						$max_input_vars      = ini_get( 'suhosin.post.max_vars' );
						$required_input_vars = $required_input_vars + ( 500 + 1000 );
						if ( $max_input_vars < $required_input_vars ) {
							echo '<mark class="error">' . sprintf( wp_kses_post( __( '%1$s - Recommended Value: %2$s.<br />Max input vars limitation will truncate POST data such as menus. See: <a href="%3$s" target="_blank" rel="noopener noreferrer">Increasing max input vars limit.</a>', 'aiomatic-automatic-ai-content-writer' ) ), $max_input_vars, '<strong>' . ( $required_input_vars ) . '</strong>', 'http://sevenspark.com/docs/ubermenu-3/faqs/menu-item-limit' ) . '</mark>';
						} else {
							echo '<mark class="yes">' . esc_html( $max_input_vars ) . '</mark>';
						}
					?>
                </td>
            </tr>
            <tr>
                <td data-export-label="<?php echo esc_attr__( 'Suhosin Request Max Vars', 'aiomatic-automatic-ai-content-writer' ); ?>"><?php esc_html_e( 'Suhosin Request Max Vars:', 'aiomatic-automatic-ai-content-writer' ); ?></td>
                <td class="help"><?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'The maximum number of variables your server can use for a single function to avoid overloads.', 'aiomatic-automatic-ai-content-writer' ) . '">[?]</a>', 'aiomatic-automatic-ai-content-writer'; ?></td>
				<?php
					$registered_navs  = get_nav_menu_locations();
					$menu_items_count = array( '0' => '0' );
					foreach ( $registered_navs as $handle => $registered_nav ) {
						$menu = wp_get_nav_menu_object( $registered_nav );
						if ( $menu ) {
							$menu_items_count[] = $menu->count;
						}
					}
					$max_items = max( $menu_items_count );
					
					$required_input_vars = ini_get( 'suhosin.request.max_vars' );
				?>
                <td>
					<?php
						$max_input_vars      = ini_get( 'suhosin.request.max_vars' );
						$required_input_vars = $required_input_vars + ( 500 + 1000 );
						if ( $max_input_vars < $required_input_vars ) {
							echo '<mark class="error">' . sprintf( wp_kses_post( __( '%1$s - Recommended Value: %2$s.<br />Max input vars limitation will truncate POST data such as menus. See: <a href="%3$s" target="_blank" rel="noopener noreferrer">Increasing max input vars limit.</a>', 'aiomatic-automatic-ai-content-writer' ) ), $max_input_vars, '<strong>' . ( $required_input_vars + ( 500 + 1000 ) ) . '</strong>', 'http://sevenspark.com/docs/ubermenu-3/faqs/menu-item-limit' ) . '</mark>';
						} else {
							echo '<mark class="yes">' . esc_html( $max_input_vars ) . '</mark>';
						}
					?>
                </td>
            </tr>
            <tr>
                <td data-export-label="<?php echo esc_attr__( 'Suhosin Post Max Value Length', 'aiomatic-automatic-ai-content-writer' ); ?>"><?php esc_html_e( 'Suhosin Post Max Value Length:', 'aiomatic-automatic-ai-content-writer' ); ?></td>
                <td class="help"><?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'Defines the maximum length of a variable that is registered through a POST request.', 'aiomatic-automatic-ai-content-writer' ) . '">[?]</a>'; ?></td>
                <td><?php
						$suhosin_max_value_length     = ini_get( 'suhosin.post.max_value_length' );
						$recommended_max_value_length = 2000000;
						if ( $suhosin_max_value_length < $recommended_max_value_length ) {
							echo '<mark class="error">' . sprintf( wp_kses_post( __( '%1$s - Recommended Value: %2$s.<br />Post Max Value Length limitation may prohibit the Theme Options data from being saved to your database. See: <a href="%3$s" target="_blank" rel="noopener noreferrer">Suhosin Configuration Info</a>.', 'aiomatic-automatic-ai-content-writer' ) ), $suhosin_max_value_length, '<strong>' . $recommended_max_value_length . '</strong>', 'http://suhosin.org/stories/configuration.html' ) . '</mark>';
						} else {
							echo '<mark class="yes">' . esc_html( $suhosin_max_value_length ) . '</mark>';
						}
					?></td>
            </tr>
		<?php endif; ?><?php endif; ?>
    <tr>
        <td data-export-label="<?php echo esc_attr__( 'MySQL Version', 'aiomatic-automatic-ai-content-writer' ); ?>"><?php esc_html_e( 'MySQL Version:', 'aiomatic-automatic-ai-content-writer' ); ?></td>
        <td class="help"><?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'The version of MySQL installed on your hosting server.', 'aiomatic-automatic-ai-content-writer' ) . '">[?]</a>'; ?></td>
        <td>
			<?php global $wpdb; ?><?php echo esc_html( $wpdb->db_version() ); ?>
        </td>
    </tr>
    <tr>
        <td data-export-label="<?php echo esc_attr__('WP Max Upload Size', 'aiomatic-automatic-ai-content-writer'); ?>"><?php esc_html_e( 'WP Max Upload Size:', 'aiomatic-automatic-ai-content-writer' ); ?></td>
        <td class="help"><?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'The largest file size that can be uploaded to your WordPress installation.', 'aiomatic-automatic-ai-content-writer' ) . '">[?]</a>'; ?></td>
        <td><?php echo size_format( wp_max_upload_size() ); ?></td>
    </tr>
    <tr>
        <td data-export-label="<?php echo esc_attr__('DOMDocument', 'aiomatic-automatic-ai-content-writer'); ?>"><?php esc_html_e( 'DOMDocument:', 'aiomatic-automatic-ai-content-writer' ); ?></td>
        <td class="help"><?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'DOMDocument is required for the Fusion Builder plugin to properly function.', 'aiomatic-automatic-ai-content-writer' ) . '">[?]</a>'; ?></td>
        <td><?php echo class_exists( 'DOMDocument' ) ? '<mark class="yes">&#10004;</mark>' : '<mark class="error">DOMDocument is not installed on your server, but is required if you need to use the Fusion Page Builder.</mark>'; ?></td>
    </tr>
    <tr>
        <td data-export-label="<?php echo esc_attr__('GD Library', 'aiomatic-automatic-ai-content-writer'); ?>"><?php esc_html_e( 'GD Library:', 'aiomatic-automatic-ai-content-writer' ); ?></td>
        <td class="help"><?php echo'<a href="#" class="help_tip" data-tip="' . esc_attr__( 'Aiomatic uses this library to resize images and speed up your site\'s loading time', 'aiomatic-automatic-ai-content-writer' ) . '">[?]</a>'; ?></td>
        <td>
			<?php
				$info = esc_attr__( 'Not Installed', 'aiomatic-automatic-ai-content-writer' );
				if ( extension_loaded( 'gd' ) && function_exists( 'gd_info' ) ) {
					$info    = esc_attr__( 'Installed', 'aiomatic-automatic-ai-content-writer' );
					$gd_info = gd_info();
					if ( isset( $gd_info['GD Version'] ) ) {
						$info = $gd_info['GD Version'];
					}
				}
				echo esc_html( $info );
			?>
        </td>
    </tr>
    </tbody>
</table>
<h3 class="screen-reader-text"><?php esc_html_e( 'More Info', 'aiomatic-automatic-ai-content-writer' ); ?></h3>
<?php
$loaded_extensions      = get_loaded_extensions();
$extensions             = array();
$extensions['dom']      = in_array( 'dom', $loaded_extensions ) ? '<mark class="yes">dom</mark>' : '<mark class="no">dom</mark>';
$extensions['xml']      = in_array( 'xml', $loaded_extensions ) ? '<mark class="yes">xml</mark>' : '<mark class="no">xml</mark>';
$extensions['mbstring'] = in_array( 'mbstring', $loaded_extensions ) ? '<mark class="yes">mbstring</mark>' : '<mark class="no">mbstring</mark>';
$extensions['curl'] = in_array( 'curl', $loaded_extensions ) ? '<mark class="yes">curl</mark>' : '<mark class="no">curl</mark>';
$information = array();

$information['mysql_version'] = array(
	'label' => __( 'MySQL Detailed version', 'aiomatic-automatic-ai-content-writer' ),
	'value' => $wpdb->get_var( "SELECT VERSION() AS version" ),
);

$information['curl_version'] = array(
	'label' => __( 'cURL version', 'aiomatic-automatic-ai-content-writer' ),
	'value' => function_exists( 'curl_version' ) ? curl_version()['version'] : '',
);

$information['curlssl_version'] = array(
	'label' => __( 'cURL SSL version', 'aiomatic-automatic-ai-content-writer' ),
	'value' => function_exists( 'curl_version' ) ? curl_version()['ssl_version'] : '',
);

$information['cron_url'] = array(
	'label' => __( 'WP-Cron url', 'aiomatic-automatic-ai-content-writer' ),
	'value' => site_url( 'wp-cron.php' ),
);

$information['docroot'] = array(
	'label' => __( 'Document root', 'aiomatic-automatic-ai-content-writer' ),
	'value' => $_SERVER['DOCUMENT_ROOT'],
);

$information['server'] = array(
	'label' => __( 'SERVER', 'aiomatic-automatic-ai-content-writer' ),
	'value' => $_SERVER['SERVER_SOFTWARE'],
);

$information['os'] = array(
	'label' => __( 'Operating System', 'aiomatic-automatic-ai-content-writer' ),
	'value' => PHP_OS,
);

$information['maxexectime'] = array(
	'label' => __( 'Maximum execution time', 'aiomatic-automatic-ai-content-writer' ),
	'value' => sprintf( __( '%s seconds', 'aiomatic-automatic-ai-content-writer' ), ini_get( 'max_execution_time' ) ),
);

$information['language'] = array(
	'label' => __( 'Language', 'aiomatic-automatic-ai-content-writer' ),
	'value' => get_bloginfo( 'language' ),
);

$information['mysql_encoding'] = array(
	'label' => __( 'MySQL Client encoding', 'aiomatic-automatic-ai-content-writer' ),
	'value' => ! empty( DB_CHARSET ) ? DB_CHARSET : '-',
);

$information['max_upload'] = array(
	'label' => __( 'PHP Max Upload Size', 'aiomatic-automatic-ai-content-writer' ),
	'value' => ini_get( 'memory_limit' ),
);

$information['remote_post'] = array(
	'label' => __( 'Remote Post', 'aiomatic-automatic-ai-content-writer' ),
	'value' => aiomatic_test_post_reponse() ? 'ON' : 'OFF',
);

$information['remote_get'] = array(
	'label' => __( 'Remote Get', 'aiomatic-automatic-ai-content-writer' ),
	'value' => aiomatic_test_get_reponse() ? 'ON' : 'OFF',
);
global $wpdb;

$cron_status = aiomatic_check_cron_status();
$information['cron_running'] = array(
	'label' => __( 'Is CRON running', 'aiomatic-automatic-ai-content-writer' ),
	'value' => is_wp_error($cron_status)? 'No '.esc_html($cron_status->get_error_message()): 'Yes' ,
);


$information['loaded_extensions']   = array(
	'label' => __( 'Loaded PHP Extensions', 'aiomatic-automatic-ai-content-writer' ),
	'value' => implode( ', ', $loaded_extensions ),
);
$information['required_extensions'] = array(
	'label' => __( 'Required PHP Extensions', 'aiomatic-automatic-ai-content-writer' ),
	'value' => implode( ', ', $extensions ),
);
?>


	<table class="wp-list-table widefat fixed" cellspacing="0">
		<thead>
		<tr>
			<th colspan="2"><h4><?php _e( 'System Information', 'aiomatic-automatic-ai-content-writer' ) ?></h4></th>
		</tr>
		<tr>
			<th width="35%"><?php _e( 'Setting', 'aiomatic-automatic-ai-content-writer' ) ?></th>
			<th><?php _e( 'Value', 'aiomatic-automatic-ai-content-writer' ) ?></th>
		</tr>
		</thead>
		<tbody>

		<?php foreach ( $information as $info ) { ?>
			<tr>
				<td><?php echo $info['label'] ?></td>
				<td><?php echo $info['value'] ?></td>
			</tr>
		<?php } ?>

		</tbody>
	</table>

   <h3 class="screen-reader-text"><?php esc_html_e( 'Active Plugins', 'aiomatic-automatic-ai-content-writer' ); ?></h3>
<table class="widefat" cellspacing="0" id="status">
    <thead>
    <tr>
        <th colspan="3" data-export-label="<?php echo esc_attr__('Active Plugins', 'aiomatic-automatic-ai-content-writer'); ?> (<?php echo count( (array) get_option( 'active_plugins' ) ); ?>)"><?php esc_html_e( 'Active Plugins', 'aiomatic-automatic-ai-content-writer' ); ?>
            (<?php echo count( (array) get_option( 'active_plugins' ) ); ?>)
        </th>
    </tr>
    </thead>
    <tbody>
	<?php
		$active_plugins = (array) get_option( 'active_plugins', array() );
		if ( is_multisite() ) {
			$active_plugins = array_merge( $active_plugins, get_site_option( 'active_sitewide_plugins', array() ) );
		}
		foreach ( $active_plugins as $plugin ) {
			$plugin_data    = get_plugin_data( WP_PLUGIN_DIR . '/' . $plugin );
			if ( ! empty( $plugin_data['Name'] ) ) {
				// Link the plugin name to the plugin url if available.
				$plugin_name = esc_html( $plugin_data['Name'] );
				if ( ! empty( $plugin_data['PluginURI'] ) ) {
					$plugin_name = '<a href="' . esc_url_raw( $plugin_data['PluginURI'] ) . '" title="' . esc_html__( 'Visit plugin homepage', 'aiomatic-automatic-ai-content-writer' ) . '">' . $plugin_name . '</a>';
				}
				?>
                <tr>
                    <td><?php echo wp_kses_post( $plugin_name ); ?></td>
                    <td class="help">&nbsp;</td>
                    <td><?php echo esc_html__( 'by', 'aiomatic-automatic-ai-content-writer' ) . '&nbsp;' . $plugin_data['Author'] . ' &ndash; ' . esc_html( $plugin_data['Version'] ) ; ?></td>
                </tr>
				<?php
			}
		}
	?>
    </tbody>
</table>
      </div>
<div id="tab-1" class="tab-content">
      <br/>
      <hr class="cr_special_hr"/>
      <div>
         <h3>
            <?php echo esc_html__("Rules Currently Running:", 'aiomatic-automatic-ai-content-writer');?>
            <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
               <div class="bws_hidden_help_text cr_min_260px">
                  <?php
                     echo esc_html__("These rules are currently running on your server.", 'aiomatic-automatic-ai-content-writer');
                     ?>
               </div>
            </div>
         </h3>
         <div>
            <?php
               if (!get_option('aiomatic_running_list')) {
                   $running = array();
               } else {
                   $running = get_option('aiomatic_running_list');
               }
               if (!empty($running)) {
                   echo '<ul>';
                   foreach($running as $key => $thread)
                   {
                        if(is_array($thread))
                        {
                            foreach($thread as $param => $type)
                            {
                                echo '<li><b>' . esc_html($type) . '</b> - ID' . esc_html($param) . '</li>';
                            }
                        }
                        else
                        {
                            echo '<li>ID - ' . esc_html($thread) . '</li>';
                        }
                   }
                   echo '</ul>';        
               }
               else
               {
                   echo esc_html__('No rules are running right now', 'aiomatic-automatic-ai-content-writer');
               }
               ?>
         </div>
         <hr/>
         <form method="post" onsubmit="return confirm('<?php echo esc_html__('Are you sure you want to clear the running list?', 'aiomatic-automatic-ai-content-writer');?>');">
            <input name="aiomatic_delete_rules" type="submit" title="<?php echo esc_html__('Caution! This is for debugging purpose only!', 'aiomatic-automatic-ai-content-writer');?>" value="<?php echo esc_html__('Clear Running Rules List', 'aiomatic-automatic-ai-content-writer');?>">
            <input name="aiomatic_nonce" type="hidden" value="<?php echo wp_create_nonce('openai-secret-nonce');?>">
         </form>
      </div>
         <br/>
         <hr class="cr_special_hr"/>
         <div>
            <h3>
               <?php echo esc_html__('Restore Plugin Default Settings', 'aiomatic-automatic-ai-content-writer');?> 
               <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                  <div class="bws_hidden_help_text cr_min_260px">
                     <?php
                        echo esc_html__('Hit this button and the plugin settings will be restored to their default values. Warning! All settings will be lost!', 'aiomatic-automatic-ai-content-writer');
                        ?>
                  </div>
               </div>
            </h3>
            <hr/>
            <form method="post" onsubmit="return confirm('<?php echo esc_html__('Are you sure you want to restore the default plugin settings?', 'aiomatic-automatic-ai-content-writer');?>');"><input name="aiomatic_restore_defaults" type="submit" value="<?php echo esc_html__('Restore Plugin Default Settings', 'aiomatic-automatic-ai-content-writer');?>">
         <input name="aiomatic_nonce" type="hidden" value="<?php echo wp_create_nonce('openai-secret-nonce');?>"></form>
         </div>
         <br/>
         <hr class="cr_special_hr"/>
         <div>
            <h3>
               <?php echo esc_html__('Delete All Posts Generated by this Plugin:', 'aiomatic-automatic-ai-content-writer');?> 
               <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                  <div class="bws_hidden_help_text cr_min_260px">
                     <?php
                        echo esc_html__('Hit this button and all posts generated by this plugin will be deleted!', 'aiomatic-automatic-ai-content-writer');
                        ?>
                  </div>
               </div>
            </h3>
            <hr/>
            <form method="post" onsubmit="return confirm('<?php echo esc_html__('Are you sure you want to delete all generated posts? This can take a while, please wait until it finishes.', 'aiomatic-automatic-ai-content-writer');?>');"><input name="aiomatic_delete_all" type="submit" value="<?php echo esc_html__('Delete All Generated Posts', 'aiomatic-automatic-ai-content-writer');?>">
         <input name="aiomatic_nonce" type="hidden" value="<?php echo wp_create_nonce('openai-secret-nonce');?>"></form>
         </div>
         <br/>
         <hr class="cr_special_hr"/>
         <div>
            <h3>
               <?php echo esc_html__('Delete All Rules from All Section: ', 'aiomatic-automatic-ai-content-writer');?>
               <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                  <div class="bws_hidden_help_text cr_min_260px">
                     <?php
                        echo esc_html__("Hit this button and all rules will be deleted!", 'aiomatic-automatic-ai-content-writer');
                        ?>
                  </div>
               </div>
            </h3>
            <hr/>
            <form method="post" onsubmit="return confirm('Are you sure you want to delete all rules?');"><input name="aiomatic_delete_all_rules" type="submit" value="Delete All Generated Rules">
         <input name="aiomatic_nonce" type="hidden" value="<?php echo wp_create_nonce('openai-secret-nonce');?>"></form>
         </div>
         <br/>
   </div>
   <div id="tab-0" class="tab-content">
         <hr class="cr_special_hr"/>
         <h3>
            <?php echo esc_html__('Activity Log:', 'aiomatic-automatic-ai-content-writer');?>
            <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
               <div class="bws_hidden_help_text cr_min_260px">
                  <?php
                     echo esc_html__('This is the main log of your plugin. Here will be listed every single instance of the rules you run or are automatically run by schedule jobs (if you enable logging, in the plugin configuration).', 'aiomatic-automatic-ai-content-writer');
                     ?>
               </div>
            </div>
         </h3>
      <hr/>
      <form method="post" onsubmit="return confirm('<?php echo esc_html__('Are you sure you want to delete all logs?', 'aiomatic-automatic-ai-content-writer');?>');">
         <input name="aiomatic_delete" type="submit" value="<?php echo esc_html__('Delete Logs', 'aiomatic-automatic-ai-content-writer');?>">
         <input name="aiomatic_nonce" type="hidden" value="<?php echo wp_create_nonce('openai-secret-nonce');?>">
      </form>
      <hr/>
         <div>
            <?php
               if($wp_filesystem->exists(WP_CONTENT_DIR . '/aiomatic_info.log'))
               {
                    $log = $wp_filesystem->get_contents(WP_CONTENT_DIR . '/aiomatic_info.log');
                    $log = esc_html($log);$log = str_replace('&lt;br/&gt;', '<br/>', $log);echo $log;
               }
               else
               {
                   echo esc_html__('Log empty', 'aiomatic-automatic-ai-content-writer');
               }
               ?>
         </div>
      </div>
</div>
</div>
<?php
   }
   ?>