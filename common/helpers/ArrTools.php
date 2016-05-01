<?php
namespace common\helpers;

class ArrTools{

    public static  function sortDataByPosition( $data  ){
        usort($data, function ($a, $b) {
           if ($a['position'] == $b['position']) {
               return 0;
           }

           return ($a['position'] < $b['position']) ? -1 : 1;
        });

        return $data;
    }

    public static  function P( $data  ){
		echo "<pre>";
		print_r( $data  );
		echo "</pre>";
	}

}
