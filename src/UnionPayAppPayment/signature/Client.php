<?php
/**
 * User: cfn <cfn@leapy.cn>
 * Datetime: 2021/8/19 10:49
 * Copyright: php
 */

namespace easysdk\UnionPayAppPayment\signature;

use easysdk\Kernel\Client\UnionPayAppPaymentClient;
use easysdk\Kernel\Support\AcpService;

/**
 * Class Verify
 *
 * @package easysdk\UnionPayAppPayment\verify
 */
class Client extends UnionPayAppPaymentClient
{
    /**
     * 验签
     * @param array $params 验签参数
     * @return bool
     * @throws \Exception
     * @author cfn <cfn@leapy.cn>
     * @date 2021/8/19 10:51
     */
    public function validate($params)
    {
        return (bool)AcpService::validate($params,'',
            $this->config['debug'] ? $this->config['test_cert']['middleCertPath'] : $this->config['cert']['middleCertPath'],
            $this->config['debug'] ? $this->config['test_cert']['rootCertPath'] : $this->config['cert']['rootCertPath'],
            !$this->config['debug']);
    }

    /**
     * 加签
     * @param array $params 签名参数
     * @author cfn <cfn@leapy.cn>
     * @date 2021/8/19 10:56
     * @throws \Exception
     */
    public function sign(&$params)
    {
        if (!isset($this->config['signCertPath']) || empty($this->config['signCertPath']))
            throw new \Exception('签名证书未配置！');
        AcpService::sign($params, $this->config['signCertPath'], $this->config['signCertPwd']);
    }
}
