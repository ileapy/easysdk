<?php
/**
 * User: cfn <cfn@leapy.cn>
 * Datetime: 2021/8/19 11:35
 * Copyright: php
 */

namespace easysdk\Wechat\tags;

use easysdk\Kernel\Client\WechatClient;
use phpDocumentor\Reflection\Types\Integer;

/**
 * Class Config
 *
 * @package easysdk\UnionPayMini\config
 */
class Client extends WechatClient
{
    /**
     * @return array|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/24
     */
    public function get()
    {
        $this->requestMethod = 'GET';
        $this->setEndpoint('cgi-bin/tags/get');
        return $this->send();
    }

    /**
     * @param string $name 标签名（30个字符以内）
     * @return array|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/24
     */
    public function create($name)
    {
        $tag['name'] = $name;
        $this->setEndpoint('cgi-bin/tags/create');
        return $this->send($this->getCredentials(compact('tag')));
    }

    /**
     * @param int $id 标签id，由微信分配
     * @param string $name 标签名（30个字符以内）
     * @return array|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException Author cfn <cfn@leapy.cn>
     * Date 2022/1/24
     */
    public function update($id, $name)
    {
        $tag['id'] = $id;
        $tag['name'] = $name;
        $this->setEndpoint('cgi-bin/tags/update');
        return $this->send($this->getCredentials(compact('tag')));
    }

    /**
     * @param int $id 标签id，由微信分配
     * @return array|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/24
     */
    public function delete($id)
    {
        $tag['id'] = $id;
        $this->setEndpoint('cgi-bin/tags/delete');
        return $this->send($this->getCredentials(compact('tag')));
    }

    /**
     * 批量打标签
     * @param int $tagid 标签id
     * @param array $openid_list 粉丝列表
     * @return array|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/24
     */
    public function batchtagging($tagid, $openid_list)
    {
        $this->setEndpoint('cgi-bin/tags/members/batchtagging');
        return $this->send($this->getCredentials(compact('tagid','openid_list')));
    }

    /**
     * 批量取消标签
     * @param int $tagid 标签id
     * @param array $openid_list 粉丝列表
     * @return array|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/24
     */
    public function batchuntagging($tagid, $openid_list)
    {
        $this->setEndpoint('cgi-bin/tags/members/batchuntagging');
        return $this->send($this->getCredentials(compact('tagid','openid_list')));
    }

    /**
     * @param string $openid 普通用户的标识，对当前公众号唯一
     * @return array|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/24
     */
    public function getidlist($openid)
    {
        $this->setEndpoint('cgi-bin/tags/getidlist');
        return $this->send($this->getCredentials(compact('openid')));
    }
}
