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
 */
class MessageDispatcherTest extends TestCase
{
    /**
     * @var Message\Dispatcher $dispatcher
     */
    protected $dispatcher;

    /**
     *Ó @var MessagesSpy $messagesSpy
     */
    protected $messagesSpy;

    protected function setUp()
    {
        $this->messagesSpy = new MessagesSpy();
        $this->dispatcher  = new Message\Dispatcher($this->messagesSpy);
    }

    public function testSendMessage()
    {
        $message = new Message\Message();
        $this->dispatcher->send($message);

        $this->assertEquals($message->toArray(), $this->messagesSpy->providedMessage);
    }

    public function testSendMessageWithOptions()
    {
        $message  = new Message\Message();
        $options  = new Message\Options();
        $expected = array_merge($message->toArray(), $options->toArray());

        $this->dispatcher->send($message, $options);
        $this->assertEquals($expected, $this->messagesSpy->providedMessage);
    }

    public function testSendAt()
    {
        $message  = new Message\Message();
        $options  = new Message\Options();
        $expected = array_merge($message->toArray(), $options->toArray());

        $sendDate          = new \DateTime();
        $sendDateFormatted = $sendDate->format('Y-m-d H:i:s');

        $this->dispatcher->sendAt($message, $sendDate, $options);
        $this->assertEquals($expected, $this->messagesSpy->providedMessage);
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
