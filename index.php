<?php
require_once 'vendor/autoload.php';
require_once 'db.php';  // Załaduj plik z połączeniem do bazy

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

// Konfiguracja Twig
$loader = new FilesystemLoader('templates');
$twig = new Environment($loader);

// Inicjalizacja połączenia z bazą danych
$db = new Database();
$pdo = $db->pdo;

// Pobieranie danych z tabeli projekty
$sql = "SELECT * FROM projekty";
$statement = $pdo->prepare($sql);
$statement->execute();
$projekty = $statement->fetchAll(PDO::FETCH_ASSOC);

// Definiowanie tras (routingu)
$routes = new RouteCollection();
$routes->add('homepage', new Route('/', ['_controller' => function() use ($twig, $projekty) {
    return new SymfonyResponse($twig->render('Home/index.twig', ['projekty' => $projekty]));
}]));

$routes->add('about', new Route('/about', ['_controller' => function() use ($twig) {
    return new SymfonyResponse($twig->render('Pages/about.twig'));
}]));

$routes->add('contact', new Route('/contact', ['_controller' => function() use ($twig) {
    return new SymfonyResponse($twig->render('Pages/contact.twig'));
}]));

// Tworzenie żądania
$request = Request::createFromGlobals();
$context = new RequestContext();
$context->fromRequest($request);

// Dopasowywanie trasy
$matcher = new UrlMatcher($routes, $context);

try {
    $attributes = $matcher->match($request->getPathInfo());
    $response = call_user_func($attributes['_controller']);
} catch (ResourceNotFoundException $e) {
    $response = new SymfonyResponse('Strona nie została znaleziona', 404);
}

// Wysyłanie odpowiedzi
$response->send();
?>
