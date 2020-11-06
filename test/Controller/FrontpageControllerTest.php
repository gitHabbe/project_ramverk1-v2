<?php

namespace Hab\Controller;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

/**
 * Test the SampleController.
 */
class FrontpageControllerTest extends TestCase
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
        $this->controller = new FrontpageController();
        $this->controller->setDI($this->di);
    }

    /**
     * Test the route "root" happy.
     */
    public function testIndexAction()
    {
        $res = $this->controller->indexActionGet();
        $res = $res->getBody();
        $exp = "Översikt av mest populära användare";
        $this->assertStringContainsString($exp, $res);
    }

    /**
     * Test the route "om" happy.
     */
    public function testOmAction()
    {
        $res = $this->controller->omActionGet();
        $res = $res->getBody();
        $exp = "Hela projektet finns uppladda på GitHub";
        $this->assertStringContainsString($exp, $res);
    }
}