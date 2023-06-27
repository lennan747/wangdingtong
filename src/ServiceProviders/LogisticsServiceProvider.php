<?php

namespace Lennan747\WdtSdk\ServiceProviders;

use Lennan747\WdtSdk\Api\Logistics;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class LogisticsServiceProvider implements ServiceProviderInterface
{

    public function register(Container $pimple)
    {
        $pimple['logistics'] = function ($pimple) {
            return new Logistics($pimple['config']);
        };
    }
}