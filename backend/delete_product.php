<?php 
include 'db_connect.php';

// Check if ID is in URL
if(isset($_GET['id'])){

    // Get ID
    $id = $_GET['id'];

    // Delete product by ID
    $query = "DELETE FROM products WHERE id='$id'";
    $query_run = mysqli_query($conn, $query);

    // If delete is successful
    if($query_run){
        $_SESSION['status'] = "Data Deleted Successfully";
        header('location: ../pages/admin/inventory.php?success=deleted');  
    }
    else {
        // If delete fails
        $_SESSION['status'] = "Deletion failed";
        header('location: ../pages/admin/inventory.php?error=failed_to_delete'); 
    }    
}
?>