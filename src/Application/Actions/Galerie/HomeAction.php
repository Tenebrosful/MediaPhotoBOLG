<?php


namespace App\Application\Actions\Galerie;


use App\Application\Actions\Action;
use App\Domain\DomainException\DomainRecordNotFoundException;
use App\Domain\Galerie\Galerie;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;

class HomeAction extends Action
{

    /**
     * @return Response
     * @throws DomainRecordNotFoundException
     * @throws HttpBadRequestException
     */
    protected function action(): Response
    {
        $this->response->getBody()->write(
            $this->twig->render('Home.twig', array("galeries"=>Galerie::inRandomOrder()->limit(5)->get()))
        );
        return $this->response;
    }
}