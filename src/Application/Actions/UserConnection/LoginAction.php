<?php


namespace App\Application\Actions\UserConnection;


use App\Application\Actions\Action;
use App\Domain\DomainException\DomainRecordNotFoundException;
use App\Domain\User\User;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;

class LoginAction extends Action
{

    /**
     * route: POST /login
     * @return Response
     * @throws DomainRecordNotFoundException
     * @throws HttpBadRequestException
     */
    protected function action(): Response
    {
        if(isset($_SESSION['user'])) {
            $this->response->withHeader('location', 'home');
        }
        else {
            if(isset($_POST["login"]) && isset($_POST["password"])) {
                $login=$_POST["login"];
                $password=$_POST["password"];
                $user = User::getByIdentifiant($login);

                if($user!=null && password_verify($password, $user->password)) {
                    $_SESSION['user']=$user;
                    return $this->response->withHeader('location', 'home');
                }
                else {
                    $this->response->getBody()->write(
                        $this->twig->render('Login.twig', ['message' => 'login or password invalid'])
                    );
                }
            }
            else {
                $this->response->getBody()->write(
                    $this->twig->render('Login.twig', ['message' => 'Vous devez renseigner les deux champs!'])
                );
            }
        }
        return $this->response;
    }
}