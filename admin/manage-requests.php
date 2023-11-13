<?php
session_start();
error_reporting(0);
include('includes/config.php');


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';
if(strlen($_SESSION['alogin'])==0)
    {   
header('location:index.php');
}
else{ 
if(isset($_GET['del']))
{
// Assuming you have established a database connection earlier

$sql = "SELECT
            tblbooks.BookName,
            tblcategory.CategoryName,
            tblauthors.AuthorName,
            tblbooks.ISBNNumber,
            tblbooks.BookPrice,
            tblbooks.id AS bookid,
            tblbooks.bookImage,
            request.sid,
            request.id
        FROM
            tblbooks
        JOIN
            tblcategory ON tblcategory.id = tblbooks.CatId
        JOIN
            tblauthors ON tblauthors.id = tblbooks.AuthorId
        JOIN
            request ON tblbooks.ISBNNumber = request.isbn";

$result = mysqli_query($connection, $sql); // Assuming you're using MySQLi

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $sid = $row['sid']; // Retrieve the "sid" value from the query result
        // Use $sid as needed
    }
    mysqli_free_result($result); // Free the result set
} else {
    // Handle the query execution error
    echo "Error: " . mysqli_error($connection);
}

// Assuming you have established a database connection and assigned it to $connection

$sql = "SELECT EmailId FROM tblStudents WHERE StudentId = '$sid'";

$result = mysqli_query($connection, $sql); // Assuming you're using MySQLi

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $email = $row['EmailId']; // Retrieve the "EmailId" value from the query result
        // Use $emailId as needed
    }
    mysqli_free_result($result); // Free the result set
} 










$id=$_GET['del'];
$sql = "delete from tblbooks  WHERE id=:id";
$query = $dbh->prepare($sql);



$mail = new PHPMailer(true);

$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username = 'veeravinu345@gmail.com';
$mail->Password = 'kdgmbfkrmcvmdhyd';
$mail->SMTPSecure = 'ssl';
$mail->Port = 465;

$mail->setFrom('veeravinu345@gmail.com');
$mail->addAddress($email);

$mail->Subject = 'Book issued';
$mail->Body = "Your book with id=: $id";

$mail->send();


}


    ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Online Library Management System | Manage Books</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- DATATABLE STYLE  -->
    <link href="assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
    <!-- GOOGLE FONT -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

</head>
<body>
      <!------MENU SECTION START-->
<?php include('includes/header.php');?>
<!-- MENU SECTION END-->
    <div class="content-wrapper">
         <div class="container">
        <div class="row pad-botm">
            <div class="col-md-12">
                <h4 class="header-line">Manage Requests</h4>
    </div>
  


        </div>
            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Books Requests
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>sid</th>

                                            <th>Book Name</th>
                                            <th>Category</th>
                                            <th>Author</th>
                                            <th>ISBN</th>
                                            <th>Price</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>



                                    <?php 
                                    
                                    
                                    $sql = "SELECT
                                    tblbooks.BookName,
                                    tblcategory.CategoryName,
                                    tblauthors.AuthorName,
                                    tblbooks.ISBNNumber,
                                    tblbooks.BookPrice,
                                    tblbooks.id AS bookid,
                                    tblbooks.bookImage,
                                    request.sid,
                                    request.id

                                FROM
                                    tblbooks
                                JOIN
                                    tblcategory ON tblcategory.id = tblbooks.CatId
                                JOIN
                                    tblauthors ON tblauthors.id = tblbooks.AuthorId
                                JOIN
                                    request ON tblbooks.ISBNNumber = request.isbn";
                                
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{               ?>                                      
                                        <tr class="odd gradeX">
                                            <td class="center"><?php echo htmlentities($cnt);?></td>
                                            <td class="center"><?php echo htmlentities($result->sid);?></b></td>

                                            <td class="center" width="300">
<img src="bookimg/<?php echo htmlentities($result->bookImage);?>" width="100">
                                                <br /><b><?php echo htmlentities($result->BookName);?></b></td>
                                            <td class="center"><?php echo htmlentities($result->CategoryName);?></td>
                                            <td class="center"><?php echo htmlentities($result->AuthorName);?></td>
                                            <td class="center"><?php echo htmlentities($result->ISBNNumber);?></td>
                                            <td class="center"><?php echo htmlentities($result->BookPrice);?></td>
                                            <td class="center">

                                            <a href="issue-book.php?del=<?php echo htmlentities($result->id);?>"><button class="btn btn-primary"></i>Accept</button> 
                                          <a href="decline.php?del=<?php echo htmlentities($result->id);?>" onclick="return confirm('Are you sure you want to delete?');" >  <button class="btn btn-danger"></i>Decline</button>
                                            </td>
                                        </tr>
 <?php $cnt=$cnt+1;}} ?>                                      
                                    </tbody>
                                </table>
                            </div>
                            
                        </div>
                    </div>
                    <!--End Advanced Tables -->
                </div>
            </div>


            
    </div>
    </div>

     <!-- CONTENT-WRAPPER SECTION END-->
  <?php include('includes/footer.php');?>
      <!-- FOOTER SECTION END-->
    <!-- JAVASCRIPT FILES PLACED AT THE BOTTOM TO REDUCE THE LOADING TIME  -->
    <!-- CORE JQUERY  -->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP SCRIPTS  -->
    <script src="assets/js/bootstrap.js"></script>
    <!-- DATATABLE SCRIPTS  -->
    <script src="assets/js/dataTables/jquery.dataTables.js"></script>
    <script src="assets/js/dataTables/dataTables.bootstrap.js"></script>
      <!-- CUSTOM SCRIPTS  -->
    <script src="assets/js/custom.js"></script>
</body>
</html>
<?php } ?>
