<?php

return [
    // your recapthca site key.
    'siteKey'   => '',
    // your recapthca secret key.
    'secretKey' => '',
    // other options to customize your configs
    'options' => [
        // set true if you want to hide your recaptcha badge
        'hideBadge' => true,
        // optional, reposition the reCAPTCHA badge. 'inline' allows you to control the CSS.
        // available values: bottomright, bottomleft, inline
        'dataBadge' => 'bottomright',
        // timeout value for guzzle client
        'timeout' => 5,
        // set true to show binding status on your javascript console
        'debug' => false
    ]
];