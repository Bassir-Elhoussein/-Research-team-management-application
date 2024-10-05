<div class="sui-box">
    <div class="sui-box__message sui-box__message--loading">
        <p><span class="sui-icon-loader sui-loading" aria-hidden="true"></span>
            <?php esc_html_e( 'Fetching latest data...', 'forminator' );?>
        </p>
    </div>

    <div class="sui-box-header">
        <h3 class="sui-box-title">
            <i class="<?php echo esc_html( $icon ); ?>" aria-hidden="true"></i>
			<?php echo esc_html( $title ); ?>
        </h3>
		<?php if ( isset( $title_link ) ) { ?>
            <div class="sui-actions-right">
                <a href="<?php echo esc_url( $title_link ); ?>" target="_blank"
                   class="sui-link-blue"><?php echo esc_html( $title_text ); ?>
                    <span class="sui-icon-arrow-right sui-sm" aria-hidden="true"></span>
                </a>
            </div>
		<?php } ?>
    </div>

    <div class="sui-box-body">
        <p><?php echo esc_html( $description ); ?></p>
	    <?php if ( isset( $has_payment ) && ! $has_payment ) { ?>
            <div class="sui-notice">
                <div class="sui-notice-content">
                    <div class="sui-notice-message">
                        <i aria-hidden="true" class="sui-notice-icon sui-icon-info sui-md"></i>
                        <p><?php esc_html_e( 'No payment field found. Add a PayPal or a Stripe field to your form to start collecting payments.', 'forminator' ); ?>
                        </p>
                    </div>
                </div>
            </div>
	    <?php } ?>
    </div>
	<?php if ( ! isset( $has_payment ) || ( isset( $has_payment ) && $has_payment ) ) { ?>
    <div class="sui-flushed">
        <table class="sui-table sui-table-flushed report-<?php echo esc_attr( $data_class ); ?>">
            <tbody>
            <tr>
                <td>
                    <div class="fui-table-title">
						<?php echo esc_html( $title ); ?>
                    </div>
                    <div class="fui-table-content">
						<san class="selected-<?php echo esc_attr( $data_class ); ?>">
                            <?php echo esc_html( $attrs['selected'] ); ?>
                        </san>
						<?php
                            $arrow_color = 'high' === $attrs['difference'] ? 'fui-trend-green' : 'fui-trend-red';
                            $arrow_icon = 'high' === $attrs['difference'] ? 'sui-icon-arrow-up' : 'sui-icon-arrow-down'; ?>
                            <span class="fui-trend <?php echo esc_html( $arrow_color ); ?> increment-<?php echo esc_attr( $data_class ); ?>">
                                <?php if ( $attrs['increment'] > 0 ) { ?>
                                    <i class="<?php echo esc_html( $arrow_icon ); ?> sui-sm" aria-hidden="true"></i>
                                    <?php echo esc_html( $attrs['increment'] );
                                } ?>
                            </span>

                    </div>
                </td>
                <td>
                    <div class="fui-table-title"><?php esc_html_e( 'previous period', '' ); ?>
                        <button class="sui-button-icon sui-tooltip sui-tooltip-top-center sui-tooltip-constrained sui-tooltip-top-right-mobile"
                                data-tooltip="<?php esc_html_e( 'Displays the statistics for the same previous period you selected.', 'forminator' ); ?>">
                            <span class="sui-icon-info" aria-hidden="true"></span>
                        </button>
                    </div>
                    <div class="fui-table-content previous-<?php echo esc_attr( $data_class ); ?>">
						<?php echo esc_html( $attrs['previous'] )  ?>
                    </div>
                </td>
            </tr>
			<?php if ( isset( $has_payment ) && $has_payment ) { ?>
                <tr>
                    <td>
                        <div class="fui-table-title"><?php esc_html_e( 'stripe', 'forminator' ); ?></div>
                        <div class="fui-table-content stripe-report">
							<?php echo esc_html( $attrs['stripe'] ); ?>
                        </div>
                    </td>
                    <td>
                        <div class="fui-table-title"><?php esc_html_e( 'paypal', 'forminator' ); ?></div>
                        <div class="fui-table-content paypal-report">
							<?php echo esc_html( $attrs['paypal'] ); ?>
                        </div>
                    </td>
                </tr>
			<?php } ?>
            </tbody>
        </table>
    </div>
	<?php if ( isset( $attrs['average'] ) ) { ?>
        <div class="sui-box-footer">
            <strong><?php esc_html_e( 'Monthly average', 'forminator' ); ?></strong>
            <div class="sui-actions-right">
                <p class="average-<?php echo esc_attr( $data_class ); ?>">
					<?php echo esc_html( $attrs['average'] ); ?>
                </p>
            </div>
        </div>
	<?php }
    } ?>
</div>