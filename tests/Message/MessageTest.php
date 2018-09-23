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
use DZMC\Mandrill\Message\BccRecipient;
use DZMC\Mandrill\Message\CcRecipient;
use DZMC\Mandrill\Message\Message;
use DZMC\Mandrill\Message\RecipientBuilderInterface;
use DZMC\Mandrill\Message\ToRecipient;
use PHPUnit\Framework\TestCase;

/**
 * Class MessageTest
 *
 * @author  Dan McAdams
 * @package DZMC\Mandrill\Tests
 *
 * @group   unit
 * @group   message
 */
class MessageTest extends TestCase
{
    /**
     * @var Message $message
     */
    protected $message;

    protected function setUp()
    {
        $this->message = new Message();
    }

    /**
     * Technically, this is two tests
     *
     * It tests defaults and the toArray method
     */
    public function testDefaults()
    {
        $message = new Message();

        $expected = [
            'html'                      => '',
            'text'                      => null,
            'subject'                   => null,
            'from_email'                => null,
            'from_name'                 => null,
            'to'                        => [],
            'headers'                   => [],
            'merge_vars'                => [],
            'recipient_metadata'        => [],
            'important'                 => false,
            'track_opens'               => null,
            'track_clicks'              => null,
            'auto_text'                 => null,
            'auto_html'                 => null,
            'inline_css'                => null,
            'url_strip_qs'              => null,
            'preserve_recipients'       => null,
            'view_content_link'         => null,
            'bcc_address'               => null,
            'tracking_domain'           => null,
            'signing_domain'            => null,
            'return_path_domain'        => null,
            'metadata'                  => [],
            'global_merge_vars'         => [],
            'google_analytics_domains'  => [],
            'google_analytics_campaign' => null,
            'tags'                      => [],
            'subaccount'                => null,
            'merge'                     => false,
            'merge_language'            => Message::MERGE_LANGUAGE_MAILCHIMP
        ];

        $this->assertEquals($expected, $message->toArray());
    }

    public function testSetHtml()
    {
        $html = "<html><body>here is a body</body></html>";

        $this->message->setHtml($html);
        $this->assertEquals($html, $this->message->toArray()['html']);
    }

    public function testSetText()
    {
        $text = 'test text';

        $this->message->setText($text);
        $this->assertEquals($text, $this->message->toArray()['text']);
    }

    public function testSetSubject()
    {
        $subject = 'a subject';

        $this->message->setSubject($subject);
        $this->assertEquals($subject, $this->message->toArray()['subject']);
    }

    public function testSetFrom()
    {
        $email = 'from@example.com';
        $name  = 'test name';

        $this->message->setFrom($email, $name);
        $this->assertEquals($email, $this->message->toArray()['from_email']);
        $this->assertEquals($name, $this->message->toArray()['from_name']);
    }

    public function testAddTo()
    {
        $toName  = 'to test';
        $toEmail = 'test@example.com';

        $toRecipient = $this->message->addTo($toEmail, $toName);

        $this->assertInstanceOf(RecipientBuilderInterface::class, $toRecipient);
        $this->assertInstanceOf(ToRecipient::class, $toRecipient);

        $this->assertCount(1, $this->message->toArray()['to']);
    }

    public function testAddCc()
    {
        $ccName  = 'cc test';
        $ccEmail = 'test@example.com';

        $ccRecipient = $this->message->addCc($ccEmail, $ccName);

        $this->assertInstanceOf(RecipientBuilderInterface::class, $ccRecipient);
        $this->assertInstanceOf(CcRecipient::class, $ccRecipient);

        $this->assertCount(1, $this->message->toArray()['to']);
    }

    public function testAddBcc()
    {
        $bccName  = 'bcc test';
        $bccEmail = 'test@example.com';

        $bccRecipient = $this->message->addBcc($bccEmail, $bccName);

        $this->assertInstanceOf(RecipientBuilderInterface::class, $bccRecipient);
        $this->assertInstanceOf(BccRecipient::class, $bccRecipient);

        $this->assertCount(1, $this->message->toArray()['to']);
    }

