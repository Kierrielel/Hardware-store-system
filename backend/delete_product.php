<?php 
include 'db_connect.php';

/*
---------------------------------------------------
CHECK IF PRODUCT ID EXISTS
---------------------------------------------------
This checks if an ID was passed in the URL.

Example:
delete_product.php?id=5

If an ID exists, the deletion process starts.
*/
if(isset($_GET['id'])){

    // Get the product ID from the URL.
    // Example: id=5
    $id = $_GET['id'];

    /*
    ---------------------------------------------------
    DELETE PRODUCT QUERY
    ---------------------------------------------------
    This SQL query deletes a product from
    the products table using its ID.

    WHERE id='$id' ensures that only the
    selected product gets deleted.
    */
    $query = "DELETE FROM products WHERE id='$id'";

    // Execute the delete query in the database.
    $query_run = mysqli_query($conn, $query);

    /*
    ---------------------------------------------------
    CHECK IF DELETION WAS SUCCESSFUL
    ---------------------------------------------------
    If the query works:
    - Save a success message in session
    - Redirect back to inventory page
    */
    if($query_run){

        // Store success message in session.
        $_SESSION['status'] = "Data Deleted Successfully";

        // Redirect to inventory page with success message.
        header('location: ../pages/admin/inventory.php?success=deleted');  
    }
    else {

        /*
        ---------------------------------------------------
        IF DELETION FAILED
        ---------------------------------------------------
        If something went wrong:
        - Save an error message in session
        - Redirect back with an error
        */

        // Store failure message in session.
        $_SESSION['status'] = "Deletion failed";

        // Redirect to inventory page with error message.
        header('location: ../pages/admin/inventory.php?error=failed_to_delete'); 
    }    
}

?>