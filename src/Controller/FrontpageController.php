<?php

namespace Hab\Controller;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Hab\User;
use Hab\Thread;
use Hab\Tag;
use Hab\Tag_2_Thread;
use Hab\Point_2_User;


class FrontpageController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;
    
    public function indexActionGet()
    {
        
        $response = $this->di->get("response");
        $session = $this->di->get("session");
        $page = $this->di->get("page");
        $threads = new Thread\Thread();
        $threads->setDb($this->di->get("dbqb"));
        $latestThreads = $threads->findAll();
        usort($latestThreads, function ($a, $b) {
            return strcmp($b->created_at, $a->created_at);
        });
        $tags = new Tag_2_Thread\Tag_2_Thread();
        $tags->setDb($this->di->get("dbqb"));
        $tags = $tags->findAll();
        $tags = array_map(function ($a) { return $a->tag_id; }, $tags);
        $tagsCount = array_count_values($tags);
        arsort($tagsCount);
        $topTags = [];
        foreach ($tagsCount ?? [] as $id => $count) {
            $tag = new Tag\Tag();
            $tag->setDb($this->di->get("dbqb"));
            array_push($topTags, [$tag->findById($id), $count]);
        }
        $p2u = new Point_2_User\Point_2_User();
        $p2u->setDb($this->di->get("dbqb"));
        $p2u = $p2u->findAll();
        $p2uArray = array_map(function ($a) { return [$a->user_id, $a->amount]; }, $p2u);
        $points = [];
        foreach ($p2uArray ?? [] as $tagData) {
            if (array_key_exists($tagData[0], $points)) {
                $points[$tagData[0]] += intval($tagData[1]);
            } else {
                $points[$tagData[0]] = intval($tagData[1]);
            }
        }
        $topUsers = [];
        foreach ($points ?? [] as $user_id => $pointsSum) {
            $user = new User\User();
            $user->setDb($this->di->get("dbqb"));
            array_push($topUsers, [$user->findById($user_id), $pointsSum]);
        }
        usort($topUsers, function ($a, $b) {
            return $b[1] > $a[1];
        });
        $data = [
            "topTags" => $topTags,
            "topUsers" => $topUsers,
            "latestThreads" => $latestThreads,
        ];
        $page->add("hab/general/default", $data);

        return $page->render(["title" => "Framsida"]);
    }

    public function omActionGet()
    {
        $response = $this->di->get("response");
        $session = $this->di->get("session");
        $page = $this->di->get("page");
        $page->add("hab/general/om");

        return $page->render(["title" => "Om"]);
    }
}