<?php declare(strict_types=1);

/**
 * This file is part of the danmcadams/mandrill-sdk-wrapper package.
 *
 * (c) Dan McAdams <danmcadams@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DZMC\Mandrill\Tests\Message;

use DZMC\Mandrill\Message\AsyncDispatcher;
use DZMC\Mandrill\Message\Message;
use DZMC\Mandrill\Tests\Mock\MessagesSpy;
use PHPUnit\Framework\TestCase;


/**
 * Class AsyncMessageDispatcherTest
 *
 * @author  Dan McAdams
 * @package DZMC\Mandrill\Tests\Message
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
