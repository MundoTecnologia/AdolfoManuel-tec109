<?php

namespace Consultoria\Paypal;

use PayPal\Rest\ApiContext;

use PayPal\Auth\OAuthTokenCredential;

class ApiConfig
{
    public $api;

    // public function __construct()
    // {
    //     $this->api = new ApiContext(
    //         new OAuthTokenCredential(
    //             'AV991292MMkyYSM0uOlM8AfGSHzx1d6Zg-yW8PSac-_P0tbFsTE_jp9g50Z7AGlqK1XsvvflGxbQ3X2M', // Substituir pelo seu client ID
    //             'ED474sO_1vrjB_ZgiTzXxzzBMxG8a211-amUFvcoYWjbv4vllYnpSYxUiLKmD48PKPvzqxU1ZwW0YRPx' // Substituir pelo seu client secret
    //         )
    //     );
    // }
    public function config()
    {
        $this->api->setConfig([
            'mode' => 'sandbox',
            'log.LogEnabled' => true,
            'log.FileName' => 'PayPal.log',
            'log.LogLevel' => 'FINE',
            'validation.level' => 'log'
        ]);
    }
}
