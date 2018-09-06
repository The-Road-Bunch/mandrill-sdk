<?php declare(strict_types=1);

/**
 * This file is part of the danmcadams/mandrill-sdk-wrapper package.
 *
 * (c) Dan McAdams <danmcadams@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DZMC\Mandrill\Message;

use DZMC\Mandrill\Response;


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
     * @return Response
     */
    public function send(Message $message, Options $options = null): Response
    {
        $payload = $message->toArray();

        if (null !== $options) {
            $payload = array_merge_recursive($payload, $options->toArray());
        }

        /** @noinspection PhpParamsInspection */
        return new Response($this->service->send($payload));
    }

    /**
     * @return \Mandrill_Messages
     */
    public function getService(): \Mandrill_Messages
    {
        return $this->service;
    }
}
