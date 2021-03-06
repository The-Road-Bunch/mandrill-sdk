<?php
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
     * @param Message   $message
     * @param \DateTime $sendAt
     *          when this message should be sent as a UTC timestamp in YYYY-MM-DD HH:MM:SS format.
     *          If you specify a time in the past, the message will be sent immediately.
     *          An additional fee applies for scheduled email, and this feature is only available to accounts with a
     *          positive balance.
     *
     * @return SendResponse[]
     */
    public function sendAt(Message $message, \DateTime $sendAt): array;

    /**
     * @param TemplateMessage $template
     *
     * @return SendResponse[]
     */
    public function sendTemplate(TemplateMessage $template): array;

    /**
     * @param TemplateMessage $message
     * @param \DateTime       $sendAt
     *          when this message should be sent as a UTC timestamp in YYYY-MM-DD HH:MM:SS format.
     *          If you specify a time in the past, the message will be sent immediately.
     *          An additional fee applies for scheduled email, and this feature is only available to accounts with a
     *          positive balance.
     *
     * @return SendResponse[]
     */
    public function sendTemplateAt(TemplateMessage $message, \DateTime $sendAt): array;
}
