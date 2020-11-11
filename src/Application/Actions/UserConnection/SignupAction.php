<?php


namespace App\Application\Actions\UserConnection;


use App\Application\Actions\Action;
use App\Domain\DomainException\DomainRecordNotFoundException;
use App\Domain\User\User;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;

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
            if (!empty($_POST['login']) && !empty($_POST['password']) && !empty($_POST['passwordConfirmation']) && !empty($_POST['email'])) {
                if ($_POST['password'] === $_POST['passwordConfirmation']) {
                    $login = filter_var($_POST['login'], FILTER_SANITIZE_STRING);
                    if (User::getByIdentifiant($login) == null) {
                        $user = new User;
                        $user->identifiant = $login;
                        $user->password = password_hash($_POST['password'], PASSWORD_BCRYPT);
                        $user->email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
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
            $this->response->getBody()->write(
                $this->twig->render('Signup.twig', ['message'=>$message])
            );
            return $this->response;
        }
    }
}