<?php

namespace App\Controller;

use mysql_xdevapi\Exception;
use PDO;
use PDOException;

class DbController
{
    public function connectToDatabase(){
        $array_info = parse_ini_file('C:\OpenServer\domains\film\config\parameters.ini', true);
        $main_info = 'mysql:host='.$array_info['host'].';dbname='.$array_info['name'];
        $login = $array_info['login'];
        $password = $array_info['password'];
        $dbh = null;
        try {
            $dbh = new PDO($main_info, $login, $password);
            return $dbh;
        } catch (PDOException $e) {
            print "Has errors: " . $e->getMessage();
            die();
        }
    }
    public function get_3_reviews_best(PDO $dbh): array
    {
        $sth = $dbh->prepare("SELECT *, (SELECT COUNT(*) AS counts FROM comment WHERE comment.id_review = review.id_review) AS counts FROM review  ORDER BY (visit + counts) DESC LIMIT 3");
        $sth->execute();
        $array = $sth->fetchAll(PDO::FETCH_ASSOC);
        return ($array);
    }
    public function get_10_reviews_best_comm(PDO $dbh): array
    {
        $sth = $dbh->prepare("SELECT *, (SELECT COUNT(*) FROM comment WHERE comment.id_review = review.id_review) AS counts FROM review  ORDER BY counts DESC LIMIT 10");
        $sth->execute();
        $array = $sth->fetchAll(PDO::FETCH_ASSOC);
        return ($array);
    }
    public function get_10_reviews_new(PDO $dbh): array
    {
        $sth = $dbh->prepare("SELECT *, (SELECT COUNT(*) FROM comment WHERE comment.id_review = review.id_review) AS counts FROM review ORDER BY date DESC LIMIT 10");
        $sth->execute();
        $array = $sth->fetchAll(PDO::FETCH_ASSOC);
        return ($array);
    }
    public function get_10_reviews_bestes(PDO $dbh): array
    {
        $sth = $dbh->prepare("SELECT *, (SELECT COUNT(*) FROM comment WHERE comment.id_review = review.id_review) AS counts FROM review  ORDER BY (visit + counts) DESC LIMIT 10");
        $sth->execute();
        $array = $sth->fetchAll(PDO::FETCH_ASSOC);
        return ($array);
    }
    public function get_4_reviews_rec(PDO $dbh): array
    {
        $sth = $dbh->prepare("SELECT *, (SELECT COUNT(*) AS counts FROM comment WHERE comment.id_review = review.id_review) AS counts FROM review ORDER BY id_review DESC LIMIT 4");
        $sth->execute();
        $array = $sth->fetchAll(PDO::FETCH_ASSOC);
        return ($array);
    }
    public function get_4_news(PDO $dbh): array
    {
        $sth = $dbh->prepare("SELECT *, (SELECT COUNT(*) FROM comment WHERE comment.id_news = news.id_news) AS counts FROM news ORDER BY date DESC LIMIT 4");
        $sth->execute();
        $array = $sth->fetchAll(PDO::FETCH_ASSOC);
        return ($array);
    }
    function get_nick($id)
    {
        global $dbh;
        $sth = $dbh->prepare("SELECT nickname FROM users WHERE id_user = :id");
        $sth->execute([
            'id' => $id
        ]);
        $array = $sth->fetchAll(PDO::FETCH_ASSOC);
        return ($array[0]['nickname']);
    }
    public function get_catalog_rev(PDO $dbh): array
    {
        $sth = $dbh->prepare("SELECT *, (SELECT nickname FROM users WHERE users.id_user = review.id_user) as nickname  FROM review ORDER BY date DESC");
        $sth->execute();
        $array_res = $sth->fetchAll(PDO::FETCH_ASSOC);
        return ($array_res);
    }
    public function get_catalog_news(PDO $dbh): array
    {
        $sth = $dbh->prepare("SELECT *, (SELECT nickname FROM users WHERE users.id_user = news.id_user) as nickname  FROM news ORDER BY date DESC");
        $sth->execute();
        $array_res = $sth->fetchAll(PDO::FETCH_ASSOC);
        return ($array_res);
    }
    public function check_auth_user(PDO $dbh, $login, $pass): array
    {
        try{
            $sth = $dbh->prepare("SELECT * FROM users WHERE login = :login ");
            $sth->execute([
                'login' => $login
            ]);
            $array = $sth->fetchAll(PDO::FETCH_ASSOC);
            if (isset($array[0]['password']) && password_verify($pass, $array[0]['password'])) {
                $sucs_inpt = 1;
            } else {
                $sucs_inpt = 0;
            }
        }catch (Exception){ $sucs_inpt = 0;}

        if ($sucs_inpt) {
            $sth = $dbh->prepare("SELECT * FROM users WHERE login = :login");
            $sth->execute([
                'login' => $login
            ]);
            $array = $sth->fetchAll(PDO::FETCH_ASSOC);
            $values = [
                "status" => $sucs_inpt,
                "id" => $array[0]['id_user'],
                "login" => $login,
                "password" => $pass,
                "phone" => $array[0]['phone'],
                "nik" => $array[0]['nickname'],
                "mail" => $array[0]['mail']
            ];
        }else{
            $values = [
                "status" => $sucs_inpt
            ];
        }
        return ($values);
    }
    public function out_user(PDO $dbh, $id): array
    {
        $query =  "UPDATE users SET date_last = :tims WHERE id_user = :id";
        $params = [
            'tims' => date('Y-m-d H:i:s'),
            'id' => $id
        ];
        $sth = $dbh->prepare($query);
        $sth->execute($params);
        $values = [
            'status' => 1
        ];
        return $values;
    }
    public function get_lk_info_count(PDO $dbh, $user_login): array
    {
        $sth = $dbh->prepare("SELECT  id_user  FROM users WHERE login = :login");
        $sth->execute([
            'login' => $user_login
        ]);
        $array_review = $sth->fetchAll(PDO::FETCH_ASSOC);
        $user_id = $array_review[0]['id_user'];
        $sth = $dbh->prepare("SELECT   COUNT(*) AS counts  FROM review WHERE id_user = :id");
        $sth->execute([
            'id' => $user_id
        ]);
        $array_review = $sth->fetchAll(PDO::FETCH_ASSOC);
        $sth = $dbh->prepare("SELECT   COUNT(*) AS counts FROM news WHERE id_user = :id");
        $sth->execute([
            'id' => $user_id
        ]);
        $array_news = $sth->fetchAll(PDO::FETCH_ASSOC);
        $sth = $dbh->prepare("SELECT   COUNT(*) AS counts FROM comment WHERE id_user = :id");
        $sth->execute([
            'id' => $user_id
        ]);
        $array_comment = $sth->fetchAll(PDO::FETCH_ASSOC);
        $array = [$array_review[0]['counts'], $array_news[0]['counts'], $array_comment[0]['counts']];
        return ($array);
    }
    function get_users_lk_rev(PDO $dbh, $user_login): array
    {
        $sth = $dbh->prepare("SELECT  id_user  FROM users WHERE login = :login");
        $sth->execute([
            'login' => $user_login
        ]);
        $array= $sth->fetchAll(PDO::FETCH_ASSOC);
        $user_id = $array[0]['id_user'];
        $sth = $dbh->prepare("SELECT *  FROM review WHERE id_user = :id  ORDER BY date DESC");
        $sth->execute([
            'id' => $user_id
        ]);
        $array_res = $sth->fetchAll(PDO::FETCH_ASSOC);
        return ($array_res);
    }
    function get_users_lk_news(PDO $dbh, $user_login): array
    {
        $sth = $dbh->prepare("SELECT  id_user  FROM users WHERE login = :login ");
        $sth->execute([
            'login' => $user_login
        ]);
        $array= $sth->fetchAll(PDO::FETCH_ASSOC);
        $user_id = $array[0]['id_user'];
        $sth = $dbh->prepare("SELECT *  FROM news WHERE id_user = :id ORDER BY date DESC");
        $sth->execute([
            'id' => $user_id
        ]);
        $array_res = $sth->fetchAll(PDO::FETCH_ASSOC);
        return ($array_res);
    }
    function get_one_rev_info(PDO $dbh, $id): array
    {
        $sth_give = $dbh->prepare("SELECT * FROM review WHERE id_review = :id");
        $sth_give->execute([
            'id' => $id
        ]);
        $array_res = $sth_give->fetchAll(PDO::FETCH_ASSOC);
        $query_get =  "UPDATE review SET visit = :visit WHERE id_review = :id";
        $params_get = [
            'visit' => $array_res[0]['visit'] + 1,
            'id' => $id
        ];
        $sth_get = $dbh->prepare($query_get);
        $sth_get->execute($params_get);
        $sth = $dbh->prepare("SELECT * FROM review WHERE id_review = :id ");
        $sth->execute([
            'id' => $id
        ]);
        $array = $sth->fetchAll(PDO::FETCH_ASSOC);
        //$info = $sth->errorInfo();
        $sth_us = $dbh->prepare("SELECT * FROM users WHERE id_user = :id ");
        $sth_us->execute([
            'id' => $array[0]['id_user']
        ]);
        $array_us = $sth_us->fetchAll(PDO::FETCH_ASSOC);
        $sth_fl = $dbh->prepare("SELECT * FROM film WHERE id_film = :id ");
        $sth_fl->execute([
            'id' => $array[0]['id_film']
        ]);
        $array_fl = $sth_fl->fetchAll(PDO::FETCH_ASSOC);
        $values = [
            'status' => 1,
            'id' => $id,
            'nick' => $array_us[0]['nickname'],
            'film' =>  $array_fl[0]['name'],
            'name' =>  $array[0]['name'],
            'picture' =>  $array[0]['picture'],
            'text_preview' =>  $array[0]['text_preview'],
            'text_main' => $array[0]['text_main'],
            'date' =>  $array[0]['date'],
            'visit' =>  $array[0]['visit']
        ];
        return ($values);
    }
    function get_one_rev_comments(PDO $dbh, $id): array
    {
        $sth = $dbh->prepare("SELECT *, (SELECT nickname FROM users WHERE users.id_user = comment.id_user) as nickname FROM comment WHERE id_review = :id ORDER BY date DESC");
        $sth->execute([
            'id' => $id
        ]);
        $array = $sth->fetchAll(PDO::FETCH_ASSOC);
        return ($array);
    }
    function get_one_news_comments(PDO $dbh, $id): array
    {
        $sth = $dbh->prepare("SELECT *, (SELECT nickname FROM users WHERE users.id_user = comment.id_user) as nickname FROM comment WHERE id_news = :id ORDER BY date DESC");
        $sth->execute([
            'id' => $id
        ]);
        $array = $sth->fetchAll(PDO::FETCH_ASSOC);
        return ($array);
    }
    function get_one_news_info(PDO $dbh, $id): array
    {
        $sth_give = $dbh->prepare("SELECT * FROM news WHERE id_news = :id");
        $sth_give->execute([
            'id' => $id
        ]);$array_res = $sth_give->fetchAll(PDO::FETCH_ASSOC);
        $query_get =  "UPDATE news SET visit = :visit WHERE id_news = :id";
        $params_get = [
            'visit' => $array_res[0]['visit'] + 1,
            'id' => $id
        ];
            $sth_get = $dbh->prepare($query_get);
            $sth_get->execute($params_get);

        $sth = $dbh->prepare("SELECT * FROM news WHERE id_news = :id ");
        $sth->execute([
            'id' => $id
        ]);
        $array = $sth->fetchAll(PDO::FETCH_ASSOC);
        //$info = $sth->errorInfo();
        $sth_us = $dbh->prepare("SELECT * FROM users WHERE id_user = :id ");
        $sth_us->execute([
            'id' => $array[0]['id_user']
        ]);
        $array_us = $sth_us->fetchAll(PDO::FETCH_ASSOC);
        $values = [
            'status' => 1,
            'id' => $id,
            'nick' => $array_us[0]['nickname'],
            'name' =>  $array[0]['name'],
            'picture' =>  $array[0]['picture'],
            'text_preview' =>  $array[0]['text_preview'],
            'text_main' => $array[0]['text_main'],
            'date' =>  $array[0]['date'],
            'visit' =>  $array[0]['visit']
        ];
        return ($values);
    }
    function add_comment_rev(PDO $dbh, $id_rev, $id_user, $text, $date): int
    {
        try
        {
            $query =  "INSERT INTO comment (id_review, id_user, text, date)
            VALUES (:id_review, :id_user, :text, :dats);";
            $params = [
                'id_review' => $id_rev,
                'id_user' => $id_user,
                'text' => $text,
                'dats' => $date
            ];
            $sth = $dbh->prepare($query);
            $sth->execute($params);
            return 1;
        }catch (Exception)
        {
            return 0;
        }

    }
    function add_comment_news(PDO $dbh, $id_news, $id_user, $text, $date): int
    {
        try {
            $query =  "INSERT INTO comment (id_news, id_user, text, date)
            VALUES (:id_news, :id_user, :text, :dats);";
            $params = [
                'id_news' => $id_news,
                'id_user' => $id_user,
                'text' => $text,
                'dats' => $date
            ];
            $sth = $dbh->prepare($query);
            $sth->execute($params);
            return 1;
        }catch (Exception){
            return 0;
        }

    }
    function reg_user(PDO $dbh, $login, $mail, $phone, $nick, $pass): void
    {
        $sth = $dbh->prepare("SELECT COUNT(*) as counts FROM users WHERE login = :login or mail = :mail");
        $sth->execute([
            'login' => $login,
            'mail' => $mail
        ]);

        $array = $sth->fetchAll(PDO::FETCH_ASSOC);
        $sucs_inpt = 0;
        if ($array[0]['counts'] == 0) {
            $sucs_inpt = 1;
            $hash = password_hash($pass, PASSWORD_DEFAULT);
            $query =  "INSERT INTO users (login, password, mail, phone, nickname, id_role)
    VALUES (:login, :password, :mail, :phone, :nick, 1);";
            $params = [
                'login' => $login,
                'password' => $hash,
                'mail' => $mail,
                'phone' => $phone,
                'nick' => $nick
            ];
            try{
                $sth = $dbh->prepare($query);
                $sth->execute($params);
            }
            catch (\Exception){}
            $id = $dbh->lastInsertId();
            session_start();
            $_SESSION['user'] = [
                "status" => $sucs_inpt,
                "id" => $id,
                "login" => $login,
                "password" => $hash,
                "phone" => $phone,
                "nik" => $nick,
                "mail" => $mail
            ];
        }
    }
    function add_rev(PDO $dbh, $name, $new_file, $t_prev, $t_main, $dates): array
    {
        try{
            $query =  "INSERT INTO review ( id_film, id_user, name, picture, text_preview, text_main, date)
        VALUES (4, :id_user, :nm, :picture, :text_preview, :text_main, :dats);";
            $params = [
                'id_user' => $_SESSION['user']['id'],
                'nm' => $name,
                'picture' => $new_file,
                'text_preview' => $t_prev,
                'text_main' => $t_main,
                'dats' =>  $dates
            ];
            $sth = $dbh->prepare($query);
            $sth->execute($params);
            $id = $dbh->lastInsertId();
        }catch (Exception){echo ('какаято-ошибка');}
        session_start();
        $_SESSION['dowland_img_rev'] = [
            "status" => 1
        ];
        $array= [
            'id' =>$id,
            'status' => 1, // 1 - успех авторизации, 0 - беда
            'nick' => $_SESSION['user']['nik'],
            'film' =>  "Всем фильмам фильм",
            'name' =>  $name,
            'picture' =>  $new_file,
            'text_preview' =>  $t_prev,
            'text_main' => $t_main,
            'date' => $dates,
            'visit' =>  0
        ];
        return $array;
    }
    function add_news(PDO $dbh, $name, $new_file, $t_prev, $t_main, $dates): array
    {
        try{
            $query =  "INSERT INTO news ( id_user, name, picture, text_preview, text_main, date)
        VALUES ( :id_user, :nm, :picture, :text_preview, :text_main, :dats);";
            $params = [
                'id_user' => $_SESSION['user']['id'],
                'nm' => $name,
                'picture' => $new_file,
                'text_preview' => $t_prev,
                'text_main' => $t_main,
                'dats' =>  $dates
            ];
            $sth = $dbh->prepare($query);
            $sth->execute($params);
            $id = $dbh->lastInsertId();
        }catch (Exception){echo ('какаято-ошибка');}
        session_start();
        $_SESSION['dowland_img_news'] = [
            "status" => 1
        ];
        $array= [
            'id' =>$id,
            'status' => 1, // 1 - успех авторизации, 0 - беда
            'nick' => $_SESSION['user']['nik'],
            'film' =>  "Всем фильмам фильм",
            'name' =>  $name,
            'picture' =>  $new_file,
            'text_preview' =>  $t_prev,
            'text_main' => $t_main,
            'date' => $dates,
            'visit' =>  0
        ];
        return $array;
    }
}