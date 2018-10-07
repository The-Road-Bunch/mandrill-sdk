<?php
/**
 * This file is part of the danmcadams/mandrill-sdk-wrapper package.
 *
 * (c) Dan McAdams <danmcadams@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DZMC\Mandrill\Message;


/**
 * Class TemplateMessage
 *
 * @author  Dan McAdams
 * @package DZMC\Mandrill\Message
 */
interface TemplateMessageInterface extends MessageInterface
{
    /**
     * the immutable name or slug of a template that exists in the user's account.
     *
     * @return string
     */
    public function getName(): string;

    /**
     * @param string $name    the name of the mc:edit editable region to inject into
     * @param string $content the content to inject
     */
    public function addContent(string $name, string $content);

    /**
     * an array of template content to send.
     *
     * [[
     *      'name' => 'template_constant',
     *      'content' => 'template content'
     * ]]
     *
     * @return array
     */
    public function getContent(): array;
}
