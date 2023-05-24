# Mini Aplicación Symfony API Rest 
## Mini Aplicación con base de datos que gestiones clubes, jugadores y entrenadores

## _Creacion Proyecto en Symfoni_
#### En la terminal ponemos el proximo comando,para entrar en el directorio que queremos crear el proyecto:
- ```cd/var/www```
#### Con el siguiente comando creamos el proyecto en symfony que se va a llamar baseDatosFutbol:
  - ```sudo symfony ne baseDatosFutbol"```
#### Despues le metemos los permisos necesarios:
- ```sudo chmod 775 baseDatosFutbol/ -Rf```
- ```sudo chown marta.www-data baseDatosFutbol/ -Rf```

![carpetaProyecto.png](src%2Fimagenes%2FcarpetaProyecto.png)

### Tambien le damos permisos en ngixn siguiendo los siguiente comandos:
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
## _Base de datos_
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

## _PhpStorm_
### Ahora vamos a crear las clases Controller de cada clase que atiende a los mensajes que manda el usuario 
- ```bin/console make:controller ClubContoller```
- ```bin/console make:controller coachContoller```
- ```bin/console make:controller PlayerContoller```

![Controllers.png](src%2Fimagenes%2FControllers.png)

([ClubController.php](src%2FController%2FClubController.php))

([coachController.php](src%2FController%2FcoachController.php))

#### En el metodo Create y Delete tiene una opcion para que al dar de alta o de baja un Coach te envie un email avisandote

([PlayerController.php](src%2FController%2FPlayerController.php))

#### En el metodo Create y Delete tiene una opcion para que al dar de alta o de baja a un Player te envie un email avisandote

#### En las clases Controllers vamos a meter los metodos create, update,delete, show, index. vamos a ver estos metodos como ejemplo en la clase club
#### El constructor, en el que fuera del constructor ponemos en privado a las entidades , ```$entityManager```, ```$clubRepository``` de la clase ClubRepository y ```$validator```, y dentro del constructor los llamamos :
### Constructor 

![constructorClaseClub.png](src%2Fimagenes%2FconstructorClaseClub.png)

####  Arriba antes de entrar al metodo ponemos la ruta por la que queremos llamar a este metodo.
### Metodo Create:
![MetodoCreateClub.png](src%2Fimagenes%2FMetodoCreateClub.png)

### Metodo Index:

![MetodoIndexClub.png](src%2Fimagenes%2FMetodoIndexClub.png)

### Metodo Update:

![MetodoUpdateClub.png](src%2Fimagenes%2FMetodoUpdateClub.png)

### Metodo Delete:

![MetodoDeleteClub.png](src%2Fimagenes%2FMetodoDeleteClub.png)

### Metodo Show:

![MetodoShowClub.png](src%2Fimagenes%2FMetodoShowClub.png)

#### En la clase Club tambien vamos a meter el metodo de sar de alta un player en el club, dar de alta un coach en el club, dar de baja un player del club y dar de baja un coach del club

### Metodo dar de alta un player en el club que te envie un email cuando te das de alta

![MetodoClubCreatePlayer.png](src%2Fimagenes%2FMetodoClubCreatePlayer.png)

### Metodo dar de alta un coach en el club que te envie un email cuando te das de alta

![MetodoClubCreateCoach.png](src%2Fimagenes%2FMetodoClubCreateCoach.png)

### Metodo dar de baja un player de un club que te envie un email cuando te das de baja

![MetodoClubDeletePlayer.png](src%2Fimagenes%2FMetodoClubDeletePlayer.png)

### Metodo dar de baja un coach de un club que te envie un email cuando te das de baja

![MetodoClubDeleteCoach.png](src%2Fimagenes%2FMetodoClubDeleteCoach.png)

#### En la clase Player aparte de los metodos index, create,  delete, show y update vamos a meter un metodo para listar los nombres de  los players que tengan un club con paginacion.

### Metodo listar los players que tengan un club

![MetodoListarPlayerconunClub.png](src%2Fimagenes%2FMetodoListarPlayerconunClub.png)

#### Este metodo esta conectado con la clase PlayerController en la que tiene el metodo findByClubAndProperty

### Metodo findByClubAndProperty de la clase PlayerController

![MetodoFinfByClubAndProperty.png](src%2Fimagenes%2FMetodoFinfByClubAndProperty.png)

### Ahora vamos a crear las clases From que nos servira para recoger los datos y crear formularios en los que cada atributo de cada clase tendra sus constraints especificos dependiendo del atributo
- ```hp bin/console make:form PlayerType```

![crearPlayerType.png](src%2Fimagenes%2FcrearPlayerType.png)

