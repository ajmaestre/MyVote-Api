# My-Vote-Api

## Introducción
MyVoteApi es una API RESTful que permite a los candidatos en elecciones administrar una variedad de información sobre el proceso electoral en Colombia.

## Características del proyecto
* La API ofrece información sobre:
  - Información general sobre los testigos electorales registrados.
  - Mesas de votación.
  - Puestos de votación.
  - Jurados de votación.
* Se requiere de autenticación.
## Versiones
* 1.0

## Guía de instalación
* Clona este repositorio [aquí](https://github.com/ajmaestre/MyVoteApi).
* Dado que es una API desarrollada totalmente en PHP puro no es necesario instalar nada más que el mismo lenguaje y el respectivo motor de base de datos.
* Modifica la cadena de conexión con tu base de datos preferida en el archivo "database/config".

## Uso
En la raiz de la API [pendiente](pendiente) se encuentra información útil sobre la API y una breve descripción de los endpoints disponibles.


## API Endpoints
Para los verbos HTTP PUT y DELETE el id correspondiente al registro a actualizar o eliminar debe enviarse en el cuerpo de la solicitud HTTP.
| Verbos HTTP| Endpoints                             				| Acción                                                              			|
| ---------- | ---------------------------------------------------- | ----------------------------------------------------------------------------- |
| POST        | /api/routes/auth                   				| Obtiene el token de autenticación del usuario a través de la contraseña y el correo electrónico (o el nombre de usuario)                               			|
| GET        | /api/routes/usuarioRoute                   				| Obtiene la lista de todos los testigos electorales registrados                               			|
| GET        | /api/routes/usuarioRoute?id={id}               				| Obtiene la información de un usuario por su id                       			|
| GET        | /api/routes/usuarioRoute?page={page}        				| Obtiene la lista de usuarios por página de 50 usuarios                   			|
| GET        | /api/routes/puestoRoute                   				| Obtiene la lista de todos los puestos de votación registrados                               			|
| GET        | /api/routes/puestoRoute?id={id}               				| Obtiene la información de un puesto de votación por su id                       			|
| GET        | /api/routes/puestoRoute?page={page}        				| Obtiene la lista de los puestos de votación por página de 50 puestos de votación                   			|
| GET        | /api/routes/mesaRoute                   				| Obtiene la lista de todas las mesas de votación registradas                               			|
| GET        | /api/routes/mesaRoute?id={id}               				| Obtiene la información de una mesa de votación por su id                       			|
| GET        | /api/routes/mesaRoute?page={page}        				| Obtiene la lista de las mesas de votación por página de 50 mesas de votación                   			|
| GET        | /api/routes/juradoRoute                   				| Obtiene la lista de todos los jurados de votación registradas                               			|
| GET        | /api/routes/juradoRoute?id={id}               				| Obtiene la información de un jurado de votación por su id                       			|
| GET        | /api/routes/juradoRoute?page={page}        				| Obtiene la lista de los jurados de votación por página de 50 jurados de votación                   			|
| POST        | /api/routes/usuarioRoute        				| Permite registrar un usuario o testigo de votación (solo puede hacerlo el administrador)                   			|
| POST        | /api/routes/puestoRoute        				| Permite registrar un puesto de votación                   			|
| POST        | /api/routes/mesaRoute        				| Permite registrar una mesa de votación                   			|
| POST        | /api/routes/juradoRoute        				| Permite registrar un jurado de votación                   			|
| DELETE        | /api/routes/usuarioRoute        				| Permite eliminar un usuario o testigo de votación (solo puede hacerlo el administrador)                   			|
| DELETE        | /api/routes/puestoRoute        				| Permite eliminar un puesto de votación                   			|
| DELETE        | /api/routes/mesaRoute        				| Permite eliminar una mesa de votación                   			|
| DELETE        | /api/routes/juradoRoute        				| Permite eliminar un jurado de votación                   			|
| PUT        | /api/routes/usuarioRoute        				| Permite actualizar un usuario o testigo de votación (solo puede hacerlo el administrador)                   			|
| PUT        | /api/routes/puestoRoute        				| Permite actualizar un puesto de votación                   			|
| PUT        | /api/routes/mesaRoute        				| Permite actualizar una mesa de votación                   			|
| PUT        | /api/routes/juradoRoute        				| Permite actualizar un jurado de votación                   			|

## Ejemplo de Respuesta
* Content type: "application/json".  Las respuestas son objetos JSON.
* El encabezado de respuesta contiene el código HTTP con el estado. 
* Ejemplo:
 
```json
{
  "id": "4",
  "nombre": "Josefina",
  "apellido": "Bovea",
  "cedula": "1033399777",
  "cargo": "vicepresidente",
  "id_mesa": "1"
}
 ```
## Tecnologías utilizadas
* [PHP 8.2.4](https://www.php.net/) Un lenguaje de script popular y de propósito general que es especialmente adecuado para el desarrollo web.
* [XAMPP](https://www.apachefriends.org/es/index.html) es una distribución de Apache completamente gratuita y fácil de instalar que contiene MariaDB, PHP y Perl. El paquete de instalación de XAMPP ha sido diseñado para ser increíblemente fácil de instalar y usar..
* [Visual Studio Code](https://code.visualstudio.com/) es un editor de código fuente desarrollado por Microsoft. Es un entorno de desarrollo integrado (IDE) muy popular y ampliamente utilizado por desarrolladores de software en diversas plataformas, incluyendo Windows, macOS y Linux. Aunque es desarrollado por Microsoft, VS Code es de código abierto y gratuito.

## Modelo de Entidad - Relación de la base de datos

<img src="assets/images/MER.png">

