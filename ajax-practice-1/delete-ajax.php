<?php
$conn = new mysqli("localhost", "root", "", "ajax-test") or die("connection not found");
$id = $_POST['id'];
$deleteQuery = "DELETE FROM students WHERE id=$id";
if ($conn->query($deleteQuery)) {
    echo 1;
} else {
    echo 0;
}
