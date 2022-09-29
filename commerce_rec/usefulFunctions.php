<?php
function findminmax($arr){
$min = 0;
$max = 0;
    foreach($arr as $i){
        foreach($arr as $j)
        {
            if($i>$max){
                $max = $i;
            }
            if($i < $min){
                $min = $i;
            }
        }
    }
    echo "min ". $min;
    echo "max ". $max;
    
}
// $arr  = [3,010,2,-1];

// findminmax($arr);

