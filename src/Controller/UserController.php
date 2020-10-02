<?php

namespace Hab\Controller;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Hab\User;

class UserController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    public function indexActionGet()
    {
        $response = $this->di->get("response");
        $session = $this->di->get("session");
        $user = $session->get("user");
        if (!$user) {
            return $response->redirect("user/login");
        }
        $page = $this->di->get("page");
        $page->add("hab/dashboard/default", ["user" => $user]);
        $title = $user . " - Dashboard";

        return $page->render(["title" => $title]);
    }

    public function loginActionGet() : object
    {
        $response = $this->di->get("response");
        $session = $this->di->get("session");
        if ($session->get("user")) {
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
        $session->set("user", $username);

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
}