<?php declare(strict_types=1);

/**
 * This file is part of the danmcadams/mandrill-sdk package.
 *
 * (c) Dan McAdams <danmcadams@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DZMC\Mandrill\Tests\Message;


use DZMC\Mandrill\Exception\ValidationException;
use DZMC\Mandrill\Message\Message;
use PHPUnit\Framework\TestCase;

/**
 * Class MessageTest
 *
 * @author  Dan McAdams
 * @package DZMC\Mandrill\Tests
 */
class MessageTest extends TestCase
{
    /**
     * @var Message $message
     */
    protected $message;

    protected function setUp()
    {
        $this->message = new Message();
    }

    /**
     * Technically, this is two tests
     *
     * It tests defaults and the toArray method
     */
    public function testDefaults()
    {
        $message = new Message();

        $expected = [
            'html'       => '',
            'text'       => null,
            'subject'    => null,
            'from_email' => null,
            'from_name'  => null,
            'to'         => [],
            'headers'    => [],
        ];

        $this->assertEquals($expected, $message->toArray());
    }

    public function testSetHtml()
    {
        $html = "<html><body>here is a body</body></html>";

        $this->message->setHtml($html);
        $this->assertEquals($html, $this->message->toArray()['html']);
    }

    public function testSetText()
    {
        $text = 'test text';

        $this->message->setText($text);
        $this->assertEquals($text, $this->message->toArray()['text']);
    }

    public function testSetSubject()
    {
        $subject = 'a subject';

        $this->message->setSubject($subject);
        $this->assertEquals($subject, $this->message->toArray()['subject']);
    }

    public function testSetFromEmail()
    {
        $emailAddress = 'test@example.com';

        $this->message->setFromEmail($emailAddress);
        $this->assertEquals($emailAddress, $this->message->toArray()['from_email']);
    }

    public function testSetFromName()
    {
        $name = 'Dan';

        $this->message->setFromName($name);
        $this->assertEquals($name, $this->message->toArray()['from_name']);
    }

    public function testAddTo()
    {
        $toName     = 'to test';
        $toEmail    = 'test@example.com';
        $toEmailTwo = 'testtwo@example.com';

        $expectedTo = [
            [
                'email' => $toEmail,
                'name'  => $toName,
                'type'  => 'to'
            ],
            [
                'email' => $toEmailTwo,
                'name'  => '',
                'type'  => 'to'
            ],
        ];

        $this->message->addTo($toEmail, $toName);
        $this->message->addTo($toEmailTwo);

        $this->assertCount(2, $this->message->toArray()['to']);
        $this->assertEquals($expectedTo, $this->message->toArray()['to']);
    }

    public function testAddToWithEmptyEmail()
    {
        $this->expectException(ValidationException::class);
        $this->message->addTo('', 'dan');
    }

    public function testAddCc()
    {
        $ccName  = 'cc test';
        $ccEmail = 'cctest@example.com';

        $expectedRecipients = [
            [
                'email' => $ccEmail,
                'name'  => $ccName,
                'type'  => 'cc'
            ]
        ];

        $this->message->addCc($ccEmail, $ccName);

        $this->assertCount(1, $this->message->toArray()['to']);
        $this->assertEquals($expectedRecipients, $this->message->toArray()['to']);
    }

    public function testAddBcc()
    {
        $ccName  = 'bcc test';
        $ccEmail = 'bcctest@example.com';

        $expectedRecipients = [
            [
                'email' => $ccEmail,
                'name'  => $ccName,
                'type'  => 'bcc'
            ]
        ];

        $this->message->addBcc($ccEmail, $ccName);

        $this->assertCount(1, $this->message->toArray()['to']);
        $this->assertEquals($expectedRecipients, $this->message->toArray()['to']);
    }

    public function testAddReplyTo()
    {
        $email = "replyto@example.com";

        $this->message->setReplyTo($email);

        $headers = $this->message->getHeaders();

        $this->assertArrayHasKey('Reply-To', $headers);
        $this->assertEquals($email, $headers['Reply-To']);
    }
}
