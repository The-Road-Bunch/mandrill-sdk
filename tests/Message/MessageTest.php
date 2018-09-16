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
use DZMC\Mandrill\Message\BccRecipient;
use DZMC\Mandrill\Message\CcRecipient;
use DZMC\Mandrill\Message\Message;
use DZMC\Mandrill\Message\RecipientBuilderInterface;
use DZMC\Mandrill\Message\ToRecipient;
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
        $toName  = 'to test';
        $toEmail = 'test@example.com';

        $toRecipient = $this->message->addTo($toEmail, $toName);

        $this->assertInstanceOf(RecipientBuilderInterface::class, $toRecipient);
        $this->assertInstanceOf(ToRecipient::class, $toRecipient);

        $this->assertCount(1, $this->message->toArray()['to']);
    }

    public function testAddCc()
    {
        $ccName  = 'cc test';
        $ccEmail = 'test@example.com';

        $ccRecipient = $this->message->addCc($ccEmail, $ccName);

        $this->assertInstanceOf(RecipientBuilderInterface::class, $ccRecipient);
        $this->assertInstanceOf(CcRecipient::class, $ccRecipient);

        $this->assertCount(1, $this->message->toArray()['to']);
    }

    public function testAddBcc()
    {
        $bccName  = 'bcc test';
        $bccEmail = 'test@example.com';

        $bccRecipient = $this->message->addBcc($bccEmail, $bccName);

        $this->assertInstanceOf(RecipientBuilderInterface::class, $bccRecipient);
        $this->assertInstanceOf(BccRecipient::class, $bccRecipient);

        $this->assertCount(1, $this->message->toArray()['to']);
    }

    public function testCreateToFromRecipients()
    {
        $toEmail = 'to@example.com';
        $toName  = 'to email';
        $ccEmail = 'cc@example.com';
        $ccName  = 'cc name';


        $expectedTo = [
            [
                'email' => $toEmail,
                'name'  => $toName,
                'type'  => 'to'
            ],
            [
                'email' => $ccEmail,
                'name'  => $ccName,
                'type'  => 'cc'
            ]
        ];
        $this->message->addTo($toEmail, $toName);
        $this->message->addCc($ccEmail, $ccName);

        $this->assertEquals($expectedTo, $this->message->toArray()['to']);
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
