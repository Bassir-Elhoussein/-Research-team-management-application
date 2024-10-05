<?php

// File generated from our OpenAPI spec
namespace WPUM\Stripe\Terminal;

/**
 * A Configurations object represents how features should be configured for
 * terminal readers.
 *
 * @property string $id Unique identifier for the object.
 * @property string $object String representing the object's type. Objects of the same type share the same value.
 * @property \Stripe\StripeObject $bbpos_wisepos_e
 * @property null|bool $is_account_default Whether this Configuration is the default for your account
 * @property bool $livemode Has the value <code>true</code> if the object exists in live mode or the value <code>false</code> if the object exists in test mode.
 * @property \Stripe\StripeObject $tipping
 * @property \Stripe\StripeObject $verifone_p400
 */
class Configuration extends \WPUM\Stripe\ApiResource
{
    const OBJECT_NAME = 'terminal.configuration';
    use \WPUM\Stripe\ApiOperations\All;
    use \WPUM\Stripe\ApiOperations\Create;
    use \WPUM\Stripe\ApiOperations\Delete;
    use \WPUM\Stripe\ApiOperations\Retrieve;
    use \WPUM\Stripe\ApiOperations\Update;
}
