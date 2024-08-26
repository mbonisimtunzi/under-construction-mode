<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Under Construction</title>
    <?php wp_head(); ?>
    <style>
        body {
            <?php
            $background_color = get_option('ucm_background_color', '#000000');
            $background_image = get_option('ucm_background_image', '');
            $overlay_opacity = get_option('ucm_overlay_opacity', 70);
            ?>
            background-color: <?php echo esc_attr($background_color); ?>;
            <?php if ($background_image): ?>
            background-image: url('<?php echo esc_url($background_image); ?>');
            background-size: cover;
            background-position: center;
            <?php endif; ?>
            color: #fff;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            overflow: hidden;
        }
        .ucm-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, <?php echo esc_attr($overlay_opacity / 100); ?>);
            z-index: 1;
        }
        .ucm-container {
            position: relative;
            z-index: 2;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="ucm-overlay"></div>
    <div class="ucm-container">
        <h1>We'll Be Back Soon!</h1>
        <p><?php echo esc_html(get_option('ucm_message', 'Our website is currently undergoing maintenance. Please check back later.')); ?></p>
    </div>
    <?php wp_footer(); ?>
</body>
</html>
