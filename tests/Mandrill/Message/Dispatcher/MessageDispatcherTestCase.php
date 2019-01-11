<?php declare(strict_types=1);

/**
 * This file is part of the theroadbunch/mandrill-sdk package.
 *
 * (c) Dan McAdams <danmcadams@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RoadBunch\Tests\Mandrill\Message\Dispatcher;

use RoadBunch\Mandrill\Message as Message;
use RoadBunch\Tests\Mandrill\Mock\MessagesSpy;
use PHPUnit\Framework\TestCase;


/**
 * Class MessageDispatcherTestCase
 *
 * @author  Dan McAdams
 * @package RoadBunch\Tests\Mandrill\Message\Dispatcher
 */
class MessageDispatcherTestCase extends TestCase
{
    /**
     * @var Message\Dispatcher $dispatcher
     */
    protected $dispatcher;

    /**
     *Ó @var MessagesSpy $messagesSpy
     */
    protected $messagesSpy;

    protected function setUp()
    {
        $this->messagesSpy = new MessagesSpy();
        $this->dispatcher  = new Message\Dispatcher($this->messagesSpy);
    }
}
