
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyVoteApi</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <header class="header">
        <h1 class="h1">MyVote Api Rest</h1>
    </header>

    <nav class="nav">
        <ul class="ul">
            <li>
                <a href="#introduccion">Introducción</a>
            </li>
            <li>
                <a href="#uso">Uso</a>
            </li>
            <li>
                <a href="#ejemplo">Ejemplo de Respuesta</a>
            </li>
            <li>
                <a href="#mer">MER</a>
            </li>
        </ul>
    </nav>

    <main class="main">
        <section class="section" id="introduccion">
            <p>
                MyVoteApi es una API RESTful que permite a los candidatos en 
                elecciones administrar una variedad de información 
                sobre el proceso electoral en Colombia.
            </p>
            <h3>La API ofrece información sobre:</h3>
            <ul class="ul">
                <li>Información general sobre los testigos electorales registrados.</li>
                <li>Mesas de votación.</li>
                <li>Puestos de votación.</li>
                <li>Jurados de votación.</li>
            </ul>
            <h3>Se requiere de autenticación.</h3>
            <ul class="ul">
                <li>Clona este repositorio <a href="https://github.com/ajmaestre/MyVoteApi" target="_blank">MyVoteApi</a>.</li>
                <li>Modifica la cadena de conexión con tu base de datos preferida en el archivo "database/config".</li>
                <li>
                    Dado que es una API desarrollada totalmente en PHP puro no es 
                    necesario instalar nada más que el mismo lenguaje y el respectivo motor de base de datos.
                </li>
            </ul>
        </section>
        <section class="section" id="uso">
            <p>
                Para los verbos HTTP PUT y DELETE el id correspondiente al registro 
                a actualizar o eliminar debe enviarse en el cuerpo de la solicitud HTTP.
            </p>
            <table>
                <tr>
                    <th>Verbos HTTP</th>
                    <th>Endpoints</th>
                    <th>Acción</th>
                </tr>
                <tr>
                    <td>GET</td>
                    <td>/api/routes/usuarioRoute </td>
                    <td>Obtiene la lista de todos los testigos</td>
                </tr>
                <tr>
                    <td>GET</td>
                    <td>/api/routes/usuarioRoute?id={id}</td>
                    <td>Obtiene la información de un usuario por su id</td>
                </tr>
                <tr>
                    <td>GET</td>
                    <td>/api/routes/usuarioRoute?page={page}</td>
                    <td>Obtiene la lista de usuarios por página de 50 usuarios</td>
                </tr>
                <tr>
                    <td>GET</td>
                    <td>/api/routes/puestoRoute </td>
                    <td>Obtiene la lista de todos los puestos de votación</td>
                </tr>
                <tr>
                    <td>GET</td>
                    <td>/api/routes/puestoRoute?id={id}</td>
                    <td>Obtiene la información de un puestos de votación por su id</td>
                </tr>
                <tr>
                    <td>GET</td>
                    <td>/api/routes/puestoRoute?page={page}</td>
                    <td>Obtiene la lista de puestos de votación por página de 50 usuarios</td>
                </tr>
                <tr>
                    <td>GET</td>
                    <td>/api/routes/mesaRoute </td>
                    <td>Obtiene la lista de todos las mesas de votación</td>
                </tr>
                <tr>
                    <td>GET</td>
                    <td>/api/routes/mesaRoute?id={id}</td>
                    <td>Obtiene la información de una mesa de votación por su id</td>
                </tr>
                <tr>
                    <td>GET</td>
                    <td>/api/routes/mesaRoute?page={page}</td>
                    <td>Obtiene la lista de mesas de votación por página de 50 usuarios</td>
                </tr>
                <tr>
                    <td>GET</td>
                    <td>/api/routes/juradoRoute </td>
                    <td>Obtiene la lista de todos los jurados de votación</td>
                </tr>
                <tr>
                    <td>GET</td>
                    <td>/api/routes/juradoRoute?id={id}</td>
                    <td>Obtiene la información de un jurado de votación por su id</td>
                </tr>
                <tr>
                    <td>GET</td>
                    <td>/api/routes/juradoRoute?page={page}</td>
                    <td>Obtiene la lista de jurados de votación por página de 50 usuarios</td>
                </tr>
                <tr>
                    <td>POST</td>
                    <td>/api/routes/usuarioRoute </td>
                    <td>Permite registrar un usuario o testigo de votación (solo puede hacerlo el administrador)</td>
                </tr>
                <tr>
                    <td>POST</td>
                    <td>/api/routes/puestoRoute</td>
                    <td>Permite registrar un puesto de votación</td>
                </tr>
                <tr>
                    <td>POST</td>
                    <td>/api/routes/mesaRoute</td>
                    <td>Permite registrar una mesa de votación</td>
                </tr>
                <tr>
                    <td>POST</td>
                    <td>/api/routes/juradoRoute</td>
                    <td>Permite registrar un jurado de votación</td>
                </tr>
            </table>
        </section>
        <section class="section" id="ejemplo">
            <h3>Ejemplo de Respuesta</h3>
            <ul class="ul">
                <li>Content type: "application/json".  Las respuestas son objetos JSON.</li>
                <li>El encabezado de respuesta contiene el código HTTP con el estado. </li>
                <li>
                    Ejemplo:
                    <pre>
                        {
                          "id": "4",
                          "nombre": "Josefina",
                          "apellido": "Bovea",
                          "cedula": "1033399777",
                          "cargo": "vicepresidente",
                          "id_mesa": "1"
                        }
                    </pre>
                </li>
            </ul>
            <h3>Tecnologías utilizadas</h3>
            <ul class="ul">
                <li>
                    <a href="https://www.php.net/" target="_blank">PHP 8.2.4</a> Un lenguaje de script 
                    popular y de propósito general que es especialmente adecuado para el desarrollo web.
                </li>
                <li>
                    <a href="https://www.apachefriends.org/es/index.html" target="_blank">XAMPP</a> Es una distribución de 
                    Apache completamente gratuita y fácil de instalar que contiene MariaDB, PHP y Perl. 
                    El paquete de instalación de XAMPP ha sido diseñado para ser increíblemente fácil 
                    de instalar y usar.
                </li>
                <li>
                    <a href="https://code.visualstudio.com/" target="_blank">Visual Studio Code</a> Es un editor de código fuente desarrollado por Microsoft. Es un entorno de desarrollo integrado (IDE) muy popular y ampliamente utilizado por desarrolladores de software en diversas plataformas, incluyendo Windows, macOS y Linux. Aunque es desarrollado por Microsoft, VS Code es de código abierto y gratuito.
                </li>
            </ul>
        </section>
        <section class="section" id="mer">
            <h3>Modelo de Entidad - Relación</h3>
            <img src="assets/images/MER.png" alt="">
        </section>
    </main>
    
</body>
</html>