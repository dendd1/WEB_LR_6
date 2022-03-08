<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;

class MainController extends BaseController
{
    private DbController $db;

    public function __construct()
    {
        $this->db = new DbController();
        session_start();
    }
    function get_info_main_page(): array
    {
        $dbh = $this->db->connectToDatabase();
        $best_3_rev = $this->db->get_3_reviews_best($dbh);
        $best_10_rev =$this->db->get_10_reviews_best_comm($dbh);
        $new_10_rev = $this->db->get_10_reviews_new($dbh);
        $bestes_10_rev = $this->db->get_10_reviews_bestes($dbh);
        $rec_4_rev = $this->db->get_4_reviews_rec($dbh);
        $news_4 = $this->db->get_4_news($dbh);
        $info_main_page = [
            'best_3_rev' => $best_3_rev,
            'best_10_rev' => $best_10_rev,
            'new_10_rev' => $new_10_rev,
            'bestes_10_rev' => $bestes_10_rev,
            'rec_4_rev' => $rec_4_rev,
            'news_4' => $news_4
        ];
        return $info_main_page;
    }
    public function show_main_page(): Response
    {
        $main_page = $this->get_info_main_page();
        return $this->renderTemplate('main_page.php', $main_page);
    }
    public function show_catalog_rev(): Response
    {
        $dbh = $this->db->connectToDatabase();
        $catalog_rev = $this->db->get_catalog_rev($dbh);
        $catalog_rev_page = [
            'catalog_rev' => $catalog_rev
        ];
        return $this->renderTemplate('catalog_rev.php', $catalog_rev_page);
    }
    public function show_catalog_news(): Response
    {
        $dbh = $this->db->connectToDatabase();
        $catalog_news = $this->db->get_catalog_news($dbh);
        $catalog_news_page = [
            'catalog_news' => $catalog_news
        ];
        return $this->renderTemplate('catalog_news.php', $catalog_news_page);
    }
    public function check_auth_user(): Response
    {
        if (!isset($_POST['login'])) {
            $main_page = $this->get_info_main_page();
            return $this->renderTemplate('main_page.php', $main_page);
        }
        else {
            $login = $_POST['login'];
            $pass = $_POST['pass'];
            $dbh = $this->db->connectToDatabase();
            $potential_user = $this->db->check_auth_user($dbh, $login, $pass);
            if ($potential_user['status']) {
                $_SESSION['user'] = [
                    "status" => $potential_user['status'],
                    "id" => $potential_user['id'],
                    "login" => $login,
                    "password" => $pass,
                    "phone" => $potential_user['phone'],
                    "nik" => $potential_user['nik'],
                    "mail" => $potential_user['mail']
                ];
            } else {
                $_SESSION['user'] = [
                    "status" => $potential_user['status']
                ];
            }
            return $this->renderTemplate('priem_ajax.php', $_SESSION['user']);
        }
    }
    public function out_user(): Response
    {
        if (!isset($_SESSION['user']['login'])) {
            $main_page = $this->get_info_main_page();
            return $this->renderTemplate('main_page.php', $main_page);
        }
        else {
            $dbh = $this->db->connectToDatabase();
            $status = $this->db->out_user($dbh, $_SESSION['user']['id']);
            unset($_SESSION['user']);
            unset($_SESSION['pointer_review']);
            unset($_SESSION['pointer_news']);
            unset($_SESSION['dowland_img_rev']);// или $_SESSION = array() для очистки всех данных сессии
            unset($_SESSION['dowland_img_news']);
            session_destroy();
            return $this->renderTemplate('header.php', $status);
        }
    }
    public function show_account_page()
    {
        $dbh = $this->db->connectToDatabase();
        if (!isset($_SESSION['user']['login'])){
            $main_page = $this->get_info_main_page();
            return $this->renderTemplate('main_page.php', $main_page);
        }
        else
        {
            $lk_info_count = $this->db->get_lk_info_count($dbh, $_SESSION['user']['login']);
            $lk_users_rev = $this->db->get_users_lk_rev($dbh, $_SESSION['user']['login']);
            $lk_users_news= $this->db->get_users_lk_news($dbh, $_SESSION['user']['login']);
            $account_page = [
                "status" =>  $_SESSION['user']['status'],
                "id" => $_SESSION['user']['id'],
                "login" => $_SESSION['user']['login'],
                "password" =>$_SESSION['user']['password'],
                "phone" => $_SESSION['user']['phone'],
                "nik" => $_SESSION['user']['nik'],
                "mail" => $_SESSION['user']['mail'],
                "lk_info_count" => $lk_info_count,
                "lk_users_rev" => $lk_users_rev,
                "lk_users_news" => $lk_users_news
            ];
            return $this->renderTemplate('account_page.php', $account_page);
        }
    }
    public function check_review_one(): Response
    {
        $dbh = $this->db->connectToDatabase();
        if (!isset($_POST['id'])) {
            $main_page = $this->get_info_main_page();
            return $this->renderTemplate('main_page.php', $main_page);
        }
        else
        {
            $rev_one_info = $this->db->get_one_rev_info($dbh, $_POST['id']);
            $rev_one_comments = $this->db->get_one_rev_comments($dbh, $_POST['id']);
            $check_review_one = [
                "status" =>  1
            ];
            $_SESSION['pointer_review'] = [
                "info" => $rev_one_info,
                "comments" => $rev_one_comments
            ];
            return $this->renderTemplate('one_review_priem.php', $check_review_one);
        }
    }
    public function show_review_one(): Response
    {
        $dbh = $this->db->connectToDatabase();
        if (!isset($_SESSION['pointer_review'])) {
            $main_page = $this->get_info_main_page();
            return $this->renderTemplate('main_page.php', $main_page);
        }
        else
        {
            $rev_one_info = $this->db->get_one_rev_info($dbh, $_SESSION['pointer_review']['info']['id']);
            $rev_one_comments = $this->db->get_one_rev_comments($dbh, $_SESSION['pointer_review']['info']['id']);
            $_SESSION['pointer_review'] = [
                "info" => $rev_one_info,
                "comments" => $rev_one_comments
            ];
            return $this->renderTemplate('one_review.php', $_SESSION['pointer_review']);
        }
    }
    public function check_news_one(): Response
    {
        $dbh = $this->db->connectToDatabase();
        if (!isset($_POST['id'])) {
            $main_page = $this->get_info_main_page();
            return $this->renderTemplate('main_page.php', $main_page);
        }
        else
        {
            $news_one_info = $this->db->get_one_news_info($dbh, $_POST['id']);
            $news_one_comments = $this->db->get_one_news_comments($dbh, $_POST['id']);
            $check_news_one = [
                "status" =>  1
            ];
            $_SESSION['pointer_news'] = [
                "info" => $news_one_info,
                "comments" => $news_one_comments
            ];
            return $this->renderTemplate('one_review_priem.php', $check_news_one);
        }
    }
    public function show_news_one(): Response
    {
        $dbh = $this->db->connectToDatabase();
        if (!isset($_SESSION['pointer_news'])) {
            $main_page = $this->get_info_main_page();
            return $this->renderTemplate('main_page.php', $main_page);
        }
        else
        {
            $news_one_info = $this->db->get_one_news_info($dbh, $_SESSION['pointer_news']['info']['id']);
            $news_one_comments = $this->db->get_one_news_comments($dbh, $_SESSION['pointer_news']['info']['id']);
            $_SESSION['pointer_news'] = [
                "info" => $news_one_info,
                "comments" => $news_one_comments
            ];
            return $this->renderTemplate('one_news.php', $_SESSION['pointer_news']);
        }
    }
    public function add_comment_rev(): Response
    {
        if (!isset($_POST['text'])) {
            $main_page = $this->get_info_main_page();
            return $this->renderTemplate('main_page.php', $main_page);
        }
        else{
            $dbh = $this->db->connectToDatabase();
            $text = trim($_POST['text']);
            $text = filter_var($text, FILTER_SANITIZE_SPECIAL_CHARS);
            $id_rev = $_SESSION['pointer_review']['info']['id'];
            $id_user = $_SESSION['user']['id'];
            $date = date('Y-m-d H:i:s');
            $status_add_comment = $this->db->add_comment_rev($dbh, $id_rev, $id_user, $text, $date);
            $add_comment = [
                'status' => $status_add_comment
            ];
            return $this->renderTemplate('priem_ajax.php', $add_comment);
        }
    }
    public function add_comment_news(): Response
    {
        if (!isset($_POST['text'])) {
            $main_page = $this->get_info_main_page();
            return $this->renderTemplate('main_page.php', $main_page);
        }
        else {
            $dbh = $this->db->connectToDatabase();
            $text = trim($_POST['text']);
            $text = filter_var($text, FILTER_SANITIZE_SPECIAL_CHARS);
            $id_news = $_SESSION['pointer_news']['info']['id'];
            $id_user = $_SESSION['user']['id'];
            $date = date('Y-m-d H:i:s');
            $status_add_comment = $this->db->add_comment_news($dbh, $id_news, $id_user, $text, $date);
            $add_comment = [
                'status' => $status_add_comment
            ];
            return $this->renderTemplate('priem_ajax.php', $add_comment);
        }
    }
    public function reg_user(): Response
    {
        if (!isset($_POST['login'])) {
            $main_page = $this->get_info_main_page();
            return $this->renderTemplate('main_page.php', $main_page);
        }
        else {
            $dbh = $this->db->connectToDatabase();
            $login = $_POST['login'];
            $nick = $_POST['nick'];
            $mail = $_POST['mail'];
            $pass = $_POST['pass'];
            $phone = $_POST['phone'];
            $this->db->reg_user($dbh, $login, $mail, $phone, $nick, $pass);
            $reg_user = [
                'status' => $_SESSION['user']['status']
            ];
            return $this->renderTemplate('priem_ajax.php', $reg_user);
        }
    }
    public function form_rev(): Response
    {
        $dbh = $this->db->connectToDatabase();
        if (!isset($_SESSION['user']['login'])) {
            $main_page = $this->get_info_main_page();
            return $this->renderTemplate('main_page.php', $main_page);
        }
        else
        {
            if(isset($_FILES['userfile']))
            {
                $this->cleanDir('img/dowland');
                $uploaddir = 'img/dowland/';
                // это папка, в которую будет загружаться картинка
                $apend = date('YmdHis') . rand(100, 1000) . '.jpg';
                // это имя, которое будет присвоенно изображению
                $uploadfile = "$uploaddir$apend";
                //в переменную $uploadfile будет входить папка и имя изображения
                if (($_FILES['userfile']['type'] == 'image/gif' || $_FILES['userfile']['type'] == 'image/jpeg' || $_FILES['userfile']['type'] == 'image/png') && ($_FILES['userfile']['size'] != 0 and $_FILES['userfile']['size'] <= 1024000)) {
                    // Указываем максимальный вес загружаемого файла. Сейчас до 512 Кб
                    if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
                        //Здесь идет процесс загрузки изображения
                        $size = getimagesize($uploadfile);
                        // с помощью этой функции мы можем получить размер пикселей изображения
                        if ($size[0] < 8000 && $size[1] < 4000) {
                            // если размер изображения не более 500 пикселей по ширине и не более 1500 по  высоте
                            $_SESSION['dowland_img_rev'] = [
                                "status" => 0,
                                "path" => $uploadfile,
                                "file_name" => $apend
                            ];
                        } else {
                            $_SESSION['dowland_img_rev'] = [
                                "status" => 1
                            ];
                            unlink($uploadfile);
                        }
                    } else {
                        echo "Файл не загружен, вернитеcь и попробуйте еще раз";
                    }
                } else {
                    echo "Файл либо не загружен, либо превышает 512 кб.";
                    $_SESSION['dowland_img_rev'] = [
                        "status" => 1
                    ];
                }
            }
        }
        return $this->renderTemplate('form_rev.php');
    }
    function cleanDir($dir)
    {
        $files = glob($dir."/*");
        $c = count($files);
        if (count($files) > 0) {
            foreach ($files as $file) {
                if (file_exists($file)) {
                    unlink($file);
                }
            }
        }
    }
    public function add_rev(): Response
    {
        $dbh = $this->db->connectToDatabase();
        if (!isset($_SESSION['user']['login'])) {
            $main_page = $this->get_info_main_page();
            return $this->renderTemplate('main_page.php', $main_page);
        }
        else
        {
            $name = trim($_POST['name']);
            $t_prev = trim($_POST['t_prev']);
            $t_main = trim($_POST['t_main']);
            $path = $_POST['path'];
            $dates = date('Y-m-d H:i:s');
            $name = filter_var($name, FILTER_SANITIZE_SPECIAL_CHARS);
            $t_prev = filter_var($t_prev, FILTER_SANITIZE_SPECIAL_CHARS);
            $t_main = filter_var($t_main, FILTER_SANITIZE_SPECIAL_CHARS);
            $file = $path;
            $new_file = 'img/posters/'.$_SESSION['dowland_img_rev']['file_name'];
            copy($file, $new_file);
            unlink($file);
            $rev_one_info = $this->db->add_rev($dbh, $name, $new_file, $t_prev, $t_main, $dates);
            $_SESSION['pointer_review'] = [
                "info" => $rev_one_info
            ];
            $add_rev = [
                'status' => 1
            ];
            return $this->renderTemplate('priem_ajax.php', $add_rev);
        }
    }
    public function form_news(): Response
    {
        $dbh = $this->db->connectToDatabase();
        if (!isset($_SESSION['user']['login'])) {
            $main_page = $this->get_info_main_page();
            return $this->renderTemplate('main_page.php', $main_page);
        }
        else
        {
            if(isset($_FILES['userfile']))
            {
                $this->cleanDir('img/dowland');
                $uploaddir = 'img/dowland/';
                // это папка, в которую будет загружаться картинка
                $apend = date('YmdHis') . rand(100, 1000) . '.jpg';
                // это имя, которое будет присвоенно изображению
                $uploadfile = "$uploaddir$apend";
                //в переменную $uploadfile будет входить папка и имя изображения
                if (($_FILES['userfile']['type'] == 'image/gif' || $_FILES['userfile']['type'] == 'image/jpeg' || $_FILES['userfile']['type'] == 'image/png') && ($_FILES['userfile']['size'] != 0 and $_FILES['userfile']['size'] <= 1024000)) {
                    // Указываем максимальный вес загружаемого файла. Сейчас до 512 Кб
                    if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
                        //Здесь идет процесс загрузки изображения
                        $size = getimagesize($uploadfile);
                        // с помощью этой функции мы можем получить размер пикселей изображения
                        if ($size[0] < 8000 && $size[1] < 4000) {
                            // если размер изображения не более 500 пикселей по ширине и не более 1500 по  высоте
                            $_SESSION['dowland_img_news'] = [
                                "status" => 0,
                                "path" => $uploadfile,
                                "file_name" => $apend
                            ];
                            return $this->renderTemplate('form_news.php');
                        } else {
                            $_SESSION['dowland_img_news'] = [
                                "status" => 1
                            ];
                            unlink($uploadfile);
                            return $this->renderTemplate('form_news.php');
                        }
                    } else {
                        echo "Файл не загружен, вернитеcь и попробуйте еще раз";
                        return $this->renderTemplate('form_rev.php');
                    }
                } else {
                    echo "Файл либо не загружен, либо превышает 512 кб.";
                    $_SESSION['dowland_img_news'] = [
                        "status" => 1
                    ];
                    return $this->renderTemplate('form_news.php');
                }
            }
        }
        return $this->renderTemplate('form_news.php');
    }
    public function add_news(): Response
    {
        $dbh = $this->db->connectToDatabase();
        if (!isset($_SESSION['user']['login'])) {
            $main_page = $this->get_info_main_page();
            return $this->renderTemplate('main_page.php', $main_page);
        }
        else
        {
            $name = trim($_POST['name']);
            $t_prev = trim($_POST['t_prev']);
            $t_main = trim($_POST['t_main']);
            $path = $_POST['path'];
            $dates = date('Y-m-d H:i:s');
            $name = filter_var($name, FILTER_SANITIZE_SPECIAL_CHARS);
            $t_prev = filter_var($t_prev, FILTER_SANITIZE_SPECIAL_CHARS);
            $t_main = filter_var($t_main, FILTER_SANITIZE_SPECIAL_CHARS);
            $file = $path;
            $new_file = 'img/blog/'.$_SESSION['dowland_img_news']['file_name'];
            copy($file, $new_file); // делаем копию
            unlink($file); // удаляем оригинал
            $news_one_info = $this->db->add_news($dbh, $name, $new_file, $t_prev, $t_main, $dates);
            $_SESSION['pointer_news'] = [
                "info" => $news_one_info
            ];
            $add_news = [
                'status' => 1
            ];
            return $this->renderTemplate('priem_ajax.php', $add_news);
        }
    }

}
