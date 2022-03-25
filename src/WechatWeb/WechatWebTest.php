<?php
/**
 * User: cfn <cfn@leapy.cn>
 * Datetime: 2022/1/21
 * Copyright: easysdk
 */

namespace easysdk\WechatWeb;

use easysdk\Factory;
use PHPUnit\Framework\TestCase;

/**
 * Class WechatTest
 * @package: easysdk
 */
class WechatWebTest extends TestCase
{
    /**
     * @var Application|null
     */
    protected $app = null;

    /**
     * @var array
     */
    public $options = [
        'appid' => 'wx035fd07c314ed3f7',
        'secret' => 'bd8b503c9d97c34e522f38c17b4f9351'
    ];

    /**
     * @param null $name
     * @param array $data
     * @param string $dataName
     */
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->app = Factory::WechatWeb($this->options);
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
        $code = "071qmrFa1sT2SC0BxeJa1Hj6W02qmrF7";
        $result = $this->app->access_token->getToken($code);
        print_r($result);
        $this->assertArrayHasKey('access_token',$result);
    }

    /**
     * testAuth
     * Author: cfn <cfn@leapy.cn>
     * Date 2022/3/24
     */
    public function testAuth()
    {
        $res = $this->app->auth->getRedirectUri('http://h5.upay.com/',"snsapi_base",'123');
        echo $res;
    }
}