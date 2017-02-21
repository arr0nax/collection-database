<?php
    date_default_timezone_set("America/Los_Angeles");
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/src.php";

    $app = new Silex\Application();
    $app->register(new Silex\Provider\TwigServiceProvider(), ["twig.path" => __DIR__."/../views"]);

    $server = 'mysql:host=localhost:8889;dbname=inventory';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server,$username,$password);

    $app->get('/', function() use($app) {
        $result = Inventory::getAll();
        return $app["twig"]->render("root.html.twig", ['result' => $result]);
    });

    $app->post('/additem', function() use($app) {
        $item = $_POST['item'];
        $description = $_POST['description'];
        $new_inventory = new Inventory($item, $description);
        $new_inventory->save();
        $result = Inventory::getAll();
        return $app["twig"]->render("root.html.twig", ['result' => $result]);
    });

    $app->get('/clearlist', function() use($app) {
        Inventory::deleteAll();
        $result = Inventory::getAll();
        return $app['twig']->render('root.html.twig', ['result' => $result]);
    });

    $app->post('/search', function() use($app) {
        $result = Inventory::searchAll($_POST['search_term']);
        return $app['twig']->render('root.html.twig', ['result' => $result]);
    });

    $app->post('/change', function() use($app) {
        Inventory::replace($_POST['old_name'], $_POST['new_name']);
        $result = Inventory::getAll();
        return $app['twig']->render('root.html.twig', ['result' => $result]);
    });

    return $app;
?>
