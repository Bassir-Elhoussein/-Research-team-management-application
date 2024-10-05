<?php
defined( 'ABSPATH' ) or exit;
$error = get_option( 'molongui_authorship_add_author_error_'.get_current_user_id() );
if ( $error )
{
    ?>
    <div class="error">
        <ul>
            <?php foreach ( $error->get_error_messages() as $err ) echo "<li>$err</li>\n"; ?>
        </ul>
    </div>
    <?php
    $input = get_option( 'molongui_authorship_add_author_input_'.get_current_user_id() );
    delete_option( 'molongui_authorship_add_author_error_'.get_current_user_id() );
    delete_option( 'molongui_authorship_add_author_input_'.get_current_user_id() );
}
$options = authorship_get_options();
if ( empty( $options['guest_authors'] ) )
{
    $input['user-account'] = true;
    $force_user_account    = true;
}

$current_color = molongui_get_admin_color();
?>
<!--
<style>

    .button {
        position: relative;
        top: 50%;
        width: 74px;
        height: 36px;
        margin: -20px auto 0 auto;
        overflow: hidden;
    }

    .button.b2 {
        border-radius: 2px;
    }

    .checkbox {
        position: relative;
        width: 100%;
        height: 100%;
        padding: 0;
        margin: 0;
        opacity: 0;
        cursor: pointer;
        z-index: 3;
    }

    .knobs {
        z-index: 2;
    }

    .layer {
        width: 100%;
        background-color: #ebf7fc;
        transition: 0.3s ease all;
        z-index: 1;
    }
    #button-17 .knobs:before,
    #button-17 .knobs span {
        content: "YES";
        position: absolute;
        top: 4px;
        left: 4px;
        width: 20px;
        height: 10px;
        color: #fff;
        font-size: 10px;
        font-weight: bold;
        text-align: center;
        line-height: 1;
        padding: 9px 4px;
    }

    #button-17 .knobs:before {
        transition: 0.3s ease all, left 0.5s cubic-bezier(0.18, 0.89, 0.35, 1.15);
        z-index: 2;
    }

    #button-17 .knobs span {
        background-color: #03a9f4;
        border-radius: 2px;
        transition: 0.3s ease all, left 0.3s cubic-bezier(0.18, 0.89, 0.35, 1.15);
        z-index: 1;
    }

    #button-17 .checkbox:checked + .knobs:before {
        content: "NO";
        left: 42px;
    }

    #button-17 .checkbox:checked + .knobs span {
        left: 42px;
        background-color: #f44336;
    }

    #button-17 .checkbox:checked ~ .layer {
        background-color: #fcebeb;
    }
</style>
<div class="button b2" id="button-17">
    <input type="checkbox" class="checkbox" />
    <div class="knobs">
        <span></span>
    </div>
    <div class="layer"></div>
