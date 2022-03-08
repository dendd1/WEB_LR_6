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
    <link rel="stylesheet" href="css/style_catalog.css">
    <link rel="stylesheet" href="css/main_catalog.css">
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
        <?php
            $review_all = $params['catalog_news'];
            for ($i=0; $i < count($review_all); $i++) {
                $picture = $review_all[$i]['picture'];
                $name = $review_all[$i]['name'];
                $text_prev = $review_all[$i]['text_preview'];
                $nick= $review_all[$i]['nickname'];
                $id_review = $review_all[$i]['id_news'];
                if (count($review_all)%2 !==0 && $i == count($review_all) - 1) {
                    print('
                                <div  class="library">
                                    <div class="library_content_place">
                                        <img class="library_poster" src="'.$picture.'" alt="">
                                        <div class="library_content_place_text">
                                            <p class="library_content_place_name_text large_text">'.$name.'</p>
                                            <p class="library_text middle_text">Превью :</p>
                                            <p class="roboto library_text review gray_text">'.$text_prev.'</p>
                                            <p class="library_text middle_text">Автор :</p>
                                            <p class="roboto library_text review gray_text">'.$nick.'</p>
                                            <button data-id="'.$id_review.'" class="info_btn catalog news">Подробнее</button>
                                        </div>
                                    </div>   
                                </div>                 
                        ');
                } else {
                    if ($i%2==0) {
                        print('
                            <div  class="library">
                                <div class="library_content_place">
                                    <img class="library_poster" src="'.$picture.'" alt="">
                                    <div class="library_content_place_text">
                                        <p class="library_content_place_name_text large_text">'.$name.'</p>
                                        <p class="library_text middle_text">Краткий обзор :</p>
                                        <p class="roboto library_text review gray_text">'.$text_prev.'</p>
                                        <p class="library_text middle_text">Автор :</p>
                                        <p class="roboto library_text review gray_text">'.$nick.'</p>
                                        <button data-id="'.$id_review.'" class="info_btn news">Подробнее</button>
                                    </div>
                                </div>
                          ');
                    } else {
                        print('
                                <div class="library_content_place">
                                    <img class="library_poster" src="'.$picture.'" alt="">
                                    <div class="library_content_place_text">
                                        <p class="library_content_place_name_text large_text">'.$name.'</p>
                                        <p class="library_text middle_text">Краткий обзор :</p>
                                        <p class="roboto library_text review gray_text">'.$text_prev.'</p>
                                        <p class="library_text middle_text">Автор :</p>
                                        <p class="roboto library_text review gray_text">'.$nick.'</p>
                                        <button data-id="'.$id_review.'" class="info_btn news">Подробнее</button>
                                    </div>
                                </div>
                            </div>
                          ');
                    }
                }
            }
        ?>
    </div>
</section>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="js/scripts.js"></script>
</body>
</html>