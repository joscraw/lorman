<?php

namespace App\Tests;

use App\Tests\AbstractMinkTest;

/**
 * Class MainControllerTest
 * @package App\Tests
 *
 * @author Josh Crawmer <jcrawmer@lorman.com> - wishful thinking ;)
 */
class MainControllerTest extends AbstractMinkTest
{

    const NODE_NOT_FOUND_MESSAGE = 'Element %s cannot be found on the page';
    const TEXT_NOT_FOUND_MESSAGE = 'Text %s cannot be found on the page';

    /**
     * Called before every test case
     */
    public function setUp()
    {
        parent::setUp();
    }

    /**
     * Test full name cannot me missing
     */
    public function testFullNameMissing()
    {
        $this->visit();
        $button = ($page = $this->getPage())->find('css', '[name="submit-contact"]');
        $this->assertNotNull($button, sprintf(self::NODE_NOT_FOUND_MESSAGE, 'submit button'));
        $this->fillField('fullName', "");
        $button->submit();
        $content = $page->getContent();
        $errorMessage = 'This value should not be blank.';
        $this->assertContains(
            $errorMessage,
            $content,
            sprintf(self::TEXT_NOT_FOUND_MESSAGE, $errorMessage)
        );
    }

    /**
     * Test email cannot be missing
     */
    public function testEmailMissing()
    {
        $this->visit();
        $button = ($page = $this->getPage())->find('css', '[name="submit-contact"]');
        $this->assertNotNull($button, sprintf(self::NODE_NOT_FOUND_MESSAGE, 'submit button'));
        $this->fillField('email', "");
        $button->submit();
        $content = $page->getContent();
        $errorMessage = 'This value should not be blank.';
        $this->assertContains(
            $errorMessage,
            $content,
            sprintf(self::TEXT_NOT_FOUND_MESSAGE, $errorMessage)
        );
    }


    /**
     * Test message cannot be missing
     */
    public function testMessageMissing()
    {
        $this->visit();
        $button = ($page = $this->getPage())->find('css', '[name="submit-contact"]');
        $this->assertNotNull($button, sprintf(self::NODE_NOT_FOUND_MESSAGE, 'submit button'));
        $this->fillField('message', "");
        $button->submit();
        $content = $page->getContent();
        $errorMessage = 'This value should not be blank.';
        $this->assertContains(
            $errorMessage,
            $content,
            sprintf(self::TEXT_NOT_FOUND_MESSAGE, $errorMessage)
        );
    }


    /**
     * Test invalid phone number
     */
    public function testInvalidPhone()
    {
        $this->visit();
        $button = ($page = $this->getPage())->find('css', '[name="submit-contact"]');
        $this->assertNotNull($button, sprintf(self::NODE_NOT_FOUND_MESSAGE, 'submit button'));
        $this->fillField('phone', "555");
        $button->submit();
        $content = $page->getContent();
        $errorMessage = 'This value is not valid.';
        $this->assertContains(
            $errorMessage,
            $content,
            sprintf(self::TEXT_NOT_FOUND_MESSAGE, $errorMessage)
        );
    }


    public function testInvalidEmail()
    {
        $this->visit();
        $button = ($page = $this->getPage())->find('css', '[name="submit-contact"]');
        $this->assertNotNull($button, sprintf(self::NODE_NOT_FOUND_MESSAGE, 'submit button'));
        $this->fillField('email', "invalid@invalid");
        $button->submit();
        $content = $page->getContent();
        $errorMessage = 'This value is not a valid email address.';
        $this->assertContains(
            $errorMessage,
            $content,
            sprintf(self::TEXT_NOT_FOUND_MESSAGE, $errorMessage)
        );
    }


    public function testSuccessfulSubmissionWithPhone()
    {
        $this->visit();
        $button = ($page = $this->getPage())->find('css', '[name="submit-contact"]');
        $this->assertNotNull($button, sprintf(self::NODE_NOT_FOUND_MESSAGE, 'submit button'));
        $this->fillField('fullName', "Josh Crawmer");
        $this->fillField('message', "This is a message");
        $this->fillField('phone', "555-666-7777");
        $this->fillField('email', "joshcrawmer4@yahoo.com");
        $button->submit();
        $content = $page->getContent();
        $successMessage = 'A Dealer Inspire Representative Will Contact You At';
        $this->assertContains(
            $successMessage,
            $content,
            sprintf(self::TEXT_NOT_FOUND_MESSAGE, $successMessage)
        );
    }


    public function testSuccessfulSubmissionWithoutPhone()
    {
        $this->visit();
        $button = ($page = $this->getPage())->find('css', '[name="submit-contact"]');
        $this->assertNotNull($button, sprintf(self::NODE_NOT_FOUND_MESSAGE, 'submit button'));
        $this->fillField('fullName', "Josh Crawmer");
        $this->fillField('message', "This is a message");
        $this->fillField('email', "joshcrawmer4@yahoo.com");
        $button->submit();
        $content = $page->getContent();
        $successMessage = 'A Dealer Inspire Representative Will Contact You At';
        $this->assertContains(
            $successMessage,
            $content,
            sprintf(self::TEXT_NOT_FOUND_MESSAGE, $successMessage)
        );
    }


}