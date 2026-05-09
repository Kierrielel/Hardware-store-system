<?php

include 'db_connect.php';

/*
---------------------------------------------------
CHECK IF USER ID EXISTS
---------------------------------------------------
This checks if an ID was passed through the URL.

Example:
delete_user.php?id=3

If an ID exists, the system will try
to delete that specific user.
*/
if(isset($_GET['id'])){

    // Get the user ID from the URL.
    // Example: id=3
    $id = $_GET['id'];

    /*
    ---------------------------------------------------
    DELETE USER QUERY
    ---------------------------------------------------
    This SQL query deletes a user from
    the users table using the given ID.

    WHERE id='$id' ensures only the selected
    user account will be deleted.
    */
    $query = "DELETE FROM users WHERE id='$id'";

    // Execute the delete query.
    $query_run = mysqli_query($conn, $query);

    /*
    ---------------------------------------------------
    CHECK IF DELETION WAS SUCCESSFUL
    ---------------------------------------------------
    If the query runs successfully:
    - Save a success message in session
    - Redirect back to users page
    */
    if($query_run){

        // Store success message in session.
        $_SESSION['status'] = "Data Deleted Successfully";

        // Redirect back to users page.
        header('location: ../pages/admin/users.php');  
    }
    else {

        /*
        ---------------------------------------------------
        IF DELETION FAILED
        ---------------------------------------------------
        If something goes wrong:
        - Save an error message
        - Redirect back to users page
        */

        // Store failure message in session.
        $_SESSION['status'] = "Deletion failed";

        // Redirect back to users page.
        header('location: ../pages/admin/users.php'); 
    }    
}

?>