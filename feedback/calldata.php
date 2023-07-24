
<?php include 'config/database.php' ?>


<?php 

$sql='SELECT id,name, email , phone , body , date FROM feedback';
$result= mysqli_query($conn, $sql);
$feedback= mysqli_fetch_all($result,MYSQLI_ASSOC);

// var_dump($feedback);

$mappedFeedback = array_map(function ($item) {
    $item['edit'] = 
"<form  action='index.php' method='POST'>   
    <input type='hidden' name='edit_id' value=". $item['id'] .">
    <input type='hidden' name='edit_name' value=". $item['name'] .">
    <input type='hidden' name='edit_email' value=". $item['email'] . ">
    <input type='hidden' name='edit_phone' value=" . $item['phone'] . ">
      <button type='submit'  class='btn btn-primary btn-sm float-end'>Edit</button>
</form>";

    $item['delete'] = 
   
   
      "<button type='button'  class='btn btn-secondary btn-sm float-end' onclick='deleteFeedback(".$item['id'].")' >Delete</button>";
      
    return $item;
}, $feedback);






$finalResult = [
    'data' => $mappedFeedback
];

$results= json_encode($finalResult);
echo $results;  


?>