<?php declare(strict_types=1);

/**
 * This file is part of the danmcadams/mandrill-sdk-wrapper package.
 *
 * (c) Dan McAdams <danmcadams@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DZMC\Mandrill\Tests\Mock;


/**
 * Class MessagesMock
 *
 * @author  Dan McAdams
 * @package DZMC\Mandrill\Tests\Mock
 */
class MessagesSpy extends \Mandrill_Messages
{
    public $providedMessage;

    public function __construct()
    {
    }

    /**
     * @param \struct $message
     * @param bool    $async
     * @param null    $ip_pool
     * @param null    $send_at
     *
     * @return array|void
     */
    public function send($message, $async = false, $ip_pool = NULL, $send_at = NULL)
    {
        $this->providedMessage = $message;
    }
}
