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
 * Class ByteMiniTest
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
        $this->assertArrayHasKey('access_token',$result);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/24
     */
    public function testAuth()
    {
        $result = $this->app->auth->code2Session('PAxKa3Xvpa8UuvCJXVwfx7z3QJQ8P5fyW9Bxb8FCkeqo8uaHBWMGARoqoLhDkGwUX4XYZRA1tJRjfesKbxX7AC-N312F4pc82iTyeDXZOhNkl1XaMHUkuBdlJXc');
        print_r($result);
        $this->assertArrayHasKey('session_key',$result);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/24
     */
    public function testQrcode()
    {
        $result = $this->app->qrcode->create('');
        print_r($result);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/24
     */
    public function testStorage()
    {
        $result = $this->app->storage->setUserStorage('d9b4a67e-ca44-4e87-8edc-c211e172d4d4','rUChRwoaSmCJ+EL9HJPiZQ==',[['key'=>'name','value'=>'展示']]);
        print_r($result);
        $this->assertArrayHasKey('error',$result);

        $result = $this->app->storage->removeUserStorage('d9b4a67e-ca44-4e87-8edc-c211e172d4d4','rUChRwoaSmCJ+EL9HJPiZQ==',['name']);
        print_r($result);
        $this->assertArrayHasKey('error',$result);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/24
     */
    public function testSecure()
    {
        $result = $this->app->secure->text(['中国人不骗中国人']);
        print_r($result);
        $this->assertArrayHasKey('log_id',$result);

        $result = $this->app->secure->image("https://img-blog.csdnimg.cn/img_convert/acbeb4ca1166bf20a9e3a20c96800610.png");
        print_r($result);
        $this->assertArrayHasKey('error',$result);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/25
     */
    public function testMessage()
    {
        $result = $this->app->message->sendMessage('','',[],'');
        print_r($result);
        $this->assertArrayHasKey('err_no',$result);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/25
     */
    public function testOther()
    {
        $result = $this->app->other->shareConfig('',1);
        print_r($result);
        $this->assertArrayHasKey('err_no',$result);

        $result = $this->app->other->videoIdToOpenItemId(['123'],'456');
        print_r($result);
        $this->assertArrayHasKey('convert_result',$result);

        $result = $this->app->other->openItemIdToEncryptId(['123'],'456');
        print_r($result);
        $this->assertArrayHasKey('convert_result',$result);
    }
}