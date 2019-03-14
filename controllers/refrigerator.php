<?php
  include_once __DIR__ . '/../models/refrigerator_item.php';
  header('Content-Type: application/json');


  if($_REQUEST['action'] === 'index'){
    echo json_encode(FridgeItems::all());

  } else if ($_REQUEST['action'] === 'post'){
      $request_body = file_get_contents('php://input');
      $body_object = json_decode($request_body);

      $new_fridge_item = new FridgeItem(null, $body_object->item, $body_object->category, $body_object->quantity, $body_object->unit);

      $all_fridge_items = FridgeItems::create($new_fridge_item);

      echo json_encode($all_fridge_items);

  } else if ($_REQUEST['action'] === 'update'){
    $request_body = file_get_contents('php://input');
    $body_object = json_decode($request_body);

    $updated_fridge_item = new FridgeItem($_REQUEST['id'], $body_object->item, $body_object->category, $body_object->quantity, $body_object->unit);

    $all_fridge_items = FridgeItems::update($updated_fridge_item);
    echo json_encode($all_fridge_items);

  } else if ($_REQUEST['action'] === 'delete'){
    $all_fridge_items = FridgeItems::delete($_REQUEST['id']);
    echo json_encode($all_fridge_items);
  }



 ?>
