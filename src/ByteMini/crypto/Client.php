<?php
/**
 * User: cfn <cfn@leapy.cn>
 * Datetime: 2021/8/16 20:19
 * Copyright: php
 */

namespace easysdk\ByteMini\crypto;

use easysdk\Kernel\Client\ByteMiniClient;
use easysdk\Kernel\Support\Encrypt;

/**
 * Class Client
 * @package: easysdk\ByteMini\crypto
 */
class Client extends ByteMiniClient
{
    /**
     * 加密
     * @param array $data
     * @param string $session_key
     * @return string
     * @author cfn <cfn@leapy.cn>
     * @date 2021/8/16 20:30
     */
    public function signature($data, $session_key)
    {
        return hash_hmac('sha256', json_encode($data, JSON_UNESCAPED_UNICODE), $session_key);
    }
}
