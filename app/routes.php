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
/*
    $app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write('Hello world!');
        return $response;
    });
*/
    $app->group('/users', function (Group $group) {
        $group->get('', ListUsersAction::class);
        $group->get('/{id}', ViewUserAction::class);
    });

    $app->get('/home', HomeAction::class);

    $app->group('/login', function(Group $group){
        $group->get('', ViewLoginAction::class);
        $group->post('', LoginAction::class);
    });

    $app->post('/disconnect', DisconnectAction::class);

    $app->group('/signup', function(Group $group){
        $group->get('', ViewSignupAction::class);
        $group->post('', SignupAction::class);
    });

    $app->group('/profil', function(Group $group){
        $group->get('', ViewProfilAction::class);
        $group->post('', UpdateProfilAction::class);
    });

    $app->get("/galeries", ListGalerieAction::class);

    $app->group("/galerie", function(Group $group) {
        $group->get('/{id}', ViewGalerieAction::class);

        $group->get('/{id}/settings', SettingGalerieAction::class);
        $group->post('/{id}/settings', UpdateGalerieAction::class);
        $group->delete('/{id}/settings', DeleteGalerieAction::class);

        $group->get('/{id}/photos', ListGaleriePhotoAction::class);

        $group->get('/{id}/photo/{photo}', ViewPhotoAction::class);

        $group->get('/{id}/photo/{photo}/settings', ViewPhotoAction::class);
        $group->post('/{id}/photo/{photo}/settings', UpdatePhotoAction::class);
        $group->delete('/{id}/photo/{photo}/settings', DeletePhotoAction::class);
    });
};
