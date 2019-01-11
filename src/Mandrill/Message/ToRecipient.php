<?php declare(strict_types=1);

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
 * Class ToRecipient
 *
 * @author  Dan McAdams
 * @package RoadBunch\Mandrill\Message
 */
class ToRecipient extends Recipient
{
    /**
     * the header type to use for the recipient, defaults to "to" if not provided
     *
     * @return string to|cc|bcc
     */
    public function getType(): string
    {
        return 'to';
    }
}
