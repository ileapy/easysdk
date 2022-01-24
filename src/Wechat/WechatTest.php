<?php
/**
 * User: cfn <cfn@leapy.cn>
 * Datetime: 2022/1/21
 * Copyright: easysdk
 */

namespace easysdk\Wechat;

use easysdk\Factory;
use PHPUnit\Framework\TestCase;

/**
 * Class WechatTest
 * @package: easysdk
 */
class WechatTest extends TestCase
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
        $this->app = Factory::Wechat($this->options);
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
        print_r($result);
        $this->assertArrayHasKey('access_token',$result);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/24
     */
    public function testBase()
    {
        $result = $this->app->base->getApiDomainIp();
        print_r($result);
        $this->assertArrayHasKey('ip_list',$result);
    }

    /**
     * 用户管理
     * @throws \GuzzleHttp\Exception\GuzzleException
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/24
     */
    public function testUser()
    {
        $result = $this->app->user->getUser();
        print_r($result);
        $this->assertArrayHasKey('count',$result);

        $result = $this->app->user->userInfo('o5bZq53AKZnAoQd9avKYEFcm1X3c');
        print_r($result);
        $this->assertArrayHasKey('openid',$result);

        $result = $this->app->user->updateRemark('o5bZq53AKZnAoQd9avKYEFcm1X3c','测试备注');
        print_r($result);
        $this->assertArrayHasKey('errcode',$result);
        $this->assertEquals(0,$result['errcode']);

        $result = $this->app->user->tagUser(2);
        print_r($result);
        $this->assertArrayHasKey('count',$result);
    }

    /**
     * 用户标签管理
     * @throws \GuzzleHttp\Exception\GuzzleException
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/24
     */
    public function testTags()
    {
        $result = $this->app->tags->get();
        print_r($result);
        $this->assertArrayHasKey('tags',$result);

        $result = $this->app->tags->create('测试标签');
        print_r($result);
        $this->assertArrayHasKey('tag',$result);

        $result = $this->app->tags->update(100,'期望客户');
        print_r($result);
        $this->assertArrayHasKey('errcode',$result);
        $this->assertEquals(0,$result['errcode']);

        $result = $this->app->tags->delete(100);
        print_r($result);
        $this->assertArrayHasKey('errcode',$result);
        $this->assertEquals(0,$result['errcode']);

        $result = $this->app->tags->getidlist('o5bZq53AKZnAoQd9avKYEFcm1X3c');
        print_r($result);
        $this->assertArrayHasKey('tagid_list',$result);

        $result = $this->app->tags->batchtagging(2,['o5bZq53AKZnAoQd9avKYEFcm1X3c']);
        print_r($result);
        $this->assertArrayHasKey('errcode',$result);
        $this->assertEquals(0,$result['errcode']);

        $result = $this->app->tags->batchuntagging(2,['o5bZq53AKZnAoQd9avKYEFcm1X3c']);
        print_r($result);
        $this->assertArrayHasKey('errcode',$result);
        $this->assertEquals(0,$result['errcode']);
    }

    /**
     * 微信二维码
     * @throws \GuzzleHttp\Exception\GuzzleException
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/24
     */
    public function qrcode()
    {
        $result = $this->app->qrcode->create('测试标签');
        print_r($result);
        $this->assertArrayHasKey('tag',$result);
    }
}