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
     * 订单
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/25
     */
    public function testOrder()
    {
        $result = $this->app->order->pay(['orderId'=>date('YmdHis'),'txnAmt'=>'1']);
        var_dump($result);
        $this->assertArrayHasKey('tn', $result);

        $result = $this->app->order->query(['orderId'=>date('YmdHis'),'txnAmt'=>'1']);
        var_dump($result);
        $this->assertArrayHasKey('respCode', $result);

        $result = $this->app->order->refund(['orderId'=>date('YmdHis'),'txnAmt'=>'1','origQryId'=>'xxxxx']);
        var_dump($result);
        $this->assertArrayHasKey('respCode', $result);

        $result = $this->app->order->cancel(['orderId'=>date('YmdHis'),'txnAmt'=>'1','origQryId'=>'xxxxx']);
        var_dump($result);
        $this->assertArrayHasKey('respCode', $result);
    }

    /**
     * 预授权
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \easysdk\Kernel\Exceptions\InvalidArgumentException
     * @throws \easysdk\Kernel\Exceptions\ValidationFailException
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/25
     */
    public function testPreorder()
    {
        $result = $this->app->preorder->pay(['orderId'=>date('YmdHis'),'txnAmt'=>'1']);
        var_dump($result);
        $this->assertArrayHasKey('tn', $result);

        $result = $this->app->preorder->finish(['orderId'=>date('YmdHis'),'txnAmt'=>'1','origQryId'=>'xxxxx']);
        var_dump($result);
        $this->assertArrayHasKey('respCode', $result);

        $result = $this->app->preorder->refund(['orderId'=>date('YmdHis'),'txnAmt'=>'1','origQryId'=>'xxxxx']);
        var_dump($result);
        $this->assertArrayHasKey('respCode', $result);

        $result = $this->app->preorder->cancel(['orderId'=>date('YmdHis'),'txnAmt'=>'1','origQryId'=>'xxxxx']);
        var_dump($result);
        $this->assertArrayHasKey('respCode', $result);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \easysdk\Kernel\Exceptions\InvalidArgumentException
     * @throws \easysdk\Kernel\Exceptions\ValidationFailException
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/25
     */
    public function testFile()
    {
        $result = $this->app->file->updatePublicKey(['orderId'=>date('YmdHis')]);
        var_dump($result);
        $this->assertArrayHasKey('respCode', $result);

        $result = $this->app->file->download(['orderId'=>date('YmdHis'),'settleDate'=>date('md')]);
        var_dump($result);
        $this->assertArrayHasKey('respCode', $result);
    }
}