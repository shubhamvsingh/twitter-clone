<!-- login.php -->
<?php

    if(isset($_POST['login'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        if(empty($email) || empty($password)) {
            $error = "Please enter email and password!";
        }

        else {
            $email = $getFromU->checkInput($email);
            $password = $getFromU->checkInput($password);

            if(!$getFromU->checkEmail($email)) {
                $error = "Invalid Email format";
            }

            // check if user exists in users table
            else  {
                if (!$getFromU->login($email, $password)) {
                    $error = "Invalid username or password";
                }
            }

        }
    }

?>
