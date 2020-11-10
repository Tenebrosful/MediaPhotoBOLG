<?php


namespace App\Application\Actions\Photo;


use App\Application\Actions\Action;
use App\Domain\DomainException\DomainRecordNotFoundException;
use App\Domain\Galerie\Galerie;
use App\Domain\Image\Image;
use App\Domain\Pivots\ImageGalerie;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;
use Slim\Routing\RouteContext;

class UpdatePhotoAction extends Action
{

    /**
     * route: POST /galerie/{id}/photo/{photo}
     * @return Response
     * @throws DomainRecordNotFoundException
     * @throws HttpBadRequestException
     */
    protected function action(): Response
    {
        if(isset($this->args["id"])) {
            $galerie = Galerie::getById($this->args['id']);
            if($galerie!=null && $galerie->canAccessSettings()){
                if($this->args['photo']==='new'){
                    $image=new Image();
                    $imagegalerie = new ImageGalerie();
                }
                else {
                    $image = Image::getById($this->args['photo']);
                    if($image==null){
                        return $this->response->withStatus(404);
                    }
                    $imagegalerie = ImageGalerie::where('id_image', '=', $image->id)->where('id_galerie', '=', $galerie->id)->first();
                }
                $image->titre=$_POST["titre"];
                $image->description=$_POST["description"];
                $image->url=$this->getNewUrl();
                $image->save();

                $imagegalerie->id_galerie=$galerie->id;
                $imagegalerie->id_image=$image->id;
                $imagegalerie->save();

                $url = RouteContext::fromRequest($this->request)->getRouteParser()->urlFor('photo', ['id'=>$galerie->id, 'photo'=>$image->id]);
                return $this->response->withHeader('location', $url);            }
            else
                return $this->response->withStatus(404);
        }
        else {
            return $this->response->withHeader('location', 'galeries');
        }
        return $this->response;
    }

    private function getNewUrl()
    {
        return bin2hex(random_bytes(4));
    }
}