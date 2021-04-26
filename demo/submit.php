<?php

require '../src/Payment.php';
require '../src/Validator.php';
require '../src/Crypto.php';

// product
$posted["product_name"] = $_GET["product"];
$product_name   = $posted['product_name'];

// firstname
$posted["full_name"] = $_GET["name"];
$fname          = $posted['full_name'];

// mobile number
$posted["contact"] = $_GET["contact"];
$contact        = $posted['contact'];

// amount
$posted["amount"] = $_GET["amount"];
$amount         = $posted['amount'];

// email
$posted["email"] = $_GET["email"];
$email          = $posted['email'];







/**
 *  Parameters requires to initialize an object of Payment are as follow.
 *  mid => Merchant Id provided by Paykun
 *  accessToken => Access Token provided by Paykun
 *  encKey =>  Encryption provided by Paykun
 *  isLive => Set true for production environment and false for sandbox or testing mode
 *  isCustomTemplate => Set true for non composer projects, will disable twig template
 */

$obj = new \Paykun\Checkout\Payment('115803834838896', 'C4BE9F56F62C6023AC5357279851A710', '9CDDD77CA95F15C98E351A8E25EDA52D', false, true);

$successUrl = str_replace("request.php", "success", $_SERVER['HTTP_REFERER']);
$failUrl 	= str_replace("request.php", "failed", $_SERVER['HTTP_REFERER']);

// Initializing Order
$obj->initOrder(generateByMicrotime(), $product_name,  $amount, $successUrl,  $failUrl, 'INR');

// Add Customer
$obj->addCustomer($fname, $email, $contact);


//Enable if require custom fields
$obj->setCustomFields(array('udf_1' => 'Some Dummy text'));
//Render template and submit the form
echo $obj->submit();

/* Check for transaction status
 * Once your success or failed url called then create an instance of Payment same as above and then call getTransactionInfo like below
 *  $obj = new Payment('merchantUId', 'accessToken', 'encryptionKey', true, true); //Second last false if sandbox mode
 *  $transactionData = $obj->getTransactionInfo(Get payment-id from the success or failed url);
 *  Process $transactionData as per your requirement
 *
 * */


function generateByMicrotime() {
    $microtime = str_replace('.', '', microtime(true));
    return (substr($microtime, 0, 14));
}
?>