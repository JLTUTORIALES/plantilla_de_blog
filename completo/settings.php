<?php
    /*
        Variables que la plantilla de blog necesita para funcionar
    */

    session_start(); //Iniciar sessión para validación de administrador

    //Información general del Blog
    $info = [
        "title" => "Blog de ejemplo",
        "year" => 2021,
        "language" => "Es",
        "icon" => "https://digitaldefynd.com/wp-content/uploads/2020/07/Best-Abstract-Art-course-tutorial-class-certification-training-online-scaled.jpg",
        "brief_description" => "Una breve descripción <br> Lorem ipsum dolor sit amet consectetur adipisicing elit. Saepe nobis laboriosam dicta amet quas veniam exercitationem provident quo maxime vero ullam nostrum deleniti iusto, fugiat quod maiores expedita magni. Beatae."
    ];

    //Datos del administrador
    $admin = [
        "username" => "Admin",
        "password" => "12345ABC"
    ];

    //Información de la Base de Datos
    $database = [
        "server" => "localhost",
        "username" => "root",
        "password" => "",
        "db_name" => "blog_de_prueba"
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
        Consulta para crea la base de datos

        CREATE DATABASE blog_de_prueba;
        USE blog_de_prueba;

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