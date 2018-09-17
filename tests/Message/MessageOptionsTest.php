<?php declare(strict_types=1);

/**
 * This file is part of the danmcadams/mandrill-sdk package.
 *
 * (c) Dan McAdams <danmcadams@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DZMC\Mandrill\Tests\Message;


use DZMC\Mandrill\Exception\ValidationException;
use DZMC\Mandrill\Message\Options;
use PHPUnit\Framework\TestCase;

class MessageOptionsTest extends TestCase
{
    /**
     * @var Options $options
     */
    protected $options;

    protected function setUp()
    {
        $this->options = new Options();
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
            'return_path_domain'  => null,
            'metadata'            => [],
            'global_merge_vars'   => []
        ];

        $this->assertEquals($expected, $this->options->toArray());
    }

    public function testSetIsImportant()
    {
        $this->options->isImportant();

        $headers = $this->options->toArray()['headers'];

        $this->assertTrue($this->options->toArray()['important']);
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
        $this->assertTrue($this->options->toArray()['track_opens']);
    }

    public function testTrackClicks()
    {
        $this->options->trackClicks();
        $this->assertTrue($this->options->toArray()['track_clicks']);
    }

    public function testAutoGenerateText()
    {
        $this->options->autoGenerateText();
        $this->assertTrue($this->options->toArray()['auto_text']);
    }

    public function testAutoGenerateHtml()
    {
        $this->options->autoGenerateHtml();
        $this->assertTrue($this->options->toArray()['auto_html']);
    }

    public function testInlineCss()
    {
        $this->options->inlineCss();
        $this->assertTrue($this->options->toArray()['inline_css']);
    }

    public function testUrlStripQs()
    {
        $this->options->urlStripQs();
        $this->assertTrue($this->options->toArray()['url_strip_qs']);
    }

    public function testPreserveRecipients()
    {
        $this->options->preserveRecipients();
        $this->assertTrue($this->options->toArray()['preserve_recipients']);
    }

    public function testDisableContentLink()
    {
        $this->options->disableContentLink();
        $this->assertFalse($this->options->toArray()['view_content_link']);
    }

    public function testSetBccAddress()
    {
        $email = 'test@example.com';

        $this->options->setBccAddress($email);
        $this->assertEquals($email, $this->options->toArray()['bcc_address']);
    }

    public function testSetTrackingDomain()
    {
        $domain = 'track.example.com';

        $this->options->setTrackingDomain($domain);
        $this->assertEquals($domain, $this->options->toArray()['tracking_domain']);
    }

    public function testSetSigningDomain()
    {
        $domain = 'sign.example.com';

        $this->options->setSigningDomain($domain);
        $this->assertEquals($domain, $this->options->toArray()['signing_domain']);
    }

    public function testSetReturnPathDomain()
    {
        $domain = 'return.example.com';

        $this->options->setReturnPathDomain($domain);
        $this->assertEquals($domain, $this->options->toArray()['return_path_domain']);
    }

    public function testSetMetadata()
    {
        $metadata = ['key' => 'value'];

        $this->options->setMetadata($metadata);
        $this->assertEquals($metadata, $this->options->toArray()['metadata']);
    }

    public function testAddMetadata()
    {
        $key1   = 'key1';
        $value1 = 'value1';
        $key2   = 'key2';
        $value2 = 'value2';

        $expected = [
            $key1 => $value1,
            $key2 => $value2
        ];

        $this->options->addMetadata($key1, $value1);
        $this->options->addMetadata($key2, $value2);

        $this->assertEquals($expected, $this->options->toArray()['metadata']);
    }

    public function testAddMergeVar()
    {
        $name    = 'merge_var';
        $content = 'merge content';

        $expected = [
            [
                'name'    => $name,
                'content' => $content
            ]
        ];

        $this->options->addMergeVar($name, $content);
        $this->assertEquals($expected, $this->options->toArray()['global_merge_vars']);
    }

    public function testAddMergeVarInvalidKey()
    {
        $this->expectException(ValidationException::class);
        $this->options->addMergeVar('_invalid', 'this will fail');
    }
}
