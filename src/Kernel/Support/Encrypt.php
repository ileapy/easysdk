<?php
/**
 * User: cfn <cfn@leapy.cn>
 * Datetime: 2021/8/16 20:19
 * Copyright: php
 */

namespace easysdk\Kernel\Support;

/**
 * Class TripleEncrypt
 *
 * @package unionpay\Kernel\Support
 */
class Encrypt
{
    /**
     * 加密
     * @param $input
     * @param $key
     * @param string $iv
     * @return string
     */
    public static function encrypt3DES($input, $key)
    {
        return base64_encode(openssl_encrypt($input,'DES-EDE3',pack("H48", $key),OPENSSL_RAW_DATA));
    }

    /**
     * 解密
     * @param $encrypted
     * @param $key
     * @return false|string
     */
    public static function decrypt3DES($encrypted, $key)
    {
        return openssl_decrypt(base64_decode($encrypted), 'des-ede3', pack("H48", $key), OPENSSL_PKCS1_PADDING);
    }

    /**
     * 签名
     * @param array param 待签名的参数
     * @param string signKey 私钥加密
     * @return string 签名结果字符串
     */
    public static function sign($params, $signKey)
    {
        openssl_sign(Str::sortByASCII($params), $binary_signature, $signKey, "SHA256");
        return base64_encode($binary_signature);
    }

    /**
     * 银联公钥验签
     * @param array $data 原始数据
     * @param string $publicKey 银联公钥
     * @return bool 验签结果
     * @author cfn <cfn@leapy.cn>
     * @date 2021/8/19 19:13
     */
    public static function verify($data, $publicKey = "")
    {
        $signature = $data['signature'];
        unset($data['signature']);
        $res = openssl_get_publickey($publicKey);
        $result = (bool)openssl_verify(Str::sortByASCII($data), base64_decode($signature), $res,'SHA256');
        openssl_free_key($res);
        return $result;
    }

    /**
     * 对字段批量签名
     * @param string symmetricKey 签名秘钥
     * @param array params 待加密数据
     * @field 要加密的字段
     */
    public static function encryptedParamMap($symmetricKey, $params, $field)
    {
        foreach ($field as $k => $v) $params[$v] = self::encrypt3DES($params[$v], $symmetricKey);
        return $params;
    }

    /**
     * 使用公钥加密对称密钥
     * @param string $publicKey 公钥
     * @param string $symmetricKey 对称密钥字节
     * @return false|string 加密后的对称密钥字节
     * @author cfn <cfn@leapy.cn>
     * @date 2021/8/19 19:05
     */
    public function encrypt($publicKey, $symmetricKey)
    {
        $key = openssl_pkey_get_public($publicKey);
        if ($key === false) return false;
        $return_en = openssl_public_encrypt($symmetricKey, $crypted, $key);
        if (!$return_en) return false;
        return base64_encode($crypted);
    }

    /**
     * 使用私钥解密对称密钥
     * @param string $privateKey 私钥
     * @param string $symmetricKey 对称密钥字节
     * @return false|mixed|void
     * @author cfn <cfn@leapy.cn>
     * @date 2021/8/19 19:06
     */
    public static function decrypt($privateKey, $symmetricKey)
    {
        $key = openssl_pkey_get_private($privateKey);
        if ($key === false) return false;
        $return_en = openssl_private_decrypt(base64_decode($symmetricKey), $decrypted, $key);
        if (!$return_en) return false;
        return $decrypted;
    }
}
