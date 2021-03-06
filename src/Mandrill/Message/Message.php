<?php declare(strict_types=1);

/**
 * This file is part of the theroadbunch/mandrill-sdk package.
 *
 * (c) Dan McAdams <danmcadams@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RoadBunch\Mandrill\Message;


use RoadBunch\Mandrill\Exception\ValidationException;
use RoadBunch\Mandrill\HeaderTrait;

/**
 * Class Message
 *
 * @author  Dan McAdams
 * @package RoadBunch\Mandrill
 */
class Message implements MessageInterface, MessageOptionsInterface
{
    use HeaderTrait;

    const MERGE_LANGUAGE_MAILCHIMP  = 'mailchimp';
    const MERGE_LANGUAGE_HANDLEBARS = 'handlebars';

    /**
     * whether or not this message is important,
     * and should be delivered ahead of non-important messages
     *
     * @var boolean $isImportant
     */
    protected $isImportant = false;

    /**
     * whether or not to turn on open tracking for the message
     *
     * @var boolean $trackOpens
     */
    protected $trackOpens;

    /**
     * whether or not to turn on click tracking for the message
     *
     * @var boolean $trackClicks
     */
    protected $trackClicks;

    /**
     * whether or not to automatically generate a text part for messages that are not given text
     *
     * @var boolean $autoText
     */
    protected $autoText;

    /**
     * whether or not to automatically generate an HTML part for messages that are not given HTML
     *
     * @var boolean $autoHtml
     */
    protected $autoHtml;

    /**
     * -- only for HTML documents less than 256KB in size --
     * whether or not to automatically inline all CSS styles provided in the message HTML
     *
     * @var boolean $inlineCss
     */
    protected $inlineCss;

    /**
     * whether or not to strip the query string from URLs when aggregating tracked URL data
     *
     * @var boolean $urlStripQs
     */
    protected $urlStripQs;

    /**
     * whether or not to expose all recipients in to "To" header for each email
     *
     * @var boolean $preserveRecipients
     */
    protected $preserveRecipients;

    /**
     * set to false to remove content logging for sensitive emails
     * (disables the 'view content' link on in the mandrill app)
     *
     * @var boolean $viewContentLink
     */
    protected $viewContentLink;

    /**
     * an optional address to receive an exact copy of each recipient's email
     *
     * @var string $bccAddress
     */
    protected $bccAddress;

    /**
     * a custom domain to use for tracking opens and clicks instead of mandrillapp.com
     *
     * @var string $trackingDomain
     */
    protected $trackingDomain;

    /**
     * a custom domain to use for SPF/DKIM signing instead of mandrill (for "via" or "on behalf of" in email clients)
     *
     * @var string $signingDomain
     */
    protected $signingDomain;

    /**
     * a custom domain to use for the messages's return-path
     *
     * @var string $returnPathDomain
     */
    protected $returnPathDomain;

    /**
     * metadata an associative array of user metadata.
     *  Mandrill will store this metadata and make it available for retrieval.
     *  In addition, you can select up to 10 metadata fields to index and make searchable using the Mandrill search api.
     *
     * @var array $metadata
     */
    protected $metadata = [];

    /**
     * global merge variables to use for all recipients. You can override these per recipient.
     *
     * @var array $globalMergeVars
     */
    protected $globalMergeVars = [];

    /**
     * the full HTML content to be sent
     *
     * @var string $html
     */
    protected $html = '';

    /**
     * optional full text content to be sent
     *
     * @var string $text
     */
    protected $text;

    /**
     * the message subject
     *
     * @var string $subject
     */
    protected $subject;

    /**
     * the sender email address
     *
     * @var string $fromEmail
     */
    protected $fromEmail;

    /**
     * optional from name to be used
     *
     * @var string $fromName
     */
    protected $fromName;

    /**
     * a collection of RecipientInterface - useful for easily building metadata and merge vars for recipients
     *
     * @var RecipientInterface[] $to
     */
    protected $to = [];

