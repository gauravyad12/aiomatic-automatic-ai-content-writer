<?php
function aiomatic_single_panel()
{
	$aiomatic_language_names = array(
		esc_html__("English", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Spanish", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("French", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Italian", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Afrikaans", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Albanian", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Arabic", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Amharic", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Armenian", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Belarusian", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Bulgarian", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Catalan", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Chinese Simplified", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Croatian", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Czech", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Danish", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Dutch", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Estonian", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Filipino", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Finnish", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Galician", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("German", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Greek", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Hebrew", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Hindi", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Hungarian", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Icelandic", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Indonesian", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Irish", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Japanese", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Korean", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Latvian", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Lithuanian", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Norwegian", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Macedonian", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Malay", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Maltese", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Persian", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Polish", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Portuguese", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Romanian", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Russian", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Serbian", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Slovak", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Slovenian", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Swahili", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Swedish", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Thai", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Turkish", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Ukrainian", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Vietnamese", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Welsh", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Yiddish", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Tamil", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Azerbaijani", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Kannada", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Basque", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Bengali", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Latin", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Chinese Traditional", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Esperanto", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Georgian", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Telugu", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Gujarati", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Haitian Creole", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Urdu", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Burmese", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Bosnian", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Cebuano", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Chichewa", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Corsican", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Frisian", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Scottish Gaelic", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Hausa", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Hawaian", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Hmong", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Igbo", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Javanese", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Kazakh", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Khmer", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Kurdish", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Kyrgyz", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Lao", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Luxembourgish", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Malagasy", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Malayalam", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Maori", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Marathi", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Mongolian", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Nepali", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Pashto", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Punjabi", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Samoan", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Sesotho", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Shona", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Sindhi", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Sinhala", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Somali", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Sundanese", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Swahili", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Tajik", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Uzbek", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Xhosa", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Yoruba", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Zulu", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Assammese", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Aymara", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Bambara", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Bhojpuri", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Dhivehi", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Dogri", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Ewe", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Guarani", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Ilocano", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Kinyarwanda", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Konkani", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Krio", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Kurdish - Sorani", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Lingala", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Luganda", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Maithili", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Meiteilon", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Mizo", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Odia", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Oromo", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Quechua", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Sanskrit", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Sepedi", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Tatar", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Tigrinya", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Tsonga", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Turkmen", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Twi", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Uyghur", 'aiomatic-automatic-ai-content-writer')
	 );
	$all_models = aiomatic_get_all_models(true);
   $all_assistants = aiomatic_get_all_assistants(true);
	$language_names = array(
		esc_html__("English", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Spanish", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("French", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Italian", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Afrikaans", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Albanian", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Arabic", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Amharic", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Armenian", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Belarusian", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Bulgarian", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Catalan", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Chinese Simplified", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Croatian", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Czech", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Danish", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Dutch", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Estonian", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Filipino", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Finnish", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Galician", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("German", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Greek", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Hebrew", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Hindi", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Hungarian", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Icelandic", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Indonesian", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Irish", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Japanese", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Korean", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Latvian", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Lithuanian", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Norwegian", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Macedonian", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Malay", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Maltese", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Persian", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Polish", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Portuguese", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Romanian", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Russian", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Serbian", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Slovak", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Slovenian", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Swahili", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Swedish", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Thai", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Turkish", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Ukrainian", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Vietnamese", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Welsh", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Yiddish", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Tamil", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Azerbaijani", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Kannada", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Basque", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Bengali", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Latin", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Chinese Traditional", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Esperanto", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Georgian", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Telugu", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Gujarati", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Haitian Creole", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Urdu", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Burmese", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Bosnian", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Cebuano", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Chichewa", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Corsican", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Frisian", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Scottish Gaelic", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Hausa", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Hawaian", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Hmong", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Igbo", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Javanese", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Kazakh", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Khmer", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Kurdish", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Kyrgyz", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Lao", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Luxembourgish", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Malagasy", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Malayalam", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Maori", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Marathi", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Mongolian", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Nepali", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Pashto", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Punjabi", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Samoan", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Sesotho", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Shona", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Sindhi", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Sinhala", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Somali", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Sundanese", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Swahili", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Tajik", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Uzbek", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Xhosa", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Yoruba", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Zulu", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Assammese", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Aymara", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Bambara", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Bhojpuri", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Dhivehi", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Dogri", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Ewe", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Guarani", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Ilocano", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Kinyarwanda", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Konkani", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Krio", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Kurdish - Sorani", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Lingala", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Luganda", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Maithili", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Meiteilon", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Mizo", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Odia", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Oromo", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Quechua", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Sanskrit", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Sepedi", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Tatar", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Tigrinya", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Tsonga", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Turkmen", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Twi", 'aiomatic-automatic-ai-content-writer'),
		esc_html__("Uyghur", 'aiomatic-automatic-ai-content-writer')
	);
?>
<div id="aiomatic-dialog" class="hidden">
  <h3 class="aiomatic-middle"><?php echo esc_html__("Post created as draft. Choose what to do next:", 'aiomatic-automatic-ai-content-writer');?></h3>
  <p class="aiomatic-middle"><button id="aiomatic-success-button" adminurl="<?php echo admin_url('post.php?post=');?>" postid=""><?php echo esc_html__("Edit Created Post", 'aiomatic-automatic-ai-content-writer');?></button></p>
  <p class="aiomatic-middle"><button id="aiomatic-close-button" onclick="window.location='#';"><?php echo esc_html__("Continue Creating Posts With AI", 'aiomatic-automatic-ai-content-writer');?></button></p>
</div>


<div class="wrap gs_popuptype_holder seo_pops">
<h2 class="cr_center"><?php echo esc_html__("Single AI Post Creator", 'aiomatic-automatic-ai-content-writer');?></h2>
<nav class="nav-tab-wrapper">
	<a href="#tab-0" class="nav-tab"><?php echo esc_html__("Express Mode", 'aiomatic-automatic-ai-content-writer');?></a>
	<a href="#tab-1" class="nav-tab"><?php echo esc_html__("Advanced Mode", 'aiomatic-automatic-ai-content-writer');?></a>
</nav>
<div id="tab-0" class="tab-content">
<h1 class="wp-heading-inline">
<?php echo esc_html__("Express Mode", 'aiomatic-automatic-ai-content-writer'); ?></h1>
<hr class="wp-header-end">
<?php
$max_execution = ini_get('max_execution_time');
if($max_execution != 0 && $max_execution < 1000)
{
    ?>
    <div class="notice notice-error">
        <p class="cr_red">
            <?php echo sprintf( wp_kses( __( "Warning! Your PHP INI max_execution_time is less than 1000 seconds (%s). This means that the plugin's execution will be forcefully stopped by your server after this amount of seconds. Please increase it to ensure that the plugin functions properly. Please check details on server settings, <a href='%s' target='_blank'>here</a>.", 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_html($max_execution), esc_url_raw( get_admin_url() . 'admin.php?page=aiomatic_logs#tab-2' ) );?>
        </p>
    </div>
    <?php
}
?>
<form name="aiomatic-single-post" action="<?php echo (aiomatic_isSecure() ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";?>" method="post" id="aiomatic-single-post">
<div id="poststuff">
<div id="post-body" class="metabox-holder columns-2">
<div id="post-body-content">

<div id="titlediv">
<div id="titlewrap">
	<h2 class="top_heading"><?php echo esc_html__("Post Title", 'aiomatic-automatic-ai-content-writer'); ?></h2>
	<input type="text" name="post_title" size="30" value="" id="title" spellcheck="true" autocomplete="off" placeholder="Post title" onkeyup="aiomatic_title_empty();">
</div>
	<div class="inside">
			</div></div><!-- /titlediv -->

	<div id="gendiv">
<div id="genwrap">
<hr/>
<h2 class="top_heading"><?php echo esc_html__("Post Sections", 'aiomatic-automatic-ai-content-writer'); ?></h2>
<div class="aiomatic-minor-publishing-actions">
<?php echo esc_html__("Number of created sections:", 'aiomatic-automatic-ai-content-writer'); ?>&nbsp;
<select name="section_count" id="section_count" class="postform">
	<option value="1">1</option>
	<option value="2" selected>2</option>
	<option value="3">3</option>
	<option value="4">4</option>
	<option value="5">5</option>
	<option value="6">6</option>
	<option value="7">7</option>
	<option value="8">8</option>
	<option value="9">9</option>
	<option value="10">10</option>
	<option value="11">11</option>
	<option value="12">12</option>
	<option value="13">13</option>
	<option value="14">14</option>
	<option value="15">15</option>
	<option value="16">16</option>
	<option value="17">17</option>
	<option value="18">18</option>
	<option value="19">19</option>
	<option value="20">20</option>
</select>&nbsp;
<input type="button" name="generate_sections" id="generate_sections" class="button button-primary button-large" value="Generate Sections">
</div>
	<textarea rows="5" name="post_sections" size="30" value="" id="post_sections" spellcheck="true" autocomplete="off" placeholder="Post Sections" class="coderevolution_gutenberg_input"></textarea>
</div>
	<div class="inside">
		<div id="gen-slug-box" class="hide-if-no-js">
				</div>
			</div></div><!-- /gendiv -->
			<hr/>
			<h2 class="top_heading"><?php echo esc_html__("Post Content", 'aiomatic-automatic-ai-content-writer'); ?></h2>
			<div class="aiomatic-minor-publishing-actions">
<?php echo esc_html__("Number of paragraphs per section:", 'aiomatic-automatic-ai-content-writer'); ?>&nbsp;
<select name="paragraph_count" id="paragraph_count" class="postform">
	<option value="1">1</option>
	<option value="2">2</option>
	<option value="3" selected>3</option>
	<option value="4">4</option>
	<option value="5">5</option>
	<option value="6">6</option>
	<option value="7">7</option>
	<option value="8">8</option>
	<option value="9">9</option>
	<option value="10">10</option>
	<option value="11">11</option>
	<option value="12">12</option>
	<option value="13">13</option>
	<option value="14">14</option>
	<option value="15">15</option>
	<option value="16">16</option>
	<option value="17">17</option>
	<option value="18">18</option>
	<option value="19">19</option>
	<option value="20">20</option>
	<option value="21">21</option>
	<option value="22">22</option>
	<option value="23">23</option>
	<option value="24">24</option>
	<option value="25">25</option>
	<option value="26">26</option>
	<option value="27">27</option>
	<option value="28">28</option>
	<option value="29">29</option>
	<option value="30">30</option>
</select>&nbsp;
<input type="button" name="generate_paragraphs" id="generate_paragraphs" class="button button-primary button-large" value="Generate Content">
</div>
	<?php
          $settings = array(
            'textarea_name' => 'post_content',
            'media_buttons' => true,
            'quicktags' => true,
            'tabindex' => '4'
          );
          wp_editor( '', 'post_content', $settings );
		  wp_nonce_field( 'create_post', 'create_post_nonce' );
        ?>

<div id="excdiv">
<div id="excwrap">
<hr/>
<h2 class="top_heading"><?php echo esc_html__("Post Excerpt", 'aiomatic-automatic-ai-content-writer'); ?></h2>
<div class="aiomatic-minor-publishing-actions">
<input type="button" name="generate_excerpt" id="generate_excerpt" class="button button-primary button-large" value="Generate Excerpt">
</div>
	<textarea rows="5" name="post_excerpt" size="30" value="" id="post_excerpt" spellcheck="true" autocomplete="off" placeholder="Post Excerpt" class="coderevolution_gutenberg_input"></textarea>
</div>
	<div class="inside">
		<div id="exc-slug-box" class="hide-if-no-js">
				</div>
			</div></div><!-- /excdiv -->

<div id="postcustom" class="postbox">
<div class="postbox-header"><h2 class="top_heading"><?php echo esc_html__("Custom Fields", 'aiomatic-automatic-ai-content-writer');?></h2>
</div><div class="inside">
<div id="postcustomstuff">
<div id="ajax-response"></div>
<table id="list-table-added">
	<thead>
	<tr>
		<th class="left"><?php echo esc_html__("Name", 'aiomatic-automatic-ai-content-writer');?></th>
		<th><?php echo esc_html__("Value", 'aiomatic-automatic-ai-content-writer');?></th>
	</tr>
	</thead>
	<tbody >
   </tbody>
</table>

<table id="list-table" class="cr_none">
	<thead>
	<tr>
		<th class="left"><?php echo esc_html__("Name", 'aiomatic-automatic-ai-content-writer');?></th>
		<th><?php echo esc_html__("Value", 'aiomatic-automatic-ai-content-writer');?></th>
	</tr>
	</thead>
	<tbody>
	<tr><td></td></tr>
	</tbody>
</table><p><strong><?php echo esc_html__("Add New Custom Field:", 'aiomatic-automatic-ai-content-writer');?></strong></p>
<table id="newmeta">
<thead>
<tr>
<th class="left"><label for="metakeyselect"><?php echo esc_html__("Name", 'aiomatic-automatic-ai-content-writer');?></label></th>
<th><label for="metavalue"><?php echo esc_html__("Value", 'aiomatic-automatic-ai-content-writer');?></label></th>
</tr>
</thead>

<tbody>
<tr>
<td id="newmetaleft" class="left">
<input type="text" id="metakeyinput" name="metakeyinput" value="" aria-label="<?php echo esc_html__("New custom field name", 'aiomatic-automatic-ai-content-writer');?>">
</td>
<td><textarea id="metavalue" name="metavalue" rows="1" cols="25"></textarea></td>
</tr>
</tbody>
</table>
<div class="add-custom-field">
	<input type="button" name="addmeta" id="newmeta-submit" class="button" value="<?php echo esc_html__("Add Custom Field", 'aiomatic-automatic-ai-content-writer');?>" onclick="addAiCustomField();">&nbsp;
   <input type="button" name="addmeta" id="generate_custom" class="generate_custom button cr_right" value="<?php echo esc_html__("Generate AI Content", 'aiomatic-automatic-ai-content-writer');?>" onclick="addAiCustomFieldContent('');"></div>
	</div>
	</div>
</div>    <!-- /postcustom -->     

<div id="publishdiv">
<div id="publishwrap">
<hr/>
<div id="major-publishing-actions">
	<div class="coderevolution_gutenberg_input" id="publishing-action">
		<span class="spinner"></span>
					<input type="submit" name="publish" id="post_publish" class="coderevolution_gutenberg_input button button-primary button-large" value="Create Post" disabled>				</div>
					
	<div class="clear"></div>
</div>
</div>
	<div class="inside">
		<div id="publish-slug-box" class="hide-if-no-js">
				</div>
			</div></div><!-- /publishdiv -->

<br/><br/>
			<div id="templdiv">
<div id="templwrap">
<hr/>
<h2 class="top_heading"><div class="tool" data-tip="Save or load your templates for content creation. These templates will be stored and accessible only from your user account."><?php echo esc_html__("Express Content Templates", 'aiomatic-automatic-ai-content-writer'); ?>&nbsp;&#9072;</div></h2>
<div class="aiomatic-minor-publishing-actions">
<input type="button" name="save_template" id="save_template" onclick="aiomatic_save_template()" class="button button-primary button-large" value="Save New Template">&nbsp;
<input type="button" name="load_template" id="load_template" onclick="aiomatic_load_template()" class="button button-primary button-large" value="Load Selected Template">&nbsp;
<input type="button" name="delete_template" id="delete_template" onclick="aiomatic_delete_template()" class="button button-primary button-large" value="Delete Selected Template">&nbsp;
<input type="button" name="import_template" id="import_template" onclick="aiomatic_import_template()" class="button button-primary button-large" value="Import Templates From File">&nbsp;
<input type="button" name="export_template" id="export_template" onclick="aiomatic_export_template()" class="button button-primary button-large" value="Export Templates To File">&nbsp;
<input type="file" id="import_template_file" name="import_template_file" class="cr_none" accept=".json" />
</div>
	<select class="coderevolution_gutenberg_input" id="template_manager">
		<option value="Default Template"><?php echo esc_html__("Default Template", 'aiomatic-automatic-ai-content-writer');?></option>
<?php
$user_id = get_current_user_id(); 
if($user_id == 0)
{
	aiomatic_log_to_file('No user logged in, cannot find templates!');
}
else
{
	$key = 'aiomatic_templates'; 
	$single = true; 
	$aiomatic_templates = get_user_meta( $user_id, $key, $single );
	if(is_array($aiomatic_templates))
	{
		foreach($aiomatic_templates as $tn => $template_name)
		{
			echo '<option value="' . $tn . '">' . $tn . '</option>';
		}
	}
}
?>
	</select>
</div>
</div><!-- /templdiv -->			

<div id="tutordiv">
<div id="tutorwrap">
<hr/>
<h2 class="top_heading"><div><?php echo esc_html__("Tutorial Video:", 'aiomatic-automatic-ai-content-writer'); ?></div></h2>
<p class="cr_center"><div class="embedtool"><iframe src="https://www.youtube.com/embed/3W-UGm7pbsU" frameborder="0" allowfullscreen></iframe></div></p>
</div>
</div><!-- /tutordiv -->	

	</div><!-- /post-body-content -->

<div id="postbox-container-1" class="postbox-container">
<div id="side-sortables" class="meta-box-sortables ui-sortable">

<div class="postbox">
<div class="postbox-header"><h2 class="hndle ui-sortable-handle"><?php echo esc_html__("Topic", 'aiomatic-automatic-ai-content-writer');?></h2>
</div><div class="inside">
<div class="submitbox" id="submitpost">

<div id="minor-publishing">


<p class="aiomatic-middle"><?php echo esc_html__("To get started, you can enter a topic here and start generating the title & content!", 'aiomatic-automatic-ai-content-writer');?></p>
	<div class="aiomatic-minor-publishing-actions">
<textarea rows="5" id="aiomatic_topics" onkeyup="aiomatic_all_empty();" class="coderevolution_gutenberg_input" placeholder="The main topic of the content"></textarea>
					<div class="clear"></div>
					<p><input type="button" name="generate_title" id="generate_title" class="coderevolution_gutenberg_input button button-primary button-large" value="Generate Title"></p>
					<p><input type="button" name="generate_all" id="generate_all" class="coderevolution_gutenberg_input button button-primary button-large" value="Generate All"></p>
					<div class="clear"></div>
	</div>

	<div class="clear"></div>
</div>
</div>
	</div>
</div>

<div class="postbox">
<div class="postbox-header"><h2 class="hndle ui-sortable-handle"><div class="tool" data-tip="Set the general parameters for your generated content."><?php echo esc_html__("Post Options", 'aiomatic-automatic-ai-content-writer');?>&nbsp;&#9072;
                              </div></h2>
</div><div class="inside">
<div class="submitbox" id="otherpost">

<div id="other-publishing">


	<div class="aiomatic-minor-publishing-actions">
	<div class="cr-align-left">
	<div class="tool" data-tip="Set the post type."><?php echo esc_html__("Post Type", 'aiomatic-automatic-ai-content-writer');?>:&nbsp;&#9072;
                              </div>
							</div>
							<select id="submit_type" name="submit_type" class="coderevolution_gutenberg_input">
<?php
foreach ( get_post_types( '', 'names' ) as $post_type ) {
   if(strstr($post_type, 'aiomatic_'))
   {
      continue;
   }
   echo '<option value="' . esc_attr($post_type) . '"';
   echo '>' . esc_html($post_type) . '</option>';
}
?>
							</select> 
					<div class="clear"></div>
	<div class="cr-align-left">
	<div class="tool" data-tip="Set the post status."><?php echo esc_html__("Status", 'aiomatic-automatic-ai-content-writer');?>:&nbsp;&#9072;
                              </div>
							</div>
							<select id="submit_status" name="submit_status" class="coderevolution_gutenberg_input">
							<option value="draft" selected><?php echo esc_html__("Draft", 'aiomatic-automatic-ai-content-writer');?></option>
							<option value="pending"><?php echo esc_html__("Pending", 'aiomatic-automatic-ai-content-writer');?></option>
							<option value="publish"><?php echo esc_html__("Published", 'aiomatic-automatic-ai-content-writer');?></option>
							<option value="private"><?php echo esc_html__("Private", 'aiomatic-automatic-ai-content-writer');?></option>
							<option value="trash"><?php echo esc_html__("Trash", 'aiomatic-automatic-ai-content-writer');?></option>
							</select> 
					<div class="clear"></div>
					<div class="cr-align-left">
	<div class="tool" data-tip="Stick this post to the front page."><?php echo esc_html__("Sticky", 'aiomatic-automatic-ai-content-writer');?>:&nbsp;&#9072;
                              </div>
							</div>
							<select id="post_sticky" name="post_sticky" class="coderevolution_gutenberg_input">
							<option value="no"><?php echo esc_html__("No", 'aiomatic-automatic-ai-content-writer');?></option>
							<option value="yes"><?php echo esc_html__("Yes", 'aiomatic-automatic-ai-content-writer');?></option>
							</select> 
					<div class="clear"></div>
					<div class="cr-align-left">
	<div class="tool" data-tip="Set the post author."><?php echo esc_html__("Author", 'aiomatic-automatic-ai-content-writer');?>:&nbsp;&#9072;
                              </div>
							</div>
<?php
	$curruser = get_current_user_id();
    wp_dropdown_users(['class' => 'coderevolution_gutenberg_input', 'id' => 'post_author', 'name' => 'post_author', 'selected' => $curruser, 'role__in' => array('administrator', 'editor', 'author', 'contributor')]);
?>
					<div class="clear"></div>
					<div class="cr-align-left">
	<div class="tool" data-tip="Set the post publish date."><?php echo esc_html__("Publish Date", 'aiomatic-automatic-ai-content-writer');?>:&nbsp;&#9072;
                              </div>
							</div>
<?php
$date1x = new DateTime('now', aiomatic_get_blog_timezone());
?>
							<input type="datetime-local" id="post_date" name="post_date" value="<?php echo $date1x->format('Y-m-d H:i:s'); ?>" class="coderevolution_gutenberg_input" />
					<div class="clear"></div>
					<div class="cr-align-left">
	<div class="tool" data-tip="Set the post categories."><?php echo esc_html__("Post Categories", 'aiomatic-automatic-ai-content-writer');?>:&nbsp;&#9072;
                              </div>
							</div>
							<?php
$default_category = get_option('default_category');
$args = array(
	'orderby'          => 'name',
	'hide_empty'       => 0,
	'echo'             => 0,
	'class'            => 'coderevolution_gutenberg_input',
	'id'               => 'post_category',
	'name'             => 'post_category',
	'selected'         => $default_category
);
$select_cats = wp_dropdown_categories($args);
$select_cats = str_replace( "name='post_category'", "name='post_category[]' multiple='multiple'", $select_cats );
$select_cats = str_replace( 'name="post_category"', 'name="post_category[]" multiple="multiple"', $select_cats );
echo $select_cats;
?>
					<div class="clear"></div><div class="cr-align-left">
	<div class="tool" data-tip="Set the post tags."><?php echo esc_html__("Post Tags", 'aiomatic-automatic-ai-content-writer');?>:&nbsp;&#9072;
                              </div>
							</div>
							<input id="post_tags" name="post_tags" type="text" list="post_tags_list" class="coderevolution_gutenberg_input" value="" placeholder="Tag list"/>
							<datalist id="post_tags_list">
<?php
$xtags = get_tags(array(
  'hide_empty' => false
));
if(!is_wp_error($xtags))
{
	foreach ($xtags as $tag) {
		echo '<option>' . $tag->name . '</option>';
	}
}
?>
							</datalist>
<small class="cr-align-left coderevolution_gutenberg_input"><?php echo esc_html__("Separate tags with commas", 'aiomatic-automatic-ai-content-writer');?></small>
					<div class="clear"></div>
	</div>

	<div class="clear"></div>
</div>
</div>
	</div>
</div>

<div class="postbox">
<div class="postbox-header"><h2 class="hndle ui-sortable-handle"><?php echo esc_html__("Featured Image", 'aiomatic-automatic-ai-content-writer');?></h2>
</div><div class="inside">
<div class="submitbox" id="submitpost">

<div id="minor-publishing">
	<div class="aiomatic-minor-publishing-actions">
<?php
$image = '<div class="coderevolution_gutenberg_input"><img id="aiomatic-preview-image"/></div>';
echo $image; ?>
 <input type="hidden" name="aiomatic_image_id" id="aiomatic_image_id" value="" class="regular-text" />
 <input type='button' class="button-primary" value="<?php esc_attr_e( 'Select an image', 'aiomatic-automatic-ai-content-writer' ); ?>" id="aiomatic_media_manager"/>


	<div class="clear"></div>
	</div>

	<div class="clear"></div>
</div>
</div>
	</div>
</div>

<div class="postbox">
<div class="postbox-header"><h2 class="hndle ui-sortable-handle"><div class="tool" data-tip="Set the general parameters for your generated content."><?php echo esc_html__("Content Parameters", 'aiomatic-automatic-ai-content-writer');?>&nbsp;&#9072;
                              </div></h2>
</div><div class="inside">
<div class="submitbox" id="otherpost">

<div id="other-publishing">


	<div class="aiomatic-minor-publishing-actions">
	<div class="cr-align-left">
	<div class="tool" data-tip="Set the language of the created content."><?php echo esc_html__("Language", 'aiomatic-automatic-ai-content-writer');?>:&nbsp;&#9072;
                              </div>
							</div>
							<input id="language" name="language" type="text" list="languages" class="coderevolution_gutenberg_input" value="English" placeholder="Language"/>
							<datalist id="languages">
<?php
foreach($language_names as $ln)
{
	echo '<option>' . $ln . '</option>';
}
?>
							</datalist>
					<div class="clear"></div>
					<div class="cr-align-left">
	<div class="tool" data-tip="Set the writing style for the created content."><?php echo esc_html__("Writing Style", 'aiomatic-automatic-ai-content-writer');?>:&nbsp;&#9072;
                              </div>
							</div>
							<input id="writing_style" name="writing_style" type="text" list="writing_styles" class="coderevolution_gutenberg_input" value="Creative" placeholder="Style"/>
							<datalist id="writing_styles">
							<option>Informative</option>
							<option>Academic</option>
							<option>Descriptive</option>
							<option>Detailed</option>
							<option>Dramative</option>
							<option>Fiction</option>
							<option>Expository</option>
							<option>Historical</option>
							<option>Dialogue</option>
							<option>Creative</option>
							<option>Critical</option>
							<option>Narrative</option>
							<option>Persuasive</option>
							<option>Reflective</option>
							<option>Argumentative</option>
							<option>Analytical</option>
							<option>Blog</option>
							<option>News</option>
							<option>Casual</option>
							<option>Pastoral</option>
							<option>Personal</option>
							<option>Poetic</option>
							<option>Satirical</option>
							<option>Sensory</option>
							<option>Articulate</option>
							<option>Monologue</option>
							<option>Colloquial</option>
							<option>Comparative</option>
							<option>Concise</option>
							<option>Biographical</option>
							<option>Anecdotal</option>
							<option>Evaluative</option>
							<option>Letter</option>
							<option>Lyrical</option>
							<option>Simple</option>
							<option>Vivid</option>
							<option>Journalistic</option>
							<option>Technical</option>
							<option>Direct</option>
							<option>Emotional</option>
							<option>Metaphorical</option>
							<option>Objective</option>
							<option>Rhetorical</option>
							<option>Theoretical</option>
							<option>Business</option>
							<option>Report</option>
							<option>Research</option>
							</datalist>
					<div class="clear"></div>
					<div class="cr-align-left">
	<div class="tool" data-tip="Set the writing tone for the created content."><?php echo esc_html__("Writing Tone", 'aiomatic-automatic-ai-content-writer');?>:&nbsp;&#9072;
                              </div>
							</div>
							<input id="writing_tone" name="writing_tone" type="text" list="writing_tones" class="coderevolution_gutenberg_input" value="Neutral" placeholder="Tone"/>
							<datalist id="writing_tones">
							<option>Neutral</option>
							<option>Formal</option>
							<option>Assertive</option>
							<option>Cheerful</option>
							<option>Humorous</option>
							<option>Informal</option>
							<option>Inspirational</option>
							<option>Professional</option>
							<option>Emotional</option>
							<option>Persuasive</option>
							<option>Supportive</option>
							<option>Sarcastic</option>
							<option>Condescending</option>
							<option>Skeptical</option>
							<option>Narrative</option>
							<option>Journalistic</option>
							<option>Conversational</option>
							<option>Factual</option>
							<option>Friendly</option>
							<option>Polite</option>
							<option>Scientific</option>
							<option>Sensitive</option>
							<option>Sincere</option>
							<option>Curious</option>
							<option>Dissapointed</option>
							<option>Encouraging</option>
							<option>Optimistic</option>
							<option>Surprised</option>
							<option>Worried</option>
							<option>Confident</option>
							<option>Authoritative</option>
							<option>Nostalgic</option>
							<option>Sympathetic</option>
							<option>Suspenseful</option>
							<option>Romantic</option>
							<option>Serious</option>
							</datalist>
					<div class="clear"></div>
	</div>

	<div class="clear"></div>
</div>
</div>
	</div>
</div>

<div class="postbox">
<div class="postbox-header"><h2 class="hndle ui-sortable-handle"><div class="tool" data-tip="General settings which will change the text generator behaviour."><?php echo esc_html__("Model Settings", 'aiomatic-automatic-ai-content-writer');?>&nbsp;&#9072;

</div></h2><div class="paddings_cr"><input type="button" name="aiomatic_toggle_model" id="aiomatic_toggle_model" onclick="aiomatic_call_func()" class="button button-primary button-large" value="Show"></div>
</div><div id="model_holder" class="inside cr_display_none">
<div class="submitbox" id="otherpost">

<div id="other-publishing">


	<div class="aiomatic-minor-publishing-actions">
	<div class="cr-align-left">
	<div class="tool" data-tip="Higher values means the model will take more risks. Between 0 and 1."><?php echo esc_html__("Temperature", 'aiomatic-automatic-ai-content-writer');?>:&nbsp;&#9072;
                              </div>
							</div>
	<input type="number" min="0" max="2" step="0.1" name="temperature" id="temperature" class="coderevolution_gutenberg_input" value="1" placeholder="Temperature">
					<div class="clear"></div>
					<div class="cr-align-left">
	<div class="tool" data-tip="Higher values means the model will generate more content. Accepted ranges vary based on selected AI model max token count."><?php echo esc_html__("Max Tokens", 'aiomatic-automatic-ai-content-writer');?>:&nbsp;&#9072;
                              </div>
							</div>
	<input type="number" min="1" max="128000" step="1" name="max_tokens" id="max_tokens" class="coderevolution_gutenberg_input" value="4000" placeholder="Max Tokens">
   <div class="clear"></div>
					<div class="cr-align-left">
	<div class="tool" data-tip="Select the AI Assistant you wish to use for the content creator."><?php echo esc_html__("Model", 'aiomatic-automatic-ai-content-writer');?>:&nbsp;&#9072;
                              </div>
							</div>
							<select id="assistant_id_single" name="assistant_id_single" onchange="singleAssistantChanged();" class="coderevolution_gutenberg_input">
    <?php
if($all_assistants === false)
{
    echo '<option val="" selected disabled>' . esc_html__("Only OpenAI API is supported for Assistants API", 'aiomatic-automatic-ai-content-writer') . '</option>';
}
else
{
    if(count($all_assistants) == 0)
    {
        echo '<option val="" selected disabled>' . esc_html__("No Assistans added, go to the plugin's 'AI Assistans' menu to add new assistants!", 'aiomatic-automatic-ai-content-writer') . '</option>';
    }
    else
    {
        echo '<option value="" selected';
        echo '>' . esc_html__("Don't use assistants, use AI models instead", 'aiomatic-automatic-ai-content-writer') . '</option>';
        foreach($all_assistants as $myassistant)
        {
            echo '<option value="' . $myassistant->ID .'"';
            echo '>' . esc_html($myassistant->post_title);
            echo '</option>';
        }
    }
}
?>
    </select>
                  <div class="clear"></div>
					<div class="cr-align-left">
	<div class="tool" data-tip="Select the AI model you wish to use for the content creator."><?php echo esc_html__("Model", 'aiomatic-automatic-ai-content-writer');?>:&nbsp;&#9072;
                              </div>
							</div>
							<select id="model" name="model" class="disableAssistantsDynamic coderevolution_gutenberg_input">
<?php
foreach($all_models as $modelx)
{
   echo '<option value="' . $modelx .'"';
   echo '>' . esc_html($modelx) . esc_html(aiomatic_get_model_provider($modelx)) . '</option>';
}
?>
						</select>
					<div class="clear"></div>
	</div>

	<div class="clear"></div>
</div>
</div>
	</div>
</div>

<div class="postbox">
<div class="postbox-header"><h2 class="hndle ui-sortable-handle"><div class="tool" data-tip="Enter your prompts, based on which each part of the content will be edited."><?php echo esc_html__("Prompts", 'aiomatic-automatic-ai-content-writer');?>&nbsp;&#9072;
                              </div></h2><div class="paddings_cr"><input type="button" name="aiomatic_toggle_prompt" id="aiomatic_toggle_prompt" onclick="aiomatic_prompt_func()" class="button button-primary button-large" value="Show"></div>
</div><div id="prompt_holder" class="inside cr_display_none">
<div class="submitbox" id="submitpost">

<div id="prompt-publishing">


	<div class="aiomatic-minor-publishing-actions">
	<div class="cr-align-left">
	<div class="tool" data-tip="Prompt to be used for the Post Title. You can use the following shortcodes: %%topic%%, %%language%%, %%writing_style%%, %%writing_tone%%"><b><?php echo esc_html__("Title", 'aiomatic-automatic-ai-content-writer');?></b> <?php echo esc_html__("Prompt", 'aiomatic-automatic-ai-content-writer');?>:&nbsp;&#9072;
                              </div>
							</div>
<textarea rows="6" id="prompt_title" placeholder="The prompt to be used for the title generator" class="coderevolution_gutenberg_input">Write a title for an article about "%%topic%%" in %%language%%. Style: %%writing_style%%. Tone: %%writing_tone%%. Must be between 40 and 60 characters.</textarea>
					<div class="clear"></div>
	</div>

	<div class="aiomatic-minor-publishing-actions">
	<div class="cr-align-left">
	<div class="tool" data-tip="Prompt to be used for the Post Sections. You can use the following shortcodes: %%title%%, %%language%%, %%writing_style%%, %%writing_tone%%, %%sections_count%%"><b><?php echo esc_html__("Sections", 'aiomatic-automatic-ai-content-writer');?></b> <?php echo esc_html__("Prompt", 'aiomatic-automatic-ai-content-writer');?>:&nbsp;&#9072;
                              </div>
							</div>
<textarea rows="6" id="prompt_sections" placeholder="The prompt to be used for the sections generator" class="coderevolution_gutenberg_input">Write %%sections_count%% consecutive headings for an article about "%%title%%", in %%language%%. Style: %%writing_style%%. Tone: %%writing_tone%%.</textarea>
					<div class="clear"></div>
	</div>

	<div class="aiomatic-minor-publishing-actions">
	<div class="cr-align-left">
	<div class="tool" data-tip="Prompt to be used for the Post Content. You can use the following shortcodes: %%title%%, %%language%%, %%writing_style%%, %%writing_tone%%, %%sections%%, %%paragraphs_per_section%%"><b><?php echo esc_html__("Content", 'aiomatic-automatic-ai-content-writer');?></b> <?php echo esc_html__("Prompt", 'aiomatic-automatic-ai-content-writer');?>:&nbsp;&#9072;
                              </div>
							</div>
<textarea rows="6" id="prompt_content" placeholder="The prompt to be used for the content generator" class="coderevolution_gutenberg_input">Write an article about "%%title%%" in %%language%%. The article is organized by the following headings:

%%sections%%

Write %%paragraphs_per_section%% paragraphs per heading.

Use HTML for formatting, include h2 tags, h3 tags, lists and bold. When applicable, add also HTML tables with WordPress styling (you can use WordPress table classes). Table data must be relevant, creative, short and simple.

Add an introduction and a conclusion.

Style: %%writing_style%%. Tone: %%writing_tone%%.</textarea>
					<div class="clear"></div>
	</div>

	<div class="aiomatic-minor-publishing-actions">
	<div class="cr-align-left">
	<div class="tool" data-tip="Select if you want to run the above prompt for each section separately or only once for the entire content. Note that changing this settings will automatically change the value of the 'Content Prompt' settings field from above."><?php echo esc_html__("Run The Content Prompt Separately For Each Section", 'aiomatic-automatic-ai-content-writer');?>:&nbsp;&#9072;
                              </div>
							</div>
			<select id="content_gen_type" name="content_gen_type" onchange="content_gen_changed();" class="coderevolution_gutenberg_input">
			<option value="no"><?php echo esc_html__("No", 'aiomatic-automatic-ai-content-writer');?></option>
			<option value="yes"><?php echo esc_html__("Yes", 'aiomatic-automatic-ai-content-writer');?></option>
			</select> 
					<div class="clear"></div>
	</div>

	<div class="aiomatic-minor-publishing-actions">
	<div class="cr-align-left">
	<div class="tool" data-tip="Prompt to be used for the Post Excerpt. You can use the following shortcodes: %%title%%, %%language%%, %%writing_style%%, %%writing_tone%%, %%sections%%"><b><?php echo esc_html__("Excerpt", 'aiomatic-automatic-ai-content-writer');?></b> <?php echo esc_html__("Prompt", 'aiomatic-automatic-ai-content-writer');?>:&nbsp;&#9072;
                              </div>
							</div>
<textarea rows="6" id="prompt_excerpt" placeholder="The prompt to be used for the excerpt generator" class="coderevolution_gutenberg_input">Write an excerpt for an article about "%%title%%" in %%language%%. Style: %%writing_style%%. Tone: %%writing_tone%%. Must be between 150 and 250 characters.</textarea>
					<div class="clear"></div>
	</div>

<div class="aiomatic-minor-publishing-actions">
<div class="cr-align-left">
<div class="tool" data-tip="Prompt to be used for the Post Custom Fields. You can use the following shortcodes: %%meta_title%%, %%title%%, %%language%%, %%writing_style%%, %%writing_tone%%, %%sections%%"><b><?php echo esc_html__("Custom Fields", 'aiomatic-automatic-ai-content-writer');?></b> <?php echo esc_html__("Prompt", 'aiomatic-automatic-ai-content-writer');?>:&nbsp;&#9072;
                           </div>
                  </div>
<textarea rows="6" id="prompt_custom" placeholder="The prompt to be used for the custom field generator" class="coderevolution_gutenberg_input">Write the content of a WordPress custom field with title: "%%meta_title%%" in %%language%%. Style: %%writing_style%%. Tone: %%writing_tone%%. Must be between 150 and 250 characters.</textarea>
            <div class="clear"></div>
</div>

	<div class="clear"></div>
</div>
</div>
	</div>
</div>

</div></div>
</div><!-- /post-body -->
<br class="clear">
</div></form><!-- /poststuff -->
</div>

<div id="tab-1" class="tab-content">
<h1 class="wp-heading-inline">
<?php echo esc_html__("Advanced Mode", 'aiomatic-automatic-ai-content-writer'); ?></h1>
<hr class="wp-header-end">
<form name="aiomatic-single-post-advanced" action="<?php echo (aiomatic_isSecure() ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";?>" method="post" id="aiomatic-single-post-advanced">
<div id="poststuff">
<div id="post-body" class="metabox-holder columns-2">
<div id="post-body-content">

<div id="modediv">

<div id="postbox-container-2" class="postbox-container">
<div id="side-sortables-2" class="meta-box-sortables ui-sortable">
<div id="settingsbox" class="postbox">
<div class="postbox-header"><h2 class="hndle ui-sortable-handle"><?php echo esc_html__("Posting Options", 'aiomatic-automatic-ai-content-writer');?></h2>
</div>
<div class="inside">

<div id="modewrap">
	<h2 class="top_heading cr_align_middle"><b><?php echo esc_html__("Posting Mode", 'aiomatic-automatic-ai-content-writer'); ?></b>&nbsp;&nbsp;<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
      <div class="bws_hidden_help_text cr_min_260px">
         <?php
            echo esc_html__("Select the posting mode you want to use. This will be equivalent with the posting modes available in the plugins Bulk Post Creator menu.", 'aiomatic-automatic-ai-content-writer');
            ?>
      </div>
   </div></h2>
   <p class="aiomatic-margin10">
<select onchange="postingModeChanged();" name="posting_mode_changer_name" id="posting_mode_changer" class="aiomatic-important coderevolution_gutenberg_input">
	<option value="1a" selected><?php echo esc_html__("Topic Based Post (Multiple API Calls) - Enter Topic", 'aiomatic-automatic-ai-content-writer'); ?></option>
	<option value="1a-"><?php echo esc_html__("Topic Based Post (Multiple API Calls) - Enter Title", 'aiomatic-automatic-ai-content-writer'); ?></option>
	<option value="1b"><?php echo esc_html__("Title Based Post (Single API Calls)", 'aiomatic-automatic-ai-content-writer'); ?></option>
	<option value="6"><?php echo esc_html__("Listicle Post", 'aiomatic-automatic-ai-content-writer'); ?></option>
	<option value="2"><?php echo esc_html__("YouTube Video To Post", 'aiomatic-automatic-ai-content-writer'); ?></option>
	<option value="3"><?php echo esc_html__("Amazon Product Roundup", 'aiomatic-automatic-ai-content-writer'); ?></option>
	<option value="4"><?php echo esc_html__("Amazon Product Review", 'aiomatic-automatic-ai-content-writer'); ?></option>
	<option value="5"><?php echo esc_html__("CSV To Post", 'aiomatic-automatic-ai-content-writer'); ?></option>
</select>
</p>
	<div class="inside">
			</div></div><!-- /modediv -->
			
<div id="topicdiv">
<div id="topicwrap">
	<h2 class="top_heading cr_align_middle"><b><?php echo esc_html__("Post Topic List", 'aiomatic-automatic-ai-content-writer'); ?>*</b>&nbsp;&nbsp;<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
      <div class="bws_hidden_help_text cr_min_260px">
         <?php
            echo esc_html__("Be sure to edit the 'Title Prompt' settings from the advanced settings to change the way titles will be created! Enter a post topic list, one on each line. If you enter multiple topics (one per line), a random topic will be selected at each run. This will set the value of the %%topic%% shortcode, which can be used in prompts below. You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
            ?>
      </div>
   </div></h2>
   <p class="aiomatic-margin10">
	<textarea rows="5" id="aiomatic_topics_list" class="coderevolution_gutenberg_input" placeholder="The main topic of the content"></textarea>
</p>
</div>
	<div class="inside">
			</div></div><!-- /topicdiv -->

<div id="listiclediv">
<div id="topicwrap">
	<h2 class="top_heading cr_align_middle"><b><?php echo esc_html__("Listicle Topic List", 'aiomatic-automatic-ai-content-writer'); ?>*</b>&nbsp;&nbsp;<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
      <div class="bws_hidden_help_text cr_min_260px">
         <?php
            echo esc_html__("Be sure to edit the 'Title Prompt' settings from the advanced settings to change the way titles will be created! Enter a post topic list, one on each line. If you enter multiple topics (one per line), a random topic will be selected at each run. This will set the value of the %%topic%% shortcode, which can be used in prompts below. You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
            ?>
      </div>
   </div></h2>
   <p class="aiomatic-margin10">
	<textarea rows="5" id="aiomatic_listicle_list" class="coderevolution_gutenberg_input" placeholder="The main topic of the listicle"></textarea>
</p>
</div>
	<div class="inside">
			</div></div><!-- /listiclediv -->

<div id="inputtitlediv" class="cr_display_none">
<div id="inputtitlewrap">
	<h2 class="top_heading cr_align_middle"><b><?php echo esc_html__("Post Title List / TXT File URL / RSS Feed URL", 'aiomatic-automatic-ai-content-writer'); ?>*</b>&nbsp;&nbsp;<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
      <div class="bws_hidden_help_text cr_min_260px">
         <?php
            echo esc_html__("Input your desired post titles (one per line), a TXT file with titles (one per line) or a RSS feed URL. The plugin will select a random post title at each run. Nested spintax supported. You can also enter RSS feed URLs, from where the plugin will extract a random post title, each time it runs. If you set a RSS feed URL, an item will be randomly selected from the title/description/content of the RSS feed contents - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
            ?>
      </div>
   </div></h2>
   <p class="aiomatic-margin10">
	<textarea rows="5" id="aiomatic_titles" class="coderevolution_gutenberg_input" placeholder="Post title"></textarea>
</p>
</div>
	<div class="inside">
			</div></div><!-- /inputtitlediv -->

<div id="youtubediv" class="cr_display_none">
<div id="youtubewrap">
	<h2 class="top_heading cr_align_middle"><b><?php echo esc_html__("YouTube Video URLs", 'aiomatic-automatic-ai-content-writer'); ?>*</b>&nbsp;&nbsp;<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
      <div class="bws_hidden_help_text cr_min_260px">
         <?php
            echo esc_html__("Please provide the URLs to the YouTube videos (one per line). You can also enter a YouTube handle URL (channel or user), example: https://www.youtube.com/@CodeRevolutionTV/videos - if you have added a YouTube API key in the plugin's 'Settings' menu, this will list all recent videos from this specific YouTube channel. Otherwise, it will list videos which appear also on the featured page of the channel. Videos added here must be public and have captions available (uploaded or auto generated). In case auto generated captions are used, the quality of the created article might be lower. Nested Shortcodes also supported!", 'aiomatic-automatic-ai-content-writer');
            ?>
      </div>
   </div></h2>
   <p class="aiomatic-margin10">
	<textarea rows="5" id="aiomatic_youtube" class="coderevolution_gutenberg_input" placeholder="YouTube URL"></textarea>
</p>
</div>
	<div class="inside">
			</div></div><!-- /youtubediv -->

<div id="roundupdiv" class="cr_display_none">
<div id="roundupwrap">
	<h2 class="top_heading cr_align_middle"><b><?php echo esc_html__("Product Search Keywords / Product ASIN List", 'aiomatic-automatic-ai-content-writer'); ?>*</b>&nbsp;&nbsp;<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
      <div class="bws_hidden_help_text cr_min_260px">
         <?php
            echo esc_html__("Please provide the a search keyword for Amazon products to be included in the created article. Alternatively, you can provide a comma separated list of product ASINs (ex: B07RZ74VLR,B07RX6FBFR). To create multiple posts from the ASIN lists, add a new comma separated ASIN list to a new line.", 'aiomatic-automatic-ai-content-writer');
            ?>
      </div>
   </div></h2>
   <p class="aiomatic-margin10">
	<textarea rows="5" id="aiomatic_roundup" class="coderevolution_gutenberg_input" placeholder="Amazon product search term"></textarea>
</p>
</div>
	<div class="inside">
			</div></div><!-- /roundupdiv -->

<div id="reviewdiv" class="cr_display_none">
<div id="reviewwrap">
	<h2 class="top_heading cr_align_middle"><b><?php echo esc_html__("Single Product ASIN or Keyword", 'aiomatic-automatic-ai-content-writer'); ?>*</b>&nbsp;&nbsp;<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
      <div class="bws_hidden_help_text cr_min_260px">
         <?php
            echo esc_html__("Please provide a single ASIN of an Amazon product (ex: B07RZ74VLR). To create multiple product review posts, add a different ASIN, each on a new line.", 'aiomatic-automatic-ai-content-writer');
            ?>
      </div>
   </div></h2>
   <p class="aiomatic-margin10">
	<textarea rows="5" id="aiomatic_review" class="coderevolution_gutenberg_input" placeholder="Amazon product ASIN"></textarea>
</p>
</div>
	<div class="inside">
			</div></div><!-- /reviewdiv -->

<div id="csvdiv" class="cr_display_none">
<div id="csvwrap">
	<h2 class="top_heading cr_align_middle"><b><?php echo esc_html__("CSV File URLs List", 'aiomatic-automatic-ai-content-writer'); ?>*</b>&nbsp;&nbsp;<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
      <div class="bws_hidden_help_text cr_min_260px">
         <?php
            echo esc_html__("Add the URLs of the CSV files from where the plugin will get the details for publishing posts. Add each file URL on a new line.", 'aiomatic-automatic-ai-content-writer');
            ?>
      </div>
   </div></h2>
   <p class="aiomatic-margin10">
	<textarea rows="5" id="csv_title" name="csv_title" placeholder="CSV file URL" class="coderevolution_gutenberg_input"></textarea>
</p>
</div>
	<div class="inside">
			</div></div><!-- /csvdiv -->


<div id="advanceddiv">
<div id="advancedwrap">
	<h2 class="top_heading cr_align_middle"><b><?php echo esc_html__("More Options", 'aiomatic-automatic-ai-content-writer'); ?></b>&nbsp;&nbsp;<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
      <div class="bws_hidden_help_text cr_min_260px">
         <?php
            echo esc_html__("Shows advanced settings for this rule.", 'aiomatic-automatic-ai-content-writer');
            ?>
      </div>
   </div></h2>
	<p class="aiomatic-middle aiomatic-margin10"><button id="aiomatic-advanced-button" class="coderevolution_gutenberg_input button dbutton-large"><?php echo esc_html__("Settings", 'aiomatic-automatic-ai-content-writer');?></button></p>
</div>
	<div class="inside">
			</div></div><!-- /advanceddiv -->

         
<div id="generatediv">
<div id="generatewrap">
	<h2 class="top_heading cr_align_middle"><b><?php echo esc_html__("Start Processing", 'aiomatic-automatic-ai-content-writer'); ?></b>&nbsp;&nbsp;<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
      <div class="bws_hidden_help_text cr_min_260px">
         <?php
            echo esc_html__("Click this button to start processing and create the content and title of the post.", 'aiomatic-automatic-ai-content-writer');
            ?>
      </div>
   </div></h2>
	<p class="aiomatic-middle aiomatic-margin10"><button id="aiomatic-generate-button" class="coderevolution_gutenberg_input button button-primary button-large"><?php echo esc_html__("Generate Title And Content", 'aiomatic-automatic-ai-content-writer');?></button></p>
   <div id="aiomaticloader" class="aiomaticloader cr_hidden"></div>
</div>
	<div id="aiomatic-status-loader" class="inside cr_center">
			</div></div><!-- /generatediv -->




         <div id="mymodalfzr5" class="codemodalfzr">
               <div class="codemodalfzr-content">
                  <div class="codemodalfzr-header">
                     <span id="aiomatic_close5" class="codeclosefzr">&times;</span>
                     <h2><span class="cr_color_white"><?php echo esc_html__("CSV File", 'aiomatic-automatic-ai-content-writer');?></span> <?php echo esc_html__("Advanced Settings", 'aiomatic-automatic-ai-content-writer');?></h2>
                  </div>
                  <div class="codemodalfzr-body">
                     <div class="table-responsive">
                        <table class="responsive table cr_main_table_nowr">
                        <tr><td colspan="2">
                                 <h3><?php echo esc_html__("CSV File Options", 'aiomatic-automatic-ai-content-writer');?>:</h3>
                           </td></tr>
                           <tr>
                           <td>
                              <div>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Set the separator of the CSV file. It is usually auto detected, however, if you have issues with auto detection, you can set the CSV separator here.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("CSV File Separator (Optional):", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="text" id="csv_separator5" name="csv_separator" value="" placeholder="Optional, leave empty if not sure" class="valuesai5 cr_width_full">
                           </td>
                        </tr>
                           <tr><td colspan="2">
                                 <h3><?php echo esc_html__("Posting Options", 'aiomatic-automatic-ai-content-writer');?>:</h3>
                           </td></tr>
                           <tr>
                              <td>
                                    <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                       <div class="bws_hidden_help_text cr_min_260px">
                                          <?php
                                             echo esc_html__("The AI writer might add the title of the post to the created post content. Check this checkbox if you want to remove the title from the post content.", 'aiomatic-automatic-ai-content-writer');
                                             ?>
                                       </div>
                                    </div>
                                    <b><?php echo esc_html__("Strip Title From Content:", 'aiomatic-automatic-ai-content-writer');?></b>
                              </td>
                              <td>
                              <input type="checkbox" id="strip_title5" name="strip_title" class="valuesai5">
                              </td>
                           </tr>
                           <tr>
                              <td>
                                    <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                       <div class="bws_hidden_help_text cr_min_260px"><?php echo esc_html__("Do you want to skip spinning of posts generated by this rule?", 'aiomatic-automatic-ai-content-writer');?>
                                       </div>
                                    </div>
                                    <b><?php echo esc_html__("Do Not Spin Posts Generated By This Rule:", 'aiomatic-automatic-ai-content-writer');?></b>
                              </td>
                              <td>
                              <input type="checkbox" id="skip_spin5" name="skip_spin" class="valuesai5">               
                              </td>
                           </tr>
                           <tr>
                              <td>
                                    <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                       <div class="bws_hidden_help_text cr_min_260px"><?php echo esc_html__("Do you want to skip translating of posts generated by this rule?", 'aiomatic-automatic-ai-content-writer');?>
                                       </div>
                                    </div>
                                    <b><?php echo esc_html__("Do Not Translate Posts Generated By This Rule:", 'aiomatic-automatic-ai-content-writer');?></b>
                              </td>
                              <td>
                              <input type="checkbox" id="skip_translate5" name="skip_translate" class="valuesai5">               
                              </td>
                           </tr>
                           <tr>
                              <td>
                                    <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                       <div class="bws_hidden_help_text cr_min_260px">
                                          <?php
                                             echo esc_html__("Do you want to randomize CSV row processing order or do you want to process the lines in their order of appearence?", 'aiomatic-automatic-ai-content-writer');
                                             ?>
                                       </div>
                                    </div>
                                    <b><?php echo esc_html__("Randomize CSV Row Processing Order:", 'aiomatic-automatic-ai-content-writer');?></b>
                              </td>
                              <td>
                              <input type="checkbox" id="random_order5" name="random_order" class="valuesai5">
                              </td>
                           </tr>
                           <tr>
                              <td>
                                    <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                       <div class="bws_hidden_help_text cr_min_260px">
                                          <?php
                                             echo esc_html__("Run regex on post content. To disable this feature, leave this field blank. No Regex separators are required here. You can add multiple Regex expressions, each on a different line.", 'aiomatic-automatic-ai-content-writer');
                                             ?>
                                       </div>
                                    </div>
                                    <b><?php echo esc_html__("Run Regex On Content:", 'aiomatic-automatic-ai-content-writer');?></b>
                              </td>
                              <td>
                              <textarea rows="1" id="strip_by_regex5" name="strip_by_regex" placeholder="regex expression" class="valuesai5 cr_width_full"></textarea>
                              </td>
                           </tr>
                           <tr>
                              <td>
                                    <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                       <div class="bws_hidden_help_text cr_min_260px">
                                          <?php
                                             echo esc_html__("Replace the above regex matches with this regex expression. If you want to strip matched content, leave this field blank. No Regex separators are required here. You can add multiple replacement expressions, each on a different line.", 'aiomatic-automatic-ai-content-writer');
                                             ?>
                                       </div>
                                    </div>
                                    <b><?php echo esc_html__("Replace Matches From Regex (Content):", 'aiomatic-automatic-ai-content-writer');?></b>
                              </td>
                              <td>
                              <textarea rows="1" id="replace_regex5" name="replace_regex" placeholder="regex replacement" class="valuesai5 cr_width_full"></textarea>
                              </td>
                           </tr>
                        <tr><td colspan="2">
                                 <h3><?php echo esc_html__("Automatic Linking Options", 'aiomatic-automatic-ai-content-writer');?>:</h3>
                           </td></tr>
                           <tr>
                              <td>
                                    <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                       <div class="bws_hidden_help_text cr_min_260px">
                                          <?php
                                             echo esc_html__("Select the linking method to use in posts.", 'aiomatic-automatic-ai-content-writer');
                                             ?>
                                       </div>
                                    </div>
                                    <b><?php echo esc_html__("Automatic Linking Type:", 'aiomatic-automatic-ai-content-writer');?></b>
                              </td>
                              <td>
                              <select autocomplete="off" class="valuesai5 cr_width_full" id="link_type5" onchange="hideLinks('');" name="link_type">
                              <option value="disabled" selected><?php echo esc_html__("Disabled", 'aiomatic-automatic-ai-content-writer');?></option>
                              <option value="internal"><?php echo esc_html__("Internal Links", 'aiomatic-automatic-ai-content-writer');?></option>
                              <option value="manual"><?php echo esc_html__("Manual Links", 'aiomatic-automatic-ai-content-writer');?></option>
                              <option value="mixed"><?php echo esc_html__("Mixed Links", 'aiomatic-automatic-ai-content-writer');?></option>
                              </select>   
                              </td>
                           </tr>
                           <tr>
                              <td class="cr_min_width_200">
                                    <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                       <div class="bws_hidden_help_text cr_min_260px">
                                          <?php
                                             echo esc_html__("Set the maximum number of automatic links to add to created posts. You can also define custom ranges, like: 3-5. Please note that this feature will work best if you already have a considerable number of posts published on your site, which will be used for internal linking.", 'aiomatic-automatic-ai-content-writer');
                                             ?>
                                       </div>
                                    </div>
                                    <b><?php echo esc_html__("Maximum Number Of Automatic Links To Add To The Post Content:", 'aiomatic-automatic-ai-content-writer');?></b>
                              </td>
                              <td>
                              <input type="text" name="max_links" id="max_links5" placeholder="3-5" class="valuesai5 cr_width_full">
                              </td>
                           </tr>
                           <tr class="hidelinks">
                              <td class="cr_min_width_200">
                                    <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                       <div class="bws_hidden_help_text cr_min_260px">
                                          <?php
                                             echo esc_html__("Enter a manual list of links, where the plugin will create links.", 'aiomatic-automatic-ai-content-writer');
                                             ?>
                                       </div>
                                    </div>
                                    <b><?php echo esc_html__("Manual List Of URLs (One Per Line):", 'aiomatic-automatic-ai-content-writer');?></b>
                              </td>
                              <td>
                              <textarea rows="1" cols="70" name="link_list" id="link_list5" placeholder="URL list (one per line)" class="valuesai5 cr_width_full"></textarea>
                              </td>
                           </tr>
                           <tr class="hidelinks">
                              <td class="cr_min_width_200">
                                    <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                       <div class="bws_hidden_help_text cr_min_260px">
                                          <?php
                                             echo esc_html__("Do you want to add nofollow attribute to manually entered, external links?", 'aiomatic-automatic-ai-content-writer');
                                             ?>
                                       </div>
                                    </div>
                                    <b><?php echo esc_html__("Add Nofollow Attribute To Manual Links:", 'aiomatic-automatic-ai-content-writer');?></b>
                              </td>
                              <td>
                              <input type="checkbox" id="link_nofollow5" name="link_nofollow" class="valuesai5">
                              </td>
                           </tr>
                           <tr>
                              <td class="cr_min_width_200">
                                    <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                       <div class="bws_hidden_help_text cr_min_260px">
                                          <?php
                                             echo esc_html__("Set the post types where to create automatic links in posts. You can also add a comma separated list of multiple post types.", 'aiomatic-automatic-ai-content-writer');
                                             ?>
                                       </div>
                                    </div>
                                    <b><?php echo esc_html__("Post Types Where To Generate Automatic Links:", 'aiomatic-automatic-ai-content-writer');?></b>
                              </td>
                              <td>
                              <input type="text" name="link_post_types" id="link_post_types5" placeholder="post" class="valuesai5 cr_width_full">
                              </td>
                           </tr>
                        </table>
                     </div>
                  </div>
                  <div class="codemodalfzr-footer">
                     <br/>
                     <h3 class="cr_inline">Aiomatic Automatic Post Generator</h3>
                     <span id="aiomatic_ok5" class="codeokfzr cr_inline">OK&nbsp;</span>
                     <br/><br/>
                  </div>
               </div>
            </div>


            <div id="mymodalfzr6" class="codemodalfzr">
            <div class="codemodalfzr-content">
               <div class="codemodalfzr-header">
                  <span id="aiomatic_close6" class="codeclosefzr">&times;</span>
                  <h2><span class="cr_color_white"><?php echo esc_html__("Listicle Article", 'aiomatic-automatic-ai-content-writer');?></span> <?php echo esc_html__("Advanced Settings", 'aiomatic-automatic-ai-content-writer');?></h2>
               </div>
               <div class="codemodalfzr-body">
                  <div class="table-responsive">
                     <table class="responsive table cr_main_table_nowr">
                     <tr><td colspan="2">
                           <h3><?php echo esc_html__("AI Assistant Options", 'aiomatic-automatic-ai-content-writer');?>:</h3>
                     </td></tr>
                     <tr>
                        <td class="cr_min_width_200">
                              <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                 <div class="bws_hidden_help_text cr_min_260px">
                                    <?php
                                       echo esc_html__("Select the AI Assistant to use for content creation. This will disable the ability to select AI models, as the models assisgned to the assistant will be used for content creation.", 'aiomatic-automatic-ai-content-writer');
                                       ?>
                                 </div>
                              </div>
                              <b><?php echo esc_html__("AI Assistant Name:", 'aiomatic-automatic-ai-content-writer');?></b>
                        </td>
                        <td><select id="assistant_id6" name="assistant_id" class="valuesai6 cr_width_full" onchange="assistantSelected('6');">
<?php
if($all_assistants === false)
{
echo '<option val="" selected disabled>' . esc_html__("Only OpenAI API is supported for Assistants API", 'aiomatic-automatic-ai-content-writer') . '</option>';
}
else
{
if(count($all_assistants) == 0)
{
echo '<option val="" selected disabled>' . esc_html__("No Assistans added, go to the plugin's 'AI Assistans' menu to add new assistants!", 'aiomatic-automatic-ai-content-writer') . '</option>';
}
else
{
echo '<option value="" selected';
echo '>' . esc_html__("Don't use assistants, use AI models instead", 'aiomatic-automatic-ai-content-writer') . '</option>';
foreach($all_assistants as $myassistant)
{
echo '<option value="' . $myassistant->ID .'"';
echo '>' . esc_html($myassistant->post_title);
echo '</option>';
}
}
}
?>
</select>  
                        </td>
                     </tr>
                        <tr class="hidetopic"><td colspan="2">
                              <h3><?php echo esc_html__("Listicle Article Options", 'aiomatic-automatic-ai-content-writer');?>:</h3>
                        </td></tr>
                        <tr class="hidetopic">
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select the method to be used for the title generator.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Title Generator Method:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <select autocomplete="off" class="valuesai6 cr_width_full" id="title_generator_method6" name="title_generator_method">
                           <option value="ai" selected><?php echo esc_html__("AI Writer", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="serp"><?php echo esc_html__("Related SERP Searches", 'aiomatic-automatic-ai-content-writer');?></option>
                           </select>   
                           </td>
                        </tr>
                        <tr class="hidetopic">
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Enter a list of post sections, one per line. These will be headings of the content. These can also be automatically generated by the plugin. To enable auto generating of sections, leave this field blank. You can use here the %%topic%% shortcode, to get the value of the above topic, automtically. This will set the value of the %%sections%% shortcode, which can be used in prompts below. You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators. If you set a section list here, each created article will have this same list of sections, because of this, use shortcodes or Spintax when defining these static topics or leave this field blank for the plugin to auto generate them!", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Post Sections List (Optional):", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <textarea rows="2" cols="70" name="post_sections_list" id="post_sections_list6" placeholder="Post sections list (one per line)" class="valuesai6 cr_width_full"></textarea>
                           </td>
                        </tr>
                        <tr class="hidetopic">
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Enter the number of listicle entries to create in the article. These will also be set as article headings. You can also set value ranges, example: 5-7. In this case, a random number will be selected in this range. Please use only numeric values in this field. This field will set the value of the %%sections_count%% shortcode.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Number Of Listicle Entries To Generate:", 'aiomatic-automatic-ai-content-writer');?></b>   
                           </td>
                           <td class="cr_min_width_200">
                           <input type="text" id="section_count6" name="section_count" placeholder="3-4" class="valuesai6 cr_width_full" value="3-4">  
                           </td>
                        </tr>
                        <tr class="hidetopic">
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select what you want to do with listicle entries in articles.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Add Listicle Entries To Content As:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <select autocomplete="off" class="valuesai6 cr_width_full" id="sections_role6" name="sections_role">
                           <option value="h2" selected><?php echo esc_html__("h2", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="h3"><?php echo esc_html__("h3", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="b"><?php echo esc_html__("Bold", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="i"><?php echo esc_html__("Italic", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="bi"><?php echo esc_html__("Bold and Italic", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="p"><?php echo esc_html__("Paragraph", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="x"><?php echo esc_html__("Plain Text", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="no"><?php echo esc_html__("Don't Add Sections", 'aiomatic-automatic-ai-content-writer');?></option>
                           </select>   
                           </td>
                        </tr>
                        <tr class="hidetopic">
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Enter the number of paragraphs to create for each Listicle Entry. These will also be set as article headings. You can also set value ranges, example: 5-7. In this case, a random number will be selected in this range. Please use only numeric values in this field. This field will set the value of the %%paragraphs_per_section%% shortcode.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Number Of Paragraphs Per Listicle Entry:", 'aiomatic-automatic-ai-content-writer');?></b>   
                           </td>
                           <td class="cr_min_width_200">
                           <input type="text" id="paragraph_count6" name="paragraph_count" placeholder="2-3" class="valuesai6 cr_width_full" value="2">  
                           </td>
                        </tr>
                        <tr class="hidetopic">
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Set the number of related images to add to the created post content. This feature will use the royalty free image sources configured in the plugin's 'Settings' menu or if you have access to the DallE API. You can change image source in the 'AI Image Source' settings field from below. The maximum number of images you can add to each article: number of sections + 2", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Number of Images To Add To The Article:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="text" name="topic_images" id="topic_images6" value="" placeholder="Number of images" class="valuesai6 cr_width_full">
                           </td>
                        </tr>
                        <tr class="hidetopic">
                           <td>
                              <div>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select if you want to add an image to each of the creating headings from the article.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Add An Image To Each Heading Of The Article:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="checkbox" id="img_all_headings6" name="img_all_headings" class="valuesai6" checked>
                           </td>
                        </tr> 
                        <tr class="hidetopic">
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select the location of the heading images.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Heading Image Location:", 'aiomatic-automatic-ai-content-writer');?></b>   
                           </td>
                           <td class="cr_min_width_200">
                           <select autocomplete="off" id="heading_img_location6" name="heading_img_location" class="valuesai6 cr_width_full">
                              <option value="top" selected><?php echo esc_html__("Top of the section", 'aiomatic-automatic-ai-content-writer');?></option>
                              <option value="heading"><?php echo esc_html__("Under the heading text", 'aiomatic-automatic-ai-content-writer');?></option>
                              <option value="bottom"><?php echo esc_html__("Bottom of the section", 'aiomatic-automatic-ai-content-writer');?></option>
                              <option value="random"><?php echo esc_html__("Random", 'aiomatic-automatic-ai-content-writer');?></option>
                           </select>   
                           </td>
                        </tr>
                        <tr class="hidetopic">
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Set the number of related YouTube videos to add to the created post content. The maximum number of videos you can add to each article: number of sections", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Number of YouTube Videos To Add To The Article:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="number" min="0" name="topic_videos" id="topic_videos6" value="" placeholder="Number of videos" class="valuesai6 cr_width_full">
                           </td>
                        </tr>
                        <tr class="hidetopic">
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Set the text of the outro section header. This is optional.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Article Outro Section Header Text:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="text" name="title_outro" id="title_outro6" value="{In Conclusion|To Conclude|In Summary|To Wrap It Up|Key Takeaways|Future Outlook|Closing Remarks|The Conclusion|Final Thoughts|In Retrospect|The Way Forward|Wrapping Up|Concluding Remarks|Insights and Conclusions}" placeholder="Optional" class="valuesai6 cr_width_full">
                           </td>
                        </tr> 
                        <tr class="hidetopic">
                           <td class="hideTOC-1">
                              <div>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select if you want to add a Table of Contents section to the created post.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Add Article Table Of Contents:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td class="hideTOC-1">
                           <input type="checkbox" id="enable_toc6" name="enable_toc" class="valuesai6">
                           </td>
                        </tr> 
                        <tr class="hidetopic">
                           <td class="hideTOC-1">
                              <div>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Set the text of the Table of Contents section header. Default is: Table of Contents", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Article Table Of Contents Section Header Text:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td class="hideTOC-1">
                           <input type="text" name="title_toc" id="title_toc6" value="Table of Contents" placeholder="Table of Contents" class="valuesai6 cr_width_full">
                           </td>
                        </tr> 
                        <tr class="hidetopic">
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select if you want to add a Q&A section to the created post. To enable Q&A for articles, be sure to add a prompt also in the 'Article Q&A Prompt' settings field from below.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Add Article Q&A Section:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="checkbox" id="enable_qa6" name="enable_qa" class="valuesai6">
                           </td>
                        </tr> 
                        <tr class="hidetopic">
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Set the text of the Q&A section header. Default is: Q&A", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Article Q&A Section Header Text:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="text" id="title_qa6" name="title_qa" value="Q&A" placeholder="Q&A" class="valuesai6 cr_width_full">
                           </td>
                        </tr> 
                        <tr class="hidetopic"><td colspan="2">
                              <h4><?php echo esc_html__("Content Parameters", 'aiomatic-automatic-ai-content-writer');?>:</h4>
                        </td></tr>
                        <tr class="hidetopic">
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Set the language of the created content. This will set the value of the %%language%% shortcode, which can be used in prompts below. You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Content Language:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input id="content_language6" name="content_language" type="text" list="languages6" placeholder="Created content language" class="valuesai6 coderevolution_gutenberg_input" value="English"/>
<datalist id="languages6">
<?php
foreach($aiomatic_language_names as $ln)
{
echo '<option>' . $ln . '</option>';
}
?>
</datalist>
                           </td>
                        </tr>
                        <tr class="hidetopic">
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Set the writing style of the created content. This will set the value of the %%writing_style%% shortcode, which can be used in prompts below. You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Writing Style:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input id="writing_style6" name="writing_style" type="text" placeholder="Created content writing style" list="writing_styles6" class="valuesai6 coderevolution_gutenberg_input" value="Creative"/>
                           <datalist id="writing_styles6">
<option>Informative</option>
<option>Academic</option>
<option>Descriptive</option>
<option>Detailed</option>
<option>Dramative</option>
<option>Fiction</option>
<option>Expository</option>
<option>Historical</option>
<option>Dialogue</option>
<option>Creative</option>
<option>Critical</option>
<option>Narrative</option>
<option>Persuasive</option>
<option>Reflective</option>
<option>Argumentative</option>
<option>Analytical</option>
<option>Blog</option>
<option>News</option>
<option>Casual</option>
<option>Pastoral</option>
<option>Personal</option>
<option>Poetic</option>
<option>Satirical</option>
<option>Sensory</option>
<option>Articulate</option>
<option>Monologue</option>
<option>Colloquial</option>
<option>Comparative</option>
<option>Concise</option>
<option>Biographical</option>
<option>Anecdotal</option>
<option>Evaluative</option>
<option>Letter</option>
<option>Lyrical</option>
<option>Simple</option>
<option>Vivid</option>
<option>Journalistic</option>
<option>Technical</option>
<option>Direct</option>
<option>Emotional</option>
<option>Metaphorical</option>
<option>Objective</option>
<option>Rhetorical</option>
<option>Theoretical</option>
<option>Business</option>
<option>Report</option>
<option>Research</option>
</datalist>
                           </td>
                        </tr>
                        <tr class="hidetopic">
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Set the writing tone of the created content. This will set the value of the %%writing_tone%% shortcode, which can be used in prompts below. You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Writing Tone:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input id="writing_tone6" name="writing_tone" type="text" list="writing_tones6" placeholder="Created content writing tone" class="valuesai6 coderevolution_gutenberg_input" value="Neutral"/>
                           <datalist id="writing_tones6">
<option>Neutral</option>
<option>Formal</option>
<option>Assertive</option>
<option>Cheerful</option>
<option>Humorous</option>
<option>Informal</option>
<option>Inspirational</option>
<option>Professional</option>
<option>Emotional</option>
<option>Persuasive</option>
<option>Supportive</option>
<option>Sarcastic</option>
<option>Condescending</option>
<option>Skeptical</option>
<option>Narrative</option>
<option>Journalistic</option>
<option>Conversational</option>
<option>Factual</option>
<option>Friendly</option>
<option>Polite</option>
<option>Scientific</option>
<option>Sensitive</option>
<option>Sincere</option>
<option>Curious</option>
<option>Dissapointed</option>
<option>Encouraging</option>
<option>Optimistic</option>
<option>Surprised</option>
<option>Worried</option>
<option>Confident</option>
<option>Authoritative</option>
<option>Nostalgic</option>
<option>Sympathetic</option>
<option>Suspenseful</option>
<option>Romantic</option>
<option>Serious</option>
</datalist>
                           </td>
                        </tr>
                        <tr class="hidetopic"><td colspan="2">
                              <h4><?php echo esc_html__("Prompts", 'aiomatic-automatic-ai-content-writer');?>:</h4>
                        </td></tr>
                        <tr class="hidetopic">
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Prompt to be used for the Post Title. You can use the following shortcodes: %%topic%%, %%language%%, %%writing_style%%, %%writing_tone%%, %%title%%, %%random_sentence%%, %%random_sentence2%%, %%post_original_title%%, %%blog_title%% - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators. You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Title Prompt:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <textarea rows="2" cols="70" name="title_prompt" id="title_prompt6" placeholder="Enter your title prompts, one per line" class="valuesai6 cr_width_full">Write a title for a listicle about "%%topic%%" in %%language%%. The listicle will include %%sections_count%% items. Style: %%writing_style%%. Tone: %%writing_tone%%. Include a specific number in the title to indicate a list. Must be between 40 and 60 characters.</textarea>
                           </td>
                        </tr>
                        <tr class="hidetopic">
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select the AI Model to be used for the title generator.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("AI Model For Title Generator:", 'aiomatic-automatic-ai-content-writer');?></b>   
                           </td>
                           <td class="cr_min_width_200">
                           <select autocomplete="off" id="topic_title_model6" name="topic_title_model" class="hideAssistant6 valuesai6 cr_width_full">
                           <?php
foreach($all_models as $modelx)
{
echo '<option value="' . $modelx .'"';
echo '>' . esc_html($modelx) . esc_html(aiomatic_get_model_provider($modelx)) . '</option>';
}
?>
                           </select>   
                           </td>
                        </tr>
                        <tr class="hidetopic">
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Prompt to be used for the intro of the article. You can use the following shortcodes: %%title%%, %%topic%%, %%language%%, %%writing_style%%, %%writing_tone%%, %%sections_count%%, %%random_sentence%%, %%random_sentence2%%, %%post_original_title%%, %%blog_title%% - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Article Intro Prompt:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <textarea rows="2" cols="70" name="intro_prompt" id="intro_prompt6" placeholder="Enter your intro prompts, one per line" class="valuesai6 cr_width_full">Craft an introduction for a listicle about "%%title%%", in %%language%%. Style: %%writing_style%%. Tone: %%writing_tone%%. Highlight the number of items in the list and what the reader can expect to learn or gain from the listicle.</textarea>
                           </td>
                        </tr>
                        <tr class="hidetopic">
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select the AI Model to be used for the intro generator.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("AI Model For Intro Generator:", 'aiomatic-automatic-ai-content-writer');?></b>   
                           </td>
                           <td class="cr_min_width_200">
                           <select autocomplete="off" id="topic_intro_model6" name="topic_intro_model" class="hideAssistant6 valuesai6 cr_width_full">
                           <?php
foreach($all_models as $modelx)
{
echo '<option value="' . $modelx .'"';
echo '>' . esc_html($modelx) . esc_html(aiomatic_get_model_provider($modelx)) . '</option>';
}
?>
                           </select>   
                           </td>
                        </tr>
                        <tr class="hidetopic">
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Prompt to be used for the Listicle Entries. These will be set also as headings in the article. You can use the following shortcodes: %%title%%, %%topic%%, %%language%%, %%writing_style%%, %%writing_tone%%, %%sections_count%%, %%random_sentence%%, %%random_sentence2%%, %%post_original_title%%, %%blog_title%% - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Listicle Entries Prompt:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <textarea rows="2" cols="70" name="sections_prompt" id="sections_prompt6" placeholder="Enter your sections prompts, one per line" class="valuesai6 cr_width_full">Write %%sections_count%% consecutive entries for a listicle about "%%title%%". The entries must be written in %%language%%, following a %%writing_style%% style and a %%writing_tone%% tone. Don't use HTML in your response, write only plain text entries, one on each line, as I will use these entries to further create content for each of them. Return only the entries, nothing else.</textarea>
                           </td>
                        </tr>
                        <tr class="hidetopic">
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select the AI Model to be used for the Listicle Entries generator.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("AI Model For Listicle Entries Generator:", 'aiomatic-automatic-ai-content-writer');?></b>   
                           </td>
                           <td class="cr_min_width_200">
                           <select autocomplete="off" id="topic_sections_model6" name="topic_sections_model" class="hideAssistant6 valuesai6 cr_width_full">
                           <?php
foreach($all_models as $modelx)
{
echo '<option value="' . $modelx .'"';
echo '>' . esc_html($modelx) . esc_html(aiomatic_get_model_provider($modelx)) . '</option>';
}
?>
                           </select>   
                           </td>
                        </tr>
                        <tr class="hidetopic">
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Prompt to be used for the Content of the article, which will be applied to each section heading generated by the plugin (or entered manually) or to the entire content (depending how you select using the 'Use the Above Content Prompt To Create The Entire Article' checkbox). You can use the following shortcodes: %%title%%, %%topic%%, %%language%%, %%writing_style%%, %%writing_tone%%, %%sections%%, %%current_section%%, %%paragraphs_per_section%%, %%random_sentence%%, %%random_sentence2%%, %%post_original_title%%, %%blog_title%% - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Listicle Entries Content Prompt:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <textarea rows="3" cols="70" name="content_prompt" id="content_prompt6" placeholder="Enter your content prompt" class="valuesai6 cr_width_full">Write the content of a listicle section for the heading "%%current_section%%" in %%language%%. The title of the post is: "%%title%%". Don't add the title at the beginning of the created content. Be creative and unique. Don't repeat the heading in the created content. Don't add an intro or outro. Write %%paragraphs_per_section%% paragraphs in the section. Use HTML for formatting, include unnumbered lists and bold. If needed, you can use WordPress related CSS styling for the article. When applicable, add also HTML tables with WordPress styling (you can use WordPress table classes). If added, table data must be relevant, creative, short and simple. Act as a Content Writer, not as a Virtual Assistant. Return only the content requested, without any additional comments or text. Writing Style: %%writing_style%%. Tone: %%writing_tone%%.</textarea>
                           </td>
                        </tr>
                        <tr class="hidetopic">
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select the AI Model to be used for the content generator.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("AI Model For Content Generator:", 'aiomatic-automatic-ai-content-writer');?></b>   
                           </td>
                           <td class="cr_min_width_200">
                           <select autocomplete="off" id="topic_content_model6" name="topic_content_model" class="hideAssistant6 valuesai6 cr_width_full">
                           <?php
foreach($all_models as $modelx)
{
echo '<option value="' . $modelx .'"';
echo '>' . esc_html($modelx) . esc_html(aiomatic_get_model_provider($modelx)) . '</option>';
}
?>
                           </select>   
                           </td>
                        </tr>
                        <tr class="hidetopic">
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select if you want to use the above content prompt to create the entire article from a single API call (checkbox checked) or to run the prompt for each section separately (checkbox unchecked). If you check this, be sure to modify the content prompt accordingly.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Use the Above Content Prompt To Create The Entire Article (Not Each Section):", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="checkbox" id="single_content_call-16" name="single_content_call" onclick="hideTOC(-1);" class="valuesai6">
                           </td>
                        </tr>
                        <tr class="hidetopic">
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Prompt to be used for the Q&A of the article. You can use the following shortcodes: %%title%%, %%topic%%, %%language%%, %%writing_style%%, %%writing_tone%%, %%sections_count%%, %%random_sentence%%, %%random_sentence2%%, %%post_original_title%%, %%blog_title%% - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Article Q&A Prompt:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <textarea rows="2" cols="70" name="qa_prompt" id="qa_prompt6" placeholder="Enter your Q&A prompts, one per line" class="valuesai6 cr_width_full">Write a Q&A listicle for an article about "%%title%%", in %%language%%. Style: %%writing_style%%. Tone: %%writing_tone%%. Each question should be clear and engaging, followed by a detailed and informative answer. Use HTML for formatting, include unnumbered lists and bold where applicable. Return only the Q&A content, nothing else.</textarea>
                           </td>
                        </tr>
                        <tr class="hidetopic">
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select the AI Model to be used for the Q&A generator.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("AI Model For Q&A Generator:", 'aiomatic-automatic-ai-content-writer');?></b>   
                           </td>
                           <td class="cr_min_width_200">
                           <select autocomplete="off" id="topic_qa_model6" name="topic_qa_model" class="hideAssistant6 valuesai6 cr_width_full">
                           <?php
foreach($all_models as $modelx)
{
echo '<option value="' . $modelx .'"';
echo '>' . esc_html($modelx) . esc_html(aiomatic_get_model_provider($modelx)) . '</option>';
}
?>
                           </select>   
                           </td>
                        </tr>
                        <tr class="hidetopic">
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Prompt to be used for the outro of the article. You can use the following shortcodes: %%title%%, %%topic%%, %%language%%, %%writing_style%%, %%writing_tone%%, %%sections_count%%, %%random_sentence%%, %%random_sentence2%%, %%post_original_title%%, %%blog_title%% - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Article Outro Prompt:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <textarea rows="2" cols="70" name="outro_prompt" id="outro_prompt6" placeholder="Enter your outro prompts, one per line" class="valuesai6 cr_width_full">Write an outro for a listicle about "%%title%%", in %%language%%. Style: %%writing_style%%. Tone: %%writing_tone%%.</textarea>
                           </td>
                        </tr>
                        <tr class="hidetopic">
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select the AI Model to be used for the outro generator.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("AI Model For Outro Generator:", 'aiomatic-automatic-ai-content-writer');?></b>   
                           </td>
                           <td class="cr_min_width_200">
                           <select autocomplete="off" id="topic_outro_model6" name="topic_outro_model" class="hideAssistant6 valuesai6 cr_width_full">
                           <?php
foreach($all_models as $modelx)
{
echo '<option value="' . $modelx .'"';
echo '>' . esc_html($modelx) . esc_html(aiomatic_get_model_provider($modelx)) . '</option>';
}
?>
                           </select>   
                           </td>
                        </tr>
                        <tr class="hidetopic">
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Prompt to be used for the excerpt of the article. You can use the following shortcodes: %%title%%, %%topic%%, %%language%%, %%writing_style%%, %%writing_tone%%, %%sections%%, %%random_sentence%%, %%random_sentence2%%, %%post_original_title%%, %%blog_title%% - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Excerpt Prompt:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <textarea rows="2" cols="70" name="excerpt_prompt" id="excerpt_prompt6" placeholder="Enter your excerpt prompts, one per line" class="valuesai6 cr_width_full">Write a short excerpt for a listicle about "%%title%%" in %%language%%. Style: %%writing_style%%. Tone: %%writing_tone%%. Must be between 150 and 250 characters. Highlight the listicle nature of the article and what readers can expect to find.</textarea>
                           </td>
                        </tr>
                        <tr class="hidetopic">
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select the AI Model to be used for the excerpt generator.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("AI Model For Excerpt Generator:", 'aiomatic-automatic-ai-content-writer');?></b>   
                           </td>
                           <td class="cr_min_width_200">
                           <select autocomplete="off" id="topic_excerpt_model6" name="topic_excerpt_model" class="hideAssistant6 valuesai6 cr_width_full">
                           <?php
foreach($all_models as $modelx)
{
echo '<option value="' . $modelx .'"';
echo '>' . esc_html($modelx) . esc_html(aiomatic_get_model_provider($modelx)) . '</option>';
}
?>
                           </select>   
                           </td>
                        </tr>
                        <tr class="hidetopic"><td colspan="2">
                              <h4><?php echo esc_html__("Advanced Prompting Options", 'aiomatic-automatic-ai-content-writer');?>:</h4>
                        </td></tr>
                        <tr class="hidetopic">
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Run regex on prompts. To disable this feature, leave this field blank. No Regex separators are required here. You can add multiple Regex expressions, each on a different line.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Run Regex On Prompts:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <textarea rows="1" name="strip_by_regex_prompts" id="strip_by_regex_prompts6" placeholder="regex expression" class="valuesai6 cr_width_full"></textarea>
                           </td>
                        </tr>
                        <tr class="hidetopic">
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Replace the above regex matches with this regex expression. If you want to strip matched content, leave this field blank. No Regex separators are required here. You can add multiple replacement expressions, each on a different line.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Replace Matches From Regex (Prompts):", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <textarea rows="1" name="replace_regex_prompts" id="replace_regex_prompts6" placeholder="regex replacement" class="valuesai6 cr_width_full"></textarea>
                           </td>
                        </tr>
                        <tr class="hidetopic">
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select on which prompts do you want to run the above Regex. Possible values are (or any of their combinations): title, intro, sections, content, outro, excerpt", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Run Above Regex On Prompts:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input id="run_regex_on6" name="run_regex_on" type="text" list="run_regex_on_list6" class="valuesai6 coderevolution_gutenberg_input" value="content"/>
<datalist id="run_regex_on_list6">
<option value="title">title</option>
<option value="intro">intro</option>
<option value="sections">sections</option>
<option value="content">content</option>
<option value="qa">Q&A</option>
<option value="outro">outro</option>
<option value="excerpt">excerpt</option>
</datalist> 
                           </td>
                        </tr>
                     <tr><td colspan="2">
                              <h3><?php echo esc_html__("Global Prompt Options", 'aiomatic-automatic-ai-content-writer');?>:</h3>
                        </td></tr>
                        <tr class="hidetopic">
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("This will be prepended to each prompt sent by the plugin to the AI writer. You can use the following shortcodes: %%topic%%, %%language%%, %%writing_style%%, %%writing_tone%%, %%title%%, %%random_sentence%%, %%random_sentence2%%, %%post_original_title%%, %%blog_title%% - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators. You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Prepend Text To All Textual AI Prompts:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <textarea rows="2" cols="70" name="global_prepend" id="global_prepend6" placeholder="Global prompt prepend text" class="valuesai6 cr_width_full"></textarea>
                           </td>
                        </tr>
                        <tr class="hidetopic">
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("This will be appended to each prompt sent by the plugin to the AI writer. You can use the following shortcodes: %%topic%%, %%language%%, %%writing_style%%, %%writing_tone%%, %%title%%, %%random_sentence%%, %%random_sentence2%%, %%post_original_title%%, %%blog_title%% - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators. You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Append Text To All Textual AI Prompts:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <textarea rows="2" cols="70" name="global_append" id="global_append6" placeholder="Global prompt append text" class="valuesai6 cr_width_full"></textarea>
                           </td>
                        </tr>
                     <tr><td colspan="2">
                              <h3><?php echo esc_html__("Automatic Linking Options", 'aiomatic-automatic-ai-content-writer');?>:</h3>
                        </td></tr>
                        <tr>
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select the linking method to use in posts.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Automatic Linking Type:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <select autocomplete="off" class="valuesai6 cr_width_full" id="link_type6" onchange="hideLinks('');" name="link_type">
                           <option value="disabled" selected><?php echo esc_html__("Disabled", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="internal"><?php echo esc_html__("Internal Links", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="manual"><?php echo esc_html__("Manual Links", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="mixed"><?php echo esc_html__("Mixed Links", 'aiomatic-automatic-ai-content-writer');?></option>
                           </select>   
                           </td>
                        </tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Set the maximum number of automatic links to add to created posts. You can also define custom ranges, like: 3-5. Please note that this feature will work best if you already have a considerable number of posts published on your site, which will be used for internal linking.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Maximum Number Of Automatic Links To Add To The Post Content:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="text" name="max_links" id="max_links6" placeholder="3-5" class="valuesai6 cr_width_full">
                           </td>
                        </tr>
                        <tr class="hidelinks">
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Enter a manual list of links, where the plugin will create links.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Manual List Of URLs (One Per Line):", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <textarea rows="1" cols="70" name="link_list" id="link_list6" placeholder="URL list (one per line)" class="valuesai6 cr_width_full"></textarea>
                           </td>
                        </tr>
                        <tr class="hidelinks">
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Do you want to add nofollow attribute to manually entered, external links?", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Add Nofollow Attribute To Manual Links:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="checkbox" id="link_nofollow6" name="link_nofollow" class="valuesai6">
                           </td>
                        </tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Set the post types where to create automatic links in posts. You can also add a comma separated list of multiple post types.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Post Types Where To Generate Automatic Links:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="text" name="link_post_types" id="link_post_types6" placeholder="post" class="valuesai6 cr_width_full">
                           </td>
                        </tr>
                     <tr><td colspan="2">
                              <h3><?php echo esc_html__("Advanced AI Text Generator Options", 'aiomatic-automatic-ai-content-writer');?>:</h3>
                        </td></tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Set the maximum number of API tokens to use with each request. This will define the length of the resulting API response. Each token usually consists of approximately 4 characters. Note that in this value the number of tokens sent to the API as an article prompt will also be counted. The maximum amount which can be set is 4000. For other models, the maximum is 2048.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Maximum Total Token Count To Use Per API Request:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="number" min="1" max="128000" name="max_tokens" id="max_tokens6" value="" placeholder="32768" class="valuesai6 cr_width_full">
                           </td>
                        </tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Set the maximum number of prompt API tokens to use with each request. This will define the length of the resulting API response. Each token usually consists of approximately 4 characters. This defines how much content does the API receive each time you call it. If the API gets more initial data, better quality results will be expected. The maximum amount which can be set is 1000.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Maximum Prompt Token Count To Use Per API Request:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="number" min="1" max="128000" name="max_seed_tokens" id="max_seed_tokens6" value="" placeholder="1000" class="valuesai6 cr_width_full">
                           </td>
                        </tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("What sampling temperature to use. Higher values means the model will take more risks. Try 0.9 for more creative applications, and 0 (argmax sampling) for ones with a well-defined answer. We generally recommend altering this or top_p but not both.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("AI Temperature:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="number" min="0" step="0.1" max="2" name="temperature" id="temperature6" value="" placeholder="1" class="valuesai6 cr_width_full">
                           </td>
                        </tr><tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("An alternative to sampling with temperature, called nucleus sampling, where the model considers the results of the tokens with top_p probability mass. So 0.1 means only the tokens comprising the top 10% probability mass are considered. We generally recommend altering this or temperature but not both.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("AI Top_p:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="number" min="0" max="1" step="0.1" name="top_p" id="top_p6" value="" placeholder="1" class="valuesai6 cr_width_full">
                           </td>
                        </tr><tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Number between -2.0 and 2.0. Positive values penalize new tokens based on whether they appear in the text so far, increasing the model's likelihood to talk about new topics.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("AI Presence Penalty:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="number" min="-2" step="0.1" max="2" name="presence_penalty" id="presence_penalty6" value="" placeholder="0" class="valuesai6 cr_width_full">
                           </td>
                        </tr><tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Number between -2.0 and 2.0. Positive values penalize new tokens based on their existing frequency in the text so far, decreasing the model's likelihood to repeat the same line verbatim.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("AI Frequency Penalty:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="number" min="0" max="2" step="0.1" name="frequency_penalty" id="frequency_penalty6" value="" placeholder="0" class="valuesai6 cr_width_full">
                           </td>
                        </tr>
                     <tr><td colspan="2">
                              <h3><?php echo esc_html__("Image Generator Options", 'aiomatic-automatic-ai-content-writer');?>:</h3>
                        </td></tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select the search query repetition mode, when searching royalty free images.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Search Query Repetition:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <select autocomplete="off" id="search_query_repetition6" name="search_query_repetition" class="valuesai6 cr_width_full">
                              <option value="0" selected><?php echo esc_html__("Use Different Search Queries For Images", 'aiomatic-automatic-ai-content-writer');?></option>
                              <option value="1"><?php echo esc_html__("Use The Same Search Query For Images", 'aiomatic-automatic-ai-content-writer');?></option>
                           </select>
                           </td>
                        </tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Do you want to enable the AI Image Generator and to replace Royalty Free Images with AI generated images? If you select 'Default Featured Image List', you can add the image URLs in the 'Default Featured Image List' settings field.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Article Image Source:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <select autocomplete="off" id="enable_ai_images6" onchange="hideImage('6');" name="enable_ai_images" class="valuesai6 cr_width_full">
                              <option value="0" selected><?php echo esc_html__("Royalty Free", 'aiomatic-automatic-ai-content-writer');?></option>
                              <option value="1"><?php echo esc_html__("OpenAI/AiomaticAPI", 'aiomatic-automatic-ai-content-writer');?></option>
                              <?php
                              if (isset($aiomatic_Main_Settings['stability_app_id']) && trim($aiomatic_Main_Settings['stability_app_id']) != '')
                              {
                              ?>
                              <option value="2"><?php echo esc_html__("Stability.AI", 'aiomatic-automatic-ai-content-writer');?></option>
                              <?php
                              }
                              ?>
                           </select>
                           </td>
                        </tr>
                        <tr class="hideImg6 cr_none">
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Set list of prompt commands (one on each line) you want to send to the AI image generator. This command can be any given task or order, based on which, it will generate images. You can use the following shortcodes here: %%topic%%, %%post_title%%, %%random_sentence%%, %%post_original_title%%, %%random_sentence2%%, %%blog_title%%. The length of this command should not be greater than 1000 characters, otherwise the plugin will strip it to 1000 characters length. - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You can also add here a link to a .txt file, where you can add multiple prompts (one per line) and the plugin will select a random one at each run. You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators. You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                          echo '&nbsp;' . sprintf( wp_kses( __( "Please check some tips and tricks about writing prompt commands, <a href='%s' target='_blank'>here</a>. The [aicontent] shortcode is able to be used also here.", 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), 'https://coderevolution.ro/knowledge-base/faq/how-to-create-a-good-seed-prompt-command-for-aiomatic-image-generating-for-openai-dall-e-api/' );
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Prompt For The AI Image Generator:", 'aiomatic-automatic-ai-content-writer');?></b>&nbsp;<b><a href="https://coderevolution.ro/knowledge-base/faq/how-to-create-a-good-seed-prompt-command-for-aiomatic-image-generating-for-openai-dall-e-api/" target="_blank">&#9432;</a></b>
                           </td>
                           <td>
                           <textarea rows="2" cols="70" name="ai_command_image" id="ai_command_image6" placeholder="Please insert a command for the AI image generator" class="valuesai6 cr_width_full">Generate a high-resolution, visually compelling image that creatively interprets the theme encapsulated by this post title: "%%post_title%%". The image should be versatile enough to fit various niches, from technology and lifestyle to nature and science. It should feature a central, eye-catching element that abstractly represents the topic, surrounded by relevant, subtler motifs that provide context and depth. The composition should be balanced and aesthetically pleasing, with a harmonious color palette that complements the mood of the title. The artwork should be suitable for use as a captivating header image for a blog post.</textarea>
                           </td>
                        </tr>
                        <tr class="hideDalle6 cr_none">
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select the AI model you wish to use for image the image generator.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("AI Image Model:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <select autocomplete="off" id="image_model6" name="image_model" class="valuesai6 cr_width_full">
                              <option value="dalle2"selected><?php echo esc_html__("Dall-E 2", 'aiomatic-automatic-ai-content-writer');?></option>
                              <option value="dalle3"><?php echo esc_html__("Dall-E 3", 'aiomatic-automatic-ai-content-writer');?></option>
                              <option value="dalle3hd"><?php echo esc_html__("Dall-E 3 HD", 'aiomatic-automatic-ai-content-writer');?></option>
                           </select>
                           </td>
                        </tr>
                        <tr class="hideImg6 cr_none">
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select the size of the generated image.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Generated Image Size:", 'aiomatic-automatic-ai-content-writer');?></b>   
                           </td>
                           <td class="cr_min_width_200">
                           <select autocomplete="off" id="model6" name="image_size" class="cr_width_full valuesai6">
                              <option value="256x256"><?php echo esc_html__("256x256", 'aiomatic-automatic-ai-content-writer');?></option>
                              <option value="512x512"><?php echo esc_html__("512x512", 'aiomatic-automatic-ai-content-writer');?></option>
                              <option value="1024x1024" selected><?php echo esc_html__("1024x1024", 'aiomatic-automatic-ai-content-writer');?></option>
                           </select>  
                           </td>
                        </tr>
                        <tr><td colspan="2">
                              <h3><?php echo esc_html__("Posting Options", 'aiomatic-automatic-ai-content-writer');?>:</h3>
                        </td></tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Enter a HTML text that should be prepended to the AI generated content in each created post. You can use the following shortcodes: %%custom_html%%, %%custom_html2%%, %%random_sentence%%, %%random_sentence2%%, %%random_image[keyword]%%, %%random_image_url[keyword]%%, %%random_video[keyword]%%, %%royalty_free_image_attribution%% - you can also use an optional parameter in the random_image and random_video shortcodes, which will add a percentage chance for the media to appear or not - example: %%random_video[keyword][60]%% - a video will appear in 60% of cases, in the rest of 40%, nothing will be returned by the shortcode - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("HTML Text To Prepend To AI Created Content:", 'aiomatic-automatic-ai-content-writer');?></b>&nbsp;<b><a href="https://coderevolution.ro/knowledge-base/faq/post-template-reference-advanced-usage/" target="_blank">&#9432;</a></b>
                           </td>
                           <td>
                           <textarea rows="2" cols="70" name="post_prepend" id="post_prepend6" placeholder="HTML content to prepend to the AI generated content" class="cr_width_full valuesai6"></textarea>
                           </td>
                        </tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Enter a HTML text that should be appended to the AI generated content in each created post. You can use the following shortcodes: %%custom_html%%, %%custom_html2%%, %%random_sentence%%, %%random_sentence2%%, %%random_image[keyword]%%, %%random_image_url[keyword]%%, %%random_video[keyword]%%, %%royalty_free_image_attribution%% - you can also use an optional parameter in the random_image and random_video shortcodes, which will add a percentage chance for the media to appear or not - example: %%random_video[keyword][60]%% - a video will appear in 60% of cases, in the rest of 40%, nothing will be returned by the shortcode - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("HTML Text To Append To AI Created Content:", 'aiomatic-automatic-ai-content-writer');?></b>&nbsp;<b><a href="https://coderevolution.ro/knowledge-base/faq/post-template-reference-advanced-usage/" target="_blank">&#9432;</a></b>
                           </td>
                           <td>
                           <textarea rows="2" cols="70" name="post_append" id="post_append6" placeholder="HTML content to append to the AI generated content" class="cr_width_full valuesai6"></textarea>
                           </td>
                        </tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Custom AI generated content shortcode creator. If you wish to create content from multiple AI prompts, and use them in post content/post custom fields/taxonomies, you can configure this from here. Also, these shortcodes will be able to be used in custom fields or custom taxonomies which the plugin will create. Syntax for this field: shortcode_name => AI_MODEL_TO_USE @@ TEXTUAL_PROMPT_TO_USE (to specify multiple shortcodes and crawling values, separate them by a new line. Example: my_custom_shortcode => gpt-3.5-turbo-instruct @@ Write a short poem. Afterwards, you can use shortcodes in any settings field that supports shortcodes (ex: 'HTML Text To Append To AI Created Content' settings field), like this: %%my_custom_shortcode%%. Official format is %%name_of_custom_shortcode%%", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Custom Shortcode Creator (Optional):", 'aiomatic-automatic-ai-content-writer');?></b><span class="tool" data-tip="Supported models: <?php echo implode(',', aiomatic_get_all_models());?>">&nbsp;&#9432;</span>
                           </td>
                           <td>
                           <textarea rows="2" cols="70" name="custom_shortcodes" id="custom_shortcodes6" placeholder="shortcode_name => AI_MODEL @@ AI_PROMPT" class="valuesai6 cr_width_full"></textarea>
                           </td>
                        </tr>
                        <tr>
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("The AI writer might add the title of the post to the created post content. Check this checkbox if you want to remove the title from the post content.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Strip Title From Content:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="checkbox" id="strip_title6" name="strip_title" class="valuesai6">
                           </td>
                        </tr>
                        <tr>
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px"><?php echo esc_html__("Do you want to skip spinning of posts generated by this rule?", 'aiomatic-automatic-ai-content-writer');?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Do Not Spin Posts Generated By This Rule:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="checkbox" id="skip_spin6" name="skip_spin" class="valuesai6">               
                           </td>
                        </tr>
                        <tr>
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px"><?php echo esc_html__("Do you want to skip translating of posts generated by this rule?", 'aiomatic-automatic-ai-content-writer');?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Do Not Translate Posts Generated By This Rule:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="checkbox" id="skip_translate6" name="skip_translate" class="valuesai6">               
                           </td>
                        </tr>
                        <tr>
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Run regex on post content. To disable this feature, leave this field blank. No Regex separators are required here. You can add multiple Regex expressions, each on a different line.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Run Regex On Content:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <textarea rows="1" class="valuesai6 cr_width_full" name="strip_by_regex" id="strip_by_regex6" placeholder="regex expression"></textarea>
                           </td>
                        </tr>
                        <tr>
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Replace the above regex matches with this regex expression. If you want to strip matched content, leave this field blank. No Regex separators are required here. You can add multiple replacement expressions, each on a different line.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Replace Matches From Regex (Content):", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <textarea rows="1" class="valuesai6 cr_width_full" name="replace_regex" id="replace_regex6" placeholder="regex replacement"></textarea>
                           </td>
                        </tr>
                     </table>
                  </div>
               </div>
               <div class="codemodalfzr-footer">
                  <br/>
                  <h3 class="cr_inline">Aiomatic Automatic Post Generator</h3>
                  <span id="aiomatic_ok6" class="codeokfzr cr_inline">OK&nbsp;</span>
                  <br/><br/>
               </div>
            </div>
         </div>
         <div id="mymodalfzr1a" class="codemodalfzr">
            <div class="codemodalfzr-content">
               <div class="codemodalfzr-header">
                  <span id="aiomatic_close1a" class="codeclosefzr">&times;</span>
                  <h2><span class="cr_color_white"><?php echo esc_html__("Topic Based", 'aiomatic-automatic-ai-content-writer');?></span> <?php echo esc_html__("Advanced Settings", 'aiomatic-automatic-ai-content-writer');?></h2>
               </div>
               <div class="codemodalfzr-body">
                  <div class="table-responsive">
                     <table class="responsive table cr_main_table_nowr">
                     <tr><td colspan="2">
                           <h3><?php echo esc_html__("AI Assistant Options", 'aiomatic-automatic-ai-content-writer');?>:</h3>
                     </td></tr>
                     <tr>
                        <td class="cr_min_width_200">
                              <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                 <div class="bws_hidden_help_text cr_min_260px">
                                    <?php
                                       echo esc_html__("Select the AI Assistant to use for content creation. This will disable the ability to select AI models, as the models assisgned to the assistant will be used for content creation.", 'aiomatic-automatic-ai-content-writer');
                                       ?>
                                 </div>
                              </div>
                              <b><?php echo esc_html__("AI Assistant Name:", 'aiomatic-automatic-ai-content-writer');?></b>
                        </td>
                        <td><select id="assistant_id1a" name="assistant_id" class="valuesai1a cr_width_full" onchange="assistantSelected('1a');">
<?php
if($all_assistants === false)
{
echo '<option val="" selected disabled>' . esc_html__("Only OpenAI API is supported for Assistants API", 'aiomatic-automatic-ai-content-writer') . '</option>';
}
else
{
if(count($all_assistants) == 0)
{
echo '<option val="" selected disabled>' . esc_html__("No Assistans added, go to the plugin's 'AI Assistans' menu to add new assistants!", 'aiomatic-automatic-ai-content-writer') . '</option>';
}
else
{
echo '<option value="" selected';
echo '>' . esc_html__("Don't use assistants, use AI models instead", 'aiomatic-automatic-ai-content-writer') . '</option>';
foreach($all_assistants as $myassistant)
{
echo '<option value="' . $myassistant->ID .'"';
echo '>' . esc_html($myassistant->post_title);
echo '</option>';
}
}
}
?>
</select>  
                        </td>
                     </tr>
                        <tr class="hidetopic"><td colspan="2">
                              <h3><?php echo esc_html__("Topic Based Posting Options", 'aiomatic-automatic-ai-content-writer');?>:</h3>
                        </td></tr>
                        <tr class="hidetopic">
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select the method to be used for the title generator.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Title Generator Method:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <select autocomplete="off" class="valuesai1a cr_width_full" id="title_generator_method1a" name="title_generator_method">
                           <option value="ai" selected><?php echo esc_html__("AI Writer", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="serp"><?php echo esc_html__("Related SERP Searches", 'aiomatic-automatic-ai-content-writer');?></option>
                           </select>   
                           </td>
                        </tr>
                        <tr class="hidetopic">
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Enter a list of post sections, one per line. These will be headings of the content. These can also be automatically generated by the plugin. To enable auto generating of sections, leave this field blank. You can use here the %%topic%% shortcode, to get the value of the above topic, automtically. This will set the value of the %%sections%% shortcode, which can be used in prompts below. You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators. If you set a section list here, each created article will have this same list of sections, because of this, use shortcodes or Spintax when defining these static topics or leave this field blank for the plugin to auto generate them!", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Post Sections List (Optional):", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <textarea rows="2" cols="70" name="post_sections_list" id="post_sections_list1a" placeholder="Post sections list (one per line)" class="valuesai1a cr_width_full"></textarea>
                           </td>
                        </tr>
                        <tr class="hidetopic">
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Enter the number of sections to create in the article. These will also be set as article headings. You can also set value ranges, example: 5-7. In this case, a random number will be selected in this range. Please use only numeric values in this field. This field will set the value of the %%sections_count%% shortcode.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Number Of Content Sections To Generate:", 'aiomatic-automatic-ai-content-writer');?></b>   
                           </td>
                           <td class="cr_min_width_200">
                           <input type="text" id="section_count1a" name="section_count" placeholder="3-4" class="valuesai1a cr_width_full" value="3-4">  
                           </td>
                        </tr>
                        <tr class="hidetopic">
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select what you want to do with sections in articles.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Add Sections To Content As:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <select autocomplete="off" class="valuesai1a cr_width_full" id="sections_role1a" name="sections_role">
                           <option value="h2" selected><?php echo esc_html__("h2", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="h3"><?php echo esc_html__("h3", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="b"><?php echo esc_html__("Bold", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="i"><?php echo esc_html__("Italic", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="bi"><?php echo esc_html__("Bold and Italic", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="p"><?php echo esc_html__("Paragraph", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="x"><?php echo esc_html__("Plain Text", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="no"><?php echo esc_html__("Don't Add Sections", 'aiomatic-automatic-ai-content-writer');?></option>
                           </select>   
                           </td>
                        </tr>
                        <tr class="hidetopic">
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Enter the number of paragraphs to create for each section. These will also be set as article headings. You can also set value ranges, example: 5-7. In this case, a random number will be selected in this range. Please use only numeric values in this field. This field will set the value of the %%paragraphs_per_section%% shortcode.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Number Of Paragraphs Per Section:", 'aiomatic-automatic-ai-content-writer');?></b>   
                           </td>
                           <td class="cr_min_width_200">
                           <input type="text" id="paragraph_count1a" name="paragraph_count" placeholder="2-3" class="valuesai1a cr_width_full" value="2">  
                           </td>
                        </tr>
                        <tr class="hidetopic">
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Set the number of related images to add to the created post content. This feature will use the royalty free image sources configured in the plugin's 'Settings' menu or if you have access to the DallE API. You can change image source in the 'AI Image Source' settings field from below. The maximum number of images you can add to each article: number of sections + 2", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Number of Images To Add To The Article:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="text" name="topic_images" id="topic_images1a" value="" placeholder="Number of images" class="valuesai1a cr_width_full">
                           </td>
                        </tr>
                        <tr class="hidetopic">
                           <td>
                              <div>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select if you want to add an image to each of the creating headings from the article.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Add An Image To Each Heading Of The Article:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="checkbox" id="img_all_headings1a" name="img_all_headings" class="valuesai1a" checked>
                           </td>
                        </tr> 
                        <tr class="hidetopic">
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select the location of the heading images.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Heading Image Location:", 'aiomatic-automatic-ai-content-writer');?></b>   
                           </td>
                           <td class="cr_min_width_200">
                           <select autocomplete="off" id="heading_img_location1a" name="heading_img_location" class="valuesai1a cr_width_full">
                              <option value="top" selected><?php echo esc_html__("Top of the section", 'aiomatic-automatic-ai-content-writer');?></option>
                              <option value="heading"><?php echo esc_html__("Under the heading text", 'aiomatic-automatic-ai-content-writer');?></option>
                              <option value="bottom"><?php echo esc_html__("Bottom of the section", 'aiomatic-automatic-ai-content-writer');?></option>
                              <option value="random"><?php echo esc_html__("Random", 'aiomatic-automatic-ai-content-writer');?></option>
                           </select>   
                           </td>
                        </tr>
                        <tr class="hidetopic">
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Set the number of related YouTube videos to add to the created post content. The maximum number of videos you can add to each article: number of sections", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Number of YouTube Videos To Add To The Article:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="number" min="0" name="topic_videos" id="topic_videos1a" value="" placeholder="Number of videos" class="valuesai1a cr_width_full">
                           </td>
                        </tr>
                        <tr class="hidetopic">
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Set the text of the outro section header. This is optional.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Article Outro Section Header Text:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="text" name="title_outro" id="title_outro1a" value="{In Conclusion|To Conclude|In Summary|To Wrap It Up|Key Takeaways|Future Outlook|Closing Remarks|The Conclusion|Final Thoughts|In Retrospect|The Way Forward|Wrapping Up|Concluding Remarks|Insights and Conclusions}" placeholder="Optional" class="valuesai1a cr_width_full">
                           </td>
                        </tr> 
                        <tr class="hidetopic">
                           <td class="hideTOC-1">
                              <div>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select if you want to add a Table of Contents section to the created post.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Add Article Table Of Contents:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td class="hideTOC-1">
                           <input type="checkbox" id="enable_toc1a" name="enable_toc" class="valuesai1a">
                           </td>
                        </tr> 
                        <tr class="hidetopic">
                           <td class="hideTOC-1">
                              <div>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Set the text of the Table of Contents section header. Default is: Table of Contents", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Article Table Of Contents Section Header Text:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td class="hideTOC-1">
                           <input type="text" name="title_toc" id="title_toc1a" value="Table of Contents" placeholder="Table of Contents" class="valuesai1a cr_width_full">
                           </td>
                        </tr> 
                        <tr class="hidetopic">
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select if you want to add a Q&A section to the created post. To enable Q&A for articles, be sure to add a prompt also in the 'Article Q&A Prompt' settings field from below.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Add Article Q&A Section:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="checkbox" id="enable_qa1a" name="enable_qa" class="valuesai1a">
                           </td>
                        </tr> 
                        <tr class="hidetopic">
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Set the text of the Q&A section header. Default is: Q&A", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Article Q&A Section Header Text:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="text" id="title_qa1a" name="title_qa" value="Q&A" placeholder="Q&A" class="valuesai1a cr_width_full">
                           </td>
                        </tr> 
                        <tr class="hidetopic"><td colspan="2">
                              <h4><?php echo esc_html__("Content Parameters", 'aiomatic-automatic-ai-content-writer');?>:</h4>
                        </td></tr>
                        <tr class="hidetopic">
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Set the language of the created content. This will set the value of the %%language%% shortcode, which can be used in prompts below. You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Content Language:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input id="content_language1a" name="content_language" type="text" list="languages1a" placeholder="Created content language" class="valuesai1a coderevolution_gutenberg_input" value="English"/>
<datalist id="languages1a">
<?php
foreach($aiomatic_language_names as $ln)
{
echo '<option>' . $ln . '</option>';
}
?>
</datalist>
                           </td>
                        </tr>
                        <tr class="hidetopic">
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Set the writing style of the created content. This will set the value of the %%writing_style%% shortcode, which can be used in prompts below. You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Writing Style:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input id="writing_style1a" name="writing_style" type="text" placeholder="Created content writing style" list="writing_styles1a" class="valuesai1a coderevolution_gutenberg_input" value="Creative"/>
                           <datalist id="writing_styles1a">
<option>Informative</option>
<option>Academic</option>
<option>Descriptive</option>
<option>Detailed</option>
<option>Dramative</option>
<option>Fiction</option>
<option>Expository</option>
<option>Historical</option>
<option>Dialogue</option>
<option>Creative</option>
<option>Critical</option>
<option>Narrative</option>
<option>Persuasive</option>
<option>Reflective</option>
<option>Argumentative</option>
<option>Analytical</option>
<option>Blog</option>
<option>News</option>
<option>Casual</option>
<option>Pastoral</option>
<option>Personal</option>
<option>Poetic</option>
<option>Satirical</option>
<option>Sensory</option>
<option>Articulate</option>
<option>Monologue</option>
<option>Colloquial</option>
<option>Comparative</option>
<option>Concise</option>
<option>Biographical</option>
<option>Anecdotal</option>
<option>Evaluative</option>
<option>Letter</option>
<option>Lyrical</option>
<option>Simple</option>
<option>Vivid</option>
<option>Journalistic</option>
<option>Technical</option>
<option>Direct</option>
<option>Emotional</option>
<option>Metaphorical</option>
<option>Objective</option>
<option>Rhetorical</option>
<option>Theoretical</option>
<option>Business</option>
<option>Report</option>
<option>Research</option>
</datalist>
                           </td>
                        </tr>
                        <tr class="hidetopic">
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Set the writing tone of the created content. This will set the value of the %%writing_tone%% shortcode, which can be used in prompts below. You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Writing Tone:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input id="writing_tone1a" name="writing_tone" type="text" list="writing_tones1a" placeholder="Created content writing tone" class="valuesai1a coderevolution_gutenberg_input" value="Neutral"/>
                           <datalist id="writing_tones1a">
<option>Neutral</option>
<option>Formal</option>
<option>Assertive</option>
<option>Cheerful</option>
<option>Humorous</option>
<option>Informal</option>
<option>Inspirational</option>
<option>Professional</option>
<option>Emotional</option>
<option>Persuasive</option>
<option>Supportive</option>
<option>Sarcastic</option>
<option>Condescending</option>
<option>Skeptical</option>
<option>Narrative</option>
<option>Journalistic</option>
<option>Conversational</option>
<option>Factual</option>
<option>Friendly</option>
<option>Polite</option>
<option>Scientific</option>
<option>Sensitive</option>
<option>Sincere</option>
<option>Curious</option>
<option>Dissapointed</option>
<option>Encouraging</option>
<option>Optimistic</option>
<option>Surprised</option>
<option>Worried</option>
<option>Confident</option>
<option>Authoritative</option>
<option>Nostalgic</option>
<option>Sympathetic</option>
<option>Suspenseful</option>
<option>Romantic</option>
<option>Serious</option>
</datalist>
                           </td>
                        </tr>
                        <tr class="hidetopic"><td colspan="2">
                              <h4><?php echo esc_html__("Prompts", 'aiomatic-automatic-ai-content-writer');?>:</h4>
                        </td></tr>
                        <tr class="hidetopic">
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Prompt to be used for the Post Title. You can use the following shortcodes: %%topic%%, %%language%%, %%writing_style%%, %%writing_tone%%, %%title%%, %%random_sentence%%, %%random_sentence2%%, %%post_original_title%%, %%blog_title%% - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators. You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Title Prompt:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <textarea rows="2" cols="70" name="title_prompt" id="title_prompt1a" placeholder="Enter your title prompts, one per line" class="valuesai1a cr_width_full">Write a title for an article about "%%topic%%" in %%language%%. Style: %%writing_style%%. Tone: %%writing_tone%%. Must be between 40 and 60 characters.</textarea>
                           </td>
                        </tr>
                        <tr class="hidetopic">
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select the AI Model to be used for the title generator.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("AI Model For Title Generator:", 'aiomatic-automatic-ai-content-writer');?></b>   
                           </td>
                           <td class="cr_min_width_200">
                           <select autocomplete="off" id="topic_title_model1a" name="topic_title_model" class="hideAssistant1a valuesai1a cr_width_full">
                           <?php
foreach($all_models as $modelx)
{
echo '<option value="' . $modelx .'"';
echo '>' . esc_html($modelx) . esc_html(aiomatic_get_model_provider($modelx)) . '</option>';
}
?>
                           </select>   
                           </td>
                        </tr>
                        <tr class="hidetopic">
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Prompt to be used for the intro of the article. You can use the following shortcodes: %%title%%, %%topic%%, %%language%%, %%writing_style%%, %%writing_tone%%, %%sections_count%%, %%random_sentence%%, %%random_sentence2%%, %%post_original_title%%, %%blog_title%% - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Article Intro Prompt:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <textarea rows="2" cols="70" name="intro_prompt" id="intro_prompt1a" placeholder="Enter your intro prompts, one per line" class="valuesai1a cr_width_full">Craft an introduction for an article about "%%title%%", in %%language%%. Style: %%writing_style%%. Tone: %%writing_tone%%.</textarea>
                           </td>
                        </tr>
                        <tr class="hidetopic">
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select the AI Model to be used for the intro generator.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("AI Model For Intro Generator:", 'aiomatic-automatic-ai-content-writer');?></b>   
                           </td>
                           <td class="cr_min_width_200">
                           <select autocomplete="off" id="topic_intro_model1a" name="topic_intro_model" class="hideAssistant1a valuesai1a cr_width_full">
                           <?php
foreach($all_models as $modelx)
{
echo '<option value="' . $modelx .'"';
echo '>' . esc_html($modelx) . esc_html(aiomatic_get_model_provider($modelx)) . '</option>';
}
?>
                           </select>   
                           </td>
                        </tr>
                        <tr class="hidetopic">
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Prompt to be used for the Sections of the article. These will be set also as headings in the article. You can use the following shortcodes: %%title%%, %%topic%%, %%language%%, %%writing_style%%, %%writing_tone%%, %%sections_count%%, %%random_sentence%%, %%random_sentence2%%, %%post_original_title%%, %%blog_title%% - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Article Sections Prompt:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <textarea rows="2" cols="70" name="sections_prompt" id="sections_prompt1a" placeholder="Enter your sections prompts, one per line" class="valuesai1a cr_width_full">Write %%sections_count%% consecutive headings for an article about "%%title%%" that highlight specific aspects, provide detailed insights and specific recommendations. The headings must be written in %%language%%, following a %%writing_style%% style and a %%writing_tone%% tone. Don't add numbers to the headings, hyphens or any types of quotes. Return only the headings list, nothing else.</textarea>
                           </td>
                        </tr>
                        <tr class="hidetopic">
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select the AI Model to be used for the sections generator.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("AI Model For Sections Generator:", 'aiomatic-automatic-ai-content-writer');?></b>   
                           </td>
                           <td class="cr_min_width_200">
                           <select autocomplete="off" id="topic_sections_model1a" name="topic_sections_model" class="hideAssistant1a valuesai1a cr_width_full">
                           <?php
foreach($all_models as $modelx)
{
echo '<option value="' . $modelx .'"';
echo '>' . esc_html($modelx) . esc_html(aiomatic_get_model_provider($modelx)) . '</option>';
}
?>
                           </select>   
                           </td>
                        </tr>
                        <tr class="hidetopic">
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Prompt to be used for the Content of the article, which will be applied to each section heading generated by the plugin (or entered manually) or to the entire content (depending how you select using the 'Use the Above Content Prompt To Create The Entire Article' checkbox). You can use the following shortcodes: %%title%%, %%topic%%, %%language%%, %%writing_style%%, %%writing_tone%%, %%sections%%, %%current_section%%, %%paragraphs_per_section%%, %%random_sentence%%, %%random_sentence2%%, %%post_original_title%%, %%blog_title%% - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Content Prompt:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <textarea rows="3" cols="70" name="content_prompt" id="content_prompt1a" placeholder="Enter your content prompt" class="valuesai1a cr_width_full">Write the content of a post section for the heading "%%current_section%%" in %%language%%. The title of the post is: "%%title%%". Don't add the title at the beginning of the created content. Be creative and unique. Don't repeat the heading in the created content. Don't add an intro or outro. Write %%paragraphs_per_section%% paragraphs in the section. Use HTML for formatting, include unnumbered lists and bold. If needed, you can use WordPress related CSS styling for the article. When applicable, add also HTML tables with WordPress styling (you can use WordPress table classes). If added, table data must be relevant, creative, short and simple. Writing Style: %%writing_style%%. Tone: %%writing_tone%%.</textarea>
                           </td>
                        </tr>
                        <tr class="hidetopic">
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select the AI Model to be used for the content generator.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("AI Model For Content Generator:", 'aiomatic-automatic-ai-content-writer');?></b>   
                           </td>
                           <td class="cr_min_width_200">
                           <select autocomplete="off" id="topic_content_model1a" name="topic_content_model" class="hideAssistant1a valuesai1a cr_width_full">
                           <?php
foreach($all_models as $modelx)
{
echo '<option value="' . $modelx .'"';
echo '>' . esc_html($modelx) . esc_html(aiomatic_get_model_provider($modelx)) . '</option>';
}
?>
                           </select>   
                           </td>
                        </tr>
                        <tr class="hidetopic">
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select if you want to use the above content prompt to create the entire article from a single API call (checkbox checked) or to run the prompt for each section separately (checkbox unchecked). If you check this, be sure to modify the content prompt accordingly.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Use the Above Content Prompt To Create The Entire Article (Not Each Section):", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="checkbox" id="single_content_call-11a" name="single_content_call" onclick="hideTOC(-1);" class="valuesai1a">
                           </td>
                        </tr>
                        <tr class="hidetopic">
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Prompt to be used for the Q&A of the article. You can use the following shortcodes: %%title%%, %%topic%%, %%language%%, %%writing_style%%, %%writing_tone%%, %%sections_count%%, %%random_sentence%%, %%random_sentence2%%, %%post_original_title%%, %%blog_title%% - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Article Q&A Prompt:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <textarea rows="2" cols="70" name="qa_prompt" id="qa_prompt1a" placeholder="Enter your Q&A prompts, one per line" class="valuesai1a cr_width_full">Write a Q&A for an article about "%%title%%", in %%language%%. Style: %%writing_style%%. Tone: %%writing_tone%%.</textarea>
                           </td>
                        </tr>
                        <tr class="hidetopic">
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select the AI Model to be used for the Q&A generator.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("AI Model For Q&A Generator:", 'aiomatic-automatic-ai-content-writer');?></b>   
                           </td>
                           <td class="cr_min_width_200">
                           <select autocomplete="off" id="topic_qa_model1a" name="topic_qa_model" class="hideAssistant1a valuesai1a cr_width_full">
                           <?php
foreach($all_models as $modelx)
{
echo '<option value="' . $modelx .'"';
echo '>' . esc_html($modelx) . esc_html(aiomatic_get_model_provider($modelx)) . '</option>';
}
?>
                           </select>   
                           </td>
                        </tr>
                        <tr class="hidetopic">
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Prompt to be used for the outro of the article. You can use the following shortcodes: %%title%%, %%topic%%, %%language%%, %%writing_style%%, %%writing_tone%%, %%sections_count%%, %%random_sentence%%, %%random_sentence2%%, %%post_original_title%%, %%blog_title%% - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Article Outro Prompt:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <textarea rows="2" cols="70" name="outro_prompt" id="outro_prompt1a" placeholder="Enter your outro prompts, one per line" class="valuesai1a cr_width_full">Write an outro for an article about "%%title%%", in %%language%%. Style: %%writing_style%%. Tone: %%writing_tone%%.</textarea>
                           </td>
                        </tr>
                        <tr class="hidetopic">
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select the AI Model to be used for the outro generator.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("AI Model For Outro Generator:", 'aiomatic-automatic-ai-content-writer');?></b>   
                           </td>
                           <td class="cr_min_width_200">
                           <select autocomplete="off" id="topic_outro_model1a" name="topic_outro_model" class="hideAssistant1a valuesai1a cr_width_full">
                           <?php
foreach($all_models as $modelx)
{
echo '<option value="' . $modelx .'"';
echo '>' . esc_html($modelx) . esc_html(aiomatic_get_model_provider($modelx)) . '</option>';
}
?>
                           </select>   
                           </td>
                        </tr>
                        <tr class="hidetopic">
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Prompt to be used for the excerpt of the article. You can use the following shortcodes: %%title%%, %%topic%%, %%language%%, %%writing_style%%, %%writing_tone%%, %%sections%%, %%random_sentence%%, %%random_sentence2%%, %%post_original_title%%, %%blog_title%% - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Excerpt Prompt:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <textarea rows="2" cols="70" name="excerpt_prompt" id="excerpt_prompt1a" placeholder="Enter your excerpt prompts, one per line" class="valuesai1a cr_width_full">Write a short excerpt for an article about "%%title%%" in %%language%%. Style: %%writing_style%%. Tone: %%writing_tone%%. Must be between 150 and 250 characters.</textarea>
                           </td>
                        </tr>
                        <tr class="hidetopic">
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select the AI Model to be used for the excerpt generator.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("AI Model For Excerpt Generator:", 'aiomatic-automatic-ai-content-writer');?></b>   
                           </td>
                           <td class="cr_min_width_200">
                           <select autocomplete="off" id="topic_excerpt_model1a" name="topic_excerpt_model" class="hideAssistant1a valuesai1a cr_width_full">
                           <?php
foreach($all_models as $modelx)
{
echo '<option value="' . $modelx .'"';
echo '>' . esc_html($modelx) . esc_html(aiomatic_get_model_provider($modelx)) . '</option>';
}
?>
                           </select>   
                           </td>
                        </tr>
                        <tr class="hidetopic"><td colspan="2">
                              <h4><?php echo esc_html__("Advanced Prompting Options", 'aiomatic-automatic-ai-content-writer');?>:</h4>
                        </td></tr>
                        <tr class="hidetopic">
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Run regex on prompts. To disable this feature, leave this field blank. No Regex separators are required here. You can add multiple Regex expressions, each on a different line.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Run Regex On Prompts:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <textarea rows="1" name="strip_by_regex_prompts" id="strip_by_regex_prompts1a" placeholder="regex expression" class="valuesai1a cr_width_full"></textarea>
                           </td>
                        </tr>
                        <tr class="hidetopic">
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Replace the above regex matches with this regex expression. If you want to strip matched content, leave this field blank. No Regex separators are required here. You can add multiple replacement expressions, each on a different line.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Replace Matches From Regex (Prompts):", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <textarea rows="1" name="replace_regex_prompts" id="replace_regex_prompts1a" placeholder="regex replacement" class="valuesai1a cr_width_full"></textarea>
                           </td>
                        </tr>
                        <tr class="hidetopic">
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select on which prompts do you want to run the above Regex. Possible values are (or any of their combinations): title, intro, sections, content, outro, excerpt", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Run Above Regex On Prompts:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input id="run_regex_on1a" name="run_regex_on" type="text" list="run_regex_on_list1a" class="valuesai1a coderevolution_gutenberg_input" value="content"/>
<datalist id="run_regex_on_list1a">
<option value="title">title</option>
<option value="intro">intro</option>
<option value="sections">sections</option>
<option value="content">content</option>
<option value="qa">Q&A</option>
<option value="outro">outro</option>
<option value="excerpt">excerpt</option>
</datalist> 
                           </td>
                        </tr>
                     <tr><td colspan="2">
                              <h3><?php echo esc_html__("Global Prompt Options", 'aiomatic-automatic-ai-content-writer');?>:</h3>
                        </td></tr>
                        <tr class="hidetopic">
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("This will be prepended to each prompt sent by the plugin to the AI writer. You can use the following shortcodes: %%topic%%, %%language%%, %%writing_style%%, %%writing_tone%%, %%title%%, %%random_sentence%%, %%random_sentence2%%, %%post_original_title%%, %%blog_title%% - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators. You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Prepend Text To All Textual AI Prompts:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <textarea rows="2" cols="70" name="global_prepend" id="global_prepend1a" placeholder="Global prompt prepend text" class="valuesai1a cr_width_full"></textarea>
                           </td>
                        </tr>
                        <tr class="hidetopic">
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("This will be appended to each prompt sent by the plugin to the AI writer. You can use the following shortcodes: %%topic%%, %%language%%, %%writing_style%%, %%writing_tone%%, %%title%%, %%random_sentence%%, %%random_sentence2%%, %%post_original_title%%, %%blog_title%% - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators. You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Append Text To All Textual AI Prompts:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <textarea rows="2" cols="70" name="global_append" id="global_append1a" placeholder="Global prompt append text" class="valuesai1a cr_width_full"></textarea>
                           </td>
                        </tr>
                     <tr><td colspan="2">
                              <h3><?php echo esc_html__("Automatic Linking Options", 'aiomatic-automatic-ai-content-writer');?>:</h3>
                        </td></tr>
                        <tr>
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select the linking method to use in posts.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Automatic Linking Type:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <select autocomplete="off" class="valuesai1a cr_width_full" id="link_type1a" onchange="hideLinks('');" name="link_type">
                           <option value="disabled" selected><?php echo esc_html__("Disabled", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="internal"><?php echo esc_html__("Internal Links", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="manual"><?php echo esc_html__("Manual Links", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="mixed"><?php echo esc_html__("Mixed Links", 'aiomatic-automatic-ai-content-writer');?></option>
                           </select>   
                           </td>
                        </tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Set the maximum number of automatic links to add to created posts. You can also define custom ranges, like: 3-5. Please note that this feature will work best if you already have a considerable number of posts published on your site, which will be used for internal linking.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Maximum Number Of Automatic Links To Add To The Post Content:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="text" name="max_links" id="max_links1a" placeholder="3-5" class="valuesai1a cr_width_full">
                           </td>
                        </tr>
                        <tr class="hidelinks">
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Enter a manual list of links, where the plugin will create links.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Manual List Of URLs (One Per Line):", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <textarea rows="1" cols="70" name="link_list" id="link_list1a" placeholder="URL list (one per line)" class="valuesai1a cr_width_full"></textarea>
                           </td>
                        </tr>
                        <tr class="hidelinks">
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Do you want to add nofollow attribute to manually entered, external links?", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Add Nofollow Attribute To Manual Links:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="checkbox" id="link_nofollow1a" name="link_nofollow" class="valuesai1a">
                           </td>
                        </tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Set the post types where to create automatic links in posts. You can also add a comma separated list of multiple post types.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Post Types Where To Generate Automatic Links:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="text" name="link_post_types" id="link_post_types1a" placeholder="post" class="valuesai1a cr_width_full">
                           </td>
                        </tr>
                     <tr><td colspan="2">
                              <h3><?php echo esc_html__("Advanced AI Text Generator Options", 'aiomatic-automatic-ai-content-writer');?>:</h3>
                        </td></tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Set the maximum number of API tokens to use with each request. This will define the length of the resulting API response. Each token usually consists of approximately 4 characters. Note that in this value the number of tokens sent to the API as an article prompt will also be counted. The maximum amount which can be set is 4000. For other models, the maximum is 2048.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Maximum Total Token Count To Use Per API Request:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="number" min="1" max="128000" name="max_tokens" id="max_tokens1a" value="" placeholder="32768" class="valuesai1a cr_width_full">
                           </td>
                        </tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Set the maximum number of prompt API tokens to use with each request. This will define the length of the resulting API response. Each token usually consists of approximately 4 characters. This defines how much content does the API receive each time you call it. If the API gets more initial data, better quality results will be expected. The maximum amount which can be set is 1000.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Maximum Prompt Token Count To Use Per API Request:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="number" min="1" max="128000" name="max_seed_tokens" id="max_seed_tokens1a" value="" placeholder="1000" class="valuesai1a cr_width_full">
                           </td>
                        </tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("What sampling temperature to use. Higher values means the model will take more risks. Try 0.9 for more creative applications, and 0 (argmax sampling) for ones with a well-defined answer. We generally recommend altering this or top_p but not both.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("AI Temperature:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="number" min="0" step="0.1" max="2" name="temperature" id="temperature1a" value="" placeholder="1" class="valuesai1a cr_width_full">
                           </td>
                        </tr><tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("An alternative to sampling with temperature, called nucleus sampling, where the model considers the results of the tokens with top_p probability mass. So 0.1 means only the tokens comprising the top 10% probability mass are considered. We generally recommend altering this or temperature but not both.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("AI Top_p:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="number" min="0" max="1" step="0.1" name="top_p" id="top_p1a" value="" placeholder="1" class="valuesai1a cr_width_full">
                           </td>
                        </tr><tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Number between -2.0 and 2.0. Positive values penalize new tokens based on whether they appear in the text so far, increasing the model's likelihood to talk about new topics.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("AI Presence Penalty:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="number" min="-2" step="0.1" max="2" name="presence_penalty" id="presence_penalty1a" value="" placeholder="0" class="valuesai1a cr_width_full">
                           </td>
                        </tr><tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Number between -2.0 and 2.0. Positive values penalize new tokens based on their existing frequency in the text so far, decreasing the model's likelihood to repeat the same line verbatim.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("AI Frequency Penalty:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="number" min="0" max="2" step="0.1" name="frequency_penalty" id="frequency_penalty1a" value="" placeholder="0" class="valuesai1a cr_width_full">
                           </td>
                        </tr>
                     <tr><td colspan="2">
                              <h3><?php echo esc_html__("Image Generator Options", 'aiomatic-automatic-ai-content-writer');?>:</h3>
                        </td></tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select the search query repetition mode, when searching royalty free images.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Search Query Repetition:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <select autocomplete="off" id="search_query_repetition1a" name="search_query_repetition" class="valuesai1a cr_width_full">
                              <option value="0" selected><?php echo esc_html__("Use Different Search Queries For Images", 'aiomatic-automatic-ai-content-writer');?></option>
                              <option value="1"><?php echo esc_html__("Use The Same Search Query For Images", 'aiomatic-automatic-ai-content-writer');?></option>
                           </select>
                           </td>
                        </tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Do you want to enable the AI Image Generator and to replace Royalty Free Images with AI generated images? If you select 'Default Featured Image List', you can add the image URLs in the 'Default Featured Image List' settings field.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Article Image Source:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <select autocomplete="off" id="enable_ai_images1a" onchange="hideImage('1a');" name="enable_ai_images" class="valuesai1a cr_width_full">
                              <option value="0" selected><?php echo esc_html__("Royalty Free", 'aiomatic-automatic-ai-content-writer');?></option>
                              <option value="1"><?php echo esc_html__("OpenAI/AiomaticAPI", 'aiomatic-automatic-ai-content-writer');?></option>
                              <?php
                              if (isset($aiomatic_Main_Settings['stability_app_id']) && trim($aiomatic_Main_Settings['stability_app_id']) != '')
                              {
                              ?>
                              <option value="2"><?php echo esc_html__("Stability.AI", 'aiomatic-automatic-ai-content-writer');?></option>
                              <?php
                              }
                              ?>
                           </select>
                           </td>
                        </tr>
                        <tr class="hideImg1a cr_none">
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Set list of prompt commands (one on each line) you want to send to the AI image generator. This command can be any given task or order, based on which, it will generate images. You can use the following shortcodes here: %%topic%%, %%post_title%%, %%random_sentence%%, %%post_original_title%%, %%random_sentence2%%, %%blog_title%%. The length of this command should not be greater than 1000 characters, otherwise the plugin will strip it to 1000 characters length. - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You can also add here a link to a .txt file, where you can add multiple prompts (one per line) and the plugin will select a random one at each run. You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators. You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                          echo '&nbsp;' . sprintf( wp_kses( __( "Please check some tips and tricks about writing prompt commands, <a href='%s' target='_blank'>here</a>. The [aicontent] shortcode is able to be used also here.", 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), 'https://coderevolution.ro/knowledge-base/faq/how-to-create-a-good-seed-prompt-command-for-aiomatic-image-generating-for-openai-dall-e-api/' );
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Prompt For The AI Image Generator:", 'aiomatic-automatic-ai-content-writer');?></b>&nbsp;<b><a href="https://coderevolution.ro/knowledge-base/faq/how-to-create-a-good-seed-prompt-command-for-aiomatic-image-generating-for-openai-dall-e-api/" target="_blank">&#9432;</a></b>
                           </td>
                           <td>
                           <textarea rows="2" cols="70" name="ai_command_image" id="ai_command_image1a" placeholder="Please insert a command for the AI image generator" class="valuesai1a cr_width_full">Generate a high-resolution, visually compelling image that creatively interprets the theme encapsulated by this post title: "%%post_title%%". The image should be versatile enough to fit various niches, from technology and lifestyle to nature and science. It should feature a central, eye-catching element that abstractly represents the topic, surrounded by relevant, subtler motifs that provide context and depth. The composition should be balanced and aesthetically pleasing, with a harmonious color palette that complements the mood of the title. The artwork should be suitable for use as a captivating header image for a blog post.</textarea>
                           </td>
                        </tr>
                        <tr class="hideDalle1a cr_none">
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select the AI model you wish to use for image the image generator.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("AI Image Model:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <select autocomplete="off" id="image_model1a" name="image_model" class="valuesai1a cr_width_full">
                              <option value="dalle2"selected><?php echo esc_html__("Dall-E 2", 'aiomatic-automatic-ai-content-writer');?></option>
                              <option value="dalle3"><?php echo esc_html__("Dall-E 3", 'aiomatic-automatic-ai-content-writer');?></option>
                              <option value="dalle3hd"><?php echo esc_html__("Dall-E 3 HD", 'aiomatic-automatic-ai-content-writer');?></option>
                           </select>
                           </td>
                        </tr>
                        <tr class="hideImg1a cr_none">
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select the size of the generated image.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Generated Image Size:", 'aiomatic-automatic-ai-content-writer');?></b>   
                           </td>
                           <td class="cr_min_width_200">
                           <select autocomplete="off" id="model1a" name="image_size" class="cr_width_full valuesai1a">
                              <option value="256x256"><?php echo esc_html__("256x256", 'aiomatic-automatic-ai-content-writer');?></option>
                              <option value="512x512"><?php echo esc_html__("512x512", 'aiomatic-automatic-ai-content-writer');?></option>
                              <option value="1024x1024" selected><?php echo esc_html__("1024x1024", 'aiomatic-automatic-ai-content-writer');?></option>
                           </select>  
                           </td>
                        </tr>
                        <tr><td colspan="2">
                              <h3><?php echo esc_html__("Posting Options", 'aiomatic-automatic-ai-content-writer');?>:</h3>
                        </td></tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Enter a HTML text that should be prepended to the AI generated content in each created post. You can use the following shortcodes: %%custom_html%%, %%custom_html2%%, %%random_sentence%%, %%random_sentence2%%, %%random_image[keyword]%%, %%random_image_url[keyword]%%, %%random_video[keyword]%%, %%royalty_free_image_attribution%% - you can also use an optional parameter in the random_image and random_video shortcodes, which will add a percentage chance for the media to appear or not - example: %%random_video[keyword][60]%% - a video will appear in 60% of cases, in the rest of 40%, nothing will be returned by the shortcode - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("HTML Text To Prepend To AI Created Content:", 'aiomatic-automatic-ai-content-writer');?></b>&nbsp;<b><a href="https://coderevolution.ro/knowledge-base/faq/post-template-reference-advanced-usage/" target="_blank">&#9432;</a></b>
                           </td>
                           <td>
                           <textarea rows="2" cols="70" name="post_prepend" id="post_prepend1a" placeholder="HTML content to prepend to the AI generated content" class="cr_width_full valuesai1a"></textarea>
                           </td>
                        </tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Enter a HTML text that should be appended to the AI generated content in each created post. You can use the following shortcodes: %%custom_html%%, %%custom_html2%%, %%random_sentence%%, %%random_sentence2%%, %%random_image[keyword]%%, %%random_image_url[keyword]%%, %%random_video[keyword]%%, %%royalty_free_image_attribution%% - you can also use an optional parameter in the random_image and random_video shortcodes, which will add a percentage chance for the media to appear or not - example: %%random_video[keyword][60]%% - a video will appear in 60% of cases, in the rest of 40%, nothing will be returned by the shortcode - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("HTML Text To Append To AI Created Content:", 'aiomatic-automatic-ai-content-writer');?></b>&nbsp;<b><a href="https://coderevolution.ro/knowledge-base/faq/post-template-reference-advanced-usage/" target="_blank">&#9432;</a></b>
                           </td>
                           <td>
                           <textarea rows="2" cols="70" name="post_append" id="post_append1a" placeholder="HTML content to append to the AI generated content" class="cr_width_full valuesai1a"></textarea>
                           </td>
                        </tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Custom AI generated content shortcode creator. If you wish to create content from multiple AI prompts, and use them in post content/post custom fields/taxonomies, you can configure this from here. Also, these shortcodes will be able to be used in custom fields or custom taxonomies which the plugin will create. Syntax for this field: shortcode_name => AI_MODEL_TO_USE @@ TEXTUAL_PROMPT_TO_USE (to specify multiple shortcodes and crawling values, separate them by a new line. Example: my_custom_shortcode => gpt-3.5-turbo-instruct @@ Write a short poem. Afterwards, you can use shortcodes in any settings field that supports shortcodes (ex: 'HTML Text To Append To AI Created Content' settings field), like this: %%my_custom_shortcode%%. Official format is %%name_of_custom_shortcode%%", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Custom Shortcode Creator (Optional):", 'aiomatic-automatic-ai-content-writer');?></b><span class="tool" data-tip="Supported models: <?php echo implode(',', aiomatic_get_all_models());?>">&nbsp;&#9432;</span>
                           </td>
                           <td>
                           <textarea rows="2" cols="70" name="custom_shortcodes" id="custom_shortcodes1a" placeholder="shortcode_name => AI_MODEL @@ AI_PROMPT" class="valuesai1a cr_width_full"></textarea>
                           </td>
                        </tr>
                        <tr>
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("The AI writer might add the title of the post to the created post content. Check this checkbox if you want to remove the title from the post content.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Strip Title From Content:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="checkbox" id="strip_title1a" name="strip_title" class="valuesai1a">
                           </td>
                        </tr>
                        <tr>
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px"><?php echo esc_html__("Do you want to skip spinning of posts generated by this rule?", 'aiomatic-automatic-ai-content-writer');?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Do Not Spin Posts Generated By This Rule:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="checkbox" id="skip_spin1a" name="skip_spin" class="valuesai1a">               
                           </td>
                        </tr>
                        <tr>
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px"><?php echo esc_html__("Do you want to skip translating of posts generated by this rule?", 'aiomatic-automatic-ai-content-writer');?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Do Not Translate Posts Generated By This Rule:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="checkbox" id="skip_translate1a" name="skip_translate" class="valuesai1a">               
                           </td>
                        </tr>
                        <tr>
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Run regex on post content. To disable this feature, leave this field blank. No Regex separators are required here. You can add multiple Regex expressions, each on a different line.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Run Regex On Content:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <textarea rows="1" class="valuesai1a cr_width_full" name="strip_by_regex" id="strip_by_regex1a" placeholder="regex expression"></textarea>
                           </td>
                        </tr>
                        <tr>
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Replace the above regex matches with this regex expression. If you want to strip matched content, leave this field blank. No Regex separators are required here. You can add multiple replacement expressions, each on a different line.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Replace Matches From Regex (Content):", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <textarea rows="1" class="valuesai1a cr_width_full" name="replace_regex" id="replace_regex1a" placeholder="regex replacement"></textarea>
                           </td>
                        </tr>
                     </table>
                  </div>
               </div>
               <div class="codemodalfzr-footer">
                  <br/>
                  <h3 class="cr_inline">Aiomatic Automatic Post Generator</h3>
                  <span id="aiomatic_ok1a" class="codeokfzr cr_inline">OK&nbsp;</span>
                  <br/><br/>
               </div>
            </div>
         </div>
   <div id="mymodalfzr1b" class="codemodalfzr">
            <div class="codemodalfzr-content">
               <div class="codemodalfzr-header">
                  <span id="aiomatic_close1b" class="codeclosefzr">&times;</span>
                  <h2><span class="cr_color_white"><?php echo esc_html__("Title Based", 'aiomatic-automatic-ai-content-writer');?></span> <?php echo esc_html__("Advanced Settings", 'aiomatic-automatic-ai-content-writer');?></h2>
               </div>
               <div class="codemodalfzr-body">
                  <div class="table-responsive">
                     <table class="responsive table cr_main_table_nowr">
                     <tr><td colspan="2">
                           <h3><?php echo esc_html__("AI Assistant Options", 'aiomatic-automatic-ai-content-writer');?>:</h3>
                     </td></tr>
                     <tr>
                        <td class="cr_min_width_200">
                              <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                 <div class="bws_hidden_help_text cr_min_260px">
                                    <?php
                                       echo esc_html__("Select the AI Assistant to use for content creation. This will disable the ability to select AI models, as the models assisgned to the assistant will be used for content creation.", 'aiomatic-automatic-ai-content-writer');
                                       ?>
                                 </div>
                              </div>
                              <b><?php echo esc_html__("AI Assistant Name:", 'aiomatic-automatic-ai-content-writer');?></b>
                        </td>
                        <td><select id="assistant_id1b" name="assistant_id" class="valuesai1b cr_width_full" onchange="assistantSelected('1b');">
<?php
if($all_assistants === false)
{
echo '<option val="" selected disabled>' . esc_html__("Only OpenAI API is supported for Assistants API", 'aiomatic-automatic-ai-content-writer') . '</option>';
}
else
{
if(count($all_assistants) == 0)
{
echo '<option val="" selected disabled>' . esc_html__("No Assistans added, go to the plugin's 'AI Assistans' menu to add new assistants!", 'aiomatic-automatic-ai-content-writer') . '</option>';
}
else
{
echo '<option value="" selected';
echo '>' . esc_html__("Don't use assistants, use AI models instead", 'aiomatic-automatic-ai-content-writer') . '</option>';
foreach($all_assistants as $myassistant)
{
echo '<option value="' . $myassistant->ID .'"';
echo '>' . esc_html($myassistant->post_title);
echo '</option>';
}
}
}
?>
</select>  
                        </td>
                     </tr>
                        <tr class="hidetitle"><td colspan="2">
                              <h3><?php echo esc_html__("Title Based Posting Options", 'aiomatic-automatic-ai-content-writer');?>:</h3>
                        </td></tr>
                     <tr class="hidetitle"><td colspan="2">
                              <h4><?php echo esc_html__("Post Content - AI Text Generator Options", 'aiomatic-automatic-ai-content-writer');?>:</h4>
                        </td></tr>
                        <tr class="hidetitle">
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select the AI Model to be used for text generator.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("AI Model For Text Generator:", 'aiomatic-automatic-ai-content-writer');?></b>   
                           </td>
                           <td class="cr_min_width_200">
                           <select autocomplete="off" id="model1b" name="model" class="hideAssistant1b valuesai1b cr_width_full">
                           <?php
foreach($all_models as $modelx)
{
echo '<option value="' . $modelx .'"';
echo '>' . esc_html($modelx) . esc_html(aiomatic_get_model_provider($modelx)) . '</option>';
}
?>
                           </select>   
                           </td>
                        </tr>
                        <tr class="hidetitle">
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Set list of prompt commands (one on each line) you want to send to OpenAI/AiomaticAPI. This command can be any given task or order, based on which, it will generate content for posts. You can use the following shortcodes here: %%post_title%%, %%random_sentence%%, %%post_original_title%%, %%random_sentence2%%, %%blog_title%%. You can also add a link to a TXT file, containing keywords (one per line), or to an RSS feed. If you use RSS feeds, you can also use the following additional shortcodes: %%post_content%%, %%post_content_plain_text%%, %%post_excerpt%%, %%post_cats%%, %%author_name%%, %%current_date_time%%, %%post_link%%. The length of this command should not be greater than the max token count set in the settings for the prompt command - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You can also add here a link to a .txt file, where you can add multiple prompts (one per line) and the plugin will select a random one at each run. You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                          echo '&nbsp;' . sprintf( wp_kses( __( "Please check some tips and tricks about writing prompt commands, <a href='%s' target='_blank'>here</a>.", 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), 'https://coderevolution.ro/knowledge-base/faq/how-to-create-a-good-seed-prompt-command-for-aiomatic-for-openai-gpt-3-api/' );
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Prompt For The AI Text Generator:", 'aiomatic-automatic-ai-content-writer');?></b>&nbsp;<b><a href="https://coderevolution.ro/knowledge-base/faq/how-to-create-a-good-seed-prompt-command-for-aiomatic-for-openai-gpt-3-api/" target="_blank">&#9432;</a></b>
                           </td>
                           <td>
                           <textarea rows="2" cols="70" name="ai_command" id="ai_command1b" placeholder="Please insert a command for the AI" class="valuesai1b cr_width_full">Write a comprehensive and SEO-optimized article on the topic of "%%post_title%%". Incorporate relevant keywords naturally throughout the article to enhance search engine visibility. This article must provide valuable information to readers and be well-structured with proper headings, bullet points, and HTML formatting. If needed, you can use WordPress related CSS styling for the article. When applicable, add also HTML tables with WordPress styling (you can use WordPress table classes). If added, table data must be relevant, creative, short and simple. 

Add an introductory and a conclusion section to the article. You can add also some other sections, when they fit the article's subject, like: benefits and practical tips, case studies, first had experience.

Please ensure that the article is at least 1200 words in length and adheres to best SEO practices, including proper header tags (H1, H2, H3), meta title, and meta description.

Feel free to use a friendly, conversational tone and make the article as informative and engaging as possible while ensuring it remains factually accurate and well-researched.</textarea>
                           </td>
                        </tr>
                        <tr class="hidetitle">
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo sprintf( wp_kses( __( "Select the minimum number of characters that the posts should have. If the API returns content which has fewer characters than this number, another API call will be made, until this character limit is met. Please check about API rate limiting <a href='%s'>here</a>.", 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), 'https://beta.openai.com/docs/api-reference/introduction' );
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("AI Content Minimum Character Count:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="number" min="1" step="1" name="min_char" id="min_char1b" value="500" placeholder="Please insert a minimum number of characters for posts" class="valuesai1b cr_width_full">
                           </td>
                        </tr>
                        <tr class="hidetitle"><td colspan="2">
                              <h4><?php echo esc_html__("Post Title - AI Text Generator Options (%%ai_generated_title%% shortcode)", 'aiomatic-automatic-ai-content-writer');?>:<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("The %%ai_generated_title%% shortcode can be used in the 'Post Title List / TXT File URL / RSS Feed URL' settings field, to get partial or fully AI generated titles.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div></h4>
                        </td></tr>
                        <tr class="hidetitle">
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select the AI Model to be used for title text generator. You can add this to the post titles, using the %%ai_generated_title%% shortcode.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("AI Model For Title Text Generator:", 'aiomatic-automatic-ai-content-writer');?></b>   
                           </td>
                           <td class="cr_min_width_200">
                           <select autocomplete="off" id="title_model1b" name="title_model" class="hideAssistant1b valuesai1b cr_width_full">
                           <?php
                                 foreach($all_models as $modelx)
                                 {
                                    echo '<option value="' . $modelx .'"';
                                    echo '>' . esc_html($modelx) . esc_html(aiomatic_get_model_provider($modelx)) . '</option>';
                                 }
                                 ?>
                           </select>   
                           </td>
                        </tr>
                        <tr class="hidetitle">
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Set list of prompt commands (one on each line) you want to send to AI for generating post titles. This command can be any given task or order, based on which, it will generate content for posts. You can use the following shortcodes here: %%post_title%%, %%random_sentence%%, %%post_original_title%%, %%random_sentence2%%, %%blog_title%%. You can also add a link to a TXT file, containing keywords (one per line), or to an RSS feed. If you use RSS feeds, you can also use the following additional shortcodes: %%post_content%%, %%post_content_plain_text%%, %%post_excerpt%%, %%post_cats%%, %%author_name%%, %%current_date_time%%, %%post_link%%. The length of this command should not be greater than the max token count set in the settings for the prompt command - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You can also add here a link to a .txt file, where you can add multiple prompts (one per line) and the plugin will select a random one at each run. You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                          echo '&nbsp;' . sprintf( wp_kses( __( "Please check some tips and tricks about writing prompt commands, <a href='%s' target='_blank'>here</a>.", 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), 'https://coderevolution.ro/knowledge-base/faq/how-to-create-a-good-seed-prompt-command-for-aiomatic-for-openai-gpt-3-api/' );
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Prompt For The AI Title Text Generator:", 'aiomatic-automatic-ai-content-writer');?></b>&nbsp;<b><a href="https://coderevolution.ro/knowledge-base/faq/how-to-create-a-good-seed-prompt-command-for-aiomatic-for-openai-gpt-3-api/" target="_blank">&#9432;</a></b>
                           </td>
                           <td>
                           <textarea rows="2" cols="70" name="title_ai_command" id="title_ai_command1b" placeholder="Please insert a command for the AI" class="valuesai1b cr_width_full">Craft an attention-grabbing and SEO-optimized article title for a dental health blog. This title must be concise, informative, and designed to pique the interest of readers while clearly conveying the topic of the article.</textarea>
                           </td>
                        </tr><tr class="hidetitle">
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select the source of the post title. If you select AI generated, the plugin will create an AI generated title based on keywords you enter in the 'Post Title List' settings field. Otherwise, it will use the titles listed there, for the created posts.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Post Title Source:", 'aiomatic-automatic-ai-content-writer');?></b>   
                           </td>
                           <td class="cr_min_width_200">
                           <select autocomplete="off" id="title_source1b" name="title_source" class="valuesai1b cr_width_full">
                              <option value="keyword" selected><?php echo esc_html__("Use The Titles From The 'Post Title List' Settings Field", 'aiomatic-automatic-ai-content-writer');?></option>
                              <option value="ai"><?php echo esc_html__("Fully AI Generated Titles", 'aiomatic-automatic-ai-content-writer');?></option>
                           </select>   
                           </td>
                        </tr>
                        <tr class="hidetitle"><td colspan="2">
                              <h4><?php echo esc_html__("Rich Content Creation Options", 'aiomatic-automatic-ai-content-writer');?>:</h4>
                        </td></tr>
                        <tr class="hidetitle">
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Set the maximum number of related headings to add to the created post content. This feature will use the 'People Also Ask' feature from Google and Bing. By default, the Bing engine is scraped, if you want to enable also Google scraping, add a SerpAPI key in the plugin's 'Settings' menu -> 'SerpAPI API Key' settings field.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Maximum Number Of Related Headings to Add To The Content:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="number" min="0" name="headings" id="headings1b" value="" placeholder="Max heading count" class="valuesai1b cr_width_full">
                           </td>
                        </tr>
                        <tr class="hidetitle">
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select the AI Model to be used for headings generator.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("AI Model For The Headings Generator:", 'aiomatic-automatic-ai-content-writer');?></b>   
                           </td>
                           <td class="cr_min_width_200">
                           <select autocomplete="off" id="headings_model1b" name="headings_model" class="hideAssistant1b valuesai1b cr_width_full">
                           <?php
foreach($all_models as $modelx)
{
echo '<option value="' . $modelx .'"';
echo '>' . esc_html($modelx) . esc_html(aiomatic_get_model_provider($modelx)) . '</option>';
}
?>
                           </select>  
                           </td>
                        </tr>
                        <tr class="hidetitle">
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Set the prompt you will use when searching for related headings. You can use the following shortcodes: %%post_title%%, %%needed_heading_count%%. The same model will be used, as the one selected for content creation. If you leave this field blank, the default prompt will be used: 'Write %%needed_heading_count%% PAA related questions, each on a new line, for the title: %%post_title%%' You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Related Headings AI Generator Prompt:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <textarea rows="2" cols="70" name="headings_ai_command" id="headings_ai_command1b" placeholder="Write %%needed_heading_count%% PAA related questions, each on a new line, for the title: %%post_title%%" class="valuesai1b cr_width_full">Generate %%needed_heading_count%% People Also Ask (PAA) related questions, each on a new line, that are relevant to the topic of the post title: "%%post_title%%".</textarea>
                           </td>
                        </tr>
                        <tr class="hidetitle">
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Set the maximum number of related images to add to the created post content. This feature will use the 'Royalty Free Image' settings from the plugin's 'Settings' menu or if you have access to the DallE API.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Maximum Number Of Related Images to Add To The Content:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="number" min="0" name="images" id="images1b" value="" placeholder="Max image count" class="valuesai1b cr_width_full">
                           </td>
                        </tr>
                        <tr class="hidetitle">
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Add a related YouTube video to the end of to the created post content. This feature will require you to add at least one YouTube API key in the plugin's 'Settings' -> 'YouTube API Key List' settings field.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Add A Related Video To The End Of The Post:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="checkbox" id="videos1b" name="videos" class="valuesai1b">
                           </td>
                        </tr>
                     <tr class="hidetitle"><td colspan="2">
                              <h4><?php echo esc_html__("Manual Headings and Images List", 'aiomatic-automatic-ai-content-writer');?>:</h4>
                        </td></tr>
                        <tr class="hidetitle">
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Add a list of headings (one on each line) to use in the generated articles. You can use the following shortcodes here: %%post_title%%, %%random_sentence%%, %%post_original_title%%, %%random_sentence2%%, %%blog_title%%. - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins).", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Manual List Of Headings:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <textarea rows="2" cols="70" name="headings_list" id="headings_list1b" placeholder="List of headings" class="valuesai1b cr_width_full"></textarea>
                           </td>
                        </tr><tr class="hidetitle">
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Add a list of image URLs (one on each line) to use in the generated articles. - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins).", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Manual List Of Images:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <textarea rows="2" cols="70" name="images_list" id="images_list1b" placeholder="List of images" class="valuesai1b cr_width_full"></textarea>
                           </td>
                        </tr>
                     <tr><td colspan="2">
                              <h3><?php echo esc_html__("Global Prompt Options", 'aiomatic-automatic-ai-content-writer');?>:</h3>
                        </td></tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("This will be prepended to each prompt sent by the plugin to the AI writer. You can use the following shortcodes: %%topic%%, %%language%%, %%writing_style%%, %%writing_tone%%, %%title%%, %%random_sentence%%, %%random_sentence2%%, %%post_original_title%%, %%blog_title%% - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators. You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Prepend Text To All Textual AI Prompts:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <textarea rows="2" cols="70" name="global_prepend" id="global_prepend1b" placeholder="Global prompt prepend text" class="valuesai1b cr_width_full"></textarea>
                           </td>
                        </tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("This will be appended to each prompt sent by the plugin to the AI writer. You can use the following shortcodes: %%topic%%, %%language%%, %%writing_style%%, %%writing_tone%%, %%title%%, %%random_sentence%%, %%random_sentence2%%, %%post_original_title%%, %%blog_title%% - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators. You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Append Text To All Textual AI Prompts:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <textarea rows="2" cols="70" name="global_append" id="global_append1b" placeholder="Global prompt append text" class="valuesai1b cr_width_full"></textarea>
                           </td>
                        </tr>
                     <tr><td colspan="2">
                              <h3><?php echo esc_html__("Automatic Linking Options", 'aiomatic-automatic-ai-content-writer');?>:</h3>
                        </td></tr>
                        <tr>
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select the linking method to use in posts.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Automatic Linking Type:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <select autocomplete="off" class="valuesai1b cr_width_full" id="link_type1b" onchange="hideLinks('');" name="link_type">
                           <option value="disabled" selected><?php echo esc_html__("Disabled", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="internal"><?php echo esc_html__("Internal Links", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="manual"><?php echo esc_html__("Manual Links", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="mixed"><?php echo esc_html__("Mixed Links", 'aiomatic-automatic-ai-content-writer');?></option>
                           </select>   
                           </td>
                        </tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Set the maximum number of automatic links to add to created posts. You can also define custom ranges, like: 3-5. Please note that this feature will work best if you already have a considerable number of posts published on your site, which will be used for internal linking.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Maximum Number Of Automatic Links To Add To The Post Content:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="text" name="max_links" id="max_links1b" placeholder="3-5" class="valuesai1b cr_width_full">
                           </td>
                        </tr>
                        <tr class="hidelinks">
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Enter a manual list of links, where the plugin will create links.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Manual List Of URLs (One Per Line):", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <textarea rows="1" cols="70" name="link_list" id="link_list1b" placeholder="URL list (one per line)" class="valuesai1b cr_width_full"></textarea>
                           </td>
                        </tr>
                        <tr class="hidelinks">
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Do you want to add nofollow attribute to manually entered, external links?", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Add Nofollow Attribute To Manual Links:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="checkbox" id="link_nofollow1b" name="link_nofollow" class="valuesai1b">
                           </td>
                        </tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Set the post types where to create automatic links in posts. You can also add a comma separated list of multiple post types.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Post Types Where To Generate Automatic Links:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="text" name="link_post_types" id="link_post_types1b" placeholder="post" class="valuesai1b cr_width_full">
                           </td>
                        </tr>
                     <tr><td colspan="2">
                              <h3><?php echo esc_html__("Advanced AI Text Generator Options", 'aiomatic-automatic-ai-content-writer');?>:</h3>
                        </td></tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Set the maximum number of API tokens to use with each request. This will define the length of the resulting API response. Each token usually consists of approximately 4 characters. Note that in this value the number of tokens sent to the API as an article prompt will also be counted. The maximum amount which can be set is 4000. For other models, the maximum is 2048.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Maximum Total Token Count To Use Per API Request:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="number" min="1" max="128000" name="max_tokens" id="max_tokens1b" value="" placeholder="32768" class="valuesai1b cr_width_full">
                           </td>
                        </tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Set the maximum number of prompt API tokens to use with each request. This will define the length of the resulting API response. Each token usually consists of approximately 4 characters. This defines how much content does the API receive each time you call it. If the API gets more initial data, better quality results will be expected. The maximum amount which can be set is 1000.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Maximum Prompt Token Count To Use Per API Request:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="number" min="1" max="128000" name="max_seed_tokens" id="max_seed_tokens1b" value="" placeholder="1000" class="valuesai1b cr_width_full">
                           </td>
                        </tr>
                        <tr class="hidetitle">
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Set the maximum number of continue API tokens to use with each request. This will define the length of the resulting API response. Each token usually consists of approximately 4 characters. This defines how much content does the API receive each time you call it. If the API gets more initial data, better quality results will be expected. The maximum amount which can be set is 500.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Maximum Continue Token Count To Use Per API Request:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="number" min="1" max="128000" name="max_continue_tokens" id="max_continue_tokens1b" value="" placeholder="500" class="valuesai1b cr_width_full">
                           </td>
                        </tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("What sampling temperature to use. Higher values means the model will take more risks. Try 0.9 for more creative applications, and 0 (argmax sampling) for ones with a well-defined answer. We generally recommend altering this or top_p but not both.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("AI Temperature:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="number" min="0" step="0.1" max="2" name="temperature" id="temperature1b" value="" placeholder="1" class="valuesai1b cr_width_full">
                           </td>
                        </tr><tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("An alternative to sampling with temperature, called nucleus sampling, where the model considers the results of the tokens with top_p probability mass. So 0.1 means only the tokens comprising the top 10% probability mass are considered. We generally recommend altering this or temperature but not both.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("AI Top_p:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="number" min="0" max="1" step="0.1" name="top_p" id="top_p1b" value="" placeholder="1" class="valuesai1b cr_width_full">
                           </td>
                        </tr><tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Number between -2.0 and 2.0. Positive values penalize new tokens based on whether they appear in the text so far, increasing the model's likelihood to talk about new topics.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("AI Presence Penalty:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="number" min="-2" step="0.1" max="2" name="presence_penalty" id="presence_penalty1b" value="" placeholder="0" class="valuesai1b cr_width_full">
                           </td>
                        </tr><tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Number between -2.0 and 2.0. Positive values penalize new tokens based on their existing frequency in the text so far, decreasing the model's likelihood to repeat the same line verbatim.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("AI Frequency Penalty:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="number" min="0" max="2" step="0.1" name="frequency_penalty" id="frequency_penalty1b" value="" placeholder="0" class="valuesai1b cr_width_full">
                           </td>
                        </tr>
                     <tr><td colspan="2">
                              <h3><?php echo esc_html__("Image Generator Options", 'aiomatic-automatic-ai-content-writer');?>:</h3>
                        </td></tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select the search query repetition mode, when searching royalty free images.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Search Query Repetition:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <select autocomplete="off" id="search_query_repetition1b" name="search_query_repetition" class="valuesai1b cr_width_full">
                              <option value="0" selected><?php echo esc_html__("Use Different Search Queries For Images", 'aiomatic-automatic-ai-content-writer');?></option>
                              <option value="1"><?php echo esc_html__("Use The Same Search Query For Images", 'aiomatic-automatic-ai-content-writer');?></option>
                           </select>
                           </td>
                        </tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Do you want to enable the AI Image Generator and to replace Royalty Free Images with AI generated images? If you select 'Default Featured Image List', you can add the image URLs in the 'Default Featured Image List' settings field.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Article Image Source:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <select autocomplete="off" id="enable_ai_images1b" onchange="hideImage('1b');" name="enable_ai_images" class="valuesai1b cr_width_full">
                              <option value="0" selected><?php echo esc_html__("Royalty Free", 'aiomatic-automatic-ai-content-writer');?></option>
                              <option value="1"><?php echo esc_html__("OpenAI/AiomaticAPI", 'aiomatic-automatic-ai-content-writer');?></option>
                              <?php
                              if (isset($aiomatic_Main_Settings['stability_app_id']) && trim($aiomatic_Main_Settings['stability_app_id']) != '')
                              {
                              ?>
                              <option value="2"><?php echo esc_html__("Stability.AI", 'aiomatic-automatic-ai-content-writer');?></option>
                              <?php
                              }
                              ?>
                           </select>
                           </td>
                        </tr>
                        <tr class="hideImg1b cr_none">
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Set list of prompt commands (one on each line) you want to send to the AI image generator. This command can be any given task or order, based on which, it will generate images. You can use the following shortcodes here: %%topic%%, %%post_title%%, %%random_sentence%%, %%post_original_title%%, %%random_sentence2%%, %%blog_title%%. The length of this command should not be greater than 1000 characters, otherwise the plugin will strip it to 1000 characters length. - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You can also add here a link to a .txt file, where you can add multiple prompts (one per line) and the plugin will select a random one at each run. You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators. You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                          echo '&nbsp;' . sprintf( wp_kses( __( "Please check some tips and tricks about writing prompt commands, <a href='%s' target='_blank'>here</a>. The [aicontent] shortcode is able to be used also here.", 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), 'https://coderevolution.ro/knowledge-base/faq/how-to-create-a-good-seed-prompt-command-for-aiomatic-image-generating-for-openai-dall-e-api/' );
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Prompt For The AI Image Generator:", 'aiomatic-automatic-ai-content-writer');?></b>&nbsp;<b><a href="https://coderevolution.ro/knowledge-base/faq/how-to-create-a-good-seed-prompt-command-for-aiomatic-image-generating-for-openai-dall-e-api/" target="_blank">&#9432;</a></b>
                           </td>
                           <td>
                           <textarea rows="2" cols="70" name="ai_command_image" id="ai_command_image1b" placeholder="Please insert a command for the AI image generator" class="valuesai1b cr_width_full">Generate a high-resolution, visually compelling image that creatively interprets the theme encapsulated by this post title: "%%post_title%%". The image should be versatile enough to fit various niches, from technology and lifestyle to nature and science. It should feature a central, eye-catching element that abstractly represents the topic, surrounded by relevant, subtler motifs that provide context and depth. The composition should be balanced and aesthetically pleasing, with a harmonious color palette that complements the mood of the title. The artwork should be suitable for use as a captivating header image for a blog post.</textarea>
                           </td>
                        </tr>
                        <tr class="hideDalle1b cr_none">
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select the AI model you wish to use for image the image generator.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("AI Image Model:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <select autocomplete="off" id="image_model1b" name="image_model" class="valuesai1b cr_width_full">
                              <option value="dalle2"selected><?php echo esc_html__("Dall-E 2", 'aiomatic-automatic-ai-content-writer');?></option>
                              <option value="dalle3"><?php echo esc_html__("Dall-E 3", 'aiomatic-automatic-ai-content-writer');?></option>
                              <option value="dalle3hd"><?php echo esc_html__("Dall-E 3 HD", 'aiomatic-automatic-ai-content-writer');?></option>
                           </select>
                           </td>
                        </tr>
                        <tr class="hideImg1b cr_none">
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select the size of the generated image.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Generated Image Size:", 'aiomatic-automatic-ai-content-writer');?></b>   
                           </td>
                           <td class="cr_min_width_200">
                           <select autocomplete="off" id="model1b" name="image_size" class="valuesai1b cr_width_full">
                              <option value="256x256"><?php echo esc_html__("256x256", 'aiomatic-automatic-ai-content-writer');?></option>
                              <option value="512x512"><?php echo esc_html__("512x512", 'aiomatic-automatic-ai-content-writer');?></option>
                              <option value="1024x1024" selected><?php echo esc_html__("1024x1024", 'aiomatic-automatic-ai-content-writer');?></option>
                           </select>  
                           </td>
                        </tr>
                        <tr><td colspan="2">
                              <h3><?php echo esc_html__("Posting Options", 'aiomatic-automatic-ai-content-writer');?>:</h3>
                        </td></tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Enter a HTML text that should be prepended to the AI generated content in each created post. You can use the following shortcodes: %%custom_html%%, %%custom_html2%%, %%random_sentence%%, %%random_sentence2%%, %%random_image[keyword]%%, %%random_image_url[keyword]%%, %%random_video[keyword]%%, %%royalty_free_image_attribution%% - you can also use an optional parameter in the random_image and random_video shortcodes, which will add a percentage chance for the media to appear or not - example: %%random_video[keyword][60]%% - a video will appear in 60% of cases, in the rest of 40%, nothing will be returned by the shortcode - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("HTML Text To Prepend To AI Created Content:", 'aiomatic-automatic-ai-content-writer');?></b>&nbsp;<b><a href="https://coderevolution.ro/knowledge-base/faq/post-template-reference-advanced-usage/" target="_blank">&#9432;</a></b>
                           </td>
                           <td>
                           <textarea rows="2" cols="70" name="post_prepend" id="post_prepend1b" placeholder="HTML content to prepend to the AI generated content" class="valuesai1b cr_width_full"></textarea>
                           </td>
                        </tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Enter a HTML text that should be appended to the AI generated content in each created post. You can use the following shortcodes: %%custom_html%%, %%custom_html2%%, %%random_sentence%%, %%random_sentence2%%, %%random_image[keyword]%%, %%random_image_url[keyword]%%, %%random_video[keyword]%%, %%royalty_free_image_attribution%% - you can also use an optional parameter in the random_image and random_video shortcodes, which will add a percentage chance for the media to appear or not - example: %%random_video[keyword][60]%% - a video will appear in 60% of cases, in the rest of 40%, nothing will be returned by the shortcode - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("HTML Text To Append To AI Created Content:", 'aiomatic-automatic-ai-content-writer');?></b>&nbsp;<b><a href="https://coderevolution.ro/knowledge-base/faq/post-template-reference-advanced-usage/" target="_blank">&#9432;</a></b>
                           </td>
                           <td>
                           <textarea rows="2" cols="70" name="post_append" id="post_append1b" placeholder="HTML content to append to the AI generated content" class="valuesai1b cr_width_full"></textarea>
                           </td>
                        </tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Custom AI generated content shortcode creator. If you wish to create content from multiple AI prompts, and use them in post content/post custom fields/taxonomies, you can configure this from here. Also, these shortcodes will be able to be used in custom fields or custom taxonomies which the plugin will create. Syntax for this field: shortcode_name => AI_MODEL_TO_USE @@ TEXTUAL_PROMPT_TO_USE (to specify multiple shortcodes and crawling values, separate them by a new line. Example: my_custom_shortcode => gpt-3.5-turbo-instruct @@ Write a short poem. Afterwards, you can use shortcodes in any settings field that supports shortcodes (ex: 'HTML Text To Append To AI Created Content' settings field), like this: %%my_custom_shortcode%%. Official format is %%name_of_custom_shortcode%%", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Custom Shortcode Creator (Optional):", 'aiomatic-automatic-ai-content-writer');?></b><span class="tool" data-tip="Supported models: <?php echo implode(',', aiomatic_get_all_models());?>">&nbsp;&#9432;</span>
                           </td>
                           <td>
                           <textarea rows="2" cols="70" name="custom_shortcodes" id="custom_shortcodes1b" placeholder="shortcode_name => AI_MODEL @@ AI_PROMPT" class="valuesai1b cr_width_full"></textarea>
                           </td>
                        </tr>
                        <tr>
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("The AI writer might add the title of the post to the created post content. Check this checkbox if you want to remove the title from the post content.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Strip Title From Content:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="checkbox" id="strip_title1b" name="strip_title" class="valuesai1b">
                           </td>
                        </tr>
                        <tr>
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px"><?php echo esc_html__("Do you want to skip spinning of posts generated by this rule?", 'aiomatic-automatic-ai-content-writer');?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Do Not Spin Posts Generated By This Rule:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="checkbox" id="skip_spin1b" name="skip_spin" class="valuesai1b">               
                           </td>
                        </tr>
                        <tr>
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px"><?php echo esc_html__("Do you want to skip translating of posts generated by this rule?", 'aiomatic-automatic-ai-content-writer');?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Do Not Translate Posts Generated By This Rule:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="checkbox" id="skip_translate1b" name="skip_translate" class="valuesai1b">               
                           </td>
                        </tr>
                        <tr>
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Run regex on post content. To disable this feature, leave this field blank. No Regex separators are required here. You can add multiple Regex expressions, each on a different line.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Run Regex On Content:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <textarea rows="1" name="strip_by_regex" id="strip_by_regex1b" placeholder="regex expression" class="valuesai1b cr_width_full"></textarea>
                           </td>
                        </tr>
                        <tr>
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Replace the above regex matches with this regex expression. If you want to strip matched content, leave this field blank. No Regex separators are required here. You can add multiple replacement expressions, each on a different line.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Replace Matches From Regex (Content):", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <textarea rows="1" name="replace_regex" id="replace_regex1b" placeholder="regex replacement" class="valuesai1b cr_width_full"></textarea>
                           </td>
                        </tr>
                     </table>
                  </div>
               </div>
               <div class="codemodalfzr-footer">
                  <br/>
                  <h3 class="cr_inline">Aiomatic Automatic Post Generator</h3>
                  <span id="aiomatic_ok1b" class="codeokfzr cr_inline">OK&nbsp;</span>
                  <br/><br/>
               </div>
            </div>
         </div>


   <div id="mymodalfzr2" class="codemodalfzr">
            <div class="codemodalfzr-content">
               <div class="codemodalfzr-header">
                  <span id="aiomatic_close2" class="codeclosefzr">&times;</span>
                  <h2><span class="cr_color_white"><?php echo esc_html__("YouTube Video To Post", 'aiomatic-automatic-ai-content-writer');?></span> <?php echo esc_html__("Advanced Settings", 'aiomatic-automatic-ai-content-writer');?></h2>
               </div>
               <div class="codemodalfzr-body">
                  <div class="table-responsive">
                     <table class="responsive table cr_main_table_nowr">
                     <tr><td colspan="2">
                           <h3><?php echo esc_html__("AI Assistant Options", 'aiomatic-automatic-ai-content-writer');?>:</h3>
                     </td></tr>
                     <tr>
                        <td class="cr_min_width_200">
                              <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                 <div class="bws_hidden_help_text cr_min_260px">
                                    <?php
                                       echo esc_html__("Select the AI Assistant to use for content creation. This will disable the ability to select AI models, as the models assisgned to the assistant will be used for content creation.", 'aiomatic-automatic-ai-content-writer');
                                       ?>
                                 </div>
                              </div>
                              <b><?php echo esc_html__("AI Assistant Name:", 'aiomatic-automatic-ai-content-writer');?></b>
                        </td>
                        <td><select id="assistant_id2" name="assistant_id" class="valuesai2 cr_width_full" onchange="assistantSelected('2');">
<?php
if($all_assistants === false)
{
echo '<option val="" selected disabled>' . esc_html__("Only OpenAI API is supported for Assistants API", 'aiomatic-automatic-ai-content-writer') . '</option>';
}
else
{
if(count($all_assistants) == 0)
{
echo '<option val="" selected disabled>' . esc_html__("No Assistans added, go to the plugin's 'AI Assistans' menu to add new assistants!", 'aiomatic-automatic-ai-content-writer') . '</option>';
}
else
{
echo '<option value="" selected';
echo '>' . esc_html__("Don't use assistants, use AI models instead", 'aiomatic-automatic-ai-content-writer') . '</option>';
foreach($all_assistants as $myassistant)
{
echo '<option value="' . $myassistant->ID .'"';
echo '>' . esc_html($myassistant->post_title);
echo '</option>';
}
}
}
?>
</select>  
                        </td>
                     </tr>
                        <tr><td colspan="2">
                              <h3><?php echo esc_html__("YouTube Video Options", 'aiomatic-automatic-ai-content-writer');?>:</h3>
                        </td></tr>
                        <tr>
                           <td>
                              <div>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Input a comma separated list of video captions prefered languages to use for the %%video_caption%% shortcode. Please use a comma separated list of 2 character language codes. Ex: en,es,hu,br. The plugin will use the fisrt language in the list that matches. If you leave this field blank, the default language caption will be imported for each video.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Video Caption Preferred Languages:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="text" name="default_lang" id="default_lang2" value="" placeholder="Please insert a language list for video captions" class="valuesai2 cr_width_full">
                           </td>
                        </tr>
                        <tr>
                           <td>
                              <div>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Set the maximum length of captions in prompts. This is useful to have, when captions can be very long.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Video Caption Maximum Character Length In Prompts:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="number" min="0" name="max_caption" id="max_caption2" value="3000" placeholder="Caption maximum length" class="valuesai2 cr_width_full">  
                           </td>
                        </tr>
                        <tr><td colspan="2">
                              <h3><?php echo esc_html__("Posting Options", 'aiomatic-automatic-ai-content-writer');?>:</h3>
                        </td></tr>
                        <tr>
                           <td>
                              <div>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select if you want to use AI generated titles for the posts created by the plugin. If not, the YouTube video title will be used.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Use AI Generated Post Titles:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="checkbox" id="ai_titles2" name="ai_titles" class="valuesai2">
                           </td>
                        </tr> 
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Enter a list of post sections, one per line. These will be headings of the content. These can also be automatically generated by the plugin. To enable auto generating of sections, leave this field blank. This will set the value of the %%sections%% shortcode, which can be used in prompts below. You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators. If you set a section list here, each created article will have this same list of sections, because of this, use shortcodes or Spintax when defining these static topics or leave this field blank for the plugin to auto generate them!", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Post Sections List (Optional):", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <textarea rows="2" cols="70" name="post_sections_list" id="post_sections_list2" placeholder="Post sections list (one per line)" class="valuesai2 cr_width_full"></textarea>
                           </td>
                        </tr>
                        <tr>
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Enter the number of sections to create in the article. These will also be set as article headings. You can also set value ranges, example: 5-7. In this case, a random number will be selected in this range. Please use only numeric values in this field. This field will set the value of the %%sections_count%% shortcode.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Number Of Content Sections To Generate:", 'aiomatic-automatic-ai-content-writer');?></b>   
                           </td>
                           <td class="cr_min_width_200">
                           <input type="text" id="section_count2" name="section_count" placeholder="3-4" class="valuesai2 cr_width_full" value="3-4">  
                           </td>
                        </tr>
                        <tr>
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select what you want to do with sections in articles.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Add Sections To Content As:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <select autocomplete="off" class="valuesai2 cr_width_full" id="sections_role2" name="sections_role">
                           <option value="h2" selected><?php echo esc_html__("h2", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="h3"><?php echo esc_html__("h3", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="b"><?php echo esc_html__("Bold", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="i"><?php echo esc_html__("Italic", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="bi"><?php echo esc_html__("Bold and Italic", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="p"><?php echo esc_html__("Paragraph", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="x"><?php echo esc_html__("Plain Text", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="no"><?php echo esc_html__("Don't Add Sections", 'aiomatic-automatic-ai-content-writer');?></option>
                           </select>   
                           </td>
                        </tr>
                        <tr>
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Enter the number of paragraphs to create for each section. These will also be set as article headings. You can also set value ranges, example: 5-7. In this case, a random number will be selected in this range. Please use only numeric values in this field. This field will set the value of the %%paragraphs_per_section%% shortcode.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Number Of Paragraphs Per Section:", 'aiomatic-automatic-ai-content-writer');?></b>   
                           </td>
                           <td class="cr_min_width_200">
                           <input type="text" id="paragraph_count2" name="paragraph_count" placeholder="2-3" class="valuesai2 cr_width_full" value="2">  
                           </td>
                        </tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Set the number of related images to add to the created post content. This feature will use the royalty free image sources configured in the plugin's 'Settings' menu or if you have access to the DallE API. You can change image source in the 'AI Image Source' settings field from below. The maximum number of images you can add to each article: number of sections + 2", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Number of Images To Add To The Article:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="text" name="topic_images" id="topic_images2" value="" placeholder="Number of images" class="valuesai2 cr_width_full">
                           </td>
                        </tr>
                        <tr>
                           <td>
                              <div>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select if you want to add an image to each of the creating headings from the article.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Add An Image To Each Heading Of The Article:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="checkbox" id="img_all_headings2" name="img_all_headings" class="valuesai2" checked>
                           </td>
                        </tr> 
                        <tr>
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select the location of the heading images.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Heading Image Location:", 'aiomatic-automatic-ai-content-writer');?></b>   
                           </td>
                           <td class="cr_min_width_200">
                           <select autocomplete="off" id="heading_img_location2" name="heading_img_location" class="valuesai2 cr_width_full">
                              <option value="top" selected><?php echo esc_html__("Top of the section", 'aiomatic-automatic-ai-content-writer');?></option>
                              <option value="heading" selected><?php echo esc_html__("Under the heading text", 'aiomatic-automatic-ai-content-writer');?></option>
                              <option value="bottom"><?php echo esc_html__("Bottom of the section", 'aiomatic-automatic-ai-content-writer');?></option>
                              <option value="random"><?php echo esc_html__("Random (Top/Bottom)", 'aiomatic-automatic-ai-content-writer');?></option>
                           </select>   
                           </td>
                        </tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select if you would like to add the source YouTube video to the end of the created article.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Add The YouTube Video To The Article:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="checkbox" id="topic_videos2" name="topic_videos" class="valuesai2">
                           </td>
                        </tr>
                        <tr>
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Set the text of the outro section header. This is optional.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Article Outro Section Header Text:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="text" name="title_outro" id="title_outro2" value="{In Conclusion|To Conclude|In Summary|To Wrap It Up|Key Takeaways|Future Outlook|Closing Remarks|The Conclusion|Final Thoughts|In Retrospect|The Way Forward|Wrapping Up|Concluding Remarks|Insights and Conclusions}" placeholder="Optional" class="valuesai2 cr_width_full">
                           </td>
                        </tr> 
                        <tr>
                           <td class="hideTOC-1">
                              <div>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select if you want to add a Table of Contents section to the created post.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Add Article Table Of Contents:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td class="hideTOC-1">
                           <input type="checkbox" id="enable_toc2" name="enable_toc" class="valuesai2">
                           </td>
                        </tr> 
                        <tr>
                           <td class="hideTOC-1">
                              <div>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Set the text of the Table of Contents section header. Default is: Table of Contents", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Article Table Of Contents Section Header Text:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td class="hideTOC-1">
                           <input type="text" name="title_toc" id="title_toc2" value="Table of Contents" placeholder="Table of Contents" class="valuesai2 cr_width_full">
                           </td>
                        </tr> 
                        <tr>
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select if you want to add a Q&A section to the created post. To enable Q&A for articles, be sure to add a prompt also in the 'Article Q&A Prompt' settings field from below.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Add Article Q&A Section:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="checkbox" id="enable_qa2" name="enable_qa" class="valuesai2">
                           </td>
                        </tr> 
                        <tr>
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Set the text of the Q&A section header. Default is: Q&A", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Article Q&A Section Header Text:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="text" name="title_qa" id="title_qa2" value="Q&A" placeholder="Q&A" class="valuesai2 cr_width_full">
                           </td>
                        </tr> 
                        <tr><td colspan="2">
                              <h4><?php echo esc_html__("Content Parameters", 'aiomatic-automatic-ai-content-writer');?>:</h4>
                        </td></tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Set the language of the created content. This will set the value of the %%language%% shortcode, which can be used in prompts below. You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Content Language:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input id="content_language2" name="content_language" type="text" list="languages2" placeholder="Created content language" class="valuesai2 coderevolution_gutenberg_input" value="English"/>
<datalist id="languages2">
<?php
foreach($aiomatic_language_names as $ln)
{
echo '<option>' . $ln . '</option>';
}
?>
</datalist>
                           </td>
                        </tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Set the writing style of the created content. This will set the value of the %%writing_style%% shortcode, which can be used in prompts below. You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Writing Style:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input id="writing_style2" name="writing_style" type="text" placeholder="Created content writing style" list="writing_styles2" class="valuesai2 coderevolution_gutenberg_input" value="Creative"/>
                           <datalist id="writing_styles2">
<option>Informative</option>
<option>Academic</option>
<option>Descriptive</option>
<option>Detailed</option>
<option>Dramative</option>
<option>Fiction</option>
<option>Expository</option>
<option>Historical</option>
<option>Dialogue</option>
<option>Creative</option>
<option>Critical</option>
<option>Narrative</option>
<option>Persuasive</option>
<option>Reflective</option>
<option>Argumentative</option>
<option>Analytical</option>
<option>Blog</option>
<option>News</option>
<option>Casual</option>
<option>Pastoral</option>
<option>Personal</option>
<option>Poetic</option>
<option>Satirical</option>
<option>Sensory</option>
<option>Articulate</option>
<option>Monologue</option>
<option>Colloquial</option>
<option>Comparative</option>
<option>Concise</option>
<option>Biographical</option>
<option>Anecdotal</option>
<option>Evaluative</option>
<option>Letter</option>
<option>Lyrical</option>
<option>Simple</option>
<option>Vivid</option>
<option>Journalistic</option>
<option>Technical</option>
<option>Direct</option>
<option>Emotional</option>
<option>Metaphorical</option>
<option>Objective</option>
<option>Rhetorical</option>
<option>Theoretical</option>
<option>Business</option>
<option>Report</option>
<option>Research</option>
</datalist>
                           </td>
                        </tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Set the writing tone of the created content. This will set the value of the %%writing_tone%% shortcode, which can be used in prompts below. You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Writing Tone:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input id="writing_tone2" name="writing_tone" type="text" list="writing_tones3" placeholder="Created content writing tone" class="valuesai2 coderevolution_gutenberg_input" value="Neutral"/>
                           <datalist id="writing_tones3">
<option>Neutral</option>
<option>Formal</option>
<option>Assertive</option>
<option>Cheerful</option>
<option>Humorous</option>
<option>Informal</option>
<option>Inspirational</option>
<option>Professional</option>
<option>Emotional</option>
<option>Persuasive</option>
<option>Supportive</option>
<option>Sarcastic</option>
<option>Condescending</option>
<option>Skeptical</option>
<option>Narrative</option>
<option>Journalistic</option>
<option>Conversational</option>
<option>Factual</option>
<option>Friendly</option>
<option>Polite</option>
<option>Scientific</option>
<option>Sensitive</option>
<option>Sincere</option>
<option>Curious</option>
<option>Dissapointed</option>
<option>Encouraging</option>
<option>Optimistic</option>
<option>Surprised</option>
<option>Worried</option>
<option>Confident</option>
<option>Authoritative</option>
<option>Nostalgic</option>
<option>Sympathetic</option>
<option>Suspenseful</option>
<option>Romantic</option>
<option>Serious</option>
</datalist>
                           </td>
                        </tr>
                        <tr><td colspan="2">
                              <h4><?php echo esc_html__("Prompts", 'aiomatic-automatic-ai-content-writer');?>:</h4>
                        </td></tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Prompt to be used for the Post Title. You can use the following shortcodes: %%video_title%%, %%video_descripton%%, %%video_url%%, %%video_id%%, %%video_captions%%, %%language%%, %%writing_style%%, %%writing_tone%%, %%random_sentence%%, %%random_sentence2%%, %%blog_title%% - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators. You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Title Prompt:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <textarea rows="2" cols="70" name="title_prompt" id="title_prompt2" placeholder="Enter your title prompts, one per line" class="valuesai2 cr_width_full">Generate a title for a blog post discussing the topics covered in the YouTube video titled: "%%video_title%%", in %%language%% language. Style: %%writing_style%%. Tone: %%writing_tone%%. Must be between 40 and 60 characters.</textarea>
                           </td>
                        </tr>
                        <tr>
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select the AI Model to be used for the title generator.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("AI Model For Title Generator:", 'aiomatic-automatic-ai-content-writer');?></b>   
                           </td>
                           <td class="cr_min_width_200">
                           <select autocomplete="off" id="topic_title_model2" name="topic_title_model" class="hideAssistant2 valuesai2 cr_width_full">
                           <?php
foreach($all_models as $modelx)
{
echo '<option value="' . $modelx .'"';
echo '>' . esc_html($modelx) . esc_html(aiomatic_get_model_provider($modelx)) . '</option>';
}
?>
                           </select>   
                           </td>
                        </tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Prompt to be used for the intro of the article. You can use the following shortcodes: %%video_title%%, %%video_descripton%%, %%video_url%%, %%video_id%%, %%video_captions%%, %%language%%, %%writing_style%%, %%writing_tone%%, %%sections_count%%, %%random_sentence%%, %%random_sentence2%%, %%blog_title%% - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Article Intro Prompt:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <textarea rows="2" cols="70" name="intro_prompt" id="intro_prompt2" placeholder="Enter your intro prompts, one per line" class="valuesai2 cr_width_full">Write an introduction for a blog post which talks about the topics discussed in the YouTube video with the following title: "%%video_title%%", in %%language%%. Style: %%writing_style%%. Tone: %%writing_tone%%. The YouTube video has the following transcript: "%%video_captions%%"</textarea>
                           </td>
                        </tr>
                        <tr>
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select the AI Model to be used for the intro generator.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("AI Model For Intro Generator:", 'aiomatic-automatic-ai-content-writer');?></b>   
                           </td>
                           <td class="cr_min_width_200">
                           <select autocomplete="off" id="topic_intro_model2" name="topic_intro_model" class="hideAssistant2 valuesai2 cr_width_full">
                           <?php
foreach($all_models as $modelx)
{
echo '<option value="' . $modelx .'"';
echo '>' . esc_html($modelx) . esc_html(aiomatic_get_model_provider($modelx)) . '</option>';
}
?>
                           </select>   
                           </td>
                        </tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Prompt to be used for the Sections of the article. These will be set also as headings in the article. You can use the following shortcodes: %%video_title%%, %%video_descripton%%, %%video_url%%, %%video_id%%, %%video_captions%%, %%language%%, %%writing_style%%, %%writing_tone%%, %%sections_count%%, %%random_sentence%%, %%random_sentence2%%, %%blog_title%% - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Article Sections Prompt:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <textarea rows="2" cols="70" name="sections_prompt" id="sections_prompt2" placeholder="Enter your sections prompts, one per line" class="valuesai2 cr_width_full">Write %%sections_count%% consecutive headings that highlight specific aspects, provide detailed insights and specific recommendations for a blog post which talks about the topics discussed in the YouTube video with the following title: "%%video_title%%", in %%language%%. Style: %%writing_style%%. Tone: %%writing_tone%%. Don't add numbers to the headings, hyphens or any types of quotes. Return only the headings list, nothing else. Extract ideas from the following video transcript: "%%video_captions%%"</textarea>
                           </td>
                        </tr>
                        <tr>
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select the AI Model to be used for the sections generator.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("AI Model For Sections Generator:", 'aiomatic-automatic-ai-content-writer');?></b>   
                           </td>
                           <td class="cr_min_width_200">
                           <select autocomplete="off" id="topic_sections_model2" name="topic_sections_model" class="hideAssistant2 valuesai2 cr_width_full">
                           <?php
foreach($all_models as $modelx)
{
echo '<option value="' . $modelx .'"';
echo '>' . esc_html($modelx) . esc_html(aiomatic_get_model_provider($modelx)) . '</option>';
}
?>
                           </select>   
                           </td>
                        </tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Prompt to be used for the Content of the article, which will be applied to each section heading generated by the plugin (or entered manually) or to the entire content (depending how you select using the 'Use the Above Content Prompt To Create The Entire Article' checkbox). You can use the following shortcodes: %%video_title%%, %%video_descripton%%, %%video_url%%, %%video_id%%, %%video_captions%%, %%language%%, %%writing_style%%, %%writing_tone%%, %%sections%%, %%current_section%%, %%paragraphs_per_section%%, %%random_sentence%%, %%random_sentence2%%, %%blog_title%% - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Content Prompt:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <textarea rows="3" cols="70" name="content_prompt" id="content_prompt2" placeholder="Enter your content prompt" class="valuesai2 cr_width_full">Write the content of a post section for the heading "%%current_section%%" in %%language%%. The title of the post is: "%%video_title%%". Don't repeat the heading in the created content. Don't add an intro or outro. Be creative and unique. Write %%paragraphs_per_section%% paragraphs in the section. Use HTML for formatting, include unnumbered lists and bold. If needed, you can use WordPress related CSS styling for the article. When applicable, add also HTML tables with WordPress styling (you can use WordPress table classes). If added, table data must be relevant, creative, short and simple. Writing Style: %%writing_style%%. Tone: %%writing_tone%%. Extract content from the following video transcript: "%%video_captions%%"</textarea>
                           </td>
                        </tr>
                        <tr>
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select the AI Model to be used for the content generator.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("AI Model For Content Generator:", 'aiomatic-automatic-ai-content-writer');?></b>   
                           </td>
                           <td class="cr_min_width_200">
                           <select autocomplete="off" id="topic_content_model2" name="topic_content_model" class="hideAssistant2 valuesai2 cr_width_full">
                           <?php
foreach($all_models as $modelx)
{
echo '<option value="' . $modelx .'"';
echo '>' . esc_html($modelx) . esc_html(aiomatic_get_model_provider($modelx)) . '</option>';
}
?>
                           </select>   
                           </td>
                        </tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select if you want to use the above content prompt to create the entire article from a single API call (checkbox checked) or to run the prompt for each section separately (checkbox unchecked). If you check this, be sure to modify the content prompt accordingly.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Use the Above Content Prompt To Create The Entire Article (Not Each Section):", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="checkbox" id="single_content_call-12" name="single_content_call" onclick="hideTOC(-1);" class="valuesai2">
                           </td>
                        </tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Prompt to be used for the Q&A of the article. You can use the following shortcodes: %%language%%, %%writing_style%%, %%writing_tone%%, %%sections_count%%, %%random_sentence%%, %%random_sentence2%%, %%blog_title%% - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Article Q&A Prompt:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <textarea rows="2" cols="70" name="qa_prompt" id="qa_prompt2" placeholder="Enter your Q&A prompts, one per line" class="valuesai2 cr_width_full">Write a Q&A for a blog post which talks about the topics discussed in the YouTube video with the following title: "%%video_title%%", in %%language%%. Style: %%writing_style%%. Tone: %%writing_tone%%. The YouTube video has the following transcript: "%%video_captions%%"</textarea>
                           </td>
                        </tr>
                        <tr>
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select the AI Model to be used for the Q&A generator.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("AI Model For Q&A Generator:", 'aiomatic-automatic-ai-content-writer');?></b>   
                           </td>
                           <td class="cr_min_width_200">
                           <select autocomplete="off" id="topic_qa_model2" name="topic_qa_model" class="hideAssistant2 valuesai2 cr_width_full">
                           <?php
foreach($all_models as $modelx)
{
echo '<option value="' . $modelx .'"';
echo '>' . esc_html($modelx) . esc_html(aiomatic_get_model_provider($modelx)) . '</option>';
}
?>
                           </select>   
                           </td>
                        </tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Prompt to be used for the outro of the article. You can use the following shortcodes: %%video_title%%, %%video_descripton%%, %%video_url%%, %%video_id%%, %%video_captions%%, %%language%%, %%writing_style%%, %%writing_tone%%, %%sections_count%%, %%random_sentence%%, %%random_sentence2%%, %%blog_title%% - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Article Outro Prompt:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <textarea rows="2" cols="70" name="outro_prompt" id="outro_prompt2" placeholder="Enter your outro prompts, one per line" class="valuesai2 cr_width_full">Write an outro for a blog post which talks about the topics discussed in the YouTube video with the following title: "%%video_title%%", in %%language%%. Style: %%writing_style%%. Tone: %%writing_tone%%. The YouTube video has the following transcript: "%%video_captions%%"</textarea>
                           </td>
                        </tr>
                        <tr>
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select the AI Model to be used for the outro generator.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("AI Model For Outro Generator:", 'aiomatic-automatic-ai-content-writer');?></b>   
                           </td>
                           <td class="cr_min_width_200">
                           <select autocomplete="off" id="topic_outro_model2" name="topic_outro_model" class="hideAssistant2 valuesai2 cr_width_full">
                           <?php
foreach($all_models as $modelx)
{
echo '<option value="' . $modelx .'"';
echo '>' . esc_html($modelx) . esc_html(aiomatic_get_model_provider($modelx)) . '</option>';
}
?>
                           </select>   
                           </td>
                        </tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Prompt to be used for the excerpt of the article. You can use the following shortcodes: %%video_title%%, %%video_descripton%%, %%video_url%%, %%video_id%%, %%video_captions%%, %%language%%, %%writing_style%%, %%writing_tone%%, %%sections%%, %%random_sentence%%, %%random_sentence2%%, %%blog_title%% - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Excerpt Prompt:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <textarea rows="2" cols="70" name="excerpt_prompt" id="excerpt_prompt2" placeholder="Enter your excerpt prompts, one per line" class="valuesai2 cr_width_full">Write a short excerpt for a blog post which talks about the topics discussed in the YouTube video with the following title: "%%video_title%%" in %%language%%. Style: %%writing_style%%. Tone: %%writing_tone%%. Must be between 150 and 250 characters. The YouTube video has the following transcript: "%%video_captions%%"</textarea>
                           </td>
                        </tr>
                        <tr>
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select the AI Model to be used for the excerpt generator.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("AI Model For Excerpt Generator:", 'aiomatic-automatic-ai-content-writer');?></b>   
                           </td>
                           <td class="cr_min_width_200">
                           <select autocomplete="off" id="topic_excerpt_model2" name="topic_excerpt_model" class="hideAssistant2 valuesai2 cr_width_full">
                           <?php
foreach($all_models as $modelx)
{
echo '<option value="' . $modelx .'"';
echo '>' . esc_html($modelx) . esc_html(aiomatic_get_model_provider($modelx)) . '</option>';
}
?>
                           </select>   
                           </td>
                        </tr>
                        <tr><td colspan="2">
                              <h4><?php echo esc_html__("Advanced Prompting Options", 'aiomatic-automatic-ai-content-writer');?>:</h4>
                        </td></tr>
                        <tr>
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Run regex on prompts. To disable this feature, leave this field blank. No Regex separators are required here. You can add multiple Regex expressions, each on a different line.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Run Regex On Prompts:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <textarea rows="1" name="strip_by_regex_prompts" id="strip_by_regex_prompts2" placeholder="regex expression" class="valuesai2 cr_width_full"></textarea>
                           </td>
                        </tr>
                        <tr>
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Replace the above regex matches with this regex expression. If you want to strip matched content, leave this field blank. No Regex separators are required here. You can add multiple replacement expressions, each on a different line.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Replace Matches From Regex (Prompts):", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <textarea rows="1" name="replace_regex_prompts" id="replace_regex_prompts2" placeholder="regex replacement" class="valuesai2 cr_width_full"></textarea>
                           </td>
                        </tr>
                        <tr>
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select on which prompts do you want to run the above Regex. Possible values are (or any of their combinations): title, intro, sections, content, outro, excerpt", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Run Above Regex On Prompts:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input id="run_regex_on2" name="run_regex_on" type="text" list="run_regex_on_list3" class="valuesai2 coderevolution_gutenberg_input" value="content"/>
<datalist id="run_regex_on_list3">
<option value="title">title</option>
<option value="intro">intro</option>
<option value="sections">sections</option>
<option value="content">content</option>
<option value="qa">Q&A</option>
<option value="outro">outro</option>
<option value="excerpt">excerpt</option>
</datalist> 
                           </td>
                        </tr>
                     <tr><td colspan="2">
                              <h3><?php echo esc_html__("Global Prompt Options", 'aiomatic-automatic-ai-content-writer');?>:</h3>
                        </td></tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("This will be prepended to each prompt sent by the plugin to the AI writer. You can use the following shortcodes: %%topic%%, %%language%%, %%writing_style%%, %%writing_tone%%, %%title%%, %%random_sentence%%, %%random_sentence2%%, %%post_original_title%%, %%blog_title%% - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators. You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Prepend Text To All Textual AI Prompts:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <textarea rows="2" cols="70" name="global_prepend" id="global_prepend2" placeholder="Global prompt prepend text" class="valuesai2 cr_width_full"></textarea>
                           </td>
                        </tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("This will be appended to each prompt sent by the plugin to the AI writer. You can use the following shortcodes: %%topic%%, %%language%%, %%writing_style%%, %%writing_tone%%, %%title%%, %%random_sentence%%, %%random_sentence2%%, %%post_original_title%%, %%blog_title%% - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators. You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Append Text To All Textual AI Prompts:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <textarea rows="2" cols="70" name="global_append" id="global_append2" placeholder="Global prompt append text" class="valuesai2 cr_width_full"></textarea>
                           </td>
                        </tr>
                     <tr><td colspan="2">
                              <h3><?php echo esc_html__("Automatic Linking Options", 'aiomatic-automatic-ai-content-writer');?>:</h3>
                        </td></tr>
                        <tr>
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select the linking method to use in posts.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Automatic Linking Type:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <select autocomplete="off" class="valuesai2 cr_width_full" id="link_type2" onchange="hideLinks('');" name="link_type">
                           <option value="disabled" selected><?php echo esc_html__("Disabled", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="internal"><?php echo esc_html__("Internal Links", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="manual"><?php echo esc_html__("Manual Links", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="mixed"><?php echo esc_html__("Mixed Links", 'aiomatic-automatic-ai-content-writer');?></option>
                           </select>   
                           </td>
                        </tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Set the maximum number of automatic links to add to created posts. You can also define custom ranges, like: 3-5. Please note that this feature will work best if you already have a considerable number of posts published on your site, which will be used for internal linking.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Maximum Number Of Automatic Links To Add To The Post Content:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="text" name="max_links" id="max_links2" placeholder="3-5" class="valuesai2 cr_width_full">
                           </td>
                        </tr>
                        <tr class="hidelinks">
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Enter a manual list of links, where the plugin will create links.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Manual List Of URLs (One Per Line):", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <textarea rows="1" cols="70" name="link_list" id="link_list2" placeholder="URL list (one per line)" class="valuesai2 cr_width_full"></textarea>
                           </td>
                        </tr>
                        <tr class="hidelinks">
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Do you want to add nofollow attribute to manually entered, external links?", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Add Nofollow Attribute To Manual Links:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="checkbox" id="link_nofollow2" name="link_nofollow" class="valuesai2">
                           </td>
                        </tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Set the post types where to create automatic links in posts. You can also add a comma separated list of multiple post types.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Post Types Where To Generate Automatic Links:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="text" name="link_post_types" id="link_post_types2" placeholder="post" class="valuesai2 cr_width_full">
                           </td>
                        </tr>
                     <tr><td colspan="2">
                              <h3><?php echo esc_html__("Advanced AI Text Generator Options", 'aiomatic-automatic-ai-content-writer');?>:</h3>
                        </td></tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Set the maximum number of API tokens to use with each request. This will define the length of the resulting API response. Each token usually consists of approximately 4 characters. Note that in this value the number of tokens sent to the API as an article prompt will also be counted. The maximum amount which can be set is 4000. For other models, the maximum is 2048.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Maximum Total Token Count To Use Per API Request:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="number" min="1" max="128000" name="max_tokens" id="max_tokens2" value="" placeholder="2048" class="valuesai2 cr_width_full">
                           </td>
                        </tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Set the maximum number of prompt API tokens to use with each request. This will define the length of the resulting API response. Each token usually consists of approximately 4 characters. This defines how much content does the API receive each time you call it. If the API gets more initial data, better quality results will be expected. The maximum amount which can be set is 1000.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Maximum Prompt Token Count To Use Per API Request:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="number" min="1" max="128000" name="max_seed_tokens" id="max_seed_tokens2" value="" placeholder="1000" class="valuesai2 cr_width_full">
                           </td>
                        </tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Set the maximum number of continue API tokens to use with each request. This will define the length of the resulting API response. Each token usually consists of approximately 4 characters. This defines how much content does the API receive each time you call it. If the API gets more initial data, better quality results will be expected. The maximum amount which can be set is 500.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Maximum Continue Token Count To Use Per API Request:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="number" min="1" max="128000" name="max_continue_tokens" id="max_continue_tokens2" value="" placeholder="500" class="valuesai2 cr_width_full">
                           </td>
                        </tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("What sampling temperature to use. Higher values means the model will take more risks. Try 0.9 for more creative applications, and 0 (argmax sampling) for ones with a well-defined answer. We generally recommend altering this or top_p but not both.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("AI Temperature:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="number" min="0" step="0.1" max="2" name="temperature" id="temperature2" value="" placeholder="1" class="valuesai2 cr_width_full">
                           </td>
                        </tr><tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("An alternative to sampling with temperature, called nucleus sampling, where the model considers the results of the tokens with top_p probability mass. So 0.1 means only the tokens comprising the top 10% probability mass are considered. We generally recommend altering this or temperature but not both.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("AI Top_p:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="number" min="0" max="1" step="0.1" name="top_p" id="top_p2" value="" placeholder="1" class="valuesai2 cr_width_full">
                           </td>
                        </tr><tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Number between -2.0 and 2.0. Positive values penalize new tokens based on whether they appear in the text so far, increasing the model's likelihood to talk about new topics.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("AI Presence Penalty:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="number" min="-2" step="0.1" max="2" name="presence_penalty" id="presence_penalty2" value="" placeholder="0" class="valuesai2 cr_width_full">
                           </td>
                        </tr><tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Number between -2.0 and 2.0. Positive values penalize new tokens based on their existing frequency in the text so far, decreasing the model's likelihood to repeat the same line verbatim.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("AI Frequency Penalty:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="number" min="0" max="2" step="0.1" name="frequency_penalty" id="frequency_penalty2" value="" placeholder="0" class="valuesai2 cr_width_full">
                           </td>
                        </tr>
                     <tr><td colspan="2">
                              <h3><?php echo esc_html__("Image Generator Options", 'aiomatic-automatic-ai-content-writer');?>:</h3>
                        </td></tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select the search query repetition mode, when searching royalty free images.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Search Query Repetition:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <select autocomplete="off" id="search_query_repetition2" name="search_query_repetition" class="valuesai2 cr_width_full">
                              <option value="0" selected><?php echo esc_html__("Use Different Search Queries For Images", 'aiomatic-automatic-ai-content-writer');?></option>
                              <option value="1"><?php echo esc_html__("Use The Same Search Query For Images", 'aiomatic-automatic-ai-content-writer');?></option>
                           </select>
                           </td>
                        </tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Do you want to enable the AI Image Generator and to replace Royalty Free Images with AI generated images? If you select 'Default Featured Image List', you can add the image URLs in the 'Default Featured Image List' settings field.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Article Image Source:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <select autocomplete="off" id="enable_ai_images2" onchange="hideImage('2');" name="enable_ai_images" class="valuesai2 cr_width_full">
                              <option value="0" selected><?php echo esc_html__("Royalty Free", 'aiomatic-automatic-ai-content-writer');?></option>
                              <option value="1"><?php echo esc_html__("OpenAI/AiomaticAPI", 'aiomatic-automatic-ai-content-writer');?></option>
                              <?php
                              if (isset($aiomatic_Main_Settings['stability_app_id']) && trim($aiomatic_Main_Settings['stability_app_id']) != '')
                              {
                              ?>
                              <option value="2"><?php echo esc_html__("Stability.AI", 'aiomatic-automatic-ai-content-writer');?></option>
                              <?php
                              }
                              ?>
                           </select>
                           </td>
                        </tr>
                        <tr class="hideImg2 cr_none">
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Set list of prompt commands (one on each line) you want to send to the AI image generator. This command can be any given task or order, based on which, it will generate images. You can use the following shortcodes here: %%post_title%%, %%random_sentence%%, %%random_sentence2%%, %%blog_title%%. The length of this command should not be greater than 1000 characters, otherwise the plugin will strip it to 1000 characters length. - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You can also add here a link to a .txt file, where you can add multiple prompts (one per line) and the plugin will select a random one at each run. You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators. You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                          echo '&nbsp;' . sprintf( wp_kses( __( "Please check some tips and tricks about writing prompt commands, <a href='%s' target='_blank'>here</a>. The [aicontent] shortcode is able to be used also here.", 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), 'https://coderevolution.ro/knowledge-base/faq/how-to-create-a-good-seed-prompt-command-for-aiomatic-image-generating-for-openai-dall-e-api/' );
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Prompt For The AI Image Generator:", 'aiomatic-automatic-ai-content-writer');?></b>&nbsp;<b><a href="https://coderevolution.ro/knowledge-base/faq/how-to-create-a-good-seed-prompt-command-for-aiomatic-image-generating-for-openai-dall-e-api/" target="_blank">&#9432;</a></b>
                           </td>
                           <td>
                           <textarea rows="2" cols="70" name="ai_command_image" id="ai_command_image2" placeholder="Please insert a command for the AI image generator" class="valuesai2 cr_width_full">Generate a high-resolution, visually compelling image that creatively interprets the theme encapsulated by this post title: "%%post_title%%". The image should be versatile enough to fit various niches, from technology and lifestyle to nature and science. It should feature a central, eye-catching element that abstractly represents the topic, surrounded by relevant, subtler motifs that provide context and depth. The composition should be balanced and aesthetically pleasing, with a harmonious color palette that complements the mood of the title. The artwork should be suitable for use as a captivating header image for a blog post.</textarea>
                           </td>
                        </tr>
                        <tr class="hideDalle2 cr_none">
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select the AI model you wish to use for image the image generator.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("AI Image Model:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <select autocomplete="off" id="image_model2" name="image_model" class="valuesai2 cr_width_full">
                              <option value="dalle2"selected><?php echo esc_html__("Dall-E 2", 'aiomatic-automatic-ai-content-writer');?></option>
                              <option value="dalle3"><?php echo esc_html__("Dall-E 3", 'aiomatic-automatic-ai-content-writer');?></option>
                              <option value="dalle3hd"><?php echo esc_html__("Dall-E 3 HD", 'aiomatic-automatic-ai-content-writer');?></option>
                           </select>
                           </td>
                        </tr>
                        <tr class="hideImg2 cr_none">
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select the size of the generated image.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Generated Image Size:", 'aiomatic-automatic-ai-content-writer');?></b>   
                           </td>
                           <td class="cr_min_width_200">
                           <select autocomplete="off" id="model2" name="image_size" class="valuesai2 cr_width_full">
                              <option value="256x256"><?php echo esc_html__("256x256", 'aiomatic-automatic-ai-content-writer');?></option>
                              <option value="512x512"><?php echo esc_html__("512x512", 'aiomatic-automatic-ai-content-writer');?></option>
                              <option value="1024x1024" selected><?php echo esc_html__("1024x1024", 'aiomatic-automatic-ai-content-writer');?></option>
                           </select>  
                           </td>
                        </tr>
                        <tr><td colspan="2">
                              <h3><?php echo esc_html__("Posting Options", 'aiomatic-automatic-ai-content-writer');?>:</h3>
                        </td></tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Enter a HTML text that should be prepended to the AI generated content in each created post. You can use the following shortcodes: %%custom_html%%, %%custom_html2%%, %%video_title%%, %%video_descripton%%, %%video_url%%, %%video_id%%, %%video_captions%%, %%language%%, %%writing_style%%, %%writing_tone%%, %%sections_count%%, %%random_sentence%%, %%random_sentence2%%, %%blog_title%%, %%random_image[keyword]%%, %%random_image_url[keyword]%%, %%random_video[keyword]%%, %%royalty_free_image_attribution%% - you can also use an optional parameter in the random_image and random_video shortcodes, which will add a percentage chance for the media to appear or not - example: %%random_video[keyword][60]%% - a video will appear in 60% of cases, in the rest of 40%, nothing will be returned by the shortcode - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("HTML Text To Prepend To AI Created Content:", 'aiomatic-automatic-ai-content-writer');?></b>&nbsp;<b><a href="https://coderevolution.ro/knowledge-base/faq/post-template-reference-advanced-usage/" target="_blank">&#9432;</a></b>
                           </td>
                           <td>
                           <textarea rows="2" cols="70" name="post_prepend" id="post_prepend2" placeholder="HTML content to prepend to the AI generated content" class="valuesai2 cr_width_full"></textarea>
                           </td>
                        </tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Enter a HTML text that should be appended to the AI generated content in each created post. You can use the following shortcodes: %%custom_html%%, %%custom_html2%%, %%video_title%%, %%video_descripton%%, %%video_url%%, %%video_id%%, %%video_captions%%, %%language%%, %%writing_style%%, %%writing_tone%%, %%sections_count%%, %%random_sentence%%, %%random_sentence2%%, %%blog_title%%, %%random_image[keyword]%%, %%random_image_url[keyword]%%, %%random_video[keyword]%%, %%royalty_free_image_attribution%% - you can also use an optional parameter in the random_image and random_video shortcodes, which will add a percentage chance for the media to appear or not - example: %%random_video[keyword][60]%% - a video will appear in 60% of cases, in the rest of 40%, nothing will be returned by the shortcode - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("HTML Text To Append To AI Created Content:", 'aiomatic-automatic-ai-content-writer');?></b>&nbsp;<b><a href="https://coderevolution.ro/knowledge-base/faq/post-template-reference-advanced-usage/" target="_blank">&#9432;</a></b>
                           </td>
                           <td>
                           <textarea rows="2" cols="70" name="post_append" id="post_append2" placeholder="HTML content to append to the AI generated content" class="valuesai2 cr_width_full"></textarea>
                           </td>
                        </tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Custom AI generated content shortcode creator. If you wish to create content from multiple AI prompts, and use them in post content/post custom fields/taxonomies, you can configure this from here. Also, these shortcodes will be able to be used in custom fields or custom taxonomies which the plugin will create. Syntax for this field: shortcode_name => AI_MODEL_TO_USE @@ TEXTUAL_PROMPT_TO_USE (to specify multiple shortcodes and crawling values, separate them by a new line. Example: my_custom_shortcode => gpt-3.5-turbo-instruct @@ Write a short poem. Afterwards, you can use shortcodes in any settings field that supports shortcodes (ex: 'HTML Text To Append To AI Created Content' settings field), like this: %%my_custom_shortcode%%. Official format is %%name_of_custom_shortcode%%", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Custom Shortcode Creator (Optional):", 'aiomatic-automatic-ai-content-writer');?></b><span class="tool" data-tip="Supported models: <?php echo implode(',', aiomatic_get_all_models());?>">&nbsp;&#9432;</span>
                           </td>
                           <td>
                           <textarea rows="2" cols="70" name="custom_shortcodes" id="custom_shortcodes2" placeholder="shortcode_name => AI_MODEL @@ AI_PROMPT" class="valuesai2 cr_width_full"></textarea>
                           </td>
                        </tr>
                        <tr>
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("The AI writer might add the title of the post to the created post content. Check this checkbox if you want to remove the title from the post content.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Strip Title From Content:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="checkbox" id="strip_title2" name="strip_title" class="valuesai2">
                           </td>
                        </tr>
                        <tr>
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px"><?php echo esc_html__("Do you want to skip spinning of posts generated by this rule?", 'aiomatic-automatic-ai-content-writer');?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Do Not Spin Posts Generated By This Rule:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="checkbox" id="skip_spin2" name="skip_spin" class="valuesai2">               
                           </td>
                        </tr>
                        <tr>
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px"><?php echo esc_html__("Do you want to skip translating of posts generated by this rule?", 'aiomatic-automatic-ai-content-writer');?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Do Not Translate Posts Generated By This Rule:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="checkbox" id="skip_translate2" name="skip_translate" class="valuesai2">               
                           </td>
                        </tr>
                        <tr>
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select if you want to process added YouTube videos in order of entry or in random order.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Process Videos In Order Of Entry:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="checkbox" id="no_random2" name="no_random" class="valuesai2">
                           </td>
                        </tr>
                        <tr>
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Run regex on post content. To disable this feature, leave this field blank. No Regex separators are required here. You can add multiple Regex expressions, each on a different line.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Run Regex On Content:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <textarea rows="1" name="strip_by_regex" id="strip_by_regex2" placeholder="regex expression" class="valuesai2 cr_width_full"></textarea>
                           </td>
                        </tr>
                        <tr>
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Replace the above regex matches with this regex expression. If you want to strip matched content, leave this field blank. No Regex separators are required here. You can add multiple replacement expressions, each on a different line.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Replace Matches From Regex (Content):", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <textarea rows="1" name="replace_regex" id="replace_regex2" placeholder="regex replacement" class="valuesai2 cr_width_full"></textarea>
                           </td>
                        </tr>
                     </table>
                  </div>
               </div>
               <div class="codemodalfzr-footer">
                  <br/>
                  <h3 class="cr_inline">Aiomatic Automatic Post Generator</h3>
                  <span id="aiomatic_ok2" class="codeokfzr cr_inline">OK&nbsp;</span>
                  <br/><br/>
               </div>
            </div>
         </div>




   <div id="mymodalfzr3" class="codemodalfzr">
            <div class="codemodalfzr-content">
               <div class="codemodalfzr-header">
                  <span id="aiomatic_close3" class="codeclosefzr">&times;</span>
                  <h2><span class="cr_color_white"><?php echo esc_html__("Amazon Product Roundup", 'aiomatic-automatic-ai-content-writer');?></span> <?php echo esc_html__("Advanced Settings", 'aiomatic-automatic-ai-content-writer');?></h2>
               </div>
               <div class="codemodalfzr-body">
                  <div class="table-responsive">
                     <table class="responsive table cr_main_table_nowr">
                     <tr><td colspan="2">
                           <h3><?php echo esc_html__("AI Assistant Options", 'aiomatic-automatic-ai-content-writer');?>:</h3>
                     </td></tr>
                     <tr>
                        <td class="cr_min_width_200">
                              <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                 <div class="bws_hidden_help_text cr_min_260px">
                                    <?php
                                       echo esc_html__("Select the AI Assistant to use for content creation. This will disable the ability to select AI models, as the models assisgned to the assistant will be used for content creation.", 'aiomatic-automatic-ai-content-writer');
                                       ?>
                                 </div>
                              </div>
                              <b><?php echo esc_html__("AI Assistant Name:", 'aiomatic-automatic-ai-content-writer');?></b>
                        </td>
                        <td><select id="assistant_id3" name="assistant_id" class="valuesai3 cr_width_full" onchange="assistantSelected('3');">
<?php
if($all_assistants === false)
{
echo '<option val="" selected disabled>' . esc_html__("Only OpenAI API is supported for Assistants API", 'aiomatic-automatic-ai-content-writer') . '</option>';
}
else
{
if(count($all_assistants) == 0)
{
echo '<option val="" selected disabled>' . esc_html__("No Assistans added, go to the plugin's 'AI Assistans' menu to add new assistants!", 'aiomatic-automatic-ai-content-writer') . '</option>';
}
else
{
echo '<option value="" selected';
echo '>' . esc_html__("Don't use assistants, use AI models instead", 'aiomatic-automatic-ai-content-writer') . '</option>';
foreach($all_assistants as $myassistant)
{
echo '<option value="' . $myassistant->ID .'"';
echo '>' . esc_html($myassistant->post_title);
echo '</option>';
}
}
}
?>
</select>  
                        </td>
                     </tr>
                        <tr><td colspan="2">
                              <h3><?php echo esc_html__("Amazon Search Options", 'aiomatic-automatic-ai-content-writer');?>:</h3>
                        </td></tr>
                        <tr>
                           <td>
                              <div>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo sprintf( wp_kses( __( "Insert your Amazon Associate ID (Optional). Learn how to get one <a href='%s' target='_blank'>here</a>. Also, you need to sign up for Amazon Affiliate program <a href='%s' target='_blank'>here</a>.", 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), 'https://affiliate-program.amazon.com/gp/advertising/api/detail/main.html', 'https://affiliate-program.amazon.com/assoc_credentials/home' );
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Amazon Associate ID (Optional):", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="text" name="affiliate_id" id="affiliate_id3" value="" placeholder="Please insert your Amazon Affiliate ID" class="valuesai3 cr_width_full">   
                           </td>
                        </tr>
                        <tr>
                           <td>
                              <div>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select the country where you have registred your affiliate account.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Amazon Target Country:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                        <select id="source3" name="target_country" class="valuesai3 cr_width_full">
                        <?php
                           $amaz_countries = aiomatic_get_amazon_codes();
                           foreach ($amaz_countries as $key => $value) {
                              echo '<option value="' . esc_html($key) . '">' . esc_html($value) . '</option>';
                           }
                           ?>
                        </select>  
                           </td>
                        </tr>
                        <tr>
                           <td class="cr_min_width_200">
                              <div>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Do you want to set a minimum price for the imported item? Price is in pennies: 1000 is 10$.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Min Price in Pennies:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="number" min="0" step="1" id="min_price3" name="min_price" class="valuesai3 cr_width_full" placeholder="Input the minimum price in pennies">
                           </td>
                        </tr>
                        <tr>
                           <td>
                              <div>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Do you want to set a maximum price for the imported item? Price is in pennies: 1000 is 10$.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Max Price in Pennies:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="number" min="0" step="1" id="max_price3" name="max_price" class="valuesai3 cr_width_full" placeholder="Input the maximum price in pennies">
                           </td>
                        </tr>
                        <tr>
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Enter the maximum number of products to include in the product roundup article. You can also enter number ranges like: 3-4", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Max Number Of Products To Include:", 'aiomatic-automatic-ai-content-writer');?></b>   
                           </td>
                           <td class="cr_min_width_200">
                           <input type="text" id="max_products3" name="max_products" placeholder="3-4" class="valuesai3 cr_width_full" value="3-4">  
                           </td>
                        </tr>
                        <tr>
                           <td class="cr_min_width_200">
                              <div>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select the type of sorting of the returned results. This will work only if you also set a value to the 'Amazon Category' settings field.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Sort Results By:", 'aiomatic-automatic-ai-content-writer');?></b>   
                           </td>
                           <td class="cr_min_width_200">
                           <select id="sort_results3" name="sort_results" class="valuesai3 cr_width_full">
                           <option value="none" selected><?php echo esc_html__("None", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="Relevance"><?php echo esc_html__("Relevance", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="Price:LowToHigh"><?php echo esc_html__("Price:LowToHigh", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="Price:HighToLow"><?php echo esc_html__("Price:HighToLow", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="NewestArrivals"><?php echo esc_html__("NewestArrivals", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="Featured"><?php echo esc_html__("Featured", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="AvgCustomerReviews"><?php echo esc_html__("AvgCustomerReviews", 'aiomatic-automatic-ai-content-writer');?></option>
                           </select>    
                           </td>
                        </tr>
                        <tr>
                           <td>
                              <div>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("If enabled, the products will be shuffled, randomizing their order on each run.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Randomize Product Order:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="checkbox" id="shuffle_products3" name="shuffle_products" class="valuesai3" checked>
                           </td>
                        </tr> 
                        <tr><td colspan="2">
                              <h3><?php echo esc_html__("AI Writer Options", 'aiomatic-automatic-ai-content-writer');?>:</h3>
                        </td></tr>
                        <tr>
                           <td>
                              <div>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("If enabled, the article will be written from a perspective that sometimes can make it sound like the writer has first-hand experience with the products.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Enable First-Hand Experience:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="checkbox" id="first_hand3" name="first_hand" class="valuesai3">
                           </td>
                        </tr> 
                        <tr>
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select what you want to do with product titles in articles.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Add Product Titles To Content As:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <select autocomplete="off" class="valuesai3 cr_width_full" id="sections_role3" name="sections_role">
                           <option value="h2" selected><?php echo esc_html__("h2", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="h3"><?php echo esc_html__("h3", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="b"><?php echo esc_html__("Bold", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="i"><?php echo esc_html__("Italic", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="bi"><?php echo esc_html__("Bold and Italic", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="p"><?php echo esc_html__("Paragraph", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="x"><?php echo esc_html__("Plain Text", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="no"><?php echo esc_html__("Don't Add Sections", 'aiomatic-automatic-ai-content-writer');?></option>
                           </select>   
                           </td>
                        </tr>
                        <tr>
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Enter the number of paragraphs to create for each section. These will also be set as article headings. You can also set value ranges, example: 5-7. In this case, a random number will be selected in this range. Please use only numeric values in this field. This field will set the value of the %%paragraphs_per_section%% shortcode.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Number Of Paragraphs Per Section:", 'aiomatic-automatic-ai-content-writer');?></b>   
                           </td>
                           <td class="cr_min_width_200">
                           <input type="text" id="paragraph_count3" name="paragraph_count" placeholder="2-3" class="valuesai3 cr_width_full" value="2">  
                           </td>
                        </tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select if you want to add the product images to the article.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Add Product Images To The Article:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="checkbox" id="topic_images3" name="topic_images" class="valuesai3" checked>
                           </td>
                        </tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select if you don't want to add the product links directly to headings.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Don't Add Product Links to Headings:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="checkbox" id="no_headlink3" name="no_headlink" class="valuesai3">
                           </td>
                        </tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select if you would like to add a relevant YouTube video to the end of the created article.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Add A Relevant YouTube Video To The Article:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="checkbox" id="topic_videos3" name="topic_videos" class="valuesai3">
                           </td>
                        </tr>
                        <tr>
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Set the text of the outro section header. This is optional.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Article Outro Section Header Text:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="text" name="title_outro" id="title_outro3" value="{Experience the Difference|Unlock Your Potential|Elevate Your Lifestyle|Embrace a New Era|Seize the Opportunity|Discover the Power|Transform Your World|Unleash Your True Potential|Embody Excellence|Achieve New Heights|Experience Innovation|Ignite Your Passion|Reveal the Extraordinary}" placeholder="Optional" class="valuesai3 cr_width_full">
                           </td>
                        </tr> 
                        <tr>
                           <td class="hideTOC-1">
                              <div>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select if you want to add a Table of Contents section to the created post.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Add Article 'Table Of Contents':", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td class="hideTOC-1">
                           <input type="checkbox" id="enable_toc3" name="enable_toc" class="valuesai3">
                           </td>
                        </tr> 
                        <tr>
                           <td class="hideTOC-1">
                              <div>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Set the text of the Table of Contents section header. Default is: Table of Contents", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Article 'Table Of Contents' Section Header Text:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td class="hideTOC-1">
                           <input type="text" name="title_toc" id="title_toc3" value="Table of Contents" placeholder="Table of Contents" class="valuesai3 cr_width_full">
                           </td>
                        </tr> 
                        <tr>
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select if you want to add a Q&A section to the created post. To enable Q&A for articles, be sure to add a prompt also in the 'Article Q&A Prompt' settings field from below.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Add Article 'Q&A' Section:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="checkbox" id="enable_qa3" name="enable_qa" class="valuesai3">
                           </td>
                        </tr> 
                        <tr>
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Set the text of the Q&A section header. Default is: Q&A", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Article 'Q&A' Section Header Text:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="text" name="title_qa" id="title_qa3" value="Q&A" placeholder="Q&A" class="valuesai3 cr_width_full">
                           </td>
                        </tr> 
                        <tr>
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select if you want to add a product comparison table to the created article.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Add Product Comparison Table:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="checkbox" id="enable_table3" name="enable_table" class="valuesai3">
                           </td>
                        </tr> 
                        <tr><td colspan="2">
                              <h4><?php echo esc_html__("Content Parameters", 'aiomatic-automatic-ai-content-writer');?>:</h4>
                        </td></tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Set the language of the created content. This will set the value of the %%language%% shortcode, which can be used in prompts below. You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Content Language:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input id="content_language3" name="content_language" type="text" list="languages4" placeholder="Created content language" class="valuesai3 coderevolution_gutenberg_input" value="English"/>
<datalist id="languages4">
<?php
foreach($aiomatic_language_names as $ln)
{
echo '<option>' . $ln . '</option>';
}
?>
</datalist>
                           </td>
                        </tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Set the writing style of the created content. This will set the value of the %%writing_style%% shortcode, which can be used in prompts below. You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Writing Style:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input id="writing_style3" name="writing_style" type="text" placeholder="Created content writing style" list="writing_styles4" class="valuesai3 coderevolution_gutenberg_input" value="Creative"/>
                           <datalist id="writing_styles4">
<option>Informative</option>
<option>Academic</option>
<option>Descriptive</option>
<option>Detailed</option>
<option>Dramative</option>
<option>Fiction</option>
<option>Expository</option>
<option>Historical</option>
<option>Dialogue</option>
<option>Creative</option>
<option>Critical</option>
<option>Narrative</option>
<option>Persuasive</option>
<option>Reflective</option>
<option>Argumentative</option>
<option>Analytical</option>
<option>Blog</option>
<option>News</option>
<option>Casual</option>
<option>Pastoral</option>
<option>Personal</option>
<option>Poetic</option>
<option>Satirical</option>
<option>Sensory</option>
<option>Articulate</option>
<option>Monologue</option>
<option>Colloquial</option>
<option>Comparative</option>
<option>Concise</option>
<option>Biographical</option>
<option>Anecdotal</option>
<option>Evaluative</option>
<option>Letter</option>
<option>Lyrical</option>
<option>Simple</option>
<option>Vivid</option>
<option>Journalistic</option>
<option>Technical</option>
<option>Direct</option>
<option>Emotional</option>
<option>Metaphorical</option>
<option>Objective</option>
<option>Rhetorical</option>
<option>Theoretical</option>
<option>Business</option>
<option>Report</option>
<option>Research</option>
</datalist>
                           </td>
                        </tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Set the writing tone of the created content. This will set the value of the %%writing_tone%% shortcode, which can be used in prompts below. You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Writing Tone:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input id="writing_tone3" name="writing_tone" type="text" list="writing_tones4" placeholder="Created content writing tone" class="valuesai3 coderevolution_gutenberg_input" value="Neutral"/>
                           <datalist id="writing_tones4">
<option>Neutral</option>
<option>Formal</option>
<option>Assertive</option>
<option>Cheerful</option>
<option>Humorous</option>
<option>Informal</option>
<option>Inspirational</option>
<option>Professional</option>
<option>Emotional</option>
<option>Persuasive</option>
<option>Supportive</option>
<option>Sarcastic</option>
<option>Condescending</option>
<option>Skeptical</option>
<option>Narrative</option>
<option>Journalistic</option>
<option>Conversational</option>
<option>Factual</option>
<option>Friendly</option>
<option>Polite</option>
<option>Scientific</option>
<option>Sensitive</option>
<option>Sincere</option>
<option>Curious</option>
<option>Dissapointed</option>
<option>Encouraging</option>
<option>Optimistic</option>
<option>Surprised</option>
<option>Worried</option>
<option>Confident</option>
<option>Authoritative</option>
<option>Nostalgic</option>
<option>Sympathetic</option>
<option>Suspenseful</option>
<option>Romantic</option>
<option>Serious</option>
</datalist>
                           </td>
                        </tr>
                        <tr><td colspan="2">
                              <h4><?php echo esc_html__("Prompts", 'aiomatic-automatic-ai-content-writer');?>:</h4>
                        </td></tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Prompt to be used for the Post Title. You can use the following shortcodes: %%search_keywords%%, %%language%%, %%writing_style%%, %%writing_tone%%, %%random_sentence%%, %%random_sentence2%%, %%blog_title%% - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators. You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Title Prompt:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <textarea rows="2" cols="70" name="title_prompt" id="title_prompt3" placeholder="Enter your title prompts, one per line" class="valuesai3 cr_width_full">Write a title for a product roundup blog post which talks about the following products: %%all_product_titles%%,  %%all_product_info%%, in %%language%% language. Style: %%writing_style%%. Tone: %%writing_tone%%. Must be between 40 and 60 characters.</textarea>
                           </td>
                        </tr>
                        <tr>
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select the AI Model to be used for the title generator.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("AI Model For Title Generator:", 'aiomatic-automatic-ai-content-writer');?></b>   
                           </td>
                           <td class="cr_min_width_200">
                           <select autocomplete="off" id="topic_title_model3" name="topic_title_model" class="hideAssistant3 valuesai3 cr_width_full">
                           <?php
foreach($all_models as $modelx)
{
echo '<option value="' . $modelx .'"';
echo '>' . esc_html($modelx) . esc_html(aiomatic_get_model_provider($modelx)) . '</option>';
}
?>
                           </select>   
                           </td>
                        </tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Prompt to be used for the intro of the article. You can use the following shortcodes: %%search_keywords%%, %%all_product_titles%%,  %%all_product_info%%, %%language%%, %%writing_style%%, %%writing_tone%%, %%sections_count%%, %%random_sentence%%, %%random_sentence2%%, %%blog_title%% - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Article Intro Prompt:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <textarea rows="2" cols="70" name="intro_prompt" id="intro_prompt3" placeholder="Enter your intro prompts, one per line" class="valuesai3 cr_width_full">Write an intro for a blog post which talks about the following products: %%all_product_titles%%,  %%all_product_info%%, in %%language%%. The title of the post is "%%post_title%%". Style: %%writing_style%%. Tone: %%writing_tone%%.</textarea>
                           </td>
                        </tr>
                        <tr>
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select the AI Model to be used for the intro generator.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("AI Model For Intro Generator:", 'aiomatic-automatic-ai-content-writer');?></b>   
                           </td>
                           <td class="cr_min_width_200">
                           <select autocomplete="off" id="topic_intro_model3" name="topic_intro_model" class="hideAssistant3 valuesai3 cr_width_full">
                           <?php
foreach($all_models as $modelx)
{
echo '<option value="' . $modelx .'"';
echo '>' . esc_html($modelx) . esc_html(aiomatic_get_model_provider($modelx)) . '</option>';
}
?>
                           </select>   
                           </td>
                        </tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Prompt to be used for the Content of the article, which will be applied to each section heading generated by the plugin (or entered manually) or to the entire content (depending how you select using the 'Use the Above Content Prompt To Create The Entire Article' checkbox). You can use the following shortcodes: %%all_product_titles%%,  %%all_product_info%%, %%product_title%%, %%product_description%%, %%product_author%%, %%product_brand%%, %%product_isbn%%, %%product_upc%%, %%offer_url%%, %%offer_price%%, %%product_list_price%%, %%offer_img%%, %%product_reviews%%, %%price_numeric%%, %%price_currency%%, %%review_link%%, %%product_asin%%, %%cart_url%%, %%list_price_numeric%%, %%product_imgs%%, %%product_imgs_html%%, %%price_with_discount_fixed%%, %%first_hand_experience_prompt%%, %%language%%, %%writing_style%%, %%writing_tone%%, %%sections%%, %%current_section%%, %%paragraphs_per_section%%, %%random_sentence%%, %%random_sentence2%%, %%blog_title%% - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators. If you have access to the Amazon API, you can set it up in the plugin and get access to the following advanced shortcodes also: %%product_score%%, %%product_edition%%, %%product_language%%, %%product_pages_count%%, %%product_publication_date%%, %%product_contributors%%, %%product_manufacturer%%, %%product_binding%%, %%product_product_group%%, %%product_rating%%, %%product_ean%%, %%product_part_no%%, %%product_model%%, %%product_warranty%%, %%product_color%%, %%product_is_adult%%, %%product_dimensions%%, %%product_date%%, %%product_size%%, %%product_unit_count%%", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Content Prompt:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <textarea rows="3" cols="70" name="content_prompt" id="content_prompt3" placeholder="Enter your content prompt" class="valuesai3 cr_width_full">Write the content of a post section describing the product "%%product_title%%" in %%language%%. Include pros and cons of the product. Don't repeat the product title in the created content. Don't add an intro or outro. Write %%paragraphs_per_section%% paragraphs in the section. Use HTML for formatting, include unnumbered lists and bold. When applicable, add also HTML tables with WordPress styling (you can use WordPress table classes). If added, table data must be relevant, creative, short and simple. Writing Style: %%writing_style%%. Tone: %%writing_tone%%. %%first_hand_experience_prompt%% Extract content from the following product description: "%%product_description%%"</textarea>
                           </td>
                        </tr>
                        <tr>
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select the AI Model to be used for the content generator.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("AI Model For Content Generator:", 'aiomatic-automatic-ai-content-writer');?></b>   
                           </td>
                           <td class="cr_min_width_200">
                           <select autocomplete="off" id="topic_content_model3" name="topic_content_model" class="hideAssistant3 valuesai3 cr_width_full">
                           <?php
foreach($all_models as $modelx)
{
echo '<option value="' . $modelx .'"';
echo '>' . esc_html($modelx) . esc_html(aiomatic_get_model_provider($modelx)) . '</option>';
}
?>
                           </select>   
                           </td>
                        </tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Prompt to be used for the Q&A of the article. You can use the following shortcodes: %%search_keywords%%, %%all_product_titles%%,  %%all_product_info%%, %%language%%, %%writing_style%%, %%writing_tone%%, %%sections_count%%, %%random_sentence%%, %%random_sentence2%%, %%blog_title%% - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Article Q&A Prompt:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <textarea rows="2" cols="70" name="qa_prompt" id="qa_prompt3" placeholder="Enter your Q&A prompts, one per line" class="valuesai3 cr_width_full">Write a Q&A for a blog post with the following title: "%%post_title%%", in %%language%%. Style: %%writing_style%%. Tone: %%writing_tone%%. The blog post describes and compares multiple products: %%all_product_titles%%</textarea>
                           </td>
                        </tr>
                        <tr>
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select the AI Model to be used for the Q&A generator.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("AI Model For Q&A Generator:", 'aiomatic-automatic-ai-content-writer');?></b>   
                           </td>
                           <td class="cr_min_width_200">
                           <select autocomplete="off" id="topic_qa_model3" name="topic_qa_model" class="hideAssistant3 valuesai3 cr_width_full">
                           <?php
foreach($all_models as $modelx)
{
echo '<option value="' . $modelx .'"';
echo '>' . esc_html($modelx) . esc_html(aiomatic_get_model_provider($modelx)) . '</option>';
}
?>
                           </select>   
                           </td>
                        </tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Prompt to be used for the outro of the article. You can use the following shortcodes: %%search_keywords%%, %%all_product_titles%%,  %%all_product_info%%, %%language%%, %%writing_style%%, %%writing_tone%%, %%sections_count%%, %%random_sentence%%, %%random_sentence2%%, %%blog_title%% - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Article Outro Prompt:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <textarea rows="2" cols="70" name="outro_prompt" id="outro_prompt3" placeholder="Enter your outro prompts, one per line" class="valuesai3 cr_width_full">Write an outro for a blog post with the following title: "%%post_title%%", in %%language%%. Style: %%writing_style%%. Tone: %%writing_tone%%. The blog post describes and compares multiple products: %%all_product_titles%%</textarea>
                           </td>
                        </tr>
                        <tr>
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select the AI Model to be used for the outro generator.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("AI Model For Outro Generator:", 'aiomatic-automatic-ai-content-writer');?></b>   
                           </td>
                           <td class="cr_min_width_200">
                           <select autocomplete="off" id="topic_outro_model3" name="topic_outro_model" class="hideAssistant3 valuesai3 cr_width_full">
                           <?php
foreach($all_models as $modelx)
{
echo '<option value="' . $modelx .'"';
echo '>' . esc_html($modelx) . esc_html(aiomatic_get_model_provider($modelx)) . '</option>';
}
?>
                           </select>   
                           </td>
                        </tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Prompt to be used for the excerpt of the article. You can use the following shortcodes: %%search_keywords%%, %%all_product_titles%%,  %%all_product_info%%, %%language%%, %%writing_style%%, %%writing_tone%%, %%sections%%, %%random_sentence%%, %%random_sentence2%%, %%blog_title%% - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Excerpt Prompt:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <textarea rows="2" cols="70" name="excerpt_prompt" id="excerpt_prompt3" placeholder="Enter your excerpt prompts, one per line" class="valuesai3 cr_width_full">Write a short excerpt for a blog post with the following title: "%%post_title%%", in %%language%%. Style: %%writing_style%%. Tone: %%writing_tone%%. The blog post describes and compares multiple products: %%all_product_titles%%</textarea>
                           </td>
                        </tr>
                        <tr>
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select the AI Model to be used for the excerpt generator.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("AI Model For Excerpt Generator:", 'aiomatic-automatic-ai-content-writer');?></b>   
                           </td>
                           <td class="cr_min_width_200">
                           <select autocomplete="off" id="topic_excerpt_model3" name="topic_excerpt_model" class="hideAssistant3 valuesai3 cr_width_full">
                           <?php
foreach($all_models as $modelx)
{
echo '<option value="' . $modelx .'"';
echo '>' . esc_html($modelx) . esc_html(aiomatic_get_model_provider($modelx)) . '</option>';
}
?>
                           </select>   
                           </td>
                        </tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Prompt to be used for the product comparison prompt of the article. You can use the following shortcodes: %%search_keywords%%, %%all_product_titles%%,  %%all_product_info%%, %%language%%, %%writing_style%%, %%writing_tone%%, %%sections%%, %%random_sentence%%, %%random_sentence2%%, %%blog_title%% - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Comparison Table Prompt:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <textarea rows="2" cols="70" name="table_prompt" id="table_prompt3" placeholder="Enter your table prompts, one per line" class="valuesai3 cr_width_full">Generate a HTML product comparison table, for a product review blog post. The post has the following title: "%%post_title%%", in %%language%%. Style: %%writing_style%%. Tone: %%writing_tone%%. Point Of View: %%point_of_view%%. Don't add the entire description as a table entry, but instead, extract data from it, make matches between multiple products, be creative and also short and simple. The table must be in a WordPress friendly format and have modern styling (you can use WordPress table classes). Detail product information: %%all_product_info%%</textarea>
                           </td>
                        </tr>
                        <tr>
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select the AI Model to be used for the product comparison table generator.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("AI Model For Comparison Table Generator:", 'aiomatic-automatic-ai-content-writer');?></b>   
                           </td>
                           <td class="cr_min_width_200">
                           <select autocomplete="off" id="topic_table_model3" name="topic_table_model" class="hideAssistant3 valuesai3 cr_width_full">
                           <?php
foreach($all_models as $modelx)
{
echo '<option value="' . $modelx .'"';
echo '>' . esc_html($modelx) . esc_html(aiomatic_get_model_provider($modelx)) . '</option>';
}
?>
                           </select>   
                           </td>
                        </tr>
                        <tr><td colspan="2">
                              <h4><?php echo esc_html__("Advanced Prompting Options", 'aiomatic-automatic-ai-content-writer');?>:</h4>
                        </td></tr>
                        <tr>
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Run regex on prompts. To disable this feature, leave this field blank. No Regex separators are required here. You can add multiple Regex expressions, each on a different line.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Run Regex On Prompts:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <textarea rows="1" name="strip_by_regex_prompts" id="strip_by_regex_prompts3" placeholder="regex expression" class="valuesai3 cr_width_full"></textarea>
                           </td>
                        </tr>
                        <tr>
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Replace the above regex matches with this regex expression. If you want to strip matched content, leave this field blank. No Regex separators are required here. You can add multiple replacement expressions, each on a different line.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Replace Matches From Regex (Prompts):", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <textarea rows="1" name="replace_regex_prompts" id="replace_regex_prompts3" placeholder="regex replacement" class="valuesai3 cr_width_full"></textarea>
                           </td>
                        </tr>
                        <tr>
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select on which prompts do you want to run the above Regex. Possible values are (or any of their combinations): title, intro, sections, content, qa, outro, excerpt", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Run Above Regex On Prompts:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input id="run_regex_on3" name="run_regex_on" type="text" list="run_regex_on_list4" class="valuesai3 coderevolution_gutenberg_input" value="content"/>
<datalist id="run_regex_on_list4">
<option value="title">title</option>
<option value="intro">intro</option>
<option value="sections">sections</option>
<option value="content">content</option>
<option value="qa">Q&A</option>
<option value="outro">outro</option>
<option value="excerpt">excerpt</option>
<option value="table">table</option>
</datalist> 
                           </td>
                        </tr>
                     <tr><td colspan="2">
                              <h3><?php echo esc_html__("Global Prompt Options", 'aiomatic-automatic-ai-content-writer');?>:</h3>
                        </td></tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("This will be prepended to each prompt sent by the plugin to the AI writer. You can use the following shortcodes: %%topic%%, %%language%%, %%writing_style%%, %%writing_tone%%, %%title%%, %%random_sentence%%, %%random_sentence2%%, %%post_original_title%%, %%blog_title%% - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators. You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Prepend Text To All Textual AI Prompts:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <textarea rows="2" cols="70" name="global_prepend" id="global_prepend3" placeholder="Global prompt prepend text" class="valuesai3 cr_width_full"></textarea>
                           </td>
                        </tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("This will be appended to each prompt sent by the plugin to the AI writer. You can use the following shortcodes: %%topic%%, %%language%%, %%writing_style%%, %%writing_tone%%, %%title%%, %%random_sentence%%, %%random_sentence2%%, %%post_original_title%%, %%blog_title%% - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators. You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Append Text To All Textual AI Prompts:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <textarea rows="2" cols="70" name="global_append" id="global_append3" placeholder="Global prompt append text" class="valuesai3 cr_width_full"></textarea>
                           </td>
                        </tr>
                     <tr><td colspan="2">
                              <h3><?php echo esc_html__("Automatic Linking Options", 'aiomatic-automatic-ai-content-writer');?>:</h3>
                        </td></tr>
                        <tr>
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select the linking method to use in posts.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Automatic Linking Type:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <select autocomplete="off" class="valuesai3 cr_width_full" id="link_type3" onchange="hideLinks('');" name="link_type">
                           <option value="disabled" selected><?php echo esc_html__("Disabled", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="internal"><?php echo esc_html__("Internal Links", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="manual"><?php echo esc_html__("Manual Links", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="mixed"><?php echo esc_html__("Mixed Links", 'aiomatic-automatic-ai-content-writer');?></option>
                           </select>   
                           </td>
                        </tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Set the maximum number of automatic links to add to created posts. You can also define custom ranges, like: 3-5. Please note that this feature will work best if you already have a considerable number of posts published on your site, which will be used for internal linking.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Maximum Number Of Automatic Links To Add To The Post Content:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="text" name="max_links" id="max_links3" placeholder="3-5" class="valuesai3 cr_width_full">
                           </td>
                        </tr>
                        <tr class="hidelinks">
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Enter a manual list of links, where the plugin will create links.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Manual List Of URLs (One Per Line):", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <textarea rows="1" cols="70" name="link_list" id="link_list3" placeholder="URL list (one per line)" class="valuesai3 cr_width_full"></textarea>
                           </td>
                        </tr>
                        <tr class="hidelinks">
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Do you want to add nofollow attribute to manually entered, external links?", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Add Nofollow Attribute To Manual Links:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="checkbox" id="link_nofollow3" name="link_nofollow" class="valuesai3">
                           </td>
                        </tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Set the post types where to create automatic links in posts. You can also add a comma separated list of multiple post types.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Post Types Where To Generate Automatic Links:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="text" name="link_post_types" id="link_post_types3" placeholder="post" class="valuesai3 cr_width_full">
                           </td>
                        </tr>
                     <tr><td colspan="2">
                              <h3><?php echo esc_html__("Advanced AI Text Generator Options", 'aiomatic-automatic-ai-content-writer');?>:</h3>
                        </td></tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Set the maximum number of API tokens to use with each request. This will define the length of the resulting API response. Each token usually consists of approximately 4 characters. Note that in this value the number of tokens sent to the API as an article prompt will also be counted. The maximum amount which can be set is 4000. For other models, the maximum is 2048.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Maximum Total Token Count To Use Per API Request:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="number" min="1" max="128000" name="max_tokens" id="max_tokens3" value="" placeholder="2048" class="valuesai3 cr_width_full">
                           </td>
                        </tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Set the maximum number of prompt API tokens to use with each request. This will define the length of the resulting API response. Each token usually consists of approximately 4 characters. This defines how much content does the API receive each time you call it. If the API gets more initial data, better quality results will be expected. The maximum amount which can be set is 1000.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Maximum Prompt Token Count To Use Per API Request:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="number" min="1" max="128000" name="max_seed_tokens" id="max_seed_tokens3" value="" placeholder="1000" class="valuesai3 cr_width_full">
                           </td>
                        </tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Set the maximum number of continue API tokens to use with each request. This will define the length of the resulting API response. Each token usually consists of approximately 4 characters. This defines how much content does the API receive each time you call it. If the API gets more initial data, better quality results will be expected. The maximum amount which can be set is 500.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Maximum Continue Token Count To Use Per API Request:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="number" min="1" max="128000" name="max_continue_tokens" id="max_continue_tokens3" value="" placeholder="500" class="valuesai3 cr_width_full">
                           </td>
                        </tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("What sampling temperature to use. Higher values means the model will take more risks. Try 0.9 for more creative applications, and 0 (argmax sampling) for ones with a well-defined answer. We generally recommend altering this or top_p but not both.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("AI Temperature:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="number" min="0" step="0.1" max="2" name="temperature" id="temperature3" value="" placeholder="1" class="valuesai3 cr_width_full">
                           </td>
                        </tr><tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("An alternative to sampling with temperature, called nucleus sampling, where the model considers the results of the tokens with top_p probability mass. So 0.1 means only the tokens comprising the top 10% probability mass are considered. We generally recommend altering this or temperature but not both.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("AI Top_p:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="number" min="0" max="1" step="0.1" name="top_p" id="top_p3" value="" placeholder="1" class="valuesai3 cr_width_full">
                           </td>
                        </tr><tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Number between -2.0 and 2.0. Positive values penalize new tokens based on whether they appear in the text so far, increasing the model's likelihood to talk about new topics.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("AI Presence Penalty:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="number" min="-2" step="0.1" max="2" name="presence_penalty" id="presence_penalty3" value="" placeholder="0" class="valuesai3 cr_width_full">
                           </td>
                        </tr><tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Number between -2.0 and 2.0. Positive values penalize new tokens based on their existing frequency in the text so far, decreasing the model's likelihood to repeat the same line verbatim.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("AI Frequency Penalty:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="number" min="0" max="2" step="0.1" name="frequency_penalty" id="frequency_penalty3" value="" placeholder="0" class="valuesai3 cr_width_full">
                           </td>
                        </tr>
                     <tr><td colspan="2">
                              <h3><?php echo esc_html__("Image Generator Options", 'aiomatic-automatic-ai-content-writer');?>:</h3>
                        </td></tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select the search query repetition mode, when searching royalty free images.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Search Query Repetition:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <select autocomplete="off" id="search_query_repetition3" name="search_query_repetition" class="valuesai3 cr_width_full">
                              <option value="0" selected><?php echo esc_html__("Use Different Search Queries For Images", 'aiomatic-automatic-ai-content-writer');?></option>
                              <option value="1"><?php echo esc_html__("Use The Same Search Query For Images", 'aiomatic-automatic-ai-content-writer');?></option>
                           </select>
                           </td>
                        </tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Do you want to enable the AI Image Generator and to replace Royalty Free Images with AI generated images? If you select 'Default Featured Image List', you can add the image URLs in the 'Default Featured Image List' settings field.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Article Image Source:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <select autocomplete="off" id="enable_ai_images3" onchange="hideImage('3');" name="enable_ai_images" class="valuesai3 cr_width_full">
                              <option value="0" selected><?php echo esc_html__("Royalty Free", 'aiomatic-automatic-ai-content-writer');?></option>
                              <option value="1"><?php echo esc_html__("OpenAI/AiomaticAPI", 'aiomatic-automatic-ai-content-writer');?></option>
                              <?php
                              if (isset($aiomatic_Main_Settings['stability_app_id']) && trim($aiomatic_Main_Settings['stability_app_id']) != '')
                              {
                              ?>
                              <option value="2"><?php echo esc_html__("Stability.AI", 'aiomatic-automatic-ai-content-writer');?></option>
                              <?php
                              }
                              ?>
                           </select>
                           </td>
                        </tr>
                        <tr class="hideImg3 cr_none">
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Set list of prompt commands (one on each line) you want to send to the AI image generator. This command can be any given task or order, based on which, it will generate images. You can use the following shortcodes here: %%post_title%%, %%random_sentence%%, %%random_sentence2%%, %%blog_title%%. The length of this command should not be greater than 1000 characters, otherwise the plugin will strip it to 1000 characters length. - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You can also add here a link to a .txt file, where you can add multiple prompts (one per line) and the plugin will select a random one at each run. You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators. You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                          echo '&nbsp;' . sprintf( wp_kses( __( "Please check some tips and tricks about writing prompt commands, <a href='%s' target='_blank'>here</a>. The [aicontent] shortcode is able to be used also here.", 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), 'https://coderevolution.ro/knowledge-base/faq/how-to-create-a-good-seed-prompt-command-for-aiomatic-image-generating-for-openai-dall-e-api/' );
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Prompt For The AI Image Generator:", 'aiomatic-automatic-ai-content-writer');?></b>&nbsp;<b><a href="https://coderevolution.ro/knowledge-base/faq/how-to-create-a-good-seed-prompt-command-for-aiomatic-image-generating-for-openai-dall-e-api/" target="_blank">&#9432;</a></b>
                           </td>
                           <td>
                           <textarea rows="2" cols="70" name="ai_command_image" id="ai_command_image3" placeholder="Please insert a command for the AI image generator" class="valuesai3 cr_width_full">A high detail image with no text of: "%%post_title%%"</textarea>
                           </td>
                        </tr>
                        <tr class="hideDalle3 cr_none">
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select the AI model you wish to use for image the image generator.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("AI Image Model:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <select autocomplete="off" id="image_model3" name="image_model" class="valuesai3 cr_width_full">
                              <option value="dalle2"selected><?php echo esc_html__("Dall-E 2", 'aiomatic-automatic-ai-content-writer');?></option>
                              <option value="dalle3"><?php echo esc_html__("Dall-E 3", 'aiomatic-automatic-ai-content-writer');?></option>
                              <option value="dalle3hd"><?php echo esc_html__("Dall-E 3 HD", 'aiomatic-automatic-ai-content-writer');?></option>
                           </select>
                           </td>
                        </tr>
                        <tr class="hideImg3 cr_none">
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select the size of the generated image.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Generated Image Size:", 'aiomatic-automatic-ai-content-writer');?></b>   
                           </td>
                           <td class="cr_min_width_200">
                           <select autocomplete="off" id="model3" name="image_size" class="valuesai3 cr_width_full">
                              <option value="256x256"><?php echo esc_html__("256x256", 'aiomatic-automatic-ai-content-writer');?></option>
                              <option value="512x512"><?php echo esc_html__("512x512", 'aiomatic-automatic-ai-content-writer');?></option>
                              <option value="1024x1024" selected><?php echo esc_html__("1024x1024", 'aiomatic-automatic-ai-content-writer');?></option>
                           </select>  
                           </td>
                        </tr>
                        <tr><td colspan="2">
                              <h3><?php echo esc_html__("Posting Options", 'aiomatic-automatic-ai-content-writer');?>:</h3>
                        </td></tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Enter a HTML text that should be prepended to the AI generated content in each created post. You can use the following shortcodes: %%custom_html%%, %%custom_html2%%, %%search_keywords%%, %%all_product_titles%%,  %%all_product_info%%, %%language%%, %%writing_style%%, %%writing_tone%%, %%sections_count%%, %%random_sentence%%, %%random_sentence2%%, %%blog_title%%, %%random_image[keyword]%%, %%random_image_url[keyword]%%, %%random_video[keyword]%%, %%royalty_free_image_attribution%% - you can also use an optional parameter in the random_image and random_video shortcodes, which will add a percentage chance for the media to appear or not - example: %%random_video[keyword][60]%% - a video will appear in 60% of cases, in the rest of 40%, nothing will be returned by the shortcode - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("HTML Text To Prepend To AI Created Content:", 'aiomatic-automatic-ai-content-writer');?></b>&nbsp;<b><a href="https://coderevolution.ro/knowledge-base/faq/post-template-reference-advanced-usage/" target="_blank">&#9432;</a></b>
                           </td>
                           <td>
                           <textarea rows="2" cols="70" name="post_prepend" id="post_prepend3" placeholder="HTML content to prepend to the AI generated content" class="valuesai3 cr_width_full"></textarea>
                           </td>
                        </tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Enter a HTML text that should be appended to the AI generated content in each created post. You can use the following shortcodes: %%custom_html%%, %%custom_html2%%, %%search_keywords%%, %%all_product_titles%%,  %%all_product_info%%, %%language%%, %%writing_style%%, %%writing_tone%%, %%sections_count%%, %%random_sentence%%, %%random_sentence2%%, %%blog_title%%, %%random_image[keyword]%%, %%random_image_url[keyword]%%, %%random_video[keyword]%%, %%royalty_free_image_attribution%% - you can also use an optional parameter in the random_image and random_video shortcodes, which will add a percentage chance for the media to appear or not - example: %%random_video[keyword][60]%% - a video will appear in 60% of cases, in the rest of 40%, nothing will be returned by the shortcode - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("HTML Text To Append To AI Created Content:", 'aiomatic-automatic-ai-content-writer');?></b>&nbsp;<b><a href="https://coderevolution.ro/knowledge-base/faq/post-template-reference-advanced-usage/" target="_blank">&#9432;</a></b>
                           </td>
                           <td>
                           <textarea rows="2" cols="70" name="post_append" id="post_append3" placeholder="HTML content to append to the AI generated content" class="valuesai3 cr_width_full"></textarea>
                           </td>
                        </tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Custom AI generated content shortcode creator. If you wish to create content from multiple AI prompts, and use them in post content/post custom fields/taxonomies, you can configure this from here. Also, these shortcodes will be able to be used in custom fields or custom taxonomies which the plugin will create. Syntax for this field: shortcode_name => AI_MODEL_TO_USE @@ TEXTUAL_PROMPT_TO_USE (to specify multiple shortcodes and crawling values, separate them by a new line. Example: my_custom_shortcode => gpt-3.5-turbo-instruct @@ Write a short poem. Afterwards, you can use shortcodes in any settings field that supports shortcodes (ex: 'HTML Text To Append To AI Created Content' settings field), like this: %%my_custom_shortcode%%. Official format is %%name_of_custom_shortcode%%", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Custom Shortcode Creator (Optional):", 'aiomatic-automatic-ai-content-writer');?></b><span class="tool" data-tip="Supported models: <?php echo implode(',', aiomatic_get_all_models());?>">&nbsp;&#9432;</span>
                           </td>
                           <td>
                           <textarea rows="2" cols="70" name="custom_shortcodes" id="custom_shortcodes3" placeholder="shortcode_name => AI_MODEL @@ AI_PROMPT" class="valuesai3 cr_width_full"></textarea>
                           </td>
                        </tr>
                        <tr>
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("The AI writer might add the title of the post to the created post content. Check this checkbox if you want to remove the title from the post content.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Strip Title From Content:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="checkbox" id="strip_title3" name="strip_title" class="valuesai3">
                           </td>
                        </tr>
                        <tr>
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px"><?php echo esc_html__("Do you want to skip spinning of posts generated by this rule?", 'aiomatic-automatic-ai-content-writer');?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Do Not Spin Posts Generated By This Rule:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="checkbox" id="skip_spin3" name="skip_spin" class="valuesai3">               
                           </td>
                        </tr>
                        <tr>
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px"><?php echo esc_html__("Do you want to skip translating of posts generated by this rule?", 'aiomatic-automatic-ai-content-writer');?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Do Not Translate Posts Generated By This Rule:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="checkbox" id="skip_translate3" name="skip_translate" class="valuesai3">               
                           </td>
                        </tr>
                        <tr>
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Run regex on post content. To disable this feature, leave this field blank. No Regex separators are required here. You can add multiple Regex expressions, each on a different line.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Run Regex On Content:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <textarea rows="1" name="strip_by_regex" id="strip_by_regex3" placeholder="regex expression" class="valuesai3 cr_width_full"></textarea>
                           </td>
                        </tr>
                        <tr>
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Replace the above regex matches with this regex expression. If you want to strip matched content, leave this field blank. No Regex separators are required here. You can add multiple replacement expressions, each on a different line.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Replace Matches From Regex (Content):", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <textarea rows="1" name="replace_regex" id="replace_regex3" placeholder="regex replacement" class="valuesai3 cr_width_full"></textarea>
                           </td>
                        </tr>
                     </table>
                  </div>
               </div>
               <div class="codemodalfzr-footer">
                  <br/>
                  <h3 class="cr_inline">Aiomatic Automatic Post Generator</h3>
                  <span id="aiomatic_ok3" class="codeokfzr cr_inline">OK&nbsp;</span>
                  <br/><br/>
               </div>
            </div>
         </div>


   <div id="mymodalfzr4" class="codemodalfzr">
            <div class="codemodalfzr-content">
               <div class="codemodalfzr-header">
                  <span id="aiomatic_close4" class="codeclosefzr">&times;</span>
                  <h2><span class="cr_color_white"><?php echo esc_html__("Amazon Product Review", 'aiomatic-automatic-ai-content-writer');?></span> <?php echo esc_html__("Advanced Settings", 'aiomatic-automatic-ai-content-writer');?></h2>
               </div>
               <div class="codemodalfzr-body">
                  <div class="table-responsive">
                     <table class="responsive table cr_main_table_nowr">
                     <tr><td colspan="2">
                           <h3><?php echo esc_html__("AI Assistant Options", 'aiomatic-automatic-ai-content-writer');?>:</h3>
                     </td></tr>
                     <tr>
                        <td class="cr_min_width_200">
                              <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                 <div class="bws_hidden_help_text cr_min_260px">
                                    <?php
                                       echo esc_html__("Select the AI Assistant to use for content creation. This will disable the ability to select AI models, as the models assisgned to the assistant will be used for content creation.", 'aiomatic-automatic-ai-content-writer');
                                       ?>
                                 </div>
                              </div>
                              <b><?php echo esc_html__("AI Assistant Name:", 'aiomatic-automatic-ai-content-writer');?></b>
                        </td>
                        <td><select id="assistant_id4" name="assistant_id" class="valuesai4 cr_width_full" onchange="assistantSelected('4');">
<?php
if($all_assistants === false)
{
echo '<option val="" selected disabled>' . esc_html__("Only OpenAI API is supported for Assistants API", 'aiomatic-automatic-ai-content-writer') . '</option>';
}
else
{
if(count($all_assistants) == 0)
{
echo '<option val="" selected disabled>' . esc_html__("No Assistans added, go to the plugin's 'AI Assistans' menu to add new assistants!", 'aiomatic-automatic-ai-content-writer') . '</option>';
}
else
{
echo '<option value="" selected';
echo '>' . esc_html__("Don't use assistants, use AI models instead", 'aiomatic-automatic-ai-content-writer') . '</option>';
foreach($all_assistants as $myassistant)
{
echo '<option value="' . $myassistant->ID .'"';
echo '>' . esc_html($myassistant->post_title);
echo '</option>';
}
}
}
?>
</select>  
                        </td>
                     </tr>
                        <tr><td colspan="2">
                              <h3><?php echo esc_html__("Amazon Search Options", 'aiomatic-automatic-ai-content-writer');?>:</h3>
                        </td></tr>
                        <tr>
                           <td>
                              <div>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo sprintf( wp_kses( __( "Insert your Amazon Associate ID (Optional). Learn how to get one <a href='%s' target='_blank'>here</a>. Also, you need to sign up for Amazon Affiliate program <a href='%s' target='_blank'>here</a>.", 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), 'https://affiliate-program.amazon.com/gp/advertising/api/detail/main.html', 'https://affiliate-program.amazon.com/assoc_credentials/home');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Amazon Associate ID (Optional):", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="text" name="affiliate_id" id="affiliate_id4" value="" placeholder="Please insert your Amazon Affiliate ID" class="valuesai4 cr_width_full">  
                           </td>
                        </tr>
                        <tr>
                           <td>
                              <div>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select the country where you have registred your affiliate account.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Amazon Target Country:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                        <select id="source4" name="target_country" class="valuesai4">
                        <?php
                           $amaz_countries = aiomatic_get_amazon_codes();
                           foreach ($amaz_countries as $key => $value) {
                              echo '<option value="' . esc_html($key) . '">' . esc_html($value) . '</option>';
                           }
                           ?>
                        </select>  
                           </td>
                        </tr>
                        <tr><td colspan="2">
                              <h3><?php echo esc_html__("AI Writer Options", 'aiomatic-automatic-ai-content-writer');?>:</h3>
                        </td></tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Enter a list of post sections, one per line. These will be headings of the content. These can also be automatically generated by the plugin. To enable auto generating of sections, leave this field blank. This will set the value of the %%sections%% shortcode, which can be used in prompts below. You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators. If you set a section list here, each created article will have this same list of sections, because of this, use shortcodes or Spintax when defining these static topics or leave this field blank for the plugin to auto generate them!", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Post Sections List (Optional):", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <textarea rows="2" cols="70" name="post_sections_list" id="post_sections_list4" placeholder="Post sections list (one per line)" class="valuesai4 cr_width_full"></textarea>
                           </td>
                        </tr>
                        <tr>
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Enter the number of sections to create in the article. These will also be set as article headings. You can also set value ranges, example: 5-7. In this case, a random number will be selected in this range. Please use only numeric values in this field. This field will set the value of the %%sections_count%% shortcode.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Number Of Content Sections To Generate:", 'aiomatic-automatic-ai-content-writer');?></b>   
                           </td>
                           <td class="cr_min_width_200">
                           <input type="text" id="section_count4" name="section_count" placeholder="3-4" class="valuesai4 cr_width_full" value="3-4">  
                           </td>
                        </tr>
                        <tr>
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select what you want to do with product titles in articles.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Add Headings To Content As:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <select autocomplete="off" class="valuesai4 cr_width_full" id="sections_role4" name="sections_role">
                           <option value="h2" selected><?php echo esc_html__("h2", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="h3"><?php echo esc_html__("h3", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="b"><?php echo esc_html__("Bold", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="i"><?php echo esc_html__("Italic", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="bi"><?php echo esc_html__("Bold and Italic", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="p"><?php echo esc_html__("Paragraph", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="x"><?php echo esc_html__("Plain Text", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="no"><?php echo esc_html__("Don't Add Sections", 'aiomatic-automatic-ai-content-writer');?></option>
                           </select>   
                           </td>
                        </tr>
                        <tr>
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Enter the number of paragraphs to create for each section. These will also be set as article headings. You can also set value ranges, example: 5-7. In this case, a random number will be selected in this range. Please use only numeric values in this field. This field will set the value of the %%paragraphs_per_section%% shortcode.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Number Of Paragraphs Per Section:", 'aiomatic-automatic-ai-content-writer');?></b>   
                           </td>
                           <td class="cr_min_width_200">
                           <input type="text" id="paragraph_count4" name="paragraph_count" placeholder="2-3" class="valuesai4 cr_width_full" value="2">  
                           </td>
                        </tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select if you want to add the product image to the article.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Add Product Images To The Article:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="checkbox" id="topic_images4" name="topic_images" class="valuesai4" checked>
                           </td>
                        </tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select if you don't want to add the product links directly to headings.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Don't Add Product Links to Headings:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="checkbox" id="no_headlink4" name="no_headlink" class="valuesai4">
                           </td>
                        </tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select if you would like to add a relevant YouTube video to the end of the created article.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Add A Relevant YouTube Video To The Article:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="checkbox" id="topic_videos4" name="topic_videos" class="valuesai4">
                           </td>
                        </tr>
                        <tr>
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Set the text of the outro section header. This is optional.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Article Outro Section Header Text:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="text" name="title_outro" id="title_outro4" value="{Experience the Difference|Unlock Your Potential|Elevate Your Lifestyle|Embrace a New Era|Seize the Opportunity|Discover the Power|Transform Your World|Unleash Your True Potential|Embody Excellence|Achieve New Heights|Experience Innovation|Ignite Your Passion|Reveal the Extraordinary}" placeholder="Optional" class="valuesai4 cr_width_full">
                           </td>
                        </tr> 
                        <tr>
                           <td class="hideTOC-1">
                              <div>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select if you want to add a Table of Contents section to the created post.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Add Article 'Table Of Contents':", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td class="hideTOC-1">
                           <input type="checkbox" id="enable_toc4" name="enable_toc" class="valuesai4">
                           </td>
                        </tr> 
                        <tr>
                           <td class="hideTOC-1">
                              <div>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Set the text of the Table of Contents section header. Default is: Table of Contents", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Article 'Table Of Contents' Section Header Text:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td class="hideTOC-1">
                           <input type="text" name="title_toc" id="title_toc4" value="Table of Contents" placeholder="Table of Contents" class="valuesai4 cr_width_full">
                           </td>
                        </tr> 
                        <tr>
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select if you want to add a Customer Reviews Analysis section to the created post. To enable Customer Reviews Analysis for articles, be sure to add a prompt also in the 'Article Customer Reviews Analysis Prompt' settings field from below.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Add Article 'Customer Reviews Analysis' Section:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="checkbox" id="enable_reviews4" name="enable_reviews" class="valuesai4">
                           </td>
                        </tr> 
                        <tr>
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Set the text of the Customer Reviews Analysis section header. Default is: Customer Reviews Analysis", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Article 'Customer Reviews Analysis' Section Header Text:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="text" name="title_reviews" id="title_reviews4" value="Customer Reviews Analysis" placeholder="Customer Reviews Analysis" class="valuesai4 cr_width_full">
                           </td>
                        </tr> 
                        <tr>
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select if you want to add a Pros & Cons section to the created post. To enable Pros & Cons for articles, be sure to add a prompt also in the 'Article Pros & Cons Prompt' settings field from below.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Add Article 'Pros & Cons' Section:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="checkbox" id="enable_proscons4" name="enable_proscons" class="valuesai4">
                           </td>
                        </tr> 
                        <tr>
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Set the text of the Pros & Cons section header. Default is: Pros & Cons", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Article 'Pros & Cons' Section Header Text:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="text" name="title_proscons" id="title_proscons4" value="Pros & Cons" placeholder="Pros & Cons" class="valuesai4 cr_width_full">
                           </td>
                        </tr> 
                        <tr>
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select if you want to add a Q&A section to the created post. To enable Q&A for articles, be sure to add a prompt also in the 'Article Q&A Prompt' settings field from below.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Add Article 'Q&A' Section:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="checkbox" id="enable_qa4" name="enable_qa" class="valuesai4">
                           </td>
                        </tr> 
                        <tr>
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Set the text of the Q&A section header. Default is: Q&A", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Article 'Q&A' Section Header Text:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="text" name="title_qa" id="title_qa4" value="Q&A" placeholder="Q&A" class="valuesai4 cr_width_full">
                           </td>
                        </tr> 
                        <tr><td colspan="2">
                              <h4><?php echo esc_html__("Content Parameters", 'aiomatic-automatic-ai-content-writer');?>:</h4>
                        </td></tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Set the language of the created content. This will set the value of the %%language%% shortcode, which can be used in prompts below. You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Content Language:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input id="content_language4" name="content_language" type="text" list="languages5" placeholder="Created content language" class="valuesai4 coderevolution_gutenberg_input" value="English"/>
<datalist id="languages5">
<?php
foreach($aiomatic_language_names as $ln)
{
echo '<option>' . $ln . '</option>';
}
?>
</datalist>
                           </td>
                        </tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Set the writing style of the created content. This will set the value of the %%writing_style%% shortcode, which can be used in prompts below. You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Writing Style:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input id="writing_style4" name="writing_style" type="text" placeholder="Created content writing style" list="writing_styles5" class="valuesai4 coderevolution_gutenberg_input" value="Creative"/>
                           <datalist id="writing_styles5">
<option>Informative</option>
<option>Academic</option>
<option>Descriptive</option>
<option>Detailed</option>
<option>Dramative</option>
<option>Fiction</option>
<option>Expository</option>
<option>Historical</option>
<option>Dialogue</option>
<option>Creative</option>
<option>Critical</option>
<option>Narrative</option>
<option>Persuasive</option>
<option>Reflective</option>
<option>Argumentative</option>
<option>Analytical</option>
<option>Blog</option>
<option>News</option>
<option>Casual</option>
<option>Pastoral</option>
<option>Personal</option>
<option>Poetic</option>
<option>Satirical</option>
<option>Sensory</option>
<option>Articulate</option>
<option>Monologue</option>
<option>Colloquial</option>
<option>Comparative</option>
<option>Concise</option>
<option>Biographical</option>
<option>Anecdotal</option>
<option>Evaluative</option>
<option>Letter</option>
<option>Lyrical</option>
<option>Simple</option>
<option>Vivid</option>
<option>Journalistic</option>
<option>Technical</option>
<option>Direct</option>
<option>Emotional</option>
<option>Metaphorical</option>
<option>Objective</option>
<option>Rhetorical</option>
<option>Theoretical</option>
<option>Business</option>
<option>Report</option>
<option>Research</option>
</datalist>
                           </td>
                        </tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Set the writing tone of the created content. This will set the value of the %%writing_tone%% shortcode, which can be used in prompts below. You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Writing Tone:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input id="writing_tone4" name="writing_tone" type="text" list="writing_tones5" placeholder="Created content writing tone" class="valuesai4 coderevolution_gutenberg_input" value="Neutral"/>
                           <datalist id="writing_tones5">
<option>Neutral</option>
<option>Formal</option>
<option>Assertive</option>
<option>Cheerful</option>
<option>Humorous</option>
<option>Informal</option>
<option>Inspirational</option>
<option>Professional</option>
<option>Emotional</option>
<option>Persuasive</option>
<option>Supportive</option>
<option>Sarcastic</option>
<option>Condescending</option>
<option>Skeptical</option>
<option>Narrative</option>
<option>Journalistic</option>
<option>Conversational</option>
<option>Factual</option>
<option>Friendly</option>
<option>Polite</option>
<option>Scientific</option>
<option>Sensitive</option>
<option>Sincere</option>
<option>Curious</option>
<option>Dissapointed</option>
<option>Encouraging</option>
<option>Optimistic</option>
<option>Surprised</option>
<option>Worried</option>
<option>Confident</option>
<option>Authoritative</option>
<option>Nostalgic</option>
<option>Sympathetic</option>
<option>Suspenseful</option>
<option>Romantic</option>
<option>Serious</option>
</datalist>
                           </td>
                        </tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select the point of view of the article.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Point Of View:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <select autocomplete="off" class="cr_width_full" id="point_of_view4" name="valuesai4 point_of_view">
                           <option value="First Person Singular (I, me, my, mine)"><?php echo esc_html__("First Person Singular (I, me, my, mine)", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="First Person Plural (we, us, our, ours)" selected><?php echo esc_html__("First Person Plural (we, us, our, ours)", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="Second Person Singular (you, your, yours)"><?php echo esc_html__("Second Person Singular (you, your, yours)", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="Second Person Plural (you [plural], y'all, you guys)"><?php echo esc_html__("Second Person Plural (you [plural], y'all, you guys)", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="Third Person Singular (he, she, it)"><?php echo esc_html__("Third Person Singular (he, she, it)", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="Third Person Plural (they, them, theirs, themselves)"><?php echo esc_html__("Third Person Plural (they, them, theirs, themselves)", 'aiomatic-automatic-ai-content-writer');?></option>
                           </select>   
                           </td>
                        </tr>
                        <tr><td colspan="2">
                              <h4><?php echo esc_html__("Prompts", 'aiomatic-automatic-ai-content-writer');?>:</h4>
                        </td></tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Prompt to be used for the Post Title. You can use the following shortcodes: %%product_title%%, %%product_description%%, %%aff_url%%, %%product_author%%, %%offer_price%%, %%product_price%%, %%product_list_price%%, %%product_brand%%, %%product_isbn%%, %%product_upc%%, %%product_reviews%%, %%price_numeric%%, %%price_currency%%, %%product_asin%%, %%cart_url%%, %%list_price_numeric%%, %%product_imgs%%, %%search_keywords%%, %%language%%, %%writing_style%%, %%point_of_view%%, %%writing_tone%%, %%random_sentence%%, %%random_sentence2%%, %%blog_title%% - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators. You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators. If you have access to the Amazon API, you can set it up in the plugin and get access to the following advanced shortcodes also: %%product_score%%, %%product_edition%%, %%product_language%%, %%product_pages_count%%, %%product_publication_date%%, %%product_contributors%%, %%product_manufacturer%%, %%product_binding%%, %%product_product_group%%, %%product_rating%%, %%product_ean%%, %%product_part_no%%, %%product_model%%, %%product_warranty%%, %%product_color%%, %%product_is_adult%%, %%product_dimensions%%, %%product_date%%, %%product_size%%, %%product_unit_count%%", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Title Prompt:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <textarea rows="2" cols="70" name="title_prompt" id="title_prompt4" placeholder="Enter your title prompts, one per line" class="valuesai4 cr_width_full">Write a title for a product review blog post of the following product: "%%product_title%%", in %%language%% language. Style: %%writing_style%%. Tone: %%writing_tone%%. Point of View: %%point_of_view%%. The title must be between 40 and 60 characters. The description of the product is: "%%product_description%%".</textarea>
                           </td>
                        </tr>
                        <tr>
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select the AI Model to be used for the title generator.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("AI Model For Title Generator:", 'aiomatic-automatic-ai-content-writer');?></b>   
                           </td>
                           <td class="cr_min_width_200">
                           <select autocomplete="off" id="topic_title_model4" name="topic_title_model" class="hideAssistant4 valuesai4 cr_width_full">
                           <?php
foreach($all_models as $modelx)
{
echo '<option value="' . $modelx .'"';
echo '>' . esc_html($modelx) . esc_html(aiomatic_get_model_provider($modelx)) . '</option>';
}
?>
                           </select>   
                           </td>
                        </tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Prompt to be used for the intro of the article. You can use the following shortcodes: %%product_title%%, %%product_description%%, %%aff_url%%, %%product_author%%, %%offer_price%%, %%product_price%%, %%product_list_price%%, %%product_brand%%, %%product_isbn%%, %%product_upc%%, %%product_reviews%%, %%price_numeric%%, %%price_currency%%, %%product_asin%%, %%cart_url%%, %%list_price_numeric%%, %%product_imgs%%, %%search_keywords%%, %%language%%, %%writing_style%%, %%point_of_view%%, %%writing_tone%%, %%random_sentence%%, %%random_sentence2%%, %%blog_title%% - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators. If you have access to the Amazon API, you can set it up in the plugin and get access to the following advanced shortcodes also: %%product_score%%, %%product_edition%%, %%product_language%%, %%product_pages_count%%, %%product_publication_date%%, %%product_contributors%%, %%product_manufacturer%%, %%product_binding%%, %%product_product_group%%, %%product_rating%%, %%product_ean%%, %%product_part_no%%, %%product_model%%, %%product_warranty%%, %%product_color%%, %%product_is_adult%%, %%product_dimensions%%, %%product_date%%, %%product_size%%, %%product_unit_count%%", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Article Intro Prompt:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <textarea rows="2" cols="70" name="intro_prompt" id="intro_prompt4" placeholder="Enter your intro prompts, one per line" class="valuesai4 cr_width_full">Write an introduction for a product review blog post of the following product: "%%product_title%%". The post is reviewing the product "%%product_title%%", in %%language%% language. Style: %%writing_style%%. Tone: %%writing_tone%%. Point of View: %%point_of_view%%. Write as if you had first-hand experience with the product you are describing. The description of the product is: "%%product_description%%".</textarea>
                           </td>
                        </tr>
                        <tr>
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select the AI Model to be used for the intro generator.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("AI Model For Intro Generator:", 'aiomatic-automatic-ai-content-writer');?></b>   
                           </td>
                           <td class="cr_min_width_200">
                           <select autocomplete="off" id="topic_intro_model4" name="topic_intro_model" class="hideAssistant4 valuesai4 cr_width_full">
                           <?php
foreach($all_models as $modelx)
{
echo '<option value="' . $modelx .'"';
echo '>' . esc_html($modelx) . esc_html(aiomatic_get_model_provider($modelx)) . '</option>';
}
?>
                           </select>   
                           </td>
                        </tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Prompt to be used for the main Sections of the article. These will be set also as headings in the article. You can use the following shortcodes: %%product_title%%, %%product_description%%, %%aff_url%%, %%product_author%%, %%offer_price%%, %%product_price%%, %%product_list_price%%, %%product_brand%%, %%product_isbn%%, %%product_upc%%, %%product_reviews%%, %%price_numeric%%, %%price_currency%%, %%product_asin%%, %%cart_url%%, %%list_price_numeric%%, %%product_imgs%%, %%sections_count%%, %%search_keywords%%, %%language%%, %%writing_style%%, %%point_of_view%%, %%writing_tone%%, %%random_sentence%%, %%random_sentence2%%, %%blog_title%% - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators. If you have access to the Amazon API, you can set it up in the plugin and get access to the following advanced shortcodes also: %%product_score%%, %%product_edition%%, %%product_language%%, %%product_pages_count%%, %%product_publication_date%%, %%product_contributors%%, %%product_manufacturer%%, %%product_binding%%, %%product_product_group%%, %%product_rating%%, %%product_ean%%, %%product_part_no%%, %%product_model%%, %%product_warranty%%, %%product_color%%, %%product_is_adult%%, %%product_dimensions%%, %%product_date%%, %%product_size%%, %%product_unit_count%%", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Article Sections Prompt:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <textarea rows="2" cols="70" name="sections_prompt" id="sections_prompt4" placeholder="Enter your sections prompts, one per line" class="valuesai4 cr_width_full">Write %%sections_count%% consecutive headings for a product review article of the "%%product_title%%" product, that starts with an overview, highlights specific features and aspects of the product, provides detailed insights and specific recommendations. The headings should be written in %%language%%, following a %%writing_style%% style and a %%writing_tone%% tone. Point of view: %%point_of_view%%. Don't add numbers to the headings, hyphens or any types of quotes. Write as if you had first-hand experience with the product you are describing. Return only the headings list, nothing else.</textarea>
                           </td>
                        </tr>
                        <tr>
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select the AI Model to be used for the sections generator.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("AI Model For Sections Generator:", 'aiomatic-automatic-ai-content-writer');?></b>   
                           </td>
                           <td class="cr_min_width_200">
                           <select autocomplete="off" id="topic_sections_model4" name="topic_sections_model" class="hideAssistant4 valuesai4 cr_width_full">
                           <?php
foreach($all_models as $modelx)
{
echo '<option value="' . $modelx .'"';
echo '>' . esc_html($modelx) . esc_html(aiomatic_get_model_provider($modelx)) . '</option>';
}
?>
                           </select>   
                           </td>
                        </tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Prompt to be used for the Content of the article, which will be applied to each section heading generated by the plugin (or entered manually) or to the entire content (depending how you select using the 'Use the Above Content Prompt To Create The Entire Article' checkbox). You can use the following shortcodes: %current_section%%, %%product_title%%, %%product_description%%, %%aff_url%%, %%product_author%%, %%offer_price%%, %%product_price%%, %%product_list_price%%, %%product_brand%%, %%product_isbn%%, %%product_upc%%, %%product_reviews%%, %%price_numeric%%, %%price_currency%%, %%product_asin%%, %%cart_url%%, %%list_price_numeric%%, %%product_imgs%%, %%search_keywords%%, %%language%%, %%writing_style%%, %%point_of_view%%, %%writing_tone%%, %%random_sentence%%, %%random_sentence2%%, %%blog_title%% - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators. If you have access to the Amazon API, you can set it up in the plugin and get access to the following advanced shortcodes also: %%product_score%%, %%product_edition%%, %%product_language%%, %%product_pages_count%%, %%product_publication_date%%, %%product_contributors%%, %%product_manufacturer%%, %%product_binding%%, %%product_product_group%%, %%product_rating%%, %%product_ean%%, %%product_part_no%%, %%product_model%%, %%product_warranty%%, %%product_color%%, %%product_is_adult%%, %%product_dimensions%%, %%product_date%%, %%product_size%%, %%product_unit_count%%", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Content Prompt:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <textarea rows="3" cols="70" name="content_prompt" id="content_prompt4" placeholder="Enter your content prompt" class="valuesai4 cr_width_full">Write the content of a product review post, for the following section heading: "%%current_section%%". The post is reviewing the product "%%product_title%%" in %%language%%. Don't repeat the product title in the created content, also don't be repetitive in general. Don't add an intro or outro. Write %%paragraphs_per_section%% paragraphs in the section. Use HTML for formatting, include unnumbered lists and bold. When applicable, add also HTML tables with WordPress styling (you can use WordPress table classes). If added, table data must be relevant, creative, short and simple. Writing Style: %%writing_style%%. Tone: %%writing_tone%%. Point Of View: %%point_of_view%%. Extract content from the following product description: "%%product_description%%".</textarea>
                           </td>
                        </tr>
                        <tr>
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select the AI Model to be used for the content generator.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("AI Model For Content Generator:", 'aiomatic-automatic-ai-content-writer');?></b>   
                           </td>
                           <td class="cr_min_width_200">
                           <select autocomplete="off" id="topic_content_model4" name="topic_content_model" class="hideAssistant4 valuesai4 cr_width_full">
                           <?php
foreach($all_models as $modelx)
{
echo '<option value="' . $modelx .'"';
echo '>' . esc_html($modelx) . esc_html(aiomatic_get_model_provider($modelx)) . '</option>';
}
?>
                           </select>   
                           </td>
                        </tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Prompt to be used for the Customer Reviews Analysis section of the article. You can use the following shortcodes: %%product_title%%, %%product_description%%, %%aff_url%%, %%product_author%%, %%offer_price%%, %%product_price%%, %%product_list_price%%, %%product_brand%%, %%product_isbn%%, %%product_upc%%, %%product_reviews%%, %%price_numeric%%, %%price_currency%%, %%product_asin%%, %%cart_url%%, %%list_price_numeric%%, %%product_imgs%%, %%search_keywords%%, %%language%%, %%writing_style%%, %%point_of_view%%, %%writing_tone%%, %%random_sentence%%, %%random_sentence2%%, %%blog_title%% - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators. If you have access to the Amazon API, you can set it up in the plugin and get access to the following advanced shortcodes also: %%product_score%%, %%product_edition%%, %%product_language%%, %%product_pages_count%%, %%product_publication_date%%, %%product_contributors%%, %%product_manufacturer%%, %%product_binding%%, %%product_product_group%%, %%product_rating%%, %%product_ean%%, %%product_part_no%%, %%product_model%%, %%product_warranty%%, %%product_color%%, %%product_is_adult%%, %%product_dimensions%%, %%product_date%%, %%product_size%%, %%product_unit_count%%", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Article Customer Reviews Analysis Prompt:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <textarea rows="2" cols="70" name="reviews_prompt" id="reviews_prompt4" placeholder="Enter your Customer Reviews Analysis prompts, one per line" class="valuesai4 cr_width_full">Write the content of a "Customer Reviews Analysis" section for a product review blog post for the following product: "%%product_title%%". The title of the blog post is: "%%post_title%%", in %%language%%. Style: %%writing_style%%. Tone: %%writing_tone%%. Point Of View: %%point_of_view%%. Use HTML for formatting. When applicable, add also HTML tables with WordPress styling (you can use WordPress table classes). If added, table data must be relevant, creative, short and simple. List of customer reviews: "%%product_reviews%%". </textarea>
                           </td>
                        </tr>
                        <tr>
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select the AI Model to be used for the Customer Reviews Analysis generator.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("AI Model For Customer Reviews Analysis Generator:", 'aiomatic-automatic-ai-content-writer');?></b>   
                           </td>
                           <td class="cr_min_width_200">
                           <select autocomplete="off" id="topic_reviews_model4" name="topic_reviews_model" class="hideAssistant4 valuesai4 cr_width_full">
                           <?php
foreach($all_models as $modelx)
{
echo '<option value="' . $modelx .'"';
echo '>' . esc_html($modelx) . esc_html(aiomatic_get_model_provider($modelx)) . '</option>';
}
?>
                           </select>   
                           </td>
                        </tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Prompt to be used for the Pros & Cons section of the article. You can use the following shortcodes: %%product_title%%, %%product_description%%, %%aff_url%%, %%product_author%%, %%offer_price%%, %%product_price%%, %%product_list_price%%, %%product_brand%%, %%product_isbn%%, %%product_upc%%, %%product_reviews%%, %%price_numeric%%, %%price_currency%%, %%product_asin%%, %%cart_url%%, %%list_price_numeric%%, %%product_imgs%%, %%search_keywords%%, %%language%%, %%writing_style%%, %%point_of_view%%, %%writing_tone%%, %%random_sentence%%, %%random_sentence2%%, %%blog_title%% - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators. If you have access to the Amazon API, you can set it up in the plugin and get access to the following advanced shortcodes also: %%product_score%%, %%product_edition%%, %%product_language%%, %%product_pages_count%%, %%product_publication_date%%, %%product_contributors%%, %%product_manufacturer%%, %%product_binding%%, %%product_product_group%%, %%product_rating%%, %%product_ean%%, %%product_part_no%%, %%product_model%%, %%product_warranty%%, %%product_color%%, %%product_is_adult%%, %%product_dimensions%%, %%product_date%%, %%product_size%%, %%product_unit_count%%", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Article Pros & Cons Prompt:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <textarea rows="2" cols="70" name="proscons_prompt" id="proscons_prompt4" placeholder="Enter your Pros & Cons prompts, one per line" class="valuesai4 cr_width_full">Write the content of a "Pros & Cons" section for a product review blog post for the following product: "%%product_title%%". The title of the blog post is: "%%post_title%%", in %%language%%. Style: %%writing_style%%. Tone: %%writing_tone%%. Point Of View: %%point_of_view%%.Use HTML for formatting. When applicable, add also HTML tables with WordPress styling (you can use WordPress table classes). If added, table data must be relevant, creative, short and simple. Product description: "%%product_description%%". </textarea>
                           </td>
                        </tr>
                        <tr>
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select the AI Model to be used for the Pros & Cons generator.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("AI Model For Pros & Cons Generator:", 'aiomatic-automatic-ai-content-writer');?></b>   
                           </td>
                           <td class="cr_min_width_200">
                           <select autocomplete="off" id="topic_proscons_model4" name="topic_proscons_model" class="hideAssistant4 valuesai4 cr_width_full">
                           <?php
foreach($all_models as $modelx)
{
echo '<option value="' . $modelx .'"';
echo '>' . esc_html($modelx) . esc_html(aiomatic_get_model_provider($modelx)) . '</option>';
}
?>
                           </select>   
                           </td>
                        </tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Prompt to be used for the Q&A of the article. You can use the following shortcodes: %%product_title%%, %%product_description%%, %%aff_url%%, %%product_author%%, %%offer_price%%, %%product_price%%, %%product_list_price%%, %%product_brand%%, %%product_isbn%%, %%product_upc%%, %%product_reviews%%, %%price_numeric%%, %%price_currency%%, %%product_asin%%, %%cart_url%%, %%list_price_numeric%%, %%product_imgs%%, %%search_keywords%%, %%language%%, %%writing_style%%, %%point_of_view%%, %%writing_tone%%, %%random_sentence%%, %%random_sentence2%%, %%blog_title%% - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators. If you have access to the Amazon API, you can set it up in the plugin and get access to the following advanced shortcodes also: %%product_score%%, %%product_edition%%, %%product_language%%, %%product_pages_count%%, %%product_publication_date%%, %%product_contributors%%, %%product_manufacturer%%, %%product_binding%%, %%product_product_group%%, %%product_rating%%, %%product_ean%%, %%product_part_no%%, %%product_model%%, %%product_warranty%%, %%product_color%%, %%product_is_adult%%, %%product_dimensions%%, %%product_date%%, %%product_size%%, %%product_unit_count%%", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Article Q&A Prompt:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <textarea rows="2" cols="70" name="qa_prompt" id="qa_prompt4" placeholder="Enter your Q&A prompts, one per line" class="valuesai4 cr_width_full">Write the content of a Q&A section for a product review blog post for the following product: "%%product_title%%". The title of the blog post is: "%%post_title%%", in %%language%%. Style: %%writing_style%%. Tone: %%writing_tone%%. Point Of View: %%point_of_view%%. Product description: "%%product_description%%".</textarea>
                           </td>
                        </tr>
                        <tr>
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select the AI Model to be used for the Q&A generator.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("AI Model For Q&A Generator:", 'aiomatic-automatic-ai-content-writer');?></b>   
                           </td>
                           <td class="cr_min_width_200">
                           <select autocomplete="off" id="topic_qa_model4" name="topic_qa_model" class="hideAssistant4 valuesai4 cr_width_full">
                           <?php
foreach($all_models as $modelx)
{
echo '<option value="' . $modelx .'"';
echo '>' . esc_html($modelx) . esc_html(aiomatic_get_model_provider($modelx)) . '</option>';
}
?>
                           </select>   
                           </td>
                        </tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Prompt to be used for the outro of the article. You can use the following shortcodes: %%product_title%%, %%product_description%%, %%aff_url%%, %%product_author%%, %%offer_price%%, %%product_price%%, %%product_list_price%%, %%product_brand%%, %%product_isbn%%, %%product_upc%%, %%product_reviews%%, %%price_numeric%%, %%price_currency%%, %%product_asin%%, %%cart_url%%, %%list_price_numeric%%, %%product_imgs%%, %%search_keywords%%, %%language%%, %%writing_style%%, %%point_of_view%%, %%writing_tone%%, %%random_sentence%%, %%random_sentence2%%, %%blog_title%% - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators. If you have access to the Amazon API, you can set it up in the plugin and get access to the following advanced shortcodes also: %%product_score%%, %%product_edition%%, %%product_language%%, %%product_pages_count%%, %%product_publication_date%%, %%product_contributors%%, %%product_manufacturer%%, %%product_binding%%, %%product_product_group%%, %%product_rating%%, %%product_ean%%, %%product_part_no%%, %%product_model%%, %%product_warranty%%, %%product_color%%, %%product_is_adult%%, %%product_dimensions%%, %%product_date%%, %%product_size%%, %%product_unit_count%%", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Article Outro Prompt:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <textarea rows="2" cols="70" name="outro_prompt" id="outro_prompt4" placeholder="Enter your outro prompts, one per line" class="valuesai4 cr_width_full">Write an outro for a product review blog post, for the product: "%%product_title%%". The post has the following title: "%%post_title%%", in %%language%%. Style: %%writing_style%%. Tone: %%writing_tone%%. Point Of View: %%point_of_view%%. Product description: "%%product_description%%". Add also an engaging final call to action link, in a clickable HTML format (don't use markdown language), leading to the link of the product: "%%aff_url%%".</textarea>
                           </td>
                        </tr>
                        <tr>
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select the AI Model to be used for the outro generator.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("AI Model For Outro Generator:", 'aiomatic-automatic-ai-content-writer');?></b>   
                           </td>
                           <td class="cr_min_width_200">
                           <select autocomplete="off" id="topic_outro_model4" name="topic_outro_model" class="hideAssistant4 valuesai4 cr_width_full">
                           <?php
foreach($all_models as $modelx)
{
echo '<option value="' . $modelx .'"';
echo '>' . esc_html($modelx) . esc_html(aiomatic_get_model_provider($modelx)) . '</option>';
}
?>
                           </select>   
                           </td>
                        </tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Prompt to be used for the excerpt of the article. You can use the following shortcodes: %%product_title%%, %%product_description%%, %%aff_url%%, %%product_author%%, %%offer_price%%, %%product_price%%, %%product_list_price%%, %%product_brand%%, %%product_isbn%%, %%product_upc%%, %%product_reviews%%, %%price_numeric%%, %%price_currency%%, %%product_asin%%, %%cart_url%%, %%list_price_numeric%%, %%product_imgs%%, %%search_keywords%%, %%language%%, %%writing_style%%, %%point_of_view%%, %%writing_tone%%, %%random_sentence%%, %%random_sentence2%%, %%blog_title%% - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators. If you have access to the Amazon API, you can set it up in the plugin and get access to the following advanced shortcodes also: %%product_score%%, %%product_edition%%, %%product_language%%, %%product_pages_count%%, %%product_publication_date%%, %%product_contributors%%, %%product_manufacturer%%, %%product_binding%%, %%product_product_group%%, %%product_rating%%, %%product_ean%%, %%product_part_no%%, %%product_model%%, %%product_warranty%%, %%product_color%%, %%product_is_adult%%, %%product_dimensions%%, %%product_date%%, %%product_size%%, %%product_unit_count%%", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Excerpt Prompt:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <textarea rows="2" cols="70" name="excerpt_prompt" id="excerpt_prompt4" placeholder="Enter your excerpt prompts, one per line" class="valuesai4 cr_width_full">Write a short excerpt for a product review blog post, for the product: "%%product_title%%". The post has the following title: "%%post_title%%", in %%language%%. Style: %%writing_style%%. Tone: %%writing_tone%%. Point Of View: %%point_of_view%%. The excerpt must be between 100 and 150 words. </textarea>
                           </td>
                        </tr>
                        <tr>
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select the AI Model to be used for the excerpt generator.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("AI Model For Excerpt Generator:", 'aiomatic-automatic-ai-content-writer');?></b>   
                           </td>
                           <td class="cr_min_width_200">
                           <select autocomplete="off" id="topic_excerpt_model4" name="topic_excerpt_model" class="hideAssistant4 valuesai4 cr_width_full">
                           <?php
foreach($all_models as $modelx)
{
echo '<option value="' . $modelx .'"';
echo '>' . esc_html($modelx) . esc_html(aiomatic_get_model_provider($modelx)) . '</option>';
}
?>
                           </select>   
                           </td>
                        </tr>
                        <tr><td colspan="2">
                              <h4><?php echo esc_html__("Advanced Prompting Options", 'aiomatic-automatic-ai-content-writer');?>:</h4>
                        </td></tr>
                        <tr>
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Run regex on prompts. To disable this feature, leave this field blank. No Regex separators are required here. You can add multiple Regex expressions, each on a different line.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Run Regex On Prompts:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <textarea rows="1" name="strip_by_regex_prompts" id="strip_by_regex_prompts4" placeholder="regex expression" class="valuesai4 cr_width_full"></textarea>
                           </td>
                        </tr>
                        <tr>
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Replace the above regex matches with this regex expression. If you want to strip matched content, leave this field blank. No Regex separators are required here. You can add multiple replacement expressions, each on a different line.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Replace Matches From Regex (Prompts):", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <textarea rows="1" name="replace_regex_prompts" id="replace_regex_prompts4" placeholder="regex replacement" class="valuesai4 cr_width_full"></textarea>
                           </td>
                        </tr>
                        <tr>
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select on which prompts do you want to run the above Regex. Possible values are (or any of their combinations): title, intro, sections, content, reviews, proscons, qa, outro, excerpt", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Run Above Regex On Prompts:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input id="run_regex_on4" name="run_regex_on" type="text" list="run_regex_on_list5" class="valuesai4 coderevolution_gutenberg_input" value="content"/>
<datalist id="run_regex_on_list5">
<option value="title">title</option>
<option value="intro">intro</option>
<option value="sections">sections</option>
<option value="content">content</option>
<option value="qa">Q&A</option>
<option value="outro">outro</option>
<option value="excerpt">excerpt</option>
</datalist> 
                           </td>
                        </tr>
                     <tr><td colspan="2">
                              <h3><?php echo esc_html__("Global Prompt Options", 'aiomatic-automatic-ai-content-writer');?>:</h3>
                        </td></tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("This will be prepended to each prompt sent by the plugin to the AI writer. You can use the following shortcodes: %%topic%%, %%language%%, %%writing_style%%, %%point_of_view%%, %%writing_tone%%, %%title%%, %%random_sentence%%, %%random_sentence2%%, %%post_original_title%%, %%blog_title%% - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators. You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Prepend Text To All Textual AI Prompts:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <textarea rows="2" cols="70" name="global_prepend" id="global_prepend4" placeholder="Global prompt prepend text" class="valuesai4 cr_width_full"></textarea>
                           </td>
                        </tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("This will be appended to each prompt sent by the plugin to the AI writer. You can use the following shortcodes: %%topic%%, %%language%%, %%writing_style%%, %%point_of_view%%, %%writing_tone%%, %%title%%, %%random_sentence%%, %%random_sentence2%%, %%post_original_title%%, %%blog_title%% - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators. You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Append Text To All Textual AI Prompts:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <textarea rows="2" cols="70" name="global_append" id="global_append4" placeholder="Global prompt append text" class="valuesai4 cr_width_full"></textarea>
                           </td>
                        </tr>
                     <tr><td colspan="2">
                              <h3><?php echo esc_html__("Automatic Linking Options", 'aiomatic-automatic-ai-content-writer');?>:</h3>
                        </td></tr>
                        <tr>
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select the linking method to use in posts.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Automatic Linking Type:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <select autocomplete="off" class="valuesai4 cr_width_full" id="link_type4" onchange="hideLinks('');" name="link_type">
                           <option value="disabled" selected><?php echo esc_html__("Disabled", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="internal"><?php echo esc_html__("Internal Links", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="manual"><?php echo esc_html__("Manual Links", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="mixed"><?php echo esc_html__("Mixed Links", 'aiomatic-automatic-ai-content-writer');?></option>
                           </select>   
                           </td>
                        </tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Set the maximum number of automatic links to add to created posts. You can also define custom ranges, like: 3-5. Please note that this feature will work best if you already have a considerable number of posts published on your site, which will be used for internal linking.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Maximum Number Of Automatic Links To Add To The Post Content:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="text" name="max_links" id="max_links4" placeholder="3-5" class="valuesai4 cr_width_full">
                           </td>
                        </tr>
                        <tr class="hidelinks">
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Enter a manual list of links, where the plugin will create links.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Manual List Of URLs (One Per Line):", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <textarea rows="1" cols="70" name="link_list" id="link_list4" placeholder="URL list (one per line)" class="valuesai4 cr_width_full"></textarea>
                           </td>
                        </tr>
                        <tr class="hidelinks">
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Do you want to add nofollow attribute to manually entered, external links?", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Add Nofollow Attribute To Manual Links:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="checkbox" id="link_nofollow4" name="link_nofollow" class="valuesai4">
                           </td>
                        </tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Set the post types where to create automatic links in posts. You can also add a comma separated list of multiple post types.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Post Types Where To Generate Automatic Links:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="text" name="link_post_types" id="link_post_types4" placeholder="post" class="valuesai4 cr_width_full">
                           </td>
                        </tr>
                     <tr><td colspan="2">
                              <h3><?php echo esc_html__("Advanced AI Text Generator Options", 'aiomatic-automatic-ai-content-writer');?>:</h3>
                        </td></tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Set the maximum number of API tokens to use with each request. This will define the length of the resulting API response. Each token usually consists of approximately 4 characters. Note that in this value the number of tokens sent to the API as an article prompt will also be counted. The maximum amount which can be set is 4000. For other models, the maximum is 2048.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Maximum Total Token Count To Use Per API Request:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="number" min="1" max="128000" name="max_tokens" id="max_tokens4" value="" placeholder="2048" class="valuesai4 cr_width_full">
                           </td>
                        </tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Set the maximum number of prompt API tokens to use with each request. This will define the length of the resulting API response. Each token usually consists of approximately 4 characters. This defines how much content does the API receive each time you call it. If the API gets more initial data, better quality results will be expected. The maximum amount which can be set is 1000.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Maximum Prompt Token Count To Use Per API Request:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="number" min="1" max="128000" name="max_seed_tokens" id="max_seed_tokens4" value="" placeholder="1000" class="valuesai4 cr_width_full">
                           </td>
                        </tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Set the maximum number of continue API tokens to use with each request. This will define the length of the resulting API response. Each token usually consists of approximately 4 characters. This defines how much content does the API receive each time you call it. If the API gets more initial data, better quality results will be expected. The maximum amount which can be set is 500.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Maximum Continue Token Count To Use Per API Request:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="number" min="1" max="128000" name="max_continue_tokens" id="max_continue_tokens4" value="" placeholder="500" class="valuesai4 cr_width_full">
                           </td>
                        </tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("What sampling temperature to use. Higher values means the model will take more risks. Try 0.9 for more creative applications, and 0 (argmax sampling) for ones with a well-defined answer. We generally recommend altering this or top_p but not both.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("AI Temperature:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="number" min="0" step="0.1" max="2" name="temperature" id="temperature4" value="" placeholder="1" class="valuesai4 cr_width_full">
                           </td>
                        </tr><tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("An alternative to sampling with temperature, called nucleus sampling, where the model considers the results of the tokens with top_p probability mass. So 0.1 means only the tokens comprising the top 10% probability mass are considered. We generally recommend altering this or temperature but not both.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("AI Top_p:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="number" min="0" max="1" step="0.1" name="top_p" id="top_p4" value="" placeholder="1" class="valuesai4 cr_width_full">
                           </td>
                        </tr><tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Number between -2.0 and 2.0. Positive values penalize new tokens based on whether they appear in the text so far, increasing the model's likelihood to talk about new topics.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("AI Presence Penalty:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="number" min="-2" step="0.1" max="2" name="presence_penalty" id="presence_penalty4" value="" placeholder="0" class="valuesai4 cr_width_full">
                           </td>
                        </tr><tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Number between -2.0 and 2.0. Positive values penalize new tokens based on their existing frequency in the text so far, decreasing the model's likelihood to repeat the same line verbatim.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("AI Frequency Penalty:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="number" min="0" max="2" step="0.1" name="frequency_penalty" id="frequency_penalty4" value="" placeholder="0" class="valuesai4 cr_width_full">
                           </td>
                        </tr>
                     <tr><td colspan="2">
                              <h3><?php echo esc_html__("Image Generator Options", 'aiomatic-automatic-ai-content-writer');?>:</h3>
                        </td></tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select the search query repetition mode, when searching royalty free images.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Search Query Repetition:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <select autocomplete="off" id="search_query_repetition4" name="search_query_repetition" class="valuesai4 cr_width_full">
                              <option value="0" selected><?php echo esc_html__("Use Different Search Queries For Images", 'aiomatic-automatic-ai-content-writer');?></option>
                              <option value="1"><?php echo esc_html__("Use The Same Search Query For Images", 'aiomatic-automatic-ai-content-writer');?></option>
                           </select>
                           </td>
                        </tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Do you want to enable the AI Image Generator and to replace Royalty Free Images with AI generated images? If you select 'Default Featured Image List', you can add the image URLs in the 'Default Featured Image List' settings field.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Article Image Source:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <select autocomplete="off" id="enable_ai_images4" onchange="hideImage('4');" name="enable_ai_images" class="valuesai4 cr_width_full">
                              <option value="0" selected><?php echo esc_html__("Royalty Free", 'aiomatic-automatic-ai-content-writer');?></option>
                              <option value="1"><?php echo esc_html__("OpenAI/AiomaticAPI", 'aiomatic-automatic-ai-content-writer');?></option>
                              <?php
                              if (isset($aiomatic_Main_Settings['stability_app_id']) && trim($aiomatic_Main_Settings['stability_app_id']) != '')
                              {
                              ?>
                              <option value="2"><?php echo esc_html__("Stability.AI", 'aiomatic-automatic-ai-content-writer');?></option>
                              <?php
                              }
                              ?>
                           </select>
                           </td>
                        </tr>
                        <tr class="hideImg4 cr_none">
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Set list of prompt commands (one on each line) you want to send to the AI image generator. This command can be any given task or order, based on which, it will generate images. You can use the following shortcodes here: %%post_title%%, %%random_sentence%%, %%random_sentence2%%, %%blog_title%%. The length of this command should not be greater than 1000 characters, otherwise the plugin will strip it to 1000 characters length. - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You can also add here a link to a .txt file, where you can add multiple prompts (one per line) and the plugin will select a random one at each run. You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators. You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                          echo '&nbsp;' . sprintf( wp_kses( __( "Please check some tips and tricks about writing prompt commands, <a href='%s' target='_blank'>here</a>. The [aicontent] shortcode is able to be used also here.", 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), 'https://coderevolution.ro/knowledge-base/faq/how-to-create-a-good-seed-prompt-command-for-aiomatic-image-generating-for-openai-dall-e-api/' );
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Prompt For The AI Image Generator:", 'aiomatic-automatic-ai-content-writer');?></b>&nbsp;<b><a href="https://coderevolution.ro/knowledge-base/faq/how-to-create-a-good-seed-prompt-command-for-aiomatic-image-generating-for-openai-dall-e-api/" target="_blank">&#9432;</a></b>
                           </td>
                           <td>
                           <textarea rows="2" cols="70" name="ai_command_image" id="ai_command_image4" placeholder="Please insert a command for the AI image generator" class="valuesai4 cr_width_full">A high detail image with no text of: "%%post_title%%"</textarea>
                           </td>
                        </tr>
                        <tr class="hideDalle4 cr_none">
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select the AI model you wish to use for image the image generator.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("AI Image Model:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <select autocomplete="off" id="image_model4" name="image_model" class="valuesai4 cr_width_full">
                              <option value="dalle2"selected><?php echo esc_html__("Dall-E 2", 'aiomatic-automatic-ai-content-writer');?></option>
                              <option value="dalle3"><?php echo esc_html__("Dall-E 3", 'aiomatic-automatic-ai-content-writer');?></option>
                              <option value="dalle3hd"><?php echo esc_html__("Dall-E 3 HD", 'aiomatic-automatic-ai-content-writer');?></option>
                           </select>
                           </td>
                        </tr>
                        <tr class="hideImg4 cr_none">
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Select the size of the generated image.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Generated Image Size:", 'aiomatic-automatic-ai-content-writer');?></b>   
                           </td>
                           <td class="cr_min_width_200">
                           <select autocomplete="off" id="model4" name="image_size" class="valuesai4 cr_width_full">
                              <option value="256x256"><?php echo esc_html__("256x256", 'aiomatic-automatic-ai-content-writer');?></option>
                              <option value="512x512"><?php echo esc_html__("512x512", 'aiomatic-automatic-ai-content-writer');?></option>
                              <option value="1024x1024" selected><?php echo esc_html__("1024x1024", 'aiomatic-automatic-ai-content-writer');?></option>
                           </select>  
                           </td>
                        </tr>
                        <tr><td colspan="2">
                              <h3><?php echo esc_html__("Posting Options", 'aiomatic-automatic-ai-content-writer');?>:</h3>
                        </td></tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Enter a HTML text that should be prepended to the AI generated content in each created post. You can use the following shortcodes: %%custom_html%%, %%custom_html2%%, %%product_title%%, %%product_description%%, %%aff_url%%, %%product_author%%, %%offer_price%%, %%product_price%%, %%product_list_price%%, %%product_brand%%, %%product_isbn%%, %%product_upc%%, %%product_reviews%%, %%price_numeric%%, %%price_currency%%, %%product_asin%%, %%cart_url%%, %%list_price_numeric%%, %%product_imgs%%, %%search_keywords%%, %%language%%, %%writing_style%%, %%point_of_view%%, %%writing_tone%%, %%random_sentence%%, %%random_sentence2%%, %%blog_title%%, %%random_image[keyword]%%, %%random_image_url[keyword]%%, %%random_video[keyword]%%, %%royalty_free_image_attribution%% - you can also use an optional parameter in the random_image and random_video shortcodes, which will add a percentage chance for the media to appear or not - example: %%random_video[keyword][60]%% - a video will appear in 60% of cases, in the rest of 40%, nothing will be returned by the shortcode - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("HTML Text To Prepend To AI Created Content:", 'aiomatic-automatic-ai-content-writer');?></b>&nbsp;<b><a href="https://coderevolution.ro/knowledge-base/faq/post-template-reference-advanced-usage/" target="_blank">&#9432;</a></b>
                           </td>
                           <td>
                           <textarea rows="2" cols="70" name="post_prepend" id="post_prepend4" placeholder="HTML content to prepend to the AI generated content" class="valuesai4 cr_width_full"></textarea>
                           </td>
                        </tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Enter a HTML text that should be appended to the AI generated content in each created post. You can use the following shortcodes: %%custom_html%%, %%custom_html2%%, %%product_title%%, %%product_description%%, %%aff_url%%, %%product_author%%, %%offer_price%%, %%product_price%%, %%product_list_price%%, %%product_brand%%, %%product_isbn%%, %%product_upc%%, %%product_reviews%%, %%price_numeric%%, %%price_currency%%, %%product_asin%%, %%cart_url%%, %%list_price_numeric%%, %%product_imgs%%, %%search_keywords%%, %%language%%, %%writing_style%%, %%point_of_view%%, %%writing_tone%%, %%random_sentence%%, %%random_sentence2%%, %%blog_title%%, %%random_image[keyword]%%, %%random_image_url[keyword]%%, %%random_video[keyword]%%, %%royalty_free_image_attribution%% - you can also use an optional parameter in the random_image and random_video shortcodes, which will add a percentage chance for the media to appear or not - example: %%random_video[keyword][60]%% - a video will appear in 60% of cases, in the rest of 40%, nothing will be returned by the shortcode - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("HTML Text To Append To AI Created Content:", 'aiomatic-automatic-ai-content-writer');?></b>&nbsp;<b><a href="https://coderevolution.ro/knowledge-base/faq/post-template-reference-advanced-usage/" target="_blank">&#9432;</a></b>
                           </td>
                           <td>
                           <textarea rows="2" cols="70" name="post_append" id="post_append4" placeholder="HTML content to append to the AI generated content" class="valuesai4 cr_width_full"></textarea>
                           </td>
                        </tr>
                        <tr>
                           <td class="cr_min_width_200">
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Custom AI generated content shortcode creator. If you wish to create content from multiple AI prompts, and use them in post content/post custom fields/taxonomies, you can configure this from here. Also, these shortcodes will be able to be used in custom fields or custom taxonomies which the plugin will create. Syntax for this field: shortcode_name => AI_MODEL_TO_USE @@ TEXTUAL_PROMPT_TO_USE (to specify multiple shortcodes and crawling values, separate them by a new line. Example: my_custom_shortcode => gpt-3.5-turbo-instruct @@ Write a short poem. Afterwards, you can use shortcodes in any settings field that supports shortcodes (ex: 'HTML Text To Append To AI Created Content' settings field), like this: %%my_custom_shortcode%%. Official format is %%name_of_custom_shortcode%%", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Custom Shortcode Creator (Optional):", 'aiomatic-automatic-ai-content-writer');?></b><span class="tool" data-tip="Supported models: <?php echo implode(',', aiomatic_get_all_models());?>">&nbsp;&#9432;</span>
                           </td>
                           <td>
                           <textarea rows="2" cols="70" name="custom_shortcodes" id="custom_shortcodes4" placeholder="shortcode_name => AI_MODEL @@ AI_PROMPT" class="valuesai4 cr_width_full"></textarea>
                           </td>
                        </tr>
                        <tr>
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("The AI writer might add the title of the post to the created post content. Check this checkbox if you want to remove the title from the post content.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Strip Title From Content:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="checkbox" id="strip_title4" name="strip_title" class="valuesai4>
                           </td>
                        </tr>
                        <tr>
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px"><?php echo esc_html__("Do you want to skip spinning of posts generated by this rule?", 'aiomatic-automatic-ai-content-writer');?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Do Not Spin Posts Generated By This Rule:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="checkbox" id="skip_spin4" name="skip_spin" class="valuesai4">               
                           </td>
                        </tr>
                        <tr>
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px"><?php echo esc_html__("Do you want to skip translating of posts generated by this rule?", 'aiomatic-automatic-ai-content-writer');?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Do Not Translate Posts Generated By This Rule:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <input type="checkbox" id="skip_translate4" name="skip_translate" class="valuesai4">               
                           </td>
                        </tr>
                        <tr>
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Run regex on post content. To disable this feature, leave this field blank. No Regex separators are required here. You can add multiple Regex expressions, each on a different line.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Run Regex On Content:", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <textarea rows="1" name="strip_by_regex" id="strip_by_regex4" placeholder="regex expression" class="valuesai4 cr_width_full"></textarea>
                           </td>
                        </tr>
                        <tr>
                           <td>
                                 <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
                                       <?php
                                          echo esc_html__("Replace the above regex matches with this regex expression. If you want to strip matched content, leave this field blank. No Regex separators are required here. You can add multiple replacement expressions, each on a different line.", 'aiomatic-automatic-ai-content-writer');
                                          ?>
                                    </div>
                                 </div>
                                 <b><?php echo esc_html__("Replace Matches From Regex (Content):", 'aiomatic-automatic-ai-content-writer');?></b>
                           </td>
                           <td>
                           <textarea rows="1" name="replace_regex" id="replace_regex4" placeholder="regex replacement" class="valuesai4 cr_width_full"></textarea>
                           </td>
                        </tr>
                     </table>
                  </div>
               </div>
               <div class="codemodalfzr-footer">
                  <br/>
                  <h3 class="cr_inline">Aiomatic Automatic Post Generator</h3>
                  <span id="aiomatic_ok4" class="codeokfzr cr_inline">OK&nbsp;</span>
                  <br/><br/>
               </div>
            </div>
                           </div>
                           </div>
                           </div>
                           </div>
         </div>
      </div>
<div id="hrdiv">
<div id="hrwrap">
	<hr/>
	<h2 class="aiomatic-middle aiomatic-big"><?php echo esc_html__("Generated Results", 'aiomatic-automatic-ai-content-writer'); ?></h2>
</div>
	</div><!-- /hrdiv -->

<div id="titlediv">
<div id="titlewrap">
	<h2 class="top_heading"><?php echo esc_html__("Post Title", 'aiomatic-automatic-ai-content-writer'); ?></h2>
	<input type="text" name="post_title" size="30" value="" id="title_advanced" class="coderevolution_gutenberg_input aiomatic-big-font" onchange="aiomatic_content_empty('post_content_advanced');" spellcheck="true" autocomplete="off" placeholder="Post title">
</div>
	</div><!-- /titlediv -->
			
			<hr/>
			<h2 class="top_heading"><?php echo esc_html__("Post Content", 'aiomatic-automatic-ai-content-writer'); ?></h2>
	<?php
          $settings = array(
            'textarea_name' => 'post_content_advanced',
            'media_buttons' => true,
            'quicktags' => true,
            'tabindex' => '4'
          );
          wp_editor( '', 'post_content_advanced', $settings );
		  wp_nonce_field( 'create_post', 'create_post_nonce' );
        ?>

<div id="publishdiv">
<div id="publishwrap">
<hr/>
<div id="major-publishing-actions">
	<div class="coderevolution_gutenberg_input" id="publishing-action">
		<span class="spinner"></span>
					<input type="submit" name="publish" id="post_publish_advanced" class="coderevolution_gutenberg_input button button-primary button-large" value="Create Post" disabled>				</div>
					
	<div class="clear"></div>
</div>
</div>
	<div class="inside">
		<div id="publish-slug-box" class="hide-if-no-js">
				</div>
			</div></div><!-- /publishdiv -->

<br/><br/>
<div id="templdiv">
<div id="templwrap">
<hr/>
<h2 class="top_heading"><div class="tool" data-tip="Save or load your templates for content creation. These templates will be stored and accessible only from your user account."><?php echo esc_html__("Advanced Content Templates", 'aiomatic-automatic-ai-content-writer'); ?>&nbsp;&#9072;</div></h2>
<div class="aiomatic-minor-publishing-actions">
<input type="button" name="save_template_advanced" id="save_template_advanced" onclick="aiomatic_save_template_advanced()" class="button button-primary button-large" value="Save New Template">&nbsp;
<input type="button" name="load_template_advanced" id="load_template_advanced" onclick="aiomatic_load_template_advanced()" class="button button-primary button-large" value="Load Selected Template">&nbsp;
<input type="button" name="delete_template_advanced" id="delete_template_advanced" onclick="aiomatic_delete_template_advanced()" class="button button-primary button-large" value="Delete Selected Template">&nbsp;
<input type="button" name="import_template_advanced" id="import_template_advanced" onclick="aiomatic_import_template_advanced()" class="button button-primary button-large" value="Import Templates From File">&nbsp;
<input type="button" name="export_template_advanced" id="export_template_advanced" onclick="aiomatic_export_template_advanced()" class="button button-primary button-large" value="Export Templates To File">&nbsp;
<input type="file" id="import_template_file_advanced" name="import_template_file_advanced" class="cr_none" accept=".json" />
</div>
	<select class="coderevolution_gutenberg_input" id="template_manager_advanced">
		<option value="Default Template"><?php echo esc_html__("Default Template", 'aiomatic-automatic-ai-content-writer');?></option>
<?php
$user_id = get_current_user_id(); 
if($user_id == 0)
{
	aiomatic_log_to_file('No user logged in, cannot find templates!');
}
else
{
	$key = 'aiomatic_templates_advanced'; 
	$single = true; 
	$aiomatic_templates = get_user_meta( $user_id, $key, $single );
	if(is_array($aiomatic_templates))
	{
		foreach($aiomatic_templates as $tn => $template_name)
		{
			echo '<option value="' . $tn . '">' . $tn . '</option>';
		}
	}
}
?>
	</select>
</div>
</div><!-- /templdiv -->
<div id="tutodiv">
<div id="tutowrap">
<hr/>
<h2 class="top_heading"><div><?php echo esc_html__("Tutorial Video:", 'aiomatic-automatic-ai-content-writer'); ?></div></h2>
<p class="cr_center"><div class="embedtool"><iframe src="https://www.youtube.com/embed/rlDtQ8qgGYg" frameborder="0" allowfullscreen></iframe></div></p>
</div>
</div><!-- /tutodiv -->			

</div><!-- /post-body-content -->

<div id="postbox-container-1" class="postbox-container">
<div id="side-sortables" class="meta-box-sortables ui-sortable">

<div class="postbox">
<div class="postbox-header"><h2 class="hndle ui-sortable-handle"><div class="tool" data-tip="Set the general parameters for your generated content."><?php echo esc_html__("Post Options", 'aiomatic-automatic-ai-content-writer');?>&nbsp;&#9072;
                              </div></h2>
</div><div class="inside">
<div class="submitbox" id="otherpost">

<div id="other-publishing">


	<div class="aiomatic-minor-publishing-actions">
	<div class="cr-align-left">
	<div class="tool" data-tip="Set the post type."><?php echo esc_html__("Post Type", 'aiomatic-automatic-ai-content-writer');?>:&nbsp;&#9072;
                              </div>
							</div>
							<select id="submit_type_advanced" name="submit_type_advanced" class="coderevolution_gutenberg_input">
<?php
foreach ( get_post_types( '', 'names' ) as $post_type ) {
   if(strstr($post_type, 'aiomatic_'))
   {
      continue;
   }
   echo '<option value="' . esc_attr($post_type) . '"';
   echo '>' . esc_html($post_type) . '</option>';
}
?>
							</select> 
					<div class="clear"></div>
	<div class="cr-align-left">
	<div class="tool" data-tip="Set the post status."><?php echo esc_html__("Status", 'aiomatic-automatic-ai-content-writer');?>:&nbsp;&#9072;
                              </div>
							</div>
							<select id="submit_status_advanced" name="submit_status_advanced" class="coderevolution_gutenberg_input">
							<option value="draft" selected><?php echo esc_html__("Draft", 'aiomatic-automatic-ai-content-writer');?></option>
							<option value="pending"><?php echo esc_html__("Pending", 'aiomatic-automatic-ai-content-writer');?></option>
							<option value="publish"><?php echo esc_html__("Published", 'aiomatic-automatic-ai-content-writer');?></option>
							<option value="private"><?php echo esc_html__("Private", 'aiomatic-automatic-ai-content-writer');?></option>
							<option value="trash"><?php echo esc_html__("Trash", 'aiomatic-automatic-ai-content-writer');?></option>
							</select> 
					<div class="clear"></div>
					<div class="cr-align-left">
	<div class="tool" data-tip="Stick this post to the front page."><?php echo esc_html__("Sticky", 'aiomatic-automatic-ai-content-writer');?>:&nbsp;&#9072;
                              </div>
							</div>
							<select id="post_sticky_advanced" name="post_sticky_advanced" class="coderevolution_gutenberg_input">
							<option value="no"><?php echo esc_html__("No", 'aiomatic-automatic-ai-content-writer');?></option>
							<option value="yes"><?php echo esc_html__("Yes", 'aiomatic-automatic-ai-content-writer');?></option>
							</select> 
					<div class="clear"></div>
					<div class="cr-align-left">
	<div class="tool" data-tip="Set the post author."><?php echo esc_html__("Author", 'aiomatic-automatic-ai-content-writer');?>:&nbsp;&#9072;
                              </div>
							</div>
<?php
	$curruser = get_current_user_id();
    wp_dropdown_users(['class' => 'coderevolution_gutenberg_input', 'id' => 'post_author_advanced', 'name' => 'post_author_advanced', 'selected' => $curruser, 'role__in' => array('administrator', 'editor', 'author', 'contributor')]);
?>
					<div class="clear"></div>
					<div class="cr-align-left">
	<div class="tool" data-tip="Set the post publish date."><?php echo esc_html__("Publish Date", 'aiomatic-automatic-ai-content-writer');?>:&nbsp;&#9072;
                              </div>
							</div>
<?php
$date1x = new DateTime('now', aiomatic_get_blog_timezone());
?>
							<input type="datetime-local" id="post_date_advanced" name="post_date_advanced" value="<?php echo $date1x->format('Y-m-d H:i:s'); ?>" class="coderevolution_gutenberg_input" />
					<div class="clear"></div>
					<div class="cr-align-left">
	<div class="tool" data-tip="Set the post categories."><?php echo esc_html__("Post Categories", 'aiomatic-automatic-ai-content-writer');?>:&nbsp;&#9072;
                              </div>
							</div>
							<?php
$default_category = get_option('default_category');
$args = array(
	'orderby'          => 'name',
	'hide_empty'       => 0,
	'echo'             => 0,
	'class'            => 'coderevolution_gutenberg_input',
	'id'               => 'post_category_advanced',
	'name'             => 'post_category_advanced',
	'selected'         => $default_category
);
$select_cats = wp_dropdown_categories($args);
$select_cats = str_replace( "name='post_category_advanced'", "name='post_category_advanced[]' multiple='multiple'", $select_cats );
$select_cats = str_replace( 'name="post_category_advanced"', 'name="post_category_advanced[]" multiple="multiple"', $select_cats );
echo $select_cats;
?>
					<div class="clear"></div><div class="cr-align-left">
	<div class="tool" data-tip="Set the post tags."><?php echo esc_html__("Post Tags", 'aiomatic-automatic-ai-content-writer');?>:&nbsp;&#9072;
                              </div>
							</div>
							<input id="post_tags_advanced" name="post_tags_advanced" type="text" list="post_tags_list2" class="coderevolution_gutenberg_input" value="" placeholder="Tag list"/>
							<datalist id="post_tags_list2">
<?php
$xtags = get_tags(array(
  'hide_empty' => false
));
if(!is_wp_error($xtags))
{
	foreach ($xtags as $tag) {
		echo '<option>' . $tag->name . '</option>';
	}
}
?>
							</datalist>
<small class="cr-align-left coderevolution_gutenberg_input"><?php echo esc_html__("Separate tags with commas", 'aiomatic-automatic-ai-content-writer');?></small>
					<div class="clear"></div>
	</div>

	<div class="clear"></div>
</div>
</div>
	</div>
</div>

<div class="postbox">
<div class="postbox-header"><h2 class="hndle ui-sortable-handle"><?php echo esc_html__("Featured Image", 'aiomatic-automatic-ai-content-writer');?></h2>
</div><div class="inside">
<div class="submitbox" id="submitpost">

<div id="minor-publishing">
	<div class="aiomatic-minor-publishing-actions">
<?php
$image = '<div class="coderevolution_gutenberg_input"><img id="aiomatic-preview-image-advanced"/></div>';
echo $image; ?>
 <input type="hidden" name="aiomatic_image_id_advanced" id="aiomatic_image_id_advanced" value="" class="regular-text" />
 <input type='button' class="button-primary" value="<?php esc_attr_e( 'Select an image', 'aiomatic-automatic-ai-content-writer' ); ?>" id="aiomatic_media_manager_advanced"/>


	<div class="clear"></div>
	</div>

	<div class="clear"></div>
</div>
</div>
	</div>
</div>

</div></div>
</div><!-- /post-body -->
<br class="clear">
</form><!-- /poststuff -->
</div>
</div>
<?php
}
?>