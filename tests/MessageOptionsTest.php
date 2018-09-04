<?php declare(strict_types=1);

/**
 * This file is part of the danmcadams/mandrill-sdk-wrapper package.
 *
 * (c) Dan McAdams <danmcadams@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DZMC\Mandrill\Tests;


use PHPUnit\Framework\TestCase;

class MessageOptionsTest extends TestCase
{
    /**
     * @var MessageOptionsSpy $options
     */
    protected $options;

    protected function setUp()
    {
        $this->options = new MessageOptionsSpy();
    }

    public function testSetIsImportant()
    {
        $this->options->isImportant();

        $headers = $this->options->getHeaders();

        $this->assertTrue($this->options->getIsImportant());
        $this->assertArrayHasKey('X-Priority', $headers);
        $this->assertEquals(1, $headers['X-Priority']);

        $this->assertArrayHasKey('X-MSMail-Priority', $headers);
        $this->assertEquals('high', $headers['X-MSMail-Priority']);

        $this->assertArrayHasKey('Importance', $headers);
        $this->assertEquals('high', $headers['Importance']);
    }

    public function testTrackOpens()
    {
        $this->assertNull($this->options->getTrackOpens());
        $this->options->trackOpens();

        $this->assertTrue($this->options->getTrackOpens());
    }

    public function testTrackClicks()
    {
        $this->assertNull($this->options->getTrackClicks());
        $this->options->trackClicks();

        $this->assertTrue($this->options->getTrackClicks());
    }

    public function testAutoGenerateText()
    {
        $this->assertNull($this->options->getAutoGenerateText());
        $this->options->autoGenerateText();

        $this->assertTrue($this->options->getAutoGenerateText());
    }

    public function testAutoGenerateHtml()
    {
        $this->assertNull($this->options->getAutoGenerateHtml());
        $this->options->autoGenerateHtml();

        $this->assertTrue($this->options->getAutoGenerateHtml());
    }
}
