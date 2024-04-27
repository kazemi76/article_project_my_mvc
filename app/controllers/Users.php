<?php

class Users extends Controller
{

    private $userModel;

    public function __construct()
    {
        $this->userModel = $this->model('User');
    }

    public function register()
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'name_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];

            if (empty($data['name'])) {
                $data['name_err'] = 'لطفا نام را وارد کنید';
            }
            if (empty($data['email'])) {
                $data['email_err'] = 'لطفا ایمیل را وارد کنید';
            } else {

                if ($this->userModel->findUserByEmail($data['email'])) {

                    $data['email_err'] = 'ایمیل قبلا ثبت شده است';
                }
            }
            if (empty($data['password'])) {
                $data['password_err'] = 'لطفا پسورد را وارد کنید';
            } elseif (strlen($data['password']) < 6) {
                $data['password_err'] = 'پسورد باید بیشتر از 6 کاراکتر باشد';
            }
            if (empty($data['confirm_password'])) {
                $data['confirm_password_err'] = 'لطفا پسورد را تکرار کنید';
            } elseif ($data['confirm_password'] != $data['password']) {
                $data['confirm_password_err'] = 'تکرار پسورد با پسورد مطابقت ندارد';
            }

            if (
                empty($data['name_err'])
                && empty($data['email_err'])
                && empty($data['password_err'])
                && empty($data['confirm_password_err'])
            ) {


                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                if ($this->userModel->register($data)) {

                    flash('regester success', 'ثبت نام باموفقیت انجام شد');
                    redirect('users/login');
                } else {
                    die('Errore REgisteration');
                }
            } else {
                $this->view('users/register', $data);
            }
        } else {

            $data = [
                'name' => '',
                'email' => '',
                'password' => '',
                'confirm_password' => '',
                'name_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];
            $this->view('users/register', $data);
        }
    }

    public function login()
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'email_err' => '',
                'password_err' => '',
            ];

            if (empty($data['email'])) {
                $data['email_err'] = 'لطفا ایمیل را وارد کنید';
            }
            if ($this->userModel->findUserByEmail($data['email'])) {
            } else {
                $data['email_err'] = 'چنین کاربری پیدا نشد';
            }


            if (empty($data['password'])) {
                $data['password_err'] = 'لطفا پسورد را وارد کنید';
            }

            if (
                empty($data['email_err'])
                && empty($data['password_err'])
            ) {

                $loggedInUser = $this->userModel->login($data);
                if ($loggedInUser) {
                   $this->createUserSession($loggedInUser);
                    
                } else {
                    $data['password_err'] = 'پسورد را اشتباه وارد کرده اید';
                    $this->view('users/login', $data);
                }
            } else {
                $this->view('users/login', $data);
            }
        } else {

            $data = [
                'email' => '',
                'password' => '',
                'email_err' => '',
                'password_err' => '',
            ];
            $this->view('users/login', $data);
        }
    }
    public function createUserSession($user){

        $_SESSION['user_id']=$user->id;
        $_SESSION['user_email']=$user->email;
        $_SESSION['user_name']=$user->name;

        redirect('articles');

    }

    public function logout(){
        $_SESSION['user_id'];
        $_SESSION['user_email'];
        $_SESSION['user_name'];
        session_destroy();
        redirect('users/login');


    }
}
