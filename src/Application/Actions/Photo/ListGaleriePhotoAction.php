<?php


namespace App\Application\Actions\Photo;


use App\Application\Actions\Action;
use App\Domain\DomainException\DomainRecordNotFoundException;
use App\Domain\Galerie\Galerie;
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
        if(isset($this->args['id'])){
            $galerie=Galerie::getById($this->args['id']);
            if($galerie!=null){
                if(!$galerie->isPrivate || $galerie->canAccess()){
                    $this->response->getBody()->write(
                        $this->twig->render('ListPhoto.twig', ['photos'=>$galerie->images()])
                    );
                }
                else
                    return $this->response->withStatus(404);
            }
            else
                return $this->response->withStatus(404);
        }
        return $this->response;
    }
}