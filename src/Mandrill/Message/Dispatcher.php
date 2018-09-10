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
     * Dispatcher constructor.
     *
     * @param \Mandrill_Messages $service
     */
    public function __construct(\Mandrill_Messages $service)
    {
        $this->service = $service;
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
     * @return array
     */
    public function sendAt(Message $message, \DateTime $sendAt, Options $options = null): array
    {
        $payload = $this->buildMessagePayload($message, $options);
        return $this->sendMessage($payload, null, null, $sendAt);
    }

    /**
     * @param array          $payload
     * @param bool|null      $async
     * @param string|null    $ipPool
     * @param \DateTime|null $sendAt
     *
     * @return array
     */
    private function sendMessage(array $payload, bool $async = null, string $ipPool = null, \DateTime $sendAt = null): array
    {
        if (null !== $sendAt) {
            $sendAt = $sendAt->format('Y-m-d H:i:s');
        }

        /** @noinspection PhpParamsInspection ignore error warning because Mandrill used \struct in their docblock */
        return $this->buildResponse($this->service->send($payload, $async, $ipPool, $sendAt));
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
