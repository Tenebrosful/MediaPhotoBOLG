<?php


namespace App\Application\Actions\Galerie;


use App\Application\Actions\Action;
use App\Domain\DomainException\DomainRecordNotFoundException;
use App\Domain\Galerie\Galerie;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;

class ListGalerieAction extends Action
{

    /**
     * route: GET /galeries   ?page={page} (optionnel)
     * @return Response
     * @throws DomainRecordNotFoundException
     * @throws HttpBadRequestException
     */
    protected function action(): Response
    {
        $array=array();

        if(isset($_GET['public'])){
            $array['publicchecked']='checked';
        }
        if(isset($_GET['private'])){
            $array['privatechecked']='checked';
        }
        if(isset($_GET['share'])){
            $array['sharechecked']='checked';
        }

        $galeries = Galerie::getFilter(isset($_GET['public']), isset($_GET['private']), isset($_GET['share']));
        if($galeries!=null)
            $array['galeries']=$galeries;
        $this->response->getBody()->write(
            $this->twig->render('ListGalerie.twig', $array)
        );
        return $this->response;
    }
}