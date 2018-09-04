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
}
