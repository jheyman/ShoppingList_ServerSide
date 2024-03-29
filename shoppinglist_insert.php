<?php
   try {
    // Create (connect to) SQLite database in file
    $file_db = new PDO('sqlite:shoppinglist.sqlite3');

    // Set errormode to exceptions
    $file_db->setAttribute(PDO::ATTR_ERRMODE, 
                            PDO::ERRMODE_EXCEPTION);

    // Prepare INSERT statement to SQLite3 file db
    $insert = "INSERT INTO shoppinglist (item, quantity) 
                VALUES (:item, :quantity)";
    $stmt = $file_db->prepare($insert);

    // Bind parameters to statement variables
    $stmt->bindParam(':item', $item);
    $stmt->bindParam(':quantity', $quantity);

    // Set values to bound variables
    $item = $_REQUEST['newitem'];
    $quantity = "1";

    // Execute statement
    $stmt->execute();

    // echoing JSON response
    echo json_encode("insert OK");

    // Close file db connection
    $file_db = null;
  }
  catch(PDOException $e) {
    // Print PDOException message
    echo $e->getMessage();
  }
?>
