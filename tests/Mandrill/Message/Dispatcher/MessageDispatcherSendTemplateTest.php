<?php declare(strict_types=1);

/**
 * This file is part of the theroadbunch/mandrill-sdk package.
 *
 * (c) Dan McAdams <danmcadams@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RoadBunch\Tests\Mandrill\Message\Dispatcher;

use RoadBunch\Mandrill\Message as Message;
use RoadBunch\Mandrill\Message\Template;
use RoadBunch\Tests\Mandrill\Mock\MessagesSpy;
use RoadBunch\Tests\Mandrill\Mock\NoResponseMessagesMock;

/**
 * Class MessgeDispatcherSendTemplateTest
 *
 * @author  Dan McAdams
 * @package RoadBunch\Tests\Mandrill\Message\Dispatcher
 *
 * @group   unit
 * @group   message
 * @group   dispatcher
 */
class MessageDispatcherSendTemplateTest extends MessageDispatcherTestCase
{
    public function testSendTemplate()
    {
        $templateMessage = new Message\TemplateMessage('mandrill_template');
        $templateMessage->addContent('block_one', 'content one');
        $templateMessage->addContent('block_two', 'content two');

        $templateMessage->setFrom('from@example.com');
        $templateMessage->setSubject('this is an email subject');
        $templateMessage->addTo('test@example.com', 'test email person');

        $this->dispatcher->sendTemplate($templateMessage);
        $this->assertEquals($templateMessage->toArray(), $this->messagesSpy->providedMessage);
        $this->assertEquals($templateMessage->getContent(), $this->messagesSpy->providedTemplateContent);
        $this->assertEquals($templateMessage->getName(), $this->messagesSpy->providedTemplateName);
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
        $templateMessage = new Message\TemplateMessage('test_template');
        $templateMessage->addContent('block_one', 'content');

        $messageService   = new MessagesSpy($expectedMessages);
        $dispatcher       = new Message\Dispatcher($messageService);

        $response = $dispatcher->sendTemplate($templateMessage);

        $this->assertInternalType('array', $response);
        $this->assertInstanceOf(Message\SendResponse::class, $response[0]);
    }

    public function testNoResponse()
    {
        $messageService = new NoResponseMessagesMock();
        $dispatcher     = new Message\Dispatcher($messageService);

        $this->assertEmpty(
            $dispatcher->sendTemplate(new Message\TemplateMessage('test_template'))
        );
    }

    public function testSendAt()
    {
        $templateMessage  = new Message\TemplateMessage('test_template');
        $templateMessage->addTo('test@example.com');

        $sendDate          = new \DateTime();
        $sendDateFormatted = $sendDate->format('Y-m-d H:i:s');

        $this->dispatcher->sendTemplateAt($templateMessage, $sendDate);
        $this->assertEquals($templateMessage->toArray(), $this->messagesSpy->providedMessage);
        $this->assertEquals($sendDateFormatted, $this->messagesSpy->providedSendAt);
    }
}
