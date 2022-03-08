<header class="header_f">
    <div class="container head">
        <div class="header_f_inner">
            <a href="/"><img class="logo_img" src="img/interaction/logo.png" alt=""></a>
            <a href="catalog_rev" class="btn_header" >Обзоры</a>
            <a href="catalog_news" class="btn_header" >Новости</a>
            <input type="text" class="header_input" >
            <button class="header_button" type="submit">
                &#128270;</button>
            <?php
                session_start();
                if (isset($_SESSION['user']['login'])) {
                    print('<a href="account" class="login_text">'."Привет, ".$_SESSION['user']['nik'].'</a>');
                    print('<button id="out_butt" onclick="scripts.js/out_user()" class="btn_header" >Выйти</button>');
                } else {
                    print('<button onclick="scripts.js/show_auth(\'block\')" class="btn_header" >Войти</button>');
                }
            ?>
        </div>
    </div>
</header>
<div id="gray_mask" onclick="scripts.js/show('none'), scripts.js/show_auth('none'), scripts.js/show_laptop_menu('none')"></div>
<div id="window_reg_auth">
    <img class="close" src="img/interaction/close.png" alt="" onclick="scripts.js/show('none')">
    <div class="form_reg_auth">
        <a class="second_choise" href="#" onclick="scripts.js/show('none'), scripts.js/show_auth('block')">Вход</a>
        <h2 class="hed_r_a">&#8594;Регистрация&#8592;</h2>
        <form action="index.html" name="f1">
            <input type="text" oninput='this.value=this.value.replace(/[^\w\d]*/gi,"");' maxlength="16" placeholder="Логин" id="reg_login" value="danila" class="input_r_a">
            <p id="error_login" class="info_reg">&#11014;ошибка&#11014;</p>
            <input type="text" oninput='this.value=this.value.replace(/[^\w\d]*/gi,"");' maxlength="20" placeholder="Ник-нейм" id="reg_nick" value="danila" class="input_r_a">
            <p id="error_nick" class="info_reg">&#11014;ошибка&#11014;</p>
            <input type="email"  placeholder="Почта (sample@mail.ru)" maxlength="32" value="danila@mail.ru" id="reg_mail" class="input_r_a">
            <p id="error_mail" class="info_reg">&#11014;ошибка&#11014;</p>
            <input type="password" oninput='this.value=this.value.replace(/[^\w\d]*/gi,"");' placeholder="Пароль" value="123" id="reg_pass_1" class="input_r_a">
            <p id="error_pass" class="info_reg">&#11014;ошибка&#11014;</p>
            <input type="password" oninput='this.value=this.value.replace(/[^\w\d]*/gi,"");' placeholder="Подтвердите пароль" value="123" id="reg_pass_2" class="input_r_a">
            <input type='tel' oninput='this.value=this.value.replace(/[^\d]*/gi,"");' maxlength="11" placeholder="Мобильный телефон" id="reg_phone" class="input_r_a">
            <div class="help_box_2"></div>
            <p><input  type="checkbox" id="reg_chbox" value=""> Соглашение на обработку личных данных</p>
            <div class="help_box_2"></div>
            <a onclick="scripts.js/reg_user()" class="btn_reg" id="reg_btn" >Зарегестрироваться</a>
        </form>
    </div>
</div>
<div id="window_auth_reg">
    <img class="close" src="img/interaction/close.png" alt="" onclick="scripts.js/show_auth('none')">
    <div class="form_reg_auth">
        <a class="second_choise" href="#" onclick=" scripts.js/show_auth('none'), scripts.js/show('block')">Регистрация</a>
        <h2 class="hed_r_a">&#8594;Вход&#8592;</h2>
        <form action="index.html" name="f1">
            <input  oninput='this.value=this.value.replace(/[^\w\d]*/gi,"");'type="text" maxlength="16" placeholder="Логин" id="auth_login"  class="input_r_a">
            <p  id="error_login_auth" class="info_reg">&#11014;ошибка&#11014;</p>
            <input oninput='this.value=this.value.replace(/[^\d]*/gi,"");' type="password" placeholder="Пароль" id="auth_password"  class="input_r_a">
            <p id="error_password_auth" class="info_reg">&#11014;ошибка&#11014;</p>
            <div class="help_box_2"></div>
            <a  class="btn_reg"  onclick="scripts.js/auth_user()"> Войти </a>
        </form>
    </div>
</div>
<header class="header_laptop">
    <div class="container head">
        <div class="header_f_inner">
            <a href="index.php"><img class="logo_img" src="img/interaction/logo.png" alt=""></a>
            <input class="header_input" value="" >
            <button onclick="scripts.js/show_laptop_menu('block')" class="btn_header" >	&#926;</button>
        </div>
    </div>
</header>
<header id="header_laptop_menu">
    <div class="container head">
        <div class="header_f_inner laptop">
            <a href="catalog_review.php" class="btn_header" >Обзоры</a>
            <a href="catalog_news.php" class="btn_header" >Новости</a>
            <?php
            if (isset($_SESSION['user']['login']))
            {
                print('<a href="account.php" class="login_text">'."Привет, ".$_SESSION['user']['nik'].'</a>');
                print('<button id="out_butt" onclick="scripts.js/out_user()" class="btn_header" >Выйти</button>');
            } else {
                print('<p class="text_big">'.$_SESSION['user']['nik'].'</p>');
                print('<button onclick="scripts.js/show_auth(\'block\')" class="btn_header" >Войти</button>');
            }
            ?>
        </div>
    </div>
</header>