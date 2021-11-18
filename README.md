## Config Env

```bash
# create .env
$ cp .env.example .env

# add info database
DB_HOST=todo_list_db
DB_PORT=3306
DB_DATABASE=app
DB_USERNAME=app
DB_PASSWORD=secret
```

## Run docker & install requirement vendor laravel

```bash
# run docker
$ docker-compose up -d

# show list image
$ docker ps

# chose container id product_manager_php and run
$ docker exec -it ${id_product_manager_php} bash
```

## Run server php
localhost:8989