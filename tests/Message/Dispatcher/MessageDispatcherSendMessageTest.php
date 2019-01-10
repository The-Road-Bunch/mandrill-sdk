<?php declare(strict_types=1);

/**
 * This file is part of the theroadbunch/mandrill-sdk package.
 *
 * (c) Dan McAdams <danmcadams@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DZMC\Mandrill\Tests\Message\Dispatcher;


use DZMC\Mandrill\Exception\EmptyResponseException;
use DZMC\Mandrill\Message as Message;
use DZMC\Mandrill\Response;
use DZMC\Mandrill\Tests\Mock\MessagesSpy;
use DZMC\Mandrill\Tests\Mock\NoResponseMessagesMock;
use PHPUnit\Framework\TestCase;

/**
 * Class MessageDispatcherTest
 *
 * @author  Dan McAdams
 * @package DZMC\Mandrill\Tests\Message
 *
 * @group   unit
 * @group   message
 * @group   dispatcher
 */
class MessageDispatcherSendMessageTest extends MessageDispatcherTestCase
{
    public function testSendMessage()
    {
        $message = new Message\Message();
        $this->dispatcher->send($message);

        $this->assertEquals($message->toArray(), $this->messagesSpy->providedMessage);
    }

    public function testIpPool()
    {
        $message = new Message\Message();

        $this->dispatcher->setIpPool('ip_pool');
        $this->dispatcher->send($message);
        $this->assertEquals('ip_pool', $this->messagesSpy->providedIpPool);

        $this->dispatcher->clearIpPool();
        $this->dispatcher->send($message);
        $this->assertEquals(null, $this->messagesSpy->providedIpPool);
    }

    public function testSendAtNoRejectReasonResponse()
    {
        $message     = new Message\Message();
        $messagesSpy = new MessagesSpy([['email' => 'email@email.com', '_id' => uniqid(), 'status' => 'queued']]);
        $dispatcher  = new Message\Dispatcher($messagesSpy);

        $dispatcher->send($message);
        $this->assertEquals($message->toArray(), $messagesSpy->providedMessage);
    }

    public function testSendAt()
    {
        $message  = new Message\Message();

        $sendDate          = new \DateTime();
        $sendDateFormatted = $sendDate->format('Y-m-d H:i:s');

        $this->dispatcher->sendAt($message, $sendDate);
        $this->assertEquals($message->toArray(), $this->messagesSpy->providedMessage);
        $this->assertEquals($sendDateFormatted, $this->messagesSpy->providedSendAt);
    }

    public function testNoResponse()
    {
        $messageService = new NoResponseMessagesMock();
        $dispatcher     = new Message\Dispatcher($messageService);

        $this->assertEmpty($dispatcher->send(new Message\Message()));
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
        $messageService   = new MessagesSpy($expectedMessages);
        $dispatcher       = new Message\Dispatcher($messageService);

        $response = $dispatcher->send(new Message\Message());

        $this->assertInternalType('array', $response);
        $this->assertInstanceOf(Message\SendResponse::class, $response[0]);
        $this->assertEquals($expectedMessages[0], $response[0]->toArray());
    }
}
