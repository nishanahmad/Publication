<?php
function sendSMS($mobilenumber,$name,$receipt_number)
{
        $user="upnknr";
        $password="upn12345";
        $message = "Dear AR,We have Transferred your available".$receipt_number." to your plus points upto ".$name.". now u have ".$name."-AR HELP";
        $senderid="ACCHLP";
        $url="http://sapteleservices.in/SMS_API/sendsms.php";
        $message = urlencode($message);
        $ch = curl_init();
        if (!$ch)
                die("Couldn't initialize a cURL handle");

        $ret = curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt ($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt ($ch, CURLOPT_POSTFIELDS,"username=$user&password=$password&mobile=$mobilenumber&message=$message&sendername=$senderid&routetype=1");
        $ret = curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $curlresponse = curl_exec($ch);
        if(curl_errno($ch))
                echo 'curl error : '. curl_error($ch);
        if (empty($ret))
        {
                // some kind of an error happened
                die(curl_error($ch));
                curl_close($ch);
        }
        else
        {
                $info = curl_getinfo($ch);
                curl_close($ch);
                echo $curlresponse;
                echo "Message Sent Succesfully" ;
        }
}
?>
