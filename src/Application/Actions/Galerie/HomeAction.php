<?php


namespace App\Application\Actions\Galerie;


use App\Application\Actions\Action;
use App\Domain\DomainException\DomainRecordNotFoundException;
use App\Domain\Galerie\Galerie;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;

class HomeAction extends Action
{

    /**
     * route: GET /home
     * @return Response
     * @throws DomainRecordNotFoundException
     * @throws HttpBadRequestException
     */
    protected function action(): Response
    {
        $galeries = Galerie::limit(3)->get();

        $this->response->getBody()->write(
            $this->twig->render('Home.twig', ["galeries" => $galeries])
        );
        return $this->response;
    }
}