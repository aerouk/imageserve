<?php
 
require_once __DIR__ . '/protected/config/config.php';

// Create connection
$conn=mysqli_connect(SQL_HOSTNAME,SQL_USERNAME,SQL_PASSWORD,SQL_DATABASE);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$token=$_GET['token'];
$table=SQL_TABLE;
$sql = "DELETE FROM $table WHERE token='$token'";

if ($conn->query($sql) === TRUE) {
    echo "Record deleted successfully";
} else {
    echo "Error deleting record: " . $conn->error;
}
echo "<br><br><a href='list.php'>Back to Userlist</a>";

$conn->close();
?> 
