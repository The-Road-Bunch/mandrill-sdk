<?php
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
interface MessageDispatcherInterface
{
    /**
     * @param string $ipPool
     *
     * @return mixed
     */
    public function setIpPool(string $ipPool);

    /**
     * @return mixed
     */
    public function clearIpPool();

    /**
     * @param Message      $message
     *
     * @return SendResponse[]
     */
    public function send(Message $message): array;

    /**
     * @param Message      $message
     * @param \DateTime    $sendAt
     *
     * @return SendResponse[]
     */
    public function sendAt(Message $message, \DateTime $sendAt): array;
}
