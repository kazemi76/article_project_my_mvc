<?php

class Article
{

    private $db;
    public function __construct()
    {

        $this->db = new Database;
    }

    public function getArticle()
    {
        $this->db->query("SELECT * , articles.id as articleId ,
        users.id as usersId,
        articles.created_at as articleCreated,
        users.created_at as userCreated
         FROM articles
         INNER JOIN users
         ON articles.user_id=users.id
         ORDER BY articles.created_at DESC
         ");
        return $this->db->featchAll();
    }


    public function addArticle($data)
    {

        $this->db->query("INSERT INTO articles (title , user_id , text) VALUE(:title , :user_id , :text) ");

        $this->db->bind(':title', $data['title']);
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':text', $data['text']);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
    public function updateArticle($data)
    {
        $this->db->query("UPDATE articles SET title =:title, text=:text WHERE  id =:id ");

        $this->db->bind(':id', $data['id']);
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':text', $data['text']);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
    public function getArticleById($id)
    {

        $this->db->query('SELECT * FROM articles WHERE id=:id');
        $this->db->bind(':id', $id);
        $row = $this->db->featch();
        return $row;
    }

    public function deleteArticle($id){

        $this->db->query('DELETE FROM articles WHERE id=:id');
        $this->db->bind(':id', $id);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
