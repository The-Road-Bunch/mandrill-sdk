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
 * Class RejectReason
 *
 * The reason for the rejection if the recipient status is "rejected"
 *
 * @author  Dan McAdams
 * @package RoadBunch\Mandrill\Message
 */
final class RejectReason
{
    const HARD_BOUNCE     = 'hard-bounce';
    const SOFT_BOUNCE     = 'soft-bounce';
    const SPAM            = 'spam';
    const UNSUB           = 'ubsub';
    const CUSTOM          = 'custom';
    const INVALID_SENDER  = 'invalid-sender';
    const INVALID         = 'invalid';
    const TEST_MODE_LIMIT = 'test-mode-limit';
    const UNSIGNED        = 'unsigned';
    const RULE            = 'rule';
}
