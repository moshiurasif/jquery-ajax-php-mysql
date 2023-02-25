<?php
$conn = new mysqli("localhost", "root", "", "ajax-test") or die("connection not found");
$student_id = $_POST['id'];
$selectQuery = "SELECT * FROM students WHERE id = '{$student_id}'";
$result = $conn->query($selectQuery);
$output = "";
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $output .= "
    <fieldset>
        <label for='fname-edit'>First Name</label>
        <input type='text' placeholder='First Name' id='fname-edit' value='{$row['first_name']}'>
        <input type='text' placeholder='id' id='edit-id' hidden value='{$row['id']}'>
        <label for='lname-edit'>Last Name</label>
        <input type='text' placeholder='Last Name' id='lname-edit' value='{$row['last_name']}'>
        <input class='button-primary' type='submit' value='Submit' id='btn-submit-edit'>
    </fieldset>
";
    }
    $conn->close();
    echo $output;
} else {
    echo "data not found";
}
