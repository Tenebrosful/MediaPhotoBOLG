<?php


namespace App\Application\Actions\Photo;


use App\Application\Actions\Action;
use App\Domain\DomainException\DomainRecordNotFoundException;
use App\Domain\Galerie\Galerie;
use App\Domain\Image\Image;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;

class SettingPhotoAction extends Action
{

    /**
     * route: GET /galerie/{id}/photo/{photo}/settings
     * @return Response
     * @throws DomainRecordNotFoundException
     * @throws HttpBadRequestException
     */
    protected function action(): Response
    {
        if(isset($this->args["id"]) && isset($this->args["photo"])) {
            $galerie = Galerie::getById($this->args['id']);
            if($galerie!=null && $galerie->canAccessSettings()){
                if($this->args['photo']==='new'){
                    $image=new Image();
                }
                else {
                    $image = Image::getById($this->args['photo']);
                    if($image==null){
                        return $this->response->withStatus(404);
                    }
                }
                $this->response->getBody()->write(
                    $this->twig->render('SettingsPhoto.twig', ['galerie'=>$galerie, 'photo'=>$image])
                );
            }
            else
                return $this->response->withStatus(404);
        }
        return $this->response;
    }
}