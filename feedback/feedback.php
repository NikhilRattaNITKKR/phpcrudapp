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
<?php foreach($feedback as $item ): ?>
  <div class="card my-3 m-75 text-center">
   <div class="card-body">
    <form  action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST"> 
    <input type="hidden" name="delete_id" value="<?php echo $item['id']; ?>">
      <button type="submit"  class="btn btn-secondary btn-sm float-end">Delete</button>
</form>
<form  action="<?php echo 'index.php' ?>" method="POST"> 
    <input type="hidden" name="edit_id" value="<?php echo $item['id']; ?>">
    <input type="hidden" name="edit_name" value="<?php echo $item['name']; ?>">
    <input type="hidden" name="edit_email" value="<?php echo $item['email']; ?>">
    <input type="hidden" name="edit_phone" value="<?php echo $item['phone']; ?>">

    <!-- <input type="hidden" name="body1" value="<?php 
    // echo $item['body']; ?>"> -->
      <button type="submit"  class="btn btn-primary btn-sm float-end">Edit</button>
</form>
      <?php echo $item['body'] ?>
      <div class="mt-2 text-secondary">
         <?php echo 'By ' . $item['name'] . ' on ' . $item['date'] ?>
      </div>
   </div>
</div>

<?php endforeach; ?>
   

<table id="myTable" class="display" width="100%">
<thead>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Feedback</th>
                <th>TimeStamp</th>

            </tr>
        </thead>

 

</table>

<script>

var myvar = <?= json_encode($feedback); ?>;

console.log(myvar);

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
        { data: 'date' }
    ]
  });
} );

</script>

<?php include 'incl/footer.php' ?>
