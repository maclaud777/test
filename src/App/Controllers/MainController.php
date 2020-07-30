<?php
declare(strict_types=1);


namespace App\Controllers;


use Core\App;
use Core\Controller;
use Core\Http\Response;
use Core\View;

class MainController extends Controller
{
    /**
     * @return Response
     */
    public function indexAction()
    {
        if (App::getInstance()->auth->isAuth()) {
            return $this->redirect('login');
        } else {
            return $this->redirect('user');
        }
    }

    /**
     * @return Response
     */
    public function loginAction(): Response
    {
        if (App::getInstance()->auth->isAuth()) {
            return $this->redirect('user');
        }

        // логин и пароль
        $username = $this->request->getServer()['PHP_AUTH_USER'] ?: null;
        $password = $this->request->getServer()['PHP_AUTH_PW'] ?: null;

        if ($username && $password) {
            App::$session->start(true);
            if (App::getInstance()->auth->auth($username, $password)) {
                return $this->redirect('user');
            } else {
                App::$session->destroy();
            }
        }

        $response = new Response('Authenticate required!', 401);
        $response->withHeader('WWW-Authenticate', 'Basic realm="Backend"');
        return $response;
    }

    /**
     * @return Response
     */
    public function logoutAction(): Response
    {
        App::$session->start(true);
        App::$session->destroy();
        return $this->redirect('home');
    }

    /**
     * @return Response
     * @throws \Core\Exception
     */
    public function userAction(): Response
    {
        if (!App::getInstance()->auth->isAuth()) {
            return $this->redirect('login');
        }

        $user = App::getInstance()->auth->user;

        $view = new View();
        $html = $view->render('user', ['user' => $user]);

        return new Response($html, 200);
    }

    public function payAction(): Response
    {
        if (!App::getInstance()->auth->isAuth()) {
            return $this->redirect('login');
        }

        $amount = $this->request->getBody()['amount'] ?? 0;
        if (!preg_match('/^[0-9]+([.,][0-9]{1,2})?$/', $amount) || $amount <= 0) {
            $this->redirect('user');
        }
        $amount = floatval($amount);

        $user = App::getInstance()->auth->user;

        $message = 'You do not have enough money.';
        if ($user->getBalance() >= $amount) {
            $result = $user->withdrawBalance($amount);
            if ($result) {
                $message = 'Success withdraw.';
            }
        }
        $message .= ' Redirect after 5 seconds...';

        $response = new Response($message, 303);
        $response->withHeader('Refresh', '2; /user');

        return $response;
    }

}