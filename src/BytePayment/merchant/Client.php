<?php
/**
 * User: cfn <cfn@leapy.cn>
 * Datetime: 2021/8/19 11:35
 * Copyright: php
 */

namespace easysdk\BytePayment\merchant;

use easysdk\Kernel\Client\BytePaymentClient;

/**
 * Class Client
 * @package: easysdk\Client\order
 */
class Client extends BytePaymentClient
{
    /**
     * 服务商进件接口
     * @param string $component_access_token 授权码兑换接口调用凭证， 参考第三方平台文档：
     * @param string $thirdparty_component_id 小程序第三方平台应用 id
     * @param int $url_type 链接类型：1-进件页面 2-账户余额页
     * @return array|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/25
     */
    public function addMerchant($component_access_token, $thirdparty_component_id, $url_type)
    {
        $this->setEndpoint('apps/ecpay/saas/add_merchant');
        return $this->send(compact('component_access_token','thirdparty_component_id','url_type'));
    }

    /**
     * 服务商代小程序进件
     * @param string $thirdparty_id 小程序第三方平台应用 id
     * @param int $url_type 链接类型：1-进件页面 2-账户余额页
     * @return array|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/25
     */
    public function getAppMerchant($thirdparty_id, $url_type)
    {
        $this->setEndpoint('apps/ecpay/saas/get_app_merchant');
        $data = $this->getCredentials(compact('thirdparty_id','url_type'));
        $this->signature($data);
        return $this->send($data);
    }

    /**
     * 小程序为第三方进件
     * @param string $sub_merchant_id 商户 id，用于接入方自行标识并管理进件方。由开发者自行分配管理
     * @param int $url_type 链接类型：1-进件页面 2-账户余额页
     * @return array|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/25
     */
    public function appAddSubMerchant($sub_merchant_id, $url_type)
    {
        $this->setEndpoint('apps/ecpay/saas/app_add_sub_merchant');
        $data = $this->getCredentials(compact('sub_merchant_id','url_type'));
        $this->signature($data);
        return $this->send($data);
    }

    /**
     * 服务商为第三方进件
     * @param string $sub_merchant_id 商户 id，用于接入方自行标识并管理进件方。由开发者自行分配管理
     * @param string $thirdparty_id 小程序第三方平台应用 id
     * @param int $url_type 链接类型：1-进件页面 2-账户余额页
     * @return array|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/25
     */
    public function addSubMerchant($sub_merchant_id, $thirdparty_id, $url_type)
    {
        $this->setEndpoint('apps/ecpay/saas/add_sub_merchant');
        $data = $this->getCredentials(compact('sub_merchant_id','thirdparty_id','url_type'));
        $this->signature($data);
        return $this->send($data);
    }

    /**
     * 服务商为第三方进件
     * @param string $sub_merchant_id 商户 id，用于接入方自行标识并管理进件方。由服务商自行分配管理
     * @param string $merchant_id 小程序平台分配商户号
     * @param string $thirdparty_id 第三方平台服务商 id，非服务商模式留空
     * @return array|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/25
     */
    public function queryMerchantStatus($sub_merchant_id, $merchant_id,$thirdparty_id='')
    {
        $this->setEndpoint('apps/ecpay/saas/query_merchant_status');
        $data = $this->getCredentials(compact('sub_merchant_id','merchant_id','thirdparty_id'));
        $this->signature($data);
        return $this->send($data);
    }
}
