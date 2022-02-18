<?php

/*function findMonthsActive($route){
    // assumes uid and tid
    $sql = 'SELECT * FROM members
        WHERE uid = :uid AND  tid = :tid
        LIMIT 1';
    $data = [
        'uid' => $route->uid,
        'tid'=> $route->tid,
    ];
   $member = sqlReturnObjectOne($sql, $data);
   $year_start = strtotime( $route->year . '-01-01');
   $member_start= $member->date_started;
   if ($year_start > $member_start){
      $report_start = 1;
   }
   else{
       while ()
   }


}