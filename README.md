# test-work5.ru

git clone git@github.com:tim31al/test-work5.ru.git my_dir

cd my_dir

## run with docker-compose

docker-compose up -d

docker-compose exec -u app app php bin/init.php

## run without docker

Для подключения к базе изменить значения в config/settings.php

Инициализация базы php bin/init.php

cd public

php -S localhost:8080
