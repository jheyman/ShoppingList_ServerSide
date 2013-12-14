<?php
 
  // Set default timezone
  date_default_timezone_set('UTC');
 
  try {
    /**************************************
    * Create databases and                *
    * open connections                    *
    **************************************/
 
    // Create (connect to) SQLite database in file
    $file_db = new PDO('sqlite:shoppinglist.sqlite3');
    // Set errormode to exceptions
    $file_db->setAttribute(PDO::ATTR_ERRMODE, 
                            PDO::ERRMODE_EXCEPTION);
 
    /**************************************
    * Create tables                       *
    **************************************/
/* 
    // Create table messages
//    $file_db->exec("CREATE TABLE IF NOT EXISTS shoppinglist (
 //                   item TEXT, 
  //                  quantity INTEGER)");
 
 
    // Array with some test data to insert to database             
    
$items = array(
                  array('item' => 'cornichons',
                        'quantity' => 1),
                  array('item' => 'salade',
                        'quantity' => 2),
                  array('item' => 'chocolat',
                        'quantity' => 5),
                  array('item' => 'sucre',
                        'quantity' => 3),
                  array('item' => 'oeufs',
                        'quantity' => 6),
                  array('item' => 'sac poubelle',
                        'quantity' => 1),
                  array('item' => 'savon',
                        'quantity' => 1),
                  array('item' => 'truc1',
                        'quantity' => 5),
                  array('item' => 'truc2',
                        'quantity' => 5),
                  array('item' => 'dernier truc',
                        'quantity' => 5),
                );
 
 
 
    // Prepare INSERT statement to SQLite3 file db
    $insert = "INSERT INTO shoppinglist (item, quantity) 
                VALUES (:item, :quantity)";
    $stmt = $file_db->prepare($insert);

    // Bind parameters to statement variables
    $stmt->bindParam(':item', $item);
    $stmt->bindParam(':quantity', $quantity);

    // Loop thru all messages and execute prepared insert statement
    foreach ($items as $i) {
      // Set values to bound variables
      $item = $i['item'];
      $quantity = $i['quantity'];
 
      // Execute statement
      $stmt->execute();
    }
*/
    // Select all data from file db messages table 
    $result = $file_db->query('SELECT * FROM shoppinglist');

     $rows = $result->fetchAll();
    
 if ($rows) {
    //$response["success"] = 1;
    //$response["message"] = "items available!";
    $response["items"]   = array();
    
    foreach ($rows as $row) {
        $item             = array();
        $item["item"] = $row["item"];
        $item["quantity"]    = $row["quantity"];
        
        
        //update our repsonse JSON data
        array_push($response["items"], $item);
    }
    
    // echoing JSON response
    echo json_encode($response);
}

//print(json_encode($result->fetchAll()));


// Need this next line  since doing multiple PDO operations in a single functions
// without this line, the next request on file_db results in error "SQLSTATE[HY000]: General error: 6 database table is locked"
unset($result); 
 
    /**************************************
    * Drop tables                         *
    **************************************/
 
    // Drop table messages from file db
    //$file_db->exec("DROP TABLE shoppinglist");
    // Drop table messages from memory db
   // $memory_db->exec("DROP TABLE messages");
 
 
    /**************************************
    * Close db connections                *
    **************************************/
 
    // Close file db connection
    $file_db = null;
    // Close memory db connection
    //$memory_db = null;
  }
  catch(PDOException $e) {
    // Print PDOException message
    echo $e->getMessage();
  }
?>
