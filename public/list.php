<?php

require_once __DIR__ . '/protected/config/config.php';

$con=mysqli_connect(SQL_HOSTNAME,SQL_USERNAME,SQL_PASSWORD,SQL_DATABASE);
if (mysqli_connect_errno())
{
echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$result = mysqli_query($con,"SELECT * FROM " . SQL_TABLE);

echo "<table border='1'>
<tr>
<th>Comment</th>
<th>Token</th>
</tr>";

while($row = mysqli_fetch_array($result))
{
echo "<tr>";
echo "<td>" . $row['comment'] . "</td>";
echo "<td>" . $row['token'] . "</td>";
echo "<td><a href='unregister.php?token=" . $row['token'] . "'>X</a></td>";
echo "</tr>";
}
mysqli_close($con);
echo "</table><br><br><br>";

echo "
<form action='register.php'>
  New user:<br>
  <input type='text' name='comment' value=''>
  <br><br>
  <input type='submit' value='Submit'>
</form>
"
?>
