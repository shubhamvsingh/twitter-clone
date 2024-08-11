<!-- tweet.php -->
<?php  
  class Tweet extends Base {
    function __construct($pdo) {
      $this->pdo = $pdo;
    }
    public function tweets($user_id) {
      // Your code here ... 
      // Fetch tweets authored by user_id. Sorted by newest first. 
      // (You will need to do a JOIN query on users and tweets tables.
      // Store the result in $tweets

      $query = $this->pdo->prepare("SELECT * 
      FROM tweets a 
      JOIN users b ON a.user_id=b.user_id 
      WHERE a.user_id = :user_id 
      OR a.user_id IN (SELECT receiver FROM follow WHERE sender = :user_id) 
      ORDER BY a.created_at DESC
      ");
      $query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
      $query->execute();
      $tweets = $query->fetchAll(PDO::FETCH_OBJ);

      foreach ($tweets as $tweet) {
        echo '<div class="all-tweet">
            <div class="t-show-wrap">  
             <div class="t-show-inner">
              <div class="t-show-popup">
                <div class="t-show-head">
                  <div class="t-show-img">
                    <img src="'. $tweet->profileImage .'"/>
                  </div>
                  <div class="t-s-head-content">
                    <div class="t-h-c-name">
                      <span><a href="profile.php?username='. $tweet->username .'">'. $tweet->fullname .'</a></span>
                      <span>@'. $tweet->username .'</span>
                      <span>'. $tweet->created_at .'</span>
                    </div>
                    <div class="t-h-c-dis">
                      '. $tweet->tweet .'
                    </div>
                  </div>
                </div>
              </div>
              <div class="t-show-footer">
                <div class="t-s-f-right">
                  <ul> 
                    <li><button><a href="#"><i class="fa fa-retweet" aria-hidden="true"></i></a></button></li>
                    <li><button><a href="#"><i class="fa fa-heart-o" aria-hidden="true"></i></a></button></li>
                      <li>
                      <a href="#" class="more"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
            </div>
          </div>';
      }
    }
    public function countTweets($user_id) {
      // Your code here ... 
      // echo count of number of tweets by user user_id. 
      $query = $this->pdo->prepare("SELECT * FROM tweets WHERE user_id = :user_id");
      $query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
      $query->execute();
      $count = $query->rowCount();
      echo $count;
    }

    public function getUserTweets($user_id) {
        $query = $this->pdo->prepare("SELECT a.*, b.* FROM tweets a JOIN users b ON a.user_id=b.user_id WHERE a.user_id = :user_id ORDER BY a.created_at DESC");
        $query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $query->execute();

        $tweets = $query->fetchAll(PDO::FETCH_OBJ);
        return $tweets;
    }
  }
?>