</div>
-->
<style>

    <?php echo $current_color; ?>

    .updated { display: none !important; }

    .molongui-new-author__container
    {
        margin: 36px auto 16px;
        text-align: left;
    }

    .molongui-new-author__wrap
    {
        max-width: 504px;
        margin-left: auto;
        margin-right: auto;
    }

    .molongui-new-author__header
    {
        text-align: center;
        margin: 16px 0 24px;
    }
    .molongui-new-author__header h2
    {
        margin-bottom: 15px;
        font-size: calc(20px);
        font-weight: normal;
        line-height: 28px;
    }
    .molongui-new-author__header p
    {
        color: #757575;
        display: flex;
        align-items: center;
        justify-content: center;
        line-height: 1.5em;
        margin: 0px;
        font-size: calc(13px);
        font-weight: normal;
    }

    .molongui-new-author__form
    {
        background-color: rgb(255, 255, 255);
        outline: currentcolor none medium;
        color: rgb(0, 0, 0);
        position: relative;
        box-shadow: rgba(0, 0, 0, 0.1) 0 0 0 1px;
        border-radius: 2px;
    }
    .molongui-new-author__form div
    {
        width: 100%;
    }

    .molongui-new-author__body
    {
        box-sizing: border-box;
        height: auto;
        max-height: 100%;
        padding: 36px 24px 16px;
    }

    .molongui-new-author__account
    {
        display: flex;
        -moz-box-align: center;
        align-items: center;
        flex-direction: column;
        -moz-box-pack: justify;
        justify-content: space-between;
        width: 100%;
        border-top: 1px solid rgba(0, 0, 0, 0.1);
        border-top-color: rgba(0, 0, 0, 0.1);
        box-sizing: border-box;
        border-color: rgba(0, 0, 0, 0.1);
        padding: calc(16px) calc(24px);
    }
    .molongui-new-author__account .molongui-new-author__fields
    {
        display: none;
    }

    .molongui-new-author__footer
    {
        display: flex;
        -moz-box-align: center;
        align-items: center;
        flex-direction: row;
        -moz-box-pack: center;
        justify-content: end;
        width: 100%;
        border-top: 1px solid rgba(0, 0, 0, 0.1);
        border-top-color: rgba(0, 0, 0, 0.1);
        box-sizing: border-box;
        border-color: rgba(0, 0, 0, 0.1);
        padding: calc(16px) calc(24px);
    }

    .molongui-new-author__input
    {
        position: relative;
        width: 100%;
        margin-bottom: 2em;
    }
    .molongui-new-author__input input {
        width: 100%;
        height: 40px;
        box-sizing: border-box;
        padding-top: 8px;
        line-height: 40px;
        font-size: 14px;
        border: 0;
        background: none;
        border-bottom: 1px solid #B9B8C3;
        outline: none;
        border-radius: 0;
        -webkit-appearance: none;
    }
    .molongui-new-author__input input:focus
    {
        box-shadow: none;
    }
    .molongui-new-author__input input:focus ~ label,
    .molongui-new-author__input input:valid ~ label
    {
        color: var(--m-admin-color-2);
        transform: translateY(-20px);
        font-size: 0.85em;
        cursor: default;
    }
    .molongui-new-author__input input:focus ~ .underline
    {
        width: 100%;
    }
    .molongui-new-author__input label {
        position: absolute;
        top: 0;
        left: 0;
        height: 40px;
        line-height: 40px;
        color: #B9B8C3;
        cursor: text;
        transition: all 200ms ease-out;
        z-index: 10;
    }
    .molongui-new-author__input .underline {
        content: "";
        display: block;
        position: absolute;
        bottom: -1px;
        left: 0;
        width: 0;
        height: 2px;
        background: var(--m-admin-color-2);
        transition: all 200ms ease-out;
    }

    .molongui-new-author__checkbox
    {
        margin-bottom: 2em;
    }

    .molongui-new-author__input select
    {
        height: 40px;
        width: 100%;
        max-width: 100%;
        padding-top: 8px;
        border: 0;
        border-bottom: 1px solid #B9B8C3;
        border-radius: 0;
    }
    .molongui-new-author__input select:focus
    {
        border-bottom: 2px solid var(--m-admin-color-2);
        box-shadow: none;
    }
    .molongui-new-author__input select:focus ~ label,
    .molongui-new-author__input select:valid ~ label
    {
        color: var(--m-admin-color-2);
        transform: translateY(-20px);
        font-size: 0.85em;
        cursor: default;
    }
    .cbx {
        -webkit-user-select: none;
        user-select: none;
        -webkit-tap-highlight-color: transparent;
        cursor: pointer;
        display: flex;
        align-items: center;
    }
    .cbx span {
        display: inline-block;
        vertical-align: middle;
        transform: translate3d(0, 0, 0);
    }
    .cbx span:first-child {
        position: relative;
        width: 24px;
        height: 24px;
        border-radius: 3px;
        transform: scale(1);
        vertical-align: middle;
        border: 1px solid #B9B8C3;
        transition: all 0.2s ease;
        margin-right: 12px;
    }
    .cbx span:first-child svg {
        position: absolute;
        z-index: 1;
        top: 8px;
        left: 6px;
        fill: none;
        stroke: white;
        stroke-width: 2;
        stroke-linecap: round;
        stroke-linejoin: round;
        stroke-dasharray: 16px;
        stroke-dashoffset: 16px;
        transition: all 0.3s ease;
        transition-delay: 0.1s;
        transform: translate3d(0, 0, 0);
    }
    .cbx span:first-child:before {
        content: "";
        width: 100%;
        height: 100%;
        background: var(--m-admin-color-2);
        display: block;
        transform: scale(0);
        opacity: 1;
        border-radius: 3px;
        transition-delay: 0.2s;
    }
    .cbx:hover span:first-child {
        border-color: var(--m-admin-color-2);
    }
