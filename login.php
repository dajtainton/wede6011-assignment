<?php
  session_start();
  
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="favicon.ico" rel="icon" type="image/x-icon" />
    <title>Login</title>
    <!-- Bootstrap -->
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <!-- Custom stlylesheet -->
    <link rel="stylesheet" href="css/login-stylesheet.css">
  </head>
  <body>
    <div class="login-page">
      <div class="form">
        <form class="login-form" method="post">
          <input type="email" name="username" placeholder="Username" value="<?php if(isset($_POST['username'])) echo $_POST['username']?>" required/>
          <input type="password" name="password" placeholder="Password" required/>
          <button name="login">Login</button>
          <p class="message">Not registered? <a href="register.php">Create an account</a></p>
        </form>
      </div>
    </div>
    <script src='js/jquery.min.js'></script>
  </body>
</html>

<?php
  if(isset($_POST["login"])) {
  
    // Connects to database
    include("scripts/dbConn.php");
  
    try {
      
      // Fetches user data into database using a prepared
      // statement to prevent SQL injection attacks 
      $stmt = $DBConnection->prepare('SELECT userId, firstname, lastname, email, passwordHash FROM tblUsers WHERE email = ?');
      
      // Binds variables to SQL statement
      $stmt->bind_param('s', $username);
  
      $username = mysqli_real_escape_string($DBConnection, $_POST["username"]);
      $hashedPassword = md5(mysqli_real_escape_string($DBConnection, $_POST["password"]));
  
      // Executes query
      $stmt->execute();
  
      $stmt->bind_result($userId, $firstname, $lastname, $email, $hash);
      $stmt->fetch();
  
      // Compares hashes to see if the entered 
      // password is correct
  
      //$hash === $hashedPassword
      if(isset($hash) && hash_equals($hash, md5($_POST['password']))) {
        
        // Sets session variables
        $_SESSION['userId'] = $userId;
        $_SESSION['firstname'] = $firstname;
        $_SESSION['lastname'] = $lastname;
        $_SESSION['email'] = $email;
  
        // Redirects user to index page
        header("Location: index.php");
        exit;
      } else {
        echo "Password incorrect...";
        return false;
      }
      
      $stmt->close();
  
    } catch (Exception $e) {
      echo 'An error occurred, please try again.';
      // echo 'Caught exception: '.  $e->getMessage();
    }
  
    // Closes connection
    mysql_close($DBConnection);
  
  }
  
?>