<?php


namespace App\Application\Actions\UserConnection;


use App\Application\Actions\Action;
use App\Domain\DomainException\DomainRecordNotFoundException;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;

use App\Domain\User\User;

class SignupAction extends Action
{

    /**
     * route: POST /signup
     * @return Response
     * @throws DomainRecordNotFoundException
     * @throws HttpBadRequestException
     */
    protected function action(): Response
    {
        if(isset($_SESSION['user']))
            return $this->response->withHeader('location', 'home');
        else {
            if(isset($_POST['login']) && isset($_POST['password'])  && isset($_POST['passwordConfirmation'])  && isset($_POST['email'])) {
                if($_POST['password']===$_POST['passwordConfirmation']) {
                    $login = $_POST['login'];
                    if (User::getByIdentifiant($login) == null) {
                        $user = new User;
                        $user->identifiant = $login;
                        $user->password = password_hash($_POST['password'], PASSWORD_BCRYPT);
                        $user->email = $_POST['email'];
                        $user->save();
                        $user = User::getByIdentifiant($login);
                        $_SESSION['user'] = $user;
                        return $this->response->withHeader('location', 'home');
                    } else {
                        $message = "Ce nom de compte est déjà utilisé, veuillez en choisir un autre!";
                    }
                }
                else{
                    $message = "Les deux mots de passe sont diffèrent!";
                }
            }
            else
                $message="Vous devez renseigner toutes les informations pour pouvoir vous inscrire!";
            $this->request->getBody()->write($this->twig->render('Signup.twig', ['message'=>$message]));
            return $this->request;
        }
    }
}