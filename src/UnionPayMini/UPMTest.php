<?php
/**
 * User: cfn <cfn@leapy.cn>
 * Datetime: 2022/1/21
 * Copyright: easysdk
 */

namespace easysdk\UnionPayMini;

use easysdk\Factory;
use PHPUnit\Framework\TestCase;

/**
 * Class Test
 * @package: easysdk
 */
class UPMTest extends TestCase
{
    /**
     * @var Application|null
     */
    protected $app = null;

    /**
     * @var array
     */
    public $options = [
        'appid' => 'a8c117dd0d644622a1b26034b63aff55',
        'secret' => '938e4310cb564af7b64544e4c86f2ed3',
        'symmetricKey' => 'f2dae558ea92a47a13d9166e8531e940f2dae558ea92a47a',
        'privateKey' => '',
        'debug' => true,
    ];

    /**
     * @param null $name
     * @param array $data
     * @param string $dataName
     */
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->app = Factory::UnionPayMini($this->options);
    }

    /**
     * 加解密测试
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/21
     */
    public function testCrypto()
    {
        // 加密
        $this->assertEquals("nSJ5OPG/I5HIGOnOac1Lpw==",$this->app->crypto->encrypt("1234abcd"));
        // 解密
        $this->assertEquals("1234abcd",$this->app->crypto->decrypt("nSJ5OPG/I5HIGOnOac1Lpw=="));
    }

    /**
     * token测试
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/21
     */
    public function testToken()
    {
        $backendToken = $this->app->backend_token->getToken();
        print_r($backendToken);
        $this->assertArrayHasKey("backendToken",$backendToken);

        $frontToken = $this->app->front_token->getToken();
        print_r($frontToken);
        $this->assertArrayHasKey("frontToken",$frontToken);

        $code = "前端获取到的code";
        $accessToken = $this->app->access_token->getToken($code);
        print_r($accessToken);
        $this->assertArrayHasKey("resp",$accessToken);
//        $this->assertArrayHasKey("accessToken",$accessToken);
    }

    /**
     * 获取用户信息
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Psr\Cache\InvalidArgumentException
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/22
     */
    public function testUser()
    {
        $code = "前端获取到的code";
        $mobile = $this->app->user->mobile($code);
        print_r($mobile);
        $this->assertArrayHasKey("resp",$mobile);

        $code = "前端获取到的code";
        $auth = $this->app->user->auth($code);
        print_r($auth);
        $this->assertArrayHasKey("resp",$auth);

        $code = "前端获取到的code";
        $card = $this->app->user->card($code);
        print_r($card);
        $this->assertArrayHasKey("resp",$card);

        $code = "前端获取到的code";
        $cardToken = $this->app->user->cardToken($code);
        print_r($cardToken);
        $this->assertArrayHasKey("resp",$cardToken);

        $code = "前端获取到的code";
        $userStatus = $this->app->user->userStatus($code);
        print_r($userStatus);
        $this->assertArrayHasKey("resp",$userStatus);

        $openid = "code未过期之前，通过openid反查code";
        $code = $this->app->user->getCode($openid);
        print_r($code);
        $this->assertEmpty($code);
    }

    /**
     * 无感支付测试
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Psr\Cache\InvalidArgumentException
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/22
     */
    public function testContract()
    {
        $apply = $this->app->contract->apply("前端获取到的code",'','协议模板id','接入方侧的签约协议号');
        print_r($apply);
        $this->assertArrayHasKey("resp",$apply);

        $relieve = $this->app->contract->relieve("abcdefg",'123','协议模板id','接入方侧的签约协议号');
        print_r($relieve);
        $this->assertArrayHasKey("resp",$relieve);

        $signStatus = $this->app->contract->signStatus("abcdefg",'协议模板id');
        print_r($signStatus);
        $this->assertArrayHasKey("resp",$signStatus);

        $unFinishedOrder = $this->app->contract->unFinishedOrder("abcdefg");
        print_r($unFinishedOrder);
        $this->assertArrayHasKey("resp",$unFinishedOrder);
    }

    /**
     * 优惠券测试
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Psr\Cache\InvalidArgumentException
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/22
     */
    public function testCoupon()
    {
        $query = $this->app->coupon->query(['origTransSeqId'=>'12321','origTransTs'=>'321312']);
        print_r($query);
        $this->assertArrayHasKey("resp",$query);

        $given = $this->app->coupon->given(['couponId'=>'1231','acctEntityTp'=>'02','cardNo'=>'1213213']);
        print_r($given);
        $this->assertArrayHasKey("resp",$given);

        $quota = $this->app->coupon->quota(['activityNo'=>'1','activityType'=>'2']);
        print_r($quota);
        $this->assertArrayHasKey("resp",$quota);
    }

    /**
     * 测试人脸识别
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Psr\Cache\InvalidArgumentException
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/22
     */
    public function testFace()
    {
        $code = "前端获取到的code";
        $image = $this->app->face->image($code);
        print_r($image);
        $this->assertArrayHasKey("resp",$image);

        $code = "前端获取到的code";
        $video = $this->app->face->video($code);
        print_r($video);
        $this->assertArrayHasKey("resp",$video);
    }

    /**
     * 发送小程序信息
     * @throws \GuzzleHttp\Exception\GuzzleException
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/22
     */
    public function testMessage()
    {
        $result = $this->app->message->sendMessage([]);
        print_r($result);
        $this->assertArrayHasKey("resp",$result);
    }

    /**
     * 抽奖测试
     * @throws \GuzzleHttp\Exception\GuzzleException
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/22
     */
    public function testQual()
    {
        $given = $this->app->qual->given();
        print_r($given);
        $this->assertArrayHasKey("resp",$given);

        $query = $this->app->qual->query(['qualNum'=>'1','qualValue'=>'2']);
        print_r($query);
        $this->assertArrayHasKey("resp",$query);

        $directLotto = $this->app->qual->directLotto();
        print_r($directLotto);
        $this->assertArrayHasKey("resp",$directLotto);

        $lotto = $this->app->qual->lotto();
        print_r($lotto);
        $this->assertArrayHasKey("resp",$lotto);
    }

    /**
     * 红包测试
     * @throws \GuzzleHttp\Exception\GuzzleException
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/22
     */
    public function testRedpack()
    {
        $lotto = $this->app->redpack->given();
        print_r($lotto);
        $this->assertArrayHasKey("resp",$lotto);

        $excQuery = $this->app->redpack->excQuery();
        print_r($excQuery);
        $this->assertArrayHasKey("resp",$excQuery);

        $orgQuery = $this->app->redpack->orgQuery([]);
        print_r($orgQuery);
        $this->assertArrayHasKey("resp",$orgQuery);
    }

    /**
     * 安全能力
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/22
     */
    public function testSecure()
    {
        $verifyPwd = $this->app->secure->verifyPwd('abcd', '',['notifyUrl'=>'']);
        print_r($verifyPwd);
        $this->assertArrayHasKey("resp",$verifyPwd);
    }
}