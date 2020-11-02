<?php

namespace Hab\Controller;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Hab\User;
use Hab\Comment;
use Hab\Point_2_Comment;
use Hab\Point_2_User;
use Hab\Answer;
use \Michelf\Markdown;

class CommentController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    public function newActionPost(int $id)
    {
        $request = $this->di->get("request");
        $session = $this->di->get("session");
        $user = $session->get("user", null);
        if ($user === null) {
            return "AUTH";
        }
        $commentName = $request->getPost("comment");
        $replyTo = intval($request->getPost("replyTo"));
        $commentsLen = intval($request->getPost("commentsLen"));
        $isReplyRange = $replyTo >= 1 && $replyTo <= $commentsLen;
        $comment = new Comment\Comment();
        $comment->setDb($this->di->get("dbqb"));
        if ($isReplyRange) {
            $comment->reply_num = $replyTo;
        }
        $comment->thread_id = $id;
        $comment->user_id = $user["id"];
        $comment->name = $commentName;
        $comment->points = 0;
        $comment->save();
        $p2u = new Point_2_User\Point_2_User();
        $p2u->setDb($this->di->get("dbqb"));
        $p2u->amount = 3;
        $p2u->user_id = $user["id"];
        $p2u->save();
        $response = $this->di->get("response");

        return $response->redirect("thread/id/" . $id);

    }

    public function pointActionPost(int $id)
    {
        $request = $this->di->get("request");
        $session = $this->di->get("session");
        $user = $session->get("user", null);
        if ($user === null) {
            return "AUTH";
        }
        $vote = $request->getPost("comment-vote");
        $thread_id = $request->getPost("threadid");
        var_dump($id);
        $vote = $vote === "up" ? 1 : -1;
        $p2c = new Point_2_Comment\Point_2_Comment();
        $p2c->setDb($this->di->get("dbqb"));
        $p2c = $p2c->findWhere("comment_id = ? AND user_id = ?", [$id, $user["id"]]);
        if ($vote === intval($p2c->positive)) {
            return "CANT";
        }
        $comment = new Comment\Comment();
        $comment->setDb($this->di->get("dbqb"));
        $comment = $comment->findById($id);
        if ($p2c->id == null) {
            $p2c = new Point_2_Comment\Point_2_Comment();
            $p2c->setDb($this->di->get("dbqb"));
            $p2c->user_id = intval($user["id"]);
            $p2c->comment_id = $id;
            $comment->points = intval($comment->points) + $vote;
        } else {
            $comment->points = intval($comment->points) + (2 * $vote);
        }
        $p2u = new Point_2_User\Point_2_User();
        $p2u->setDb($this->di->get("dbqb"));
        $p2u->amount = $vote * 2;
        $p2u->user_id = $comment->user_id;
        $p2u->save();
        $p2c->positive = $vote;
        $comment->save();
        $p2c->save();
        $response = $this->di->get("response");

        return $response->redirect("thread/id/" . $thread_id);
    }

    public function answerActionPost()
    {
        $request = $this->di->get("request");
        $comment = $request->getPost("commentid");
        $thread = $request->getPost("threadid");
        $answer = new Answer\Answer();
        $answer->setDb($this->di->get("dbqb"));
        $answer = $answer->find("thread_id", $thread);
        // var_dump($thread);
        // var_dump($comment);
        // die();
        if ($answer->id === null) {
            $newAnswer = new Answer\Answer();
            $newAnswer->setDb($this->di->get("dbqb"));
            $newAnswer->thread_id = $thread;
            $newAnswer->comment_id = $comment;
            $newAnswer->save();
        } else {
            return "already answered";
        }
        $response = $this->di->get("response");

        return $response->redirect("thread/id/" . $thread);
    }
}