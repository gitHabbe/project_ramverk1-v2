<?php

namespace Hab\Controller;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Hab\Thread;
use Hab\Comment;
use Hab\Point_2_Thread;

class ThreadController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    public function indexActionGet()
    {
        $page = $this->di->get("page");
        $thread = new Thread\Thread();
        $thread->setDb($this->di->get("dbqb"));
        $threads = $thread->findAll();
        $page->add("hab/thread/default", ["threads" => $threads]);

        return $page->render(["title" => "All threads"]);
    }
    
    public function idActionGet(int $id)
    {
        $session = $this->di->get("session");
        $page = $this->di->get("page");
        $user = $session->get("user", null);
        $thread = new Thread\Thread();
        $thread->setDb($this->di->get("dbqb"));
        $thread = $thread->findById($id);
        $comment = new Comment\Comment();
        $comment->setDb($this->di->get("dbqb"));
        $comments = $comment->findAllWhereJoin("thread_id = ?", $id, "User", "User.id=user_id");
        // $p2t = new Point_2_Thread\Point_2_Thread();
        // $p2t->setDb($this->di->get("dbqb"));
        $data = [
            "thread" => $thread,
            "comments" => $comments,
            "user" => $user,
        ];
        $page->add("hab/thread/single-thread", $data);

        return $page->render(["title" => "All threads"]);
    }

    public function pointActionPost(int $id)
    {
        $request = $this->di->get("request");
        $session = $this->di->get("session");
        $user = $session->get("user", null);
        var_dump($user);
        if ($user === null) {
            return "AUTH";
        }
        $vote = $request->getPost("thread-vote");
        $p2t = new Point_2_Thread\Point_2_Thread();
        $p2t->setDb($this->di->get("dbqb"));
        $p2t = $p2t->findWhere("thread_id = ? AND user_id = ?", [$id, $user["id"]]);
        var_dump(intval($p2t->positive));
        if ($vote === "up" && intval($p2t->positive) === 1) {
            return "CANT";
        }
        if ($vote === "down" && intval($p2t->positive) === 0) {
            return "CANT";
        }
        $thread = new Thread\Thread();
        $thread->setDb($this->di->get("dbqb"));
        $thread = $thread->findById($id);
        $thread->points = intval($thread->points) + 1;
        $thread->save();
        // $test = $thread->saveWhere("points = ?", intval($thread->points) + 1);
        var_dump($thread);
        die();
        // $vote = $vote === "up" ? -1 : 1;
        // $isVotable = intval($p2t->positive) === $vote;
        // var_dump($p2t->positive);
        // var_dump($votable);
        // die();
        $response = $this->di->get("response");

        return $response->redirect("thread/id/" . $id);
    }
}