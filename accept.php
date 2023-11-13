<?php
if (isset($_GET['sid']) && isset($_GET['isbn']) && isset($_GET['id'])) {
    $studentID = $_GET['sid']; // Get Student ID from the URL parameter
    $isbn = $_GET['isbn']; // Get ISBN from the URL parameter
    $requestID = $_GET['id']; // Get the ID from the URL parameter
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
    // SQL query to insert into tblissuedbookdetails
    $insertSql = "INSERT INTO tblissuedbookdetails(StudentID, BookId) VALUES (?, (SELECT id FROM tblbooks WHERE ISBNNumber = ?))";
    // SQL query to delete the record from the request table
    $deleteSql = "DELETE FROM request WHERE id = ?";

    // SQL query to decrement copies in tblbooks
    $decrementSql = "UPDATE tblbooks SET copies = copies - 1 WHERE ISBNNumber = ?";

    // Prepare the INSERT statement
    if ($stmt = $conn->prepare($insertSql)) {
        // Bind parameters for INSERT
        $stmt->bind_param("ss", $studentID, $isbn);

        // Execute the INSERT statement
        if ($stmt->execute()) {
            // Prepare the DELETE statement
            if ($stmt = $conn->prepare($deleteSql)) {
                // Bind parameters for DELETE
                $stmt->bind_param("i", $requestID);

                // Execute the DELETE statement
                if ($stmt->execute()) {
                    // Prepare the UPDATE statement to decrement copies
                    if ($stmt = $conn->prepare($decrementSql)) {
                        // Bind parameter for ISBN
                        $stmt->bind_param("s", $isbn);

                        // Execute the UPDATE statement to decrement copies
                        $stmt->execute();

                        // Success: Inserted into tblissuedbookdetails, deleted from the request table, and updated copies
                        echo "<script>alert('Book issued successfully and request record deleted.'); window.location.href='manage-requests.php';</script>";
                    } else {
                        // Error: Decrement operation failed
                        echo "<script>alert('Error decrementing copies: " . $stmt->error . "'); window.location.href='manage-requests.php';</script>";
                    }
                } else {
                    // Error: Delete operation failed
                    echo "<script>alert('Error deleting request record: " . $stmt->error . "'); window.location.href='manage-requests.php';</script>";
                }
            }
        } else {
            // Error: Issue operation failed
            echo "<script>alert('Error issuing the book: " . $stmt->error . "'); window.location.href='manage-requests.php';</script>";
        }

        // Close the statement
        $stmt->close();
    }

    // Close the database connection
    $conn->close();
}
?>