<?php
$nameerror = $twoerror = $errormsg = "";
$namesafe = $twosafe = "";
// PHP Procedural MYSQLi
// connect to mysql database with phpmyadmin
$servername = "localhost";
$username = "root";
$password = "password";
$dbname = "test";

$connection = new mysqli($servername, $username, $password, $dbname);

//if(isset($_POST["submit"]))
if($_SERVER["REQUEST_METHOD"] == "POST")
{
    if(empty(trim($_POST["name"]))) {
        $nameerror = "Name is required";
    }
    else {
        $namesafe = mysqli_real_escape_string($connection, $_POST["name"]);
    }
    if(empty(trim($_POST["two"]))) {
        $twoerror = "Two is required";
    }
    else {
        $twosafe = mysqli_real_escape_string($connection, $_POST["two"]);
    }

    if($namesafe != "" && $twosafe != "") {
      // Check and see if EXISTS
          $sqlCheck = "SELECT name FROM tester WHERE name ='". $namesafe ."'";
        $check = mysqli_query($connection, $sqlCheck);
        $numRows = mysqli_num_rows($check);
        if($numRows == 0) {

            $sqlInsert = "INSERT INTO tester(name, two) " .
                "VALUES('". $namesafe ."','". $twosafe ."')";
              if(mysqli_query($connection, $sqlInsert)) {
                  echo "Successfully entered.";
              } else {
                  echo "NOT successful error: " . $sqlInsert . "<br>" . mysqli_error($connection);
              }
          }
          else {
              $errormsg = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close" aria-hidden="true">
              &times;</button>Name has <b>ALREADY</b> been <u>used</u>!<br>'. $namesafe .'</div>';
        }
    } else {
        $errormsg = '<div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" ' .
            'class="close" data-dismiss="alert" aria-label="Close" aria-hidden="true">&times;</button>' .
            'All fields are required to continue</div>';
    }
}

mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>PHP BootStrap mysql Create</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- BootStrap 4 CDN CSS external link -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <!-- Custom CSS Link -->
    <link rel="stylesheet" href="css/main.css" />
</head>
<body>
  <header class="container-fluid text-center text-light py-4">
      <div>
          <div class="d-block">
              <img id="headpic" class="rounded-circle" src="img/Andrew.JPG" />
          </div>
          <div>
              <h1 class="header-text d-inline">PHP BootStrap4 mySQL Create</h1>
              <span class="d-inline text-light2">By Andrew Harkins</span>
          </div>
      </div>
  </header>
  <?php
      if(!$connection) {
        die("Connection Failed! " . mysqli_connect_error());
      }
      echo "Connected Successfully@!";
   ?>
    <section class="text-align" id="section-content">
        <div id="alertMessages" class="container rounded"></div>
        <div id="contentdiv" class="container rounded">
            <form id="formtest" class="rounded" method="post" action="">
              <!-- action="" -->
                <h3>PHP Create</h3>
                <?php
                    if(isset($errormsg)) {
                      echo $errormsg;
                    }
                 ?>
                <div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="txtName" name="name"/>
                        <label for="txtName">Name </label>
                        <?php if(isset($nameerror)) { echo '<span class="error"><b>' . $nameerror . '</b></span>'; } ?>
                    </div>
                    <div>
                        <input type="text" class="form-control" id="txttwo" name="two"/>
                        <label for="txttwo">Text Two </label>
                        <?php if(isset($twoerror)) { echo '<span class="error"><b>' . $twoerror . '</b></span>'; } ?>
                    </div>
                </div>
                <button type="submit" class="btn btn-lg btn-primary btn-block" name="submit">Click</button>
            </form>
        </div>
    </section>
    <!-- BootStrap 4 CDN JavaScript -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
</body>
</html>
