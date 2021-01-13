<?php

    function lang($phrase){
        static $lang = array(
            "Message" => "Hello Broo",
        );
        return $lang[$phrase];
    }

?>