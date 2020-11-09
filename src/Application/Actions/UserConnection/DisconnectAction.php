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
            session_destroy();
            return $this->response->withHeader('location', 'login');
    }
}