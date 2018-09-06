<?php declare(strict_types=1);

/**
 * This file is part of the danmcadams/mandrill-sdk-wrapper package.
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
     * @param string $apiKey
     * @throws \Mandrill_Error
     */
    public function __construct(string $apiKey = '')
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
}
