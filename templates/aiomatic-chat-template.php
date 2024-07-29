<?php
/*
Template Name: Aiomatic Chat Template
Template Post Type: page, aiomatic_remote_chat
*/
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">
            <?php
            while ( have_posts() ) : the_post();
                the_content();
            endwhile;
            ?>
        </main>
    </div>
    <?php wp_footer(); ?>
</body>
</html>