.cbx span:last-child {
    margin-left: 8px;
}
.cbx span:last-child:after {
    content: "";
    position: absolute;
    top: 8px;
    left: 0;
    height: 1px;
    width: 100%;
    background: #B9B8C3;
    transform-origin: 0 0;
    transform: scaleX(0);
}
    .cbx div
    {
        font-size: 14px;
    }
    .cbx div p
    {
        margin: 0;
        font-size: 12px;
        color: #979797;
    }

    .inp-cbx:checked + .cbx span:first-child {
        border-color: var(--m-admin-color-2);
        background: var(--m-admin-color-2);
        animation: check 0.6s ease;
    }
    .inp-cbx:checked + .cbx span:first-child svg {
        stroke-dashoffset: 0;
    }
    .inp-cbx:checked + .cbx span:first-child:before {
        transform: scale(2.2);
        opacity: 0;
        transition: all 0.6s ease;
    }/*
    .inp-cbx:checked + .cbx span:last-child {
        color: #B9B8C3;
        transition: all 0.3s ease;
    }
    .inp-cbx:checked + .cbx span:last-child:after {
        transform: scaleX(1);
        transition: all 0.3s ease;
    }
*/
    .inp-cbx:disabled + .cbx
    {
        cursor: not-allowed;
    }
    .inp-cbx:disabled + .cbx:hover span:first-child
    {
        border-color: #B9B8C3;
    }
    .inp-cbx:disabled + .cbx
    {
        color: #B9B8C3;
    }
    .inp-cbx:disabled + .cbx div p
    {
        color: #ff9f9f;
    }

    @keyframes check { 50% { transform: scale(1.2); } }

