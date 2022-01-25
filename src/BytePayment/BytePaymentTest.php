<?php
/**
 * User: cfn <cfn@leapy.cn>
 * Datetime: 2022/1/21
 * Copyright: easysdk
 */

namespace easysdk\BytePayment;

use easysdk\Factory;
use PHPUnit\Framework\TestCase;

/**
 * Class ByteMiniTest
 * @package: easysdk
 */
class BytePaymentTest extends TestCase
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
        'secret' => '8e2cb6a37db0805d4ef782a8a9e4cca4461ebbf8',
        'token' => 'your_payment_token',
        'salt' => 'your_payment_salt'
    ];

    /**
     * @param null $name
     * @param array $data
     * @param string $dataName
     */
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->app = Factory::BytePayment($this->options);
    }

    /**
     * token测试
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Psr\Cache\InvalidArgumentException
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/22
     */
    public function testOrder()
    {
        $result = $this->app->order->createOrder(date('YmdHis'),1,'参数','测试测试测试',180);
        print_r($result);
        $this->assertArrayHasKey('err_no',$result);

        $result = $this->app->order->queryOrder(date('YmdHis'));
        print_r($result);
        $this->assertArrayHasKey('err_no',$result);

        $result = $this->app->order->createRefund(date('YmdHis'),'213123','测试',1);
        print_r($result);
        $this->assertArrayHasKey('err_no',$result);

        $result = $this->app->order->queryRefund(date('YmdHis'));
        print_r($result);
        $this->assertArrayHasKey('err_no',$result);

        $result = $this->app->order->settle(date('YmdHis'),'dsa','sddsa');
        print_r($result);
        $this->assertArrayHasKey('err_no',$result);

        $result = $this->app->order->querySettle(date('YmdHis'));
        print_r($result);
        $this->assertArrayHasKey('err_no',$result);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/25
     */
    public function testMerchant()
    {
        $result = $this->app->merchant->addMerchant('','','');
        print_r($result);
        $this->assertArrayHasKey('err_no',$result);

        $result = $this->app->merchant->addSubMerchant();
        print_r($result);
        $this->assertArrayHasKey('err_no',$result);

        $result = $this->app->merchant->appAddSubMerchant();
        print_r($result);
        $this->assertArrayHasKey('err_no',$result);

        $result = $this->app->merchant->getAppMerchant();
        print_r($result);
        $this->assertArrayHasKey('err_no',$result);

        $result = $this->app->merchant->queryMerchantStatus();
        print_r($result);
        $this->assertArrayHasKey('err_no',$result);
    }
}