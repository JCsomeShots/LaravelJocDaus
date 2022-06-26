<p align="center"><a href="https://github.com/JCsomeShots/LaravelJocDaus" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="200"> <strong>API REST </strong></a></p>



## About this Aplication

i´ve created this API REST with Laravel. 
This API is a play, where you throw a couple of dices and it recognize if you get or not a seven, means if you win or not. 

this API get 

1.- a CRUD for the users

2.- a user authorization 

3.- a Ranking and average of success for each user.


Hope you enjoy it







## Down you will find the instructions in spanish

PARA EL PROYECTO

Requisitos previos 

1.- Es necesario tener en el sistema operativo composer de manera global

2.- Tener instalado GIT

3.- Contar con un entorno de desarrollo como Xamp, Wamp

4.- Versión PHP 8.1.5

5.- Tener instalado Postman

Pasos a seguir

1.- Clonar el repositorio del proyecto en Laravel -- git clone https://github.com/JCsomeShots/LaravelJocDaus.git

2.- Instalar dependencias del proyecto -- Ingrese en terminal : composer install

3.- Generar archivo .env -- Ingrese en terminal : cp .env.example .env

4.- Generar Key -- Ingrese en terminal : php artisan key:generate

5.- Crear base de datos -- Ingrese en terminal : mysql -u root -p : CREATE DATABASE jocDaus CHARACTER SET utf8 COLLATE utf8_spanish_ci;

6.- Correr migraciones y seeds

    Creará administradores (2) jugadores (10) y jugadas (30)  Ingrese en terminal :  
    --  php artisan migrate:fresh --seed
    
    o si lo prefiere también puede hacer una migración sin usuarios, Ingrese en terminal :
    -- php artisan migrate:fresh

7.- Instalar Passport , Ingrese en la terminal : 
    -- php artisan passport:instal --force

8.- Para tastear los Endpoints descargar las colecciones de postman y exportar la misma al programa postman, que se encuentran en la carpeta "postman" dentro de este proyecto. Se encontrará en dos formatos : un link público / la colección en formato json

9.- Tenga en cuenta que para algunas funcionalidades se le pedirá ser un usuario autentificado, y en algunas funcionalidad serán reservadas para el rol de administrador. Ambas validaciones se realizan en postman "Autoization / Bearer Token / token "

10.- Si se desea usar PHPUnit para tastear la aplicación escriba desde el terminal : ./vendor/bin/phpunit. Se realizará 24 test automatizado con 29 afirmaciones ("assertions").

Let's play
