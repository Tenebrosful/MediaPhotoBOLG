<?php


namespace App\Application\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface as Middleware;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;
use Slim\Routing\RouteContext;

class LoggedMiddleware implements Middleware
{
    /**
     * {@inheritdoc}
     */
    public function process(Request $request, RequestHandler $handler): ResponseInterface
    {
        if (!empty($_SESSION['user'])) {
            return $handler->handle($request);
        } else {
            $_SESSION['message'] = "L'accès à cette page demande d'être connecté !";

            $routeParser = RouteContext::fromRequest($request)->getRouteParser();
            $response = new Response();
            return $response->withHeader('Location', $routeParser->urlFor('login'))->withStatus(302);
        }
    }
}