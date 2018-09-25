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

use DZMC\Mandrill\Message\Template;
use PHPUnit\Framework\TestCase;


/**
 * Class TemplateMessageTest
 *
 * @author  Dan McAdams
 * @package DZMC\Mandrill\Tests\Message
 */
class TemplateMessageTest extends TestCase
{
    public function testCreateTemplate()
    {
        $name     = 'template_constant';
        $template = new Template($name);

        $this->assertEquals($name, $template->getName());
    }

    public function testAddContent()
    {
        $template = new Template('test_constant');
        $template->addContent($name = 'BLOCKNAME', $content = 'content');

        $expect = [
            [
                'name'    => $name,
                'content' => $content
            ]
        ];
        $this->assertEquals($expect, $template->getContent());
    }
}
