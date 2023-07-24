<?php include 'incl/header.php' ?>

<?php 

$name='';
$email='';
$body='';
$phone='';

$nameErr='';
$emailErr='';
$bodyErr='';
$phoneErr='';
$fileContent='';
$fileErr='';


$sqlToGetEmails="SELECT email from feedback";

$result= mysqli_query($conn, $sqlToGetEmails);
$newResult= mysqli_fetch_all($result,MYSQLI_NUM);


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

  if(strrpos($email,'.')<strpos($email,'@'))
  $emailErr='Enter a valid Email';

}

if(empty($_POST['phone'])){
  $phoneErr='Phone IS REQUIRED';
}else{

  $phone=filter_input(INPUT_POST,'phone',FILTER_SANITIZE_NUMBER_INT);

  if(!(strlen($phone)==10 && ctype_digit($phone)) ){
$phoneErr='Phone number is not valid';
  }
}

if(empty($_POST['body'])){
  $bodyErr='BODY IS REQUIRED';
}else{

  $body=filter_input(INPUT_POST,'body',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
}

if(empty($_FILES['photo']['name'])){
  $fileErr='Photo IS REQUIRED';
}else{

  $file = $_FILES['photo'];

    // Check for errors
    if ($file['error'] !== UPLOAD_ERR_OK) {
        $fileErr= "Error uploading file. Error code: " . $file['error'];
        exit;
    }

    // Validate file size (in bytes)
    $maxFileSize = 5 * 1024 * 1024; // 5MB
    if ($file['size'] > $maxFileSize) {
      $fileErr= "File size exceeds the maximum limit of 5MB.";
    }

    // Validate file extension
    $allowedExtensions = array('jpg', 'jpeg', 'png');
    $fileName = $file['name'];
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    if (!in_array($fileExtension, $allowedExtensions)) {
        $fileErr="Invalid file extension. Only JPG, JPEG, PNG files are allowed.";
    }


$fileContent=file_get_contents($file["tmp_name"]);
$fileContent = addslashes($fileContent);
}


if(empty($nameErr) && empty($bodyErr) && empty($emailErr) && empty($phoneErr) ){
$sql='';

    if(isset($_POST['id']) && $_POST['id']!=='' ){
      $id=$_POST['id'];
      if($fileErr!=='')
    $sql=  "UPDATE feedback SET name = '$name', email = '$email' , body='$body' , phone='$phone' , photo= '$fileContent' WHERE id = '$id' ";
    else
    $sql=  "UPDATE feedback SET name = '$name', email = '$email' , body='$body' , phone='$phone'  WHERE id = '$id' ";
  }else{
    if($fileErr!=='')
  $sql= "INSERT INTO feedback (name,email,phone, photo, body ) VALUES ('$name' , '$email' , '$phone' , '$fileContent'  , '$body' )";
  else
  $sql= "INSERT INTO feedback (name,email,phone,  body ) VALUES ('$name' , '$email' , '$phone' , '$body' )";

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

    <img src="/phpcrud/feedback/img/images.jpg" class="w-25 mb-3" alt="">
    <h2>Feedback</h2>
    <p class="lead text-center"> Leave feedback for HONO </p>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST" class="mt-4 w-75" enctype="multipart/form-data">
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
        <div class="invalid-feedback" id="email_div">
        <?php echo $emailErr ?>
      </div>
      </div>
       <div class="mb-3">
        <label for="phone" class="form-label">Phone</label> 
        <input onkeypress='return event.charCode >= 48 && event.charCode <= 57' value="<?php echo isset($_POST['edit_phone']) ?  $_POST['edit_phone'] : ( isset($_POST['phone']) ? $_POST['phone'] : NULL )  ?>" type="text" class="form-control <?php if($phoneErr!=='') echo "is-invalid"  ?>" id="phone" name="phone" placeholder="Enter your 10 digit PhoneNumber">
        <div class="invalid-feedback" id="phone_div">
        <?php 
         echo $phoneErr ?>
         
      </div>
      </div>

      <div class="mb-3">
        <label for="photo" class="form-label">Photo</label> 
        <input accept=".jpg, .png, .jpeg"  type="file" class="form-control id="photo" name="photo" placeholder="Upload your Photo">
        <!-- <div class="invalid-feedback"> -->
        <?php 
        //  echo $fileErr ?>
      <!-- </div> -->
      </div>
       
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



    <script>


$(document).ready( function () {
  
var emails= <?= json_encode($newResult) ?>;

emails=emails.map((item)=>item[0]);

$('#email').on ('keyup ',(e)=>{

  if(emails.includes(e.target.value)){
    
    $('#email').addClass('is-invalid');
    $('#email_div').html("This Email is already in use. Please chose another");
  }else{
    $('#email_div').html("");
    $('#email').removeClass('is-invalid');
  }
})

$('#phone').on ('keyup ',(e)=>{

if(String(e.target.value).length !==10){
  
  $('#phone').addClass('is-invalid');
  $('#phone_div').html("Phone number is Invalid");
}else{
  $('#phone_div').html("");
  $('#phone').removeClass('is-invalid');
}
})

} );

</script>

<?php include 'incl/footer.php' ?>
