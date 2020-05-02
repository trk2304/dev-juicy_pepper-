<?PHP

require_once('mysql.inc.php');

class Comment {

    private $db = null;

    /**
     * Constructor. Just initiates the database member
     */
    public function __construct() {
        $this->db = new myConnectDB();
    }

    /**
     * Adds comment to the database. Takes in an article id (for which post the comment is going to), a name for the comment's author,
     * and the comment's content.
     */
    public function addComment($article_id, $user, $content) {
        $sql = "
            INSERT INTO comments (article_id, name, body) VALUES (?, ?, ?)
        "; 

        //Remove HTML Tags From Strings
        $user = filter_var($user, FILTER_SANITIZE_STRING);
        $content = filter_var($content, FILTER_SANITIZE_STRING);

        //Prepare the query
        $stmt = $this->db->stmt_init();
        $stmt->prepare($sql);
        $stmt->bind_param('iss', $article_id, $user, $content);
        $success = $stmt->execute();

        if(!$success || $this->db->affected_rows == 0) {
            echo "Hmmm. Inserting comment went wrong. Check your query.";
            echo "Here's the error: " . $this->db->error;
            return false;
        }
        
        return true;
    }

    /**
     * Returns an array of all comments pertaining to at particular blog post.
     */
    public function getCommentsById($article_id) {
        $sql = "SELECT comment_id, name, body, posted_on FROM comments WHERE article_id = ? ORDER BY posted_on DESC";
        
        $stmt = $this->db->stmt_init();
        $stmt->prepare($sql);
        $stmt->bind_param('i', $article_id);
        $success = $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($comment_id, $user, $content, $date);


        if(!$success || $stmt->num_rows < 0) {
            echo "Hmmm. Getting comments by id went wrong. Check your query. \n";
            echo "Here's the error: " . $stmt->error;
            return false;
        }

        // Now get all of your results organized and ready to send off.
        $result = array();

        $i = 0;
        while($stmt->fetch()) {
            $result[$i]['id'] = $comment_id;
            $result[$i]['name'] = $user;
            $result[$i]['content'] = $content;
            $result[$i]['date'] = $date;
            $i++;
        }

        return $result;
    }

    /**
     * Allows admin to delete comments by comment_id
     */
    public function deleteByCommentId($comment_id) {
        $sql = "DELETE FROM comments WHERE comment_id = ?";
        
        $stmt = $this->db->stmt_init();
        $stmt->prepare($sql);
        $stmt->bind_param('i', $comment_id);
        $success = $stmt->execute();

        if(!$success || $this->db->affected_rows == 0) {
            echo "There was an error with deleting that comment.";
            echo "Here's the error: " . $this->db->error;
            return false;
        }
        return true;
    }

    /**
     * Admin is able to delete comments by id
     */
    public function deleteCommentById($comment_id) {
        $sql = "DELETE FROM comments WHERE comment_id = ?";

        $stmt = $this->db->stmt_init();
        $stmt->prepare($sql);
        $stmt->bind_param("i", $comment_id);
        $success = $stmt->execute();

        if(!$success || $this->db->affected_rows == 0) {
            echo "There was an error with query $sql";
            echo "The error is $stmt->error";
            return false;
        }

        return true;
    }

    /**
     * This is a STATIC function of the Post Class which allows the user to 
     * return all rows of the comment table.
     */
    public static function getAllComments() {
        $sql = "SELECT article_id, comment_id, name, body, posted_on FROM comments ORDER BY posted_on DESC";
    
        $db = new myConnectDB();
        $stmt = $db->stmt_init();
        $stmt->prepare($sql);
        $success = $stmt->execute();
        $stmt->store_result();

        if(!$success || $stmt->num_rows == 0) {
            echo "There was an error with query *$sql*";
            echo "Ther error is *$db->error*";
        }

        $stmt->bind_result($article_id, $comment_id, $name, $content, $date);

        $result = array(); 

        // Allows for organized indices for each row of the table.
        $i = 0;
        while($stmt->fetch()) {
            $result[$i]['article_id'] = $article_id;
            $result[$i]['comment_id'] = $comment_id;
            $result[$i]['name'] = $name;
            $result[$i]['content'] = $content;
            $result[$i]['date'] = $date;
            $i += 1;
        }

        // I'm missing a blog post when I make the call to get all blog posts. Not sure why... but I need to figure this out.

        return $result;
    }

}


?>