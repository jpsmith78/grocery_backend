<?php
  // require '../vendor/autoload.php';
  // $dotenv = Dotenv\Dotenv::create(__DIR__ . '/..');
  // $dotenv->load();
  $host = getenv('HOST');


  if(getenv(DATABASE_URL)) {
   $dbconn = pg_connect(getenv("DATABASE_URL"));
  } else {
  $dbconn = pg_connect("host=localhost dbname=shopping_list");
  }

  class FridgeItem {
    public $id;
    public $fridge_item;
    public $fridge_category;
    public $fridge_quantity;
    public $fridge_unit;
    public function __construct($id, $fridge_item, $fridge_category, $fridge_quantity, $fridge_unit){
      $this->id = $id;
      $this->fridge_item = $fridge_item;
      $this->fridge_category = $fridge_category;
      $this->fridge_quantity = $fridge_quantity;
      $this->fridge_unit = $fridge_unit;
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
          $row_object->fridge_item,
          $row_object->fridge_category,
          intval($row_object->fridge_quantity),
          $row_object->fridge_unit
        );
        $fridge_items[] = $new_fridge_item;

        $row_object = pg_fetch_object($results);
      }
      return $fridge_items;
    }

    static function create($fridge_item){
      $query = "INSERT INTO refrigerator (fridge_item, fridge_category, fridge_quantity, fridge_unit) VALUES ($1, $2, $3, $4)";

      $query_params = array($fridge_item->fridge_item, $fridge_item->fridge_category, $fridge_item->fridge_quantity, $fridge_item->fridge_unit);

      pg_query_params($query, $query_params);
      return self::all();
    }

    static function update($updated_fridge_item){
      $query = "UPDATE refrigerator SET item = $1, category = $2, quantity = $3, unit = $4 WHERE id = $5";

      $query_params = array($updated_fridge_item->fridge_item, $updated_fridge_item->fridge_category, $updated_fridge_item->fridge_quantity, $updated_fridge_item->fridge_unit, $updated_fridge_item->id);

      $result = pg_query_params($query, $query_params);

      return self::all();
    }

    static function delete($id){
      $query = "DELETE FROM refrigerator WHERE id = $1";
      $query_params = array($id);
      $result = pg_query_params($query, $query_params);

      return self::all();
    }

  }

 ?>
