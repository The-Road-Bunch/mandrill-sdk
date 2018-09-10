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
 * Class Status
 *
 * @author  Dan McAdams
 * @package DZMC\Mandrill\Message
 */
final class Status
{
    const SENT      = 'sent';
    const QUEUED    = 'queued';
    const SCHEDULED = 'scheduled';
    const REJECTED  = 'rejected';
    const INVALID   = 'invalid';
}
