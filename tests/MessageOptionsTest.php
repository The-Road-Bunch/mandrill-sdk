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

    /**
     * Technically, this is two tests
     *
     * It tests defaults and the toArray method
     */
    public function testDefaults()
    {
        $expected = [
            'headers'             => [],
            'important'           => false,
            'track_opens'         => null,
            'track_clicks'        => null,
            'auto_text'           => null,
            'auto_html'           => null,
            'inline_css'          => null,
            'url_strip_qs'        => null,
            'preserve_recipients' => null,
            'view_content_link'   => null,
            'bcc_address'         => null,
            'tracking_domain'     => null,
            'signing_domain'      => null,
            'return_path_domain'  => null
        ];

        $this->assertEquals($expected, $this->options->toArray());
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
        $this->options->trackOpens();
        $this->assertTrue($this->options->getTrackOpens());
    }

    public function testTrackClicks()
    {
        $this->options->trackClicks();
        $this->assertTrue($this->options->getTrackClicks());
    }

    public function testAutoGenerateText()
    {
        $this->options->autoGenerateText();
        $this->assertTrue($this->options->getAutoGenerateText());
    }

    public function testAutoGenerateHtml()
    {
        $this->options->autoGenerateHtml();
        $this->assertTrue($this->options->getAutoGenerateHtml());
    }

    public function testInlineCss()
    {
        $this->options->inlineCss();
        $this->assertTrue($this->options->getInlineCss());
    }

    public function testUrlStripQs()
    {
        $this->options->urlStripQs();
        $this->assertTrue($this->options->getUrlStripQs());
    }

    public function testPreserveRecipients()
    {
        $this->options->preserveRecipients();
        $this->assertTrue($this->options->getPreserveRecipients());
    }

    public function testDisableContentLink()
    {
        $this->options->disableContentLink();
        $this->assertFalse($this->options->getViewContentLink());
    }

    public function testSetBccAddress()
    {
        $email = 'test@example.com';

        $this->options->setBccAddress($email);
        $this->assertEquals($email, $this->options->getBccAddress());
    }

    public function testSetTrackingDomain()
    {
        $domain = 'track.example.com';

        $this->options->setTrackingDomain($domain);
        $this->assertEquals($domain, $this->options->getTrackingDomain());
    }

    public function testSetSigningDomain()
    {
        $domain = 'sign.example.com';

        $this->options->setSigningDomain($domain);
        $this->assertEquals($domain, $this->options->getSigningDomain());
    }

    public function testSetReturnPathDomain()
    {
        $domain = 'return.example.com';

        $this->options->setReturnPathDomain($domain);
        $this->assertEquals($domain, $this->options->getReturnPathDomain());
    }
}
