<?php

namespace Hab\Controller;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

/**
 * Test the SampleController.
 */
class UserControllerTest extends TestCase
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
        $this->controller = new UserController();
        $this->controller->setDI($this->di);
    }

    /**
     * Test the route "user" happy.
     */
    public function testIndexAction()
    {
        $session = $this->di->get("session");
        $session->set("user", ["id" => 1, "user" => "testing"]);
        $res = $this->controller->indexActionGet();
        $res = $res->getBody();
        // $exp = "Edit your information";
        $exp = "Dashboard";
        $session->destroy();
        $this->assertStringContainsString($exp, $res);
    }

    /**
     * Test the route "user" sad.
     */
    public function testIndexActionFail()
    {
        $res = $this->controller->indexActionGet();
        $res = $res->getBody();
        $this->assertNull($res);
    }

    /**
     * Test the route "user/login" happy.
     */
    public function testLoginAction()
    {
        $res = $this->controller->loginActionGet();
        $res = $res->getBody();
        $exp = "<h1>Logga in!</h1>";
        $this->assertStringContainsString($exp, $res);
    }
    
    /**
     * Test the route "user/login" sad.
     */
    public function testLoginActionFail()
    {
        $session = $this->di->get("session");
        $session->set("user", ["id" => 1, "user" => "testing"]);
        $res = $this->controller->loginActionGet();
        $res = $res->getBody();
        $this->assertNull($res);
        $session->destroy();
    }
    
    /**
     * Test the route POST "user/login" happy.
     */
    public function testLoginActionPost()
    {
        $request = $this->di->get("request");
        $request->setPost("username", "testing");
        $request->setPost("password", 'a');
        $res = $this->controller->loginActionPost();
        $res = $res->getBody();
        $exp = "Wrong username or password";
        $this->assertStringContainsString($exp, $res);
        // $this->assertNull($res);
    }
    
    /**
     * Test the route "user/signup" sad.
     */
    public function testSignupActionPost()
    {
        $request = $this->di->get("request");
        $request->setPost("username", "testingg");
        $request->setPost("password1", "testing");
        $request->setPost("password2", "testin");
        $res = $this->controller->signupActionPost();
        $res = $res->getBody();
        $exp = "Passwords doesnt match eachother.";
        // $this->assertNull($res);
        $this->assertStringContainsString($exp, $res);
    }

    public function testLogoutAction()
    {
        $res = $this->controller->logoutActionGet();
        $session = $this->di->get("session");
        $exp = $session->get("user");
        $this->assertNull($exp);
    }

    public function testEditAction()
    {
        $session = $this->di->get("session");
        $session->set("user", ["id" => 21, "user" => "testing"]);
        $res = $this->controller->editActionGet();
        $res = $res->getBody();
        $exp = "<h1>Edit user data</h1>";
        $this->assertStringContainsString($exp, $res);
        $session->destroy();
    }

    public function testEditActionFail()
    {
        $res = $this->controller->editActionGet();
        $res = $res->getBody();
        $this->assertNull($res);
    }

    public function testEditActionPost()
    {
        $res = $this->controller->idActionGet(1);
        $res = $res->getBody();
        $exp = "Profilsida för användare";
        $this->assertStringContainsString($exp, $res);
    }
}