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
        $payload = $message->toArray();

        if (null !== $options) {
            $payload = array_merge_recursive($payload, $options->toArray());
        }

        /** @noinspection PhpParamsInspection ignore error warning because Mandrill used \struct in their docblock */
        return $this->buildResponse($this->service->send($payload));
    }

    /**
     * @param $mandrillResponse
     * @return array
     */
    private function buildResponse($mandrillResponse): array
    {
        $response = [];
        foreach ($mandrillResponse as $result) {
            $response[] = new SendResponse($result['_id'], $result['email'], $result['status'], $result['reject_reason']);
        }
        return $response;
    }
}
