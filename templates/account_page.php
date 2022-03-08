<?php
/* @var array $params */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style_accaunt.css">
    <link rel="stylesheet" href="css/main_accaunt.css">
    <link rel="stylesheet" href="css/header_style.css"/>
    <title>Shamy</title>
</head>
<body>
<?php
    require_once 'header.php';
?>
<section>
    <header/>
</section>
<section>
    <div class="container">
        <div class="box_info">
            <ul>
                <li><p id="accaunt" class="middle_text active">Профиль</p></li>
                <li><p id="more_info" class="middle_text">Личные данные</p></li>
                <li><a href="form_rev"><p class="middle_text">Создать обзор</p></a></li>
                <li><a href="form_news"><p class="middle_text">Создать новость</p></a></li>
                <li><p id="library_btn" class="middle_text">Ваши Обзоры</p></li>
                <li><p id="news_btn" class="middle_text">Ваши Новости</p></li>
                <li><a href="/"><p class="middle_text">На главную</p></a></li>
                <li><a onclick="scripts.js/out_user()"><p class="middle_text">Выход</p></a></li>
            </ul>
        </div>
        <div class="box_content">
            <div id="accaunt_content" class="box accaunt" style="display:flex">
                <img class="accaunt_avatar_img" src="img/avatars/squidward.jpg" alt="">
                <?php
                    print('
                        <p class="large_text accaunt_name accaunt_text">
                            '.$params['nik'].'
                        </p>
                        ');
                    $array_info = $params['lk_info_count'];
                    print('
                        <p class="small_text accaunt_text">Краткая информация</p>
                        <div class="accaunt_container_info">
                            <div class="accaunt_container_info_box">
                                <p class="large_text accaunt_text">
                                    '.$array_info[0].'
                                </p>
                                <p class="middle_text accaunt_text">
                                    обзоров <br> создано
                                </p>
                            </div>
                            <div class="accaunt_container_info_box">
                                <p class="large_text accaunt_text">
                                    '.$array_info[1].'
                                </p>
                                <p class="middle_text accaunt_text">
                                    новостей <br> оставлено
                                </p>
                            </div>
                            <div class="accaunt_container_info_box">
                                <p class="large_text accaunt_text">
                                    '.$array_info[2].'
                                </p>
                                <p class="middle_text accaunt_text">
                                    Комментариев <br> написано
                                </p>
                            </div>
    
                        </div>')
                ?>
            </div>
            <div id="more_info_content" class="box info" style="display:none">
                <div class="info_text info_box">
                    <p class="large_text">ЛИЧНЫЕ ДАННЫЕ</p>
                    <div class="info_text_box">
                        <?php
                            print('<p class="small_text">Никнейм</p>
                                <p class="middle_text gray_text">'.$params['nik'].'</p>
                            </div>    
                            <div class="info_text_box">
                                <p class="small_text">Почта</p>
                                <p class="middle_text gray_text">'.$params['mail'].'</p>
                            </div>
                            ');
                        ?>
                    </div>
                    <div class="info_img info_box">
                        <img class="info_avatar_img" src="img/avatars/squidward.jpg" alt="">
                    </div>
                </div>
                <div id="library"  class="library" style="display:none">
                    <?php
                        $array = $params['lk_users_rev'];
                        for ($i=0; $i < count($array); $i++) {
                            $name = $array[$i]['name'];
                            $picture = $array[$i]['picture'];
                            $text_preview = $array[$i]['text_preview'];
                            $id_review = $array[$i]['id_review'];
                            print('
                                   <div class="library_content_place">
                            <img class="library_poster" src="'.$picture.'" alt="">
                            <div class="library_content_place_text">
                                <p class="library_content_place_name_text large_text">'.$name.'</p>
                                <p class="library_text middle_text">Краткий обзор :</p>
                                <p class="roboto library_text review gray_text">'.$text_preview.'</p>
                                <button data-id="'.$id_review.'" class="info_btn catalog">подробнее</button>
                            </div>
                        </div>
                          ');
                        }
                    ?>
                </div>
                <div id="news"  class="library" style="display:none">
                    <?php
                        $array = $params['lk_users_news'];
                        for ($i=0; $i < count($array); $i++) {
                            $name = $array[$i]['name'];
                            $picture = $array[$i]['picture'];
                            $text_preview = $array[$i]['text_preview'];
                            $id_news= $array[$i]['id_news'];
                            print('
                                 <div class="library_content_place">
                                   <img class="library_poster" src="'.$picture.'" alt="">
                            <div class="library_content_place_text">
                                <p class="library_content_place_name_text large_text">'.$name.'</p>
                                <p class="library_text middle_text">Краткое содержание :</p>
                                <p class="roboto library_text review gray_text">'.$text_preview.'</p>
                                <button data-id="'.$id_news.'" class="info_btn news">подробнее</button>
                            </div>
                            </div>
                          ');
                        }
                    ?>
                </div>
            </div>
        </div>
</section>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="js/scripts_account.js"></script>
<script src="js/scripts.js"></script>
</body>
</html>