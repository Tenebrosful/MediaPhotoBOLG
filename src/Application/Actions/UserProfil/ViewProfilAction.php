<?php


namespace App\Application\Actions\UserProfil;


use App\Application\Actions\Action;
use App\Domain\DomainException\DomainRecordNotFoundException;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;

class ViewProfilAction extends Action
{

    /**
     * route: GET /profil
     * @return Response
     * @throws DomainRecordNotFoundException
     * @throws HttpBadRequestException
     */
    protected function action(): Response
    {
        if(isset($_SESSION['user'])){
            $this->response->getBody()->write(
                $this->twig->render('Profil.twig', array())
            );
        }
        return $this->response;
    }
}