<?php

require 'db.php';

$sql = "SELECT * FROM urls";
$result = mysqli_query($conn, $sql);

echo "<table border='1'>";
echo "<tr><th>ID</th><th>Long URL</th><th>Short Code</th><th>Clicks</th></tr>";

while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>" . $row['id'] . "</td>";
    echo "<td>" . htmlspecialchars($row['long_url']) . "</td>";
    echo "<td>" . $row['short_code'] . "</td>";
    echo "<td>" . $row['clicks'] . "</td>";
    echo "</tr>";
}

echo "</table>";
