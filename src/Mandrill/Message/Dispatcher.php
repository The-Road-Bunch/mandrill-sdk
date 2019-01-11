<?php declare(strict_types=1);

/**
 * This file is part of the theroadbunch/mandrill-sdk package.
 *
 * (c) Dan McAdams <danmcadams@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RoadBunch\Mandrill\Message;

/**
 * Class Dispatcher
 *
 * @author  Dan McAdams
 * @package RoadBunch\Mandrill\Message
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
     */
    public function __construct(\Mandrill_Messages $service)
    {
        $this->service = $service;
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
     * @param Message $message
     *
     * @return SendResponse[]
     */
    public function send(Message $message): array
    {
        return $this->sendMessage($message);
    }

    /**
     * @param Message   $message
     * @param \DateTime $sendAt
     *          when this message should be sent as a UTC timestamp in YYYY-MM-DD HH:MM:SS format.
     *          If you specify a time in the past, the message will be sent immediately.
     *          An additional fee applies for scheduled email, and this feature is only available to accounts with a
     *          positive balance.
     *
     * @return SendResponse[]
     */
    public function sendAt(Message $message, \DateTime $sendAt): array
    {
        return $this->sendMessage($message, $this->formatDate($sendAt));
    }

    /**
     * @param Message     $message
     * @param string|null $sendAt
     *
     * @return SendResponse[]
     */
    private function sendMessage(Message $message, string $sendAt = null): array
    {
        /** @noinspection PhpParamsInspection ignore error warning because Mandrill used \struct in their docblock */
        return $this->buildResponse($this->service->send($message->toArray(), $this->async, $this->ipPool, $sendAt));
    }

    /**
     * @param TemplateMessage $message
     *
     * @return SendResponse[]
     */
    public function sendTemplate(TemplateMessage $message): array
    {
        return $this->sendTemplateMessage($message);
    }

    /**
     * @param TemplateMessage $message
     * @param \DateTime       $sendAt
     *          when this message should be sent as a UTC timestamp in YYYY-MM-DD HH:MM:SS format.
     *          If you specify a time in the past, the message will be sent immediately.
     *          An additional fee applies for scheduled email, and this feature is only available to accounts with a
     *          positive balance.
     *
     * @return array
     */
    public function sendTemplateAt(TemplateMessage $message, \DateTime $sendAt): array
    {
        return $this->sendTemplateMessage($message, $this->formatDate($sendAt));
    }

    /**
     * @param TemplateMessage $message
     * @param string|null     $sendAt
     *
     * @return array
     */
    private function sendTemplateMessage(TemplateMessage $message, string $sendAt = null)
    {
        /** @noinspection PhpParamsInspection ignore error warning because Mandrill used \struct in their docblock */
        return $this->buildResponse(
            $this->service->sendTemplate(
                $message->getName(),
                $message->getContent(),
                $message->toArray(),
                $this->async,
                $this->ipPool,
                $sendAt
            )
        );
    }

    /**
     * Mandrill's API returns an array of response array when you
     * send a message, here we'll convert them into objects before we return them to the user
     *
     * @param $messagesResponse
     *
     * @return SendResponse[]
     */
    private function buildResponse(array $messagesResponse): array
    {
        $resArray = [];
        foreach ($messagesResponse as $response) {
            $resArray[] = new SendResponse(
                $response['_id'],
                $response['email'],
                $response['status'],
                isset($response['reject_reason']) ? $response['reject_reason'] : null
            );
        }
        return $resArray;
    }

    /**
     * @param \DateTime $sendAt
     *
     * @return string
     */
    private function formatDate(\DateTime $sendAt): string
    {
        return $sendAt->format('Y-m-d H:i:s');
    }
}
