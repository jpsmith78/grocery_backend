<?php
  $autoload = getenv('AUTOLOAD');
  if(getenv(AUTOLOAD)){
    require $autoload;
  } else {
    require '../vendor/autoload.php';
  }

  $dotenv = Dotenv\Dotenv::create(__DIR__ . '/..');
  $dotenv->load();
  $host = getenv('HOST');


  if(getenv(DATABASE_URL)) {
   $dbconn = pg_connect(getenv("DATABASE_URL"));
  } else {
  $dbconn = pg_connect("host=$host dbname=shopping_list");
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
    }
  }

  class ListItems {
    static function all(){
      $listItems = array();

      $results = pg_query("SELECT * FROM list");

      $row_object = pg_fetch_object($results);
      while($row_object){
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
