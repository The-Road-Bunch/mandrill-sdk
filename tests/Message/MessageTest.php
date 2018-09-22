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
            'google_analytics_campaign' => null
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
}
