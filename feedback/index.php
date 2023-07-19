<?php include 'incl/header.php' ?>

<?php 

$name='';
$email='';
$body='';

$nameErr='';
$emailErr='';
$bodyErr='';
$phoneErr='';




if(isset($_POST['submit'])){

if(empty($_POST['name'])){
  $nameErr='NAME IS REQUIRED';
}else{

  $name=filter_input(INPUT_POST,'name',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
}

if(empty($_POST['email'])){
  $emailErr='EMAIL IS REQUIRED';
}else{
  $email=filter_input(INPUT_POST,'email',FILTER_SANITIZE_EMAIL);
}

// if(empty($_POST['phone'])){
//   $phoneErr='Phone IS REQUIRED';
// }else{

//   $name=filter_input(INPUT_POST,'phone',FILTER_SANITIZE_NUMBER_INT);
// }

if(empty($_POST['body'])){
  $bodyErr='BODY IS REQUIRED';
}else{

  $body=filter_input(INPUT_POST,'body',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
}


if(empty($nameErr) && empty($bodyErr) && empty($emailErr)){
$sql='';

    if(isset($_POST['id']) && $_POST['id']!=='' ){
      $id=$_POST['id'];
    $sql=  "UPDATE feedback SET name = '$name', email = '$email' , body='$body' WHERE id = '$id' ";
  }else{
   
  $sql=  "INSERT INTO feedback (name,email,body) VALUES ('$name' , '$email' , '$body' )";
  }

  try{
  if(mysqli_query($conn,$sql)){

    header("Location: feedback.php");

  }else {
    echo 'Error '. mysqli_error($conn);
  }
}catch(Exception $err){
  echo ($err->getMessage());
  // echo $sql;
}
}


}


?>

    <img src="/phpcrud/feedback/img/logo.png" class="w-25 mb-3" alt="">
    <h2>Feedback</h2>
    <p class="lead text-center"> Leave feedback for Traversy Media</p>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST" class="mt-4 w-75">
      <div class="mb-3">
        <label for="name" class="form-label">Name</label> 
        <input value="<?php echo isset($_POST['edit_name']) ?  $_POST['edit_name'] : ( isset($_POST['name']) ? $_POST['name'] : NULL )  ?>" type="text" class="form-control <?php if($nameErr!=='') echo "is-invalid"  ?>" id="name" name="name" placeholder="Enter your name">
        <div class="invalid-feedback">
        <?php echo $nameErr ?>
      </div>
      </div>
      
      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input  value="<?php echo isset($_POST['edit_email']) ?  $_POST['edit_email'] : ( isset($_POST['email']) ? $_POST['email'] : NULL )    ?>"  type="email" class="form-control <?php if($emailErr!=='') echo "is-invalid"  ?>" id="email" name="email" placeholder="Enter your email">
        <div class="invalid-feedback">
        <?php echo $emailErr ?>
      </div>
      </div>
      <!-- <div class="mb-3">
        <label for="phone" class="form-label">Phone</label> 
        <input value="<?php echo isset($_POST['edit_phone']) ?  $_POST['edit_phone'] : ( isset($_POST['phone']) ? $_POST['phone'] : NULL )  ?>" type="text" class="form-control <?php if($nameErr!=='') echo "is-invalid"  ?>" id="name" name="name" placeholder="Enter your name">
        <div class="invalid-feedback">
        <?php 
        //  echo $phoneErr ?>
      </div>
      </div> -->
      <div class="mb-3">
        <label for="body" class="form-label">Feedback</label>
        <textarea   class="form-control <?php if($bodyErr!=='') echo "is-invalid"  ?>" id="body" name="body" placeholder="Enter your feedback"></textarea>
        <div class="invalid-feedback">
        <?php echo $bodyErr ?>
      </div>
      </div>
      <div class="mb-3">
     <input type="hidden" name="id" value="<?php echo isset($_POST['edit_id']) ? $_POST['edit_id'] : (isset($_POST['id']) ? $_POST['id']: NULL )?>"   >
        <input type="submit" name="submit" value="Send" class="btn btn-dark w-100">
      </div>
    </form>



<?php include 'incl/footer.php' ?>
