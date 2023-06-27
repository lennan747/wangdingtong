<?php

namespace Lennan747\WdtSdk\Api;

class Trade extends Base
{
    protected $url = 'trade_push.php';

    /**
     * @param array $orders
     *              $orders['tid'] 原始单号
     *              $orders['trade_status'] 平台状态 30 已付款待发货(包含货到付款) 40 已发货 70 已完成（已签收），平台订单完成（客户确认收货）后，推送此状态 80 已退款(付款后又全部退款推送此状态)
     *              $orders['pay_status'] 平台支付状态 平台订单付款状态:0:未付款,1:部分付款,2:已付款
     *              $orders['delivery_term'] 1:款到发货,2:货到付款(包含部分货到付款),3:分期付款,4:挂账
     *              $orders['pay_time'] 支付时间 yyyy-MM-dd HH:mm:ss
     *              $orders['buyer_nick    va'] 客户网名
     *              $orders['receiver_name'] 收件人
     *              $orders['receiver_province'] 收件人省
     *              $orders['receiver_city'] 收件人市
     *              $orders['receiver_district'] 收件人区
     *              $orders['receiver_address'] 收件人地址
     *              $orders['receiver_mobile'] 收件人手机
     *              $orders['post_amount'] 邮费
     *              $orders['cod_amount'] 货到付款金额 货到付款金额   cod金额=(price * num + adjust_amount -discount – share_discount）+post_amount+ext_cod_fee-paid
     *              $orders['ext_cod_fee'] 货到付款买家费用，扣除货到付款订单金额后，卖家仍需支付的货到付款其他金额。这个钱卖家收不回来，是快递公司直接收走，但在快递单里是要打印出来，否则快递收款就错了
     *              $orders['other_amount'] 其它收费
     *              $orders['paid'] 订单已付金额，paid计算公式：paid = Σ(price * num + adjust_amount -discount – share_discount）+ post_amount+other_amount，所有金额相关字段推送处理办法
     *              $orders['order_list'] 订单货品明细节点
     *
     *              $orders['order_list']['oid'] 原始单号
     *              $orders['order_list']['num'] 数量
     *              $orders['order_list']['price'] 单价
     *              $orders['order_list']['status'] 状态
     *              $orders['order_list']['refund_status'] 退款状态
     *              $orders['order_list']['goods_id'] 平台货品ID
     *              $orders['order_list']['spec_no'] 规格编码
     *              $orders['order_list']['goods_name'] 货品名称
     * @param array $order_list
     * @return \Lennan747\WdtSdk\Core\Collection|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Lennan747\WdtSdk\Core\Exceptions\HttpException
     */
    public function push(array $orders, array $order_list)
    {
        $orders['order_list'] = $order_list;

        $params = [
            'shop_no' => $this->config->get('shop_no'),
            'switch' => $this->config->get('switch'),
            'trade_list' => json_encode([$orders], JSON_UNESCAPED_UNICODE),
        ];

        return $this->request($this->url, $params);
    }

}