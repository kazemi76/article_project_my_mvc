<?php
class User{

    private $db;
    public function __construct(){
        $this->db= new Database();
    }


    public function findUserByEmail($email){
        
        $this->db->query('SELECT * FROM users WHERE email=:email');

        $this->db->bind(':email',$email);

        $this->db->featch();


        if($this->db->rowCount()> 0){
            return true;

        }else{

            return false;
        }
        
        
    }
    public function register($data){
        $this->db->query('INSERT INTO users (name,email,password) VALUE (:name , :email, :password)');

        $this->db->bind(':email',$data['email']);
        $this->db->bind(':name',$data['name']);
        $this->db->bind('password',$data['password']);

        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function login($data){
        
        $this->db->query('SELECT * FROM users WHERE email=:email');

        $this->db->bind(':email',$data['email']);

        $row=$this->db->featch();

        $hash_password=$row->password;

        if(password_verify($data['password'] ,$hash_password)){
            return $row;

        }else{

            return false;
        }
        
        
    }
    public function getUserById($id)
    {

        $this->db->query('SELECT * FROM users WHERE id=:id');
        $this->db->bind(':id', $id);
        $row = $this->db->featch();
        return $row;
    }
}