<?php
/**
 * This file is part of the theroadbunch/mandrill-sdk package.
 *
 * (c) Dan McAdams <danmcadams@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RoadBunch\Mandrill\Message;


/**
 * Class Template
 *
 * @author  Dan McAdams
 * @package RoadBunch\Mandrill\Message
 */
interface TemplateInterface
{
    /**
     * the immutable name or slug of a template that exists in the user's account.
     *
     * @return string
     */
    public function getName(): string;

    /**
     * an array of template content to send.
     *
     * @return array
     */
    public function getContent(): array;
}