- ```hp bin/console make:form CoachType```

![crearEntrenadorType.png](src%2Fimagenes%2FcrearEntrenadorType.png)

- ```hp bin/console make:form ClubType```

![carpetaForm.png](src%2Fimagenes%2FcarpetaForm.png)

([ClubType.php](src%2FForm%2FClubType.php))

([CoachType.php](src%2FForm%2FCoachType.php))

([PlayerType.php](src%2FForm%2FPlayerType.php))

#### Echo esto, vamos a ver las clases que nos faltan y vamos a utilizar 
### Las clases del directorio Entity son Player,Entrenador y Club que guardan en ellas los campos que hay en cada clase que tipo de datos son y los get y set de cada campo

![entity.png](src%2Fimagenes%2Fentity.png)

([Club.php](src%2FEntity%2FClub.php))

([Coach.php](src%2FEntity%2FCoach.php))

([Player.php](src%2FEntity%2FPlayer.php))

#### Las clases Entity tambien les metimos un codigo para que los atributos que queramos no se repitan

### Clase para que no se repitan los atributos

![MetodoNoRepetir.png](src%2Fimagenes%2FMetodoNoRepetir.png)

### La clase de errores para que te especifica que error da cuando envias el metodo create o update.

![ClaseErrores.png](src%2Fimagenes%2FClaseErrores.png)

![CodigoClaseErrores.png](src%2Fimagenes%2FCodigoClaseErrores.png)

([FormErrorsToArray.php](src%2FHelper%2FFormErrorsToArray.php))
### Clase Listener que recoge que los datos se tienen que enviar un JSON

![ClaseListener.png](src%2Fimagenes%2FClaseListener.png)

![CodigoClaseListener.png](src%2Fimagenes%2FCodigoClaseListener.png)

([RequestJsonListener.php](src%2FListener%2FRequestJsonListener.php))

### Directorio Validator que dentro tiene una clase SalaryValidator

#### La clase SalaryValidator y CoachSalaryValidator sirve para que cuando el Salary del player o Coach sea mayor que el budget de el Club de error y no deje crear el player o el coach
![ClaseValidator.png](src%2Fimagenes%2FClaseValidator.png)

![ClaseSalaryValidator.png](src%2Fimagenes%2FClaseSalaryValidator.png)

([SalaryValidator.php](src%2FValidator%2FSalaryValidator.php))

([CoachSalaryValidator.php](src%2FValidator%2FCoachSalaryValidator.php))


## _POSTMAN_ 
#### Para ver si los metodos de create, update,delete, show, index que pusimos en la clase Controller de cada tabla funciona vamos a utilizar la aplicacion postman en la que pondremos la Url de busqueda de cada metodo para ver si funciona con nginx


#### En postman vamos a crear una nueva coleccion llamada baseDatosFutbol y dentro de ella vamos a crear 3 carpetas que se van a llamar PLayer,Entrenador y Club como nuestras clases entity y un request que se va a llamar pagina inicia que nos va a llevar a la pagina inicial.
#### Dentro de cada carpeta vamos a crear 5 request cada uno por un metodo(create, delete, update, show, index) que va tener cada carpeta referente a cada clase.

![PostmanOrganizacion.png](src%2Fimagenes%2FPostmanOrganizacion.png)

#### Para que nos lleve a la pagina inicial ponemos la url, en el campo de la URL, que pusimos en el codigo de arriba en nginx en este caso futbol.localhost y al lado de la url ponemos POTs y le damos a send para enviar y abajo en Preview vemos la pagina inicial.

![postmanPaginaInicial.png](src%2Fimagenes%2FpostmanPaginaInicial.png)

#### Ahora vamos a ver si el metodo Create funciona en la clase Club entramos en el request create Clubs en la opcion Body le damos a la opcion raw y a la izquierda de todo a JSON metemos el codigo Json como vemos en el ejemplo siguiente:
![CreateClubs.png](src%2Fimagenes%2FCreateClubs.png)

#### Despues de esto le damos a enviar y nos tiene que llegar un mensaje en la parte de abajo de que el club a sido creado correctamente
![ClubCreadoCorrectamente.png](src%2Fimagenes%2FClubCreadoCorrectamente.png)

#### Hacemos lo mismo con los demas metodos, delete, update,index, show, club_create_player, club_create_coach, club_delete_player, club_delete_coachy listar Players con un club poniendole la URL que le hayas puesto tu en el codigo
#### en los metodos index, delete, y show no hace faltas meter codigo en JSON debido a que no vamos a crear ni cambiar ningun dato solo nos tiene que devolver por pantalla que el metodo se ejecuto correctamente.


