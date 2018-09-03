<?php declare(strict_types=1);

/**
 * This file is part of the danmcadams/mandrill-sdk-wrapper package.
 *
 * (c) Dan McAdams <danmcadams@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DZMC\Mandrill\Tests;


use DZMC\Mandrill\Message;

/**
 * Class MessageSpy
 *
 * @author  Dan McAdams
 * @package DZMC\Mandrill\Tests
 */
class MessageSpy extends Message
{
    public function getIsImportant()
    {
        return $this->isImportant;
    }

    public function getTrackOpens()
    {
        return $this->trackOpens;
    }

    public function getTrackClicks()
    {
        return $this->trackClicks;
    }

    /**
     * @return string
     */
    public function getSubject(): string
    {
        return $this->subject;
    }

    /**
     * @return string
     */
    public function getFromEmail(): string
    {
        return $this->fromEmail;
    }

    /**
     * @return string
     */
    public function getFromName(): string
    {
        return $this->fromName;
    }

    /**
     * @return string
     */
    public function getHtml(): string
    {
        return $this->html;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @return array
     */
    public function getRecipients(): array
    {
        return $this->to;
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }
}
