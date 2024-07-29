<?php
class Aiomatic_Setup_Wizard {
    private $step   = '';
    private $steps  = array();
    public function __construct() 
    {
        if ( current_user_can( 'access_aiomatic_menu' ) ) 
        {
            if ( empty( $_GET['page'] ) || 'aiomatic_admin_settings' !== $_GET['page'] ) 
            {
                return;
            }
            $name = md5(get_bloginfo());
            $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
            wp_enqueue_script($name . '-main-script', plugins_url('scripts/main.js', __FILE__), array('jquery'), AIOMATIC_MAJOR_VERSION);
            wp_enqueue_script($name . '-setup-script', plugins_url('scripts/setup.js', __FILE__), array('jquery'), AIOMATIC_MAJOR_VERSION);
            if(!isset($aiomatic_Main_Settings['best_user']))
            {
                $best_user = '';
            }
            else
            {
                $best_user = $aiomatic_Main_Settings['best_user'];
            }
            if(!isset($aiomatic_Main_Settings['best_password']))
            {
                $best_password = '';
            }
            else
            {
                $best_password = $aiomatic_Main_Settings['best_password'];
            }
            $header_main_settings = array(
                'best_user' => $best_user,
                'best_password' => $best_password,
                'ajaxurl' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('openai-ajax-nonce'),
            );
            wp_localize_script($name . '-main-script', 'mycustommainsettings', $header_main_settings);
            wp_register_style($name . '-browser-style', plugins_url('styles/aiomatic-browser.css', __FILE__), false, AIOMATIC_MAJOR_VERSION);
            wp_enqueue_style($name . '-browser-style');
            wp_register_style($name . '-custom-style', plugins_url('styles/coderevolution-style.css', __FILE__), false, AIOMATIC_MAJOR_VERSION);
            wp_enqueue_style($name . '-custom-style');
            wp_enqueue_script('jquery');
            wp_enqueue_script('jquery-ui-core');
            wp_enqueue_script('interface');
            wp_enqueue_script('jquery-ui-sortable');
            wp_enqueue_script('media-upload');
            wp_enqueue_script('thickbox');
            wp_enqueue_style('thickbox');
            $this->setup_wizard($aiomatic_Main_Settings);
        }
    }
    public function setup_wizard($aiomatic_Main_Settings) 
    {
        $this->steps = array(
            'intro' => array(
                'name'    =>  esc_html__( 'Welcome', 'aiomatic-automatic-ai-content-writer' ),
                'view'    => array( $this, 'setup_step_introduction' ),
                'handler' => ''
            ),
            'activation' => array(
                'name'    =>  esc_html__( 'Activation', 'aiomatic-automatic-ai-content-writer' ),
                'view'    => array( $this, 'setup_step_basic' ),
                'handler' => array( $this, 'setup_step_basic_save' )
            ),
            'apikeys' => array(
                'name'    =>  esc_html__( 'API Keys', 'aiomatic-automatic-ai-content-writer' ),
                'view'    => array( $this, 'setup_step_api' ),
                'handler' => array( $this, 'setup_step_api_save' )
            ),
            'content' => array(
                'name'    =>  esc_html__( 'Content', 'aiomatic-automatic-ai-content-writer' ),
                'view'    => array( $this, 'setup_step_content' ),
                'handler' => array( $this, 'setup_step_content_save' )
            ),
            'editor' => array(
                'name'    =>  esc_html__( 'Editor', 'aiomatic-automatic-ai-content-writer' ),
                'view'    => array( $this, 'setup_step_editor' ),
                'handler' => array( $this, 'setup_step_editor_save' ),
            ),
            'chatbot' => array(
                'name'    =>  esc_html__( 'Chatbot', 'aiomatic-automatic-ai-content-writer' ),
                'view'    => array( $this, 'setup_step_chatbot' ),
                'handler' => array( $this, 'setup_step_chatbot_save' ),
            ),
            'forms' => array(
                'name'    =>  esc_html__( 'AI Forms', 'aiomatic-automatic-ai-content-writer' ),
                'view'    => array( $this, 'setup_step_forms' ),
                'handler' => array( $this, 'setup_step_forms_save' ),
            ),
            'playground' => array(
                'name'    =>  esc_html__( 'Playground', 'aiomatic-automatic-ai-content-writer' ),
                'view'    => array( $this, 'setup_step_playground' ),
                'handler' => array( $this, 'setup_step_playground_save' ),
            ),
            'more' => array(
                'name'    =>  esc_html__( 'More', 'aiomatic-automatic-ai-content-writer' ),
                'view'    => array( $this, 'setup_step_more' ),
                'handler' => array( $this, 'setup_step_more_save' ),
            ),
            'next_steps' => array(
                'name'    =>  esc_html__( 'Ready!', 'aiomatic-automatic-ai-content-writer' ),
                'view'    => array( $this, 'setup_step_ready' ),
                'handler' => ''
            )
        );

        $this->step = isset( $_GET['step'] ) ? sanitize_key( $_GET['step'] ) : current( array_keys( $this->steps ) );
        wp_enqueue_style( 'aiomatic-setup', plugins_url('styles/setup.css', __FILE__), array( 'dashicons', 'install' ) );

        if ( isset($_POST['save_step']) && ! empty( $_POST['save_step'] ) && isset( $this->steps[ $this->step ]['handler'] ) ) 
        {
            call_user_func( $this->steps[ $this->step ]['handler'] );
        }
        $plugin = plugin_basename(__FILE__);
        $plugin_slug = explode('/', $plugin);
        $plugin_slug = $plugin_slug[0]; 
        update_option($plugin_slug . '_registration', array('item_id'=>'38877369', 'item_name'=>'Aiomatic - Automatic AI Content Writer', 'created_at'=>'NA', 'buyer'=>'GPL','licence'=>'Custom License','supported_until'=>'12/12/2099'));
        if(isset($_POST[$plugin_slug . '_register_setup']) && isset($_POST[$plugin_slug. '_register_code_setup']) && trim($_POST[$plugin_slug . '_register_code_setup']) != '' && isset($_POST['aiomatic_nonce_setup']) && wp_verify_nonce( $_POST['aiomatic_nonce_setup'], 'openai-secret-nonce'))
        {
            if(strlen(trim($_POST[$plugin_slug . '_register_code_setup'])) != 36 || strstr($_POST[$plugin_slug . '_register_code_setup'], '-') == false)
            {
                aiomatic_log_to_file('Invalid registration code submitted: ' . $_POST[$plugin_slug . '_register_code_setup']);
                update_option('aiomatic_activation_status', 'Invalid registration code submitted: ' . $_POST[$plugin_slug . '_register_code_setup']);
            }
            else
            {
                $ch = curl_init('https://wpinitiate.com/verify-purchase/purchase.php');
                if($ch !== false)
                {
                    $data           = array();
                    $data['code']   = trim($_POST[$plugin_slug . '_register_code_setup']);
                    $data['siteURL']   = get_bloginfo('url');
                    $data['siteName']   = get_bloginfo('name');
                    $data['siteEmail']   = get_bloginfo('admin_email');
                    $fdata = "";
                    foreach ($data as $key => $val) {
                        $fdata .= "$key=" . urlencode(trim($val)) . "&";
                    }
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $fdata);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
                    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                    $result = curl_exec($ch);
                    
                    if($result === false)
                    {
                        aiomatic_log_to_file('Failed to get verification response: ' . curl_error($ch));
                        update_option('aiomatic_activation_status', 'Failed to get verification response: ' . curl_error($ch));
                    }
                    else
                    {
                        $rj = json_decode($result, true);
                        if(isset($rj['error']))
                        {
                            update_option('aiomatic_activation_status', 'Activation error: ' . $rj['error']);
                        }
                        elseif(isset($rj['item_name']))
                        {
                            $rj['code'] = $_POST[$plugin_slug . '_register_code_setup'];
                            if($rj['item_id'] == '38877369' || $rj['item_id'] == '13371337' || $rj['item_id'] == '19200046')
                            {
                                update_option($plugin_slug . '_registration', $rj);
                            }
                            else
                            {
                                aiomatic_log_to_file('Invalid response from purchase code verification (are you sure you inputed the right purchase code?): ' . print_r($rj, true));
                                update_option('aiomatic_activation_status', 'Invalid response from purchase code verification (are you sure you inputed the right purchase code?): ' . print_r($rj, true));
                            }
                        }
                        else
                        {
                            aiomatic_log_to_file('Invalid json from purchase code verification: ' . print_r($result, true));
                            update_option('aiomatic_activation_status', 'Invalid json from purchase code verification: ' . print_r($result, true));
                        }
                    }
                    curl_close($ch);
                }
                else
                {
                    aiomatic_log_to_file('Failed to init curl when trying to make purchase verification.');
                    update_option('aiomatic_activation_status', 'Failed to init curl when trying to make purchase verification');
                }
            }
        }
        if(isset($_POST[$plugin_slug . '_revoke_license_setup']) && trim($_POST[$plugin_slug . '_revoke_license_setup']) != '' && isset($_POST['aiomatic_nonce_setup']) && wp_verify_nonce( $_POST['aiomatic_nonce_setup'], 'openai-secret-nonce'))
        {
            $ch = curl_init('https://wpinitiate.com/verify-purchase/revoke.php');
            if($ch !== false)
            {
                $data           = array();
                $data['siteURL']   = get_bloginfo('url');
                $fdata = "";
                foreach ($data as $key => $val) {
                    $fdata .= "$key=" . urlencode(trim($val)) . "&";
                }
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $fdata);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
                curl_setopt($ch, CURLOPT_TIMEOUT, 60);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                $result = curl_exec($ch);
                
                if($result === false)
                {
                    aiomatic_log_to_file('Failed to revoke verification response: ' . curl_error($ch));
                    update_option($plugin_slug . '_registration', false);
                }
                else
                {
                    update_option($plugin_slug . '_registration', false);
                }
            }
            else
            {
                aiomatic_log_to_file('Failed to init curl to revoke verification response.');
                update_option('aiomatic_activation_status', 'Failed to init curl to revoke verification response.');
            }
        }

        ob_start();
        $this->setup_wizard_header();
        $this->setup_wizard_steps($aiomatic_Main_Settings);
        $this->setup_wizard_content();
        $this->setup_wizard_footer();
        exit;
    }

    public function get_next_step_link() {
        $keys = array_keys( $this->steps );
        return add_query_arg( 'step', $keys[ array_search( $this->step, array_keys( $this->steps ) ) + 1 ], remove_query_arg( 'translation_updated' ) );
    }
    
    public function get_prev_step_link() {
        $keys = array_keys( $this->steps );
        return add_query_arg( 'step', $keys[ array_search( $this->step, array_keys( $this->steps ) ) - 1 ], remove_query_arg( 'translation_updated' ) );
    }

    public function setup_wizard_header() {
        ?>
        <!DOCTYPE html>
        <html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
        <head>
            <meta name="viewport" content="width=device-width" />
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <title><?php esc_html_e( 'Aiomatic Quick Setup & Tutorial', 'aiomatic-automatic-ai-content-writer' ); ?></title>
            <?php remove_action( 'admin_print_styles', 'print_emoji_styles' );do_action( 'admin_print_styles' );add_action( 'admin_print_styles', 'print_emoji_styles' ); ?>
            <?php do_action( 'admin_print_scripts' ); ?>
            <?php remove_action( 'admin_head', 'wp_admin_bar_header' );do_action( 'admin_head' );add_action( 'admin_head', 'wp_admin_bar_header' );?>
        </head>
        <body class="aiomatic-setup wp-core-ui">
            <h1 id="aiomatic-logo" class="aiomatic-logo"><a target="_blank" href="https://1.envato.market/aiomatic"><?php esc_html_e( 'Aiomatic Quick Setup & Tutorial', 'aiomatic-automatic-ai-content-writer' ); ?></a></h1>
        <?php
    }

    public function setup_wizard_footer() {
        ?>
        <?php remove_action( 'admin_bar_menu', 'wp_admin_bar_edit_menu', 80 );remove_action( 'wp_footer', 'the_block_template_skip_link' );do_action( 'wp_footer' );add_action( 'wp_footer', 'the_block_template_skip_link' );add_action( 'admin_bar_menu', 'wp_admin_bar_edit_menu', 80 ); ?>
            </body>
        </html>
        <?php
    }

    public function setup_wizard_steps($aiomatic_Main_Settings) {
        $output_steps = $this->steps;
        ?>
        <ol class="aiomatic-setup-steps">
            <?php $apifound = false;
            foreach ( $output_steps as $step_key => $step ) : ?>
                <li class="<?php
                    if ( $step_key === $this->step ) {
                        echo 'active';
                    } elseif ( array_search( $this->step, array_keys( $this->steps ) ) > array_search( $step_key, array_keys( $this->steps ) ) ) {
                        echo 'done';
                    }
                    ?>"><a <?php if(!aiomatic_validate_activation() && ($this->step == 'intro' || $this->step == 'activation') && $step_key !== 'intro' && $step_key != 'activation'){ echo ' href="#" ';}else{?>href=<?php if($apifound === true){echo '"#" title="' . esc_html__( 'You need to add an AiomaticAPI/OpenAI/Azure OpenAI API key to use these features!', 'aiomatic-automatic-ai-content-writer' ) . '"';}else {echo '"' . esc_url_raw( admin_url( 'admin.php?page=aiomatic_admin_settings&step=' . $step_key ) ) . '"';}}?>><?php echo esc_html( $step['name'] ); ?></a>
                </li>
            <?php 
                if($step_key == 'apikeys' && (!isset($aiomatic_Main_Settings['app_id']) || $aiomatic_Main_Settings['app_id'] == ''))
                {
                    $apifound = true;
                }
            endforeach; ?>
        </ol>
        <?php
    }

    public function setup_wizard_content() {
        echo '<div class="aiomatic-setup-content">';
        call_user_func( $this->steps[ $this->step ]['view'] );
        echo '</div>';
    }

    public function next_step_buttons($first = false, $required = false, $show_save = false, $no_go = false) {
        ?>
        <p class="aiomatic-setup-actions step">
        <?php
            if($no_go === false)
            {
                if($show_save === true)
                {
                ?>
                <input type="submit" class="button-primary button button-large button-next" value="<?php esc_attr_e( 'Save & Continue', 'aiomatic-automatic-ai-content-writer' ); ?>" name="save_step" />
                <?php
                }
                else
                {
                ?>
                <input type="submit" class="button-primary button button-large button-next" value="<?php esc_attr_e( 'Continue', 'aiomatic-automatic-ai-content-writer' ); ?>" name="save_step" />
                <?php
                }
            }
            if($required === false)
            {
            ?>
            <a href="<?php echo esc_url_raw( $this->get_next_step_link() ); ?>" class="button button-large button-next"><?php esc_html_e( 'Skip', 'aiomatic-automatic-ai-content-writer' ); ?></a>
            <?php 
            }
            if($first == false)
            {
                echo '<a href="' . esc_url_raw( $this->get_prev_step_link() ) . '" class="button button-large button-next">' . esc_html__( 'Back', 'aiomatic-automatic-ai-content-writer' ) . '</a>';
            }
            echo '<a href="' . esc_url_raw( admin_url('admin.php?page=aiomatic_admin_settings&aiomatic_done_config=1') ) . '" class="button button-large button-next">' . esc_html__( 'Abort', 'aiomatic-automatic-ai-content-writer' ) . '</a>';
            wp_nonce_field( 'aiomatic_admin_settings' ); ?>
        </p>
        <?php
    }

    public function setup_step_introduction() {
        ?>
        <h1><?php esc_html_e( 'Congratulations on choosing Aiomatic!', 'aiomatic-automatic-ai-content-writer' ); ?></h1>
        <p><?php echo wp_kses_post( esc_html__('You are about to streamline your WordPress experience with the top AI content creation tool available. This Quick Setup Wizard is designed to help you configure the essential settings of Aiomatic swiftly and effortlessly. Setting up should take no more than a few minutes.', 'aiomatic-automatic-ai-content-writer' ) ); ?></p>
        <h3><?php esc_html_e( 'Why use the Quick Setup?', 'aiomatic-automatic-ai-content-writer' ); ?></h3>
        <ul>
            <li><b><?php esc_html_e( 'Efficient Configuration:', 'aiomatic-automatic-ai-content-writer' );?></b>&nbsp;<?php esc_html_e( 'Get your plugin up and running with settings that cater to your needs.', 'aiomatic-automatic-ai-content-writer' );?></li>
            <li><b><?php esc_html_e( 'Flexibility:', 'aiomatic-automatic-ai-content-writer' );?></b>&nbsp;<?php esc_html_e( 'You can also customize the settings later in the Aiomatic dashboard.', 'aiomatic-automatic-ai-content-writer' );?></li>
            <li><b><?php esc_html_e( 'Guidance:', 'aiomatic-automatic-ai-content-writer' );?></b>&nbsp;<?php esc_html_e( 'Step-by-step assistance to make setup a breeze.', 'aiomatic-automatic-ai-content-writer' );?></li>
        </ul>
        <iframe class="cr-youtube-video" src="https://www.youtube.com/embed/sJqEfTzc8gQ" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        <br/><br/>
        <h3><?php esc_html_e( 'What you\'ll need:', 'aiomatic-automatic-ai-content-writer' ); ?></h3>
        <ul>
            <li><?php echo sprintf( wp_kses( __( "Your API key for <a href='%s' target='_blank'>AiomaticAPI</a>, <a href='%s' target='_blank'>OpenAI</a> or <a href='%s' target='_blank'>Microsoft Azure OpenAI</a> (whichever you prefer). Other, secondary AI services will also be able to be used in the plugin, like: Anthropic (Claude), Google AI Studio (Gemini Pro), Perplexity AI, HuggingFaceAI or OpenRouter - each will provide a set of AI models for use in the plugin.", 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), "https://aiomaticapi.com/api-keys/", "https://platform.openai.com/api-keys", "https://portal.azure.com/?microsoft_azure_marketplace_ItemHideKey=microsoft_openai_tip#home" );?></li>
            <li><?php esc_html_e( 'Basic configuration details like your preferred AI model and content generation preferences.', 'aiomatic-automatic-ai-content-writer' );?></li>
        </ul>
        <h3><?php esc_html_e( 'Optional but helpful:', 'aiomatic-automatic-ai-content-writer' ); ?></h3>
        <ul>
            <li><?php esc_html_e( 'Access to tutorial videos that provide a visual guide on configuring and maximizing Aiomatic:', 'aiomatic-automatic-ai-content-writer' );?></li>
            <li><a href="https://www.youtube.com/watch?v=_Ft1czw-VPU&list=PLEiGTaa0iBIhRvgICiyvwBXH-dMBM4VAt" target="_blank"><?php esc_html_e( 'Watch Aiomatic\'s Quick Setup Tutorials', 'aiomatic-automatic-ai-content-writer' );?></a></li>
            <li><a href="https://www.youtube.com/watch?v=aD7PkrUdzb8&list=PLEiGTaa0iBIhsRSgl5czLEDAhawr_SHx2" target="_blank"><?php esc_html_e( 'Watch Aiomatic\'s Update Videos', 'aiomatic-automatic-ai-content-writer' );?></a></li>
        </ul>
        <h3><?php esc_html_e( 'Not the right time?', 'aiomatic-automatic-ai-content-writer' ); ?></h3>
        <ul>
            <li><?php esc_html_e( 'Feel free to skip this setup wizard and jump straight to the Aiomatic dashboard. You can return to this setup wizard anytime to fine-tune your configuration. To do so, go to the plugin\' \'Settings\' menu -> \'Welcome\' tab, where you will be able to access this wizard again in the future.', 'aiomatic-automatic-ai-content-writer' );?></li>
        </ul>
        <p><b><?php esc_html_e( 'Let\'s get started and unlock the full potential of your WordPress site with AI-powered content!', 'aiomatic-automatic-ai-content-writer' ); ?></b></p>
        <p><?php esc_html_e( 'Need help or have questions? Our comprehensive', 'aiomatic-automatic-ai-content-writer' ); ?><a href="https://coderevolution.ro/support/tickets/aiomatic-support/" target="_blank">&nbsp;<?php esc_html_e( 'support center', 'aiomatic-automatic-ai-content-writer' ); ?></a>&nbsp;<?php esc_html_e( 'is here for you', 'aiomatic-automatic-ai-content-writer' ); ?></p>
        <p><b><?php esc_html_e( 'Thank you for choosing Aiomatic - where powerful AI meets content creation.', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<?php esc_html_e( 'Let\'s make something amazing together!', 'aiomatic-automatic-ai-content-writer' ); ?></p>
        <p class="aiomatic-setup-actions step">
            <a href="<?php echo esc_url_raw( $this->get_next_step_link() ); ?>" class="button-primary button button-large button-next"><?php esc_html_e( 'Let\'s Go!', 'aiomatic-automatic-ai-content-writer' ); ?></a>
            <a href="<?php echo esc_url_raw( admin_url( 'admin.php?page=aiomatic_admin_settings&aiomatic_done_config=1' ) ); ?>" class="button button-large"><?php esc_html_e( 'Not right now', 'aiomatic-automatic-ai-content-writer' ); ?></a>
        </p>
        <?php
    }

    public function setup_step_basic() {
        ?>
        <h1><?php esc_html_e( 'License Activation', 'aiomatic-automatic-ai-content-writer' ); ?></h1>

        <form id="registerForm" method="post">
            <table class="form-table">
            <tr>
                     <td colspan="2">
                        <?php
                           $plugin = plugin_basename(__FILE__);
                           $plugin_slug = explode('/', $plugin);
                           $plugin_slug = $plugin_slug[0]; 
                           $uoptions = array();
                           $is_activated = aiomatic_is_activated($plugin_slug, $uoptions);
                           if($is_activated === true)
                           {
                           ?>
                        <h3><b><?php echo esc_html__("Plugin Registration Info - Automatic Updates Enabled:", 'aiomatic-automatic-ai-content-writer');?></b> </h3>
                        <ul>
                           <li><b><?php echo esc_html__("Item Name:", 'aiomatic-automatic-ai-content-writer');?></b> <?php echo esc_html($uoptions['item_name']);?></li>
                           <li>
                              <b><?php echo esc_html__("Item ID:", 'aiomatic-automatic-ai-content-writer');?></b> <?php echo esc_html($uoptions['item_id']);?>
                           </li>
                           <li>
                              <b><?php echo esc_html__("Created At:", 'aiomatic-automatic-ai-content-writer');?></b> <?php echo esc_html($uoptions['created_at']);?>
                           </li>
                           <li>
                              <b><?php echo esc_html__("Buyer Name:", 'aiomatic-automatic-ai-content-writer');?></b> <?php echo esc_html($uoptions['buyer']);?>
                           </li>
                           <li>
                              <b><?php echo esc_html__("License Type:", 'aiomatic-automatic-ai-content-writer');?></b> <?php echo esc_html($uoptions['licence']);?>
                           </li>
                           <li>
                              <b><?php echo esc_html__("Supported Until:", 'aiomatic-automatic-ai-content-writer');?></b> <?php echo esc_html($uoptions['supported_until']);?>
                              <?php 
                              $supported = strtotime($uoptions['supported_until']);
                              if($supported !== false && $supported < time())
                              {
      ?>
      <div class="notice notice-error is-dismissible">
        <p>
         <?php echo sprintf( wp_kses( __( 'Your support for Aiomatic has expired. Please <a href="%s" target="_blank">renew it</a> to continue receiving support for the plugin. After you renewed support, please click the "Revoke License" button, from the plugin\'s "Settings" menu -> "Plugin Activation" tab and add your license key again, to activate the plugin with the renewed support license.', 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), '//codecanyon.net/item/aiomatic-automatic-ai-content-writer/38877369/support');?>
        </p>
    </div>
    <?php
                              }
                              ?>
                           </li>
                        </ul>
                        <p>
                        <input type="submit" onclick="unsaved = false;" class="button button-primary" name="<?php echo esc_html($plugin_slug);?>_revoke_license_setup" value="<?php echo esc_html__("Revoke License", 'aiomatic-automatic-ai-content-writer');?>">
                        <input name="aiomatic_nonce_setup" type="hidden" value="<?php echo wp_create_nonce('openai-secret-nonce');?>">
                        </p>
                        <?php
                           }
                           elseif($is_activated === 2)
                           {
?>
<div class="notice notice-error"><p><?php echo esc_html__("This is a demo version of the Aiomatic plugin, it has limited functionality in some cases. In the demo mode, the plugin does not need purchase code activation. To use it also on your site, you can purchase a license for it from here: ", 'aiomatic-automatic-ai-content-writer');?><a href="https://1.envato.market/aiomatic" target="_blank"><?php echo esc_html__("Aiomatic on CodeCanyon", 'aiomatic-automatic-ai-content-writer');?></a></p></div>
<?php
                           }
                           elseif($is_activated === -1)
                           {
?>
<div class="notice notice-error"><p><?php echo esc_html__("You are using a PIRATED version of the plugin! Because of this, the main functionality of the plugin is not available. Please revoke your license and activate a genuine license for the Aiomatic plugin. Note that the only place where you can get a valid license for the plugin is found here (if you find the plugin for sale also on other websites, do not buy, they are selling pirated copies): ", 'aiomatic-automatic-ai-content-writer');?><a href="https://1.envato.market/aiomatic" target="_blank"><?php echo esc_html__("Aiomatic on CodeCanyon", 'aiomatic-automatic-ai-content-writer');?></a></p></div>
<input type="submit" onclick="unsaved = false;" class="button button-primary" name="<?php echo esc_html($plugin_slug);?>_revoke_license_setup" value="<?php echo esc_html__("Revoke License", 'aiomatic-automatic-ai-content-writer');?>">
<input name="aiomatic_nonce_setup" type="hidden" value="<?php echo wp_create_nonce('openai-secret-nonce');?>">
<?php
                           }
                           else
                           {
                            $last_action = get_option('aiomatic_activation_status', '');
                            if(!empty($last_action))
                            {
                                delete_option('aiomatic_activation_status');
                                echo '<div class="cr_red notice notice-error is-dismissible">' . esc_html__("Failed to change the plugin license status: ", 'aiomatic-automatic-ai-content-writer') . esc_html($last_action) . '</div>';
                            }
                           ?>
                        <div class="notice notice-error is-dismissible"><p><?php echo esc_html__("To unlock all the features of Aiomatic and start generating high-quality AI content, please activate your license key. By activating the plugin you will also benefit of automatic updates. Activation is a one-time process and provides you access to the best of Aiomatic in compliance with our terms of use.", 'aiomatic-automatic-ai-content-writer');?></p></div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo sprintf( wp_kses( __( 'Please input your Envato purchase code, to enable automatic updates in the plugin. To get your purchase code, please follow <a href="%s" target="_blank">this tutorial</a>. Info submitted to the registration server consists of: purchase code, site URL, site name, admin email. All these data will be used strictly for registration purposes.', 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), '//coderevolution.ro/knowledge-base/faq/how-do-i-find-my-items-purchase-code-for-plugin-license-activation/' );
                                 ?>
                           </div>
                        </div>
                        <b><?php echo esc_html__("Aiomatic Purchase Code:", 'aiomatic-automatic-ai-content-writer');?></b>
                     </td>
                     <td><input type="text" required name="<?php echo esc_html($plugin_slug);?>_register_code_setup" value="" placeholder="<?php echo esc_html__("Envato Purchase Code", 'aiomatic-automatic-ai-content-writer');?>" class="cr_width_full">
                     <input name="aiomatic_nonce_setup" type="hidden" value="<?php echo wp_create_nonce('openai-secret-nonce');?>"></td>
                  </tr>
                  <tr>
                     <td colspan="2"><input type="submit" name="<?php echo esc_html($plugin_slug);?>_register_setup" id="<?php echo esc_html($plugin_slug);?>_register_setup" class="button button-primary" onclick="unsaved = false;" value="<?php echo esc_html__("Activate License", 'aiomatic-automatic-ai-content-writer');?>"/>
                        <?php
                           }
                           ?>
                     </td>
                  </tr>
            </table>
<?php 
if($is_activated === true || $is_activated === 2)
{
    $this->next_step_buttons(true, true);
}
else
{
    $this->next_step_buttons(true, true, false, true);
}
?>
        </form>
        <br/><br/>
        <?php
    }
public function setup_step_content() {
        ?>
        <h1><?php esc_html_e( 'AI Content Creation', 'aiomatic-automatic-ai-content-writer' ); ?></h1>
        <p><?php esc_html_e( 'From here on, the Quick Setup will teach you the basics of the plugin\'s usage, check each step and read the provided explanations carefully. Also, watching the tutorial videos can be very helpful for a better understanding of the plugin\'s functionality.', 'aiomatic-automatic-ai-content-writer' ); ?></p>
        <p><?php esc_html_e( 'Aiomatic revolutionizes content creation with AI-driven capabilities designed to cater to a wide range of content needs. From single posts to bulk articles, and from video captions to product reviews, this plugin covers all bases, streamlining the content generation process for your WordPress site. There will be both manual and automatic variants of content creation, check below the options offered by the plugin:', 'aiomatic-automatic-ai-content-writer' ); ?></p>
        <hr/>
        <h3 class="ai-section-title"><?php esc_html_e( 'Single AI Post Creator', 'aiomatic-automatic-ai-content-writer' ); ?></h3>
        <p><b><?php esc_html_e( 'Location:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<a href="<?php echo esc_url_raw( admin_url('admin.php?page=aiomatic_single_panel'));?>" target="_blank"><?php esc_html_e( 'Single AI Post Creator Menu', 'aiomatic-automatic-ai-content-writer' ); ?></a></p>
        <p><?php esc_html_e( 'The Single AI Post Creator allows you to effortlessly create individual blog posts using AI. Here, you can manually edit and publish each AI-generated article, complete with images. The Single AI Post Creator has two different modes in which it can be used:', 'aiomatic-automatic-ai-content-writer' ); ?></p>
        <p><b><?php esc_html_e( '1. Express Mode:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<?php esc_html_e( 'Quickly generate a post with AI-assisted content—ideal for when you need content fast.', 'aiomatic-automatic-ai-content-writer' ); ?></p>
        <p><b><?php esc_html_e( 'Watch a Tutorial for the Single AI Post Creator Express Mode:', 'aiomatic-automatic-ai-content-writer' ); ?></b></p>
        <iframe class="cr-youtube-video" src="https://www.youtube.com/embed/3W-UGm7pbsU" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        <br/><br/>
        <p><b><?php esc_html_e( '2. Advanced Mode:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<?php esc_html_e( 'Offers detailed controls to fine-tune the AI output, perfect for when you need a more tailored approach.', 'aiomatic-automatic-ai-content-writer' ); ?></p>
        <p><b><?php esc_html_e( 'Watch a Tutorial for the Single AI Post Creator Advanced Mode:', 'aiomatic-automatic-ai-content-writer' ); ?></b></p>
        <iframe class="cr-youtube-video" src="https://www.youtube.com/embed/rlDtQ8qgGYg" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        <br/><br/>

        <hr/>
        <h3 class="ai-section-title"><?php esc_html_e( 'Bulk AI Post Creator', 'aiomatic-automatic-ai-content-writer' ); ?></h3>
        <p><b><?php esc_html_e( 'Location:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<a href="<?php echo esc_url_raw( admin_url('admin.php?page=aiomatic_items_panel'));?>" target="_blank"><?php esc_html_e( 'Bulk AI Post Creator Menu', 'aiomatic-automatic-ai-content-writer' ); ?></a></p>
        <p><?php esc_html_e( 'For those looking to scale their content creation, the Bulk AI Post Creator automates the process, allowing you to publish multiple posts according to a schedule. Here also you will find two different ways which will be able to be used, to create content in bulk:', 'aiomatic-automatic-ai-content-writer' ); ?></p>
        <p><b><?php esc_html_e( '1. Title Based Post Creator:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<?php esc_html_e( 'A more straight forward approach, allowing you to input titles, and the AI will generate corresponding posts, streamlining the creation process. This is recommended if you want to create shorter articles (the entire article will be created with a single API call).', 'aiomatic-automatic-ai-content-writer' ); ?></p>
        <p><b><?php esc_html_e( '2. Section Based Post Creator:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<?php esc_html_e( 'Start with keywords, and the AI develops long-form content, crafted to provide depth and value. This is recommended for detailed articles, which are based on multiple sections (each section will be created with a different API call).', 'aiomatic-automatic-ai-content-writer' ); ?></p>
        <p><b><?php esc_html_e( 'Watch a Tutorial for the Bulk AI Post Creator:', 'aiomatic-automatic-ai-content-writer' ); ?></b></p>
        <iframe class="cr-youtube-video" src="https://www.youtube.com/embed/dhWhsEIccPU" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        <br/><br/>

        <hr/>
        <h3 class="ai-section-title"><?php esc_html_e( 'YouTube Videos to Blog Posts', 'aiomatic-automatic-ai-content-writer' ); ?></h3>
        <p><b><?php esc_html_e( 'Location:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<a href="<?php echo esc_url_raw( admin_url('admin.php?page=aiomatic_youtube_panel'));?>" target="_blank"><?php esc_html_e( 'YouTube to Blog Posts Menu', 'aiomatic-automatic-ai-content-writer' ); ?></a></p>
        <p><?php esc_html_e( 'Transform YouTube videos into engaging blog articles. This function parses video captions and employs AI to craft comprehensive posts based on the video content.', 'aiomatic-automatic-ai-content-writer' ); ?></p>
        <p><b><?php esc_html_e( 'Watch a Tutorial for the YouTube to Blog Posts:', 'aiomatic-automatic-ai-content-writer' ); ?></b></p>
        <iframe class="cr-youtube-video" src="https://www.youtube.com/embed/MWpu_ly5ZKE" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        <br/><br/>

        <hr/>
        <h3 class="ai-section-title"><?php esc_html_e( 'Amazon Product Roundup', 'aiomatic-automatic-ai-content-writer' ); ?></h3>
        <p><b><?php esc_html_e( 'Location:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<a href="<?php echo esc_url_raw( admin_url('admin.php?page=aiomatic_amazon_panel'));?>" target="_blank"><?php esc_html_e( 'Amazon Product Roundup Menu', 'aiomatic-automatic-ai-content-writer' ); ?></a></p>
        <p><?php esc_html_e( 'Create compelling product comparison articles with the Amazon Product Roundup feature. By entering search keywords, you\'ll get AI-generated articles that compare various Amazon products, utilizing imported product info for accuracy and depth.', 'aiomatic-automatic-ai-content-writer' ); ?></p>
        <p><b><?php esc_html_e( 'Watch a Tutorial for the Amazon Product Roundup:', 'aiomatic-automatic-ai-content-writer' ); ?></b></p>
        <iframe class="cr-youtube-video" src="https://www.youtube.com/embed/li3UhcGpVc0" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        <br/><br/>

        <hr/>
        <h3 class="ai-section-title"><?php esc_html_e( 'Amazon Product Review', 'aiomatic-automatic-ai-content-writer' ); ?></h3>
        <p><b><?php esc_html_e( 'Location:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<a href="<?php echo esc_url_raw( admin_url('admin.php?page=aiomatic_review_panel'));?>" target="_blank"><?php esc_html_e( 'Amazon Product Review Menu', 'aiomatic-automatic-ai-content-writer' ); ?></a></p>
        <p><?php esc_html_e( 'Delve into detailed reviews with the Amazon Product Review feature. Each article is crafted based on the extensive descriptions available on Amazon, providing your readers with thorough insights into the products.', 'aiomatic-automatic-ai-content-writer' ); ?></p>
        <p><b><?php esc_html_e( 'Watch a Tutorial for the Amazon Product Review:', 'aiomatic-automatic-ai-content-writer' ); ?></b></p>
        <iframe class="cr-youtube-video" src="https://www.youtube.com/embed/X_sxxlbdKXU" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        <br/><br/>

        <hr/>
        <h3 class="ai-section-title"><?php esc_html_e( 'CSV Post Creator', 'aiomatic-automatic-ai-content-writer' ); ?></h3>
        <p><b><?php esc_html_e( 'Location:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<a href="<?php echo esc_url_raw( admin_url('admin.php?page=aiomatic_csv_panel'));?>" target="_blank"><?php esc_html_e( 'CSV Post Creator', 'aiomatic-automatic-ai-content-writer' ); ?></a></p>
        <p><?php esc_html_e( 'For data-driven content creation, the CSV Post Creator allows articles to be automatically generated from data uploaded in CSV format. This feature is perfect for creating content that includes data analytics, comparisons, or listings.', 'aiomatic-automatic-ai-content-writer' ); ?></p>
        <p><b><?php esc_html_e( 'Watch a Tutorial for the CSV Post Creator:', 'aiomatic-automatic-ai-content-writer' ); ?></b></p>
        <iframe class="cr-youtube-video" src="https://www.youtube.com/embed/3ZhuTt81F58" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        <br/><br/>

        <hr/>
        <h3 class="ai-section-title"><?php esc_html_e( 'OmniBlocks', 'aiomatic-automatic-ai-content-writer' ); ?></h3>
        <p><b><?php esc_html_e( 'Location:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<a href="<?php echo esc_url_raw( admin_url('admin.php?page=aiomatic_omniblocks#tab-1'));?>" target="_blank"><?php esc_html_e( 'OmniBlocks', 'aiomatic-automatic-ai-content-writer' ); ?></a></p>
        <p><?php esc_html_e( 'OmniBlocks is the most advanced feature of this plugin, you can also call it the Ultimate AI Content Creation Tool, offering custom queues of blocks that work in unison to generate AI content. This includes text, images, videos, as well as integrating data from Amazon products, YouTube videos, web scrapes, RSS feeds, and Google search results. Content can be crafted into posts, published across social media platforms, or used to call webhooks for extensive automation.', 'aiomatic-automatic-ai-content-writer' ); ?></p>
        <ul>
            <li>
            <b><?php esc_html_e( 'Content Types:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<?php esc_html_e( 'Generate diverse content types including posts for social media like Facebook, X (formerly Twitter), Instagram, Pinterest, YouTube Community, LinkedIn, and Reddit.', 'aiomatic-automatic-ai-content-writer' ); ?>
            </li>
            <li>
            <b><?php esc_html_e( 'Advanced Integration:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<?php esc_html_e( 'Use webhooks for dynamic content creation and distribution strategies.', 'aiomatic-automatic-ai-content-writer' ); ?>
            </li>
            <li>
            <b><?php esc_html_e( 'Continuous Development:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<?php esc_html_e( 'New OmniBlock templates and types are continuously added to the plugin in new updates, allowing you to use them in more and more powerful ways.', 'aiomatic-automatic-ai-content-writer' ); ?>
            </li>
        </ul>
        <p><b><?php esc_html_e( 'Watch a Tutorial for the OmniBlocks:', 'aiomatic-automatic-ai-content-writer' ); ?></b></p>
        <iframe class="cr-youtube-video" src="https://www.youtube.com/embed/vuyssxmxP_Y" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        <br/><br/>
        <p><?php esc_html_e( 'These features are designed to harness the power of AI to not only simplify content creation but also to enhance the quality and relevance of the content you publish on your WordPress site. Dive into each feature, explore its potential, and transform the way you create content online.', 'aiomatic-automatic-ai-content-writer' ); ?></p>
        <p><?php esc_html_e( 'These features are designed to harness the power of AI to not only simplify content creation but also to enhance the quality and relevance of the content you publish on your WordPress site. Dive into each feature, explore its potential, and transform the way you create content online.', 'aiomatic-automatic-ai-content-writer' ); ?></p>
        <form method="post">
            <?php $this->next_step_buttons(); ?>
        </form>
        <br/><br/>
        <?php
}

public function setup_step_forms() {
        ?>
        <h1><?php esc_html_e( 'AI Forms', 'aiomatic-automatic-ai-content-writer' ); ?></h1>
        <p><?php esc_html_e( 'AI Forms within the Aiomatic plugin offer a dynamic way to interact with your site visitors through customizable input forms. These forms can be configured to use textual inputs or to generate images with Dall-E, Midjourney or Stable Diffusion models, enhancing the functionality and interactivity of your WordPress site.', 'aiomatic-automatic-ai-content-writer' ); ?></p>
        <p><b><?php esc_html_e( 'What are AI Forms?', 'aiomatic-automatic-ai-content-writer' ); ?></b></p>
        <p><?php esc_html_e( 'AI Forms allow for the creation of fully customizable forms that users can interact with directly on your site. These forms support multiple types of inputs including text boxes, radio buttons, checkboxes, and even AI-generated image selectors. You can integrate these forms anywhere on your site using the [aiomatic-form id="FORM_ID"] shortcode.', 'aiomatic-automatic-ai-content-writer' ); ?></p>
        <?php esc_html_e( 'Potential Uses:', 'aiomatic-automatic-ai-content-writer' ); ?>
        <ul>
            <li>
            <b><?php esc_html_e( 'Customized User Interactions:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<?php esc_html_e( 'Tailor responses to user queries or inputs.', 'aiomatic-automatic-ai-content-writer' ); ?>
            </li>
            <li>
            <b><?php esc_html_e( 'AI Membership Sites:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<?php esc_html_e( 'Facilitate user engagement and content personalization.', 'aiomatic-automatic-ai-content-writer' ); ?>
            </li>
            <li>
            <b><?php esc_html_e( 'Enhanced Site Functionality:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<?php esc_html_e( 'Leverage AI to provide unique services or features.', 'aiomatic-automatic-ai-content-writer' ); ?>
            </li>
            <li>
            <b><?php esc_html_e( 'Built-in Shortcodes:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<?php esc_html_e( 'Extend form capabilities with built-in shortcodes detailed in the \'Built-in Shortcodes\' tab.', 'aiomatic-automatic-ai-content-writer' ); ?>
            </li>
        </ul>

        <hr/>
        <h3 class="ai-section-title"><?php esc_html_e( 'Getting Started with AI Forms', 'aiomatic-automatic-ai-content-writer' ); ?></h3>
        <p><b><?php esc_html_e( 'Step 0: Preparation', 'aiomatic-automatic-ai-content-writer' ); ?></b></p>
        <p><?php esc_html_e( 'Ensure you understand the full capabilities and setup process by reading this tutorial and watching the associated tutorial video from below.', 'aiomatic-automatic-ai-content-writer' ); ?></p>
        <p><b><?php esc_html_e( 'Step 1a: Import Default AI Forms', 'aiomatic-automatic-ai-content-writer' ); ?></b></p>
        <p><b><?php esc_html_e( 'Location:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<a href="<?php echo esc_url_raw( admin_url('admin.php?page=aiomatic_shortcodes_panel#tab-4'));?>" target="_blank"><?php esc_html_e( 'AI Forms Importer/Exporter', 'aiomatic-automatic-ai-content-writer' ); ?></a></p>
        <p><?php esc_html_e( 'For quick deployment, import default forms that come bundled with the plugin:', 'aiomatic-automatic-ai-content-writer' ); ?></p>
        <ul>
            <li>
            <?php esc_html_e( 'Navigate to the \'AI Forms Importer/Exporter\' tab.', 'aiomatic-automatic-ai-content-writer' ); ?>
            </li>
            <li>
            <?php esc_html_e( 'Click \'Import Default Forms\' to instantly add pre-configured forms to your site.', 'aiomatic-automatic-ai-content-writer' ); ?>
            </li>
        </ul>
        <p><b><?php esc_html_e( 'Step 1b: Create Your Own AI Forms', 'aiomatic-automatic-ai-content-writer' ); ?></b></p>
        <p><b><?php esc_html_e( 'Location:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<a href="<?php echo esc_url_raw( admin_url('admin.php?page=aiomatic_shortcodes_panel#tab-2'));?>" target="_blank"><?php esc_html_e( 'Add A New AI Form', 'aiomatic-automatic-ai-content-writer' ); ?></a></p>
        <p><?php esc_html_e( 'Customize and create your forms tailored to your needs:', 'aiomatic-automatic-ai-content-writer' ); ?></p>
        <ul>
            <li>
            <b><?php esc_html_e( 'Form Types:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<?php esc_html_e( 'Choose from text, Dall-E image, Midjourney or Stable Diffusion image forms.', 'aiomatic-automatic-ai-content-writer' ); ?>
            </li>
            <li>
            <b><?php esc_html_e( 'Form Setup:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<?php esc_html_e( 'Assign a name and description. Add custom input fields using the \'Add A New Form Input Field\' button.', 'aiomatic-automatic-ai-content-writer' ); ?>
            </li>
            <li>
            <b><?php esc_html_e( 'Input Fields:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<?php esc_html_e( 'For each input field, set an ID to use as a shortcode within the form\'s AI prompts (e.g., %%input_field_ID%%).', 'aiomatic-automatic-ai-content-writer' ); ?>
            </li>
            <li>
            <b><?php esc_html_e( 'Advanced Settings:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<?php esc_html_e( 'Configure AI model settings and submit button text and much more.', 'aiomatic-automatic-ai-content-writer' ); ?>
            </li>
        </ul>
        <p><b><?php esc_html_e( 'Step 2: Use AI Forms on Your Site', 'aiomatic-automatic-ai-content-writer' ); ?></b></p>
        <p><b><?php esc_html_e( 'Location:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<a href="<?php echo esc_url_raw( admin_url('admin.php?page=aiomatic_shortcodes_panel#tab-3'));?>" target="_blank"><?php esc_html_e( 'List AI Forms', 'aiomatic-automatic-ai-content-writer' ); ?></a></p>
        <p><?php esc_html_e( 'List and deploy AI Forms and manage them effectively:', 'aiomatic-automatic-ai-content-writer' ); ?></p>
        <ul>
            <li>
            <b><?php esc_html_e( 'Embedding Forms:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<?php esc_html_e( 'Use the [aiomatic-form id="FORM_ID"] shortcode to add forms to posts, pages, or widgets.', 'aiomatic-automatic-ai-content-writer' ); ?>
            </li>
            <li>
            <b><?php esc_html_e( 'Manage Forms:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<?php esc_html_e( 'Edit, delete, or preview existing forms through the \'List AI Forms\' tab.', 'aiomatic-automatic-ai-content-writer' ); ?>
            </li>
        </ul>
        <hr/>
        <h3 class="ai-section-title"><?php esc_html_e( 'Finalizing Your AI Forms Setup', 'aiomatic-automatic-ai-content-writer' ); ?></h3>
        <p><?php esc_html_e( 'Transform your site with AI Forms—start engaging your users in more meaningful ways today! AI Forms pave the way for innovative interactions and content personalization, enhancing your digital presence and user experience.', 'aiomatic-automatic-ai-content-writer' ); ?></p>
        <p><?php esc_html_e( 'Congratulations on setting up your AI Forms! These forms are not just tools for data collection but gateways to sophisticated interactions that utilize the full potential of AI within your WordPress environment.', 'aiomatic-automatic-ai-content-writer' ); ?></p>

        <p><b><?php esc_html_e( 'Watch a Tutorial for AI Forms:', 'aiomatic-automatic-ai-content-writer' ); ?></b></p>
        <iframe class="cr-youtube-video" src="https://www.youtube.com/embed/NhbEeIXxu-0" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        <br/><br/>

        <form method="post">
            <?php $this->next_step_buttons(); ?>
        </form>
        <div class="cr_center"><?php esc_html_e( 'For more settings, check the plugin\'s ', 'aiomatic-automatic-ai-content-writer' ); echo '"<a href="' . esc_url_raw( admin_url('admin.php?page=aiomatic_shortcodes_panel#tab-3') ) . '" target="_blank">';esc_html_e( 'AI Forms', 'aiomatic-automatic-ai-content-writer' ); echo '</a>" tab.'; ?></div>
        <br/><br/>
        <?php
}
public function setup_step_api() {
    $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
    if (isset($aiomatic_Main_Settings['api_selector'])) {
        $api_selector = $aiomatic_Main_Settings['api_selector'];
    } else {
        $api_selector = 'openai';
    }
    if (isset($aiomatic_Main_Settings['azure_endpoint'])) {
        $azure_endpoint = $aiomatic_Main_Settings['azure_endpoint'];
    } else {
        $azure_endpoint = 'openai';
    }
    if (isset($aiomatic_Main_Settings['app_id_claude'])) {
        $app_id_claude = $aiomatic_Main_Settings['app_id_claude'];
    } else {
        $app_id_claude = '';
    }
    if (isset($aiomatic_Main_Settings['app_id_google'])) {
        $app_id_google = $aiomatic_Main_Settings['app_id_google'];
    } else {
        $app_id_google = '';
    }
    if (isset($aiomatic_Main_Settings['app_id_perplexity'])) {
        $app_id_perplexity = $aiomatic_Main_Settings['app_id_perplexity'];
    } else {
        $app_id_perplexity = '';
    }
    if (isset($aiomatic_Main_Settings['app_id_openrouter'])) {
        $app_id_openrouter = $aiomatic_Main_Settings['app_id_openrouter'];
    } else {
        $app_id_openrouter = '';
    }
    if (isset($aiomatic_Main_Settings['app_id_huggingface'])) {
        $app_id_huggingface = $aiomatic_Main_Settings['app_id_huggingface'];
    } else {
        $app_id_huggingface = '';
    }
    if (isset($aiomatic_Main_Settings['app_id'])) {
        $app_id = $aiomatic_Main_Settings['app_id'];
    } else {
        $app_id = '';
    }
        ?>
        <h1><?php esc_html_e( 'API Keys', 'aiomatic-automatic-ai-content-writer' ); ?></h1>

        <form method="post">
            <input name="aiomatic_nonce_rand" type="hidden" value="<?php echo wp_create_nonce('openai-secret-nonce');?>">
            <table class="form-table">
            <tr><td colspan="2"><h3><?php echo esc_html__("Main AI API Settings (Required):", 'aiomatic-automatic-ai-content-writer');?></h3></td></tr>
               <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Select the AI API service to use to generate content in the plugin using the gpt-3.5/gpt-4 models.", 'aiomatic-automatic-ai-content-writer');
                                    ?>
                              </div>
                           </div>
                           <span><?php echo esc_html__("Main API Service Provider Selector:", 'aiomatic-automatic-ai-content-writer');?></span>
                        </div>
                     </td>
                     <td>
                        <div>
                           <select id="api_selector" name="aiomatic_Main_Settings[api_selector]"  class="cr_width_full">
                              <option value="openai"<?php
                                 if ($api_selector == "openai") {
                                     echo " selected";
                                 }
                                 ?>><?php echo esc_html__("OpenAI / AiomaticAPI", 'aiomatic-automatic-ai-content-writer');?></option>
                              <option value="azure"<?php
                                 if ($api_selector == "azure") {
                                     echo " selected";
                                 }
                                 ?>><?php echo esc_html__("Microsoft Azure", 'aiomatic-automatic-ai-content-writer');?></option>                         
                           </select>
                        </div>
                     </td>
                  </tr>
                  <tr class="azurehide">
            <td colspan="2">
               <span class="cr_red">
<?php echo sprintf( wp_kses( __( "Check <a href='%s' target='_blank'>this detailed step-by-step tutorial</a> and also <a href='%s' target='_blank'>this tutorial video</a> for info on setup and usage of Microsoft Azure OpenAI API in Aiomatic.", 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), 'https://coderevolution.ro/knowledge-base/faq/how-to-setup-microsoft-azure-api-in-aiomatic/', 'https://www.youtube.com/watch?v=56ZHp2B4qgY' );?></span></td>
                              </tr>
          <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo sprintf( wp_kses( __( "Insert your API Keys (one per line). For OpenAI API, get your API key <a href='%s' target='_blank'>here</a>. For AiomaticAPI, get your API key <a href='%s' target='_blank'>here</a>. For Azure, get your API key <a href='%s' target='_blank'>here</a>.", 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), 'https://platform.openai.com/api-keys', 'https://aiomaticapi.com/pricing/', 'https://portal.azure.com/?microsoft_azure_marketplace_ItemHideKey=microsoft_openai_tip#home' );
                           ?>
                     </div>
                  </div>
                  <span class="cr_red"><span id="apilinks"><a href='https://platform.openai.com/api-keys' target='_blank'>OpenAI</a>&nbsp;/&nbsp;<a href='https://aiomaticapi.com/api-keys/' target='_blank'>AiomaticAPI</a></span>&nbsp;<?php echo esc_html__("API Keys (One Per Line) - *Required:", 'aiomatic-automatic-ai-content-writer');?></span>   
<?php
$token = '';
$appids = preg_split('/\r\n|\r|\n/', trim($aiomatic_Main_Settings['app_id']));
$appids = array_filter($appids);
if(count($appids) == 1)
{
   $token = $appids[array_rand($appids)];
   if(aiomatic_is_aiomaticapi_key($token))
   {
      $call_count = get_transient('aiomaticapi_tokens');
      if($token != '' && $call_count !== false)
      {
         echo esc_html__("Remaining API Tokens: ", 'aiomatic-automatic-ai-content-writer') . '<b>' . $call_count . '</b>';
      }
   }
}

?>
               </div>
            </td>
            <td>
               <div>
                  <textarea rows="2" id="app_id" required onkeyup="keyUpdated();" class="cr_textarea_pass cr_width_full" name="aiomatic_Main_Settings[app_id]" placeholder="<?php echo esc_html__("Please insert your OpenAI/AiomaticAPI API Key", 'aiomatic-automatic-ai-content-writer');?>"><?php
                     echo esc_textarea($app_id);
                     ?></textarea>
               </div>
            </td>
            </tr>
            <tr class="azurehide">
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo sprintf( wp_kses( __( "Insert your Azure OpenAI API endpoint. Get one in the <a href='%s' target='_blank'>Microsoft Azure Services panel</a>.", 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), 'https://portal.azure.com/?microsoft_azure_marketplace_ItemHideKey=microsoft_openai_tip#home' );
                           ?>
                     </div>
                  </div>
                  <span><?php echo esc_html__("Azure OpenAI Endpoint:", 'aiomatic-automatic-ai-content-writer');?></span>   
               </div>
            </td>
            <td>
               <div>
                  <input type="url" class="cr_width_full" autocomplete="off" id="azure_endpoint" name="aiomatic_Main_Settings[azure_endpoint]" placeholder="<?php echo esc_html__("Azure Endpoint", 'aiomatic-automatic-ai-content-writer');?>" value="<?php echo esc_attr($azure_endpoint);?>">
               </div>
            </td>
            </tr><tr class="azurehide"><td colspan="2"><h4><?php echo esc_html__("Azure AI Model Deployments List", 'aiomatic-automatic-ai-content-writer');
?>:</h4></td></tr>
<?php
foreach (AIOMATIC_AZURE_MODELS as $model) {
   ?>
   <tr class="azurehide">
       <td>
           <div>
               <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                   <div class="bws_hidden_help_text cr_min_260px">
                       <?php
                       echo sprintf( wp_kses( __( "Insert your Azure OpenAI API deployment name for %s model. Create one in the <a href='%s' target='_blank'>Microsoft Azure Services panel</a>.", 'aiomatic-automatic-ai-content-writer'), array( 'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_html($model), 'https://portal.azure.com/?microsoft_azure_marketplace_ItemHideKey=microsoft_openai_tip#home' );
                       ?>
                   </div>
               </div>
               <span><?php echo esc_html__("Azure OpenAI Deployment Name For '", 'aiomatic-automatic-ai-content-writer') . $model . "':";?></span>   
           </div>
       </td>
       <td>
           <div>
               <input type="text" class="cr_width_full" autocomplete="off" id="azure_model_deployments_<?php echo esc_attr($model); ?>" name="aiomatic_Main_Settings[azure_model_deployments][<?php echo esc_attr($model); ?>]" placeholder="<?php echo esc_html__("Azure deployment name for ", 'aiomatic-automatic-ai-content-writer') . $model;?>" value="<?php echo esc_attr( isset($azure_model_deployments[$model]) ? $azure_model_deployments[$model] : '' );?>">
           </div>
       </td>
   </tr>
   <?php
}
?>
<tr><td colspan="2"><h3><?php echo esc_html__("Additional AI API Settings (Optional):", 'aiomatic-automatic-ai-content-writer');?></h3></td></tr>
<tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo sprintf( wp_kses( __( "Adding your Anthropic Claude API key in this settings field, will make the Anthropic Claude models to appear in all model selector boxes from the plugin. To make it work, insert your Anthropic Claude API Keys (one per line). Get your API key <a href='%s' target='_blank'>here</a>.", 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), 'https://console.anthropic.com/account/keys' );
                           ?>
                     </div>
                  </div>
                  <span class="cr_red"><span id="apilinksClaude"><a href='https://console.anthropic.com/account/keys' target='_blank'>Anthropic Claude</a>&nbsp;<?php echo esc_html__("API Keys (One Per Line):", 'aiomatic-automatic-ai-content-writer');?></span>
               </div>
            </td>
            <td>
               <div>
                  <textarea rows="2" id="app_id_claude" class="cr_textarea_pass cr_width_full" name="aiomatic_Main_Settings[app_id_claude]" placeholder="<?php echo esc_html__("Please insert your Anthropic Claude API Key", 'aiomatic-automatic-ai-content-writer');?>"><?php
                     echo esc_textarea($app_id_claude);
                     ?></textarea>
               </div>
            </td>
            </tr>
<tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo sprintf( wp_kses( __( "Adding your Google AI Studio API key in this settings field, will make the Google AI Studio AI models to appear in all model selector boxes from the plugin. To make it work, insert your Google AI Studio AI API Keys (one per line). Get your API key <a href='%s' target='_blank'>here</a>.", 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), 'https://aistudio.google.com/app/apikey' );
                           ?>
                     </div>
                  </div>
                  <span class="cr_red"><span id="apilinksGoogle"><a href='https://aistudio.google.com/app/apikey' target='_blank'>Google AI Studio AI</a>&nbsp;<?php echo esc_html__("API Keys (One Per Line):", 'aiomatic-automatic-ai-content-writer');?></span>
               </div>
            </td>
            <td>
               <div>
                  <textarea rows="2" id="app_id_google" class="cr_textarea_pass cr_width_full" name="aiomatic_Main_Settings[app_id_google]" placeholder="<?php echo esc_html__("Please insert your Google AI Studio AI API Key", 'aiomatic-automatic-ai-content-writer');?>"><?php
                     echo esc_textarea($app_id_google);
                     ?></textarea>
               </div>
            </td>
            </tr>
<tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo sprintf( wp_kses( __( "Adding your Perplexity key in this settings field, will make the Perplexity AI models to appear in all model selector boxes from the plugin. To make it work, insert your Perplexity AI API Keys (one per line). Get your API key <a href='%s' target='_blank'>here</a>.", 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), 'https://www.perplexity.ai/settings/api' );
                           ?>
                     </div>
                  </div>
                  <span class="cr_red"><span id="apilinksPerplexity"><a href='https://www.perplexity.ai/settings/api' target='_blank'>Perplexity AI</a>&nbsp;<?php echo esc_html__("API Keys (One Per Line):", 'aiomatic-automatic-ai-content-writer');?></span>
               </div>
            </td>
            <td>
               <div>
                  <textarea rows="2" id="app_id_perplexity" class="cr_textarea_pass cr_width_full" name="aiomatic_Main_Settings[app_id_perplexity]" placeholder="<?php echo esc_html__("Please insert your Perplexity AI API Key", 'aiomatic-automatic-ai-content-writer');?>"><?php
                     echo esc_textarea($app_id_perplexity);
                     ?></textarea>
               </div>
            </td>
            </tr>
<tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo sprintf( wp_kses( __( "Adding your OpenRouter key in this settings field, will make the OpenRouter AI models to appear in all model selector boxes from the plugin. To make it work, insert your OpenRouter AI API Keys (one per line). Get your API key <a href='%s' target='_blank'>here</a>.", 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), 'https://openrouter.ai/keys' );
                           ?>
                     </div>
                  </div>
                  <span class="cr_red"><span id="apilinksOpenrouter"><a href='https://openrouter.ai/keys' target='_blank'>OpenRouter AI</a>&nbsp;<?php echo esc_html__("API Keys (One Per Line):", 'aiomatic-automatic-ai-content-writer');?></span>
               </div>
            </td>
            <td>
               <div>
                  <textarea rows="2" id="app_id_openrouter" class="cr_textarea_pass cr_width_full" name="aiomatic_Main_Settings[app_id_openrouter]" placeholder="<?php echo esc_html__("Please insert your OpenRouter AI API Key", 'aiomatic-automatic-ai-content-writer');?>"><?php
                     echo esc_textarea($app_id_openrouter);
                     ?></textarea>
               </div>
            </td>
            </tr>
            <tr>
            <th>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo sprintf( wp_kses( __( "Adding your HuggingFace key in this settings field, will make the HuggingFace AI models to appear in all model selector boxes from the plugin. To make it work, insert your HuggingFace AI API Keys (one per line). Get your API key <a href='%s' target='_blank'>here</a>.", 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), 'https://huggingface.co/settings/tokens' );
                           ?>
                     </div>
                  </div>
                  <b class="cr_red"><span id="apilinksHuggingFace"><a href='https://huggingface.co/settings/tokens' target='_blank'>HuggingFace AI</a>&nbsp;<?php echo esc_html__("API Keys (One Per Line):", 'aiomatic-automatic-ai-content-writer');?></b>
               </div>
            </th>
            <td>
               <div>
                  <textarea rows="2" id="app_id_huggingface" class="cr_textarea_pass cr_width_full" name="aiomatic_Main_Settings[app_id_huggingface]" placeholder="<?php echo esc_html__("Please insert your HuggingFace AI API Key", 'aiomatic-automatic-ai-content-writer');?>"><?php
                     echo esc_textarea($app_id_huggingface);
                     ?></textarea>
               </div>
            </td>
            </tr>
            </table>

            <?php $this->next_step_buttons(false, true, true); ?>
        </form>
        <div class="cr_center"><?php esc_html_e( 'For more options and to set up more APIs which can be used in the plugin, check the plugin\'s ', 'aiomatic-automatic-ai-content-writer' ); echo '"<a href="' . esc_url_raw( admin_url('admin.php?page=aiomatic_admin_settings&skip_config=1#tab-2') ) . '" target="_blank">';esc_html_e( 'API Keys', 'aiomatic-automatic-ai-content-writer' ); echo '</a>" tab.'; ?></div>
        <br/><br/>
        <?php
    }

public function setup_step_more() {
        ?>
        <h1><?php esc_html_e( 'More Features', 'aiomatic-automatic-ai-content-writer' ); ?></h1>
        <p><?php esc_html_e( 'While Aiomatic is known for its powerful core functionalities, it also boasts a suite of hidden gems that can significantly enhance your digital experience on WordPress. From content management to interactive engagement, these additional features are designed to supercharge your website\'s capabilities. Let\'s delve into these exciting features.', 'aiomatic-automatic-ai-content-writer' ); ?></p>
        
        <h3 class="ai-section-title"><?php esc_html_e( 'Use AI Assistants Instead Of AI Models', 'aiomatic-automatic-ai-content-writer' ); ?></h3>
        <p><b><?php esc_html_e( 'Location:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<a href="<?php echo esc_url_raw( admin_url('admin.php?page=aiomatic_assistants_panel') );?>" target="_blank"><?php esc_html_e( 'AI Assistants', 'aiomatic-automatic-ai-content-writer' ); ?></a></p>
        <p><b><?php esc_html_e( 'Step 1a: Create a New Assistant', 'aiomatic-automatic-ai-content-writer' ); ?></b></p>
        <ul>
            <li>
            <b><?php esc_html_e( 'Add New Assistant:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<?php esc_html_e( 'Click the \'Add New Assistant\' button to start configuring a new assistant.', 'aiomatic-automatic-ai-content-writer' ); ?>
            </li>
            <li>
            <b><?php esc_html_e( 'Configuration Details:', 'aiomatic-automatic-ai-content-writer' ); ?></b>
            <br/><ul>
                <li><b><?php esc_html_e( 'Name and Description:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<?php esc_html_e( 'Provide a name and a detailed description of the assistant\'s responsibilities.', 'aiomatic-automatic-ai-content-writer' ); ?></li>
                <li><b><?php esc_html_e( 'AI Model Selection:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<?php esc_html_e( 'Choose an AI model that best suits the tasks you expect the assistant to perform.', 'aiomatic-automatic-ai-content-writer' ); ?></li>
                <li><b><?php esc_html_e( 'Context Prompt:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<?php esc_html_e( ' In the \'Assistant Context Prompt\' field, input necessary background information which the assistant should consistently remember (e.g., its name, role, and any specific tasks it needs to handle).', 'aiomatic-automatic-ai-content-writer' ); ?></li>
                <li><b><?php esc_html_e( 'Advanced Features:', 'aiomatic-automatic-ai-content-writer' ); ?></b>
                    <ul>
                        <li>
                        <?php esc_html_e( 'Enable features like \'Code Interpreter\' for running snippets of code.', 'aiomatic-automatic-ai-content-writer' ); ?>
                        </li>
                        <li>
                        <?php esc_html_e( 'Enable \'File Search\' for fetching and using external data.', 'aiomatic-automatic-ai-content-writer' ); ?>
                        </li>
                        <li>
                        <?php esc_html_e( 'Add custom functions that the assistant can use to process requests.', 'aiomatic-automatic-ai-content-writer' ); ?>
                        </li>
                        <li>
                        <?php esc_html_e( 'Upload files that the assistant can reference or extract content from.', 'aiomatic-automatic-ai-content-writer' ); ?>
                        </li>
                    </ul>
                </li>
                <li><b><?php esc_html_e( 'Avatar Assignment:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<?php esc_html_e( 'Assign an avatar that will represent the assistant, particularly useful when the assistant is utilized in chatbot functions.', 'aiomatic-automatic-ai-content-writer' ); ?></li>
                </ul>
            </li>
        </ul>
        <p><b><?php esc_html_e( 'Step 1b: Import Existing Assistants', 'aiomatic-automatic-ai-content-writer' ); ?></b></p>
        <p><?php esc_html_e( 'If you have pre-configured assistants on OpenAI\'s platform, use the \'Import Assistants From OpenAI\' button to integrate them directly into your WordPress site. All imported and created assistants will be available for selection and use within the plugin.', 'aiomatic-automatic-ai-content-writer' ); ?></p>
        <p><b><?php esc_html_e( 'Step 2: Utilize Assistants in Plugin Settings', 'aiomatic-automatic-ai-content-writer' ); ?></b></p>
        <p><?php esc_html_e( 'Watch a Tutorial for this feature:', 'aiomatic-automatic-ai-content-writer' ); ?></p>
        <p><b><?php esc_html_e( 'Assign your AI Assistants to specific tasks within your site: in the relevant plugin settings section, replace the traditional AI model with one of your configured or imported assistants using the \'AI Assistant Name\' settings field.', 'aiomatic-automatic-ai-content-writer' ); ?></b></p>
        <iframe class="cr-youtube-video" src="https://www.youtube.com/embed/x2mkjdOZI9Y" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        <br/><br/>

        <h3 class="ai-section-title"><?php esc_html_e( 'AI Embeddings', 'aiomatic-automatic-ai-content-writer' ); ?></h3>
        <p><b><?php esc_html_e( 'Location:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<a href="<?php echo esc_url_raw( admin_url('admin.php?page=aiomatic_embeddings_panel') );?>" target="_blank"><?php esc_html_e( 'AI Embeddings', 'aiomatic-automatic-ai-content-writer' ); ?></a></p>
        <p><?php esc_html_e( 'Embeddings are essentially snippets of pre-processed data that help the AI understand the context or specific details about a subject without the need to train a completely new model. This method is highly efficient for providing the AI with the necessary background to accurately address complex queries about your company, products, or content.', 'aiomatic-automatic-ai-content-writer' ); ?></p>
        <p><b><?php esc_html_e( 'Setting Up AI Embeddings', 'aiomatic-automatic-ai-content-writer' ); ?></b></p>
        <p><?php esc_html_e( 'Step 1: Create Data for Embeddings - Quality Data Creation: Focus on developing precise questions and answers that provide clear, concise, and relevant context. Data Volume: Unlike full AI training, embeddings do not require vast amounts of data. Include just enough information to guide the AI accurately.', 'aiomatic-automatic-ai-content-writer' ); ?></p>
        <p><?php esc_html_e( 'Step 2: Auto Index Existing Posts - Automatically generate embeddings from existing content. Set the plugin to index posts, pages, products, or custom post types and create embeddings from this content. Template Customization: Adjust the auto-created embeddings template from the \'Embeddings\' tab under \'Settings\' menu, to fit the specific format you need for your data.', 'aiomatic-automatic-ai-content-writer' ); ?></p>
        <p><?php esc_html_e( 'Step 3: Manage Embeddings - Review and refine your embeddings: edit or delete embeddings as needed to keep the dataset current and effective.', 'aiomatic-automatic-ai-content-writer' ); ?></p>
        <p><b><?php esc_html_e( 'Watch a Tutorial for this feature:', 'aiomatic-automatic-ai-content-writer' ); ?></b></p>
        <iframe class="cr-youtube-video" src="https://www.youtube.com/embed/hkk0d7W0kIs" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            <br/><br/>

            <h3 class="ai-section-title"><?php esc_html_e( 'AI Model Training', 'aiomatic-automatic-ai-content-writer' ); ?></h3>
        <p><b><?php esc_html_e( 'Location:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<a href="<?php echo esc_url_raw( admin_url('admin.php?page=aiomatic_openai_training') );?>" target="_blank"><?php esc_html_e( 'AI Model Training', 'aiomatic-automatic-ai-content-writer' ); ?></a></p>
        <p><?php esc_html_e( 'Fine-tuning GPT-3 involves customizing a pre-trained AI model to enhance its understanding and output based on specific tasks or datasets. This feature within Aiomatic allows you to tailor the AI responses to closely align with your organizational needs, whether for creating a niche chatbot, generating targeted content, or providing precise customer support. Fine-tuning is the process of training a GPT-3 model on a tailored dataset to specialize its responses and functionalities. This method significantly improves the model\'s accuracy on specific topics by adjusting its parameters to reflect the nuances of the provided data.', 'aiomatic-automatic-ai-content-writer' ); ?></p>
        <p><b><?php esc_html_e( 'Setting Up AI Fine-Tuning', 'aiomatic-automatic-ai-content-writer' ); ?></b></p>
        <p><?php esc_html_e( 'Step 1: Create Your Dataset - Prepare your dataset, which is critical for the fine-tuning process:', 'aiomatic-automatic-ai-content-writer' ); ?></p>
        <ul>
            <li>
            <b><?php esc_html_e( 'Dataset Uploader (Step 1a):', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<?php esc_html_e( 'Directly upload your JSONL file if it\'s ready. Ensure it uses the prompt and completion format, with each line containing a pair. Upload Guidelines: Check your WordPress settings to accommodate the file size. Use tools like OpenAI\'s CLI Data Preparation Tool to format your data correctly.', 'aiomatic-automatic-ai-content-writer' ); ?>
            </li>
            <li>
            <b><?php esc_html_e( 'Manual Entry (Step 1b):', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<?php esc_html_e( 'Input data manually into the plugin or use tools to systematically gather and convert your content into a dataset.', 'aiomatic-automatic-ai-content-writer' ); ?>
            </li>
            <li>
            <b><?php esc_html_e( 'Dataset Converter (Step 1c):', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<?php esc_html_e( 'Automatically convert website content (posts, pages, products) into a structured dataset where titles are questions and content are answers.', 'aiomatic-automatic-ai-content-writer' ); ?>
            </li>
        </ul>
        <p><?php esc_html_e( 'Step 2: Initiate Model Training - Once your dataset is prepared and uploaded:', 'aiomatic-automatic-ai-content-writer' ); ?></p>
        <ul>
            <li>
            <b><?php esc_html_e( 'Start Training:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<?php esc_html_e( 'Navigate to the \'Datasets\' tab, select your dataset, and click \'Create Fine-Tune\'. Choose to fine-tune a new model or an existing one.', 'aiomatic-automatic-ai-content-writer' ); ?>
            </li>
            <li>
            <b><?php esc_html_e( 'Training Duration:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<?php esc_html_e( 'Training time can vary; a typical 500-row dataset might take about 20 minutes to process.', 'aiomatic-automatic-ai-content-writer' ); ?>
            </li>
        </ul>
        <p><?php esc_html_e( 'Step 3: Monitor and Deploy - After initiating the fine-tune:', 'aiomatic-automatic-ai-content-writer' ); ?></p>
        <ul>
            <li>
            <b><?php esc_html_e( 'Check Progress:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<?php esc_html_e( 'Monitor the status of your fine-tuning under the \'Model Finetunes\' tab. Ensure the model lists as \'succeeded\' before use.', 'aiomatic-automatic-ai-content-writer' ); ?>
            </li>
            <li>
            <b><?php esc_html_e( 'Deployment:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<?php esc_html_e( 'Once successful, the fine-tuned model will be available in the plugin\'s model selection dropdown.', 'aiomatic-automatic-ai-content-writer' ); ?>
            </li>
        </ul>
        <p><b><?php esc_html_e( 'Tips for Effective Fine-Tuning', 'aiomatic-automatic-ai-content-writer' ); ?></b></p>
        <ul>
            <li>
            <b><?php esc_html_e( 'Dataset Quality:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<?php esc_html_e( 'The quality and size of your dataset are paramount. More comprehensive and well-structured data leads to better model performance.', 'aiomatic-automatic-ai-content-writer' ); ?>
            </li>
            <li>
            <b><?php esc_html_e( 'Continuous Monitoring:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<?php esc_html_e( 'Regularly check the model\'s performance and make adjustments to the dataset as needed.', 'aiomatic-automatic-ai-content-writer' ); ?>
            </li>
            <li>
            <b><?php esc_html_e( 'Iterative Process:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<?php esc_html_e( 'Fine-tuning can be an iterative process. Initial results should be analyzed and used to refine the dataset and model parameters continually.', 'aiomatic-automatic-ai-content-writer' ); ?>
            </li>
        </ul>
        <p><b><?php esc_html_e( 'Watch a Tutorial for this feature:', 'aiomatic-automatic-ai-content-writer' ); ?></b></p>
        <iframe class="cr-youtube-video" src="https://www.youtube.com/embed/MV5F2X6z_X4" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            <br/><br/>

        <h3 class="ai-section-title"><?php esc_html_e( 'Limits and Statistics', 'aiomatic-automatic-ai-content-writer' ); ?></h3>
        <p><b><?php esc_html_e( 'Location:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<a href="<?php echo esc_url_raw( admin_url('admin.php?page=aiomatic_openai_status') );?>" target="_blank"><?php esc_html_e( 'Limits and Statistics menu', 'aiomatic-automatic-ai-content-writer' ); ?></a></p>
        <p><?php esc_html_e( 'The Aiomatic plugin includes comprehensive tools for managing and monitoring AI service usage. The \'Limits and Statistics\' feature provides detailed logs, graphs, and usage controls, enabling you to efficiently oversee operations within your WordPress site. Check features available in this section of the plugin:', 'aiomatic-automatic-ai-content-writer' ); ?></p>
        <ul>
            <li>
            <b><?php esc_html_e( 'Usage Logs:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<?php esc_html_e( 'This tab displays a detailed table with usage metrics for each AI request made through the plugin:', 'aiomatic-automatic-ai-content-writer' ); ?>
            <ul>
                <li>
                <?php esc_html_e( 'User: Who made the request.', 'aiomatic-automatic-ai-content-writer' ); ?>
                </li>
                <li>
                <?php esc_html_e( 'IP: The IP address from which the request originated.', 'aiomatic-automatic-ai-content-writer' ); ?>
                </li>
                <li>
                <?php esc_html_e( 'Source: Where the request was made (e.g., post editor, widget).', 'aiomatic-automatic-ai-content-writer' ); ?>
                </li>
                <li>
                <?php esc_html_e( 'Model: Which AI model was used.', 'aiomatic-automatic-ai-content-writer' ); ?>
                </li>
                <li>
                <?php esc_html_e( 'Mode: Operational mode (e.g., automatic, manual).', 'aiomatic-automatic-ai-content-writer' ); ?>
                </li>
                <li>
                <?php esc_html_e( 'Units: Number of units (tokens) used.', 'aiomatic-automatic-ai-content-writer' ); ?>
                </li>
                <li>
                <?php esc_html_e( 'Type: Type of units used (e.g., tokens).', 'aiomatic-automatic-ai-content-writer' ); ?>
                </li>
                <li>
                <?php esc_html_e( 'Price: Cost incurred for the request.', 'aiomatic-automatic-ai-content-writer' ); ?>
                </li>
                <li>
                <?php esc_html_e( 'Time: Timestamp of the request.', 'aiomatic-automatic-ai-content-writer' ); ?>
                </li>
                <li>
                <?php esc_html_e( 'Session ID: Identifier for the session during which the request was made.', 'aiomatic-automatic-ai-content-writer' ); ?>
                </li>
            </ul>
            </li>
            <li>
            <b><?php esc_html_e( 'Usage Graphs:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<?php esc_html_e( 'Visualize the plugin\'s usage through several types of graphs:', 'aiomatic-automatic-ai-content-writer' ); ?>
            <ul>
                <li>
                <?php esc_html_e( 'Call Count: Number of API calls made over time.', 'aiomatic-automatic-ai-content-writer' ); ?>
                </li>
                <li>
                <?php esc_html_e( 'Token Count: Number of tokens used over time.', 'aiomatic-automatic-ai-content-writer' ); ?>
                </li>
                <li>
                <?php esc_html_e( 'Usage Cost: Costs incurred over time.', 'aiomatic-automatic-ai-content-writer' ); ?>
                </li>
                <li>
                <?php esc_html_e( 'AI Image Count: Number of AI-generated images over time.', 'aiomatic-automatic-ai-content-writer' ); ?>
                </li>
            </ul>
            </li>
            <li>
            <b><?php esc_html_e( 'Usage Limits:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<?php esc_html_e( 'Set and manage usage limits to prevent abuse and manage costs:', 'aiomatic-automatic-ai-content-writer' ); ?>
            <ul>
                <li>
                <?php esc_html_e( 'Limit Types: Configure limits based on token usage, price, or call count.', 'aiomatic-automatic-ai-content-writer' ); ?>
                </li>
                <li>
                <?php esc_html_e( 'User-Specific Limits: Set different limits for logged-in users versus guests.', 'aiomatic-automatic-ai-content-writer' ); ?>
                </li>
                <li>
                <?php esc_html_e( 'Role-Based Limits: Apply distinct limits based on user roles, allowing more flexibility for administrators or other roles.', 'aiomatic-automatic-ai-content-writer' ); ?>
                </li>
                <li>
                <?php esc_html_e( 'Membership Integration: Utilize integration with the \'Ultimate Membership Pro\' plugin to set varying limits for different membership levels.', 'aiomatic-automatic-ai-content-writer' ); ?>
                </li>
            </ul>
            </li>
            <li>
            <b><?php esc_html_e( 'OpenAI Status:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<?php esc_html_e( 'Keep track of OpenAI\'s operational status and any incidents that might affect service availability: current status and health of the OpenAI API, also check incident reports, showing details of any ongoing or past issues that might have impacted service.', 'aiomatic-automatic-ai-content-writer' ); ?>
            </li>
        </ul>
        <p><b><?php esc_html_e( 'Watch a Tutorial for this feature:', 'aiomatic-automatic-ai-content-writer' ); ?></b></p>
        <iframe class="cr-youtube-video" src="https://www.youtube.com/embed/skwJz6yeqIg" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            <br/><br/>

            <h3 class="ai-section-title"><?php esc_html_e( 'Aiomatic Extensions', 'aiomatic-automatic-ai-content-writer' ); ?></h3>
        <p><b><?php esc_html_e( 'Location:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<a href="<?php echo esc_url_raw( admin_url('admin.php?page=aiomatic_extensions') );?>" target="_blank"><?php esc_html_e( 'Aiomatic Extensions menu', 'aiomatic-automatic-ai-content-writer' ); ?></a></p>
        <p><?php esc_html_e( 'Extend your Aiomatic plugin with extra features and functionality. Check additional available Extensions in this menu of the plugin. Some examples of extensions available for the plugin:', 'aiomatic-automatic-ai-content-writer' ); ?></p>
        <ul>
            <li>
            <b><?php esc_html_e( 'PDF Parsing:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<?php esc_html_e( 'PDF file parsing and storage using OmniBlocks', 'aiomatic-automatic-ai-content-writer' ); ?>
            </li>
            <li>
            <b><?php esc_html_e( 'Amazon S3 Storage For Images:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<?php esc_html_e( 'Store royalty-free or AI-generated images on Amazon S3', 'aiomatic-automatic-ai-content-writer' ); ?>
            </li>
            <li>
            <b><?php esc_html_e( 'Amazon API:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<?php esc_html_e( 'Use the official Amazon API instead of using web scraping, to get Amazon product details', 'aiomatic-automatic-ai-content-writer' ); ?>
            </li>
            <li>
            <b><?php esc_html_e( 'Amazon API:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<?php esc_html_e( 'Use the official Amazon API instead of using web scraping, to get Amazon product details', 'aiomatic-automatic-ai-content-writer' ); ?>
            </li>
            <li>
            <b><?php esc_html_e( 'Social Sharing:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<?php esc_html_e( 'Adds multiple chatbot extension & OmniBlock extensions for sharing on various social networks, like: Facebook, Twitter, Instagram, Pinterest, LinkedIn, Reddit, YouTube Community.', 'aiomatic-automatic-ai-content-writer' ); ?>
            </li>
        </ul>
        <p><b><?php esc_html_e( 'Watch a Tutorial for this feature:', 'aiomatic-automatic-ai-content-writer' ); ?></b></p>
        <iframe class="cr-youtube-video" src="https://www.youtube.com/embed/DIUZkvD4Y6U" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            <br/><br/>

        <h3 class="ai-section-title"><?php esc_html_e( 'Content Wizard', 'aiomatic-automatic-ai-content-writer' ); ?></h3>
        <p><b><?php esc_html_e( 'Location:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<a href="<?php echo esc_url_raw( admin_url('admin.php?page=aiomatic_admin_settings&skip_config=1#tab-16') );?>" target="_blank"><?php esc_html_e( 'Content Wizard Tab', 'aiomatic-automatic-ai-content-writer' ); ?></a></p>
        <p><?php esc_html_e( 'The Content Wizard acts as your personal content strategist, aiding in various aspects of content management:', 'aiomatic-automatic-ai-content-writer' ); ?></p>
        <ul>
            <li>
            <b><?php esc_html_e( 'AI-Powered Meta Tags:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<?php esc_html_e( 'Automatically generates meta tags for your posts, optimizing them for better SEO.', 'aiomatic-automatic-ai-content-writer' ); ?>
            </li>
            <li>
            <b><?php esc_html_e( 'Keyword Suggestions:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<?php esc_html_e( 'Provides keyword recommendations to improve search engine visibility.', 'aiomatic-automatic-ai-content-writer' ); ?>
            </li>
            <li>
            <b><?php esc_html_e( 'Content Optimization:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<?php esc_html_e( 'Offers insights and suggestions to enhance the quality and SEO of your text.', 'aiomatic-automatic-ai-content-writer' ); ?>
            </li>
        </ul>
        <p><?php esc_html_e( 'This tool is essential for anyone looking to improve their content\'s reach and impact efficiently.', 'aiomatic-automatic-ai-content-writer' ); ?></p>
        <p><b><?php esc_html_e( 'Watch a Tutorial for the Content Wizard:', 'aiomatic-automatic-ai-content-writer' ); ?></b></p>
        <iframe class="cr-youtube-video" src="https://www.youtube.com/embed/e5tPgqOB8ss" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            <br/><br/>

        <h3 class="ai-section-title"><?php esc_html_e( 'AI Media Library Extensions', 'aiomatic-automatic-ai-content-writer' ); ?></h3>
        <p><b><?php esc_html_e( 'Location:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<a href="<?php echo esc_url_raw( admin_url('upload.php?page=aiomatic-automatic-ai-content-writer') );?>" target="_blank"><?php esc_html_e( 'Media Library Extension', 'aiomatic-automatic-ai-content-writer' ); ?></a></p>
        <p><?php esc_html_e( 'Elevate your media library with AI-driven extensions to create AI generated images and also to add alt and SEO meta tags to existing images:', 'aiomatic-automatic-ai-content-writer' ); ?></p>
        <ul>
            <li>
            <?php esc_html_e( 'Create AI generated images and autoamtically add them to your Media Library', 'aiomatic-automatic-ai-content-writer' ); ?>
            </li>
            <li>
            <?php esc_html_e( 'Automatically generates alt text, captions, and descriptions for images, enhancing accessibility and SEO.', 'aiomatic-automatic-ai-content-writer' ); ?>
            </li>
            <li>
            <?php esc_html_e( 'Suggests relevant tags and keywords for your media files, ensuring they are discoverable and rank well in search engines.', 'aiomatic-automatic-ai-content-writer' ); ?>
            </li>
        </ul>
        <p><?php esc_html_e( 'These extensions save time and streamline the process of media optimization.', 'aiomatic-automatic-ai-content-writer' ); ?></p>
        <p><b><?php esc_html_e( 'Watch a Tutorial for this feature:', 'aiomatic-automatic-ai-content-writer' ); ?></b></p>
        <iframe class="cr-youtube-video" src="https://www.youtube.com/embed/wRY6ElVZawI" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        <br/><br/>

        <h3 class="ai-section-title"><?php esc_html_e( 'Comment Replier', 'aiomatic-automatic-ai-content-writer' ); ?></h3>
        <p><b><?php esc_html_e( 'Location:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<a href="<?php echo esc_url_raw( admin_url('admin.php?page=aiomatic_admin_settings&skip_config=1#tab-21') );?>" target="_blank"><?php esc_html_e( 'Comment Replier', 'aiomatic-automatic-ai-content-writer' ); ?></a></p>
        <p><?php esc_html_e( 'Interact with your audience effortlessly with the Comment Replier feature. This tool uses AI to:', 'aiomatic-automatic-ai-content-writer' ); ?></p>
        <ul>
            <li>
            <?php esc_html_e( 'Analyze Comments: Understands the context and sentiment of user comments.', 'aiomatic-automatic-ai-content-writer' ); ?>
            </li>
            <li>
            <?php esc_html_e( 'Suggest Responses: Provides intelligent reply suggestions to help maintain active and engaging conversations.', 'aiomatic-automatic-ai-content-writer' ); ?>
            </li>
        </ul>
        <p><?php esc_html_e( 'The Comment Replier is invaluable for keeping your community lively and responsive.', 'aiomatic-automatic-ai-content-writer' ); ?></p>
        <p><b><?php esc_html_e( 'Watch a Tutorial for this feature:', 'aiomatic-automatic-ai-content-writer' ); ?></b></p>
        <iframe class="cr-youtube-video" src="https://www.youtube.com/embed/VknKvIcKRuw" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                 <br/><br/>

        <h3 class="ai-section-title"><?php esc_html_e( 'AI Taxonomy Description Writer', 'aiomatic-automatic-ai-content-writer' ); ?></h3>
        <p><b><?php esc_html_e( 'Location:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<a href="<?php echo esc_url_raw( admin_url('admin.php?page=aiomatic_admin_settings&skip_config=1#tab-22') );?>" target="_blank"><?php esc_html_e( 'AI Taxonomy Description Writer', 'aiomatic-automatic-ai-content-writer' ); ?></a></p>
        <p><?php esc_html_e( 'Optimize your WordPress taxonomies (categories and tags) with AI-crafted descriptions that boost SEO:', 'aiomatic-automatic-ai-content-writer' ); ?></p>
        <ul>
            <li>
            <?php esc_html_e( 'Automated Descriptions: AI generates insightful and keyword-rich descriptions for each taxonomy to enhance search visibility.', 'aiomatic-automatic-ai-content-writer' ); ?>
            </li>
        </ul>
        <p><?php esc_html_e( 'This feature is crucial for anyone looking to improve their site\'s organizational SEO efforts.', 'aiomatic-automatic-ai-content-writer' ); ?></p>
        <p><b><?php esc_html_e( 'Watch a Tutorial for this feature:', 'aiomatic-automatic-ai-content-writer' ); ?></b></p>
        <iframe class="cr-youtube-video" src="https://www.youtube.com/embed/k5BFo9jcmcs" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        <br/><br/>

        <h3 class="ai-section-title"><?php esc_html_e( '[aicontent] Shortcode', 'aiomatic-automatic-ai-content-writer' ); ?></h3>
        <p><b><?php esc_html_e( 'Location:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<a href="<?php echo esc_url_raw( admin_url('admin.php?page=aiomatic_admin_settings&skip_config=1#tab-20') );?>" target="_blank"><?php esc_html_e( '[aicontent] Shortcode', 'aiomatic-automatic-ai-content-writer' ); ?></a></p>
        <p><?php esc_html_e( 'Integrate Aiomatic\'s capabilities across your WordPress plugins with the [aicontent] shortcode. This powerful shortcode:', 'aiomatic-automatic-ai-content-writer' ); ?></p>
        <ul>
            <li>
            <?php esc_html_e( 'Universal Integration: Works with any plugin, enabling AI-generated content for posts, pages, and custom post types created by other plugins.', 'aiomatic-automatic-ai-content-writer' ); ?>
            </li>
            <li>
            <?php esc_html_e( 'Dynamic Content Generation: Ensures that all content, whether scraped or manually entered, remains fresh and engaging.', 'aiomatic-automatic-ai-content-writer' ); ?>
            </li>
        </ul>
        <p><b><?php esc_html_e( 'Watch a Tutorial for this feature:', 'aiomatic-automatic-ai-content-writer' ); ?></b></p>
        <iframe class="cr-youtube-video" src="https://www.youtube.com/embed/z_mGPlBsQQA" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        <br/><br/>

        <h3 class="ai-section-title"><?php esc_html_e( 'Developer Tools Documentation', 'aiomatic-automatic-ai-content-writer' ); ?></h3>
        <p><b><?php esc_html_e( 'Location:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<a href="<?php echo esc_url_raw( 'https://coderevolution.ro/knowledge-base/faq/aiomatic-plugin-custom-filters-documentation/' );?>" target="_blank"><?php esc_html_e( 'Developer Tools Documentation', 'aiomatic-automatic-ai-content-writer' ); ?></a></p>
        <p><?php esc_html_e( 'Aiomatic allows developers to deeply customize AI interactions:', 'aiomatic-automatic-ai-content-writer' ); ?></p>
        <ul>
            <li>
            <?php esc_html_e( 'Custom Prompts and Responses: Modify the AI prompts and fine-tune the responses for specific needs, enhancing the customizability and relevance of the output.', 'aiomatic-automatic-ai-content-writer' ); ?>
            </li>
        </ul>
        <p><b><?php esc_html_e( 'Watch a Tutorial for this feature:', 'aiomatic-automatic-ai-content-writer' ); ?></b></p>
        <iframe class="cr-youtube-video" src="https://www.youtube.com/embed/lDJOnhSS_5o" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        <br/><br/>

        <h3 class="ai-section-title"><?php esc_html_e( '\'Ultimate Membership Pro\' Integration', 'aiomatic-automatic-ai-content-writer' ); ?></h3>
        <p><b><?php esc_html_e( 'Location:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<a href="<?php echo esc_url_raw( admin_url('admin.php?page=aiomatic_openai_status#tab-2') );?>" target="_blank"><?php esc_html_e( 'AI Usage Limits tab', 'aiomatic-automatic-ai-content-writer' ); ?></a></p>
        <p><?php esc_html_e( 'Enhance your membership site with Aiomatic\'s advanced features:', 'aiomatic-automatic-ai-content-writer' ); ?></p>
        <ul>
            <li>
            <?php esc_html_e( 'Exclusive AI Features: Restrict Aiomatic\'s functionalities to members based on their subscription levels, adding immense value to your membership packages.', 'aiomatic-automatic-ai-content-writer' ); ?>
            </li>
        </ul>
        <p><b><?php esc_html_e( 'Watch a Tutorial for this feature:', 'aiomatic-automatic-ai-content-writer' ); ?></b></p>
        <iframe class="cr-youtube-video" src="https://www.youtube.com/embed/Ej4fPlA91N4" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        <br/><br/>
        <form method="post">
            <?php $this->next_step_buttons(); ?>
        </form>
        <br/><br/>
        <?php
    }

public function setup_step_playground() {
        ?>
        <h1><?php esc_html_e( 'AI Playground', 'aiomatic-automatic-ai-content-writer' ); ?></h1>
        <p><?php esc_html_e( 'Welcome to the AI Playground, a feature-rich section of the Aiomatic plugin that leverages advanced AI technologies to enhance your digital experience. This tutorial will guide you through various functionalities available in the AI Playground, including text completion, text editing, image generation, chatbot interactions, speech-to-text conversion, and text moderation. Each feature is designed to assist in content generation, user interaction, and content management.', 'aiomatic-automatic-ai-content-writer' ); ?></p>
        
        <h3 class="ai-section-title"><?php esc_html_e( 'Available Features in AI Playground', 'aiomatic-automatic-ai-content-writer' ); ?></h3>
        <p><b><?php esc_html_e( 'Text Completion', 'aiomatic-automatic-ai-content-writer' ); ?></b></p>
        <p><b><?php esc_html_e( 'Location:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<a href="<?php echo esc_url_raw( admin_url('admin.php?page=aiomatic_playground_panel#tab-1'));?>" target="_blank"><?php esc_html_e( 'Text Completion', 'aiomatic-automatic-ai-content-writer' ); ?></a></p>
        <p><?php esc_html_e( 'This feature allows the AI to extend a piece of text provided by the user, which can be used to generate creative content, complete narratives, or finish sentences in a coherent and contextually appropriate manner.', 'aiomatic-automatic-ai-content-writer' ); ?></p>
        <p><b><?php esc_html_e( 'Use Case:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<?php esc_html_e( 'Ideal for brainstorming sessions, story development, or as an aid for writing assignments.', 'aiomatic-automatic-ai-content-writer' ); ?></p>
        
        <p><b><?php esc_html_e( 'Text Editing', 'aiomatic-automatic-ai-content-writer' ); ?></b></p>
        <p><b><?php esc_html_e( 'Location:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<a href="<?php echo esc_url_raw( admin_url('admin.php?page=aiomatic_playground_panel#tab-2'));?>" target="_blank"><?php esc_html_e( 'Text Editing', 'aiomatic-automatic-ai-content-writer' ); ?></a></p>
        <p><?php esc_html_e( 'Modify text according to specific instructions. You can reformulate the style, correct grammar, simplify explanations, or adjust the tone to suit different audiences.', 'aiomatic-automatic-ai-content-writer' ); ?></p>
        <p><b><?php esc_html_e( 'Use Case:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<?php esc_html_e( 'Perfect for refining articles, preparing formal or informal communications, and enhancing the readability of existing content.', 'aiomatic-automatic-ai-content-writer' ); ?></p>

        <p><b><?php esc_html_e( 'Image Generation Using DALL-E 2, DALL-E 3, Midjourney and Stable Diffusion', 'aiomatic-automatic-ai-content-writer' ); ?></b></p>
        <p><b><?php esc_html_e( 'Location:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<a href="<?php echo esc_url_raw( admin_url('admin.php?page=aiomatic_playground_panel#tab-3'));?>" target="_blank"><?php esc_html_e( 'Dall-E 2', 'aiomatic-automatic-ai-content-writer' ); ?></a>, <a href="<?php echo esc_url_raw( admin_url('admin.php?page=aiomatic_playground_panel#tab-8'));?>" target="_blank"><?php esc_html_e( 'Dall-E 3', 'aiomatic-automatic-ai-content-writer' ); ?></a>, <a href="<?php echo esc_url_raw( admin_url('admin.php?page=aiomatic_playground_panel#tab-4'));?>" target="_blank"><?php esc_html_e( 'Stable Diffusion', 'aiomatic-automatic-ai-content-writer' ); ?></a></p>
        <p><?php esc_html_e( 'Generate images from text prompts using state-of-the-art models like DALL-E 2, Midjourney and Stable Diffusion. Input a descriptive prompt, and the AI will create a corresponding image.', 'aiomatic-automatic-ai-content-writer' ); ?></p>
        <p><b><?php esc_html_e( 'Use Case:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<?php esc_html_e( 'Useful for artists, bloggers, and content creators who need original visuals to accompany text posts or to visualize concepts.', 'aiomatic-automatic-ai-content-writer' ); ?></p>

        <p><b><?php esc_html_e( 'Chatbot', 'aiomatic-automatic-ai-content-writer' ); ?></b></p>
        <p><b><?php esc_html_e( 'Location:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<a href="<?php echo esc_url_raw( admin_url('admin.php?page=aiomatic_playground_panel#tab-5'));?>" target="_blank"><?php esc_html_e( 'Chatbot', 'aiomatic-automatic-ai-content-writer' ); ?></a></p>
        <p><?php esc_html_e( 'You can also use the chatbot in the playground. Interact with an AI-powered chatbot that can answer questions, provide information, and engage in conversation. Set up the chatbot to handle FAQs, customer support, or casual interactions.', 'aiomatic-automatic-ai-content-writer' ); ?></p>
        <p><b><?php esc_html_e( 'Use Case:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<?php esc_html_e( 'Enhances user engagement on platforms such as customer service portals, informational sites, and interactive campaigns.', 'aiomatic-automatic-ai-content-writer' ); ?></p>

        <p><b><?php esc_html_e( 'Speech to Text Using the Whisper API', 'aiomatic-automatic-ai-content-writer' ); ?></b></p>
        <p><b><?php esc_html_e( 'Location:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<a href="<?php echo esc_url_raw( admin_url('admin.php?page=aiomatic_playground_panel#tab-6'));?>" target="_blank"><?php esc_html_e( 'Whisper Speech To Text', 'aiomatic-automatic-ai-content-writer' ); ?></a></p>
        <p><?php esc_html_e( 'Convert spoken language into written text with the Whisper API. Record audio and the AI will transcribe it accurately.', 'aiomatic-automatic-ai-content-writer' ); ?></p>
        <p><b><?php esc_html_e( 'Use Case:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<?php esc_html_e( 'Essential for journalists, researchers, and professionals who need to transcribe interviews, lectures, or meetings efficiently.', 'aiomatic-automatic-ai-content-writer' ); ?></p>

        <p><b><?php esc_html_e( 'Text Moderation', 'aiomatic-automatic-ai-content-writer' ); ?></b></p>
        <p><b><?php esc_html_e( 'Location:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<a href="<?php echo esc_url_raw( admin_url('admin.php?page=aiomatic_playground_panel#tab-7'));?>" target="_blank"><?php esc_html_e( 'Text Moderation', 'aiomatic-automatic-ai-content-writer' ); ?></a></p>
        <p><?php esc_html_e( 'Automate the moderation of user-generated content. Define criteria for acceptable content, and let the AI filter out spam, offensive language, or any content that doesn\'t meet your standards.', 'aiomatic-automatic-ai-content-writer' ); ?></p>
        <p><b><?php esc_html_e( 'Use Case:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<?php esc_html_e( 'Ideal for maintaining a healthy online community, moderating comments on blogs or forums, and ensuring content appropriateness.', 'aiomatic-automatic-ai-content-writer' ); ?></p>

        <p><b><?php esc_html_e( 'Plagiarism Checker', 'aiomatic-automatic-ai-content-writer' ); ?></b></p>
        <p><b><?php esc_html_e( 'Location:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<a href="<?php echo esc_url_raw( admin_url('admin.php?page=aiomatic_playground_panel#tab-9'));?>" target="_blank"><?php esc_html_e( 'Plagiarism Checker', 'aiomatic-automatic-ai-content-writer' ); ?></a></p>
        <p><?php esc_html_e( 'Check text for plagiarism, using the PlagiarismCheck API.', 'aiomatic-automatic-ai-content-writer' ); ?></p>

        <p><b><?php esc_html_e( 'AI Content Detector', 'aiomatic-automatic-ai-content-writer' ); ?></b></p>
        <p><b><?php esc_html_e( 'Location:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<a href="<?php echo esc_url_raw( admin_url('admin.php?page=aiomatic_playground_panel#tab-10'));?>" target="_blank"><?php esc_html_e( 'AI Content Checker', 'aiomatic-automatic-ai-content-writer' ); ?></a></p>
        <p><?php esc_html_e( 'Check texts and detect if are fully AI generated or if they contain chunks of AI generated content, using the PlagiarismCheck API.', 'aiomatic-automatic-ai-content-writer' ); ?></p>

        <form method="post"> 
            <?php $this->next_step_buttons(); ?>
        </form>
        <div class="cr_center"><?php esc_html_e( 'For more settings, check the plugin\'s ', 'aiomatic-automatic-ai-content-writer' ); echo '"<a href="' . esc_url_raw( admin_url('admin.php?page=aiomatic_playground_panel') ) . '" target="_blank">';esc_html_e( 'AI Playground', 'aiomatic-automatic-ai-content-writer' ); echo '</a>" tab.'; ?></div>
        <br/><br/>
        <?php
    }

    public function setup_step_basic_save() 
    {
        check_admin_referer( 'aiomatic_admin_settings' );
        $this->aiomatic_update_site_settings('activation');
        wp_redirect( esc_url_raw( $this->get_next_step_link() ) );
        exit;
    }
    public function setup_step_api_save() {
        check_admin_referer( 'aiomatic_admin_settings' );
        $this->aiomatic_update_site_settings('apikeys');
        wp_redirect( esc_url_raw( $this->get_next_step_link() ) );
        exit;
    }
    public function setup_step_content_save() {
        check_admin_referer( 'aiomatic_admin_settings' );
        $this->aiomatic_update_site_settings('content');
        wp_redirect( esc_url_raw( $this->get_next_step_link() ) );
        exit;
    }
    public function setup_step_forms_save() {
        check_admin_referer( 'aiomatic_admin_settings' );
        $this->aiomatic_update_site_settings('forms');
        wp_redirect( esc_url_raw( $this->get_next_step_link() ) );
        exit;
    }
    public function setup_step_playground_save() {
        check_admin_referer( 'aiomatic_admin_settings' );
        $this->aiomatic_update_site_settings('playground');
        wp_redirect( esc_url_raw( $this->get_next_step_link() ) );
        exit;
    }
    public function setup_step_more_save() {
        check_admin_referer( 'aiomatic_admin_settings' );
        $this->aiomatic_update_site_settings('more');
        wp_redirect( esc_url_raw( $this->get_next_step_link() ) );
        exit;
    }
    public function setup_step_chatbot_save() {
        check_admin_referer( 'aiomatic_admin_settings' );
        $this->aiomatic_update_site_settings('chatbot');
        wp_redirect( esc_url_raw( $this->get_next_step_link() ) );
        exit;
    }
    public function setup_step_editor_save() {
        check_admin_referer( 'aiomatic_admin_settings' );
        $this->aiomatic_update_site_settings('wizplug');
        wp_redirect( esc_url_raw( $this->get_next_step_link() ) );
        exit;
    }
    
    public function setup_step_chatbot() {
        ?>
        <h1><?php esc_html_e( 'AI Chatbot', 'aiomatic-automatic-ai-content-writer' ); ?></h1>
        <p><?php esc_html_e( 'Enhance your WordPress site\'s interactivity with a fully customizable AI-powered chatbot provided by the Aiomatic plugin. This tutorial will guide you through the setup process, allowing you to deploy a responsive chatbot that can engage visitors, answer inquiries, and offer personalized support.', 'aiomatic-automatic-ai-content-writer' ); ?></p>
        
        <hr/>
        <h3 class="ai-section-title"><?php esc_html_e( 'Step 1: Customize the Chatbot Behavior', 'aiomatic-automatic-ai-content-writer' ); ?></h3>
        <p><b><?php esc_html_e( 'Location:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<a href="<?php echo esc_url_raw( admin_url('admin.php?page=aiomatic_chatbot_panel'));?>" target="_blank"><?php esc_html_e( 'AI Chatbot Menu', 'aiomatic-automatic-ai-content-writer' ); ?></a></p>
        <p><?php esc_html_e( 'Begin by navigating to the "AI Chatbot" menu within the Aiomatic settings page. You\'ll find several tabs here dedicated to customizing your chatbot:', 'aiomatic-automatic-ai-content-writer' ); ?></p>
        <ul>
            <li><b><?php esc_html_e( 'Chatbot Customization Tab:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<?php esc_html_e( 'Set rules for how the chatbot responds to specific inputs from users.', 'aiomatic-automatic-ai-content-writer' ); ?></li>
            <li><b><?php esc_html_e( 'Chatbot Default Styling Tab:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<?php esc_html_e( 'Modify the visual style and appearance of the chatbot to match your site\'s aesthetics.', 'aiomatic-automatic-ai-content-writer' ); ?></li>
            <li><b><?php esc_html_e( 'Chatbot Settings Tab:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<?php esc_html_e( 'Further define the behavior and operational settings of the chatbot.', 'aiomatic-automatic-ai-content-writer' ); ?></li>
            <li><b><?php esc_html_e( 'Default API Parameters Tab:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<?php esc_html_e( 'Adjust the default settings that control the chatbot\'s interactions based on the chosen AI model.', 'aiomatic-automatic-ai-content-writer' ); ?></li>
        </ul>
        <h3 class="ai-section-title"><?php esc_html_e( 'Step 2: Add the Chatbot to Your Website', 'aiomatic-automatic-ai-content-writer' ); ?></h3>
        <p><b><?php esc_html_e( 'Location:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<a href="<?php echo esc_url_raw( admin_url('admin.php?page=aiomatic_chatbot_panel#tab-5'));?>" target="_blank"><?php esc_html_e( 'Chatbot Website Injection Tab', 'aiomatic-automatic-ai-content-writer' ); ?></a></p>
        <p><?php esc_html_e( 'Incorporate the chatbot into your site either globally or on specific posts and pages:', 'aiomatic-automatic-ai-content-writer' ); ?></p>
        <ul>
            <li><b><?php esc_html_e( 'Globally:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<?php esc_html_e( 'To add the chatbot across your entire site, including the backend for admin interactions, use the settings provided in the \'Chatbot Website Injection\' tab. Here, you can decide if the chatbot should appear on all pages or only specific areas of your site.', 'aiomatic-automatic-ai-content-writer' ); ?></li>
            <li><b><?php esc_html_e( 'Locally:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<?php esc_html_e( 'For adding the chatbot to specific pages, use the [aiomatic-chat-form] shortcode where you want the chatbot to appear. To customize the shortcode easily and make it exactly like you need it, you can use the ', 'aiomatic-automatic-ai-content-writer' ); ?>&nbsp;<a href="<?php echo esc_url_raw( admin_url('admin.php?page=aiomatic_chatbot_panel#tab-7'));?>" target="_blank"><?php esc_html_e( 'Custom Chatbot Builder', 'aiomatic-automatic-ai-content-writer' ); ?></a>.</li>
        </ul>
        <h3 class="ai-section-title"><?php esc_html_e( 'Step 3: Test the Chatbot', 'aiomatic-automatic-ai-content-writer' ); ?></h3>
        <p><?php esc_html_e( 'After deployment, start interacting with the chatbot:', 'aiomatic-automatic-ai-content-writer' ); ?></p>
        <ul>
            <li><?php esc_html_e( 'If the chatbot is added globally to your site, locate the chatbot icon or window.', 'aiomatic-automatic-ai-content-writer' ); ?></li>
            <li><?php esc_html_e( 'Type questions or phrases into the chat window.', 'aiomatic-automatic-ai-content-writer' ); ?></li>
            <li><?php esc_html_e( 'Observe the responses and make sure they align with the configurations you\'ve set up.', 'aiomatic-automatic-ai-content-writer' ); ?></li>
        </ul>
        <p><?php esc_html_e( 'Testing ensures that the chatbot is ready to effectively communicate with your visitors and provide them with valuable assistance. You can give the chatbot a basic test drive, below:', 'aiomatic-automatic-ai-content-writer' ); ?></p>
        <?php
        $preview_settings = array( 'live_preview' => 'yes', 'temperature' => '', 'top_p' => '', 'presence_penalty' => '', 'frequency_penalty' => '', 'model' => '', 'instant_response' => '', 'show_in_window' => 'off' );
        echo aiomatic_chat_shortcode($preview_settings);
        ?>
        <p><b><?php esc_html_e( 'Watch a Tutorial for the AI Chatbot:', 'aiomatic-automatic-ai-content-writer' ); ?></b></p>
        <iframe class="cr-youtube-video" src="https://www.youtube.com/embed/QCkNkCrFi-o" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        <br/><br/>

        <form method="post" class="form-table">
            <?php $this->next_step_buttons(); ?>
        </form>
        <div class="cr_center"><?php esc_html_e( 'For more settings, check the plugin\'s ', 'aiomatic-automatic-ai-content-writer' ); echo '"<a href="' . esc_url_raw( admin_url('admin.php?page=aiomatic_chatbot_panel') ) . '" target="_blank">';esc_html_e( 'AI Chatbot', 'aiomatic-automatic-ai-content-writer' ); echo '</a>" menu.'; ?></div>
        <br/><br/>
        <?php
    }
    public function setup_step_editor() {
        ?>
        <h1><?php esc_html_e( 'AI Content Editor', 'aiomatic-automatic-ai-content-writer' ); ?></h1>
        <p><?php esc_html_e( 'The AI Content Editor within the Aiomatic plugin is a robust tool designed to automatically refine and enhance your posts using advanced artificial intelligence. Whether updating newly published, drafted, or existing posts, this feature streamlines the editing process, improving content quality and engagement effortlessly.', 'aiomatic-automatic-ai-content-writer' ); ?></p>
        
        <hr/>
        <h3 class="ai-section-title"><?php esc_html_e( 'Editing Templates and Options', 'aiomatic-automatic-ai-content-writer' ); ?></h3>
        <p><b><?php esc_html_e( 'Location:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<a href="<?php echo esc_url_raw( admin_url('admin.php?page=aiomatic_spinner_panel#tab-1'));?>" target="_blank"><?php esc_html_e( 'Editing Templates and Options Tab', 'aiomatic-automatic-ai-content-writer' ); ?></a></p>
        <p><?php esc_html_e( 'Determine exactly how posts should be edited through various AI-enhanced features. These features can be automatically applied to newly published posts or to exiting posts from your website:', 'aiomatic-automatic-ai-content-writer' ); ?></p>
        <ul>
            <li><b><?php esc_html_e( 'AI Content Rewriting:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<?php esc_html_e( 'Toggle rewriting to refresh and improve article quality.', 'aiomatic-automatic-ai-content-writer' ); ?></li>
            <li><b><?php esc_html_e( 'Featured Image Creation/Editing:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<?php esc_html_e( 'Automatically assign or revise featured images using AI-driven visuals.', 'aiomatic-automatic-ai-content-writer' ); ?></li>
            <li><b><?php esc_html_e( 'Editing Of Images From The Post Content:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<?php esc_html_e( 'Automatically edit the images found in the post content, change them, making them unique.', 'aiomatic-automatic-ai-content-writer' ); ?></li>
            <li><b><?php esc_html_e( 'AI-Generated Content Addition:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<?php esc_html_e( 'Append or prepend AI-crafted content to enhance detail and richness.', 'aiomatic-automatic-ai-content-writer' ); ?></li>
            <li><b><?php esc_html_e( 'Internal Links:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<?php esc_html_e( 'Insert AI-selected internal links to boost SEO and user engagement.', 'aiomatic-automatic-ai-content-writer' ); ?></li>
            <li><b><?php esc_html_e( 'Auto Generate Post Categories/Tags:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<?php esc_html_e( 'Add relevant, AI generated categories and tags to your posts.', 'aiomatic-automatic-ai-content-writer' ); ?></li>
            <li><b><?php esc_html_e( 'AI-Generated Comments:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<?php esc_html_e( 'Add relevant, AI-created comments to foster community and discussion.', 'aiomatic-automatic-ai-content-writer' ); ?></li>
            <li><b><?php esc_html_e( 'SEO Meta Descriptions:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<?php esc_html_e( 'Automatically generate compelling SEO descriptions for posts.', 'aiomatic-automatic-ai-content-writer' ); ?></li>
            <li><b><?php esc_html_e( 'Add Text To Speech/Video To Posts:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<?php esc_html_e( 'Automatically generate text to speech/video based on the textual content of posts and add the multimedia content to your posts.', 'aiomatic-automatic-ai-content-writer' ); ?></li>
            <li><b><?php esc_html_e( 'Post Status Adjustment:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<?php esc_html_e( 'Change the post\'s status post-editing to reflect new updates or revisions.', 'aiomatic-automatic-ai-content-writer' ); ?></li>
        </ul>
        <h3 class="ai-section-title"><?php esc_html_e( 'Automatic Content Editing Settings', 'aiomatic-automatic-ai-content-writer' ); ?></h3>
        <p><b><?php esc_html_e( 'Location:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<a href="<?php echo esc_url_raw( admin_url('admin.php?page=aiomatic_spinner_panel#tab-3'));?>" target="_blank"><?php esc_html_e( 'Automatic Content Editing Settings Tab', 'aiomatic-automatic-ai-content-writer' ); ?></a></p>
        <p><?php esc_html_e( 'Configure the AI to automatically edit newly published posts based on specific conditions and preferences:', 'aiomatic-automatic-ai-content-writer' ); ?></p>
        <ul>
            <li><b><?php esc_html_e( 'When to Edit Posts:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<?php esc_html_e( 'Choose to auto-edit content upon publishing, drafting, or setting as pending.', 'aiomatic-automatic-ai-content-writer' ); ?></li>
            <li><b><?php esc_html_e( 'Post Types to Edit:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<?php esc_html_e( 'Select which types of content (e.g., posts, pages, custom post types) should be automatically refined.', 'aiomatic-automatic-ai-content-writer' ); ?></li>
            <li><b><?php esc_html_e( 'Editing Delay:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<?php esc_html_e( 'Set a time delay for edits to allow personal review before AI enhancements are applied.', 'aiomatic-automatic-ai-content-writer' ); ?></li>
            <li><b><?php esc_html_e( 'Exclusions:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<?php esc_html_e( 'Specify categories or tags to exclude from automatic editing.', 'aiomatic-automatic-ai-content-writer' ); ?></li>
        </ul>
        <h3 class="ai-section-title"><?php esc_html_e( 'Manual Content Editing Settings', 'aiomatic-automatic-ai-content-writer' ); ?></h3>
        <p><b><?php esc_html_e( 'Location:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<a href="<?php echo esc_url_raw( admin_url('admin.php?page=aiomatic_spinner_panel#tab-4'));?>" target="_blank"><?php esc_html_e( 'Manual Content Editing Settings Tab', 'aiomatic-automatic-ai-content-writer' ); ?></a></p>
        <p><?php esc_html_e( 'Manually set conditions for editing existing posts from your website, to fine-tune content long after initial publication:', 'aiomatic-automatic-ai-content-writer' ); ?></p>
        <ul>
            <li><b><?php esc_html_e( 'Filter Options:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<?php esc_html_e( 'Extensive filtering allows for precise control over which posts, pages, or custom types are edited.', 'aiomatic-automatic-ai-content-writer' ); ?></li>
            <li><b><?php esc_html_e( 'Editing Of Existin Posts On a Schedule:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<?php esc_html_e( 'You can also set up a process which will be automatically started at a schedule, which will automatically edit existing posts from your site.', 'aiomatic-automatic-ai-content-writer' ); ?></li>
        </ul>
        <p><b><?php esc_html_e( 'Watch a Tutorial for the AI Content Editor:', 'aiomatic-automatic-ai-content-writer' ); ?></b></p>
        <iframe class="cr-youtube-video" src="https://www.youtube.com/embed/WVccxtXQTcc" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        <br/><br/>
        
        <form method="post" class="form-table">
            <?php $this->next_step_buttons(); ?>
        </form>
        <div class="cr_center"><?php esc_html_e( 'For more settings, check the plugin\'s ', 'aiomatic-automatic-ai-content-writer' ); echo '"<a href="' . esc_url_raw( admin_url('admin.php?page=aiomatic_spinner_panel') ) . '" target="_blank">';esc_html_e( 'AI Content Editor', 'aiomatic-automatic-ai-content-writer' ); echo '</a>" menu.'; ?></div>
        <br/><br/>
        <?php
    }

    public function setup_step_ready() {
        ?>

        <div class="final-step">
            <h1><?php esc_html_e( 'Congratulations! You\'re All Set.', 'aiomatic-automatic-ai-content-writer' ); ?></h1>
        </div>
        <div>
            <p><b><?php esc_html_e( 'Aiomatic is now ready to work its magic!', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;
            <?php esc_html_e( 'You\'ve successfully configured the essential settings, learned the basics of the plugin\'s usage and your WordPress site is now empowered with cutting-edge AI capabilities. Here\'s what you can do next:', 'aiomatic-automatic-ai-content-writer' ); ?></p>
            <ul><li>
                <b><?php esc_html_e( 'Explore Aiomatic:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<?php esc_html_e( 'Discover the vast array of features Aiomatic offers, from AI-driven content creation to automated SEO enhancements.', 'aiomatic-automatic-ai-content-writer' ); ?>
            </li><li>
                <b><?php esc_html_e( 'Create Content:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<?php esc_html_e( 'Start generating engaging, relevant, and high-quality content for your site with just a few clicks.', 'aiomatic-automatic-ai-content-writer' ); ?>
            </li><li>
                <b><?php esc_html_e( 'Chat With The Chatbot:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<?php esc_html_e( 'Set up the chatbot on your site and use it as a virtual assistant to streamline your work.', 'aiomatic-automatic-ai-content-writer' ); ?>
            </li><li>
                <b><?php esc_html_e( 'Customize Settings:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<?php esc_html_e( 'Tailor Aiomatic further by adjusting the settings to perfectly match your content strategy.', 'aiomatic-automatic-ai-content-writer' ); ?>
            </li></ul>
            <h3><?php esc_html_e( 'What\'s Next?', 'aiomatic-automatic-ai-content-writer' ); ?></h3>
            <ul><li>
                <b><?php esc_html_e( 'Test Drive:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<?php esc_html_e( 'Feel free to experiment with different settings and features to see what works best for your needs.', 'aiomatic-automatic-ai-content-writer' ); ?>
            </li><li>
                <b><?php esc_html_e( 'Need Inspiration?', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<?php esc_html_e( 'Check out our tutorial videos for creative uses of Aiomatic, on', 'aiomatic-automatic-ai-content-writer' ); ?>&nbsp;<a href="https://www.youtube.com/@CodeRevolutionTV" target="_blank">CodeRevolutionTV @YouTube</a>
            </li><li>
                <b><?php esc_html_e( 'Dive Deeper:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<?php esc_html_e( 'Visit the Aiomatic Dashboard to fine-tune additional settings or explore advanced features.', 'aiomatic-automatic-ai-content-writer' ); ?>
            </li><li>
                <b><?php esc_html_e( 'Suggest New Features For The Plugin:', 'aiomatic-automatic-ai-content-writer' ); ?></b>&nbsp;<?php echo sprintf( wp_kses( __( "Visit the <a href=\"%s\" target=\"_blank\">Aiomatic's Update Ideas Boad</a> , where you will be able to vote for new features and also leave your own new feature ideas, to be implemented and added in new plugin updates.", 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), "https://trello.com/b/2yxVZapo/aiomatic-feature-ideas" ); ?>
            </li></ul>
            <h3><?php esc_html_e( 'Need Assistance?', 'aiomatic-automatic-ai-content-writer' ); ?></h3>
            <p>
            <?php echo sprintf( wp_kses( __( "Our <a href=\"%s\" target=\"_blank\">support system</a> is ready to help you with any questions or issues you might encounter. Don't hesitate to reach out!", 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), "https://coderevolution.ro/support" ); ?>
            </p>
            <h3><?php esc_html_e( 'Stay Updated!', 'aiomatic-automatic-ai-content-writer' ); ?></h3>
            <p>
            <?php esc_html_e( 'Keep your plugin updated to enjoy the latest features and improvements. Check the update log regularly for the latest updates.', 'aiomatic-automatic-ai-content-writer' ); ?>
            </p>
            <h3><?php esc_html_e( 'Thank You for Choosing Aiomatic!', 'aiomatic-automatic-ai-content-writer' ); ?></h3>
            <p>
            <?php esc_html_e( 'We are excited to see the incredible content you will create and the success it will bring to your site. Let\'s make your WordPress experience phenomenal!', 'aiomatic-automatic-ai-content-writer' ); ?>
            </p>
        </div>
        <div class="final-step">
            <div class="aiomatic-setup-next-steps">
                <div class="aiomatic-setup-next-steps-first">
                    <h2><?php esc_html_e( 'Next Steps', 'aiomatic-automatic-ai-content-writer' ); ?> &rarr;</h2>
                    <a class="button button-primary button-large"
                        href="<?php echo esc_url_raw( admin_url('admin.php?page=aiomatic_admin_settings&aiomatic_done_config=3') ); ?>">
                        <?php esc_html_e( 'Go to Aiomatic Dashboard!', 'aiomatic-automatic-ai-content-writer' );
                                ?>
                    </a>
                </div>
            </div>
        </div>
        <?php
    }
    function aiomatic_update_site_settings($where)
    {
        if($where == 'apikeys')
        {
            if(isset($_POST['aiomatic_nonce_rand']) && wp_verify_nonce( $_POST['aiomatic_nonce_rand'], 'openai-secret-nonce') && isset($_POST['aiomatic_Main_Settings']) && is_array($_POST['aiomatic_Main_Settings']))
            {
                $change_done = false;
                $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
                foreach($_POST['aiomatic_Main_Settings'] as $save_option => $save_value)
                {
                    $aiomatic_Main_Settings[$save_option] = $save_value;
                    $change_done = true;
                }
                if($change_done == true)
                {
                    update_option('aiomatic_Main_Settings', $aiomatic_Main_Settings);
                }
            }
        }
    }
}