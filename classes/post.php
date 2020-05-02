<?php

require_once('mysql.inc.php');

/**
 * This class is meant to follow the PHP CRUD Model
 * CRUD = CReate, Update, Delete
 */
class Post {
    
    private $db = null;
    private $id = null;
    private $title = null;
    private $content = null;
    private $date = null;

    public function __construct() {
        $this->db = new myConnectDB();
    }

    /**
     * This should add to the posts database every time the admin writes a new post.
     * 
     * Steps include filtering form input, making the query to insert into the database, and returning true if successful, false if not.
     */
    public function insertPost($name, $content) {
        
        $name = filter_var($name, FILTER_SANITIZE_STRING);
        $content = filter_var($content, FILTER_SANITIZE_STRING);

        $sql = "INSERT INTO post (article_title, article_content) VALUES (?, ?)";
        $stmt = $this->db->stmt_init();
        $stmt->prepare($sql);
        $stmt->bind_param('ss', $name, $content);
        $success = $stmt->execute();
        $stmt->close();

        if(!$success || $this->db->affected_rows == 0) {
            echo "There was an error with query $sql";
            $db = $this->db;
            echo "The error is $db->error";
            return false;
        }

        return true;
    }

    /**
     * Update a post by sanitizing title and content,
     * making a SQL query, and executing it.
     * Return true if successful, false if not.
     */
    public function updatePost($name, $content, $id) {
        
        $name = filter_var($name, FILTER_SANITIZE_STRING);
        $content = filter_var($content, FILTER_SANITIZE_STRING);

        $sql = "UPDATE post SET article_title = ?, article_content = ? WHERE article_id = ?";
        $stmt = $this->db->stmt_init();
        $stmt->prepare($sql);
        $stmt->bind_param('ssi', $name, $content, $id);
        $success = $stmt->execute();
        $stmt->close();

        if(!$success || $this->db->affected_rows == 0) {
            echo "There was an error with query $sql";
            echo "The error is $stmt->error";
            return false;
        }
        return true;
    }

    /**
     * Delete a post given an article id number.
     * Query, execute, return true if successful.
     */
    public function deletePost($id) {
        $sql = "DELETE FROM post WHERE article_id = ?";

        $stmt = $this->db->stmt_init();
        $stmt->prepare($sql);
        $stmt->bind_param("i", $id);
        $success = $stmt->execute();

        if(!$success || $this->db->affected_rows == 0) {
            echo "There was an error with query $sql";
            echo "The error is $stmt->error";
            return false;
        }

        return true;
    }

    /**
     * Return an array containing a Post Title and Post Content
     * 
     * Query the database.
     * Create a new array.
     * Assign results from the query to the array.
     * Return the array.
     */
    public function getPost($id) {
        
        $sql = "SELECT article_title, article_content, date FROM post WHERE article_id = ?";
        
        $stmt = $this->db->stmt_init();
        $stmt->prepare($sql);
        $stmt->bind_param('i', $id);
        $success = $stmt->execute();

        $stmt->store_result();



        if( !$success || $stmt->num_rows == 0 ) {
            echo "There was an error with query $sql";
            echo "The error is $stmt->error";
            return false;
        }

        $stmt->bind_result($title, $content, $date);

        $result = array();

        while($stmt->fetch()) {
            $result['title'] = $title;
            $result['content'] = $content;
            $result['id'] = $id;
            $result['date'] = $date;
        }

        return $result; 
    }

    /**
     * Returns the 2 most recent blog posts
     */
    public function getMostRecentTwo() {
        $sql = "SELECT article_id, article_title, article_content, date
        FROM post
        ORDER BY date DESC LIMIT 2";

        $stmt = $this->db->stmt_init();
        $stmt->prepare($sql);
        $success = $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($article_id, $article_title, $article_content, $date);
        
        $result = array();

        $i = 0;
        while($stmt->fetch()) {
            $result[$i]['id'] = $article_id;
            $result[$i]['title'] = $article_title;
            $result[$i]['content'] = $article_content;
            $result[$i]['date'] = $date;
            $i += 1;
        }

        return $result;
    }

    /**
     * This is a STATIC function of the Post Class which allows the user to 
     * return all rows of the post table.
     */
    public static function getAllPosts() {
        $sql = "SELECT article_id, article_title, article_content, date FROM post ORDER BY date DESC";
    
        $db = new myConnectDB();
        $stmt = $db->stmt_init();
        $stmt->prepare($sql);
        $success = $stmt->execute();
        $stmt->store_result();

        if(!$success || $stmt->num_rows == 0) {
            echo "There was an error with query *$sql*";
            echo "Ther error is *$db->error*";
        }

        $stmt->bind_result($id, $title, $content, $date);

        $result = array(); 

        // Allows for organized indices for each row of the table.
        $i = 0;
        while($stmt->fetch()) {
            $result[$i]['id'] = $id;
            $result[$i]['title'] = $title;
            $result[$i]['content'] = $content;
            $result[$i]['date'] = $date;
            $i += 1;
        }

        // I'm missing a blog post when I make the call to get all blog posts. Not sure why... but I need to figure this out.

        return $result;
    }

}

?>