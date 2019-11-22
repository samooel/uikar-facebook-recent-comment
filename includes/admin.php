<?php

/**
 * Register a custom menu page.
 */
function uikar_fbcomment_add_custom_page() {
    add_submenu_page(
            'options-general.php',__('UIKAR Facebook comment', 'uikar-fbcomments'), __('UIKAR Facebook comment', 'uikar-fbcomments'), 'manage_options', 'uikarfb', 'uikar_fbcomment_custom_menu', plugins_url('uikar-form-builder/assets/img/icon.png'), 72
    );
}

add_action('admin_menu', 'uikar_fbcomment_add_custom_page');



/**
 * Display a custom menu page
 */
function uikar_fbcomment_custom_menu() {
    ?>
    <form method="post" action="options.php">
        <?php wp_nonce_field('update-options'); ?>
        <table class="form-table">
            <tr valign="top">
                <th scope="row"><?php _e('Access Token', 'uikar-fbcomments'); ?></th>
                <td><input type="text" name="accessToken" value="<?php echo get_option('accessToken'); ?>" size="50" /></td>
            </tr>
            <tr valign="top">
                <th scope="row"><?php _e('Facebook Page ID', 'uikar-fbcomments'); ?></th>
                <td><input type="text" name="FacebookPageID" value="<?php echo get_option('FacebookPageID'); ?>" size="50" /></td>
            </tr>
            <tr valign="top">
                <th scope="row"><?php _e('Number of displayed comment', 'uikar-fbcomments'); ?></th>
                <td>
                    <select name="postCounter">
                        <?php
                        $counterNumber = get_option('postCounter');
                        for($i=1;$i<10;$i++)
                        {
                            if($i == $counterNumber)
                            {
                                $selected="selected";
                            }
                            else{
                                $selected="";
                            }?>
                            <option value="<?php echo($i)?>>" <?php echo($selected);?>><?php echo($i)?></option>
                        <?php }?>
                    </select>
                </td>
                <td><a href="https://developers.facebook.com/tools/explorer" target="_blank"><?php _e('Facebook Get Access Token', 'uikar-fbcomments');?></a></td>
            </tr>
        </table>
        <p><?php _e('To show facebook Comments, use this shortcode', 'uikar-fbcomments');?>: [uikar_fbcomments]</p>
        <input type="hidden" name="action" value="update" />
        <input type="hidden" name="page_options" value="accessToken,FacebookPageID,postCounter" />
        <div class="submit">
            <input type="submit" class="button-primary" value="<?php _e('Save Settings', 'uikar-fbcomments') ?>" />
        </div>
    </form>
    <?php
}



