## Configuration of the Laravel Back-end API

1. Copy env.sample to .env
2. Make sure to configure the ports in the .env file if the local system uses the defaults
```shell
vim .env
```
3. Go to workbench or phpmyadmin and create database schema starter
4. Append the dev domain name '127.0.0.1   starter.test' in /etc/hosts:
```shell
sudo vim /etc/hosts
```

## Build Application

After starting the Docker-Compose local development environment from the **infrastructure/dev_env** folder (follow README.md from that folder), build the application from the live docker containers.

### For the Laravel API start the app container by running:
```shell
docker exec -it app /bin/bash
```
Then in folder within the app container **app/api** run the following commands:
```shell
composer install && php artisan config:clear && php artisan view:clear && php artisan route:clear && composer dump-autoload && php artisan cache:clear && php artisan config:cache && php artisan route:cache
```
Run these commands to migrate and populate the database:
```shell
php artisan migrate:fresh && php artisan db:seed
```

### For the Vuejs Admin Panel SPA start the app container by running:
```shell
docker exec -it node /bin/bash
```
Then in folder within the node container **app/client/admin** run the following commands:
```shell
npm install && npm run dev
```

### For the Nuxt Public Content SSR start the app container by running:
```shell
docker exec -it node /bin/bash
```
Then in folder within the node container **app/client/public** run the following commands:
```shell
npm install && npm run dev
```

### Tips

To fix Permission issues for Laravel folder in folder **app/api** outside of docker containers:
```shell
sudo chown -R www-data: . && sudo setfacl -R -m u:$USER:rwx .
```

## Useful commands:

Get a list of all running or failed containers
```shell
docker ps -a
```
To execute commands inside a container
```shell
docker exec -it app /bin/bash
```
Run a container for a service defined in the docker-compose.yaml file. You will have to execute this command from the dev_env folder
```shell
docker-compose exec -it app node /bin/bash
```
Clear all docker cache containers networks etc ... This will remove docker containers for other projects too not just starter
```shell
docker system prune -a
```

## Running Tests:

Create new .env.testing file with the following variables (or based on your current DB config)
```dotenv
APP_ENV=testing
DB_CONNECTION=mysql
DB_DATABASE=starter_test
DB_HOST=database
DB_PORT=3306
DB_USERNAME=root
DB_PASSWORD=password
```
After that run the command
```shell
php artisan migrate:fresh --database=mysql --env=testing --seed
```
