<?php include 'incl/header.php' ?>



<?php 



$sql='SELECT id,name, email , phone , body , date FROM feedback';
$result= mysqli_query($conn, $sql);
$feedback= mysqli_fetch_all($result,MYSQLI_ASSOC);

  
function deleteFeedback($id,$conn){

$sql="DELETE FROM feedback WHERE id='$id'";
$result= mysqli_query( $conn, $sql);


if(mysqli_query($conn,$sql)){
  $location= $_SERVER['PHP_SELF'];
  header("Location: $location");

}else {
  echo 'Error '. mysqli_error($conn);
}
}

  if(isset($_POST['delete_id'])){
  deleteFeedback($_POST['delete_id'],$conn);
}

?>


   
    <h2>Feedback</h2>
   

<table id="myTable" class="display" width="100%">
<thead>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Feedback</th>
                <th>TimeStamp</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>

 

</table>

<script>

var myvar = <?= json_encode($feedback); ?>;

console.log(myvar);

const deleteFeedback=(id)=>{
    $.ajax({
        type: 'POST',
        url: 'utils/deleteFeedback.php',
        data: { id : id },
        success: function (response) {

          response=JSON.parse(response);

          if (response.status == "success") {
                console.log('Successfully deleted');
                // Redirect to the specified URL
                window.location.href = response.redirect_url;
            } else {
                console.error('Error:', response);
            }
        },
        error: function (xhr, status, error) {
            console.error('Error:', error);
        }
      });
  }



$(document).ready( function () {


 


  new DataTable('#myTable',{
    ajax: 'calldata.php',
    "lengthMenu": [ 2,5,10,20,50 ],
    columns: [
        { data: 'id' },
        { data: 'name' },
        { data: 'email' },
        { data: 'phone' },
        { data: 'body' },
        { data: 'date' },
        { data: 'edit' },
        { data: 'delete' },
    ]
  });
} );

</script>

<?php include 'incl/footer.php' ?>
