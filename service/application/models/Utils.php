<?php

class Application_Model_Utils
{
    public function distance($lat1, $lng1, $lat2, $lng2, $miles = true)
    {
        $pi80 = M_PI / 180;
        $lat1 *= $pi80;
        $lng1 *= $pi80;
        $lat2 *= $pi80;
        $lng2 *= $pi80;

        $r = 6372.797; // mean radius of Earth in km
        $dlat = $lat2 - $lat1;
        $dlng = $lng2 - $lng1;
        $a = sin($dlat / 2) * sin($dlat / 2) + cos($lat1) * cos($lat2) * sin($dlng / 2) * sin($dlng / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $km = $r * $c;

        return ($miles ? ($km * 0.621371192) : $km);
    }
    
    
    public function getPoint($pointType){
        switch ($pointType) {
            case "tag":
                return 1;
            case "untag":
                return 1;
            case "agree":
                return 1;
            case "share":
                return 1;
            case "firsttag":
                return 2;
            case "firstuntag":
                return 2;
            case 'tagads':
                return 2;
            default:
                return 0;    
        }
    }
    
    public function sendMail($to,$header,$body){
        //Initialize needed variables
        $your_name = 'Venti Tag';
        $your_email = 'venti.tag.system@gmail.com'; 
        $your_password = 'trafficjam2012';
        $send_to_email = $to;

        //SMTP server configuration
        $smtpHost = 'smtp.gmail.com';
        $smtpConf = array(
        'auth' => 'login',
        'ssl' => 'ssl',
        'port' => '465',
        'username' => $your_email,
        'password' => $your_password
        );
        $transport = new Zend_Mail_Transport_Smtp($smtpHost, $smtpConf);

        //Create email
        $mail = new Zend_Mail();
        $mail->setFrom($your_email, $your_name);
        $mail->addTo($send_to_email, '');
        $mail->setSubject($header);
        $mail->setBodyText($body);

        //Send
        $sent = true;
        try {
            $mail->send($transport);
        }
        catch (Exception $e) {
            $sent = false;
        }

        //Return boolean indicating success or failure
        return $sent;
    }
}