    /**
     * an array of strings indicating for which any matching URLs
     *  will automatically have Google Analytics parameters appended to their query string automatically.
     *
     * @var string[] $googleAnalyticsDomains
     */
    protected $googleAnalyticsDomains = [];

    /**
     * optional string indicating the value to set for the utm_campaign tracking parameter.
     *  If this isn't provided the email's from address will be used instead.
     *
     * @var string $googleAnalyticsCampaign
     */
    protected $googleAnalyticsCampaign;

    /**
     * an array of strings to tag the message with. Stats are accumulated using tags,
     *  though we only store the first 100 we see, so this should not be unique or change frequently.
     *  Tags should be 50 characters or less.
     *  Any tags starting with an underscore are reserved for internal use and will cause errors.
     *
     * @var array $tags
     */
    protected $tags = [];

    /**
     * the unique id of a subaccount for this message - must already exist or will fail with an error
     *
     * @var string $subaccount
     */
    protected $subaccount;

    /**
     * whether to evaluate merge tags in the message.
     *  Will automatically be set to true if either merge_vars or global_merge_vars are provided.
     *
     * @var bool $merge
     */
    protected $merge = false;

    /**
     * the merge tag language to use when evaluating merge tags, either mailchimp or handlebars
     *  one of mailchimp|handlebars
     *
     * @var string $mergeLanguage
     */
    protected $mergeLanguage = self::MERGE_LANGUAGE_MAILCHIMP;

    /**
     * an array of supported attachments to add to the message
     *
     * @var array $attachments
     */
    protected $attachments = [];

    /**
     * an array of embedded images to add to the message
     *
     * @var array $images
     */
    protected $images = [];

    /**
     * @param string $subject
     */
    public function setSubject(string $subject)
    {
        $this->subject = $subject;
    }

    /**
     * @param string      $email
     * @param string|null $name
     */
    public function setFrom(string $email, string $name = null)
    {
        $this->fromEmail = $email;
        $this->fromName  = $name;
    }

    /**
     * @param string $html
     */
    public function setHtml(string $html)
    {
        $this->html = $html;
    }

    /**
     * @param string $text
     */
    public function setText(string $text)
    {
        $this->text = $text;
    }

    /**
     * @param string $email
     */
    public function setReplyTo(string $email)
    {
        $this->addHeader('Reply-To', $email);
    }

    /**
     * @param string $email
     * @param string $name
     *
     * @return RecipientBuilderInterface
     * @throws ValidationException
     */
    public function addTo(string $email, string $name = ''): RecipientBuilderInterface
    {
        return $this->to[] = new ToRecipient($email, $name);
    }

    /**
     * @param string $email
     * @param string $name
     *
     * @return RecipientBuilderInterface
     * @throws ValidationException
     */
    public function addCc(string $email, string $name = ''): RecipientBuilderInterface
    {
        return $this->to[] = new CcRecipient($email, $name);
    }

    /**
     * @param string $email
     * @param string $name
     *
     * @return RecipientBuilderInterface
     * @throws ValidationException
     */
    public function addBcc(string $email, string $name = ''): RecipientBuilderInterface
    {
        return $this->to[] = new BccRecipient($email, $name);
    }

    /**
     * set important headers (I'm pretty sure mandrill does this already, but it can't hurt)
     */
    public function isImportant()
    {
        $this->isImportant = true;

        $this->addHeader('X-Priority', 1);
        $this->addHeader('X-MSMail-Priority', 'high');
        $this->addHeader('Importance', 'high');
    }

    /**
     * turn on tracking when an email is opened
     */
    public function trackOpens()
    {
        $this->trackOpens = true;
    }

    /**
     * turn on click tracking
     */
    public function trackClicks()
    {
        $this->trackClicks = true;
    }

    /**
     * tell mandrill to automatically generate text parts for messages that are not given text
     */
    public function autoGenerateText()
    {
        $this->autoText = true;
    }

