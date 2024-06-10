<?php
    session_start();

    // Local test
    $API_Link = "https://127.0.0.1:7104/";

    // Production
    // $API_Link = "https://ecmapi.boonsiri.co.th/";

    date_default_timezone_set("Asia/Bangkok");

    // Full Thai Date
    function thai_date($strDate, $time) {
        $strYear = date("Y", strtotime($strDate)) + 543;
        $strMonth = date("n", strtotime($strDate));
        $strDay = date("j", strtotime($strDate));
        $strHour = date("H", strtotime($strDate));
        $strMinute = date("i", strtotime($strDate));
        $strSeconds = date("s", strtotime($strDate));
        $strMonthCut = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
        $strMonthThai = $strMonthCut[$strMonth];

        if ($time) {
            return "$strDay $strMonthThai $strYear เวลา $strHour:$strMinute:$strSeconds";
        } else {
            return "$strDay $strMonthThai $strYear";
        }
    }

    function redirect($path) {
        header("Location: $path");
    }

    function convertToURLFriendly($inputString) {
        // Convert string to lowercase
        $urlFriendly = strtolower($inputString);
    
        // Remove special characters and replace spaces with hyphens
        $urlFriendly = preg_replace('/[^a-z0-9\-]/', '', $urlFriendly);
        $urlFriendly = preg_replace('/-+/', '-', $urlFriendly);
        
        // Trim hyphens from the beginning and end
        $urlFriendly = trim($urlFriendly, '-');
        
        return $urlFriendly;
    }

    // function time_ago($lang, $timestamp) {
    //     $timestamp = strtotime($timestamp);

    //     $currentTime = time();
    //     $timeDiff = $currentTime - $timestamp;
    
    //     if ($lang == "en") {
    //         $intervals = array(
    //             1 => array('second', 'seconds'),
    //             60 => array('minute', 'minutes'),
    //             3600 => array('hour', 'hours'),
    //             86400 => array('day', 'days'),
    //             604800 => array('week', 'weeks'),
    //             2592000 => array('month', 'months'),
    //             31536000 => array('year', 'years')
    //         );
        
    //         foreach ($intervals as $seconds => $names) {
    //             $count = floor($timeDiff / $seconds);
    //             if ($count > 0) {
    //                 if ($count === 1) {
    //                     $timeAgo = $count . ' ' . $names[0] . ' ago';
    //                 } else {
    //                     $timeAgo = $count . ' ' . $names[1] . ' ago';
    //                 }
    //                 break;
    //             }
    //         }
        
    //         return isset($timeAgo) ? $timeAgo : 'just now';
    //     } else {
    //         $intervals = array(
    //             1 => array('วินาที', 'วินาที'),
    //             60 => array('นาที', 'นาที'),
    //             3600 => array('ชั่วโมง', 'ชั่วโมง'),
    //             86400 => array('วัน', 'วัน'),
    //             604800 => array('สัปดาห์', 'สัปดาห์'),
    //             2592000 => array('เดือน', 'เดือน'),
    //             31536000 => array('ปี', 'ปี')
    //         );
        
    //         foreach ($intervals as $seconds => $names) {
    //             $count = floor($timeDiff / $seconds);
    //             if ($count > 0) {
    //                 if ($count === 1) {
    //                     $timeAgo = $count . ' ' . $names[0] . ' ที่แล้ว';
    //                 } else {
    //                     $timeAgo = $count . ' ' . $names[1] . ' ที่แล้ว';
    //                 }
    //                 break;
    //             }
    //         }
        
    //         return isset($timeAgo) ? $timeAgo : 'เมื่อสักครู่นี้';
    //     }
    // }

    function time_ago($lang, $datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        if ($lang == "EN") {
            $string = array(
                'y' => 'Years',
                'm' => 'Months',
                'w' => 'Weeks',
                'd' => 'Days',
                'h' => 'Hours',
                'i' => 'Minutes',
                's' => 'Seconds',
            );
            $ago = "ago";
            $justnow = "Just now";
        } elseif ($lang == "TH") {
            $string = array(
                'y' => 'ปี',
                'm' => 'เดือน',
                'w' => 'สัปดาห์',
                'd' => 'วัน',
                'h' => 'ชั่วโมง',
                'i' => 'นาที',
                's' => 'วินาที',
            );
            $ago = "ที่แล้ว";
            $justnow = "เมื่อสักครู่นี้";

        } else {
            $string = array(
                'y' => 'ปี',
                'm' => 'เดือน',
                'w' => 'สัปดาห์',
                'd' => 'วัน',
                'h' => 'ชั่วโมง',
                'i' => 'นาที',
                's' => 'วินาที',
            );
            $ago = "ที่แล้ว";
            $justnow = "เมื่อสักครู่นี้";
        }

        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? '' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) {
            $string = array_slice($string, 0, 1);
        }

        return $string ? implode(', ', $string) . ' ' . $ago : $justnow;
    }

    function thai_month($month) {
        $strMonthCut = array("", "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤษจิกายน", "ธันวาคม");
        return $strMonthCut[$month];
    }

    function rootURL($dir = __DIR__) {

        $root = "";
        $dir = str_replace('\\', '/', realpath($dir));

        //HTTPS or HTTP
        $root .= !empty($_SERVER['HTTPS']) ? 'https' : 'http';

        //HOST
        $root .= '://' . $_SERVER['HTTP_HOST'];

        //ALIAS
        if (!empty($_SERVER['CONTEXT_PREFIX'])) {
            $root .= $_SERVER['CONTEXT_PREFIX'];
            $root .= substr($dir, strlen($_SERVER['CONTEXT_DOCUMENT_ROOT']));
        } else {
            $root .= substr($dir, strlen($_SERVER['DOCUMENT_ROOT']));
        }

        $root .= '/';

        $path = explode("/", $root);

        return $path[0] . "//" . $path[2] . "/" . $path[3];
    }

    function actualURL() {
        $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        return $url;
    }

    function check_login() {
        if ($_SESSION['id']) {
            echo "success";
        } else {
            echo "failed";
        }
    }

    function connect_api($url, $data = "") {
        // Convert the data to JSON format
        // if ($data == "") {
        //     $data = [
        //         "data" => 0
        //     ];
        // }

        // $jsonData = json_encode($data);

        // $curl = curl_init($url);
        
        // // Set cURL options
        // curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        // curl_setopt($curl, CURLOPT_HTTPHEADER, [
        //     'Content-Type: application/json',
        //     'Content-Length: ' . strlen($jsonData)
        // ]);

        // curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        // curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonData);
        
        // $response = curl_exec($curl);
        
        // if (curl_errno($curl)) {
        //     echo "Error: " . curl_error($curl);
        // }
        
        // curl_close($curl);
        
        // return json_decode($response, true);

        echo $url;
    }