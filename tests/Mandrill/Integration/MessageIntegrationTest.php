<?php declare(strict_types=1);

/**
 * This file is part of the theroadbunch/mandrill-sdk package.
 *
 * (c) Dan McAdams <danmcadams@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RoadBunch\Tests\Mandrill\Integration;

use RoadBunch\Mandrill\Message\Message;
use RoadBunch\Mandrill\Message\MessageDispatcherInterface;
use RoadBunch\Mandrill\Message\Status;


/**
 * Class MessageTest
 *
 * @author  Dan McAdams
 * @package RoadBunch\Tests\Mandrill\Integration
 *
 * @group   integration
 * @group   message
 */
class MessageIntegrationTest extends MandrillTestCase
{
    /**
     * @var MessageDispatcherInterface $messageDispatcher
     */
    protected $messageDispatcher;

    /**
     * This should be provided in the phpunit.xml configuration file
     * If you decide to use these tests, make sure you're using your test API key from Mandrill instead
     *  of your production key.
     *
     * @var string $mandrillEmail
     */
    protected $mandrillEmail = MANDRILL_FROM_EMAIL;

    protected function setUp()
    {
        parent::setUp();
        $this->messageDispatcher = $this->dispatcherFactory->createMessageDispatcher();
    }

    public function testSendGenericMessage()
    {
        $message = $this->createGenericMessage();

        $response = $this->messageDispatcher->send($message);
        $this->assertEquals(Status::SENT, $response[0]->status);
    }

    public function testSendAt()
    {
        $message = $this->createGenericMessage();

        $response = $this->messageDispatcher->sendAt($message, new \DateTime('+1 day'));
        $this->assertEquals(Status::SCHEDULED, $response[0]->status);
    }

    /**
     * @return Message
     * @throws \RoadBunch\Mandrill\Exception\ValidationException
     */
    private function createGenericMessage(): Message
    {
        $message = new Message();
        $message->setFrom($this->mandrillEmail);
        $message->setText('A test email');
        $message->setSubject('A subject');

        $message->addTo('test@example.com', 'test email');
        return $message;
    }
}
