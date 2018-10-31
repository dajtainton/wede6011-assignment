<?php
  session_start();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="favicon.ico" rel="icon" type="image/x-icon" />
    <title>Register</title>
    <!-- Bootstrap -->
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <!-- Custom stlylesheet -->
    <link rel="stylesheet" href="css/login-stylesheet.css">
  </head>
  <body>
    <div class="login-page">
      <div class="form">
        <form class="register-form" method="post">
          <input type="text" name="firstname" placeholder="Firstname" value="<?php if(isset($_POST['firstname'])) echo $_POST['firstname']?>" required/>
          <input type="text" name="lastname" placeholder="Lastname" value="<?php if(isset($_POST['lastname'])) echo $_POST['lastname']?>" required/>
          <input type="email" name="email" placeholder="Email Address" value="<?php if(isset($_POST['email'])) echo $_POST['email']?>" required/>
          <input type="password" name="password" placeholder="Password" required/>
          <input type="password" name="retypedpassword" placeholder="Retype Password" required/>
          <button name="register">Register</button>
          <p class="message">Already registered? <a href="login.php">Log In</a></p>
        </form>
      </div>
    </div>
    <script src='js/jquery.min.js'></script>
  </body>
</html>
<?php
  if(isset($_POST["register"])) {
  
    // Connects to database
    include("scripts/dbConn.php");
  
    try {
      // Checks that input is valid
      if(validInput()) {
  
        // Inserts user data into database using a prepared
        // statement to prevent SQL injection attacks 
        $stmt = $DBConnection->prepare("INSERT INTO `tblUsers` (`firstname`, 
        `lastname`, `email`, `passwordHash`) VALUE(?, ?, ?, ?)");
  
        // Binds variables to SQL statement
        $stmt->bind_param('ssss', $fname, $lname, $uname, $phash);
        
        $fname = mysqli_real_escape_string($DBConnection, $_POST["firstname"]);
        $lname = mysqli_real_escape_string($DBConnection, $_POST["lastname"]);
        $uname = mysqli_real_escape_string($DBConnection, $_POST["email"]);
        $phash = md5(mysqli_real_escape_string($DBConnection, $_POST["password"]));
  
        // Executes query
        $stmt->execute();
        $stmt->close();
  
        // Closes connection
        mysqli_close($DBConnection);
  
        // Creates alert saying account created successfully
        echo "<script>alert(\"Account created successfully.\");</script>";
        header("Location: login.php");
        exit;
  
      }
    } catch (Exception $e) {
      echo 'An error occurred, please try again.';
      // echo 'Caught exception: '.  $e->getMessage();
    }
  }
  
  function validInput() {
  
    // Validates values from the form and 
    // displays an appropriate error message
    $valid = true;
    
    $regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/'; 
    if (!preg_match($regex, $_POST['email'])) {
      echo "Please enter a valid email address *<br/>";
      $valid = false;
    }
  
    if (strlen($_POST['password']) < 8) {
        echo "Password should be longer than 8 characters *<br/>";
        $valid = false;
    }
  
    if($_POST['password'] !== $_POST['retypedpassword']) {
        echo "Passwords do not match  *<br/>";
        $valid = false;
    }
  
    // Returns true if valid input
    return $valid;
  
  }
  
  ?>