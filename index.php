<?php
require_once 'vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse; // Użyj aliasu
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

// Definiowanie tras (routingu)
$routes = new RouteCollection();
$routes->add('homepage', new Route('/', ['_controller' => function() use ($twig) {
    return new SymfonyResponse($twig->render('index.twig', ['messageOne' => 'Witaj w Symfony!!!'],)); // Użyj aliasu
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
