<?php
$conn = new mysqli("localhost", "root", "", "ajax-test") or die("connection not found");
$id = $_POST['id'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$updateQuery = "UPDATE students SET first_name = '{$first_name}', last_name = '{$last_name}' WHERE id = '{$id}'";
if ($conn->query($updateQuery)) {
    echo 1;
} else {
    echo 0;
}
