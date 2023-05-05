# Mini Aplicación Symfony API Rest 
## Mini Aplicación con base de datos que gestiones clubes, jugadores y entrenadores

### Primero creamos un proyecto en symfony 
#### En la terminal ponemos el proximo comando,para entrar en el directorio que queremos crear el proyecto:
- ```cd/var/www```
#### Con el siguiente comando crwamos el proyecto en symfony que se va a llamar baseDatosFutbol:
  - "sudo symfony ne baseDatosFutbol"
#### Despues le metemos los permisos necesarios:
- ```sudo chmod 775 baseDatosFutbol/ -Rf```
- ````sudo chown marta.www-data baseDatosFutbol/ -Rf```
### Tambien le damos permisos en ngixn siguiendo lossiguiente comandos:
- ```cd /etc/nginx/sites-avaible```
- ```vim baseDatosFutbol```
-  insertamos el siguiente codigo:
 
```server {
  # Example PHP Nginx FPM config file
  listen 80 ;
  listen [::]:80 ;
  server_name futbol.localhost;
  root /var/www/baseDatosFutbol/public;
    location / {
        # try to serve file directly, fallback to index.php
        try_files $uri /index.php$is_args$args;
    }

    # optionally disable falling back to PHP script for the asset directories;
    # nginx will return a 404 error when files are not found instead of passing the
    # request to Symfony (improves performance but Symfony's 404 page is not displayed)
    # location /bundles {
    #     try_files $uri =404;
    # }

    location ~ ^/index\.php(/|$) {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_split_path_info ^(.+\.php)(/.*)$;
        include fastcgi_params;

        # optionally set the value of the environment variables used in the application
        # fastcgi_param APP_ENV prod;
        # fastcgi_param APP_SECRET <app-secret-id>;
        # fastcgi_param DATABASE_URL "mysql://db_user:db_pass@host:3306/db_name";

        # When you are using symlinks to link the document root to the
        # current version of your application, you should pass the real
        # application path instead of the path to the symlink to PHP
        # FPM.
        # Otherwise, PHP's OPcache may not properly detect changes to
        # your PHP files (see https://github.com/zendtech/ZendOptimizerPlus/issues/126
        # for more information).
        # Caveat: When PHP-FPM is hosted on a different machine from nginx
        #         $realpath_root may not resolve as you expect! In this case try using
        #         $document_root instead.
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        fastcgi_param DOCUMENT_ROOT $realpath_root;
        # Prevents URIs that include the front controller. This will 404:
        # http://domain.tld/index.php/some-path
        # Remove the internal directive to allow URIs like this
        internal;
    }

    # return 404 for all other php files not matching the front controller
    # this prevents access to other php files you don't want to be accessible.
    location ~ \.php$ {
        return 404;
    }
}
``` 

- ```sudo nginx -t```  para saber que esta funcionando bien
- ```sudo service nginx reload```
#### Ahora entramos en el proyecto por la terminal
-```cd /cd/var/www/baseDatosFutbol```
- Vemos si nos esta funcionando el symfony: ```symfony serve -d```
- Vemos que tenamos todos los paquetes de symfony actualizados y descargados ```composer require symfony/orm-pack```
#### Ya al saber que symfony funciona bien y que tenemos todo instalado y actualizado vamos a conectarnos a la base de datos para ellos seguimos los siguientes pasos:
- Primero cambiamos la ultima linea de el .env  que no esta conectada y ponemos ```DATABASE_URL="mysql://root:root@127.0.0.1:3306/baseDatosFutbol?serverVersion=5.7"``` con el nombre que queramos ponerle a la base de datos en este caso se va a llamar baseDatosFutbol
- Despues en la terminal creamos la base de datos con el comando ```hp bin/consle doctrine:database:create```
- Instalamos el maker-bundle de symfony para poder seguir con la base de datos con este comando: ```composer require symfony/maker-bundle --dev```
- Ahora vamos a crear en la base de datos las tablas con sus respectivos datos  ```php bin/console make:entity```
- las tablas que vamos a utilizar con sus respectivos datos , ninguno de ellos puede ser null, son las siguientes:


 | tablas:| Entrenador       | Player            | Club              |
 |--------|------------------|-------------------|-------------------|
 | Datos: |                  |                   |                   |
 |        | dni(String)      | dni(String)       |                   |
 |        | name(String)     | name(String)      | name(String)      |
 |        | las_name(String) | last_name(String) | last_name(String) |
 |        | team(String)     | team(String)      |                   |
 |        | salary(int)      | salary(int)       |                   |
 |        |                  |                   | Budget(int)       |
 |        |                  | position(String)  |                   |
 |        |                  | dorsal            |                   |
 |        | email(String)    | email(String)     | email(String)     |
 |        | phone(int)       | phone(int)        | phone(int)        |

- para darle las migraciones necesarias y funcione hacemos estos comandos ```symfony console make:migrations```  ```symfony console doctrine :migrations:migrate```
#### Ahora vamos a crear los controladores de cada clase
- ```bin/console make:controller ClubContoller```
- ```bin/console make:controller EntrenadorContoller```
- ```bin/console make:controller PlayerContoller```
- 


