<?php

namespace Hab\Controller;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Hab\User;
use Hab\Thread;
use Hab\Comment;
use Hab\Answer;
use Hab\Point_2_User;
use Hab\Point_2_Comment;
use Hab\Point_2_Thread;

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
        // if ($session->get("user")["id"]) {
        if ($session->get("user") != null) {
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
        $page = $this->di->get("page");
        $username = $request->getPost("username");
        $password = $request->getPost("password");
        $isUserTaken = new User\User();
        $isUserTaken->setDb($this->di->get("dbqb"));
        $isUserTaken = $isUserTaken->findWhere("username = ?", $username);
        $user = new User\User();
        $user->setDb($this->di->get("dbqb"));
        if ($isUserTaken->id == null) {
            $page->add("hab/login/default", ["error" => "Wrong username or password."]);
            return $page->render(["title" => "User login"]);
        }
        if (!$user->verifyPassword($username, $password)) {
            $page->add("hab/login/default", ["error" => "Wrong username or password."]);
            return $page->render(["title" => "User login"]);
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
        $page = $this->di->get("page");
        $username = $request->getPost("username");
        $password1 = $request->getPost("password1");
        $password2 = $request->getPost("password2");
        $user = new User\User();
        $user->setDb($this->di->get("dbqb"));
        $user->username = $username;
        if ($user->isTaken()) {
            $page->add("hab/signup/default", ["error" => "User name taken."]);
            return $page->render(["title" => "User sign-up"]);
        }
        if ($password1 != $password2) {
            $page->add("hab/signup/default", ["error" => "Passwords doesnt match eachother."]);
            return $page->render(["title" => "User sign-up"]);
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
        $response = $this->di->get("response");
        $session = $this->di->get("session");
        $page = $this->di->get("page");
        // var_dump(get_class_methods($response));
        // var_dump(get_class_methods($page));
        // die();
        $userSession = $session->get("user");
        if (!$userSession["id"]) {
            return $response->redirect("user/login");
        }
        $user = new User\User();
        $user->setDb($this->di->get("dbqb"));
        $user = $user->findById($userSession["id"]);
        $page->add("hab/dashboard/edit-user", ["user" => $user]);

        return $page->render(["title" => "Edit user"]);
    }

    public function editActionPost()
    {
        $session = $this->di->get("session");
        $response = $this->di->get("response");
        $request = $this->di->get("request");
        $page = $this->di->get("page");
        $userSession = $session->get("user");
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
        if (strpos($gravatar, $gravPattern) === false) {
            return $response->redirect("user/edit");
        }
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

    public function idActionGet(int $id)
    {
        $session = $this->di->get("session");
        // $userSession = $session->get("user");
        $response = $this->di->get("response");
        $request = $this->di->get("request");
        $page = $this->di->get("page");
        $user = new User\User();
        $user->setDb($this->di->get("dbqb"));
        $user = $user->findById($id);
        $p2u = new Point_2_user\Point_2_user();
        $p2u->setDb($this->di->get("dbqb"));
        $p2u = $p2u->findAllWhere("user_id = ?", $id);
        $comments = new Comment\Comment();
        $comments->setDb($this->di->get("dbqb"));
        $comments = $comments->findAllWhere("user_id = ?", $id);
        $threadsTemp = new Thread\Thread();
        $threadsTemp->setDb($this->di->get("dbqb"));
        $threadsTemp = $threadsTemp->findAllWhere("user_id = ?", $id);
        $threads = [];
        foreach($threadsTemp ?? [] as $thread) {
            $answer = new Answer\Answer();
            $answer->setDb($this->di->get("dbqb"));
            array_push($threads, [$thread, $answer->findWhere("thread_id = ?", $thread->id)]);
        }
        $p2t = new Point_2_Thread\Point_2_Thread();
        $p2t->setDb($this->di->get("dbqb"));
        $p2t = $p2t->findAllWhere("user_id = ?", $id);
        $p2c = new Point_2_Comment\Point_2_Comment();
        $p2c->setDb($this->di->get("dbqb"));
        $p2c = $p2c->findAllWhere("user_id = ?", $id);
        $data = [
            "user" => $user,
            "threads" => $threads,
            "comments" => $comments,
            "p2u" => $p2u,
            "p2c" => $p2c,
            "p2t" => $p2t,
        ];
        $page->add("hab/dashboard/user", $data);

        return $page->render(["title" => $user->username]);
    }
}