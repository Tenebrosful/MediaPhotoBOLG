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
                    $image->titre=$_POST["titre"];
                    $image->description=$_POST["description"];
                    switch($this->uploadFile($image)) {
                        case 1:
                            $message="L'image est invalide";
                            break;
                        case 2:
                            $message="Le nom de l'image est invalide";
                            break;
                        case 3:
                            $message="Failed";
                            break;
                    }
                    if(isset($message)){
                        $this->response->getBody()->write(
                            $this->twig->render('SettingsPhoto.twig', ['message'=>$message, 'photo'=>$image])
                        );
                        return $this->response;
                    }

                    $imagegalerie = new ImageGalerie();
                }
                else {
                    $image = Image::getById($this->args['photo']);
                    if($image==null){
                        return $this->response->withStatus(404);
                    }
                    $image->titre=$_POST["titre"];
                    $image->description=$_POST["description"];
                    $imagegalerie = ImageGalerie::where('id_image', '=', $image->id)->where('id_galerie', '=', $galerie->id)->first();
                }
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

    private function uploadFile($image) : int
    {
        $target_dir = "uploads/";
        $target_file = $target_dir . rand() . "_" . filter_var($_FILES['image']['name'], FILTER_SANITIZE_URL);
        $image->url = "/" . $target_file;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
        if (isset($_POST["submit"])) {
            $check = getimagesize($_FILES["image"]["tmp_name"]);
            if ($check == false) {
                return 1;
            }
        }

// Check if file already exists
        if (file_exists($target_file)) {
            return 2;
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
            return 1;
        }

// if everything is ok, try to upload file

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            //echo "The file ". htmlspecialchars( basename( $_FILES["image"]["name"])). " has been uploaded.";
            return 0;
        } else {
            //echo "Sorry, there was an error uploading your file.";
            return 3;
        }
    }
}