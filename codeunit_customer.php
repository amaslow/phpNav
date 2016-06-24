<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="is-IS">

    <head profile="http://gmpg.org/xfn/11">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

        <title>NAV Web Service via PHP</title>
    </head>
    <body>

        <?php
        require_once("ntlm/NTLMStream.php");
        require_once("ntlm/NTLMSoapClient.php");

        try {
            stream_wrapper_unregister('http');
            stream_wrapper_register('http', 'NTLMStream') or die("Failed to register protocol");
            
            $baseURL = 'http://172.16.54.17:7047/WS_SuperShift_LIVE/ws/Tristar-Europe B.V./Codeunit/SuperShift_WS';
            $client = new NTLMSoapClient($baseURL);
            $result = $client->GetCustomers(array(
                'customersOutput' => 'Customer'
            ));

            $product_item = $result->customersOutput->Customer;

            print "<pre>";
            print_r($product_item);
            print "</pre>";

            stream_wrapper_restore('http');
        } catch (SoapFault $exception) {
            echo $exception->getMessage();
        }
        ?>
    </body>
</html>

