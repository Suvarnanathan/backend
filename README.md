### Installation Instructions
1. Run `git clone https://github.com/Prime-Technologies-Global/ipartner-backend.git`
2. Create a MySQL database for the project
    * ```mysql -u root -p```, if using Vagrant: ```mysql -u homestead -psecret```
    * ```create database ipartner;```
    * ```\q```
3. From the projects root run `cp .env.example .env`
4. Configure your `.env` file
5. Run `composer update` from the projects root folder

```
7. From the projects root folder run `sudo chmod -R 755 ../ipartner-backend`
8. From the projects root folder run `php artisan key:generate`
9. From the projects root folder run `php artisan migrate`
10. From the projects root folder run `composer dump-autoload`
11. From the projects root folder run `php artisan db:seed`
12. Run `php artisan passport:install`
13.Run 'php artisan storage:link' for image link to storage and public
14.npm install && npm run dev