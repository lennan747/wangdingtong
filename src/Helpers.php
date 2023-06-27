<?php

namespace Lennan747\WdtSdk;

/**
 * Generate a signature.
 *
 * @param array $attributes
 * @param string $appsecret
 * @return string
 */
function generate_sign(array $attributes, string $appsecret): string
{
    //print_r($attributes);die();
    ksort($attributes);
    $arr = [];
    foreach ($attributes as $key => $val) {
        if ($key == 'sign') continue;

        if (count($arr)) $arr[] = ';';

        $arr[] = sprintf("%02d", iconv_strlen($key, 'UTF-8'));
        $arr[] = '-';
        $arr[] = $key;
        $arr[] = ':';
        $arr[] = sprintf("%04d", iconv_strlen($val, 'UTF-8'));
        $arr[] = '-';
        $arr[] = $val;
    }
    $signString = implode('', $arr);

    return md5($signString . $appsecret);
}

/**
 * Get client ip.
 *
 * @return string
 */
function get_client_ip()
{
    if (!empty($_SERVER['REMOTE_ADDR'])) {
        $ip = $_SERVER['REMOTE_ADDR'];
    } else {
        // for php-cli(phpunit etc.)
        $ip = defined('PHPUNIT_RUNNING') ? '127.0.0.1' : gethostbyname(gethostname());
    }

    return filter_var($ip, FILTER_VALIDATE_IP) ?: '127.0.0.1';
}