<?php

include 'db_connect.php';

// Check if ID exists in URL
if(isset($_GET['id'])){

    // Get user ID
    $id = $_GET['id'];

    // Delete user by ID
    $query = "DELETE FROM users WHERE id='$id'";
    $query_run = mysqli_query($conn, $query);

    // If delete is successful
    if($query_run){
        $_SESSION['status'] = "Data Deleted Successfully";
        header('location: ../pages/admin/users.php');  
    }
    else {
        // If delete fails
        $_SESSION['status'] = "Deletion failed";
        header('location: ../pages/admin/users.php'); 
    }    
}

?>