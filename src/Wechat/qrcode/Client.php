<?php
/**
 * User: cfn <cfn@leapy.cn>
 * Datetime: 2021/8/19 11:35
 * Copyright: php
 */

namespace easysdk\Wechat\qrcode;

use easysdk\Kernel\Client\WechatClient;

/**
 * Class Config
 *
 * @package easysdk\UnionPayMini\config
 */
class Client extends WechatClient
{
    /**
     * @param string|int $scene 临时二维码时为32位非0整型，永久二维码时最大值为100000（目前参数只支持1--100000）|| 字符串类型，长度限制为1到64
     * @param int $expire_seconds 默认60s 填0永久
     * @return array|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/24
     */
    public function create($scene, $expire_seconds = 60)
    {
        $action_name = $expire_seconds > 0 ? (is_int($scene) ? 'QR_SCENE' : 'QR_STR_SCENE') : (is_int($scene) ? 'QR_LIMIT_SCENE' : 'QR_LIMIT_STR_SCENE');
        is_int($scene) ? $action_info['scene_id'] = $scene : $action_info['scene_str'] = $scene;

        $this->setEndpoint('cgi-bin/qrcode/create');
        return $this->send($this->getCredentials(compact('action_name','action_info','expire_seconds')));
    }

    /**
     * @param string $ticket 二维码ticket
     * @return array|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/24
     */
    public function showqrcode($ticket)
    {
        $this->requestMethod = 'GET';
        $this->endpoint = 'cgi-bin/showqrcode?ticket=' . $ticket;
        return $this->send();
    }

    /**
     * @param string $long_data 需要转换的长信息，不超过4KB
     * @param int $expire_seconds 过期秒数，最大值为2592000（即30天），默认为2592000
     * @return array|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/24
     */
    public function shorten($long_data, $expire_seconds=0)
    {
        $this->setEndpoint('cgi-bin/shorten/gen');
        return $this->send($this->getCredentials(compact('long_data','expire_seconds')));
    }

    /**
     * @param string $short_key 短key
     * @return array|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/24
     */
    public function fetchShorten($short_key)
    {
        $this->setEndpoint('cgi-bin/shorten/fetch');
        return $this->send($this->getCredentials(compact('short_key')));
    }

}
