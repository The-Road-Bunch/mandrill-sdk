<?php declare(strict_types=1);

/**
 * This file is part of the danmcadams/mandrill-sdk-wrapper package.
 *
 * (c) Dan McAdams <danmcadams@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DZMC\Mandrill\Tests\Message\Dispatcher;

use DZMC\Mandrill\Message as Message;
use DZMC\Mandrill\Message\Template;
use DZMC\Mandrill\Tests\Mock\MessagesSpy;
use DZMC\Mandrill\Tests\Mock\NoResponseMessagesMock;

/**
 * Class MessgeDispatcherSendTemplateTest
 *
 * @author  Dan McAdams
 * @package DZMC\Mandrill\Tests\Message\Dispatcher
 *
 * @group   unit
 * @group   message
 * @group   dispatcher
 */
class MessageDispatcherSendTemplateTest extends MessageDispatcherTestCase
{
    public function testSendTemplate()
    {
        $template = new Message\Template('mandrill_template');
        $template->addContent('block_one', 'content one')
                 ->addContent('block_two', 'content two');

        $message = new Message\Message();
        $message->setFrom('from@example.com');
        $message->setSubject('this is an email subject');
        $message->addTo('test@example.com', 'test email person');

        $this->dispatcher->sendTemplate($template, $message);
        $this->assertEquals($message->toArray(), $this->messagesSpy->providedMessage);
        $this->assertEquals($template->getContent(), $this->messagesSpy->providedTemplateContent);
        $this->assertEquals($template->getName(), $this->messagesSpy->providedTemplateName);
    }

    public function testReturnsSendResponse()
    {
        $expectedMessages = [
            [
                'email'         => 'test@example.com',
                'status'        => 'sent',
                'reject_reason' => null,
                '_id'           => uniqid()
            ]
        ];
        $template = new Message\Template('fake_template');
        $template->addContent('block_one', 'content');

        $messageService   = new MessagesSpy($expectedMessages);
        $dispatcher       = new Message\Dispatcher($messageService);

        $response = $dispatcher->sendTemplate($template, new Message\Message());

        $this->assertInternalType('array', $response);
        $this->assertInstanceOf(Message\SendResponse::class, $response[0]);
    }

    public function testNoResponse()
    {
        $messageService = new NoResponseMessagesMock();
        $dispatcher     = new Message\Dispatcher($messageService);

        $this->assertEmpty(
            $dispatcher->sendTemplate(new Template('test_constant'), new Message\Message())
        );
    }

    public function testSendAt()
    {
        $message  = new Message\Message();
        $expected = $message->toArray();

        $sendDate          = new \DateTime();
        $sendDateFormatted = $sendDate->format('Y-m-d H:i:s');

        $this->dispatcher->sendTemplateAt(new Template('test_constant'), $message, $sendDate);
        $this->assertEquals($expected, $this->messagesSpy->providedMessage);
        $this->assertEquals($sendDateFormatted, $this->messagesSpy->providedSendAt);
    }
}
