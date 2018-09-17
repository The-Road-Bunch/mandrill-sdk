<?php declare(strict_types=1);

/**
 * This file is part of the danmcadams/mandrill-sdk package.
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
class Message implements MessageInterface
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
     * a collection of RecipientInterface - useful for easily building metadata and merge vars for recipients
     *
     * @var RecipientInterface[] $to
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
     * @return array
     */
    public function toArray(): array
    {
        return [
            'html'               => $this->html,
            'text'               => $this->text,
            'subject'            => $this->subject,
            'from_email'         => $this->fromEmail,
            'from_name'          => $this->fromName,
            'to'                 => $this->extractRecipients(),
            'headers'            => $this->headers,
            'merge_vars'         => $this->extractMergeVars(),
            'recipient_metadata' => $this->extractMetadata()
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
            $ret[] = $recipient->getToArray();
        }
        return $ret;
    }

    private function extractMergeVars()
    {
        $ret = [];
        foreach ($this->to as $recipient) {
            if (!empty($mergeVars = $recipient->getMergeVars())) {
                $ret[] = [
                    'rcpt' => $recipient->getToArray()['email'],
                    'vars' => $mergeVars
                ];
            }
        }
        return $ret;
    }

    private function extractMetadata()
    {
        $ret = [];
        foreach ($this->to as $recipient) {
            if (!empty($metadata = $recipient->getMetadata())) {
                $ret[] = [
                    'rcpt'   => $recipient->getToArray()['email'],
                    'values' => $metadata
                ];
            }
        }
        return $ret;
    }
}
