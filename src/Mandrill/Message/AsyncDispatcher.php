<?php declare(strict_types=1);

/**
 * This file is part of the theroadbunch/mandrill-sdk package.
 *
 * (c) Dan McAdams <danmcadams@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DZMC\Mandrill\Message;


/**
 * Class AsyncDispatcher
 *
 * @author  Dan McAdams
 * @package DZMC\Mandrill\Message
 */
class AsyncDispatcher extends Dispatcher
{
    public function __construct(\Mandrill_Messages $service)
    {
        $this->async = true;
        parent::__construct($service);
    }
}
