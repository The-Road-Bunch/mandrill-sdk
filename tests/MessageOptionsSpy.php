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


use DZMC\Mandrill\MessageOptions;

/**
 * Class MessageOptionsSpy
 *
 * @author  Dan McAdams
 * @package DZMC\Mandrill\Tests
 */
class MessageOptionsSpy extends MessageOptions
{
    public function getAutoGenerateText()
    {
        return $this->autoText;
    }

    public function getAutoGenerateHtml()
    {
        return $this->autoHtml;
    }

    public function getHeaders()
    {
        return $this->headers;
    }

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
}
