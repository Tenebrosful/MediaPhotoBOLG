<?php
declare(strict_types=1);

use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\ViewUserAction;

use App\Application\Actions\Galerie\ListGalerieAction;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write('Hello world!');
        return $response;
    });

    $app->group('/users', function (Group $group) {
        $group->get('', ListUsersAction::class);
        $group->get('/{id}', ViewUserAction::class);
    });

    $app->get('/home', HomeAction::class);

    $app->get('/profil', ViewProfilAction::class);
    $app->post('/profil', UpdateProfilAction::class);

    $app->group("/galeries", function(Group $group) {
        $group->get('', ListGalerieAction::class);
        $group->get('/{id}', ViewGalerieAction::class);

        $group->get('/{id}/settings', SettingGalerieAction::class);
        $group->post('/{id}/settings', UpdateGalerieAction::class);
        $group->delete('/{id}/settings', DeleteGalerieAction::class);

        $group->get('/{id}/page/{page}', ListGaleriePhotoAction::class);

        $group->get('/{id}/photo/{photo}', ViewPhotoAction::class);

        $group->get('/{id}/photo/{photo}/settings', ViewPhotoAction::class);
        $group->post('/{id}/photo/{photo}/settings', UpdatePhotoAction::class);
        $group->delete('/{id}/photo/{photo}/settings', DeletePhotoAction::class);
    });
};