    /**
     * tell mandrill to automatically generate text parts for messages that are not given text
     */
    public function autoGenerateHtml()
    {
        $this->autoHtml = true;
    }

    /**
     * tell mandrill to automatically inline all CSS styles provided in the message HTML
     */
    public function inlineCss()
    {
        $this->inlineCss = true;
    }

    /**
     * tell mandrill to strip the query string from URLs when aggregating tracked URL data
     */
    public function urlStripQs()
    {
        $this->urlStripQs = true;
    }

    /**
     * tell mandrill to expose all recipients in to "To" header for each email
     */
    public function preserveRecipients()
    {
        $this->preserveRecipients = true;
    }

    /**
     * disables the view content link for sensitive emails (will disable the link in the mandrill app)
     */
    public function disableContentLink()
    {
        $this->viewContentLink = false;
    }

    /**
     * an optional address to receive an exact copy of each recipient's email
     *
     * @param string $email
     */
    public function setBccAddress(string $email)
    {
        $this->bccAddress = $email;
    }

    /**
     * set a custom domain to use for tracking opens and clicks instead of mandrillapp.com
     *
     * @param string $domain
     */
    public function setTrackingDomain(string $domain)
    {
        $this->trackingDomain = $domain;
    }

    /**
     * set a custom domain to use for SPF/DKIM signing instead of mandrill (for "via" or "on behalf of" in email clients)
     *
     * @param string $domain
     */
    public function setSigningDomain(string $domain)
    {
        $this->signingDomain = $domain;
    }

    /**
     * set a custom domain to use for the messages's return-path
     *
     * @param string $domain
     */
    public function setReturnPathDomain(string $domain)
    {
        $this->returnPathDomain = $domain;
    }

    /**
     * using this method will overwrite all global metadata
     * but allows the user of this method to easily set metadata without a loop
     *
     * @param array $metadata
     */
    public function setMetadata(array $metadata)
    {
        $this->metadata = $metadata;
    }

    /**
     * add a key to the metadata array
     *
     * @param $key
     * @param $value
     */
    public function addMetadata($key, $value)
    {
        $this->metadata[$key] = $value;
    }

    /**
     * add a global merge variable
     *
     * @param string $name
     * @param        $content
     *
     * @throws ValidationException
     */
    public function addMergeVar(string $name, $content)
    {
        $this->merge = true;
        if ($this->stringStartsWithUnderscore($name)) {
            throw new ValidationException('Merge variables may not start with an underscore');
        }
        $this->globalMergeVars[] = ['name' => $name, 'content' => $content];
    }

    /**
     * A string to tag the message with. Stats are accumulated using tags,
     *  though we only store the first 100 we see, so this should not be unique or change frequently.
     *  Tags should be 50 characters or less.
     *  Any tags starting with an underscore are reserved for internal use and will cause errors.
     *
     * @param string $tag
     *
     * @throws ValidationException
     */
    public function addTag(string $tag)
    {
        if ($this->stringStartsWithUnderscore($tag)) {
            throw new ValidationException('Tags may not start with an underscore');
        }
        $this->tags[] = $tag;
    }

    /**
     * an array of strings indicating for which any matching URLs
     *  will automatically have Google Analytics parameters appended to their query string automatically.
     *
     * @param string $domain
     */
    public function addGoogleAnalyticsDomain(string $domain)
    {
        $this->googleAnalyticsDomains[] = $domain;
    }

    /**
     * optional string indicating the value to set for the utm_campaign tracking parameter.
     *  If this isn't provided the email's from address will be used instead.
     *
     * @param string $campaign
     */
    public function setGoogleAnalyticsCampaign(string $campaign)
    {
        $this->googleAnalyticsCampaign = $campaign;
    }

    /**
     * the unique id of a subaccount for this message - must already exist or will fail with an error
     *
     * @param string $subaccount
     */
    public function setSubaccount(string $subaccount)
    {
        $this->subaccount = $subaccount;
    }

