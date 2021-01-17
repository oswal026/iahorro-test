# Code Challenge iAhorro

Este repositorio contiene las instrucciones para probar una API REST con los siguientes Endpoints:

1. Persistir registro de solicitud de hipoteca en la BD.
2. Mostrar los registros disponibles de un experto hipotecario.
3. Consultar información base (Expertos y franjas horarias).

Prueba realizada en Lumen framework v8.0

## Requerimientos:
- Docker
- Docker-Compose

## Descripción
Este es un stack completo para ejecutar Lumen 8 en contenedores Docker usando la herramienta docker-compose.

Está compuesto por 3 contenedores:
- `nginx`, actuando como servidor web.
- `php`, contenedor PHP-FPM con la version PHP 7.4.
- `mysql`, actuando como Base de Datos con la versión 5.7.

## Instrucciones para ejecutar el proyecto

1. Clonar este repositorio.

2. Ubicarse en la carpeta donde ha descargado el repositorio y ejecutar los siguientes comandos:
    - `docker-compose up -d --build`
    
3. Se desplegaran los 3 contenedores:
    ```
       Creating iahorro-nginx ... done
       Creating mysql         ... done
       Creating iahorro-php   ... done
    ```

4. Ejecutar el comando `docker ps -a` para mostrar los contenedores que están funcionando.

5. Antes de ejecutar el proyecto:
    - Acceder al contenedor "iahorro-php" con el comando: `docker exec -it iahorro-php sh`.
    - Acceder a la raiz del proyecto: `cd iahorro-app`.
    - Duplicar el archivo ".env.example" y renombrarlo a ".env".
    - Ejecutar `composer update` para crear el vendor.
    - Ejecutar `php artisan migrate --seed` para crear las tablas y algunos datos base (expertos y franjas horarias).
    
6. Abrir el navegador y ejecutar la siguiente url: `http://localhost:8001/api/mortgage/base-data` (muestra información base).

7. Las colecciones Postman: iahorro.postman_collection.json y entorno-local.postman_environment.json contienen 3 requests y el entorno local para probar los 3 Endpoints.

```Nota: Si en el punto #5, falla el contenedor mysql, se debe cambiar el puerto del archivo docker-compose.yml, línea 35 por: - 127.0.0.1:4306:3306```

### Test Unitarios
1. Acceder a la consola del contenedor "iahorro-app" (Punto #5 de las instrucciones para ejecutar el proyecto).
2. Para ejecutar los tests, se debe ejecutar el siguiente comando: `vendor/bin/phpunit tests/MortgageTest.php`.

