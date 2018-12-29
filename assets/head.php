<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js no-svg">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php
    wp_head();
    ?>
</head>
<?php
echo '<body '.smoothie_body_bgstyle().' '; body_class(); echo '>';
