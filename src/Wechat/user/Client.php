<?php
/**
 * User: cfn <cfn@leapy.cn>
 * Datetime: 2021/8/19 11:35
 * Copyright: php
 */

namespace easysdk\Wechat\user;

use easysdk\Kernel\Client\WechatClient;

/**
 * Class Config
 *
 * @package easysdk\UnionPayMini\config
 */
class Client extends WechatClient
{
    /**
     * @param string $next_openid 第一个拉取的OPENID，不填默认从头开始拉取
     * @return array|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/24
     */
    public function getUser($next_openid = '')
    {
        $this->requestMethod = 'GET';
        $this->setEndpoint('cgi-bin/user/get',compact('next_openid'));
        return $this->send();
    }

    /**
     * @param int $tagid 标签id
     * @param string $next_openid 第一个拉取的OPENID，不填默认从头开始拉取
     * @return array|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/24
     */
    public function tagUser($tagid, $next_openid = '')
    {
        $this->setEndpoint('cgi-bin/user/tag/get');
        return $this->send($this->getCredentials(compact('next_openid','tagid')));
    }

    /**
     * @param string $openid 普通用户的标识，对当前公众号唯一
     * @param string $lang 返回国家地区语言版本，zh_CN 简体，zh_TW 繁体，en 英语
     * @return array|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/24
     */
    public function userInfo($openid, $lang = 'zh_CN')
    {
        $this->requestMethod = 'GET';
        $this->setEndpoint('cgi-bin/user/info',compact('openid','lang'));
        return $this->send();
    }

    /**
     * @param string $openid 普通用户的标识，对当前公众号唯一
     * @param string $remark 新的备注名，长度必须小于30字节
     * @return array|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException Author cfn <cfn@leapy.cn>
     * Date 2022/1/24
     */
    public function updateRemark($openid, $remark)
    {
        $this->setEndpoint('cgi-bin/user/info/updateremark');
        return $this->send($this->getCredentials(compact('openid','remark')));
    }
}
