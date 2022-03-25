<?php
/**
 * User: cfn <cfn@leapy.cn>
 * Datetime: 2022/1/21
 * Copyright: easysdk
 */

namespace easysdk\AliyunSms;

use easysdk\Factory;
use PHPUnit\Framework\TestCase;

/**
 * Class WechatTest
 * @package: easysdk
 */
class AliyunSmsTest extends TestCase
{
    /**
     * @var Application|null
     */
    protected $app = null;

    /**
     * @var array
     */
    public $options = [
        'AccessKeyId' => 'LTAI5tEc9dMSQBSXDJ442fJZ',
        'AccessKeySecret' => 'EgybUVHxZAedfDyhLf2AbqHCZLOye6'
    ];

    /**
     * @param null $name
     * @param array $data
     * @param string $dataName
     */
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->app = Factory::AliyunSms($this->options);
    }

    /**
     * testSms
     * Author: cfn <cfn@leapy.cn>
     * Date 2022/3/25
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testSms()
    {
        $res = $this->app->sms->sendSms('18438622598','里派','SMS_237211426',['code'=>123456]);
        $this->assertArrayHasKey('Message',$res);
        var_dump($res);

        $res = $this->app->sms->sendBatchSms(['18736647561','15639267560'],['里派','里派'],'SMS_237211426',[['code'=>123456],['code'=>123456]]);
        $this->assertArrayHasKey('Message',$res);
        var_dump($res);
    }

    /**
     * testQuery
     * Author: cfn <cfn@leapy.cn>
     * Date 2022/3/25
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testQuery()
    {
        $res = $this->app->query->querySendStatistics('20220325','20220325',1,10,1);
        $this->assertArrayHasKey('Message',$res);
        var_dump($res);
    }
}