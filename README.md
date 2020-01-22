## sysUptag

Administrative software used for save and publish documents


## Requeriments


* PHP, Mysql and Apache installed. 

* Or any AMPP stack instaled, recommended Laragon. 

## Instructions

Place the master folder inside the root directory of your web server.

Open a terminal and place the directory in the root folder of the software, then run the following:


*  Create database:

`$ php artisan migrate:refresh`


*  Insert Admin user

`$ php artisan db:seed`

Then the user details to log in:

**Email:** anthony@example.com'

**Password:** securepassword

## More info about developer

- [Creator](https://codineffable.github.io)

