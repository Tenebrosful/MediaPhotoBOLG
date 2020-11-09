<?php


namespace App\Application\Actions\Photo;


use App\Application\Actions\Action;
use App\Domain\DomainException\DomainRecordNotFoundException;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;

class ListGaleriePhotoAction extends Action
{

    /**
     * route: GET /galerie/{id}/photos   ?page={page} (optionnel)
     * @return Response
     * @throws DomainRecordNotFoundException
     * @throws HttpBadRequestException
     */
    protected function action(): Response
    {
        // TODO: Implement action() method.
    }
}