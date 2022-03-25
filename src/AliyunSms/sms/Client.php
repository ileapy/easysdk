<?php
/**
 * User: cfn <cfn@leapy.cn>
 * Datetime: 2021/8/19 11:35
 * Copyright: php
 */

namespace easysdk\AliyunSms\sms;

use easysdk\Kernel\Client\AliyunSmsClient;

/**
 * Class Config
 *
 * @package easysdk\UnionPayMini\config
 */
class Client extends AliyunSmsClient
{
    /**
     * sendSms
     * Author: cfn <cfn@leapy.cn>
     * Date 2022/3/25
     * @param string $PhoneNumbers
     * @param string $SignName
     * @param string $TemplateCode
     * @param array $TemplateParam
     * @return array|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function sendSms($PhoneNumbers, $SignName, $TemplateCode, $TemplateParam=[])
    {
        $params = [
            'Action'=> 'SendSms',
            'PhoneNumbers' => $PhoneNumbers,
            'SignName' => $SignName,
            'TemplateCode' => $TemplateCode,
            'TemplateParam' => json_encode($TemplateParam, JSON_UNESCAPED_UNICODE)
        ];
        $data = array_replace_recursive($this->getCommonData(), $params);
        $this->signature($data);
        $this->setEndpoint('',$data);
        return $this->send();
    }

    /**
     * sendBatchSms
     * Author: cfn <cfn@leapy.cn>
     * Date 2022/3/25
     * @param array $PhoneNumbers
     * @param array $SignNames
     * @param string $TemplateCode
     * @param array $TemplateParam
     * @return array|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Exception
     */
    public function sendBatchSms($PhoneNumbers, $SignNames, $TemplateCode, $TemplateParam=[])
    {
        if (!is_array($PhoneNumbers) || !is_array($SignNames)) throw new \Exception('参数有误！');
        $params = [
            'Action'=> 'SendBatchSms',
            'PhoneNumberJson' => json_encode($PhoneNumbers, JSON_UNESCAPED_UNICODE),
            'SignNameJson' => json_encode($SignNames, JSON_UNESCAPED_UNICODE),
            'TemplateCode' => $TemplateCode,
            'TemplateParamJson' => json_encode($TemplateParam, JSON_UNESCAPED_UNICODE)
        ];
        $data = array_replace_recursive($this->getCommonData(), $params);
        $this->signature($data);
        $this->setEndpoint('',$data);
        return $this->send();
    }
}
