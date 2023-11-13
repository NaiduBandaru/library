<?php
// Ensure you have a valid database connection before executing this query

if (isset($_GET['del'])) {
    $id = $_GET['del']; // Get the 'id' from the URL parameter

    // Your database connection settings
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "library";

    // Create a database connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // SQL query to delete a record from the "request" table
    $sql = "DELETE FROM request WHERE id = '$id'";

    if ($conn->query($sql) === TRUE) {
        // Success: Record deleted
        echo "<script>alert('Record deleted successfully.'); window.location.href='manage-requests.php';</script>";
    } else {
        // Error: Record not deleted
        echo "<script>alert('Error deleting record: " . $conn->error . "'); window.location.href='manage-requests.php';</script>";
    }

    // Close the database connection
    $conn->close();
}
?>
