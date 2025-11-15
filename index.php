<?
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php');
$APPLICATION->SetTitle('Test');
?>
    <!DOCTYPE html>
    <html lang="ru">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/assets/css/style.css">
    </head>
    <body>

    <!-- banner -->
    <section class="banner">
        <div class="banner_content">
            <div class="banner_left">
                <div class="banner_left_content">
                    <h1>Заголовок h1</h1>
                    <span>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</span>
                </div>
            </div>
            <div class="banner_right">
                <img src="<?=SITE_TEMPLATE_PATH?>/assets/img/banner.png" alt="banner">
            </div>
        </div>
    </section>
    <!-- banner -->

    <!-- content -->
    <section class="section">
        <div class="range_container">
            <h2>Заголовок h2</h2>
            <span>Выберите диапазон</span>
            <div class="range_inputs">
                <input type="number" id="min-val" value="0" placeholder="от 0">
                <input type="number" id="max-val" value="150" placeholder="до 150">
            </div>
            <div class="slider">
                <div class="slider_progress"></div>
                <div class="range-input">
                    <input type="range" id="range-min" min="0" max="150" value="0" step="1">
                    <input type="range" id="range-max" min="0" max="150" value="150" step="1">
                </div>
            </div>
        </div>
    </section>
    <!-- content -->

    <!-- form -->
    <section class="section">
        <div class="form_container">
            <form action="#" class="custom-form" novalidate>
                <div class="form-group">
                    <label for="framework-select">Выберите select</label>
                    <div class="select-wrapper">
                        <select name="frameworks" id="framework-select">
                            <option value="">Option</option>
                            <option value="Vite">Vite</option>
                            <option value="Webpack">Webpack</option>
                            <option value="Gulp">Gulp</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label>Выберите radio</label>
                    <div class="radio-group">
                        <div class="radio-item">
                            <input type="radio" id="js" name="language" value="JavaScript" checked>
                            <label for="js">JavaScript</label>
                        </div>
                        <div class="radio-item">
                            <input type="radio" id="php" name="language" value="PHP">
                            <label for="php">PHP</label>
                        </div>
                        <div class="radio-item">
                            <input type="radio" id="csharp" name="language" value="C#">
                            <label for="csharp">C#</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="full-name">Введите ФИО</label>
                    <input type="text" id="full-name" placeholder="Placeholder">
                    <div class="error-message" id="full-name-error"></div>
                </div>

                <div class="form-group">
                    <label for="age">Введите возраст в цифрах</label>
                    <input type="text" id="age" placeholder="Placeholder">
                    <div class="error-message" id="age-error"></div>
                </div>

                <div class="form-group form-group-full">
                    <div class="checkbox-group">
                        <div class="checkbox-item">
                            <input type="checkbox" id="required-check" name="required-check">
                            <label for="required-check">Обязательный checkbox</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" id="optional-check" name="optional-check">
                            <label for="optional-check">Необязательный checkbox</label>
                        </div>
                    </div>
                    <div class="error-message" id="required-check-error"></div>
                </div>

                <div class="form-group form-group-full">
                    <div class="button-wrapper">
                        <button type="submit" class="button-abslt">Отправить</button>
                        <div class="button-bg"></div>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <!-- form -->

    <!-- block -->
    <section class="section last-block">
        <h3>Заголовок h3</h3>
        <span>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</span>
    </section>
    <!-- block -->

    <!-- modalka -->
    <div class="modal-overlay" id="modal-overlay">
        <div class="modal" id="modal">
            <span class="close-modal" id="close-modal">&times;</span>
            <div class="modal-header">Результат отправки:</div>
            <div class="modal-content" id="modal-content">
            </div>
        </div>
    </div>
    <!-- modalka -->

    <script src="<?=SITE_TEMPLATE_PATH?>/assets/js/main.js"></script>

    </body>
    </html>
<?
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/footer.php');
?>