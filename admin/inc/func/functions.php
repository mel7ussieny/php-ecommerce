<?php
  /*
    ***********
    ****** FUNCTION THE TITLE OF PAGE
    ***********
  */


  function getTitle(){
    global $title;
    $title = isset($title) ? $title : "Default";
    echo $title;
  }
  /*
    ***********
    ****** Redirect Page [MSG, SECOND, TO PAGE]
    ***********
  */
  function redirectPage($msg, $second = 2,$toPage){
    echo $msg;
    echo "<div class='alert alert-info col-sm-5 mr-auto ml-auto mt-3'>You Will Redirect After $second Second</div>";
    if(isset($_SERVER['HTTP_REFERER'])){
      if($toPage == "back"){
        $toPage = $_SERVER['HTTP_REFERER'];
      }
      echo 1;
    }else{
      if($toPage == "back"){
        $toPage = "index.php";
      }
    }
    // echo $toPage;
    header("refresh:$second; url=$toPage");
  }
  /*
    ***********
    ****** Redirect Page [!MSG , TO PAGE , SECOND]
    ***********
  */
  function redirectMsg($second = 3,$toPage){
    echo "<div class='alert alert-info col-sm-5 mr-auto ml-auto mt-3'>You Will Redirect After $second Second</div>";
    $toPage = $toPage == "back" ? $_SERVER["HTTP_REFERER"] : $toPage;
    header("refresh:$second; url=$toPage");
  }

  /*
    ***********
    ****** Check The Item Exists In DATABASE
    ***********
  */

  function checkItem($select , $from , $value){
    global $connect;
    $statment = $connect->prepare("SELECT $select FROM $from WHERE $select = ?");
    $statment->execute(array($value));
    $count = $statment->rowCount();

    return $count;
  }


    /*
    ***********
    ****** Check The Item Exists In DATABASE TO EDIT 
    ***********
  */

  function checkItem_Edit($select , $from , $value,$select2,$value2){
    global $connect;
    $statment = $connect->prepare("SELECT $select FROM $from WHERE $select = ? && $select2 != ?");
    $statment->execute(array($value,$value2));
    $count = $statment->rowCount();

    return $count;
  }

  /*
    ***********
    ****** Get Count Elements In Coloumn
    ***********
  */


  function getCount($col,$tbl,$condition = 1){
    global $connect;
    $statment = $connect->prepare("SELECT COUNT($col) FROM $tbl WHERE $condition");
    $statment->execute();

    echo $statment->fetchColumn();

  }

  /*
    *************
    ***** GET LATEST ACTIVITY
    *************
  */

  function getLatest($select,$tbl,$order,$limit = 5){
    global $connect;
    $statment = $connect->prepare("SELECT $select FROM $tbl ORDER BY $order DESC LIMIT $limit");
    $statment->execute();
    $row = $statment->fetchAll();

    return $row;
  }


?>
