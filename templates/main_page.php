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
    <link rel="stylesheet" href="css/super_style.css">
    <link rel="stylesheet" href="css/lightslider.css"/>
    <title>Shamy</title>
</head>
<body>
<?php
    require_once 'header.php';
?>
<!--  ------Первый слайд(начало)----------------- -->
<section>
    <div class="main">
        <div class="container content_down">
            <div class="box content_main">
                <p class="large_text_ad">Темный рыцарь</p>
            </div>
            <div class="box content_main">
                <div class="link_main">
                    <p class="small_text rotate_text text_main">самое самое</p>
                </div>
                <div class="content_main posters_main">
                    <?php
                        $best =  $params['best_3_rev'];
                        for ($i=0; $i < count($best); $i++)
                        {
                            $picture = $best[$i]['picture'];
                            $name = $best[$i]['name'];
                            $comment = $best[$i]['counts'];
                            $visit = $best[$i]['visit'];
                            $id_review = $best[$i]['id_review'];
                            print('
                                    <div class="item container_main">
                                        <img class="item_img" src="'.$picture.'" alt="">
                                        <button data-id="'.$id_review.'" class="item_btn poster_btn" >Отзыв</button>
                                        <div class="item_mask">
                                            <div class="item_text film_name_main">
                                                '.$name. '
                                            </div>
                                            <div class="item_text stat_main">
                                                <img class="img_stat_mini" src="img/interaction/comment.svg" alt="">
                                                ' .$comment. '
                                                <img class="img_stat_mini" src="img/interaction/eye.svg" alt="">
                                                ' .$visit.'
                                            </div>
                                        </div>
                                    </div>');
                        }
                    ?>
                </div>
            </div>
        </div>
        <div class="laptop_scroll">
            <div class="help_box"></div>
            <p>Самое самое</p>
            <ul id="laptop_scroll">
                <?php
                    $best =  $params['best_3_rev'];
                    for ($i=0; $i < count($best); $i++)
                    {
                        $picture = $best[$i]['picture'];
                        $name = $best[$i]['name'];
                        $comment = $best[$i]['counts'];
                        $visit = $best[$i]['visit'];
                        $id_review = $best[$i]['id_review'];
                        print('
                           <li>
                              <div class="item container_main">
                                <img class="item_img" src="'.$picture.'" alt="">
                                <button data-id="'.$id_review.'" class="item_btn poster_btn" >Отзыв</button>
                                <div class="item_mask">
                                  <div class="item_text film_name_main">
                                    '.$name. '
                                  </div>
                                  <div class="item_text stat_main">
                                    <img class="img_stat_mini" src="img/interaction/comment.svg" alt="">
                                     ' .$comment. '
                                    <img class="img_stat_mini" src="img/interaction/eye.svg" alt="">
                                    ' .$visit.'
                                  </div>
                                </div>
                              </div>
                           </li>');
                    }
                ?>
            </ul>
        </div>
        <div class="main_mask"></div>
    </div>
</section>
<!--  ------Первый слайд(конец)----------------- -->
<!-- ------------------Второй слайд(начало)-------------- -->
<section>
    <div class="container_for_micro">
        <div class="section_header">
            <h3  class="small_text">все самое лучшше для вас</h3>
            <h2 class="middle_text">Каталог фильмов</h2>
            <button id="catalog_btn_1" class="item_btn catalog_btn catalog_btn_active" >Все</button>
            <button  id="catalog_btn_2" class="item_btn catalog_btn" >Новинки</button>
            <button  id="catalog_btn_3" class="item_btn catalog_btn" >Самое обсуждаемое</button>
            <button  id="catalog_btn_4" class="item_btn catalog_btn" >Лучшее</button>
        </div>
        <div id="new" class="container_for_scroll">
            <h3  class="small_text">Новинки</h3>
            <ul id="review_scroll_new" class="cs-hidden">
                <?php
                    $review =  $params['new_10_rev'];
                    for ($i=0; $i < count($review); $i++)
                    {
                        $picture = $review[$i]['picture'];
                        $name = $review[$i]['name'];
                        $comment = $review[$i]['counts'];
                        $visit = $review[$i]['visit'];
                        $id_review = $review[$i]['id_review'];
                        print('
                                  <li>
                                    <div class="item catalog_container">
                                        <img class="item_img" src='.$picture.' alt="">
                                        <button data-id="'.$id_review.'" class="item_btn poster_btn" >Отзыв</button>
                                        <div class="item_mask catalog_mask">
                                            <div class="item_text film_name">
                                                <p class="text_big">'.$name. '</p>
                                            </div>
                                            <div class="item_text stat">
                                                <img class="picture_catalog" src="img/interaction/comment.svg" alt="">
                                                <p class="text_big">' .$comment. '</p>
                                                <img class="picture_catalog" src="img/interaction/eye.svg" alt="">
                                                <p class="text_big">' .$visit.'</p>
                                            </div>
                                        </div>
                                    </div>
                                  </li>
                                  ');
                    }
                ?>
            </ul>
        </div>
        <div id="best_com" class="container_for_scroll">
            <h3  class="small_text">Самое обсуждаемое</h3>
            <ul id="review_scroll_best_com" class="cs-hidden">
                <?php
                    $review =  $params['best_10_rev'];
                    for ($i=0; $i < count($review); $i++) {
                        $picture = $review[$i]['picture'];
                        $name = $review[$i]['name'];
                        $comment = $review[$i]['counts'];
                        $visit = $review[$i]['visit'];
                        $id_review = $review[$i]['id_review'];
                        print('
                          <li>
                            <div class="item catalog_container">
                                <img class="item_img" src='.$picture.' alt="">
                                <button data-id="'.$id_review.'" class="item_btn poster_btn" >Отзыв</button>
                                <div class="item_mask catalog_mask">
                                    <div class="item_text film_name">
                                        <p class="text_big">'.$name. '</p>
                                    </div>
                                    <div class="item_text stat">
                                        <img class="picture_catalog" src="img/interaction/comment.svg" alt="">
                                        <p class="text_big">' .$comment. '</p>
                                        <img class="picture_catalog" src="img/interaction/eye.svg" alt="">
                                        <p class="text_big">' .$visit.'</p>
                                    </div>
                                </div>
                            </div>
                          </li>
                          ');
                    }
                ?>
            </ul>
        </div>
        <div id="best_all" class="container_for_scroll">
            <h3  class="small_text">Лучшее</h3>
            <ul id="review_scroll_best_all" class="cs-hidden">
                <?php
                    $review =  $params['bestes_10_rev'];
                    for ($i=0; $i < count($review); $i++) {
                        $picture = $review[$i]['picture'];
                        $name = $review[$i]['name'];
                        $comment = $review[$i]['counts'];
                        $visit = $review[$i]['visit'];
                        $id_review = $review[$i]['id_review'];
                        print('
                          <li>
                            <div class="item catalog_container">
                                <img class="item_img" src='.$picture.' alt="">
                                <button data-id="'.$id_review.'" class="item_btn poster_btn" >Отзыв</button>
                                <div class="item_mask catalog_mask">
                                    <div class="item_text film_name">
                                        <p class="text_big">'.$name. '</p>
                                    </div>
                                    <div class="item_text stat">
                                        <img class="picture_catalog" src="img/interaction/comment.svg" alt="">
                                        <p class="text_big">' .$comment. '</p>
                                        <img class="picture_catalog" src="img/interaction/eye.svg" alt="">
                                        <p class="text_big">' .$visit.'</p>
                                    </div>
                                </div>
                            </div>
                          </li>
                          ');
                    }
                ?>
            </ul>
        </div>
    </div>
</section>
<!-- ------------------Второй слайд(конец)-------------- -->
<!-- ------------------Третий слайд(начало)-------------- -->
<section>
    <div class="container">
        <div class="section_header">
            <h2 class="middle_text">Выбор редакции</h2>
        </div>
        <?php
            $rec = $params['rec_4_rev'];
            $big_box_1 = $rec[0];
            $small_box_1 = $rec[1];
            $big_box_2 = $rec[3];
            $small_box_2 = $rec[2];
            print('
                        <div class="gallery-block">
                          <div class="box">
                            <div class="gallery_content_box_big">
                                <img class="img_recomend" src="'.$big_box_1['picture'].'">
                                <button data-id="'.$big_box_1['id_review'].'" class="item_btn poster_btn_recomend">Отзыв</button>
                                <div class="item_mask_recomend">
                                <div class="item_text film_name_recomend">
                                    '.$big_box_1['name']. '
                                </div>
                                <div class="item_text stat_recomend">
                                <img class="picture_recomend_last" src="img/interaction/comment.svg" alt="">
                                <p class="text_very_but_not_big">' .$big_box_1['counts']. '</p>
                                <img class="picture_recomend_last" src="img/interaction/eye.svg" alt="">
                                <p class="text_very_but_not_big">' .$big_box_1['visit'].'</p>
                            </div>
                         </div>
                        </div>
                            <div class="gallery_content_box_small">
                                <img class="img_recomend" src="'.$small_box_1['picture'].'">
                                <button data-id="'.$small_box_1['id_review'].'" class="item_btn poster_btn_recomend">Отзыв</button>
                                <div class="item_mask_recomend">
                                <div class="item_text film_name_recomend">
                                    '.$small_box_1['name']. '
                                </div>
                                <div class="item_text stat_recomend">
                                <img class="picture_recomend_last" src="img/interaction/comment.svg" alt="">
                                <p class="text_very_but_not_big">' .$small_box_1['counts']. '</p>
                                <img class="picture_recomend_last" src="img/interaction/eye.svg" alt="">
                                <p class="text_very_but_not_big">' .$small_box_1['visit'].'</p>
                            </div>
    
                        </div>
                    </div>
                </div>    
                 <div class="box">
                    <div class="gallery_content_box_small">
                    <img class="img_recomend" src="'.$small_box_2['picture'].'">
                    <button data-id="'.$small_box_2['id_review'].'" class="item_btn poster_btn_recomend">Отзыв</button>
                    <div class="item_mask_recomend">
                    <div class="item_text film_name_recomend">
                      '.$small_box_2['name']. '
                    </div>
                    <div class="item_text stat_recomend">
                        <img class="picture_recomend_last" src="img/interaction/comment.svg" alt="">
                        <p class="text_very_but_not_big">' .$small_box_2['counts']. '</p>
                        <img class="picture_recomend_last" src="img/interaction/eye.svg" alt="">
                        <p class="text_very_but_not_big">' .$small_box_2['visit'].'</p>
                    </div>
                  </div>
                </div>
                <div class="gallery_content_box_big">
                  <img class="img_recomend" src="'.$big_box_2['picture'].'">
                  <button data-id="'.$big_box_2['id_review'].'" class="item_btn poster_btn_recomend">Отзыв</button>    
                  <div class="item_mask_recomend">
                    <div class="item_text film_name_recomend">
                      '.$big_box_2['name']. '
                    </div>
                    <div class="item_text stat_recomend">
                        <img class="picture_recomend_last" src="img/interaction/comment.svg" alt="">
                        <p class="text_very_but_not_big">' .$big_box_2['counts']. '</p>
                        <img class="picture_recomend_last" src="img/interaction/eye.svg" alt="">
                        <p class="text_very_but_not_big">' .$big_box_2['visit'].'</p>
                    </div>    
                  </div>
                </div>');
        ?>
    </div>
</section>
<!-- ------------------Третий слайд(конец)-------------- -->
<!-- ------------------Четвертый слайд(начало)-------------- -->
<section>
    <div class="container">
        <div>
            <p class="middle_text blog_theme_text">Свежее в блоге</p>
        </div>
        <div class="blog_box">
            <ul id="autoWidth" class="cs-hidden">
                <?php
                    $news =  $params['news_4'];
                    for ($i=0; $i < count($news); $i++) {
                        $picture = $news[$i]['picture'];
                        $text_preview = $news[$i]['text_preview'];
                        $comment = $news[$i]['counts'];
                        $visit = $news[$i]['visit'];
                        print('
                      <li>
                        <div class="third_box">
                          <img class="blog_img"
                            src="'.$picture.'"
                            alt="">
                          <p  class="small_text blog_text">
                          '.$text_preview. '
                          </p>
                          <div class="reaction_blog">
                            <img class="picture_catalog" src="img/interaction/comment.svg" alt="">
                            <p class="text_big">
                              ' .$comment. '
                            </p>
                            <img class="picture_catalog" src="img/interaction/eye.svg" alt="">
                            <p class="text_big">
                            ' .$visit.'
                            </p>
                          </div>
                        </div>
    
                      </li>
                      ');
                    }
                ?>
            </ul>
        </div>
        <div class="blog_btn">
            <a href="catalog_news"><p class="small_text blog_btn">Все публикации</p></a>
        </div>
    </div>
</section>
<!-- ------------------Четвертый слайд(конец)-------------- -->
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="js/lightslider.js"></script>
<script src="js/scripts.js"></script>
</body>
</html>