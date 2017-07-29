<?php
 
require_once __DIR__ . '/protected/config/config.php';

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

// Create connection
$conn=mysqli_connect(SQL_HOSTNAME,SQL_USERNAME,SQL_PASSWORD,SQL_DATABASE);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$table=SQL_TABLE;
$comment=$_GET['comment'];
$token=generateRandomString(40);
$sql = "INSERT INTO $table (comment, token) VALUES ('$comment', '$token')";

if ($conn->query($sql) === TRUE) {
    echo "Token generated for new user \"$comment\":<br><br>$token";
} else {
    echo "Error creating user: " . $conn->error;
}
echo "<br><br><a href='list.php'>Back to Userlist</a>";

$conn->close();
?> 
