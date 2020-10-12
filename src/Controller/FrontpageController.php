<?php

namespace Hab\Controller;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Hab\User;
use Hab\Thread;
use Hab\Tag_2_Thread;


class FrontpageController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;
    
    public function indexActionGet()
    {
        
        $response = $this->di->get("response");
        $session = $this->di->get("session");
        $page = $this->di->get("page");
        $page->add("hab/general/default");
        $threads = new Thread\Thread();
        $threads->setDb($this->di->get("dbqb"));
        $threads = $threads->findAll();
        $thraeds = usort($threads, function ($a, $b) {
            return strcmp($a->created_at, $b->created_at);
        });
        $tags = new Tag_2_Thread\Tag_2_Thread();
        $tags->setDb($this->di->get("dbqb"));
        $tags = $tags->findAll();
        $tags = array_map(function($a) { return $a->tag_id; }, $tags);
        $tagsCount = array_count_values($tags);

        return $page->render(["title" => "Frontpage"]);
    }
}