<?php


namespace App\Application\Actions\UserConnection;


use App\Application\Actions\Action;
use App\Domain\DomainException\DomainRecordNotFoundException;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;

class ViewLoginAction extends Action
{

    /**
     * route: GET /login
     * @return Response
     * @throws DomainRecordNotFoundException
     * @throws HttpBadRequestException
     */
    protected function action(): Response
    {
        if (isset($_SESSION['user'])) {
            $this->response->getBody()->write(
                $this->twig->render('Home.twig', array())
            );
        } else {
            $this->response->getBody()->write(
                $this->twig->render('Login.twig', array())
            );
        }
        return $this->response;
    }
}