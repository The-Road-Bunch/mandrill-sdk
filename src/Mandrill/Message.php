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


use DZMC\Mandrill\Exception\MandrillValidationException;

/**
 * Class Message
 *
 * @author  Dan McAdams
 * @package DZMC\Mandrill
 */
class Message
{
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
    protected $text = '';

    /**
     * the message subject
     *
     * @var string $subject
     */
    protected $subject = '';

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
    protected $fromName = '';

    /**
     * an array of recipient's information
     *
     * [
     *      [
     *          'email' => 'example@example.com',
     *          'name'  => 'Example Name',
     *          'type'  => 'to|cc|bcc'
     *      ]
     * ]
     *
     * @var array $to
     */
    protected $to = [];

    /**
     * optional extra headers to add to the message (most headers are allowed)
     *
     * @var array $headers
     */
    protected $headers = [];

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
     * @param string $subject
     */
    public function setSubject(string $subject)
    {
        $this->subject = $subject;
    }

    /**
     * @param string $fromEmail
     */
    public function setFromEmail(string $fromEmail)
    {
        $this->fromEmail = $fromEmail;
    }

    /**
     * @param string $fromName
     */
    public function setFromName(string $fromName)
    {
        $this->fromName = $fromName;
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
     * @param string $name
     *
     * @throws MandrillValidationException
     */
    public function addTo(string $email, string $name = '')
    {
        $this->addRecipient($email, $name);
    }

    /**
     * @param string $email
     * @param string $name
     *
     * @throws MandrillValidationException
     */
    public function addCc(string $email, string $name = '')
    {
        $this->addRecipient($email, $name, 'cc');
    }

    /**
     * @param string $email
     * @param string $name
     *
     * @throws MandrillValidationException
     */
    public function addBcc(string $email, string $name = '')
    {
        $this->addRecipient($email, $name, 'bcc');
    }

    /**
     * @param string $header
     * @param        $content
     */
    public function addHeader(string $header, $content)
    {
        $this->headers[$header] = $content;
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
     * add a recipient to the to array
     *
     * @param string $email
     * @param string $name
     * @param string $type to|cc|bcc
     *
     * @throws MandrillValidationException
     */
    protected function addRecipient(string $email, string $name = '', string $type = 'to')
    {
        if (empty($email)) {
            throw new MandrillValidationException('email cannot be empty');
        }

        $this->to[] = ['email' => $email, 'name' => $name, 'type' => $type];
    }
}
