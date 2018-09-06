<?php
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
interface MessageDispatcherInterface
{
    /**
     * @param Message      $message
     * @param Options|null $options
     *
     * @return array
     */
    public function send(Message $message, Options $options = null): array;

    /**
     * @return \Mandrill_Messages
     */
    public function getService(): \Mandrill_Messages;
}
