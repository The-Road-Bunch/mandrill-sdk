<?php declare(strict_types=1);

/**
 * This file is part of the theroadbunch/mandrill-sdk package.
 *
 * (c) Dan McAdams <danmcadams@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RoadBunch\Tests\Mandrill\Message;

use RoadBunch\Mandrill\Message\AsyncDispatcher;
use RoadBunch\Mandrill\Message\Message;
use RoadBunch\Tests\Mandrill\Mock\MessagesSpy;
use PHPUnit\Framework\TestCase;


/**
 * Class AsyncMessageDispatcherTest
 *
 * @author  Dan McAdams
 * @package RoadBunch\Tests\Mandrill\Message
 *
 * @group unit
 * @group message
 * @group dispatcher
 */
class AsyncMessageDispatcherTest extends TestCase
{
    public function testSendAsync()
    {
        $messages   = new MessagesSpy();
        $dispatcher = new AsyncDispatcher($messages);

        $dispatcher->send(new Message());
        $this->assertTrue($messages->providedAsync);
    }
}