</style>
<div class="wrap">

    <h1 class="wp-heading-inline"><?php _e( "Add New Author", 'molongui-authorship' ); ?></h1>
    <hr class="wp-header-end">

    <div class="molongui-new-author__container">

        <div class="molongui-new-author__wrap">

            <div class="molongui-new-author__header">

                <h2><?php _e( "Add New Author", 'molongui-authorship' ); ?></h2>
                <p><?php _e( "Fill out the form below. Author details can be added on the next screen", 'molongui-authorship' ); ?></p>

            </div>

            <div class="molongui-new-author__form">

                <form method="post" name="createauthor" id="createauthor" class="validate" autocomplete="off" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">

                    <input type="hidden" name="action" value="add_author" />
                    <?php wp_nonce_field( 'create-author', 'authorship-create-author-nonce' ); ?>

                    <div class="molongui-new-author__body">
                        <div class="molongui-new-author__fields">

                            <div class="molongui-new-author__input">
                                <input type="text" id="first-name" name="first-name" required value="<?php echo !empty( $input['first-name'] ) ? $input['first-name'] : ''; ?>" >
                                <label for="first-name"><?php _e( "First Name", 'molongui-authorship' ); ?></label>
                                <span class="underline"></span>
                            </div>

                            <div class="molongui-new-author__input">
                                <input type="text" id="last-name" name="last-name" required value="<?php echo !empty( $input['last-name'] ) ? $input['last-name'] : ''; ?>" >
                                <label for="last-name"><?php _e( "Last Name", 'molongui-authorship' ); ?></label>
                                <span class="underline"></span>
                            </div>

                        </div>
                    </div>

                    <div class="molongui-new-author__account">

                        <?php if ( current_user_can( 'create_users' ) ) : ?>

                            <div class="molongui-new-author__checkbox" title="<?php _e( "Check to create a user account for this author. Leave blank to make this author a guest.", 'molongui-authorship' ); ?>">
                                <?php if ( empty( $force_user_account ) ) : ?>
                                    <input type="checkbox" class="inp-cbx" id="user-account" name="user-account" <?php checked( !empty( $input['user-account'] ) ); ?> style="display: none;" />
                                <?php else : ?>
                                    <input type="checkbox" id="user-account" name="user-account" class="inp-cbx" checked="checked" disabled="disabled" style="display: none;" />
                                <?php endif; ?>
                                <label class="cbx" for="user-account">
                                    <span>
                                        <svg width="12px" height="9px" viewbox="0 0 12 9">
                                            <polyline points="1 5 4 8 11 1"></polyline>
                                        </svg>
                                    </span>
                                    <div>
                                        <?php _e( "Grant access to the dashboard", 'molongui-authorship' ); ?>
                                        <p>
                                            <?php
                                            if ( empty( $force_user_account ) )
                                            {
                                                _e( "Create a user account so the author can access the dashboard", 'molongui-authorship' );
                                            }
                                            else
                                            {
                                                _e( "Guest authors disabled. A new user account will be added for this author", 'molongui-authorship' );
                                            }
                                            ?>
                                        </p>
                                    </div>
                                </label>
                                <?php if ( !empty( $force_user_account ) ) : // Disabled checkboxes are not submitted to $_POST, so we need to recreate it using a hidden input. ?>
                                    <input type="hidden" id="__user-account" name="user-account" value="on" />
                                <?php endif; ?>
                            </div>

                            <div id="user-fields" class="molongui-new-author__fields">

                                <div class="molongui-new-author__input">
                                    <select name="role" id="role">
                                        <?php $role = !empty( $input['role'] ) ? $input['role'] : 'author'; ?>
                                        <?php wp_dropdown_roles( $role ); ?>
                                    </select>
                                    <label for="role"><?php _e( "User Role", 'molongui-authorship' ); ?></label>
                                </div>

                                <div class="molongui-new-author__input">
                                    <input type="text" id="username" name="username" autocomplete="off" required value="<?php echo !empty( $input['username'] ) ? $input['username'] : ''; ?>" >
                                    <label for="username"><?php _e( "Username", 'molongui-authorship' ); ?></label>
                                    <span class="underline"></span>
                                </div>

                                <div class="molongui-new-author__input">
                                    <?php $pwd = !empty( $input['password'] ) ? $input['password'] : esc_attr( wp_generate_password( 24 ) ); ?>
                                    <input type="text" id="password" name="password" autocomplete="off" required value="<?php echo $pwd; ?>">
                                    <label for="password"><?php _e( "Password", 'molongui-authorship' ); ?></label>
                                    <span class="underline"></span>
                                </div>

                                <div class="molongui-new-author__input">
                                    <input type="email" id="email" name="email" required value="<?php echo !empty( $input['email'] ) ? $input['email'] : ''; ?>" >
                                    <label for="email"><?php _e( "Email", 'molongui-authorship' ); ?></label>
                                    <span class="underline"></span>
                                </div>

                                <div class="molongui-new-author__checkbox">
                                    <input type="checkbox" class="inp-cbx" id="user-notify" name="user-notify" <?php checked( !empty( $input['user-notify'] ) ); ?> style="display: none;" />
                                    <label class="cbx" for="user-notify">
                                            <span>
                                        <svg width="12px" height="9px" viewbox="0 0 12 9">
                                            <polyline points="1 5 4 8 11 1"></polyline>
                                        </svg>
                                    </span>
                                        <div>
                                            <?php _e( "Send the new user an email about their account", 'molongui-authorship' ); ?>
                                        </div>
                                    </label>
                                </div>

                            </div>

                        <?php else : ?>

                            <div class="molongui-new-author__checkbox">
                                <input type="checkbox" class="inp-cbx" id="void" disabled style="display: none;" />
                                <label class="cbx disabled" for="void">
                                    <span></span>
                                    <div>
                                        <s><?php _e( "Grant access to the dashboard", 'molongui-authorship' ); ?></s>
                                        <p><?php _e( "You are not allowed to create users, so this will be added as a guest author.", 'molongui-authorship' ); ?></p>
                                    </div>
                                </label>
                            </div>

                        <?php endif; ?>

                    </div>

                    <div class="molongui-new-author__footer">
                        <button id="next" type="submit" class="button is-primary" <!--disabled=""--><?php _e( "Next", 'molongui-authorship' ); ?></button>
                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

<script>
    let accountCbx = jQuery('#user-account');
    accountCbx.on('m-load change', function(e)
    {
        let userFields = jQuery('#user-fields');
        if ( jQuery(this).is(':checked') )
        {
            userFields.show();
            userFields.find('input:not(:checkbox), select').prop('required',true);
        }
        else
        {
            userFields.hide();
            userFields.find('input:not(:checkbox), select').prop('required',false);
        }
    });
    accountCbx.trigger('m-load');

</script>