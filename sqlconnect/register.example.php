<?php
  /////////////////////////////////////////
  // register.php Copyright ajc200x 2018 //
  /////////////////////////////////////////
  // Database PHP Connector

  $dbuser = 'DATABASE USERNAME HERE';  // Replace these with your MYSQL Database Credentials
  $dbpassword = 'DATABASE PASSWORD HERE';
  $databasename = 'DATABASE_NAME HERE';

  $con = mysqli_connect('localhost',$dbuser,$dbpassword,$databasename);
  // Connection Check
  if(mysqli_connect_errno())
  {
    echo "1: Connection Failed."; // Error Code #1 - Connection Failed Output
    exit();
  }
  $username = $_POST ["username"];
  $password = $_POST ["password"];
  // Name Checker PHP-SQL Query
  $namecheckquery = "SELECT username FROM players WHERE username = '" . $username . "';"; // Careful of syntax altering this string... careful annotation required...
  $namecheck = mysqli_query($con, $namecheckquery) or die("2: Userame check query Failed"); // Error Code #2 Name Check Query Failed
if (mysqli_num_rows($namecheck) > 0)
{
  echo "3: This username has already been taken! :( "; // Error Code 3 Output
  exit();
}
// Adding The User To The Database Table .. DATABASE_NAME.players
$salt = sha1(md5($password)).'scrambledeggs';
$password = md5($password.$salt);
$hash = crypt($salt, $password);
$insertuserquery = "INSERT INTO players (username, hash, salt) VALUES ('".$username ."','".$hash ."','". $salt ."');";
mysqli_query($con, $insertuserquery) or die("4: Inserting player registration information into the database Failed."); // Error Code #4: Player Insert Failure
echo ("0");
?>
