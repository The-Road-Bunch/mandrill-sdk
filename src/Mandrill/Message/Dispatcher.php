<?php declare(strict_types=1);

/**
 * This file is part of the danmcadams/mandrill-sdk package.
 *
 * (c) Dan McAdams <danmcadams@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DZMC\Mandrill\Message;

/**
 * Class Dispatcher
 *
 * @author  Dan McAdams
 * @package DZMC\Mandrill\Message
 */
class Dispatcher implements MessageDispatcherInterface
{
    /**
     * @var \Mandrill_Messages $service
     */
    protected $service;

    /**
     * the name of the dedicated ip pool that should be used to send the message.
     *  If you do not have any dedicated IPs, this parameter has no effect.
     *  If you specify a pool that does not exist, your default pool will be used instead.
     *
     * @var string $ipPool
     */
    protected $ipPool;

    /**
     * enable a background sending mode that is optimized for bulk sending.
     *  In async mode, messages/send will immediately return a status of "queued" for every recipient.
     *  To handle rejections when sending in async mode, set up a webhook for the 'reject' event.
     *  Defaults to false for messages with no more than 10 recipients;
     *  messages with more than 10 recipients are always sent asynchronously, regardless of the value of async.
     *
     * @var bool $async
     */
    protected $async;

    /**
     * Dispatcher constructor.
     *
     * @param \Mandrill_Messages $service
     * @param bool|null          $async
     */
    public function __construct(\Mandrill_Messages $service, bool $async = null)
    {
        $this->service = $service;
        $this->async   = $async;
    }

    /**
     * @param string $ipPool
     */
    public function setIpPool(string $ipPool)
    {
        $this->ipPool = $ipPool;
    }

    /**
     *
     */
    public function clearIpPool()
    {
        $this->ipPool = null;
    }

    /**
     * @param Message      $message
     * @param Options|null $options
     *
     * @return SendResponse[]
     */
    public function send(Message $message, Options $options = null): array
    {
        $payload = $this->buildMessagePayload($message, $options);
        return $this->sendMessage($payload);
    }

    /**
     * @param Message      $message
     * @param \DateTime    $sendAt
     * @param Options|null $options
     *
     * @return SendResponse[]
     */
    public function sendAt(Message $message, \DateTime $sendAt, Options $options = null): array
    {
        $payload = $this->buildMessagePayload($message, $options);
        return $this->sendMessage($payload, $sendAt);
    }

    /**
     * @param array          $payload
     * @param \DateTime|null $sendAt
     *
     * @return array
     */
    private function sendMessage(array $payload, \DateTime $sendAt = null): array
    {
        if (null !== $sendAt) {
            $sendAt = $sendAt->format('Y-m-d H:i:s');
        }

        /** @noinspection PhpParamsInspection ignore error warning because Mandrill used \struct in their docblock */
        return $this->buildResponse($this->service->send($payload, $this->async, $this->ipPool, $sendAt));
    }

    /**
     * @param $messagesResponse
     *
     * @return array
     */
    private function buildResponse(array $messagesResponse): array
    {
        $response = [];
        foreach ($messagesResponse as $mr) {
            $response[] = new SendResponse($mr['_id'], $mr['email'], $mr['status'], $mr['reject_reason']);
        }
        return $response;
    }

    /**
     * @param Message $message
     * @param Options $options
     *
     * @return array
     */
    private function buildMessagePayload(Message $message, Options $options = null): array
    {
        $payload = $message->toArray();

        if (null !== $options) {
            $payload = array_merge_recursive($payload, $options->toArray());
        }
        return $payload;
    }
}
