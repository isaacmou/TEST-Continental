<?php
session_start(); // Start the session
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    echo "Hi, $username<br><br>";
} else {
    // Redirect the user back to the login page if the session data is not set
    header("Location: index.php");
    exit();
}
include 'database.php';
$results_per_page = 4; // Number of products per page
if (!isset($_GET['page'])) {
    $page = 1;
} else {
    echo"hi";
}

$start_index = ($page - 1) * $results_per_page;
$search = isset($_GET['search']) ? $_GET['search'] : '';
$sql = "SELECT ProductName, photo FROM products WHERE ProductName LIKE '%$search%' LIMIT $start_index, $results_per_page";
$result = $conn->query($sql);

echo "<form method='GET' action=''>
    <input type='text' name='search' placeholder='Search by ProductName' value='$search'>
    <button type='submit'>Search</button>
</form>";
if ($result->num_rows > 0) {
    // Display images
    while ($row = $result->fetch_assoc()) {
        $ProductName = $row['ProductName'];
        $photo = $row['photo'];

        // Display the image
        echo "<div style='width: 45%; padding: 10px; box-sizing: border-box; display: inline-block; margin-right: 5%'>";
        echo "$ProductName<br>";
        echo "<img style='width: auto; height: 40%;' src='data:image/jpeg;base64," . base64_encode($photo) . "' alt='Image $ProductName'><br>";
        echo "</div>";
    }

    // Pagination links
    $sql = "SELECT COUNT(*) AS total FROM products WHERE ProductName LIKE '%$search%'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $total_pages = ceil($row['total'] / $results_per_page);

    echo "<div>";
    for ($i = 1; $i <= $total_pages; $i++) {
        $pageLink = isset($_GET['search']) ? "?page=$i&search=$search" : "?page=$i";
        echo "<a href='$pageLink'>$i</a> ";
    }
    echo "</div>";
} else {
    echo "No images found";
}

$conn->close();
?>