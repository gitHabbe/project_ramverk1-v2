<?php

namespace Hab\Controller;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

/**
 * Test the SampleController.
 */
class ThreadControllerTest extends TestCase
{
    // Create the di container.
    protected $di;
    protected $controller;

    /**
     * Prepare before each test.
     */
    protected function setUp()
    {
        global $di;

        // Setup di
        $this->di = new DIFactoryConfig();
        $this->di->loadServices(ANAX_INSTALL_PATH . "/config/di");

        // Use a different cache dir for unit test
        $this->di->get("cache")->setPath(ANAX_INSTALL_PATH . "/test/cache");

        // View helpers uses the global $di so it needs its value
        $di = $this->di;

        // Setup the controller
        $this->controller = new ThreadController();
        $this->controller->setDI($this->di);
    }

    /**
     * Test the route "thread" happy.
     */
    public function testIndexAction()
    {
        $res = $this->controller->indexActionGet();
        $res = $res->getBody();
        $exp = "Nam dui.";
        // $session->destroy();
        $this->assertStringContainsString($exp, $res);
    }

    /**
     * Test the route "thread/new" happy.
     */
    public function testNewAction()
    {
        $session = $this->di->get("session");
        $session->set("user", ["id" => 1, "user" => "testing"]);
        $res = $this->controller->newActionGet();
        $res = $res->getBody();
        $exp = "Content";
        $this->assertStringContainsString($exp, $res);
        $session->destroy();
    }

    /**
     * Test the route "thread/new" sad.
     */
    public function testNewActionFail()
    {
        $res = $this->controller->newActionGet();
        $res = $res->getBody();
        $this->assertNull($res);
    }

    /**
     * Test the route "thread/id" happy.
     */
    public function testIdActionGet()
    {
        $res = $this->controller->idActionGet(1);
        $res = $res->getBody();
        $exp = "Morbi sem mauris";
        $this->assertStringContainsString($exp, $res);
    }

    /**
     * Test the route "thread/tags" happy.
     */
    public function testTagsActionGet()
    {
        $res = $this->controller->tagsActionGet();
        $res = $res->getBody();
        $exp = "alla trådar under just";
        $this->assertStringContainsString($exp, $res);
    }

    /**
     * Test the route "thread/tagid" happy.
     */
    public function testTagidActionGet()
    {
        $res = $this->controller->tagidActionGet(5);
        $res = $res->getBody();
        $exp = "taggen: <b>seven</b>";
        $this->assertStringContainsString($exp, $res);
    }
}