<?php

class Validator
{
    function isEmpty($arr){
        foreach ($arr as $key=>$val){
            if(empty($val)) return ['status'=>true,"message"=>$key." is required"];
        }
        return ['status'=>false,"message"=>"valid"];
    }
    function allowed($str,$arr){
        if(!in_array($str,$arr)) return ['status'=>false,'message'=>"<div class='alert alert-danger'>Invalid selection ".$str."</div>"];
        return ['status'=>true,"message"=>'valid'];
    }
    function academicYear($strAcyear){
        $feed = ['status'=>true,"message"=>"valid"];
        if(count(preg_match('/[0-9]{4}-[0-9]{4}/', $strAcyear))>0){
            $acyearArr = explode(",",$strAcyear);
            if($acyearArr[0]>=2020) {
                if ($acyearArr[1] - $acyearArr[0] == 1) {
                    $feed = ['status' => true, "message" => "valid"];
                } else {
                    $feed = ['status' => false, "message" => "Academic year must have interval of 1 year eg: 2000-2001"];
                }
            }else{
                $feed = ['status'=>false,"message"=>"Academic starting year should be greater or equal to 2020,A year system has started being used"];
        }
        } else{
            $feed = ['status'=>false,"message"=>"Invalid Academic year shoud be in this format 2000-2001"];

        }

        return $feed;
    }
    function text($format, $str)
    {
        if ($format == 'lower') {
            return $this->lower($str);
        } elseif ($format == 'upper') {
            return $this->caps($str);
        } elseif ($format == 'number') {
            return $this->num($str);
        } elseif ($format == 'mixed') {
            return $this->mixed($str);
        } else {
            return "invalid format " . $format;
        }
    }//end text method

    public function phone($ctr, $num)
    {
        if ($ctr == 'rwandan') {
            return $this->rwandan($num);
        } elseif ($ctr == 'international') {
            return $this->international($num);
        }
    }//end phone method

    public function rwandanID($num)
    {
        if (preg_match("/^1 [0-9]{4} [7,8]{1} [0-9]{7} [0-9]{1} [0-9]{2}/", $num)) {
            $feed = 1;
        } else {
            $feed = 0;
        }
        return $feed;
    }

    public function email($str)
    {
///^(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){255,})(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){65,}@)(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22))(?:\\.(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\\]))$/i
        if (preg_match("/^(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){255,})(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){65,}@)(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22))(?:\\.(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\\]))$/i", $str)) {
            $feed = 1;
        } else {
            $feed = 0;
        }//end else for preg
        return $feed;
    }//end email method

    private function sessionManager($allowed, $redirect)
    {
        $arr = explode("/", $_SERVER['REQUEST_URI']);
        if (!isset($_SESSION[$allowed])) {
            header("location:" . $redirect);
//echo "<script>console.log('No Session Exist')</script>";
        } else {
//echo "<script>console.log('Session Exist')</script>";
        }
    }

#=============================PRIVATE FUNCTION TO EXECUTE FORMAT=========================
    private function lower($str)
    {
        if (preg_match("/^[a-z]+$/i", $str)) {
            $feed = 1;
        } else {
            $feed = 0;
        }//end else for preg
        return $feed;
    }//end method lower

    private function caps($str)
    {
        if (preg_match("/^[A-Z]+$/i", $str)) {
            $feed = 1;
        } else {
            $feed = 0;
        }//end else for preg
        return $feed;
    }//end caps method

    private function num($str)
    {
        if (preg_match("/^[0-9]+$/i", $str)) {
            $feed = 1;
        } else {
            $feed = 0;
        }//end else for preg
        return $feed;
    }//end num mehod

    private function mixed($str)
    {
        if (preg_match("/^[a-zA-Z0-9]+$/i", $str)) {
            $feed = 1;
        } else {
            $feed = 0;
        }//end else for preg
        return $feed;
    }//end mixed metohd

    private function rwandan($num)
    {
        if (is_numeric($num)) {
            if (strlen($num) == 12) {
                $feed = $this->rwandan12($num);
            } elseif (strlen($num) == 10) {
                $feed = $this->rwandan10($num);
            } else {
                $feed = "Rwandan phone number must be 10 or 12 digits";
            }
        }//end is numeric
        else {
            $feed = "Phone number must be always integer";
        }
        return $feed;
    }//end rwandan method

    private function rwandan12($num)
    {
        if (preg_match("/^2507[2,3,8][0-9]{7}/", $num)) {
            $feed = 1;
        } else {
            $feed = 0;
        }
        return $feed;

    }//end rwandan12 method

    private function rwandan10($num)
    {
        if (preg_match("/^(25)?07[2,3,8][0-9]{7}/", $num)) {
            $feed = 1;
        } else {
            $feed = 0;
        }
        return $feed;
    }//end rwandan10 method

    private function international($num)
    {
        if (preg_match("/^[0-9]{3}-[0-9]{3}-[0-9]{4}+$/i", $num)) {
            $feed = 1;
        } else {
            $feed = 0;
        }
        return $feed;
    }//end method international
}//end class validate
?>