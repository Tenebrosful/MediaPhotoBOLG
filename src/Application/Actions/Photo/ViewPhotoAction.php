<?php


namespace App\Application\Actions\Photo;


use App\Application\Actions\Action;
use App\Domain\DomainException\DomainRecordNotFoundException;
use App\Domain\Galerie\Galerie;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;

class ViewPhotoAction extends Action
{

    /**
     * route: GET /galerie/{id}/photo/{photo}
     * @return Response
     * @throws DomainRecordNotFoundException
     * @throws HttpBadRequestException
     */
    protected function action(): Response
    {
        if(isset($this->args["id"]) && isset($this->args["photo"])){
            $galerie=Galerie::getById($this->args["id"]);
            if($galerie!=null){
                $photo=$galerie->image($this->args["photo"]);
                if($photo!=null) {
                    $this->response->getBody()->write(
                        $this->twig->render('photo.twig', ['galerie'=>$galerie, 'photo' => $photo])
                    );
                }
                else {
                    return $this->response->withStatus(404);
                }
            }
            else {
                return $this->response->withStatus(404);
            }
        }
        return $this->response;
    }
}