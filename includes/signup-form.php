<!-- signup-form.php -->
<?php 
    if(isset($_POST['signup'])) {
        $fullname = $_POST['fullname'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        // check if all inputs are not empty
        if(empty($fullname) || empty($username) || empty($email) || empty($password)) {
            $signupError = 'Please enter email and password!';
        }

        else {
            $fullname = $getFromU->checkInput($fullname);
            $username = $getFromU->checkInput($username);
            $email = $getFromU->checkInput($email);
            $password = $getFromU->checkInput($password);

            if(!$getFromU->checkEmail($email)) {
                $signupError = 'Invalid Email format';
            } 

            else if(!(strlen($fullname) < 20 && strlen($username) < 20)) {
                $signupError = 'Name must be between 6-20 characters';
            }

            else if(strlen($password) < 5) {
                $signupError = 'Password too short';
            }

            else if($getFromU->checkUserEmail($email)) {
                $signupError = 'Email already registered';
            }

            else if($getFromU->checkUsername($username)) {
                $signupError = 'Username already exists';
            }

            else {
                $user_id = $getFromU->create('users', 
                array(
                    'username' => $username, 
                    'email' => $email, 
                    'password' => md5($password), 
                    'fullname' => $fullname,
                    'profileImage' => 'assets/images/defaultprofile1.png',
                    'following' => 0,
                    'followers' => 0
                ));

                $_SESSION['user_id'] = $user_id;
                header("Location: home.php");
            }

        }
    }
?>
