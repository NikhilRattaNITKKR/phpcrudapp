
<?php include 'config/database.php' ?>


<?php 

$sql='SELECT id,name, email , phone , body , date FROM feedback';
$result= mysqli_query($conn, $sql);
$feedback= mysqli_fetch_all($result,MYSQLI_ASSOC);

// var_dump($feedback);

$finalResult = [
    'data' => $feedback
];

$results= json_encode($finalResult);
echo $results;  


?>