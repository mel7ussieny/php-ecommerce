<?php

    function lang($phrase){
        static $lang = array(
// Navbar
            "Nav-Cat"   => "Categories",
            "Nav-Itm"   => "Items",
            "Nav-Mem"   => "Members",
            "Nav-Stat"  => "Statistics",
            "Nav-Log"   => "Logs",
            "Nav-Com"   => "Comments",
// Dropdown Navbar
            "Drop-Ed"   => "Edit Profile",
            "Drop-Set"  => "Settings",
            "Drop-Log"  => "Logout",
        );
        return $lang[$phrase];
    }

?>
