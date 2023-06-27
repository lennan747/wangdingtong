<?php


include __DIR__ . '/vendor/autoload.php';

use Lennan747\WdtSdk\Application;


function query(Application $app)
{
    $logistics = $app->logistics;
    $result = $logistics->query();
    print_r($result);
}

function push(Application $app)
{
    $order = [
        'id' => 9041,
        'order_id' => 'wx381838902488465904',
        'trade_no' => '',
        'uid' => 12,
        'real_name' => '张三',
        'user_phone' => '13800138000',
        'user_address' => '北京市 北京市 东城区 sdsf',
        'freight_price' => 0.00,
        'total_num' => 1,
        'total_price' => 10.00,
        'total_postage' => 0,
        'pay_price' => 10.00,
        'pay_postage' => 0,
        'deduction_price' => 0,
        'coupon_price' => 0,
        'pay_time' => 0,
        'pay_type' => 'yue',
        'add_time' => 1687679279,
    ];

    $orderCartInfo = [
        [
            'id' => '14404301008861134904',
            'product_id' => 904,
            'product_attr_unique' => '1_1',
            'store_name' => '学而思学习平板',
            'cart_num' => 1,
            'truePrice' => 10.00,
            'attrInfo' => [
                'id' => 9041,
                'product_id' => 904,
                'suk' => "默认",
                'stock' => 993,
                'sales' => 3,
                'price' => 10.00,
                'distributor_price' => 10.00,
                'sales_company_price' => 10.00,
                //'unique' => '3a15b5f2',
                'bar_code' => '6975619720073',
            ]
        ]
    ];

    $user_address = explode(' ', $order['user_address']);
    $order = [
        'tid' => $order['order_id'],
        'trade_status' => 30, // 已付款待发货(包含货到付款)，30只可以直接变更为70/ 80这2种状态
        'pay_status' => 2, // 已付款
        'delivery_term' => 1, // 1:款到发货
        'trade_time' => date('Y-m-d H:i:s', $order['add_time']),
        'pay_time' => date('Y-m-d H:i:s', time()),
        'buyer_nick' => $order['real_name'],
        'receiver_name' => $order['real_name'],
        'receiver_province' => $user_address[0],
        'receiver_city' => $user_address[1],
        'receiver_district' => $user_address[2],
        'receiver_address' => $user_address[3],
        'receiver_mobile' => $order['user_phone'],
        'post_amount' => $order['total_postage'],
        'cod_amount' => 0,
        'ext_cod_fee' => 0,
        'other_amount' => 0,
        'paid' => $order['pay_price'],
        'logistics_type' => 8
    ];

    $order_list = [];

    foreach ($orderCartInfo as $cartInfo) {
        $order_list[] = [
            'oid' => $cartInfo['id'],
            'num' => $cartInfo['cart_num'],
            'price' => $cartInfo['truePrice'],
            'title' => $cartInfo['store_name'],
            'status' => 30,
            'goods_id' => $cartInfo['product_id'],
            //'goods_no' => $cartInfo['attrInfo']['unique'],
            'goods_name' => $cartInfo['store_name'],
            'spec_name' => $cartInfo['store_name'] . $cartInfo['attrInfo']['suk'],
            'spec_no' => $cartInfo['attrInfo']['bar_code'],
            'share_discount' => 0,
        ];
    }


    $app->trade->push($order, $order_list);
}


$config = [
    'sid' => 'apidevnew2',
    'appkey' => 'hongyu2-test',
    'appsecret' => '38857fc08',

    'shop_no' => 'hongyu2-test',
    'shop_name' => 'hongyu2-test',
    'warehouse_no' => 'hongyu2-test',
    'warehouse_name' => 'hongyu2-test',
    'platform_id' => '127',

    'switch' => 1,
    'environment' => 'dev',
];

$app = new Application($config);

query($app);