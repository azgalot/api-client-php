<?php

/**
 * PHP version 5.4
 *
 * Test case class
 *
 * @category RetailCrm
 * @package  RetailCrm
 */

namespace RetailCrm\Test;

use PHPUnit\Framework\MockObject\MockObject;
use RetailCrm\ApiClient;
use RetailCrm\Http\Client;
use PHPUnit\Framework\TestCase as BaseCase;

/**
 * Class TestCase
 *
 * @category RetailCrm
 * @package  RetailCrm
 */
class TestCase extends BaseCase
{
    /**
     * Return ApiClient object
     *
     * @param string $url     (default: null)
     * @param string $apiKey  (default: null)
     * @param string $version (default: null)
     * @param string $site    (default: null)
     *
     * @return ApiClient
     */
    public static function getApiClient(
        $url = null,
        $apiKey = null,
        $version = null,
        $site = null
    ) {
        $configUrl     = getenv('RETAILCRM_URL') ?: $_SERVER['RETAILCRM_URL'];
        $configKey     = getenv('RETAILCRM_KEY') ?: $_SERVER['RETAILCRM_KEY'];
        $configVersion = getenv('RETAILCRM_VERSION') ?: $_SERVER['RETAILCRM_VERSION'];
        $configSite    = getenv('RETAILCRM_SITE') ?: $_SERVER['RETAILCRM_SITE'];

        return new ApiClient(
            $url ?: $configUrl,
            $apiKey ?: $configKey,
            $version ?: $configVersion,
            $site ?: $configSite
        );
    }

    /**
     * @param \RetailCrm\Http\Client|MockObject $httpClient
     * @return ApiClient
     * @throws \ReflectionException
     */
    public static function getMockedApiClient($httpClient)
    {
        $client = self::getApiClient();
        $property = new \ReflectionProperty(get_class($client->request), 'client');

        $property->setAccessible(true);
        $property->setValue($client->request, $httpClient);

        return $client;
    }

    /**
     * Return Client object
     *
     * @param string $url               (default: null)
     * @param array  $defaultParameters (default: array())
     *
     * @return Client
     */
    public static function getClient($url = null, $defaultParameters = [])
    {
        $configUrl     = getenv('RETAILCRM_URL') ?: $_SERVER['RETAILCRM_URL'];
        $configKey     = getenv('RETAILCRM_KEY') ?: $_SERVER['RETAILCRM_KEY'];
        $configVersion = getenv('RETAILCRM_VERSION') ?: $_SERVER['RETAILCRM_VERSION'];

        return new Client(
            $url ?: $configUrl . '/api/' .  $configVersion,
            [
                'apiKey' => array_key_exists('apiKey', $defaultParameters)
                    ? $defaultParameters['apiKey']
                    : $configKey
            ]
        );
    }
}
