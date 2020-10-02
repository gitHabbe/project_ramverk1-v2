<?php

namespace Hab\Controller;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Hab\Thread;
use Hab\Comment;

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

    public function allComments(int $thread_id)
    {
        $comment = new Comment\Comment();
        $comment->setDb($this->di->get("dbqb"));
        return $comment->findAllWhere("thread_id = ?", $thread_id);
    }

    public function idActionGet(int $id)
    {
        $page = $this->di->get("page");
        $thread = new Thread\Thread();
        $thread->setDb($this->di->get("dbqb"));
        $thread = $thread->findById($id);
        $comments = $this->allComments($id);

        $page->add("hab/thread/single-thread", ["thread" => $thread, "comments" => $comments]);

        return $page->render(["title" => "All threads"]);
    }

    // public function allComments(int $thread_id)
    // {
    //     $comment = new Comment\Comment();
    //     $comment->setDb($this->di->get("dbqb"));
    //     $comments = $comment->find("thread_id", $where_id);

    //     return $comments;
    // }
}