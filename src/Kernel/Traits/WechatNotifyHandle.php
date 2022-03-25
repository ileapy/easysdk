<?php
/**
 * User: cfn <cfn@leapy.cn>
 * Datetime: 2021/8/20 9:33
 * Copyright: php
 */

namespace easysdk\Kernel\Traits;

use easysdk\Kernel\Support\Xml;
use Exception;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class MiniProgramNotifyHandle
 *
 * @package unionpay\Kernel\Traits
 */
trait WechatNotifyHandle
{
    /**
     * @var string
     */
    protected $data = [];

    /**
     * @var array
     */
    protected $query = [];

    /**
     * @var Response
     */
    protected $response = null;

    /**
     * @return Response
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/26
     */
    protected function toResponse()
    {
        // 自定义回复
        if (!empty($this->response) || $this->response instanceof Response) return $this->response;
        // 服务器验证
        if (isset($this->query['echostr'])) return new Response($this->query['echostr']);
        // 默认回复
        return new Response("success");
    }

    /**
     * @return array|string
     * @throws Exception
     * @author cfn <cfn@leapy.cn>
     * @date 2021/8/20 9:37
     */
    protected function getData()
    {
        if (!empty($this->data)) return $this->data;

        // 数据处理
        $_data = $this->app['request']->getContent();
        $this->data = Xml::xmlToArr($_data);
        $this->query = $_GET;

        if (!$this->validate($_GET))
            throw new Exception('验签失败', 400);

        return $this->data;
    }

    /**
     * 设置返回内容
     * @param Response|string|null $response
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/26
     */
    protected function setResponse($response = null)
    {
        if (is_string($response)) $this->response = new Response($response);
        elseif ($response instanceof Response) $this->response = $response;
    }
}
