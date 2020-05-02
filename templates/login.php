<?PHP
    // Connect to Database
    require_once("../mysql.inc.php");

    // Database object 'db' is now available for use.
    // If the post variable with the username and password are set, then check the users table and compare input with what's in the table

    if( isset($_POST['username']) && isset($_POST['password']) ) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $sql = "SELECT username, password_hash FROM users WHERE username = ?";

        $stmt = $db->stmt_init();
        $stmt->prepare($sql);
        $stmt->bind_param('s', $username);
        $success = $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($user, $hash);
        $stmt->fetch();
        $stmt->close();
  
  
        if(!$success || $db->affected_rows == 0) {
          echo "<p>ERROR: " . $db->error . " for query *$query*</p><hr>";
        }


        //Now check to see if username and password match.
        if ( $user == $username && password_verify($password, $hash) ) {
            session_start();

            $_SESSION['user'] = 'admin';
            
            header("Location: ../admin/addPost.php");
        } else {
            echo "<script>alert('Incorrect Login Information');</script>";
        }
    }

?>


<!-- Borrowed from Bootstrap Template on getbootstrap.com -->
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Signin Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">


    <!-- Custom styles for this template -->
    <link href="../css/custom.css" rel="stylesheet">
  </head>

  <body class="text-center login-form">
    <form class="form-signin" method="POST" action="login.php">
      <h1 class="h3 mb-3 font-weight-normal">Admin Log In</h1>
        
      <label for="inputUsername" class="sr-only">Email address</label>
        <input type="text" id="inputUsername" class="form-control" placeholder="Username" name="username" required autofocus>
        
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required>
      
        <br>

      <button class="btn btn-lg bg-prim btn-block" type="submit">Sign in</button>
      <a class="btn btn-lg bg-sec btn-block" href="index.php" style="color: black;">I'm Not Admin</a>
      <p class="mt-5 mb-3 text-muted">&copy; The Juicy Pepper 2023</p>
    </form>
  </body>
</html>
