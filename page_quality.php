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

            $baseURL = 'http://172.16.54.17:7047/WS_SuperShift_LIVE/ws/Tristar-Europe B.V./Page/Items_QC?wsdl';

            $client = new NTLMSoapClient($baseURL);
            ?>    
            <form name= "form" action = "" method="POST">
                Product: <input type = "text" name = "ItemNo" id="ItemNo" value="">
            </form>
            <?php
            $result = $client->Read(array(
                'Item_No' => $_POST['ItemNo']
            ));
            if (is_soap_fault($result)) {
                trigger_error("SOAP Fault: (faultcode: {$result->faultcode}, faultstring: {$result->faultstring})", E_USER_ERROR);
            }
            $product_item = $result->Items_QC->Item_No;
            $product_desc1 = $result->Items_QC->Directives_2014_30_EU_EMC_1;
            $product_desc2 = $result->Items_QC->Directives_2014_30_EU_EMC_2;

//            echo $product_info->USP;
            print "<pre>";
            print_r($result);
            //print_r($product_item . ' , ' . $product_desc1 . ' , ' . $product_desc2);
            print "</pre>";

            stream_wrapper_restore('http');
        } catch (SoapFault $exception) {
            echo $exception->getMessage();
        }
        ?>

    </body>
</html>