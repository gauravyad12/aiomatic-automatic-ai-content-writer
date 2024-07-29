<?php
function aiomatic_playground_panel()
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
<h2 class="cr_center"><?php echo esc_html__("Aiomatic Playground", 'aiomatic-automatic-ai-content-writer');?></h2>

</div>


<div class="wrap gs_popuptype_holder">
        <nav class="nav-tab-wrapper">
            <a href="#tab-0" class="nav-tab"><?php echo esc_html__("Tutorial", 'aiomatic-automatic-ai-content-writer');?></a>
            <a href="#tab-1" class="nav-tab"><?php echo esc_html__("Text Completion", 'aiomatic-automatic-ai-content-writer');?></a>
            <a href="#tab-2" class="nav-tab"><?php echo esc_html__("Text Editing", 'aiomatic-automatic-ai-content-writer');?></a>
            <a href="#tab-3" class="nav-tab"><?php echo esc_html__("DALL-E 2 Image Generator", 'aiomatic-automatic-ai-content-writer');?></a>
            <a href="#tab-8" class="nav-tab"><?php echo esc_html__("DALL-E 3 Image Generator", 'aiomatic-automatic-ai-content-writer');?></a>
            <a href="#tab-4" class="nav-tab"><?php echo esc_html__("Stable Diffusion Image Generator", 'aiomatic-automatic-ai-content-writer');?></a>
            <a href="#tab-11" class="nav-tab"><?php echo esc_html__("Midjourney Image Generator", 'aiomatic-automatic-ai-content-writer');?></a>
            <a href="#tab-5" class="nav-tab"><?php echo esc_html__("Aiomatic Chat", 'aiomatic-automatic-ai-content-writer');?></a>
            <a href="#tab-6" class="nav-tab"><?php echo esc_html__("Whisper Speech To Text", 'aiomatic-automatic-ai-content-writer');?></a>
            <a href="#tab-7" class="nav-tab"><?php echo esc_html__("Text Moderation", 'aiomatic-automatic-ai-content-writer');?></a>
            <a href="#tab-9" class="nav-tab"><?php echo esc_html__("Plagiarism Checker", 'aiomatic-automatic-ai-content-writer');?></a>
            <a href="#tab-10" class="nav-tab"><?php echo esc_html__("AI Content Checker", 'aiomatic-automatic-ai-content-writer');?></a>
        </nav>
        <div id="tab-0" class="tab-content">
        <br/>
        <h2><?php echo esc_html__("AI Playground", 'aiomatic-automatic-ai-content-writer');?></h2>
        <p>
        <?php echo esc_html__("Welcome to this comprehensive tutorial on the 'AI Playground' functionality of the Aiomatic plugin. This powerful tool harnesses the capabilities of artificial intelligence to provide a wide range of features that can enhance your digital experience. In this tutorial, we'll cover several key functionalities of the AI Playground, including text completion, text editing, image generation using AI technologies like DALL-E 2 and Stable Diffusion, a chatbot feature, speech-to-text conversion using the Whisper API, and text moderation. Each of these features can be used in various ways to generate and manage content, interact with users, and more.", 'aiomatic-automatic-ai-content-writer');?>
</p>
<p>
<?php echo esc_html__("Please note that you will also be able to use the shortcodes provided at the bottom of the forms which can be used in the AI Playground. These will add the same forms also to the front end of your site.", 'aiomatic-automatic-ai-content-writer');?>
</p>
<p>
<?php echo esc_html__("Please check below the available playgrounds to test the plugin's features:", 'aiomatic-automatic-ai-content-writer');?>
</p>
<h4><?php echo esc_html__("Text Completion", 'aiomatic-automatic-ai-content-writer');?></h4>

<?php echo esc_html__("Text completion is a feature where the AI can continue a text entered by the user. To use this feature, you would typically enter a piece of text, and the AI would generate a continuation of that text. This could be used for a variety of purposes, such as generating ideas for a story or completing a sentence in a natural-sounding way.", 'aiomatic-automatic-ai-content-writer');?>

