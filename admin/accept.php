<?php
session_start();
error_reporting(0);
include('includes/config.php');

if (isset($_GET['del'])) {
    $id = $_GET['del']; // Get the 'id' from the URL parameter

    // Your database connection settings
   

    $sql = "SELECT sid, isbn FROM request WHERE id = :id";
    $query = $dbh->prepare($sql);
    $query->bindParam(':id', $id, PDO::PARAM_INT);
    $query->execute();

    if ($query->rowCount() > 0) {
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $studentid = $row['sid'];
            $isbn = $row['isbn'];

            $sql = "SELECT id FROM tblbooks WHERE ISBNNumber = :isbn";
$query = $dbh->prepare($sql);
$query->bindParam(':isbn', $isbn, PDO::PARAM_STR);
$query->execute();

if ($query->rowCount() > 0) {
    $row = $query->fetch(PDO::FETCH_ASSOC);
    $bookId = $row['id'];

    // Now you have the "id" of the book from tblbooks
    // Use $bookId as needed
} 
           
echo $bookId;// Now, separate your INSERT and UPDATE statements and execute them separately
echo $studentid;
$isissued=1;
echo $bookid;
$sql="INSERT INTO  tblissuedbookdetails(StudentID,BookId) VALUES(:studentid,:bookid);
update tblbooks set isIssued=:isissued where id=:bookid;";
$query = $dbh->prepare($sql);
$query->bindParam(':studentid',$studentid,PDO::PARAM_STR);
$query->bindParam(':bookid',$bookid,PDO::PARAM_STR);
$query->bindParam(':isissued',$isissued,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();
           
        
        if($lastInsertId)
{
$_SESSION['msg']="Book issued successfully";
header('location:manage-issued-books.php');
}
else 
{
$_SESSION['error']="Something went wrong. Please try again";
header('location:manage-issued-books.php');

    }
}
    }
}
?>
