<?php
/**
 * User: cfn <cfn@leapy.cn>
 * Datetime: 2021/8/17 23:12
 * Copyright: php
 */

namespace easysdk\UnionPayAppPayment\file;

use easysdk\Kernel\Exceptions\InvalidArgumentException;
use easysdk\Kernel\Exceptions\ValidationFailException;
use easysdk\Kernel\Client\UnionPayAppPaymentClient;
use easysdk\Kernel\Support\AcpService;

/**
 * Class Client
 *
 * @package easysdk\UnionPayAppPayment\file
 */
class Client extends UnionPayAppPaymentClient
{
    /**
     * 此接口暂不可用
     * 银联加密公钥更新查询接口
     * @throws InvalidArgumentException|\GuzzleHttp\Exception\GuzzleException
     * @throws ValidationFailException
     * @author cfn <cfn@leapy.cn>
     * @date 2021/8/20 19:39
     */
    public function updatePublicKey($params)
    {
        $this->setEndpoint("backTransReq.do");

        $base = [
            // 产品类型
            'bizType'          =>      '000201',
            // 订单发送时间，格式为YYYYMMDDhhmmss，取北京时间
            'txnTime'        =>        date('YmdHis'),
            // 交易类型
            'txnType'        =>        '95',
            // 交易子类
            'txnSubType'     =>        '00',
            // 商户代码，请改自己的商户号
            'merId'          =>        $this->config['merId']
        ];

        $data = array_replace_recursive($this->config['payConfig'], $base, $params);

        // 必填项校验
        if (!isset($data['orderId']))
            throw new InvalidArgumentException("商户订单号[orderId]必传，自定义");

        // 签名
        $this->app->signature->sign($data, $this->config['signCertPath'], $this->config['signCertPwd']);

        // 验签
        $result = $this->send($data);
        if (!$this->app->signature->validate($result)) throw new ValidationFailException('验签失败');
        return $result;
    }

    /**
     * 文件传输类交易接口
     * @param array $params
     * @return false|string[]
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws InvalidArgumentException
     * @throws ValidationFailException
     * @author cfn <cfn@leapy.cn>
     * @date 2021/8/20 19:58
     */
    public function download($params)
    {
        $this->setEndpoint("",true);

        $base = [
            // 产品类型
            'bizType'          =>      '000000',
            // 订单发送时间，格式为YYYYMMDDhhmmss，取北京时间
            'txnTime'        =>        date('YmdHis'),
            // 交易类型
            'txnType'        =>        '76',
            // 交易子类
            'txnSubType'     =>        '01',
            // 商户代码，请改自己的商户号
            'merId'          =>        $this->config['merId'],
            // 文件类型
            'fileType' => '00',
        ];

        $data = array_replace_recursive($this->config['payConfig'], $base, $params);

        // 必填项校验
        if (!isset($data['settleDate']))
            throw new InvalidArgumentException("清算日期[settleDate]必传，格式为MMDD");

        // 签名
        $this->app->signature->sign($data, $this->config['signCertPath'], $this->config['signCertPwd']);

        // 验签
        $result = $this->send($data);
        if (!$this->app->signature->validate($result)) throw new ValidationFailException('验签失败');
        return $result;
    }

    /**
     * 保存文件
     * @param array $params download返回的数据
     * @param string $filePath 文件保存地址
     * @return array|false
     * @throws InvalidArgumentException
     * @author cfn <cfn@leapy.cn>
     * @date 2021/8/20 20:14
     */
    public function save($params, $filePath)
    {
        // 文件不存在
        if ($params['respCode'] == "98")
            throw new InvalidArgumentException('文件不存在。', 400);
        elseif ($params['respCode'] != "00")
            throw new InvalidArgumentException('获取失败。', 400);

        // 成功返回文件名称 失败返回false
        if (AcpService::decodeFileContent($params, $filePath))
        {
            $fileName =  isset($params['fileName']) && !empty($params['fileName']) ? $filePath . $params['fileName'] : $filePath . $params['merId'] . '_' . $params['batchNo'] . '_' . $params['txnTime'] . '.txt';
            return compact('fileName');
        }
        return false;
    }
}
