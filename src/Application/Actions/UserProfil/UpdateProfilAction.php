<?php


namespace App\Application\Actions\UserProfil;


use App\Application\Actions\Action;
use App\Domain\DomainException\DomainRecordNotFoundException;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;

class UpdateProfilAction extends Action
{

    /**
     * route: POST /profil
     * @return Response
     * @throws DomainRecordNotFoundException
     * @throws HttpBadRequestException
     */
    protected function action(): Response
    {
        if(!isset($_SESSION['user'])) {
            return $this->response->withHeader('location', 'home');
        }
        else {
            if (isset($_POST['oldpassword']) && isset($_POST['newpassword']) && isset($_POST['confirmnewpassword'])) {
                if ($_POST['newpassword'] === $_POST['confirmnewpassword']) {
                    if (password_verify($_POST['oldpassword'], $_SESSION['user']->password)) {
                        $_SESSION['user']->password = password_hash($_POST['newpassword'], PASSWORD_BCRYPT);
                        $_SESSION['user']->save();
                        return $this->response->withHeader('location', 'home');
                    } else {
                        $message = "Les deux mots de passe sont diffèrent!";
                    }
                } else {
                    $message = "Les deux mots de passe sont diffèrent!";
                }
            } else {
                $message = "Vous devez renseigner toutes les informations pour pouvoir changer votre mot de passe!";
            }
        }
        $this->response->getBody()->write(
            $this->twig->render('Profil.twig', ['message'=>$message])
        );
        return $this->response;
    }
}