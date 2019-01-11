<?php declare(strict_types=1);

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
 * Class TemplateMessage
 *
 * @author  Dan McAdams
 * @package RoadBunch\Mandrill\Message
 */
class TemplateMessage extends Message implements TemplateMessageInterface
{
    /**
     * the immutable name or slug of a template that exists in the user's account.
     *  For backwards-compatibility, the template name may also be used but the immutable slug is preferred.
     *
     * @var string $name
     */
    protected $name;

    /**
     * an array of template content to send.
     * Each item in the array should be a struct with two keys
     *  - name:     the name of the content block to set the content for
     *  - content:  the actual content to put into the block
     *
     * @var array $content
     */
    protected $content = [];

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * the immutable name or slug of a template that exists in the user's account.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }


    /**
     * @param string $name    the name of the mc:edit editable region to inject into
     * @param string $content the content to inject
     */
    public function addContent(string $name, string $content)
    {
        $this->content[] = [
            'name'    => $name,
            'content' => $content
        ];
    }

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
    public function getContent(): array
    {
        return $this->content;
    }
}