    public function testCreateToFromRecipients()
    {
        $toEmail = 'to@example.com';
        $toName  = 'to email';
        $ccEmail = 'cc@example.com';
        $ccName  = 'cc name';


        $expectedTo = [
            [
                'email' => $toEmail,
                'name'  => $toName,
                'type'  => 'to'
            ],
            [
                'email' => $ccEmail,
                'name'  => $ccName,
                'type'  => 'cc'
            ]
        ];
        $this->message->addTo($toEmail, $toName);
        $this->message->addCc($ccEmail, $ccName);

        $this->assertEquals($expectedTo, $this->message->toArray()['to']);
    }

    public function testBuildMergeVarsArray()
    {
        $name       = 'merge_var_1';
        $content    = 'merge content one';
        $nameTwo    = 'merge_var_2';
        $contentTwo = 'merge content two';
        $email      = 'test@example.com';

        $email2        = 'test2@example.com';
        $nameEmail2    = 'merge_var_name_2';
        $contentEmail2 = ' merge content email two';

        $expected = [
            [
                'rcpt' => $email,
                'vars' => [
                    [
                        'name'    => $name,
                        'content' => $content
                    ],
                    [
                        'name'    => $nameTwo,
                        'content' => $contentTwo
                    ]
                ]
            ],
            [
                'rcpt' => $email2,
                'vars' => [
                    [
                        'name'    => $nameEmail2,
                        'content' => $contentEmail2
                    ]
                ]
            ]
        ];
        $this->message->addTo($email)
                      ->addMergeVar($name, $content)
                      ->addMergeVar($nameTwo, $contentTwo);

        $this->message->addTo($email2)
                      ->addMergeVar($nameEmail2, $contentEmail2);

        $this->message->addCc('shouldnotshowup@example.com', 'dan');

        $this->assertEquals($expected, $this->message->toArray()['merge_vars']);
        $this->assertTrue($this->message->toArray()['merge']);
    }

    public function testBuildMetadataArray()
    {
        $email = 'test@example.com';
        $key1  = 'key1';
        $val1  = 'val1';
        $key2  = 'key2';
        $val2  = 'val2';

        $this->message->addTo($email)
                      ->addMetadata($key1, $val1)
                      ->addMetadata($key2, $val2);

        $expected = [
            [
                'rcpt'   => $email,
                'values' => [
                    $key1 => $val1,
                    $key2 => $val2
                ]
            ]
        ];
        $this->assertEquals($expected, $this->message->toArray()['recipient_metadata']);
    }

    public function testAddReplyTo()
    {
        $email = "replyto@example.com";

        $this->message->setReplyTo($email);

        $headers = $this->message->getHeaders();

        $this->assertArrayHasKey('Reply-To', $headers);
        $this->assertEquals($email, $headers['Reply-To']);
    }

    public function testAddGoogleAnalyticsDomain()
    {
        $domainOne = 'example.com';
        $domainTwo = 'test.example.com';

        $this->message->addGoogleAnalyticsDomain($domainOne);
        $this->message->addGoogleAnalyticsDomain($domainTwo);

        $expected = [$domainOne, $domainTwo];
        $this->assertEquals($expected, $this->message->toArray()['google_analytics_domains']);
    }

    public function testSetGoogleAnalyticsCampaign()
    {
        $campaign = 'messages.test@example.com';

        $this->message->setGoogleAnalyticsCampaign($campaign);
        $this->assertEquals($campaign, $this->message->toArray()['google_analytics_campaign']);
    }

    public function testAddTag()
    {
        $tagOne = 'tag_one';
        $tagTwo = 'tag_two';

        $this->message->addTag($tagOne);
        $this->message->addTag($tagTwo);

        $this->assertEquals([$tagOne, $tagTwo], $this->message->toArray()['tags']);
    }

    public function testAddTagStartingWithUnderscore()
    {
        $this->expectException(ValidationException::class);
        $this->message->addTag('_invalid');
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
        $this->assertTrue($this->message->toArray()['merge']);
    }

    public function testAddMergeVarStartingWithUnderscore()
    {
        $this->expectException(ValidationException::class);
        $this->message->addMergeVar('_invalid', 'this will fail');
    }

    public function testSetSubaccount()
    {
        $subaccount = 'subexample';

        $this->message->setSubaccount($subaccount);
        $this->assertEquals($subaccount, $this->message->toArray()['subaccount']);
    }

    public function testSetMergeLanguage()
    {
        $this->message->setMergeLanguage(Message::MERGE_LANGUAGE_MAILCHIMP);
        $this->assertEquals(Message::MERGE_LANGUAGE_MAILCHIMP, $this->message->toArray()['merge_language']);
    }
}
