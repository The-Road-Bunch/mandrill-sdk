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


use DZMC\Mandrill\Message\Dispatcher;
use PHPUnit\Framework\TestCase;

/**
 * Class MessageDispatcherTest
 *
 * @author  Dan McAdams
 * @package DZMC\Mandrill\Tests\Message
 */
class MessageDispatcherTest extends TestCase
{
    public function testCreateDispatcher()
    {
        $dipatcher = new Dispatcher();
    }
}