<?php
declare(strict_types=1);

use App\Application\Actions\Galerie\DeleteGalerieAction;
use App\Application\Actions\Galerie\HomeAction;
use App\Application\Actions\Galerie\ListGalerieAction;
use App\Application\Actions\Galerie\SettingGalerieAction;
use App\Application\Actions\Galerie\UpdateGalerieAction;
use App\Application\Actions\Galerie\ViewGalerieAction;
use App\Application\Actions\Photo\DeletePhotoAction;
use App\Application\Actions\Photo\ListGaleriePhotoAction;
use App\Application\Actions\Photo\SettingPhotoAction;
use App\Application\Actions\Photo\UpdatePhotoAction;
use App\Application\Actions\Photo\ViewPhotoAction;
use App\Application\Actions\UserConnection\DisconnectAction;
use App\Application\Actions\UserConnection\LoginAction;
use App\Application\Actions\UserConnection\SignupAction;
use App\Application\Actions\UserConnection\ViewLoginAction;
use App\Application\Actions\UserConnection\ViewSignupAction;
use App\Application\Actions\UserProfil\UpdateProfilAction;
use App\Application\Actions\UserProfil\ViewProfilAction;
use App\Application\Middleware\LoggedMiddleware;
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
        return $response->withHeader('location', 'home');
    });
/*
    $app->group('/users', function (Group $group) {
        $group->get('', ListUsersAction::class);
        $group->get('/{id}', ViewUserAction::class);
    });
*/
    $app->get('/home', HomeAction::class)->setName('home');

    $app->group('/login', function(Group $group){
        $group->get('', ViewLoginAction::class)->setName('login');
        $group->post('', LoginAction::class);
    });

    $app->get('/disconnect', DisconnectAction::class)->add(LoggedMiddleware::class)->setName('disconnect');

    $app->group('/signup', function(Group $group){
        $group->get('', ViewSignupAction::class)->setName('signup');
        $group->post('', SignupAction::class);
    });

    $app->group('/profil', function (Group $group) {
        $group->get('', ViewProfilAction::class)->setName('profil');
        $group->post('', UpdateProfilAction::class);
    })->add(LoggedMiddleware::class);

    $app->group('/galeries', function(Group $group){
        $group->get('', ListGalerieAction::class)->setName('galeries');
    });

    $app->group("/galerie", function(Group $group) {
        $group->get('/{id}', ViewGalerieAction::class)->setName('galerie');

        $group->get('/{id}/settings', SettingGalerieAction::class)->add(LoggedMiddleware::class);
        $group->post('/{id}/settings', UpdateGalerieAction::class)->add(LoggedMiddleware::class);
        $group->post('/{id}/delete', DeleteGalerieAction::class)->add(LoggedMiddleware::class);

        $group->get('/{id}/photos', ListGaleriePhotoAction::class);

        $group->get('/{id}/photo/{photo}', ViewPhotoAction::class);

        $group->get('/{id}/photo/{photo}/settings', SettingPhotoAction::class)->add(LoggedMiddleware::class);
        $group->post('/{id}/photo/{photo}/settings', UpdatePhotoAction::class)->add(LoggedMiddleware::class);
        $group->post('/{id}/photo/{photo}/delete', DeletePhotoAction::class)->add(LoggedMiddleware::class);
    });
};
