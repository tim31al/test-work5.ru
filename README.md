# test-work5.ru

git clone my_dir

cd my_dir

## run with docker-compose

docker-compose up -d

docker-compose exec -u app app php bin/init.php

## run without docker

php bin/init.php

cd public

php -S localhost:8080
