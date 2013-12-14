<?php
  try {
    // Create (connect to) SQLite database in file
    $file_db = new PDO('sqlite:shoppinglist.sqlite3');

    // Set errormode to exceptions
    $file_db->setAttribute(PDO::ATTR_ERRMODE, 
                            PDO::ERRMODE_EXCEPTION);

    // Prepare DELETE statement to SQLite3 file db
     if($_REQUEST["whereClause"] == "*") {
        $delete = "DELETE FROM shoppinglist";
     }
     else {

	$tmp = SQLite3::escapeString($_REQUEST["whereClause"]);
	$delete = "DELETE FROM shoppinglist WHERE item='".$tmp."'";
     }

    $stmt = $file_db->prepare($delete);

    // Execute statement
    $stmt->execute();

    // Select all data from file db messages table 
    $result = $file_db->query('SELECT * FROM shoppinglist');

     $rows = $result->fetchAll();

    if ($rows) {
      $response["items"]   = array();

      foreach ($rows as $row) {
        $item             = array();
        $item["item"] = $row["item"];
        $item["quantity"]    = $row["quantity"];

        //update our repsonse JSON data
        array_push($response["items"], $item);
    }

    echo json_encode($delete);
}

    // Need this next line  since doing multiple PDO operations in a single functions
    // without this line, the next request on file_db results in error "SQLSTATE[HY000]: General error: 6 database table is locked"
    unset($result); 
 
    // Close file db connection
    $file_db = null;
  }
  catch(PDOException $e) {
    // Print PDOException message
    echo $e->getMessage();
  }
?>
