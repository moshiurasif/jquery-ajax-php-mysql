<?php
$search_value = $_POST['search'];
$conn = new mysqli("localhost", "root", "", "ajax-test") or die("connection not found");
$sqlQuery = "select * from students where first_name LIKE '%{$search_value}%' OR last_name LIKE '%{$search_value}%'";
$result = $conn->query($sqlQuery);
$output = "";
if ($result->num_rows > 0) {
    $output = "<table>
    <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th width='150px'>Edit</th>
            <th width='150px'>Delete</th>
        </tr>
        </thead>
        <tbody>
    ";
    while ($row = $result->fetch_assoc()) {
        $output .= "
        <tr>
            <td>{$row['id']}</td>
            <td>{$row["first_name"]} {$row["last_name"]}</td>
            <td><button class='edit-btn' data-eid='{$row['id']}'>Edit</button></td>
            <td><button class='delete-btn' data-id='{$row['id']}'>Delete</button></td>
        </tr>
    ";
    }
    $output .= "</tbody></table>";
    $conn->close();
    echo $output;
} else {
    echo "<h2>No records found</h2>";
}
