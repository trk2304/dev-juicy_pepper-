CREATE TABLE comments (
    article_id INT,
    comment_id INT NOT NULL,
    name VARCHAR(255),
    body TEXT,
    posted_on TIMESTAMP NOT NULL,
    CONSTRAINT PK_comment_id PRIMARY KEY (comment_id),
    CONSTRAINT FK_article_id FOREIGN KEY (article_id)
        REFERENCES post(article_id)
);

/* Writing a query to get the two most recent posts for the features on index.php*/

SELECT article_id, article_title, date
    FROM post
    ORDER BY date DESC LIMIT 2;

ALTER TABLE comments
    DROP FOREIGN KEY FK_article_id;

ALTER TABLE comments
    ADD CONSTRAINT FK_article_id FOREIGN KEY (article_id)
    REFERENCES post(article_id)
    ON DELETE CASCADE;