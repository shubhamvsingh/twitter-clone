<!-- follow.php -->
<?php

class Follow extends Base {
    function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function displayBtn($user_id, $profileId) {
        if ($user_id == $profileId) {
            echo "";
        } elseif ($this->checkFollow($user_id, $profileId) === true) {
            // unfollow
            echo '<span>You are following this user. </span>';
            echo '<input type="submit" style="color: #FFFFFF; font-weight: bold; background-color: #d10000"  name="unfollow" value="Unfollow"/>';
        }
        else {
            // follow
            echo '<input type="submit" style="color: #FFFFFF; font-weight: bold; background-color: #006eb7"  name="follow" value="Follow"/>';
        }
    }

    public function checkFollow($user_id, $profileId) {
        $query = $this->pdo->prepare("SELECT * FROM follow WHERE sender = :user_id and receiver = :profileId");
        $query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $query->bindParam(':profileId', $profileId, PDO::PARAM_INT);
        $query->execute();

        $rows = $query->rowCount();
        if($rows != 0) {
            // user follows profile
            return true;
        }

        return false;
    }

    public function followUser($user_id, $profileId) {
        // add a record in follow table
        $query1 = $this->pdo->prepare("INSERT INTO follow (sender, receiver) VALUES(:user_id, :profileId)");
        $query1->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $query1->bindParam(':profileId', $profileId, PDO::PARAM_INT);
        $query1->execute();

        // increment following of user_id by 1
        $query2 = $this->pdo->prepare("UPDATE users SET following = following + 1 WHERE user_id = :user_id");
        $query2->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $query2->execute();

        // increment follower of profileId by 1
        $query3 = $this->pdo->prepare("UPDATE users SET followers = followers + 1 WHERE user_id = :profileId");
        $query3->bindParam(':profileId', $profileId, PDO::PARAM_INT);
        $query3->execute();
    }

    public function unfollowUser($user_id, $profileId) {
        // remove record in follow table
        $query1 = $this->pdo->prepare("DELETE FROM follow WHERE sender = :user_id AND receiver = :profileId");
        $query1->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $query1->bindParam(':profileId', $profileId, PDO::PARAM_INT);
        $query1->execute();

        // decrement following of user_id by 1
        $query2 = $this->pdo->prepare("UPDATE users SET following = following - 1 WHERE user_id = :user_id");
        $query2->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $query2->execute();

        // decrement follower of profileId by 1
        $query3 = $this->pdo->prepare("UPDATE users SET followers = followers - 1 WHERE user_id = :profileId");
        $query3->bindParam(':profileId', $profileId, PDO::PARAM_INT);
        $query3->execute();
    }
}

?>