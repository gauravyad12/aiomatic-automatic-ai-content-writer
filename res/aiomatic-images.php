<?php
function aiomatic_media_page()
{
   $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
   if (!isset($aiomatic_Main_Settings['app_id']) || trim($aiomatic_Main_Settings['app_id']) == '') 
   {
      ?>
<h1><?php echo esc_html__("You must add an OpenAI/AiomaticAPI API Key into the plugin's 'Settings' menu before you can use this feature!", 'aiomatic-automatic-ai-content-writer');?></h1>
<?php
return;
   }
?>
<div class="wp-header-end"></div>
<div class="wrap gs_popuptype_holder seo_pops">
<h2 class="cr_center"><?php echo esc_html__("Aiomatic Images", 'aiomatic-automatic-ai-content-writer');?></h2>
</div>
<div class="wrap">
    <nav class="nav-tab-wrapper">
        <a href="#aiomatic-image-tab-1" class="nav-tab aiomatic-nav-tab-active"><?php echo esc_html__("Aiomatic Images", 'aiomatic-automatic-ai-content-writer');?></a>
    </nav>
    <h2><?php echo esc_html__("AI Generated Images", 'aiomatic-automatic-ai-content-writer');?></h2>
    <div id="aiomatic-image-tab-1" class="aiomatic-image-tab-1 tab-content">
        <br/>
        <?php echo esc_html__("Loading editor...", 'aiomatic-automatic-ai-content-writer');?>
    </div>
    <hr/>
    <h2><?php echo esc_html__("Royalty Free Images", 'aiomatic-automatic-ai-content-writer');?></h2>
    <div id="aiomatic-image-tab-2" class="aiomatic-image-tab-2 tab-content">
        <br/>
        <?php echo esc_html__("Loading editor...", 'aiomatic-automatic-ai-content-writer');?>
    </div>
</div>
<?php
}
?>