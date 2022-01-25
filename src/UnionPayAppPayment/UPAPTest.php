<?php
/**
 * User: cfn <cfn@leapy.cn>
 * Datetime: 2022/1/21
 * Copyright: easysdk
 */

namespace easysdk\UnionPayAppPayment;

use easysdk\Factory;
use PHPUnit\Framework\TestCase;

/**
 * Class Test
 * @package: easysdk
 */
class UPAPTest extends TestCase
{
    /**
     * @var Application|null
     */
    protected $app = null;

    /**
     * @var array
     */
    public $options = [
        'merId' => '777290058194258', // 商户编号
        'signCertPath' => 'E:\study\php\acp_test_sign.pfx', // 签名证书路径pfx结尾
        'signCertPwd' => '000000', // 签名证书密码
        'encryptCertPath' => 'E:\study\php\acp_test_enc.cer', // 敏感信息加密证书路径 cer结尾
        'debug' => true, // 支付模式，true为测试环境，false为生产环境，默认false
    ];

    /**
     * @param null $name
     * @param array $data
     * @param string $dataName
     */
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->app = Factory::UnionPayAppPayment($this->options);
    }

    /**
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/25
     */
    public function testOrder()
    {
        $result = $this->app->order->pay(['orderId'=>date('YmdHis'),'txnAmt'=>'0.01']);
        var_dump($this->app->signature->validate($result));
    }
}