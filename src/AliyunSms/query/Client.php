<?php
/**
 * User: cfn <cfn@leapy.cn>
 * Datetime: 2021/8/19 11:35
 * Copyright: php
 */

namespace easysdk\AliyunSms\query;

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
     * @param string $StartDate
     * @param string $EndDate
     * @param int $PageIndex
     * @param int $PageSize
     * @param int $IsGlobe
     * @return array|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function querySendStatistics($StartDate, $EndDate, $PageIndex=1, $PageSize=20, $IsGlobe=1)
    {
        $params = [
            'Action'=> 'QuerySendStatistics ',
            'IsGlobe' => $IsGlobe,
            'StartDate' => $StartDate,
            'EndDate' => $EndDate,
            'PageIndex' => $PageIndex,
            'PageSize' => $PageSize
        ];
        $data = array_replace_recursive($this->getCommonData(), $params);
        var_dump($data);
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
     */
    public function QuerySendDetails($PhoneNumbers, $SignNames, $TemplateCode, $TemplateParam=[])
    {
        if (!is_array($PhoneNumbers))
        $params = [
            'Action'=> 'SendBatchSms',
            'PhoneNumberJson' => json_encode($PhoneNumbers, JSON_UNESCAPED_UNICODE),
            'SignNameJson' => json_encode($SignNames, JSON_UNESCAPED_UNICODE),
            'TemplateCode' => $TemplateCode,
            'TemplateParam' => json_encode($TemplateParam, JSON_UNESCAPED_UNICODE)
        ];
        $data = array_replace_recursive($this->getCommonData(), $params);
        $this->signature($data);
        $this->setEndpoint('',$data);
        return $this->send();
    }
}
