<?php
/**
 * User: cfn <cfn@leapy.cn>
 * Datetime: 2021/8/16 9:03
 * Copyright: php
 */

namespace easysdk\Kernel\Traits;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Handler\CurlHandler;
use GuzzleHttp\Handler\CurlMultiHandler;
use GuzzleHttp\Handler\StreamHandler;
use GuzzleHttp\HandlerStack;
use Psr\Http\Message\ResponseInterface;

/**
 * Author cfn <cfn@leapy.cn>
 * Date 2022/1/21
 */
trait HasHttpRequests
{
    /**
     * @var ClientInterface
     */
    protected $httpClient;

    /**
     * @var array
     */
    protected $middlewares = [];

    /**
     * @var HandlerStack
     */
    protected $handlerStack;

    /**
     * @var array
     */
    protected static $defaults = [
        'curl' => [
            CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4,
        ],
    ];

    /**
     * @param array $defaults
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/21
     */
    protected static function setDefaultOptions($defaults = [])
    {
        self::$defaults = $defaults;
    }

    /**
     * @return array|array[]
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/21
     */
    protected static function getDefaultOptions()
    {
        return self::$defaults;
    }

    /**
     * @param ClientInterface $httpClient
     * @return $this
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/21
     */
    protected function setHttpClient(ClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;

        return $this;
    }

    /**
     * @return Client|ClientInterface|mixed
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/21
     */
    protected function getHttpClient()
    {
        if (!($this->httpClient instanceof ClientInterface)) {
            if (property_exists($this, 'app') && $this->app['http']) {
                $this->httpClient = $this->app['http'];
            } else {
                $this->httpClient = new Client(['handler' => HandlerStack::create($this->getGuzzleHandler())]);
            }
        }
        return $this->httpClient;
    }

    /**
     * @param callable $middleware
     * @param null $name
     * @return $this
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/21
     */
    protected function pushMiddleware(callable $middleware, $name = null)
    {
        if (!is_null($name)) {
            $this->middlewares[$name] = $middleware;
        } else {
            array_push($this->middlewares, $middleware);
        }
        return $this;
    }

    /**
     * @return array
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/21
     */
    protected function getMiddlewares()
    {
        return $this->middlewares;
    }

    /**
     * @param $url
     * @param string $method
     * @param array $options
     * @return ResponseInterface
     * @throws GuzzleException
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/21
     */
    protected function request($url, $method = 'GET', $options = [])
    {
        $method = strtoupper($method);
        $options = array_merge(self::$defaults, $options, ['handler' => $this->getHandlerStack()]);
        $options = $this->fixJsonIssue($options);
        if (property_exists($this, 'baseUri') && !is_null($this->baseUri)) {
            $options['base_uri'] = $this->baseUri;
        }
        $response = $this->getHttpClient()->request($method, $url, $options);
        $response->getBody()->rewind();
        return $response;
    }

    /**
     * @param HandlerStack $handlerStack
     * @return $this
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/21
     */
    protected function setHandlerStack(HandlerStack $handlerStack)
    {
        $this->handlerStack = $handlerStack;
        return $this;
    }

    /**
     * @return HandlerStack
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/21
     */
    protected function getHandlerStack()
    {
        if ($this->handlerStack) {
            return $this->handlerStack;
        }
        $this->handlerStack = HandlerStack::create($this->getGuzzleHandler());
        foreach ($this->middlewares as $name => $middleware) {
            $this->handlerStack->push($middleware, $name);
        }
        return $this->handlerStack;
    }

    /**
     * @param array $options
     * @return array
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/21
     */
    protected function fixJsonIssue(array $options)
    {
        if (isset($options['json']) && is_array($options['json'])) {
            $options['headers'] = array_merge(isset($options['headers']) ? $options['headers'] : [], ['Content-Type' => 'application/json']);
            if (empty($options['json'])) {
                $options['body'] = \GuzzleHttp\json_encode($options['json'], JSON_FORCE_OBJECT);
            } else {
                $options['body'] = \GuzzleHttp\json_encode($options['json'], JSON_UNESCAPED_UNICODE);
            }
            unset($options['json']);
        }
        return $options;
    }

    /**
     * @return callable|CurlHandler|CurlMultiHandler|StreamHandler|mixed
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/21
     */
    protected function getGuzzleHandler()
    {
        if (property_exists($this, 'app') && isset($this->app['guzzle_handler'])) {
            return is_string($handler = $this->app->raw('guzzle_handler'))
                ? new $handler()
                : $handler;
        }
        return \GuzzleHttp\choose_handler();
    }

    /**
     * @param array $credentials
     * @return mixed
     * @throws GuzzleException
     * @throws \Exception
     * @author cfn <cfn@leapy.cn>
     * @date 2021/8/16 10:06
     */
    protected function requestToken($credentials)
    {
        $response = $this->sendRequest($credentials);
        return $response->getBody()->getContents();
    }

    /**
     * @param $credentials
     * @return ResponseInterface
     * @throws GuzzleException
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/21
     */
    protected function sendRequest($credentials)
    {
        $options = [
            ('GET' === $this->requestMethod) ? 'query' : $this->config['http_post_data_type'] => $credentials,
        ];
        return $this->setHttpClient($this->app['http'])->request($this->getEndpoint(), $this->requestMethod, $options);
    }

    /**
     * @return string
     * @author cfn <cfn@leapy.cn>
     * @date 2021/8/16 10:04
     */
    protected function getEndpoint()
    {
        return $this->endpoint;
    }
}
