<?php

Class Article extends Controller{


    protected $articleModel;
    public function __construct(){
    $this->articleModel= $this->model('Article');

    }
  

    public function index(){
        $articles=$this->articleModel->getArticle();
        $data=[
            'title'=>'hello',
            'articles'=>$articles
        ];
        $this->view('pages/index', $data);

    }

    public function about(){
        // $this->model('articel')
        $data=[
            'title'=>'hello'
        ];
        $this->view('pages/about', $data);

    }
}