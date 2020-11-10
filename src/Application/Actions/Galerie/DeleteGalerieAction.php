<?php


namespace App\Application\Actions\Galerie;


use App\Application\Actions\Action;
use App\Domain\DomainException\DomainRecordNotFoundException;
use App\Domain\Galerie\Galerie;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;
use Slim\Routing\RouteContext;

class DeleteGalerieAction extends Action
{

    /**
     * route: POST /galerie/{id}/delete
     * @return Response
     * @throws DomainRecordNotFoundException
     * @throws HttpBadRequestException
     */
    protected function action(): Response
    {
        if(isset($this->args['id'])) {
            $galerie=Galerie::getById($this->args['id']);
            if($galerie!=null && $galerie->id_owner===$_SESSION['user']->id){
                $galerie->delete();
                $url = RouteContext::fromRequest($this->request)->getRouteParser()->urlFor('home');

                return $this->response->withHeader('location', $url);
            }
            else
                return $this->response->withStatus(404);
        }
        return $this->response;
    }
}