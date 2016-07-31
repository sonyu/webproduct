<?php
/*
 * lay ngay danh int
 * $time : int thoi gian hien thi
 * $fun_time = lieu muon lay 
 */
function get_date($time, $full_time = true){
    $format = '%d - %m - %y';
    if($full_time){
        $format=$format.' - %h:%i:%s';
    }
    $date = mdate($format,$time);
    return $date;
}
function convet_timestamp($time){
    $time = date('Y-m-d H:i:s',$time);
    return $time;
}