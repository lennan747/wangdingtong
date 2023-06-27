<?php

namespace Lennan747\WdtSdk\Api;

/**
 * Class Logistics
 * @package Lennan747\WdtSdk\Api
 */
class Logistics extends Base
{
    protected $query_url = 'logistics_sync_query.php';
    protected $ack_url = 'logistics_sync_ack.php';


    /**
     * @param int $limit
     * @return \Lennan747\WdtSdk\Core\Collection|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Lennan747\WdtSdk\Core\Exceptions\HttpException
     */
    public function query(int $limit = 100)
    {
        $params = [
            'shop_no' => $this->config->get('shop_no'),
            'limit' => $limit,
            //'is_part_sync_able' => json_encode($params, JSON_UNESCAPED_UNICODE),
        ];
        return $this->request($this->query_url, $params);
    }

    /**
     * @param $params
     * @return \Lennan747\WdtSdk\Core\Collection|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Lennan747\WdtSdk\Core\Exceptions\HttpException
     */
    public function ack($params)
    {
        $params = [
            'logistics_list' => json_encode($params, JSON_UNESCAPED_UNICODE),
        ];
        return $this->request($this->ack_url, $params);
    }

}