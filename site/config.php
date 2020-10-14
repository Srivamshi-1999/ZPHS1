<?php
$firstname= $_POST['fname'];
$lastname= $_POST['lastname'];
$email= $_POST['email'];
$phonenumber= $_POST['phonenumber'];
$password= $_POST['psw'];
if(!empty($firstname) || !empty($lastname) || !empty($email)|| !empty($phonenumber) || !empty($password)) {
 $host = "localhost";
    $dbUsername = "root";
    $dbpass = "Vamshisql@003";
    $dbname = "useraccounts";
    //create connection
    $conn = new mysqli($host, $dbUsername, $dbpass, $dbname);
    if (mysqli_connect_error()) {
     die('Connect Error('. mysqli_connect_errno().')'. mysqli_connect_error());
    } else {
     $SELECT = "SELECT email From register Where email = ? Limit 1";
     $INSERT = "INSERT Into register (firstname, lastname, email, phonenumber, password) values(?, ?, ?, ?, ?)";
     //Prepare statement
     $stmt = $conn->prepare($SELECT);
     $stmt->bind_param("s", $email);
     $stmt->execute();
     $stmt->bind_result($email);
     $stmt->store_result();
     $rnum = $stmt->num_rows;
     if ($rnum==0) {
      $stmt->close();
      $stmt = $conn->prepare($INSERT);
      $stmt->bind_param("sssss", $firstname,$lastname,$email,$phonenumber,$password);
      $stmt->execute();
      echo "New record inserted sucessfully";
     } else {
      echo "Someone already register using this email";
     }
     $stmt->close();
     $conn->close();
    }
} else {
 echo "All field are required";
 die();
}
?>