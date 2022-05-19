<?php

    // รูปแบบวัน : วัน/เดือน/ปี : EX. 01/01/2020
    function formatdate($date){
        $newdate = date("d/m/Y",strtotime($date));
        return $newdate;
    }

    // รูปแบบวัน : ปี/เดือน/วัน : Ex. 2020/01/01
    function formatdatedefault($date){
        $formatdate=str_replace('/','-',$date);
        $newdate = date("Y-m-d",strtotime($formatdate));
        return $newdate;
    }

    // รูปแบบวัน : อังฤษ : Ex. 01 January 2020
    function DateEng($strDate){
        $strYear 	  = date("Y",strtotime($strDate));
        $strMonth	  = date("n",strtotime($strDate));
        $strDay		  = date("j",strtotime($strDate));
        $strMonthCut  = array("","January","February","March","April","May","June","July","August","September","October","November","December");
        $strMonthThai = $strMonthCut[$strMonth];
        return "$strDay $strMonthThai $strYear";
    }				

    // รูปแบบวัน : ไทย : Ex. 01 มกราคม 2563
    function DateThai($strDate){
        $strYear 	  = date("Y",strtotime($strDate))+543;
        $strMonth	  = date("n",strtotime($strDate));
        $strDay		  = date("j",strtotime($strDate));
        $strMonthCut  = array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
        $strMonthThai = $strMonthCut[$strMonth];
        return "$strDay $strMonthThai $strYear";
    }	
    
    // รูปแบบวัน : ไทยตัวเลข : Ex. 15 01 2563
    function DateThaiNum($strDate){
        $strYear 	  = date("Y",strtotime($strDate))+543;
        $strMonth	  = date("n",strtotime($strDate));
        $strDay		  = date("j",strtotime($strDate));
        $strMonthCut  = array("","01","02","03","04","05","06","07","08","09","10","11","12");
        $strMonthThai = $strMonthCut[$strMonth];
        return "$strDay/$strMonthThai/$strYear";
    }	


?>