<h4><?php echo esc_html__("Text Editing", 'aiomatic-automatic-ai-content-writer');?></h4>

<?php echo esc_html__("Text editing is a feature where the AI can be instructed to edit a text in multiple different ways. For example, you might input a piece of text and ask the AI to rewrite it in a more formal or informal tone, to simplify it, or to correct any grammatical errors. This could be useful for improving the quality of written content or adapting it for different audiences.", 'aiomatic-automatic-ai-content-writer');?>

<h4><?php echo esc_html__("Image Generation Using DALL-E 2 and Stable Diffusion", 'aiomatic-automatic-ai-content-writer');?></h4>

<?php echo esc_html__("Image generation is a feature where the AI generates images based on prompts. You would typically enter a text prompt, and the AI would generate an image that represents that prompt. This could be used for a variety of creative purposes, such as generating artwork or visualizing concepts. Please note that as of my last update in September 2021, DALL-E 2 and Stable Diffusion were not released or announced, so I can't provide specific details about these technologies.", 'aiomatic-automatic-ai-content-writer');?>

<h4><?php echo esc_html__("Chatbot Feature", 'aiomatic-automatic-ai-content-writer');?></h4>

<?php echo esc_html__("The chatbot feature allows you to chat with an AI bot, ask questions, and get replies. You would typically enter a question or statement, and the AI would generate a response. This could be used for a variety of purposes, such as answering frequently asked questions, providing customer support, or just having a conversation.", 'aiomatic-automatic-ai-content-writer');?>

<h4><?php echo esc_html__("Speech to Text Using the Whisper API", 'aiomatic-automatic-ai-content-writer');?></h4>

<?php echo esc_html__("Speech to text is a feature where the AI converts speech to text. You would typically record a piece of audio, and the AI would transcribe it into text. This could be useful for a variety of purposes, such as transcribing interviews, dictating notes, or making audio content more accessible.", 'aiomatic-automatic-ai-content-writer');?>

<h4><?php echo esc_html__("Text Moderation", 'aiomatic-automatic-ai-content-writer');?></h4>

<?php echo esc_html__("Text moderation is a feature where the AI filters unwanted content from your site. You would typically set up rules or criteria for what constitutes unwanted content, and the AI would review incoming content and filter out anything that meets those criteria. This could be used for a variety of purposes, such as preventing spam, blocking offensive content, or maintaining a positive community environment.", 'aiomatic-automatic-ai-content-writer');?>
        
<h4><?php echo esc_html__("Plagiarism Checker", 'aiomatic-automatic-ai-content-writer');?></h4>

<?php echo esc_html__("Check text for plagiarism, using the PlagiarismCheck API.", 'aiomatic-automatic-ai-content-writer');?>

<h4><?php echo esc_html__("AI Content Detector", 'aiomatic-automatic-ai-content-writer');?></h4>

<?php echo esc_html__("Check texts and detect if are fully AI generated or if they contain chunks of AI generated content, using the PlagiarismCheck API.", 'aiomatic-automatic-ai-content-writer');?>

