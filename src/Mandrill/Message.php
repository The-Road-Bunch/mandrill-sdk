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

class Message
{
    /** @var string $html */
    protected $html = '';

    /** @var string $text */
    protected $text = '';

    /** @var string $subject */
    protected $subject = '';

    /** @var string $fromEmail */
    protected $fromEmail;

    /** @var string $fromName */
    protected $fromName;

    /** @var array $to */
    protected $to = [];

    /** @var array $headers */
    protected $headers = [];

    /**
     * @return string
     */
    public function getSubject(): string
    {
        return $this->subject;
    }

    /**
     * @param string $subject
     */
    public function setSubject(string $subject)
    {
        $this->subject = $subject;
    }

    /**
     * @return string
     */
    public function getFromEmail(): string
    {
        return $this->fromEmail;
    }

    /**
     * @param string $fromEmail
     */
    public function setFromEmail(string $fromEmail)
    {
        $this->fromEmail = $fromEmail;
    }

    /**
     * @return string
     */
    public function getFromName(): string
    {
        return $this->fromName;
    }

    /**
     * @param string $fromName
     */
    public function setFromName(string $fromName)
    {
        $this->fromName = $fromName;
    }

    /**
     * @return string
     */
    public function getHtml(): string
    {
        return $this->html;
    }

    /**
     * @param string $html
     */
    public function setHtml(string $html)
    {
        $this->html = $html;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText(string $text)
    {
        $this->text = $text;
    }

    /**
     * @return array
     */
    public function getTo(): array
    {
        return $this->to;
    }

    /**
     * @param string $email
     * @param string $name
     *
     * @return $this
     * @throws MandrillValidationException
     */
    public function addTo(string $email, string $name = '')
    {
        if (empty($email)) {
            throw new MandrillValidationException('email cannot be empty');
        }

        $this->to[] = [
            'email' => $email,
            'name'  => $name,
            'type'  => 'to'
        ];
        return $this;
    }

    public function addHeader(string $header, string $content)
    {
        $this->headers[$header] = $content;
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    public function isImportant()
    {
    }
}
