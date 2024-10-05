<?php

namespace WPUM\Stripe\ApiOperations;

/**
 * Trait for searchable resources.
 *
 * This trait should only be applied to classes that derive from StripeObject.
 */
trait Search
{
    /**
     * @param string $searchUrl
     * @param null|array $params
     * @param null|array|string $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\SearchResult of ApiResources
     */
    protected static function _searchResource($searchUrl, $params = null, $opts = null)
    {
        self::_validateParams($params);
        list($response, $opts) = static::_staticRequest('get', $searchUrl, $params, $opts);
        $obj = \WPUM\Stripe\Util\Util::convertToStripeObject($response->json, $opts);
        if (!$obj instanceof \WPUM\Stripe\SearchResult) {
            throw new \WPUM\Stripe\Exception\UnexpectedValueException('Expected type ' . \WPUM\Stripe\SearchResult::class . ', got "' . \get_class($obj) . '" instead.');
        }
        $obj->setLastResponse($response);
        $obj->setFilters($params);
        return $obj;
    }
}
