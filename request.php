<?php
// Check if the ISBNNumber and sid parameters are set in the URL
if (isset($_GET['ISBNNumber']) && isset($_GET['sid'])) {
    // Get the values from the URL
    $isbn = $_GET['ISBNNumber'];
    $sid = $_GET['sid'];
    
    // Insert the values into the database
    $servername = "localhost"; // Update to your server name
    $username = "root"; // Update to your database username
    $password = ""; // If your root user has no password, leave this empty
    $dbname = "library"; // Update to your database name

    // Create a database connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert the values into the database
    $sql = "INSERT INTO request (sid, isbn, status) VALUES ('$sid', '$isbn', '0')";
    
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Request inserted successfully.');</script>";
        echo "<script>location.href='listed-books.php';</script>";
    } else {
        echo "<script>alert('Error: " . $sql . "<br>" . $conn->error . "');</script>";
        echo "<script>location.href='listed-books.php';</script>";
    }
    
    // Close the database connection
    $conn->close();
} else {
    echo "<script>alert('ISBNNumber and sid not provided in the URL.');</script>";
    echo "<script>location.href='listed-books.php';</script>";
}
?>
