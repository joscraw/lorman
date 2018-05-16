<?php

namespace App\Tests;

use Behat\Mink\Driver\GoutteDriver;
use Behat\Mink\Session;
use Behat\Mink\Mink;
use Behat\Mink\Driver\Selenium2Driver;
use PHPUnit\Framework\TestCase;

/**
 * All functional classes should extend this to have access to
 * a built in Driver, Session, and Client.
 *
 * Class AbstractMinkTest
 * @package AppBundle\Tests
 *
 * @author Josh Crawmer <jcrawmer@lorman.com> - wishful thinking ;)
 */
abstract class AbstractMinkTest extends TestCase
{

    /**
     * Holds the mink object. Needs to be static so we can define
     * this inside the static setUpBeforeClass method inside PHPUnit
     *
     * @var Mink $mink
     */
    private static $mink;

    private static $baseUrl;

    /**
     * Setup some default configuration before the tests are run
     */
    public static function setUpBeforeClass()
    {

        /**
         * The Server Base URL will most likely always be set
         * This is just a fall back for safe proofing
         */
        self::$baseUrl = isset($_SERVER['BASE_URL'])
            ? $_SERVER['BASE_URL']
            : 'http://0.0.0.0:8888/';


        self::$mink = new Mink(
            array(
                'symfony' => new Session(new GoutteDriver()),
                'selenium' => new Session(new Selenium2Driver()),
            )
        );

        self::$mink->setDefaultSessionName('symfony');
    }

    /**
     * Returns the current session.
     * Pass in a name to get a different session
     *
     * @param null $name
     * @return Session
     */
    protected function getSession($name = null)
    {
        $session = self::$mink->getSession();
        if ($name) {
            $session = self::$mink->getSession($name);
        }

        return $session;
    }

    /**
     * Resets the current session
     */
    protected function teardown()
    {
        $this->getMink()->resetSessions();
    }

    /**
     * Get the Mink object
     *
     * @return Mink
     */
    protected function getMink()
    {
        return self::$mink;
    }

    /**
     * Gets the current page you are on. Pass in a session name to get it for
     * a session other than the default
     *
     * @param null $name
     * @return \Behat\Mink\Element\DocumentElement
     */
    protected function getPage($name = null)
    {
        return $this->getSession($name)->getPage();
    }

    /**
     * Assert the session is valid
     *
     * @param null $name
     * @return \Behat\Mink\WebAssert
     */
    protected function assertSession($name = null)
    {
        return $this->getMink()->assertSession($name);
    }

    /**
     * The base URL has already been set above.
     * Just pass in the uri you would like to visit.
     *
     * @param string $uri defaults to empty string to visit the homepage or URL defined above in setup();
     */
    protected function visit($uri = '')
    {
        $this->getSession()->visit(self::$baseUrl.$uri);
    }


    /**
     * @param $name
     * @param $value
     */
    protected function fillField($name, $value)
    {
        $field = $this->getPage()->find('css', '[name="'.$name.'"]');
        $this->assertNotNull($field);
        $field->setValue($value);
    }

    /**
     * @param null $name
     * @return string
     */
    protected function getContent($name = null)
    {
        return $this->getPage($name)->getContent();
    }

}
