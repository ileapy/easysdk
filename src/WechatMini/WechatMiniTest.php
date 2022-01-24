<?php
/**
 * User: cfn <cfn@leapy.cn>
 * Datetime: 2022/1/21
 * Copyright: easysdk
 */

namespace easysdk\WechatMini;

use easysdk\Factory;
use PHPUnit\Framework\TestCase;

/**
 * Class Test
 * @package: easysdk
 */
class WechatMiniTest extends TestCase
{
    /**
     * @var Application|null
     */
    protected $app = null;

    /**
     * @var array
     */
    public $options = [
        'appid' => 'wx7cec1c8df7df74a3',
        'secret' => 'd0a76666784ed6770d28f874d17b7e06'
    ];

    /**
     * @param null $name
     * @param array $data
     * @param string $dataName
     */
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->app = Factory::WechatMini($this->options);
    }


    /**
     * 检查加密信息是否由微信生成
     * @throws \GuzzleHttp\Exception\GuzzleException
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/22
     */
    public function testAuth()
    {
//        $result = $this->app->auth->code2Session("073EDk100vC9cN14le100aQ71p0EDk1m");
//        print_r($result);
//        $this->assertArrayHasKey('session_key',$result);
//        $this->assertArrayHasKey('openid',$result);

//        $result = $this->app->auth->checkEncryptedData("ej9FNJgeqoV7EIX00rgthvcjKb9XqsnZCY+BAcbP1Q76/5S51FNIwYmJA2TkHZWvdqeToWv0rwvOI22YhBs+yRYZwLhszbnqFxOKvWG67s16BxAPN6UuhV1XLW2htP0GyGWdWE3ENshUGMXJ2xwlIzp9NuZfexGJWjO+8QNeM6Ni3u/r5lXroxjJxogNzy0RHC+x9FFjSphdknasS310PA==");
//        print_r($result);
//        $this->assertArrayHasKey('session_key',$result);

        $result = $this->app->auth->getPaidUnionId("aaa111");
        var_dump($result);
        $this->assertArrayHasKey('session_key',$result);

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
        $result = $this->app->access_token->getToken(false);
        $this->assertArrayHasKey('access_token',$result);
    }

    /**
     * 二维码
     * @throws \GuzzleHttp\Exception\GuzzleException
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/22
     */
    public function testQrcode()
    {
        $result = $this->app->qrcode->createQRCode('pages/index/index');
        var_dump($result);
//        $this->assertArrayHasKey('access_token',$result);
    }
}