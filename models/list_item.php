<?php

  include_once __DIR__ . '/refrigerator_item.php';
  // require '../vendor/autoload.php';
  // $dotenv = Dotenv\Dotenv::create(__DIR__ . '/..');
  // $dotenv->load();
  $host = getenv('HOST');


  if(getenv(DATABASE_URL)) {
   $dbconn = pg_connect(getenv("DATABASE_URL"));
  } else {
  $dbconn = pg_connect("host=localhost dbname=shopping_list");
  }


  class ListItem {
    public $id;
    public $item;
    public $category;
    public $price;
    public $quantity;
    public $unit;
    public $in_refrigerator;
    public function __construct($id, $item, $category, $price, $quantity, $unit, $in_refrigerator){
      $this->id = $id;
      $this->item = $item;
      $this->category = $category;
      $this->price = $price;
      $this->quantity = $quantity;
      $this->unit = $unit;
      $this->in_refrigerator = $in_refrigerator;
      $this->have_at_home = [];
    }
  }

  class ListItems {
    static function all(){
      $listItems = array();

      $results = pg_query("SELECT
          list.*,
          refrigerator.id AS fridge_id,
          refrigerator.fridge_item, refrigerator.fridge_category, refrigerator.fridge_quantity, refrigerator.fridge_unit
        FROM list
        LEFT JOIN refrigerator
          ON list.item = refrigerator.fridge_item
        AND list.category = refrigerator.fridge_category
        ORDER BY list.id ASC;");

      $row_object = pg_fetch_object($results);
      $last_item_id = null;

      while($row_object){
        if($row_object->id !== $last_item_id){
          $new_listItem = new ListItem(
              intval($row_object->id),
              $row_object->item,
              $row_object->category,
              $row_object->price,
              intval($row_object->quantity),
              $row_object->unit,
              $row_object->in_refrigerator
            );
            $listItems[] = $new_listItem;
            $last_item_id = $row_object->id;
        }
        if($row_object->fridge_id){
          $new_fridge_item = new FridgeItem(
              intval($row_object->fridge_id),
              $row_object->fridge_item,
              $row_object->fridge_category,
              intval($row_object->fridge_quantity),
              $row_object->fridge_unit
            );
            $list_length = count($listItems);
            $last_index_of_list = $list_length-1;

            $most_recently_added_list = $listItems[$last_index_of_list];

            $most_recently_added_list->have_at_home[] = $new_fridge_item;
        }



          $row_object = pg_fetch_object($results);
      }
      return $listItems;
    }

    static function create($newItem){
      $query = "INSERT INTO list (item, category, price, quantity, unit) VALUES ($1, $2, $3, $4, $5)";
      $query_params = array($newItem->item, $newItem->category, $newItem->price, $newItem->quantity, $newItem->unit);
      pg_query_params($query, $query_params);
      return self::all();
    }

    static function update($updated_item){
      $query = "UPDATE list SET item = $1, category = $2, price = $3, quantity = $4, unit = $5, in_refrigerator = $6 WHERE id = $7";

      $query_params = array($updated_item->item, $updated_item->category, $updated_item->price, $updated_item->quantity, $updated_item->unit, $updated_item->in_refrigerator, $updated_item->id);

      $result = pg_query_params($query, $query_params);

      return self::all();
    }

    static function delete($id){
      $query = "DELETE FROM list WHERE id = $1";
      $query_params = array($id);
      $result = pg_query_params($query, $query_params);

      return self::all();
    }

  }




 ?>
