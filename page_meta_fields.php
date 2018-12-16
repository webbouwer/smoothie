<?php
/********** PAGE CUSTOM META FIELDS **********/
add_action("add_meta_boxes", "add_childpage_section_box");
function add_childpage_section_box()
{
    add_meta_box(
        "childpage-section-box",
        "Childpage settings",
        "childpage_section_fields",
        "page",
        "side", // normal
        "high",
        null);
}

function childpage_section_fields($object)
{
wp_nonce_field(basename(__FILE__), "meta-box-nonce");
$dsp = get_post_meta($object->ID, "meta-box-display-childpages", true);
$parent = get_post_meta($object->ID, "meta-box-display-parentcontent", true);
$childalign = get_post_meta($object->ID, "meta-box-display-alignment", true);
$coverimage = get_post_meta($object->ID, "meta-box-display-coverimage", true);
?>
<p><label for="meta-box-display-childpages"><?php echo __('Display Childpages', 'smoothie'); ?></label>
<select name="meta-box-display-childpages" id="meta-box-display-childpages">
<option value="none" <?php selected( $dsp, 'none' ); ?>><?php echo __('Do not display', 'smoothie'); ?></option>
<option value="display" <?php selected( $dsp, 'display' ); ?>><?php echo __('Display', 'smoothie'); ?></option>
</select>
</p>
<p><label for="meta-box-display-parentcontent"><?php echo __('Parent content display', 'smoothie'); ?></label>
<select name="meta-box-display-parentcontent" id="meta-box-display-parentcontent">
<option value="none" <?php selected( $parent, 'none' ); ?>><?php echo __('Do not display', 'smoothie'); ?></option>
<option value="intr" <?php selected( $parent, 'top' ); ?>><?php echo __('Display on top of childpages', 'smoothie'); ?></option>
</select>
</p>



<?php
}

function save_page_meta_box($post_id, $post, $update)
{
    if (!isset($_POST["meta-box-nonce"]) || !wp_verify_nonce($_POST["meta-box-nonce"], basename(__FILE__)))
        return $post_id;

    if(!current_user_can("edit_post", $post_id))
        return $post_id;


    // childpage sections
    if( isset( $_POST['meta-box-display-childpages'] ) )
        update_post_meta( $post_id, 'meta-box-display-childpages', $_POST['meta-box-display-childpages'] );
    if( isset( $_POST['meta-box-display-parentcontent'] ) )
        update_post_meta( $post_id, 'meta-box-display-parentcontent', $_POST['meta-box-display-parentcontent'] );

}
add_action("save_post", "save_page_meta_box", 10, 3);
?>
