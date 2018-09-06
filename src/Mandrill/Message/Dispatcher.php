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


/**
 * Class Dispatcher
 *
 * @author  Dan McAdams
 * @package DZMC\Mandrill\Message
 */
class Dispatcher
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
     */
    public function send(Message $message, Options $options = null)
    {
        $payload = $message->toArray();

        if (null !== $options) {
            $payload = array_merge_recursive($payload, $options->toArray());
        }

        /** @noinspection PhpParamsInspection */
        $this->service->send($payload);
    }

    /**
     * @return \Mandrill_Messages
     */
    public function getService()
    {
        return $this->service;
    }
}
