<?php
$conn = new mysqli("localhost", "root", "", "ajax-test") or die("connection not found");
$limit_per_page = 5;
$page = "";
if (isset($_POST['page_no'])) {
    $page = $_POST['page_no'];
} else {
    $page = 1;
}
$offset = ($page - 1) * $limit_per_page;
$sqlQuery = "select * from students LIMIT {$offset}, {$limit_per_page}";
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
    $recordsQuery = "select * from students";
    $records = $conn->query($recordsQuery);
    $totalRecords = $records->num_rows;
    $totalPages = ceil($totalRecords / $limit_per_page);
    $output .= "<div id='pagination'>";

    for ($i = 1; $i <= $totalPages; $i++) {
        if ($i == $page) {
            $active_page = "active";
        } else {
            $active_page = "";
        }
        $output .= "<a href='' id='{$i}' class='{$active_page}'>{$i}</a>";
    }

    $output .= "</div>";
    $conn->close();
    echo $output;
} else {
    echo "<h2>data not found</h2>";
}