    /**
     * set the merge language
     * mailchimp|handlebars
     *
     * @param string $mergeLanguage
     */
    public function setMergeLanguage(string $mergeLanguage)
    {
        $this->mergeLanguage = $mergeLanguage;
    }

    /**
     * a single supported attachment
     *
     * @param string $type    the MIME type of the attachment
     * @param string $name    the file name of the attachment
     * @param string $content the content of the attachment as a base64-encoded string
     */
    public function addAttachment(string $type, string $name, string $content)
    {
        $this->attachments[] = [
            'type'    => $type,
            'name'    => $name,
            'content' => $content
        ];
    }

    /**
     * an array of embedded images to add to the message
     *
     * @param string $type    the MIME type of the image - must start with "image/"
     * @param string $name    the Content ID of the image
     *                        use <img src="cid:THIS_VALUE"> to reference the image in your HTML content
     * @param string $content the content of the image as a base64-encoded string
     */
    public function addImage(string $type, string $name, string $content)
    {
        $this->images[] = [
            'type'    => $type,
            'name'    => $name,
            'content' => $content
        ];
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'html'                      => $this->html,
            'text'                      => $this->text,
            'subject'                   => $this->subject,
            'from_email'                => $this->fromEmail,
            'from_name'                 => $this->fromName,
            'to'                        => $this->extractRecipients(),
            'headers'                   => $this->headers,
            'merge_vars'                => $this->extractRecipientMergeVars(),
            'recipient_metadata'        => $this->extractRecipientMetadata(),
            'important'                 => $this->isImportant,
            'track_opens'               => $this->trackOpens,
            'track_clicks'              => $this->trackClicks,
            'auto_text'                 => $this->autoText,
            'auto_html'                 => $this->autoHtml,
            'inline_css'                => $this->inlineCss,
            'url_strip_qs'              => $this->urlStripQs,
            'preserve_recipients'       => $this->preserveRecipients,
            'view_content_link'         => $this->viewContentLink,
            'bcc_address'               => $this->bccAddress,
            'tracking_domain'           => $this->trackingDomain,
            'signing_domain'            => $this->signingDomain,
            'return_path_domain'        => $this->returnPathDomain,
            'metadata'                  => $this->metadata,
            'global_merge_vars'         => $this->globalMergeVars,
            'google_analytics_domains'  => $this->googleAnalyticsDomains,
            'google_analytics_campaign' => $this->googleAnalyticsCampaign,
            'tags'                      => $this->tags,
            'subaccount'                => $this->subaccount,
            'merge'                     => $this->merge,
            'merge_language'            => $this->mergeLanguage,
            'attachments'               => $this->attachments,
            'images'                    => $this->images
        ];
    }

    /**
     * build the 'to' array for sending off to Mandrill.
     *
     * @return array
     */
    private function extractRecipients()
    {
        $ret = [];
        foreach ($this->to as $recipient) {
            $ret[] = [
                'email' => $recipient->getEmail(),
                'name'  => $recipient->getName(),
                'type'  => $recipient->getType()
            ];
        }
        return $ret;
    }

    private function extractRecipientMergeVars(): array
    {
        $ret = [];
        foreach ($this->to as $recipient) {
            if ($mergeVars = $recipient->getMergeVars()) {
                $ret[] = [
                    'rcpt' => $recipient->getEmail(),
                    'vars' => $mergeVars
                ];
            }
        }
        $this->merge = $this->merge ?: !empty($ret);
        return $ret;
    }

    private function extractRecipientMetadata(): array
    {
        $ret = [];
        foreach ($this->to as $recipient) {
            if ($metadata = $recipient->getMetadata()) {
                $ret[] = [
                    'rcpt'   => $recipient->getEmail(),
                    'values' => $metadata
                ];
            }
        }
        return $ret;
    }

    /**
     * @param string $str
     *
     * @return bool
     */
    private function stringStartsWithUnderscore(string $str)
    {
        return substr($str, 0, 1) === '_';
    }
}
