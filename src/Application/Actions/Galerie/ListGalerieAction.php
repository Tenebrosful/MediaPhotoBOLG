<?php


namespace App\Application\Actions\Galerie;


use App\Application\Actions\Action;
use App\Domain\DomainException\DomainRecordNotFoundException;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;

class ListGalerieAction extends Action
{

    /**
     * route: GET /galeries   ?page={page} (optionnel)
     * @return Response
     * @throws DomainRecordNotFoundException
     * @throws HttpBadRequestException
     */
    protected function action(): Response
    {
        $this->response->getBody()->write(
            $this->twig->render('ListGalerie.twig', array())
        );
        return $this->response;
    }
}