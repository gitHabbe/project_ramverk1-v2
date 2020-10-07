<?php

namespace Hab\Controller;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Hab\User;
use Hab\Comment;
use Hab\Point_2_Comment;

class CommentController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    public function pointActionPost(int $id)
    {
        $request = $this->di->get("request");
        $session = $this->di->get("session");
        $user = $session->get("user", null);
        if ($user === null) {
            return "AUTH";
        }
        $vote = $request->getPost("comment-vote");
        $vote = $vote === "up" ? 1 : -1;
        $p2c = new Point_2_Comment\Point_2_Comment();
        $p2c->setDb($this->di->get("dbqb"));
        $p2c = $p2c->findWhere("comment_id = ? AND user_id = ?", [$id, $user["id"]]);
        if ($vote === intval($p2c->positive)) {
            return "CANT";
        }
    }
}