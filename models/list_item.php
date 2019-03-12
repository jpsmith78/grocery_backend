<?php
  $host = getenv('HOST')
  $dbconn = pg_connect("host=$host dbname=shopping_list");

  class ListItem {
    public $id;
    public $produce;
    public $meat;
    public $grocery;
    public function __construct($id, $produce, $meat, $grocery){
      $this->id = $id;
      $this->produce = $produce;
      $this->meat = $meat;
      $this->grocery = $grocery;
    }
  }

  class ListItems {
    static function all(){
      $listItems = array();

      $results = pg_query("SELECT * FROM list");

      $row_object = pg_fetch_object($results);
      while($row_object){
        $new_listItem = new ListItem(
            $row_object->id,
            $row_object->produce,
            $row_object->meat,
            $row_object->grocery
          );
          $listItems[] = $new_listItem;

          $row_object = pg_fetch_object($results);
      }

      return $listItems;



    }
  }




 ?>
