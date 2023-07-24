
<?php include('../config/database.php');
 ?>

<?php 


function deleteFeedback($id,$conn){


     
    $sql="DELETE FROM feedback WHERE id='$id'";
    $result= mysqli_query( $conn, $sql);
    
    
    if (mysqli_query($conn, $sql)) {
        // Send a JSON response indicating success and redirect URL
        $response = array(
            "status" => "success",
            "redirect_url" => "feedback.php"
        );
        echo json_encode($response);
    } else {
        // Send a JSON respo nse indicating error
        $response = array(
            "status" => "error",
            "message" => "Error: " . mysqli_error($conn)
        );
        echo json_encode($response);
    }
    }


    deleteFeedback($_POST['id'],$conn);
?>
