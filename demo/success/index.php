<?php

require '../../src/Payment.php';
require '../../src/Crypto.php';
require '../../src/Validator.php';


$obj = new \Paykun\Checkout\Payment('115803834838896', 'C4BE9F56F62C6023AC5357279851A710', '9CDDD77CA95F15C98E351A8E25EDA52D', false, true);
$response = $obj->getTransactionInfo($_REQUEST['payment-id']);

var_dump($response);
if(is_array($response) && !empty($response)) {

    if($response['status'] && $response['data']['transaction']['status'] == "Success") {
        echo "Transaction success";
    } else {
        echo "Transaction failed";
    }
}

?>