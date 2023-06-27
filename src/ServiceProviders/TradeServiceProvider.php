<?php

namespace Lennan747\WdtSdk\ServiceProviders;

use Lennan747\WdtSdk\Api\Trade;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class TradeServiceProvider implements ServiceProviderInterface
{

    public function register(Container $pimple)
    {
        $pimple['trade'] = function ($pimple) {
            return new Trade($pimple['config']);
        };
    }
}