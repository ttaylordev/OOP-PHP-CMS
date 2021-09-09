<?php 
    declare(strict_types=1);
    session_start();

    define('ROOT_PATH', dirname(__FILE__) . DIRECTORY_SEPARATOR);
    define('VIEW_PATH', ROOT_PATH . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR);


    require_once ROOT_PATH . './src/Controller.php';
    require_once ROOT_PATH . './src/Template.php';
    require_once ROOT_PATH . './src/DbConnection.php';
    require_once ROOT_PATH . './src/Entity.php';
    require_once ROOT_PATH . './src/Router.php';
    require_once ROOT_PATH . './model/Page.php';

    DbConnection::connect('localhost', 'oop-cms', 'root');


    // routing
    $action = $_GET['seo_name'] ?? 'home';

    $dbh = DbConnection::getInstance();
    $dbc = $dbh->getConnection();

    $router = new Router($dbc);
    $router->findBy('pretty_url', $action);
    $action = $router->action != '' ? $router->action : 'default';

    // specifies which *Controller.php to use
    $moduleName =  ucfirst($router->module) . 'Controller';

    if(file_exists(ROOT_PATH . './controller/' . $moduleName . '.php')) {
    
        include ROOT_PATH . './controller/' . $moduleName . '.php';
        $controller = new $moduleName();
        $controller->setEntityId($router->entity_id);
        $controller->runAction($action);
    } else {
    
        echo "index.php: moduleName does not exist: " . $moduleName;
    }   
