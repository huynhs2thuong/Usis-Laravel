<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default tax rate
    |--------------------------------------------------------------------------
    |
    | This default tax rate will be used when you make a class implement the
    | Taxable interface and use the HasTax trait.
    |
    */

    'tax' => 0,

    /*
    |--------------------------------------------------------------------------
    | Shoppingcart database settings
    |--------------------------------------------------------------------------
    |
    | Here you can set the connection that the shoppingcart should use when
    | storing and restoring a cart.
    |
    */

    'database' => [

        'connection' => null,

        'table' => 'shoppingcart',

    ],

    /*
    |--------------------------------------------------------------------------
    | Destroy the cart on user logout
    |--------------------------------------------------------------------------
    |
    | When this option is set to 'true' the cart will automatically
    | destroy all cart instances when the user logs out.
    |
    */

    'destroy_on_logout' => false,

    /*
    |--------------------------------------------------------------------------
    | Default number format
    |--------------------------------------------------------------------------
    |
    | This defaults will be used for the formated numbers if you don't
    | set them in the method call.
    |
    */

    'format' => [

        'decimals' => 0,

        'decimal_point' => '',

        'thousand_seperator' => ''

    ],

    # Đơn hàng tối thiểu
    'total_min' => 50000,

    # Thời gian tồn tại của giỏ hàng nhóm (phút)
    'gartTimeout' => 720,

    # Không thanh toán đơn hàng vào ban đêm
    'timeCheckout' => [
        'start' => 8, // 9:00 AM
        'end' => 20.5 // 9:30 PM
    ],

    # Hoa Sao API link
    'apiTest' => 'http://118.69.182.250:7889/jollibee_test/ws/create_order_ws.php?wsdl',
    'api' => 'http://118.69.182.250:7889/jollibee/ws/create_order_ws_ma.php?wsdl',
//    'api' => 'http://115.79.60.215:7889/jollibee/ws/create_order_ws_ma.php?wsdl',
];
