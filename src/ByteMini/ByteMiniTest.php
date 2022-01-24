<?php
/**
 * User: cfn <cfn@leapy.cn>
 * Datetime: 2022/1/21
 * Copyright: easysdk
 */

namespace easysdk\ByteMini;

use easysdk\Factory;
use PHPUnit\Framework\TestCase;

/**
 * Class WechatTest
 * @package: easysdk
 */
class ByteMiniTest extends TestCase
{
    /**
     * @var Application|null
     */
    protected $app = null;

    /**
     * @var array
     */
    public $options = [
        'appid' => 'tt624814f5fd71053c01',
        'secret' => '8e2cb6a37db0805d4ef782a8a9e4cca4461ebbf8'
    ];

    /**
     * @param null $name
     * @param array $data
     * @param string $dataName
     */
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->app = Factory::ByteMini($this->options);
    }

    /**
     * token测试
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Psr\Cache\InvalidArgumentException
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/22
     */
    public function testToken()
    {
        $result = $this->app->access_token->getToken();
        print_r($result);
//        $this->assertArrayHasKey('access_token',$result);
    }
}