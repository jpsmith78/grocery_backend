<?php
  include_once __DIR__ . '/../models/refrigerator_item.php';
  header('Content-Type: application/json');


  if($_REQUEST['action'] === 'index'){
    echo json_encode(FridgeItems::all());
  }



 ?>
