<?php declare(strict_types=1);

/**
 * This file is part of the danmcadams/mandrill-sdk-wrapper package.
 *
 * (c) Dan McAdams <danmcadams@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DZMC\Mandrill\Tests\Integration;

use DZMC\Mandrill\DispatcherFactory;
use PHPUnit\Framework\TestCase;


/**
 * Class MandrillTestCase
 *
 * @author  Dan McAdams
 * @package DZMC\Mandrill\Tests\Integration
 *
 * @group integration
 * @group message
 */
class MandrillTestCase extends TestCase
{
    /**
     * @var DispatcherFactory $dispatcherFactory
     */
    protected $dispatcherFactory;

    protected function setUp()
    {
        $this->dispatcherFactory = new DispatcherFactory();
    }
}
