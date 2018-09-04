<?php declare(strict_types=1);

/**
 * This file is part of the danmcadams/mandrill-sdk-wrapper package.
 *
 * (c) Dan McAdams <danmcadams@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DZMC\Mandrill\Tests\Message;


use DZMC\Mandrill\Message\Message;

/**
 * Class MessageSpy
 *
 * @author  Dan McAdams
 * @package DZMC\Mandrill\Tests
 */
class MessageSpy extends Message
{
    public function getSubject(): string
    {
        return $this->subject;
    }

    public function getFromEmail(): string
    {
        return $this->fromEmail;
    }

    public function getFromName(): string
    {
        return $this->fromName;
    }

    public function getHtml(): string
    {
        return $this->html;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getRecipients(): array
    {
        return $this->to;
    }

    public function getHeaders()
    {
        return $this->headers;
    }
}
