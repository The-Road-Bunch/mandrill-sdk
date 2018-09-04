<?php declare(strict_types=1);

/**
 * This file is part of the danmcadams/mandrill-sdk-wrapper package.
 *
 * (c) Dan McAdams <danmcadams@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DZMC\Mandrill;

/**
 * Class MessageOptions
 *
 * @author  Dan McAdams
 * @package DZMC\Mandrill
 */
class MessageOptions
{
    use HeaderTrait;

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
    protected $trackOpens = null;

    /**
     * whether or not to turn on click tracking for the message
     *
     * @var boolean $trackClicks
     */
    protected $trackClicks = null;

    /**
     * whether or not to automatically generate a text part for messages that are not given text
     *
     * @var boolean $autoText
     */
    protected $autoText = null;

    /**
     * whether or not to automatically generate an HTML part for messages that are not given HTML
     *
     * @var boolean $autoHtml
     */
    protected $autoHtml = null;

    /**
     * -- only for HTML documents less than 256KB in size --
     * whether or not to automatically inline all CSS styles provided in the message HTML
     *
     * @var boolean $inlineCss
     */
    protected $inlineCss = null;

    /**
     * whether or not to strip the query string from URLs when aggregating tracked URL data
     *
     * @var boolean $urlStripQs
     */
    protected $urlStripQs = null;

    /**
     * whether or not to expose all recipients in to "To" header for each email
     *
     * @var boolean $preserveRecipients
     */
    protected $preserveRecipients = null;

    /**
     * set to false to remove content logging for sensitive emails
     * (disables the 'view content' link on in the mandrill app)
     *
     * @var boolean $viewContentLink
     */
    protected $viewContentLink = null;

    /**
     * an optional address to receive an exact copy of each recipient's email
     *
     * @var string $bccAddress
     */
    protected $bccAddress = null;

    /**
     * a custom domain to use for tracking opens and clicks instead of mandrillapp.com
     *
     * @var string $trackingDomain
     */
    protected $trackingDomain = null;

    /**
     * a custom domain to use for SPF/DKIM signing instead of mandrill (for "via" or "on behalf of" in email clients)
     *
     * @var string $signingDomain
     */
    protected $signingDomain = null;

    /**
     * a custom domain to use for the messages's return-path
     *
     * @var string $returnPathDomain
     */
    protected $returnPathDomain = null;

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
     * @return array
     */
    public function toArray()
    {
        return [
            'important'           => $this->isImportant,
            'track_opens'         => $this->trackOpens,
            'track_clicks'        => $this->trackClicks,
            'auto_text'           => $this->autoText,
            'auto_html'           => $this->autoHtml,
            'headers'             => $this->headers,
            'inline_css'          => $this->inlineCss,
            'url_strip_qs'        => $this->urlStripQs,
            'preserve_recipients' => $this->preserveRecipients,
            'view_content_link'   => $this->viewContentLink,
            'bcc_address'         => $this->bccAddress,
            'tracking_domain'     => $this->trackingDomain,
            'signing_domain'      => $this->signingDomain,
            'return_path_domain'  => $this->returnPathDomain
        ];
    }

    public function __toString()
    {
        return json_encode($this->toArray());
    }
}
