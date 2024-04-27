<?php

class Articles extends Controller
{


    protected $articleModel;
    protected $userModel;
    public function __construct()
    {
        $this->articleModel = $this->model('Article');
        $this->userModel = $this->model('User');
        if (!isLoggedIn()) {
            redirect("users/login");
        }
    }


    public function index()
    {
        $articles = $this->articleModel->getArticle();
        $data = [
            'articles' => $articles
        ];
        $this->view('articles/index', $data);
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'title' => trim($_POST['title']),
                'text' => trim($_POST['text']),
                'user_id' => $_SESSION['user_id'],
                'titel_err' => '',
                'text_err' => ''
            ];

            if (empty($data['title'])) {

                $data['title_err'] = 'عنوان الزامی است';
            }
            if (empty($data['text'])) {

                $data['text_err'] = 'متن الزامی است';
            }

            if (empty($data['text_err']) && empty($data['title_err'])) {

                if ($this->articleModel->addArticle($data)) {

                    flash('article_message', 'ثبت مقاله باموفقیت انجام شد');
                    redirect('articles/index');
                } else {
                    flash('article_message', 'ثبت مقاله انجام نشد', 'alert alert-danger');
                    redirect('articles/add');
                }
            } else {
                $this->view('articles/add', $data);
            }
        } else {
            $data = [
                'title' => '',
                'text' => '',
                'titel_err' => '',
                'text_err' => ''
            ];
            $this->view('articles/add', $data);
        }
    }
    public function show($id)
    {

        $article = $this->articleModel->getArticleById($id);
        $user = $this->userModel->getUserById($article->user_id);

        $data = [
            'article' => $article,
            'user' => $user,
        ];

        $this->view('articles/show', $data);
    }

    public function edit($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'id' => $id,
                'title' => trim($_POST['title']),
                'text' => trim($_POST['text']),
                'user_id' => $_SESSION['user_id'],
                'titel_err' => '',
                'text_err' => ''
            ];

            if (empty($data['title'])) {

                $data['title_err'] = 'عنوان الزامی است';
            }
            if (empty($data['text'])) {

                $data['text_err'] = 'متن الزامی است';
            }

            if (empty($data['text_err']) && empty($data['title_err'])) {

                if ($this->articleModel->updateArticle($data)) {

                    flash('article_message', 'ویرایش مقاله باموفقیت انجام شد');
                    redirect('articles/index');
                } else {
                    // flash('article_message', 'ویرایش مقاله انجام نشد','alert alert-danger');
                    // redirect('articles/');
                    die('update error');
                }
            } else {
                $this->view('articles/edit', $data);
            }
        } else {
            $article = $this->articleModel->getArticleById($id);
            if ($article->user_id != $_SESSION['user_id']) {
                redirect('articles/index');
            }

            $data = [
                'id' => $id,
                'title' => $article->title,
                'text' =>  $article->text,
                'title_err' => '',
                'text_err' => ''
            ];
            $this->view('articles/edit', $data);
        }
    }
    public function delete($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $article = $this->articleModel->getArticleById($id);
            if ($article->user_id != $_SESSION['user_id']) {
                redirect('articles/index');
            }
            if ($this->articleModel->deleteArticle($id)) {
                flash('article_message', 'حذف مقاله باموفقیت انجام شد');
                redirect('articles/index');
            } else {
                flash('article_message', 'حذف مقاله انجام نشد','alert alert-danger');
                redirect('articles/index');
            }
        } else {
            redirect('articles/index');
           
        }
    }
}
