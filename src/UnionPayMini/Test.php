<?php
/**
 * User: cfn <cfn@leapy.cn>
 * Datetime: 2022/1/21
 * Copyright: easysdk
 */

namespace easysdk;

use PHPUnit\Framework\TestCase;

/**
 * Class Test
 * @package: easysdk
 */
class Test extends TestCase
{
    /**
     * @var UnionPayMini\Application|null
     */
    protected $app = null;

    /**
     * @var array
     */
    public $options = [
        //************************************************** 小程序相关配置
        'appid' => 'a8c117dd0d644622a1b26034b63aff55',
        'secret' => '938e4310cb564af7b64544e4c86f2ed3',
        'symmetricKey' => 'f2dae558ea92a47a13d9166e8531e940f2dae558ea92a47a',
        'privateKey' => '',
        'debug' => true,
        //************************************************** 支付相关配置
        'merId' => '777290058194258', // 商户编号
        'signCertPath' => 'E:\study\php\acp_test_sign.pfx', // 签名证书路径pfx结尾
        'signCertPwd' => '000000', // 签名证书密码
        'encryptCertPath' => 'E:\study\php\acp_test_enc.cer', // 敏感信息加密证书路径 cer结尾
        'payment_model' => true, // 支付模式，true为测试环境，false为生产环境，默认false
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
        $this->assertArrayHasKey("backendToken",$backendToken);

        $frontToken = $this->app->front_token->getToken();
        $this->assertArrayHasKey("frontToken",$frontToken);

        $code = "前端获取到的code";
        $accessToken = $this->app->access_token->getToken($code);
        $this->assertArrayHasKey("resp",$accessToken);
//        $this->assertArrayHasKey("accessToken",$accessToken);
    }
}