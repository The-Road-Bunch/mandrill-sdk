<?php
/**
 * This file is part of the danmcadams/mandrill-sdk package.
 *
 * (c) Dan McAdams <danmcadams@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DZMC\Mandrill\Message;


/**
 * Class MessageOptions
 *
 * @author  Dan McAdams
 * @package DZMC\Mandrill
 */
interface MessageOptionsInterface
{
    /**
     * set important headers (I'm pretty sure mandrill does this already, but it can't hurt)
     */
    public function isImportant();

    /**
     * turn on tracking when an email is opened
     */
    public function trackOpens();

    /**
     * turn on click tracking
     */
    public function trackClicks();

    /**
     * tell mandrill to automatically generate text parts for messages that are not given text
     */
    public function autoGenerateText();

    /**
     * tell mandrill to automatically generate text parts for messages that are not given text
     */
    public function autoGenerateHtml();

    /**
     * tell mandrill to automatically inline all CSS styles provided in the message HTML
     */
    public function inlineCss();

    /**
     * tell mandrill to strip the query string from URLs when aggregating tracked URL data
     */
    public function urlStripQs();

    /**
     * tell mandrill to expose all recipients in to "To" header for each email
     */
    public function preserveRecipients();

    /**
     * disables the view content link for sensitive emails (will disable the link in the mandrill app)
     */
    public function disableContentLink();

    /**
     * an optional address to receive an exact copy of each recipient's email
     *
     * @param string $email
     */
    public function setBccAddress(string $email);

    /**
     * set a custom domain to use for tracking opens and clicks instead of mandrillapp.com
     *
     * @param string $domain
     */
    public function setTrackingDomain(string $domain);

    /**
     * set a custom domain to use for SPF/DKIM signing instead of mandrill (for "via" or "on behalf of" in email clients)
     *
     * @param string $domain
     */
    public function setSigningDomain(string $domain);

    /**
     * set a custom domain to use for the messages's return-path
     *
     * @param string $domain
     */
    public function setReturnPathDomain(string $domain);

    /**
     * @return array
     */
    public function toArray();
}
