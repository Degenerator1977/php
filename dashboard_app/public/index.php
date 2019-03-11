<?php

  include_once '../config/Database.php';
  include_once '../models/Admin.php';

  // Message alert variables
  $msg = '';
  $msgClass = '';

  // Check for submit
  if(filter_has_var(INPUT_POST, 'submit')){

    // Get form data
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);
    $company = htmlspecialchars($_POST['company']);

    // Instantiate DB
    $database = new Database();
    $db = $database->connect();

    // Instantiate user object
    $user = new User($db);

    // Check required fields
    if(!empty($username)  && !empty($password) && !empty($company)) {

      // Set property values
      $user->username = $username;
      $user->password = $password;
      $user->company = $company;

      // Do login check here
      if($Admin->login()) {

        http_response_code(200);

      } else {
    
        http_response_code(401);
        
        // Failed login
        $msg = 'Login failed';
        $msgClass = 'alert-danger';
    
      }

    } else {

      // Failed to fill in all form fields
      $msg = 'Please fill in all fields';
      $msgClass = 'alert-danger';
    }
  }

 ?>

<!DOCTYPE html>
<html>
<head>
  <title>TerraMar Networks Login</title>
  <!-- Bootswatch CDN - for production install with NPM -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootswatch/4.2.1/flatly/bootstrap.min.css">
  <link rel="icon" href="favicon"/> sort this!!!!!!!!

</head>

<body>

  <!-- Nav bar -->
  <nav class="navbar nav-bar-default">
    <div class="container">
      <div class="navbar-header">
        <a class="navbar-brand" href="/">TerraMar Networks</a>
      </div>
    </div>
  </nav>

  <div class="container">
    <div class="row">
      <!-- Check for alert message and add to alert div area if true -->
      <?php if($msg != ''): ?>
        <div class="alert <?php echo $msgClass; ?>"><?php echo $msg; ?></div>
      <?php endif; ?>
    </div>

    <div class="row">

        <div class="col-md-4" padding="5">
          <div class="wrapper">
            <form class="form-signin" method="post" action="/login">
              <h2 class="form-signin-heading">Admin Portal</h2>
              <input type="text" class="form-control" value="<?php echo isset($_POST['username']) ? $username: ''; ?>" name="username" placeholder="Username"  autofocus="" />
              <input type="password" class="form-control" value="<?php echo isset($_POST['password']) ? $password: ''; ?>" name="password" placeholder="Password" />
              <input type="text" class="form-control" value="<?php echo isset($_POST['company']) ? $company: ''; ?>" name="company" placeholder="Company"  autofocus="" />
              <br>
              <button class="btn btn-lg btn-primary btn-block" type="submit" name="submit">Login</button>
            </form>
          </div>
        </div>

    <div class="col-md-8"><img src="http://localhost:8000/dashboard_app/public/images/transport.jpg" class="img-thumbnail" alt="Responsive Transport image"></div>
  </div>

</div>

</body>

</html>
