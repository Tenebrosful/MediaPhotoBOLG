<?php


namespace App\Application\Actions\Galerie;


use App\Application\Actions\Action;
use App\Domain\DomainException\DomainRecordNotFoundException;
use App\Domain\Galerie\Galerie;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;
use Slim\Routing\RouteContext;

class UpdateGalerieAction extends Action
{

    /**
     * route: POST /galerie/{id}/settings
     * @return Response
     * @throws DomainRecordNotFoundException
     * @throws HttpBadRequestException
     */
    protected function action(): Response
    {
        if(isset($this->args["id"])) {
            if($this->args["id"]==='new'){
                $galerie = new Galerie();
                $galerie->id_owner=$_SESSION['user']->id;
            }
            else {
                $galerie=Galerie::getById($this->args["id"]);
                if($galerie==null)
                    return $this->response->withStatus(404);
            }
            $galerie->nom=$_POST['titre'];
            $galerie->description=$_POST['description'];
            $galerie->isPrivate=false;
            $galerie->save();
            $url = RouteContext::fromRequest($this->request)->getRouteParser()->urlFor('galerie', ['id'=>$galerie->id]);
            return $this->response->withHeader('location', $url);
        }
        return $this->response;
    }
}