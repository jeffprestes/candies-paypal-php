<?php
session_start();

// #Execute Payment Sample
// This sample shows how you can complete
// a payment that has been approved by
// the buyer by logging into paypal site.
// You can optionally update transaction
// information by passing in one or more transactions.
// API used: POST '/v1/payments/payment/<payment-id>/execute'.

require 'bootstrap.php';
require 'spMQTT.class.php';

use PayPal\Api\ExecutePayment;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;

$mock = 0;

if ($mock != '1')   {

    if (isset($_GET['success']) && $_GET['success'] == 'true') {
        
        $response = "";
        $error = "";

        // Get the payment Object by passing paymentId
        // payment id was previously stored in session in
        // CreatePaymentUsingPayPal.php
        $paymentId = $_GET['paymentId'];
        $payment = Payment::get($paymentId, $apiContext);

        // PaymentExecution object includes information necessary
        // to execute a PayPal account payment.
        // The payer_id is added to the request query parameters
        // when the user is redirected from paypal back to your site
        $execution = new PaymentExecution();
        $execution->setPayerId($_GET['PayerID']);
        //Execute the payment
        // (See bootstrap.php for more on `ApiContext`)
        $result = $payment->execute($execution, $apiContext);

        if ($result->getState()=="approved")    {


            $mqtt = new spMQTT('tcp://iot.eclipse.org:1883/');
            spMQTTDebug::Disable();

            $connected = $mqtt->connect();
            if (!$connected) {
                die("It was not possible connect to Candy Machine. Please try again.\n");
            }

            $mqtt->ping();

            $msg = "release";

            # mosquitto_sub -t 'sskaje/#'  -q 1 -h test.mosquitto.org
            $retorno = $mqtt->publish($_SESSION['location'], $msg, 0, 2, 0, 1);

            if ($retorno['ret']>0)    {
                $response = "{status: success!}";
            }   else    {
                $error = "It was not possible connect to Candy Machine. Please try again.";
            }

        } else {
            $error = "Payment was not approved";
        }
    } else {
        $error = "User cancelled the payment. It's a pity".
        $response = "";
    }
    
}   else    {
    //$response = "{status: success!}";
    //$error = "";
    //$error = "User cancelled the payment. It's a pity".
    //$response = "";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <title>Candies</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link href='https://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
    <style type="text/css">
        div   {
            position:  absolute;
            top: 50%;
            left: 50%;
            text-align: center;
            display: none;
        }

        #splash {
            margin-left: -75px;
            margin-top: -170px;
        }

        #form   {
            margin-left: -75px;
            margin-top: -200px;
        }

        #btn {
            border: none;
            background: url('https://www.paypalobjects.com/webstatic/en_US/btn/btn_buynow_pp_142x27.png') no-repeat top left;
            padding: 2px 8px;
            width: 142px;
            height: 27px;
        }

        #message    {
            font-family: 'Lobster', cursive;
            font-size: x-large;
            font-color: brown;
        }
    </style>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script type="text/javascript">
        function stringify() {
            var response = "<?=$response?>";
            var error = "<?=$error?>";

            $('#splash').hide();
            $('#failed').hide();
            //alert(response);
            //alert(response == "{status: success!}")
            if (response != "" && response == "{status: success!}") {
                $('#splash').show();
            } else if (error != "") {
                $('#splash').hide();
                $('#errormessage').html("<strong>" + response + "<br />" + error + "</strong>");
                $('#failed').show();
            }
        }
    </script>
</head>
<body onload="stringify()">
    <div id="splash">
        <img src='https://openclipart.org/image/300px/svg_to_png/173135/Happy_Tiger.png'>
        <br />
        <br />
        <span id="message">Take your candies!</span>

        <br />
        <br/>
	<a href="index.php">Buy again</a>
    </div>
    <div id="failed">
        <span id="errormessage">&nbsp;</span>
        <br />
        <br />
	<a href="index.html">Buy it again</a>
    </div>
</body>
</html>


