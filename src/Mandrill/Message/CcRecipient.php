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
 * Class CcRecipient
 *
 * @author  Dan McAdams
 * @package DZMC\Mandrill\Message
 */
class CcRecipient extends Recipient
{
    /**
     * he header type to use for the recipient, defaults to "to" if not provided
     *
     * @return string to|cc|bcc
     */
    protected function getType(): string
    {
        return 'cc';
    }
}
