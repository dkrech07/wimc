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

php yii fixture/load Customs






Дополнительно:

1. Генерация тестовых данных:

php yii fixture/generate customs --count=10