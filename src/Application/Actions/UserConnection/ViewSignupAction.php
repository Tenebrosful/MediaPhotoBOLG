<?php


namespace App\Application\Actions\UserConnection;


use App\Application\Actions\Action;
use App\Domain\DomainException\DomainRecordNotFoundException;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;

class ViewSignupAction extends Action
{

    /**
     * route: GET /signup
     * @return Response
     * @throws DomainRecordNotFoundException
     * @throws HttpBadRequestException
     */
    protected function action(): Response
    {
        if(!isset($_SESSION["user"])) {
            $this->response->getBody()->write(
                $this->twig->render('Signup.twig', [])
            );
            return $this->response;
        }
        else {
            return $this->response->withHeader('location', 'home');
        }
    }
}