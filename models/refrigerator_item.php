<?php
  require '../vendor/autoload.php';
  $dotenv = Dotenv\Dotenv::create(__DIR__ . '/..');
  $dotenv->load();
  $host = getenv('HOST');

  $dbconn = pg_connect("host=$host dbname=shopping_list");

  class FridgeItem {
    public $id;
    public $item;
    public $category;
    public $quantity;
    public $unit;
    public function __construct($id, $item, $category, $quantity, $unit){
      $this->id = $id;
      $this->item = $item;
      $this->category = $category;
      $this->quantity = $quantity;
      $this->unit = $unit;
    }
  }

  class FridgeItems {
    static function all(){
      $fridge_items = array();

      $results = pg_query("SELECT * FROM refrigerator");
      $row_object = pg_fetch_object($results);
      while($row_object){
        $new_fridge_item = new FridgeItem(
          intval($row_object->id),
          $row_object->item,
          $row_object->category,
          intval($row_object->quantity),
          $row_object->unit
        );
        $fridge_items[] = $new_fridge_item;

        $row_object = pg_fetch_object($results);
      }
      return $fridge_items;
    }

    static function create($fridge_item){
      $query = "INSERT INTO refrigerator (item, category, quantity, unit) VALUES ($1, $2, $3, $4)";

      $query_params = array($fridge_item->item, $fridge_item->category, $fridge_item->quantity, $fridge_item->unit);

      pg_query_params($query, $query_params);
      return self::all();
    }
  }

 ?>
