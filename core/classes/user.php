<!-- user.php -->
<?php 
class User extends Base {
    function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function checkInput($var) {
        $var = htmlspecialchars($var);
        $var = stripslashes($var);
        $var = trim($var);

        return $var;
    }

    public function checkEmail($email) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true; // email format is valid
        }

        return false;
    }

    // check if a email already exists
    public function checkUserEmail($email) {
        $query = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");
        $query->bindParam(":email", $email, PDO::PARAM_STR);
        $query->execute();

        $user = $query->fetch(PDO::FETCH_OBJ);
        $row = $query->rowCount();

        if($row == 0) {
            return false; // email not found
        }

        return true;
    }

    // check if username already exists
    public function checkUsername($username) {
        $query = $this->pdo->prepare("SELECT * FROM users WHERE username = :username");
        $query->bindParam(":username", $username, PDO::PARAM_STR);
        $query->execute();

        $user = $query->fetch(PDO::FETCH_OBJ);
        $row = $query->rowCount();

        if($row == 0) {
            return false; // username not found
        }

        return true;
        
    }

    public function login($email, $password) {
        $query = $this->pdo->prepare("SELECT * FROM users WHERE email = :email AND password = :password");
        $query->bindParam(":email", $email, PDO::PARAM_STR);
        $hash = md5($password);
        $query->bindParam(":password", $hash, PDO::PARAM_STR);
        $query->execute();

        $user = $query->fetch(PDO::FETCH_OBJ);
        $row = $query->rowCount();

        if($row == 0) {
            return false; // user not found
        }

        // $_SESSION['username'] = $user->username;
        $_SESSION['user_id'] = $user->user_id;
        header("Location: home.php");
    }

    public function userData($user_id) {
        $query = $this->pdo->prepare("SELECT * FROM users WHERE user_id = :user_id");
        $query->bindParam(":user_id", $user_id, PDO::PARAM_INT);
        $query->execute();

        $user = $query->fetch(PDO::FETCH_OBJ);
        return $user;
    }

    public function logout() {
        session_destroy();
        header('Location: '. BASE_URL .'index.php');
    }

    // check if session variable is set or not
    public function loggedIn() {
        if(isset($_SESSION['user_id'])) {
            return true;
        }
        return false;
    }

    public function userIdByUsername($username) {
        $query = $this->pdo->prepare("SELECT user_id FROM users WHERE username = :username");
        $query->bindParam(':username', $username, PDO::PARAM_STR);
        $query->execute();

        $user = $query->fetch(PDO::FETCH_OBJ);
        return $user->user_id;
    }

    public function searchByUsername($username) {
        $query = $this->pdo->prepare("SELECT * FROM users WHERE username = :username");
        $query->bindParam(':username', $username, PDO::PARAM_STR);
        $query->execute();

        $row = $query->rowCount();
        if($row > 0) {
            // found the user
            return BASE_URL.'profile.php?username='.$username;
        }

        // redirect to index page if no user found
        return 'index.php';
    }

}
?>
