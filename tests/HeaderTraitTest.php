<?php declare(strict_types=1);

/**
 * This file is part of the danmcadams/mandrill-sdk package.
 *
 * (c) Dan McAdams <danmcadams@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DZMC\Mandrill\Tests;


use DZMC\Mandrill\HeaderTrait;
use PHPUnit\Framework\TestCase;

/**
 * Class HeaderTraitTest
 *
 * @author  Dan McAdams
 * @package DZMC\Mandrill\Tests
 */
class HeaderTraitTest extends TestCase
{
    /**
     * @var HeaderTrait $headerTrait
     */
    protected $headerTrait;

    protected function setUp()
    {
        /** @var HeaderTrait headerTrait */
        $this->headerTrait = $this->getMockForTrait(HeaderTrait::class);
    }

    public function testHeadersDefaultToEmptyArray()
    {
        $this->assertInternalType('array', $this->headerTrait->getHeaders());
    }

    public function testAddHeader()
    {
        $name    = 'X-Force';
        $content = 'Maximum Effort';

        $this->headerTrait->addHeader($name, $content);

        $headers = $this->headerTrait->getHeaders();

        $this->assertArrayHasKey($name, $headers);
        $this->assertEquals($content, $headers[$name]);
    }
}
