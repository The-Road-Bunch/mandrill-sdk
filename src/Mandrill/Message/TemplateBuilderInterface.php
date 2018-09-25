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


interface TemplateBuilderInterface
{
    /**
     * @param string $name    the name of the mc:edit editable region to inject into
     * @param string $content the content to inject
     *
     * @return Template
     */
    public function addContent(string $name, string $content): TemplateBuilderInterface;
}
