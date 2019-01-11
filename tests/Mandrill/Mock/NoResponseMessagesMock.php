<?php declare(strict_types=1);

/**
 * This file is part of the theroadbunch/mandrill-sdk package.
 *
 * (c) Dan McAdams <danmcadams@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RoadBunch\Tests\Mandrill\Mock;


/**
 * Class NoResponseMessagesSpy
 *
 * @author  Dan McAdams
 * @package RoadBunch\Tests\Mandrill\Mock
 */
class NoResponseMessagesMock extends MessagesSpy
{
    /**
     * @param \struct $message
     * @param bool    $async
     * @param null    $ip_pool
     * @param null    $send_at
     *
     * @return array
     */
    public function send($message, $async = false, $ip_pool = NULL, $send_at = NULL): array
    {
        $this->providedMessage = $message;
        return [];
    }
}
