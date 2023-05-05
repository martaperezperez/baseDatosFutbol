# Mini Aplicación Symfony API Rest 
## Mini Apli

cación con b

ase de datos que gestiones clubes, jugadores y entrenadores

### Primero creamos un proyecto en symfony 
#### En la terminal ponemos el proximo comando,para entrar en el directorio que queremos crear el proyecto:
- ```cd/var/www```
#### Con el siguiente comando crwamos el proyecto en symfony que se va a llamar baseDatosFutbol:
  - ```sudo symfony ne baseDatosFutbol"```
#### Despues le metemos los permisos necesarios:
- ```sudo chmod 775 baseDatosFutbol/ -Rf```
- ```sudo chown marta.www-data baseDatosFutbol/ -Rf```

![carpetaProyecto.png](src%2Fimagenes%2FcarpetaProyecto.png)

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
![codigo.png](src%2Fimagenes%2Fcodigo.png)

#### comprobamos que este funcionando
![site-avaible.png](src%2Fimagenes%2Fsite-avaible.png)

![site-enable.png](src%2Fimagenes%2Fsite-enable.png)
- ```sudo nginx -t```  para saber que esta funcionando bien

![nginxFUncionando.png](src%2Fimagenes%2FnginxFUncionando.png)

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

![baseDatos.png](src%2Fimagenes%2FbaseDatos.png)

![tablaEntrenador.png](src%2Fimagenes%2FtablaEntrenador.png)

![tablaJugador.png](src%2Fimagenes%2FtablaJugador.png)

![tablaClub.png](src%2Fimagenes%2FtablaClub.png)

- para darle las migraciones necesarias y funcione hacemos estos comandos ```symfony console make:migrations```  ```symfony console doctrine :migrations:migrate```
#### Ahora vamos a crear las clases Controller de cada clase que atiende a los mensajes que manda el usuario 
- ```bin/console make:controller ClubContoller```
- ```bin/console make:controller EntrenadorContoller```
- ```bin/console make:controller PlayerContoller```

![Controllers.png](src%2Fimagenes%2FControllers.png)

#### Ahora vamos a crear las clases From que nos servira para recoger los datos y crear formularios
- ```hp bin/console make:form PlayerType```

![crearPlayerType.png](src%2Fimagenes%2FcrearPlayerType.png)

- ```hp bin/console make:form EntrenadorType```

![crearEntrenadorType.png](src%2Fimagenes%2FcrearEntrenadorType.png)

- ```hp bin/console make:form ClubType```

![carpetaForm.png](src%2Fimagenes%2FcarpetaForm.png)

#### Echo esto, vamos a ver las clases que nos faltan y vamos a utilizar 
#### Las clases del directorio Entity son Player,Entrenador y Club que guardan en ellas los campos que hay en cada clase que tipo de datos son y los get y set de cada campo

![entity.png](src%2Fimagenes%2Fentity.png)


#### Para ver si los metodos de create, update,delete, show, index que pusimos en la clase Controller de cada tabbla funciona vamos a utilizar la aplicacion postman en la que pondremos la Url de busqueda de cada metodo para ver si funciona con nginx


#### Vamos a crear una nueva coleccion llamada baseDatosFutbol y dentro de ella vamos a crear 3 carpetas que se van a llamar PLayer,Entrenador y Club como nuestras clases entity y un request que se va a llamar pagina inicia que nos va a llevar a la pagina inicial.
#### Dentro de cada carpeta vamos a crear 5 request cada uno por un metodo(create, delete, update, show, index) que va tener cada carpeta referente a cada clase.

![postmanOrganizacion.png](src%2Fimagenes%2FpostmanOrganizacion.png)

#### Para que nos lleve a la pagina inicial ponemos la url, en el campo de la URL, que pusimos en el codigo de arriba en nginx en este caso futbol.localhost y al lado de la url ponemos POTs y le damos a send para enviar y abajo en Preview vemos la pagina inicial.

![postmanPaginaInicial.png](src%2Fimagenes%2FpostmanPaginaInicial.png)



