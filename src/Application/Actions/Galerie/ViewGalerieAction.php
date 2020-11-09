<?php


namespace App\Application\Actions\Galerie;


use App\Application\Actions\Action;
use App\Domain\DomainException\DomainRecordNotFoundException;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;

class ViewGalerieAction extends Action
{

    /**
     * route: GET /galerie/{id}
     * @return Response
     * @throws DomainRecordNotFoundException
     * @throws HttpBadRequestException
     */
    protected function action(): Response
    {
        // TODO: Implement action() method.
    }
}