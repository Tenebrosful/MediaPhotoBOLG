<?php


namespace App\Application\Actions\Galerie;


use App\Application\Actions\Action;
use App\Domain\DomainException\DomainRecordNotFoundException;
use App\Domain\Galerie\Galerie;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;

class SettingGalerieAction extends Action
{

    /**
     * route: GET /galerie/{id}/settings
     * @return Response
     * @throws DomainRecordNotFoundException
     * @throws HttpBadRequestException
     */
    protected function action(): Response
    {
        if(isset($this->args["id"])) {
            if($this->args['id']==='new'){
                $galerie=new Galerie();
                $this->response->getBody()->write(
                    $this->twig->render('SettingsGalerie.twig', array('galerie'=>$galerie, 'new'=>true))
                );
            }
            else {
                $galerie = Galerie::getById($this->args['id']);
                if($galerie!=null && $galerie->canAccessSettings()){
                    $this->response->getBody()->write(
                        $this->twig->render('SettingsGalerie.twig', array('galerie'=>$galerie))
                    );
                }
                else
                    return $this->response->withStatus(404);
            }
        }
        else {
            return $this->response->withHeader('location', 'galeries');
        }
        return $this->response;
    }
}