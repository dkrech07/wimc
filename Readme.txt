Развернуть проект:

1. Установить Yii в директорию taskforce:

composer create-project --prefer-dist yiisoft/yii2-app-basic wimc

2. Загрузить проект из гита в директорию taskforce:

git clone git@github.com:dkrech07/wimc.git

3. Загрузить зависимости:

composer install

4. Выполнить автозагрузку кастомных классов:

composer dump-autoload

5. Создать базу данных:

CREATE DATABASE wimc
  DEFAULT CHARACTER SET utf8mb4;

6. Получить структуру базы данных:

yii migrate

7. Загрузить тестовые данные:

php yii fixture "Customs, Pages"


Дополнительно:

1. Генерация тестовых данных:

php yii fixture/generate customs --count=10


// Получить ответ от геокодера:
http://localhost/wimc/web/geoapi/Екатеринбург

// Роут без ЧПУ (enablePrettyUrl):
http://localhost/wimc/web/index.php?r=customs/index

---------------------------------------------------------
<!-- <?= $form->field(
            $loginForm,
            'login',
            [
                // 'options' => [
                //     'class' => 'col-8 col-sm-8 col-md-8 col-lg-8 col-xl-8',
                // ],
            ]
        )->textInput([
            'id' => 'login',
            'class' => 'form-control',
            // 'required' => true,
        ]) ?>

    <?= $form->field($loginForm, 'password', [
        // 'options' => [
        //     'class' => 'col-8 col-sm-8 col-md-8 col-lg-8 col-xl-8',
        // ],
    ])->passwordInput(
        [
            'id' => 'password',
            'class' => 'form-control login',
            // 'required' => true,
        ]
    ) ?> -->