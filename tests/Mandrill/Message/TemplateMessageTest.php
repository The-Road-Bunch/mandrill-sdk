<?php declare(strict_types=1);

/**
 * This file is part of the theroadbunch/mandrill-sdk package.
 *
 * (c) Dan McAdams <danmcadams@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RoadBunch\Tests\Mandrill\Message;

use RoadBunch\Mandrill\Message\Message;
use RoadBunch\Mandrill\Message\Template;
use RoadBunch\Mandrill\Message\TemplateMessage;
use PHPUnit\Framework\TestCase;


/**
 * Class TemplateMessageTest
 *
 * @author  Dan McAdams
 * @package RoadBunch\Tests\Mandrill\Message
 */
class TemplateMessageTest extends TestCase
{
    public function testCreateTemplateMessage()
    {
        $name     = 'template_constant';
        $templateMessage = new TemplateMessage($name);

        $this->assertEquals($name, $templateMessage->getName());
        $this->assertInstanceOf(Message::class, $templateMessage);
    }

    public function testAddContent()
    {
        $templateMessage = new TemplateMessage('test_constant');
        $templateMessage->addContent($name = 'BLOCKNAME', $content = 'content');

        $expect = [
            [
                'name'    => $name,
                'content' => $content
            ]
        ];
        $this->assertEquals($expect, $templateMessage->getContent());
    }
}
