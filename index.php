<?php

#assigning variables
$server = 'localhost';
$user = 'root';
$password = '';
$db = 'project-diary';

#creating DB connection
$conn = new mysqli($server,$user,$password,$db);

#checking connection
if(!$conn){
    die("Connection failed: " . mysqli_connect_error());}

#grabbing data from axios
$method = $_SERVER['REQUEST_METHOD'];

#Checking for the method used 
switch($method){
    case 'GET':
        $id = $_GET['id'];
        $sql = "SELECT * FROM flows WHERE id=$id";
        break;
    case 'POST':
        $flow = $_POST['flow'];

        //insertint ito db
        $sql = "INSERT INTO flows(flow) VALUES('$flow')";
        break;
}

#running sql statements
$result = mysqli_query($conn,$sql);

#cheking if sql is successed
if(!$result){
    http_response_code(404);
    die(mysqli_error($conn));
}else{
    echo 'Good';
}

if ($method == 'GET') {
    if (!$id) echo '[';
    for ($i=0 ; $i<mysqli_num_rows($result) ; $i++) {
      echo ($i>0?',':'').json_encode(mysqli_fetch_object($result));
    }
    if (!$id) echo ']';
  } elseif ($method == 'POST') {
    echo json_encode($result);
  } else {
    echo mysqli_affected_rows($conn);
  }

$conn->close();


