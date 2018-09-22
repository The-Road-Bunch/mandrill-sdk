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
use DZMC\Mandrill\Message\Message;
use PHPUnit\Framework\TestCase;

/**
 * Class MessageOptionsTest
 *
 * @author  Dan McAdams
 * @package DZMC\Mandrill\Tests\Message
 *
 * @group unit
 * @group message
 */
class MessageOptionsTest extends TestCase
{
    /**
     * @var Message $message
     */
    protected $message;

    protected function setUp()
    {
        $this->message = new Message();
    }

    public function testSetIsImportant()
    {
        $this->message->isImportant();

        $headers = $this->message->toArray()['headers'];

        $this->assertTrue($this->message->toArray()['important']);
        $this->assertArrayHasKey('X-Priority', $headers);
        $this->assertEquals(1, $headers['X-Priority']);

        $this->assertArrayHasKey('X-MSMail-Priority', $headers);
        $this->assertEquals('high', $headers['X-MSMail-Priority']);

        $this->assertArrayHasKey('Importance', $headers);
        $this->assertEquals('high', $headers['Importance']);
    }

    public function testTrackOpens()
    {
        $this->message->trackOpens();
        $this->assertTrue($this->message->toArray()['track_opens']);
    }

    public function testTrackClicks()
    {
        $this->message->trackClicks();
        $this->assertTrue($this->message->toArray()['track_clicks']);
    }

    public function testAutoGenerateText()
    {
        $this->message->autoGenerateText();
        $this->assertTrue($this->message->toArray()['auto_text']);
    }

    public function testAutoGenerateHtml()
    {
        $this->message->autoGenerateHtml();
        $this->assertTrue($this->message->toArray()['auto_html']);
    }

    public function testInlineCss()
    {
        $this->message->inlineCss();
        $this->assertTrue($this->message->toArray()['inline_css']);
    }

    public function testUrlStripQs()
    {
        $this->message->urlStripQs();
        $this->assertTrue($this->message->toArray()['url_strip_qs']);
    }

    public function testPreserveRecipients()
    {
        $this->message->preserveRecipients();
        $this->assertTrue($this->message->toArray()['preserve_recipients']);
    }

    public function testDisableContentLink()
    {
        $this->message->disableContentLink();
        $this->assertFalse($this->message->toArray()['view_content_link']);
    }

    public function testSetBccAddress()
    {
        $email = 'test@example.com';

        $this->message->setBccAddress($email);
        $this->assertEquals($email, $this->message->toArray()['bcc_address']);
    }

    public function testSetTrackingDomain()
    {
        $domain = 'track.example.com';

        $this->message->setTrackingDomain($domain);
        $this->assertEquals($domain, $this->message->toArray()['tracking_domain']);
    }

    public function testSetSigningDomain()
    {
        $domain = 'sign.example.com';

        $this->message->setSigningDomain($domain);
        $this->assertEquals($domain, $this->message->toArray()['signing_domain']);
    }

    public function testSetReturnPathDomain()
    {
        $domain = 'return.example.com';

        $this->message->setReturnPathDomain($domain);
        $this->assertEquals($domain, $this->message->toArray()['return_path_domain']);
    }

    public function testSetMetadata()
    {
        $metadata = ['key' => 'value'];

        $this->message->setMetadata($metadata);
        $this->assertEquals($metadata, $this->message->toArray()['metadata']);
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

        $this->message->addMetadata($key1, $value1);
        $this->message->addMetadata($key2, $value2);

        $this->assertEquals($expected, $this->message->toArray()['metadata']);
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

        $this->message->addMergeVar($name, $content);
        $this->assertEquals($expected, $this->message->toArray()['global_merge_vars']);
    }

    public function testAddMergeVarInvalidKey()
    {
        $this->expectException(ValidationException::class);
        $this->message->addMergeVar('_invalid', 'this will fail');
    }
}
