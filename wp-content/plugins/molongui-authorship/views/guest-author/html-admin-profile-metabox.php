<?php
defined( 'ABSPATH' ) or exit;

?>
<div class="molongui-metabox">

    <div class="m-flex-container m-settings-container">

        <div class="m-flex-row">

            <div class="m-flex-column">
                <div class="m-flex-content">

                    <div class="m-field">
                        <label class="m-title" for="_molongui_guest_author_first_name">
                            <?php _e( "First Name", 'molongui-authorship' ); ?>
                            <div class="m-tooltip m-tooltip__input">
                                <span class="dashicons dashicons-editor-help"></span>
                                <span class="m-tooltip__text"><?php _e( "The name of this guest author", 'molongui-authorship' ); ?></span>
                            </div>
                        </label>
                        <input type="text" name="_molongui_guest_author_first_name" id="_molongui_guest_author_first_name" value="<?php echo esc_attr( $guest_author_first_name ); ?>" />
                    </div>

                    <div class="m-field">
                        <label class="m-title" for="_molongui_guest_author_last_name">
                            <?php _e( "Last Name", 'molongui-authorship' ); ?>
                            <div class="m-tooltip m-tooltip__input">
                                <span class="dashicons dashicons-editor-help"></span>
                                <span class="m-tooltip__text"><?php _e( "Author's last name", 'molongui-authorship' ); ?></span>
                            </div>
                        </label>
                        <input type="text" name="_molongui_guest_author_last_name" id="_molongui_guest_author_last_name" value="<?php echo esc_attr( $guest_author_last_name ); ?>" />
                    </div>

                    <div class="m-field">
                        <label class="m-title" for="_molongui_guest_author_display_name">
                            <?php _e( "Display Name", 'molongui-authorship' ); ?>
                            <div class="m-tooltip m-tooltip__input">
                                <span class="dashicons dashicons-editor-help"></span>
                                <span class="m-tooltip__text"><?php _e( "This is a phrase that refers to the author's name. Most of the time, it is the name of the author, but you can write in whatever you wish. This will be shown as author name.", 'molongui-authorship' ); ?></span>
                            </div>
                        </label>
                        <input type="text" name="_molongui_guest_author_display_name" id="_molongui_guest_author_display_name" value="<?php echo esc_attr( $guest_author_display_name ); ?>" />
                    </div>

                    <div class="m-field">
                        <label class="m-title" for="_molongui_guest_author_mail">
                            <?php _e( "E-mail", 'molongui-authorship' ); ?>
                            <div class="m-tooltip m-tooltip__input">
                                <span class="dashicons dashicons-editor-help"></span>
                                <span class="m-tooltip__text"><?php _e( "Author's e-mail address. Used to retrieve author's Gravatar if it exists and no local avatar is uploaded. This field is not displayed in the front-end unless configured so. See 'Author box settings' on this same page.", 'molongui-authorship' ); ?></span>
                            </div>
                        </label>
                        <input type="text" name="_molongui_guest_author_mail" id="_molongui_guest_author_mail" value="<?php echo esc_attr( $guest_author_mail ); ?>" />
                    </div>

                    <div class="m-field">
                        <label class="m-title" for="_molongui_guest_author_web">
                            <?php _e( "Website", 'molongui-authorship' ); ?>
                            <div class="m-tooltip m-tooltip__input">
                                <span class="dashicons dashicons-editor-help"></span>
                                <span class="m-tooltip__text"><?php _e( "URL to the author's website, blog or profile page. Leave blank to prevent this field to be displayed in the front-end.", 'molongui-authorship' ); ?></span>
                            </div>
                        </label>
                        <input type="text" name="_molongui_guest_author_web" id="_molongui_guest_author_web" value="<?php echo esc_attr( $guest_author_web ); ?>" />
                    </div>

                    <div class="m-field">
                        <label class="m-title" for="_molongui_guest_author_phone"><?php _e( 'Phone', 'molongui-authorship' ); ?>
                            <div class="m-tooltip m-tooltip__input">
                                <span class="dashicons dashicons-editor-help"></span>
                                <span class="m-tooltip__text"><?php _e( "Author's telephone number. This field is not displayed in the front-end unless configured so. See 'Author box settings' on this same page.", 'molongui-authorship' ); ?></span>
                            </div>
                        </label>
                        <input type="text" name="_molongui_guest_author_phone" id="_molongui_guest_author_author_phone" value="<?php echo esc_attr( $guest_author_phone ); ?>" />
                    </div>

                </div>
            </div>

            <div class="m-flex-column">
                <div class="m-flex-content">

                    <div class="m-field">
                        <label class="m-title" for="_molongui_guest_author_job">
                            <?php _e( "Job Title", 'molongui-authorship' ); ?>
                            <div class="m-tooltip m-tooltip__input">
                                <span class="dashicons dashicons-editor-help"></span>
                                <span class="m-tooltip__text"><?php _e( "Name used to describe what the author does for a business or another enterprise. It will be displayed in the author box, just below the author name. Leave blank to prevent this field to be displayed in the front-end.", 'molongui-authorship' ); ?></span>
                            </div>
                        </label>
                        <input type="text" name="_molongui_guest_author_job" id="_molongui_guest_author_job" value="<?php echo esc_attr( $guest_author_job ); ?>" />
                    </div>

                    <div class="m-field">
                        <label class="m-title" for="_molongui_guest_author_company">
                            <?php _e( "Company", 'molongui-authorship' ); ?>
                            <div class="m-tooltip m-tooltip__input">
                                <span class="dashicons dashicons-editor-help"></span>
                                <span class="m-tooltip__text"><?php _e( "The name of the company the author works for. It will be displayed in the author box, just below the author name. Leave blank to prevent this field to be displayed in the front-end.", 'molongui-authorship' ); ?></span>
                            </div>
                        </label>
                        <input type="text" name="_molongui_guest_author_company" id="_molongui_guest_author_company" value="<?php echo esc_attr( $guest_author_company ); ?>" />
                    </div>

                    <div class="m-field">
                        <label class="m-title" for="_molongui_guest_author_company_link">
                            <?php _e( "Company URL", 'molongui-authorship' ); ?>
                            <div class="m-tooltip m-tooltip__input">
                                <span class="dashicons dashicons-editor-help"></span>
                                <span class="m-tooltip__text"><?php _e( "URL the company name will link to. Leave blank to disable link feature.", 'molongui-authorship' ); ?></span>
                            </div>
                        </label>
                        <input type="text" name="_molongui_guest_author_company_link" id="_molongui_guest_author_company_link" value="<?php echo esc_attr( $guest_author_company_link ); ?>" />
                    </div>

                </div>
            </div>

        </div>

    </div>

</div>