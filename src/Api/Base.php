<?php

namespace Lennan747\WdtSdk\Api;

use Lennan747\WdtSdk\Config;
use Lennan747\WdtSdk\Core\Collection;
use Lennan747\WdtSdk\Core\Exceptions\HttpException;
use Lennan747\WdtSdk\Core\Http;
use Psr\Http\Message\ResponseInterface;
use function Lennan747\WdtSdk\generate_sign;

class Base
{
    /**
     * 测试环境API地址
     */
    const API_HOST_DEV = 'https://sandbox.wangdian.cn/openapi2/';

    /**
     * 正式环境API地址
     */
    const API_HOST_PRO = 'https://api.wangdian.cn/openapi2/';

    protected $debug = false;

    /**
     * @var \Lennan747\WdtSdk\Config
     */
    protected $config;

    /**
     * @var Http
     */
    protected $http;

    /**
     * 载入商户配置
     *
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        if ($config->get('environment') === 'dev') {
            $this->debug = true;
        }
        $this->config = $config;
    }


    /**
     * @param string $api
     * @param array $params
     * @param string $method
     * @param array $options
     * @param bool $returnResponse
     * @return \Lennan747\WdtSdk\Core\Collection|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Lennan747\WdtSdk\Core\Exceptions\HttpException
     */
    public function request(string $api, array $params, string $method = 'post', array $options = [], bool $returnResponse = false)
    {
        $params = $this->generateParamsAndSign($params);

        $options = array_merge($options, ['form_params' => $params]);

        $response = $this->getHttp()->request($this->getApi($api), $method, $options);

        if ($response->getStatusCode() !== 200) {
            throw new HttpException('[富友支付异常]请求异常: HTTP状态码 ' . $response->getStatusCode());
        }
        return $returnResponse ? $response : $this->parseResponse($response);
    }


    /**
     * 请求客户端
     *
     * @return Http
     */
    public function getHttp(): Http
    {
        if (is_null($this->http)) {
            $this->http = new Http();
        }

        return $this->http;
    }

    /**
     * 获取API地址
     *
     * @param string $api
     * @return string
     */
    public function getApi(string $api): string
    {
        if ($this->debug) {
            return self::API_HOST_DEV . $api;
        } else {
            return self::API_HOST_PRO . $api;
        }
    }

    /**
     * @param $response
     * @return mixed
     */
    protected function parseResponse($response)
    {
        return json_decode($response->getBody()->getContents());
    }


    protected function baseAttributes(): array
    {
        return [
            'sid' => $this->config->get('sid'),
            'appkey' => $this->config->get('appkey'),
            'timestamp' => time(),
        ];
    }

    protected function generateParamsAndSign(array $params): array
    {
        $attributes = array_merge($params, $this->baseAttributes());

        $sign = generate_sign($attributes, $this->config->get('appsecret'));

        return array_merge($attributes, ['sign' => $sign]);
    }
}