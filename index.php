<!-- index.php -->
<?php 
    include 'core/init.php';
    if (isset($_SESSION['user_id'])) {
      header('Location: home.php');
    }
?>
<html>
  <head>
    <title>Twitter Clone</title>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="assets/css/font/css/font-awesome.css"/>
    <link rel="stylesheet" href="assets/css/style-complete.css"/>
  </head>
<body>
<div class="bg">
<div class="wrapper">
<!---Inner wrapper-->
    <div class="inner-wrapper-index">
      <!-- main container -->
      <div class="main-container">
        <!-- content left-->
        <div class="content-left">
          <h1>Welcome to Twitter</h1>
          <br/>
          <p>See what's happening in the world right now.</p>
        </div><!-- content left ends -->  
        <!-- content right ends -->
        <div class="content-right">
          <!-- Log In Section -->
          <div class="login-wrapper">
            <?php include 'includes/login.php' ?>
            <div class="login-div">
              <h3>Login</h3>
              <form method="post">
                <ul>
                  <li>
                    <input type="text" name="email" placeholder="Email"/>
                  </li>
                  <li>
                    <input type="password" name="password" placeholder="Password"/>
                  </li>
                  <li>
                    <input type="submit" name="login" value="Login"/>
                  </li>

                  <?php
                    if (isset($error)) {
                      echo '<li class="error-li">
                              <div class="span-fp-error">' . $error . '</div>
                            </li>';
                    }
                  ?>
                </ul>
              </form>
            </div>
          </div><!-- log in wrapper end -->
          <!-- SignUp Section -->
          <div class="signup-wrapper">
             <?php include 'includes/signup-form.php' ?>
             <form method="post" autocomplete="off">
              <div class="signup-div">
                <h3>New user? Sign up </h3>
                <ul>
                  <li>
                      <input type="text" name="fullname" placeholder="Full Name"/>
                  </li>
                  <li>
                    <input type="text" name="username" placeholder="Username"/>
                  </li>
                  <li>
                    <input type="email" name="email" placeholder="Email"/>
                  </li>
                  <li>
                    <input type="password" name="password" placeholder="Password"/>
                  </li>
                  <li>
                    <input type="submit" name="signup" Value="Signup">
                  </li>
                  <?php
                      if (isset($signupError)) {
                        echo '<li class="error-li">
                        <div class="span-fp-error">' . $signupError . '</div>
                        </li>';
                      }
                  ?>
                </ul>

              </div>
            </form>
          </div>
          <!-- SIGN UP wrapper end -->
        </div><!-- content right ends -->
      </div><!-- main container end -->
    </div><!-- inner wrapper ends-->
  </div><!-- ends wrapper -->
</div>  
</body>
</html>
