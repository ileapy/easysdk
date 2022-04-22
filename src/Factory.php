<?php

namespace easysdk;

/**
 * Class Factory
 * @package: easysdk
 *
 * @method static \easysdk\AliyunSms\Application           AliyunSms(array $config)
 * @method static \easysdk\UnionPayMini\Application        UnionPayMini(array $config)
 * @method static \easysdk\UnionPayAppPayment\Application  UnionPayAppPayment(array $config)
 * @method static \easysdk\WechatMini\Application          WechatMini(array $config)
 * @method static \easysdk\WechatWeb\Application           WechatWeb(array $config)
 * @method static \easysdk\Wechat\Application              Wechat(array $config)
 * @method static \easysdk\ByteMini\Application            ByteMini(array $config)
 * @method static \easysdk\BytePayment\Application         BytePayment(array $config)
 * @method static \easysdk\UnionPayUtpPayment\Application  UnionPayUtpPayment(array $config)
 */
class Factory
{
    /**
     * @param $funName
     * @param $arguments
     * @return mixed
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/21
     */
    public static function __callStatic($funName, $arguments)
    {
        return self::create($funName, ...$arguments);
    }

    /**
     * @param $funName
     * @param array $config
     * @return mixed
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/21
     */
    private static function create($funName, array $config)
    {
        $application = "\\easysdk\\{$funName}\\Application";
        return new $application($config);
    }
}
