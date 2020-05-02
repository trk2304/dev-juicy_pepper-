<?php

/**
 * Class to handle blog posts (Articles)
*/

class Article {

    // Properties

    /**
     * var int The article ID from the database
     */

    private $id = null;
    
    /**
     * string: The full title of the article 
     */

    private $title = null;

    /**
     * int: WHen the article was published
     */
    private $publicationDate = null;

     /**
      * string: A short summary of the article
      */
    
    private $summary = null;

    /**
     * string: The HTML content of the article
     */
    private $content = null;

    /**
     * Constructor
     */
    public function __construct( $data = array() ) {
        if ( isset($data['id']) )
            $this->id = (int) $data['id'];
        if ( isset($data['publicationDate']) )
            $this->publicationDate = (int) $data['publicationDate'];
        if ( isset($data['title']) ) 
            $this->title = preg_replace("/[^\.\,\-\_\'\"\@\?\!\:\$ a-zA-Z0-9()]/", "", $data['title']);
        if ( isset($data['summary']) )
            $this->summary = preg_replace("/[^\.\,\-\_\'\"\@\?\!\:\$ a-zA-Z0-9()]/", "", $data['title']);
        if ( isset($data['content']) )
            $this->content = $data['content'];
    }

    /**
     * Sets the object's properties using the edit form post values in the supplied array
     * 
     * @param assoc The form post values
     */

    public function storeFormValues( $params ) {
        // Store all the parameters
        $this->__construct($params);

        // Parse and store the publication date
        if ( isset($params['publicationDate']) ) {
            $publicationDate = explode('-', $params['publicationDate']);

            if( count($publicationDate) == 3 ) {
                $this->publicationDate = mktime(0,0,0, $m, $d, $y);
            }
        }
    }

    /**
     * Returns an Article object matching the given article ID
     * 
     * @param int The Article ID
     * @return Article|false The article object, or flasae if the record was not found or there was a problem.
     * 
     */
    public static function getById( $id ) {
        $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
        $sql = "SELECT *, UNIX_TIMESTAMP(publicationDate) AS publicationDate FROM articles WHERE id = :id";
        $st = $conn->prepare($sql);
        $st->bindValue( ":id", $id, PDO::PARAM_INT );
        $st->execute();
        $row = $st->fetch();
        $conn = null;
        if ( $row ) {
            return new Article( $row );
        }
        return false;
    }

    /**
     * Return all (or range of) Article objects in the DB
     * 
     * @param int Optional The Numer of rows to return (default=all)
     * @return Array|false A two-element array: results=>Array,  a list of Article objects; totalRows=> Total number of articles
     * 
     */
    public static function getList( $numRows=1000000 ) {
        $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
        $sql = "SELECT SQL_CALC_FOUND_ROWS *, UNIX_TIMESTAMP(publicationDate) AS publicationDate FROM articles ORDER BY publicationDate DESC LIMIT :numRows";
        $st = $conn->prepare($sql);
        $st->bindValue(":numRows", $numRows, PDO::PARAM_INT);
        $st->execute();
        $list = array();

        while( $row = $st->fetch() ) {
            $article = new Article( $row );
            $list[] = $article;
        }
        
        $sql = "SELECT FOUND_ROWS() AS totalRows";
        $totalRows = $conn->query( $sql )->fetch();
        $conn = null;
    
        return ( array("results"=>$list, "totalRows"=>$totalRows[0]) );

    }

    /**
     * Insert an article object into the database and set its ID property.
     *  
     */
    public function insert() {
        if ( !is_null( $this->id ) ) trigger_error ( "Article::insert(): Attempt to insert an Article object that already has its ID property set (to $this->id).", E_USER_ERROR );

        // Insert the Article
        $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
        $sql = "INSERT INTO articles (publicationDate, title, summary, content) VALUES (FROM_UNIXTIME(:publicationDate), :title, :summary, :content )";
        $st = $conn->prepare($sql);
        $st->bindValue(":publicationDate", $this->publicationDate, PDO::PARAM_INT );
        $st->bindValue(":title", $this->title, PDO::PARAM_STR);
        $st->bindValue(":summary", $this->summary, PDO::PARAM_STR);
        $st->bindValue(":content", $this->content, PDO::PARAM_STR);
        $st->execute();
        $this->id = $conn->lastInsertId();
        $conn = null;
    }

    /**
     * Updates this Article object int the database.
     */
    public function update() {
        if ( is_null( $this->id ) ) trigger_error ( "Article::update(): Attempt to update an Article object that does not have its ID property set.", E_USER_ERROR );

        // Update the article
        $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
        $sql="UPDATE articles SET publicationDate=FROM_UNIXTIME(:publicationDate), title=:title, summary=:summary, content=:content WHERE id=:id";
        $st = $conn->prepare($sql);
        $st->bindValue(":publicationDate", $this->publicationDate, PDO::PARAM_INT);
        $st->bindValue(":title", $this->title, PDO::PARAM_STR);
        $st->bindValue(":summary", $this->content, PDO::PARAM_STR);
        $st->bindValue(":content", $this->content, PDO::PARAM_STR);
        $st->bindValue(":id", $this->id, PDO::PARAM_INT);
        $st->execute();
        $conn = null;
    }

    /**
     * Deletes the current Article Object from the database.
     */
    public function delete() {
        if ( is_null( $this->id ) ) trigger_error ( "Article::delete(): Attempt to delete an Article object that does not have its ID property set.", E_USER_ERROR );

        // Delete the Article
        $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
        $st = $conn->prepare("DELETE FROM articles WHERE id = :id LIMIT 1");
        $st->bindValue(":id", $this->id, PDO::PARAM_INT);
        $st->execute();
        $conn = null;
    
    }
}
     
?>