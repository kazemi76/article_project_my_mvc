<?php
Class Pages extends Controller{

    public function __construct(){

    }
    public function index(){
        // $this->model('articel')
        $data=[
            'title'=>'hello'
        ];
        $this->view('pages/index/', $data);

    }

    public function about(){
        // $this->model('articel')
        $data=[
            'title'=>'hello'
        ];
        $this->view('pages/about/', $data);

    }
}