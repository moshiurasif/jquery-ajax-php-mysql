<?php
$conn = new mysqli("localhost", "root", "", "ajax-test") or die("connection not found");
$first_name = $_POST["first_name"];
$last_name = $_POST["last_name"];
$inserQuery = "insert into students(first_name, last_name) values('{$first_name}', '{$last_name}')";
if ($conn->query($inserQuery)) {
    echo 1;
} else {
    echo 0;
}
