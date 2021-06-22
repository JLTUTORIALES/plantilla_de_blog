<?php session_start(); //Iniciar sessión para validación de administrador
    /*
        Variables que la plantilla de blog necesita para funcionar
    */

    //Información general del Blog
    $info = [
        "title" => "Plantilla de Blog",
        "year" => 2021,
        "language" => "Es",
        "icon" => "https://imgur.com/iPOAh1u.jpg",
        "brief_description" => "Este es un proyecto de plantilla de blog diseñado como proyecto personal pensando en el uso de diversas tecnologías"
    ];

    //Datos del administrador
    $admin = [
        "username" => "Admin",
        "password" => "12345ABC"
    ];

    //Información de la Base de Datos
    $database = [
        "server" => "localhost",
        "username" => "luisj82_admin",
        "password" => "AdminDeBBDD123",
        "db_name" => "luisj82_plantilla_blog"
    ];

    //Incluír la clase blog_struct para optimizar el uso de require en las páginas
    require_once('res/struct.php');

    //Detectar si es administrador
    function is_admin(){
        if (isset($_SESSION['admin']) && $_SESSION['admin']){
            return true;
        }
        return false;
    }

    //Conectar a la base de datos
    function db_connect(){
        global $database;

        return mysqli_connect(
            $database['server'],
            $database['username'],
            $database['password'],
            $database['db_name']
        );
    }

    /*
        Consulta para crea la tabla de la base de datos

        CREATE TABLE post(
            id INT PRIMARY KEY AUTO_INCREMENT,
            fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            views INT DEFAULT 0,
            title VARCHAR (255) NOT NULL,
            url VARCHAR (255) NOT NULL UNIQUE,
            thumb VARCHAR (255) NOT NULL,
            descr MEDIUMTEXT,
            content MEDIUMTEXT NOT NULL,
            status BOOLEAN NOT NULL
        );
    
    */
?>