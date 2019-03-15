<?php
  include_once __DIR__ . '/../models/list_item.php';
  // header("Access-Control-Allow-Origin: *");
  // header("Access-Control-Allow-Headers: Accept, Content-Type");
  // header("Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE, PUT");
  header('Content-Type: application/json');

  if($_REQUEST['action'] === 'index'){
    echo json_encode(ListItems::all());

  } else if ($_REQUEST['action'] === 'post'){
      $request_body = file_get_contents('php://input');
      $body_object = json_decode($request_body);
      $new_listItem = new ListItem(null, $body_object->item, $body_object->category, $body_object->price, $body_object->quantity, $body_object->unit, $body_object->in_refrigerator);
      $all_list_items = ListItems::create($new_listItem);
      echo json_encode($all_list_items);

  } else if ($_REQUEST['action'] === 'update'){
    $request_body = file_get_contents('php://input');
    $body_object = json_decode($request_body);
    $updated_item = new ListItem($_REQUEST['id'], $body_object->item, $body_object->category, $body_object->price, $body_object->quantity, $body_object->unit, $body_object->in_refrigerator);

    $all_list_items = ListItems::update($updated_item);

    echo json_encode($all_list_items);

  } else if ($_REQUEST['action'] === 'delete'){
    $all_list_items = ListItems::delete($_REQUEST['id']);
    echo json_encode($all_list_items);
  }



 ?>
