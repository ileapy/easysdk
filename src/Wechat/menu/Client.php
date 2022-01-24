<?php
/**
 * User: cfn <cfn@leapy.cn>
 * Datetime: 2021/8/19 11:35
 * Copyright: php
 */

namespace easysdk\Wechat\menu;

use easysdk\Kernel\Client\WechatClient;

/**
 * Class Config
 *
 * @package easysdk\UnionPayMini\config
 */
class Client extends WechatClient
{
    /**
     * @param array $menu 菜单数据
     * @return array|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/24
     */
    public function create($menu)
    {
        $this->setEndpoint('cgi-bin/menu/create');
        return $this->send($this->getCredentials($menu));
    }

    /**
     * 查询菜单
     * @return array|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/24
     */
    public function query()
    {
        $this->requestMethod = 'GET';
        $this->setEndpoint('cgi-bin/get_current_selfmenu_info');
        return $this->send();
    }

    /**
     * 删除底部菜单
     * @return array|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/24
     */
    public function delete()
    {
        $this->requestMethod = 'GET';
        $this->setEndpoint('cgi-bin/menu/delete');
        return $this->send();
    }

    /**
     * 个性化菜单创建
     * @param array $menu 个性化菜单
     * @return array|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/24
     */
    public function addConditional($menu)
    {
        $this->setEndpoint('cgi-bin/menu/addconditional');
        return $this->send($this->getCredentials($menu));
    }

    /**
     * 删除个性化菜单
     * @param string $menuid 个性化菜单id
     * @return array|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/24
     */
    public function delConditional($menuid)
    {
        $this->setEndpoint('cgi-bin/menu/delconditional');
        return $this->send($this->getCredentials(compact('menuid')));
    }

    /**
     * 删除个性化菜单
     * @param string $user_id user_id可以是粉丝的OpenID，也可以是粉丝的微信号。
     * @return array|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/24
     */
    public function tryMatch($user_id)
    {
        $this->setEndpoint('cgi-bin/menu/trymatch');
        return $this->send($this->getCredentials(compact('user_id')));
    }
}
