<?php

namespace Hab\Controller;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Hab\User;
use Hab\Point_2_User;

class UserController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    public function indexActionGet()
    {
        $response = $this->di->get("response");
        $session = $this->di->get("session");
        $sessionUser = $session->get("user");
        $user = new User\User();
        $user->setDb($this->di->get("dbqb"));
        $user = $user->findById($sessionUser["id"]);
        if (!$sessionUser["id"]) {
            return $response->redirect("user/login");
        }
        $page = $this->di->get("page");
        $page->add("hab/dashboard/default", ["user" => $user]);
        $title = $user->username . " - Dashboard";

        return $page->render(["title" => $title]);
    }

    public function loginActionGet() : object
    {
        $response = $this->di->get("response");
        $session = $this->di->get("session");
        if ($session->get("user")["id"]) {
            return $response->redirect("");
        }
        $page = $this->di->get("page");
        $page->add("hab/login/default");

        return $page->render(["title" => "User login"]);
    }

    public function loginActionPost()
    {
        $session = $this->di->get("session");
        $request = $this->di->get("request");
        $response = $this->di->get("response");
        $username = $request->getPost("username");
        $password = $request->getPost("password");
        $user = new User\User();
        $user->setDb($this->di->get("dbqb"));
        if (!$user->verifyPassword($username, $password)) {
            return "username or password wrong";
        }
        $session->set("user", ["user" => $username, "id" => $user->id]);

        return $response->redirect("");
    }

    public function signupActionGet() : object
    {
        $page = $this->di->get("page");
        $page->add("hab/signup/default");

        return $page->render(["title" => "User sign-up"]);
    }

    public function signupActionPost()
    {
        $request = $this->di->get("request");
        $response = $this->di->get("response");
        $username = $request->getPost("username");
        $password1 = $request->getPost("password1");
        $password2 = $request->getPost("password2");
        $user = new User\User();
        $user->setDb($this->di->get("dbqb"));
        $user->username = $username;
        if ($user->isTaken()) {
            return "taken";
        }
        if ($password1 != $password2) {
            return "password doesnt match";
        }
        $user->setPassword($password1);
        $user->save();

        return $response->redirect("user/login");
    }

    public function logoutActionGet()
    {
        $response = $this->di->get("response");
        $session = $this->di->get("session");
        $session->delete("user");

        return $response->redirect("user/login");
    }

    public function editActionGet()
    {
        $session = $this->di->get("session");
        $userSession = $session->get("user");
        if (!$userSession["id"]) {
            return $response->redirect("user/login");
        }
        $user = new User\User();
        $user->setDb($this->di->get("dbqb"));
        $user = $user->findById($userSession["id"]);
        $page = $this->di->get("page");
        $page->add("hab/dashboard/edit-user", ["user" => $user]);

        return $page->render(["title" => "Edit user"]);
    }

    public function editActionPost()
    {
        $session = $this->di->get("session");
        $userSession = $session->get("user");
        $response = $this->di->get("response");
        $request = $this->di->get("request");
        $password = $request->getPost("password");
        $quote = $request->getPost("quote");
        $gravatar = $request->getPost("gravatar");
        $user = new User\User();
        $user->setDb($this->di->get("dbqb"));
        $user = $user->findById($userSession["id"]);
        $gravPattern = "https://www.gravatar.com/avatar/";
        $p2u = new Point_2_User\Point_2_User();
        $p2u->setDb($this->di->get("dbqb"));
        $p2u->user_id = $user->id;
        if (strpos($gravatar, $gravPattern) != 0) {
            return false;
        }
        // var_dump($quote);
        // var_dump($user->quote);
        // die();
        if ($password > 1) {
            $user->setPassword($password);
        }
        if ($user->gravatar === "" && $gravatar != "") {
            $p2u->amount = 7;
            $p2u->save();
        }
        if ($user->quote === "" && $quote != "") {
            $p2u->amount = 7;
            $p2u->save();
        }
        $user->gravatar = $gravatar;
        $user->quote = $quote;
        $user->save();

        return $response->redirect("user");
    }
}