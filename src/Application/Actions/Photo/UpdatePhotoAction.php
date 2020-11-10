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
                    if(!$this->uploadFile($image))
                        return $this->response->withStatus(404);
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
                $image->save();

                $imagegalerie->id_galerie=$galerie->id;
                $imagegalerie->id_image=$image->id;
                $imagegalerie->save();

                $url = RouteContext::fromRequest($this->request)->getRouteParser()->urlFor('photo', ['id'=>$galerie->id, 'photo'=>$image->id]);
                return $this->response->withHeader('location', $url);
            }
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

    private function uploadFile($image) : bool
    {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $image->url="/".$target_file;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
        if(isset($_POST["submit"])) {
            $check = getimagesize($_FILES["image"]["tmp_name"]);
            if($check == false) {
                return false;
            }
        }

// Check if file already exists
        if (file_exists($target_file)) {
            return false;
        }

// Check file size
        /*
        if ($_FILES["image"]["size"] > 500000) {
            return false;
        }
*/
// Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
            return false;
        }

// if everything is ok, try to upload file

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            //echo "The file ". htmlspecialchars( basename( $_FILES["image"]["name"])). " has been uploaded.";
            return true;
        } else {
            //echo "Sorry, there was an error uploading your file.";
            return false;
        }
    }
}