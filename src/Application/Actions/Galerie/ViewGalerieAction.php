<?php


namespace App\Application\Actions\Galerie;


use App\Application\Actions\Action;
use App\Domain\DomainException\DomainRecordNotFoundException;
use App\Domain\Galerie\Galerie;
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
        if(isset($this->args["id"])){
            $galerie=Galerie::getById($this->args["id"]);
            if($galerie!=null){
                $this->response->getBody()->write(
                    $this->twig->render('galerie.twig', ['galerie'=>$galerie])
                );
            }
            else {
                $this->response->withStatus(404);
            }
        }
        return $this->response;
    }
}