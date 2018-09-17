<?php declare(strict_types=1);

/**
 * This file is part of the danmcadams/mandrill-sdk package.
 *
 * (c) Dan McAdams <danmcadams@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DZMC\Mandrill;

use DZMC\Mandrill\Message as Message;


/**
 * Class DispatcherFactory
 *
 * @author  Dan McAdams
 * @package DZMC\Mandrill
 */
class DispatcherFactory
{
    /**
     * @var \Mandrill $service
     */
    protected $service;

    /**
     * DispatcherFactory constructor.
     *
     * If no api key is provided, Mandrill will check for an environment variable MANDRILL_APIKEY
     * If those don't exits, Mandrill will look for ~/.mandrill.key or /etc/mandrill.key
     *
     * @param string $apiKey
     * @throws \Mandrill_Error
     */
    public function __construct(string $apiKey = null)
    {
        $this->service = new \Mandrill($apiKey);
    }

    /**
     * @return Message\Dispatcher
     */
    public function createMessageDispatcher()
    {
        return new Message\Dispatcher($this->service->messages);
    }

    /**
     * @return Message\AsyncDispatcher
     */
    public function createAsyncMessageDispatcher()
    {
        return new Message\AsyncDispatcher($this->service->messages);
    }
}
