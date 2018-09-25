<?php declare(strict_types=1);

/**
 * This file is part of the danmcadams/mandrill-sdk-wrapper package.
 *
 * (c) Dan McAdams <danmcadams@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DZMC\Mandrill\Tests\Message\Dispatcher;

use DZMC\Mandrill\Message as Message;
use DZMC\Mandrill\Tests\Mock\MessagesSpy;
use PHPUnit\Framework\TestCase;


/**
 * Class MessageDispatcherTestCase
 *
 * @author  Dan McAdams
 * @package DZMC\Mandrill\Tests\Message\Dispatcher
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
