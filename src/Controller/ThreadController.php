<?php

namespace Hab\Controller;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Hab\Thread;
use Hab\Comment;
use Hab\Point_2_Thread;
use Hab\User;
use Hab\Tag;
use Hab\Tag_2_Thread;
use Hab\Point_2_User;
use Hab\Answer;
use \Michelf\Markdown;

class ThreadController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    public function indexActionGet()
    {
        $page = $this->di->get("page");
        $thread = new Thread\Thread();
        $thread->setDb($this->di->get("dbqb"));
        $threads = $thread->findAll();
        $comment = new Comment\Comment();
        $comment->setDb($this->di->get("dbqb"));
        $comments = $comment->findAll();
        $data = [
            "threads" => $threads,
            "comments" => $comments,
        ];
        $page->add("hab/thread/default", $data);

        return $page->render(["title" => "All threads"]);
    }

    public function newActionGet()
    {
        $page = $this->di->get("page");
        $request = $this->di->get("request");
        $response = $this->di->get("response");
        $session = $this->di->get("session");
        $user = $session->get("user", null);
        if ($user === null) {
            return $response->redirect("user/login");
        }
        $tag = new Tag\Tag();
        $tag->setDb($this->di->get("dbqb"));
        $tags = $tag->findAll();
        $data = [
            "tags" => $tags
        ];
        $page->add("hab/thread/new", $data);

        return $page->render(["title" => "New Thread"]);
    }

    public function newActionPost()
    {
        $session = $this->di->get("session");
        $user = $session->get("user", null);
        if ($user === null) {
            return "AUTH";
        }
        $user = $session->get("user");
        $response = $this->di->get("response");
        $request = $this->di->get("request");
        $topic = $request->getPost("topic");
        $content = $request->getPost("content");
        $thread = new Thread\Thread();
        $thread->setDb($this->di->get("dbqb"));
        $thread->user_id = $user["id"];
        $thread->content = $content;
        $thread->topic = $topic;
        $thread->points = 0;
        $thread->created_at = date('Y-m-d H:i:s');
        $thread->save();
        $p2u = new Point_2_User\Point_2_User();
        $p2u->setDb($this->di->get("dbqb"));
        $p2u->amount = 5;
        $p2u->user_id = $user["id"];
        $p2u->save();
        $tags = $request->getPost("tags");
        $tags = explode("#", $tags);
        $tags = array_filter($tags);
        foreach ($tags as $tag) {
            $tagName = str_replace(' ', '', $tag);
            $tagDb = new Tag\Tag();
            $tagDb->setDb($this->di->get("dbqb"));
            $tagDb = $tagDb->find("name", $tagName);
            $tag2thread = new Tag_2_Thread\Tag_2_Thread();
            $tag2thread->setDb($this->di->get("dbqb"));
            $tag2thread->thread_id = $thread->id;
            $tag2thread->tag_id = $tagDb->id;
            $tag2thread->save();
        }

        return $response->redirect("thread/id/" . $thread->id);
    }
    
    public function idActionGet(int $id)
    {
        $session = $this->di->get("session");
        $page = $this->di->get("page");
        $sessionUser = $session->get("user", null);
        $realThread = new Thread\Thread();
        $realThread->setDb($this->di->get("dbqb"));
        $realThread = $realThread->findById($id);
        $thread2 = new Thread\Thread();
        $thread2->setDb($this->di->get("dbqb"));
        $comments2 = $thread2->findAllWhereJoin("Thread.id = ?", $id, "Comment", "Comment.thread_id = Thread.id");
        $thread = new Thread\Thread();
        $thread->setDb($this->di->get("dbqb"));
        $thread = $thread->findAllWhereJoin("Thread.id = ?", $id, "User", "User.id = Thread.user_id");
        $thread = $thread[0];
        $user = new User\User();
        $user->setDb($this->di->get("dbqb"));
        $user->findById($thread->user_id);
        $comment = new Comment\Comment();
        $comment->setDb($this->di->get("dbqb"));
        $comments = $comment->findAllWhereJoin("thread_id = ?", $id, "User", "User.id=user_id");
        $answer = new Answer\Answer();
        $answer->setDb($this->di->get("dbqb"));
        $answer = $answer->find("thread_id", $realThread->id);
        $tags = new Tag_2_Thread\Tag_2_Thread();
        $tags->setDb($this->di->get("dbqb"));
        $tags = $tags->findAllWhereJoin("thread_id = ?", $id, "Tag", "Tag.id = tag_id");
        $my_html = Markdown::defaultTransform($realThread->content);
        $data = [
            "thread" => $thread,
            "realThread" => $realThread,
            "comments" => $comments,
            "comments2" => $comments2,
            "user" => $user,
            "tags" => $tags,
            "my_html" => $my_html,
            "answer" => $answer,
        ];
        $page->add("hab/thread/single-thread", $data);

        return $page->render(["title" => "All threads"]);
    }

    public function pointActionPost(int $id)
    {
        $request = $this->di->get("request");
        $session = $this->di->get("session");
        $user = $session->get("user", null);
        if ($user === null) {
            return "AUTH";
        }
        $vote = $request->getPost("thread-vote");
        $vote = $vote === "up" ? 1 : -1;
        $p2t = new Point_2_Thread\Point_2_Thread();
        $p2t->setDb($this->di->get("dbqb"));
        $p2t = $p2t->findWhere("thread_id = ? AND user_id = ?", [$id, $user["id"]]);
        if ($vote === intval($p2t->positive)) {
            return "CANT";
        }
        $thread = new Thread\Thread();
        $thread->setDb($this->di->get("dbqb"));
        $thread = $thread->findById($id);

        if ($p2t->id == null) {
            $p2t = new Point_2_Thread\Point_2_Thread();
            $p2t->setDb($this->di->get("dbqb"));
            $p2t->user_id = intval($user["id"]);
            $p2t->thread_id = $id;
            $thread->points = intval($thread->points) + $vote;
        } else {
            $thread->points = intval($thread->points) + (2 * $vote);
        }
        $p2t->positive = $vote;
        $thread->save();
        $p2t->save();
        $p2u = new Point_2_User\Point_2_User();
        $p2u->setDb($this->di->get("dbqb"));
        $p2u->amount = $vote * 2;
        $p2u->user_id = $thread->user_id;
        $p2u->save();
        $response = $this->di->get("response");

        return $response->redirect("thread/id/" . $id);
    }

    public function tagsActionGet()
    {
        $session = $this->di->get("session");
        $page = $this->di->get("page");
        $tags = new Tag\Tag();
        $tags->setDb($this->di->get("dbqb"));
        $tags = $tags->findAll();
        $data = [
            "tags" => $tags,
        ];
        $page->add("hab/thread/tags", $data);

        return $page->render(["title" => "All tags"]);
    }

    public function tagidActionGet(int $id)
    {
        $session = $this->di->get("session");
        $page = $this->di->get("page");
        $tags = new Tag_2_Thread\Tag_2_Thread();
        $tags->setDb($this->di->get("dbqb"));
        $tags = $tags->findAllWhere("tag_id = ?", $id);
        $threads = [];
        foreach ($tags as $tag) {
            $thread = new Thread\Thread();
            $thread->setDb($this->di->get("dbqb"));
            array_push($threads, $thread->findById($tag->thread_id));
        }
        $data = [
            "tags" => $tags,
            "threads" => $threads,
        ];
        $page->add("hab/thread/threads-with-tags", $data);

        return $page->render(["title" => "All tags"]);
    }
}