<h4><a href="https://platform.openai.com/playground/chat" target="_blank"><?php echo esc_html__("Check Also OpenAI's Playground", 'aiomatic-automatic-ai-content-writer');?></a></h4>
<br/>
        </div>
        <div id="tab-1" class="tab-content">
        <br/>
        <?php echo aiomatic_form_shortcode(array( 'temperature' => 'default', 'top_p' => 'default', 'presence_penalty' => 'default', 'frequency_penalty' => 'default', 'model' => 'default' ));?>
        <br/>
        <p class="cr_image_center"><?php echo esc_html__("Shortcode alternative: ", 'aiomatic-automatic-ai-content-writer');?><b>[aiomatic-text-completion-form]</b></p>
        </div>
        <div id="tab-2" class="tab-content">
        <br/>
        <?php echo aiomatic_edit_shortcode(array( 'temperature' => 'default', 'top_p' => 'default', 'model' => 'default' ));?>
        <br/>
        <p class="cr_image_center"><?php echo esc_html__("Shortcode alternative: ", 'aiomatic-automatic-ai-content-writer');?><b>[aiomatic-text-editing-form]</b></p>
        </div>
        <div id="tab-3" class="tab-content">
        <br/>
        <?php echo aiomatic_image_shortcode(array( 'image_size' => 'default', 'image_model' => 'dalle2' ));?>
        <br/>
        <p class="cr_image_center"><?php echo esc_html__("Shortcode alternative: ", 'aiomatic-automatic-ai-content-writer');?><b>[aiomatic-image-generator-form image_model="dalle2"]</b></p>
        </div>
        <div id="tab-8" class="tab-content">
        <br/>
        <?php echo aiomatic_image_shortcode(array( 'image_size' => 'default', 'image_model' => 'dalle3' ));?>
        <br/>
        <p class="cr_image_center"><?php echo esc_html__("Shortcode alternative: ", 'aiomatic-automatic-ai-content-writer');?><b>[aiomatic-image-generator-form image_model="dalle3"]</b></p>
        </div>
        <div id="tab-4" class="tab-content">
        <br/>
        <?php echo aiomatic_stable_image_shortcode(array( 'image_size' => 'default' ));?>
        <br/>
        <p class="cr_image_center"><?php echo esc_html__("Shortcode alternative: ", 'aiomatic-automatic-ai-content-writer');?><b>[aiomatic-stable-image-generator-form]</b></p>
        </div>
        <div id="tab-11" class="tab-content">
        <br/>
        <?php echo aiomatic_midjourney_image_shortcode(array( 'image_size' => 'default' ));?>
        <br/>
        <p class="cr_image_center"><?php echo esc_html__("Shortcode alternative: ", 'aiomatic-automatic-ai-content-writer');?><b>[aiomatic-midjourney-image-generator-form]</b></p>
        </div>
        <div id="tab-5" class="tab-content">
        <br/>
        <?php echo aiomatic_chat_shortcode(array( 'temperature' => '', 'top_p' => '', 'presence_penalty' => '', 'frequency_penalty' => '', 'model' => '', 'instant_response' => '', 'show_in_window' => 'off' ));?>
        <br/>
        <p class="cr_image_center"><?php echo esc_html__("Shortcode alternative: ", 'aiomatic-automatic-ai-content-writer');?><b>[aiomatic-chat-form]</b></p>
        </div>
        <div id="tab-6" class="tab-content">
        <br/>
        <?php echo aiomatic_audio_convert(array());?>
        <br/>
        <p class="cr_image_center"><?php echo esc_html__("Shortcode alternative: ", 'aiomatic-automatic-ai-content-writer');?><b>[aiomatic-audio-converter]</b></p>
        </div>
        <div id="tab-7" class="tab-content">
        <br/>
        <?php echo aiomatic_text_moderation(array());?>
        <br/>
        <p class="cr_image_center"><?php echo esc_html__("Shortcode alternative: ", 'aiomatic-automatic-ai-content-writer');?><b>[aiomatic-text-moderation]</b></p>
        </div>
        <div id="tab-9" class="tab-content">
        <br/>
        <?php echo aiomatic_text_plagiarism(array());?>
        <br/>
        <p class="cr_image_center"><?php echo esc_html__("Shortcode alternative: ", 'aiomatic-automatic-ai-content-writer');?><b>[aiomatic-plagiarism-check]</b></p>
        </div>
        <div id="tab-10" class="tab-content">
        <br/>
        <?php echo aiomatic_text_ai_detector(array());?>
        <br/>
        <p class="cr_image_center"><?php echo esc_html__("Shortcode alternative: ", 'aiomatic-automatic-ai-content-writer');?><b>[aiomatic-ai-detector]</b></p>
        </div>
    </div>
<?php
}
?>