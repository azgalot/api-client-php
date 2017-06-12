<?php

/**
 * PHP version 5.3
 *
 * API client test class
 *
 * @category RetailCrm
 * @package  RetailCrm
 * @author   RetailCrm <integration@retailcrm.ru>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://www.retailcrm.ru/docs/Developers/ApiVersion5
 */

namespace RetailCrm\Tests\Http;

use RetailCrm\Test\TestCase;
use RetailCrm\ApiClient;
use RetailCrm\Http\Client;

/**
 * Class ClientTest
 *
 * @category RetailCrm
 * @package  RetailCrm
 * @author   RetailCrm <integration@retailcrm.ru>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://www.retailcrm.ru/docs/Developers/ApiVersion5
 */
class ClientTest extends TestCase
{
    /**
     * @group unit
     */
    public function testConstruct()
    {
        $client = new Client('https://asdf.df', array());

        static::assertInstanceOf('RetailCrm\Http\Client', $client);
    }

    /**
     * @group unit
     * @expectedException \InvalidArgumentException
     */
    public function testHttpRequiring()
    {
        $client = new Client('http://demo.retailcrm.ru/api/' . ApiClient::VERSION, array('apiKey' => '123'));
        return $client;
    }

    /**
     * @group unit
     * @expectedException \InvalidArgumentException
     */
    public function testRequestWrongMethod()
    {
        $client = static::getClient();
        $client->makeRequest('/a', 'adsf');
    }

    /**
     * @group integration
     * @expectedException \RetailCrm\Exception\CurlException
     */
    public function testRequestWrongUrl()
    {
        $client = new Client('https://asdf.df', array());
        $client->makeRequest('/a', Client::METHOD_GET, array());
    }

    /**
     * @group integration
     */
    public function testRequestSuccess()
    {
        $client = static::getClient();
        $response = $client->makeRequest('/orders', Client::METHOD_GET);

        static::assertInstanceOf('RetailCrm\Response\ApiResponse', $response);
        static::assertEquals(200, $response->getStatusCode());
    }
}
