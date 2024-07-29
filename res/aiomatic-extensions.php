<?php
   function aiomatic_extensions()
   {
   ?>
   <div class="wrap gs_popuptype_holder seo_pops">
   <h2 class="cr_center"><?php echo esc_html__("Aiomatic Extensions", 'aiomatic-automatic-ai-content-writer');?></h2>
   </div>
<div class="wp-header-end"></div><div class="aiomatic-top-message-new-extension">
	<?php echo esc_html_e('Extend your ', 'aiomatic-automatic-ai-content-writer');?> <strong>Aiomatic</strong><?php esc_html_e(' plugin with extra features and functionality. Check additional available ', 'aiomatic-automatic-ai-content-writer');?> <strong>Extensions</strong> <a href="https://coderevolution.ro/product-category/aiomatic/" target="_blank"><?php esc_html_e('here', 'aiomatic-automatic-ai-content-writer');?></a>
</div>
<div class="gs_popuptype_holder gs_display_table">
<?php
$exts = aiomatic_get_extensions();
foreach ($exts as $k => $v):?>
	<div class="aiomatic-magic-box-wrap<?php echo ($v['enabled']) ? '' : ' aiomatic-disabled-box';?>">
		<a href="<?php if($v['enabled']) {echo $v['link'];}else{echo $v['getlink'];}?>" <?php if(!$v['enabled'] || $k == 'new_extension'):
			echo ' target="_blank" ';
		endif;
		?>
		>
			<div class="aiomatic-magic-feature <?php echo $k;?> <?php echo $v['extra_class'];?>">
				<?php if (isset($v['pro']) && $v['pro'] === TRUE){ ?>
						<div class="aiomatic-adm-ribbon aiomatic-adm-ribbon-top-left"><span>PRO</span></div>
				<?php } ?>
				<div class="aiomatic-magic-box-icon"><img src="<?php echo $v['icon'];?>"></div>
				<div class="aiomatic-magic-box-title"><?php echo $v['label'];?></div>
				<div class="aiomatic-magic-box-desc"><?php echo $v['description'];?></div>
                <?php
                if($k != 'new_extension')
                {
                    if($v['enabled'])
                    {
                    ?>
                    <div class="aiomatic-magic-box-desc">>> <?php echo esc_html_e('SETUP', 'aiomatic-automatic-ai-content-writer');?> <<</div>
                    <?php
                    }
                    else
                    {
                    ?>
                    <div class="aiomatic-magic-box-desc">>> <?php echo esc_html_e('GET IT', 'aiomatic-automatic-ai-content-writer');?> <<</div>
                    <?php
                    }
                }
                ?>
			</div>
		</a>
	</div>
<?php endforeach;?>
</div>
<?php
}
?>