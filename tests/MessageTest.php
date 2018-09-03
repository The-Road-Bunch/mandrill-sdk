<?php declare(strict_types=1);

/**
 * This file is part of the danmcadams/mandrill-sdk-wrapper package.
 *
 * (c) Dan McAdams <danmcadams@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DZMC\Mandrill\Tests;


use DZMC\Mandrill\Exception\MandrillValidationException;
use PHPUnit\Framework\TestCase;

/**
 * Class MessageTest
 *
 * @author  Dan McAdams
 * @package DZMC\Mandrill\Tests
 */
class MessageTest extends TestCase
{
    /** @var MessageSpy */
    protected $message;

    protected function setUp()
    {
        $this->message = new MessageSpy();
    }

    public function testSetHtml()
    {
        $html = "<html><body>here is a body</body></html>";

        $this->message->setHtml($html);
        $this->assertEquals($html, $this->message->getHtml());
    }

    public function testSetText()
    {
        $text = 'test text';

        $this->message->setText($text);
        $this->assertEquals($text, $this->message->getText());
    }

    public function testSetSubject()
    {
        $subject = 'a subject';

        $this->message->setSubject($subject);
        $this->assertEquals($subject, $this->message->getSubject());
    }

    public function testSetFromEmail()
    {
        $emailAddress = 'test@example.com';

        $this->message->setFromEmail($emailAddress);
        $this->assertEquals($emailAddress, $this->message->getFromEmail());
    }

    public function testSetFromName()
    {
        $name = 'Dan';

        $this->message->setFromName($name);
        $this->assertEquals($name, $this->message->getFromName());
    }

    public function testToDefaultEmptyArray()
    {
        $this->assertInternalType('array', $this->message->getRecipients());
        $this->assertEmpty($this->message->getRecipients());
    }

    public function testAddTo()
    {
        $toName       = 'test user';
        $toEmail      = 'test@example.com';
        $toNameTwo    = 'test user two';
        $toEmailTwo   = 'testtwo@example.com';
        $toEmailThree = 'testthree@example.com';

        $expectedTo = [
            [
                'email' => $toEmail,
                'name'  => $toName,
                'type'  => 'to'
            ],
            [
                'email' => $toEmailTwo,
                'name'  => $toNameTwo,
                'type'  => 'to'
            ],
            [
                'email' => $toEmailThree,
                'name'  => '',
                'type'  => 'to'
            ]
        ];

        $this->message->addTo($toEmail, $toName);
        $this->message->addTo($toEmailTwo, $toNameTwo);
        $this->message->addTo($toEmailThree);

        $this->assertCount(3, $this->message->getRecipients());
        $this->assertEquals($expectedTo, $this->message->getRecipients());
    }

    public function testAddToWithEmptyEmail()
    {
        $this->expectException(MandrillValidationException::class);
        $this->message->addTo('', 'dan');
    }

    public function testAddHeader()
    {
        $this->message->addHeader('X-Force', 'Not the X-Men');

        $headers = $this->message->getHeaders();

        $this->assertArrayHasKey('X-Force', $headers);
        $this->assertEquals('Not the X-Men', $headers['X-Force']);
    }

    public function testSetIsImportant()
    {
        $this->message->isImportant();

        $headers = $this->message->getHeaders();

        $this->assertTrue($this->message->getIsImportant());
        $this->assertArrayHasKey('X-Priority', $headers);
        $this->assertEquals(1, $headers['X-Priority']);

        $this->assertArrayHasKey('X-MSMail-Priority', $headers);
        $this->assertEquals('high', $headers['X-MSMail-Priority']);

        $this->assertArrayHasKey('Importance', $headers);
        $this->assertEquals('high', $headers['Importance']);
    }
}
