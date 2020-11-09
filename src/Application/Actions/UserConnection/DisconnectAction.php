<?php


namespace App\Application\Actions\UserConnection;


use App\Application\Actions\Action;
use App\Domain\DomainException\DomainRecordNotFoundException;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;

class DisconnectAction extends Action
{

    /**
     * route: POST /disconnect
     * @return Response
     * @throws DomainRecordNotFoundException
     * @throws HttpBadRequestException
     */
    protected function action(): Response
    {
        if(isset($_SESSION['user'])){
            unset($_SESSION['user']);
            session_destroy();
            session_start();
            $this->response->withHeader('location', 'login');
        }
        return $this->response;
    }
}