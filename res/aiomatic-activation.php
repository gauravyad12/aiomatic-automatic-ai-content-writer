<?php
function aiomatic_admin_settings()
{
   $plugin = plugin_basename(__FILE__);
   $plugin_slug = explode('/', $plugin);
   $plugin_slug = $plugin_slug[0];
   $uoptions = array();
   $is_activated = aiomatic_is_activated($plugin_slug, $uoptions);
   if($is_activated === true)
   {
?>
   <div class="verification-container">
     <div class="help-section">
       <div class="help-icon">
         <span class="dashicons dashicons-editor-help"></span>
       </div>
       <div class="help-text">
         <?php
           echo sprintf( wp_kses( __( 'The plugin is registered correctly. You can revoke your license here.', 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url_raw( '//coderevolution.ro/knowledge-base/faq/how-do-i-find-my-items-purchase-code-for-plugin-license-activation/' ) );
         ?>
       </div>
     </div>
     <div class="input-section">
       <label><b><?php echo esc_html__("Revoke Your Purchase Code:", 'aiomatic-automatic-ai-content-writer');?></b></label>
       <input type="hidden" id="<?php echo esc_html($plugin_slug);?>_activation_nonce" value="<?php echo wp_create_nonce('activation-secret-nonce');?>">
       <button type="button" id="<?php echo esc_html($plugin_slug);?>_revoke_license" class="button button-primary modern-button" onclick="unsaved = false;"><?php echo esc_html__("Revoke License", 'aiomatic-automatic-ai-content-writer');?></button>
     </div>
   </div>
<?php
   }
   elseif($is_activated === 2)
   {
      ?>
         <div class="verification-container">
           <div class="help-section">
             <div class="help-icon">
               <span class="dashicons dashicons-editor-help"></span>
             </div>
             <div class="help-text">
               <?php
                 echo sprintf( wp_kses( __( 'The plugin is in DEMO Mode, no registration is required. You can freely test its functionality.', 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url_raw( '//coderevolution.ro/knowledge-base/faq/how-do-i-find-my-items-purchase-code-for-plugin-license-activation/' ) );
               ?>
             </div>
           </div>
         </div>
      <?php

   }
   elseif($is_activated === -1)
   {
      ?>
         <div class="verification-container">
           <div class="help-section">
             <div class="help-icon">
               <span class="dashicons dashicons-editor-help"></span>
             </div>
             <div class="help-text"><p class="cr_red"><?php echo esc_html__("You are using a PIRATED version of the plugin! Because of this, the main functionality of the plugin is not available. Please revoke your license and activate a genuine license for the Aiomatic plugin. Note that the only place where you can get a valid license for the plugin is found here (if you find the plugin for sale also on other websites, do not buy, they are selling pirated copies): ", 'aiomatic-automatic-ai-content-writer');?><a href="https://1.envato.market/aiomatic" target="_blank"><?php echo esc_html__("Aiomatic on CodeCanyon", 'aiomatic-automatic-ai-content-writer');?></a></p>
             </div>
           </div>
           <div class="input-section">
             <label><b><?php echo esc_html__("Revoke Your Purchase Code:", 'aiomatic-automatic-ai-content-writer');?></b></label>
             <input type="hidden" id="<?php echo esc_html($plugin_slug);?>_activation_nonce" value="<?php echo wp_create_nonce('activation-secret-nonce');?>">
             <button type="button" id="<?php echo esc_html($plugin_slug);?>_revoke_license" class="button button-primary modern-button" onclick="unsaved = false;"><?php echo esc_html__("Revoke License", 'aiomatic-automatic-ai-content-writer');?></button>
           </div>
         </div>
      <?php
   }
   else
   {
   ?>
<div class="verification-container">
  <div class="help-section">
    <div class="help-icon">
      <span class="dashicons dashicons-editor-help"></span>
    </div>
    <div class="help-text">
      <?php
        echo sprintf( wp_kses( __( 'Please input your Envato purchase code, to activate the plugin. To get your purchase code, please follow <a href="%s" target="_blank">this tutorial</a>.', 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url_raw( '//coderevolution.ro/knowledge-base/faq/how-do-i-find-my-items-purchase-code-for-plugin-license-activation/' ) );
      ?>
    </div>
  </div>
  <div class="input-section">
    <label for="<?php echo esc_html($plugin_slug);?>_register_code"><b><?php echo esc_html__("Register Your Envato Purchase Code To Activate The Plugin:", 'aiomatic-automatic-ai-content-writer');?></b></label>
    <input type="text" id="<?php echo esc_html($plugin_slug);?>_register_code" placeholder="<?php echo esc_html__("Envato Purchase Code", 'aiomatic-automatic-ai-content-writer');?>" class="input-text">
    <input type="hidden" id="<?php echo esc_html($plugin_slug);?>_activation_nonce" value="<?php echo wp_create_nonce('activation-secret-nonce');?>">
    <button type="button" id="<?php echo esc_html($plugin_slug);?>_register" class="button button-primary modern-button" onclick="unsaved = false;"><?php echo esc_html__("Register Purchase Code", 'aiomatic-automatic-ai-content-writer');?></button>
  </div>
</div>
<?php
   }
}
?>