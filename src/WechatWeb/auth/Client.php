<?php
/**
 * User: cfn <cfn@leapy.cn>
 * Datetime: 2021/8/19 11:35
 * Copyright: php
 */

namespace easysdk\WechatWeb\auth;

use easysdk\Kernel\Client\WechatWebClient;

/**
 * Class Config
 *
 * @package easysdk\UnionPayMini\config
 */
class Client extends WechatWebClient
{
    /**
     * getRedirectUri
     * Author: cfn <cfn@leapy.cn>
     * Date 2022/3/24
     * @param $redirect_uri
     * @param $scope
     * @param $state
     * @return string
     */
    public function getRedirectUri($redirect_uri, $scope='snsapi_base', $state="")
    {
        $redirect_uri = urlencode($redirect_uri);
        return "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$this->config['appid']}&redirect_uri={$redirect_uri}&response_type=code&scope={$scope}&state={$state}#wechat_redirect";
    }

//    public function
}
