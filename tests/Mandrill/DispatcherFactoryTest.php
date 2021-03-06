<?php declare(strict_types=1);

/**
 * This file is part of the theroadbunch/mandrill-sdk package.
 *
 * (c) Dan McAdams <danmcadams@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RoadBunch\Tests\Mandrill;

use RoadBunch\Mandrill\DispatcherFactory;
use RoadBunch\Mandrill\Message as Message;
use PHPUnit\Framework\TestCase;


/**
 * Class DispatcherFactoryTest
 *
 * @author  Dan McAdams
 * @package RoadBunch\Tests\Mandrill
 *
 * @group unit
 * @group dispatcher
 */
class DispatcherFactoryTest extends TestCase
{
    public function testCreateDispatcherFactory()
    {
        $factory = new DispatcherFactory('test_api_key');
        $this->assertNotNull($factory);
    }

    public function testCreateMessageDispatcher()
    {
        $factory    = new DispatcherFactory('test_api_key');
        $dispatcher = $factory->createMessageDispatcher();

        $this->assertInstanceOf(Message\Dispatcher::class, $dispatcher);
    }

    public function testCreateAsyncMessageDispatcher()
    {
        $factory = new DispatcherFactory('test_api_key');
        $dispatcher = $factory->createAsyncMessageDispatcher();

        $this->assertInstanceOf(Message\AsyncDispatcher::class, $dispatcher);
    }
}
