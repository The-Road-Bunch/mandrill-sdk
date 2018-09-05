<?php declare(strict_types=1);

/**
 * This file is part of the danmcadams/mandrill-sdk-wrapper package.
 *
 * (c) Dan McAdams <danmcadams@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DZMC\Mandrill\Message;


use DZMC\Mandrill\Exception\ValidationException;
use DZMC\Mandrill\HeaderTrait;

/**
 * Class Message
 *
 * @author  Dan McAdams
 * @package DZMC\Mandrill
 */
class Message
{
    use HeaderTrait;

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
     */
    public function setReplyTo(string $email)
    {
        $this->addHeader('Reply-To', $email);
    }

    /**
     * @param string $email
     * @param string $name
     *
     * @throws ValidationException
     */
    public function addTo(string $email, string $name = '')
    {
        $this->addRecipient($email, $name);
    }

    /**
     * @param string $email
     * @param string $name
     *
     * @throws ValidationException
     */
    public function addCc(string $email, string $name = '')
    {
        $this->addRecipient($email, $name, 'cc');
    }

    /**
     * @param string $email
     * @param string $name
     *
     * @throws ValidationException
     */
    public function addBcc(string $email, string $name = '')
    {
        $this->addRecipient($email, $name, 'bcc');
    }

    /**
     * add a recipient to the to array
     *
     * @param string $email
     * @param string $name
     * @param string $type to|cc|bcc
     *
     * @throws ValidationException
     */
    protected function addRecipient(string $email, string $name = '', string $type = 'to')
    {
        if (empty($email)) {
            throw new ValidationException('email cannot be empty');
        }

        $this->to[] = ['email' => $email, 'name' => $name, 'type' => $type];
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'html'       => $this->html,
            'text'       => $this->text,
            'subject'    => $this->subject,
            'from_email' => $this->fromEmail,
            'from_name'  => $this->fromName,
            'to'         => $this->to,
            'headers'    => $this->headers
        ];
    }
}
