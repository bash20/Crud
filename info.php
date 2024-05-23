<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "userinfo";

$conn = new mysqli($servername, $username, $password, $database);
if($conn->connect_errno){
    die("Connection Failed :" . $conn->connect_error);
}

function fetchAllUsers($conn) {
    $sql = "SELECT * FROM info";
    $result = $conn->query($sql);
    $users = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
    }
    echo json_encode($users);
}


function addUser($conn){
    $U_name = mysqli_real_escape_string($conn, $_POST['U_name']);
    $Email_id = mysqli_real_escape_string($conn, $_POST['Email_id']);

    $sql = "INSERT INTO info (Uname, emailid) VALUES ('$U_name','$Email_id')";
    $result = mysqli_query($conn,$sql);

    if($result){
        echo "<p class='alert alert-success'>Data inserted</p>";
    } else{
        echo "<p class='alert alert-danger'>Data not inserted</p>";
    }
}

function delUser($conn){
    $Uid = intval($_POST['U_delet']);
    $sql = "DELETE FROM info WHERE id = $Uid " ;
    $result = mysqli_query($conn, $sql);
    if($result){
        echo "<p class='alert alert-success'>Data Deleted</p>";
    } else {
        echo "<p class='alert alert-danger'>Data not deleted</p>";
    }
}

function updateUser($conn){
    $Uid = intval($_POST['id']);
    $uname = mysqli_real_escape_string($conn,$_POST['Uname']);
    $uemail = mysqli_real_escape_string($conn,$_POST['emailid']);

    $sql = "UPDATE info SET Uname = '$uname' , emailid = '$uemail' WHERE id = '$Uid' ";
    $result = mysqli_query($conn, $sql);
    if($result){
        echo "<p class='alert alert-info'>Data updated</p>";
    } else {
        echo "<p class='alert alert-danger'>Data not updated</p>";
    }
}
function betUser($conn){
    $minid = intval($_GET['Idmin']);
    $maxid = intval($_GET['Idmax']);
     
     $sql = "SELECT * FROM info WHERE id BETWEEN $minid AND $maxid";
     $result = $conn->query($sql);
     $users = [];
     if ($result->num_rows > 0) {
         while ($row = $result->fetch_assoc()) {
             $users[] = $row;
         }
     }
     echo json_encode($users);
 }

$action = $_REQUEST['action'];
 switch($action){
    case 'read':
        fetchAllUsers($conn);
        break;
    
    case 'insert':
        addUser($conn);
        break;

    case 'delete':
        delUser($conn);
        break;

    case 'update':
        updateUser($conn);
        break;

        case 'between':
            betUser($conn);
            break;
 }

