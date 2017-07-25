<?php

if ($data['action'] == "getPaymentShopUrl") {
    echo json_encode(array(
        "response" => array(
            "data" => 'http://t4th.ph',
        ),
        "serialNo" => $engine->session->serialNo(),
        "time" => round(microtime(true) * 1000),
    ));
} elseif ($data['action'] == "getSmallestPackage") {
    echo json_encode([
        "time" => round(microtime(true) * 1000),
        "serialNo" => $engine->session->serialNo(),
        "response" => [
            "product_id" => 9741,
            "currency" => "USD",
            "is_bestdeal" => false,
            "is_promo" => "",
            "original_units" => "",
            "percentage" => "",
            "price" => "12.99",
            "units" => "300",
            "product_image_url" => "http://content.tg-payment.com/content/img/products/payment_package_3.png",
            "product_locale" => "en_US",
            "product_name" => "Package C",
            "service_type" => "0",
            "unit_type_text" => "Gold",
        ],
    ]);
}