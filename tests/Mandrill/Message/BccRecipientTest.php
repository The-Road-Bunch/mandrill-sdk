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

use RoadBunch\Mandrill\Message\BccRecipient;
use RoadBunch\Mandrill\Message\Recipient;
use RoadBunch\Mandrill\Message\RecipientBuilderInterface;
use PHPUnit\Framework\TestCase;


/**
 * Class BccRecipientTest
 *
 * @author  Dan McAdams
 * @package RoadBunch\Tests\Mandrill\Message
 *
 * @group unit
 * @group message
 * @group recipient
 */
class BccRecipientTest extends TestCase
{
    public function testCreateBccRecipient()
    {
        /** @var Recipient|RecipientBuilderInterface $recipient */
        $email     = 'test@example.com';
        $recipient = new BccRecipient($email);

        $this->assertInstanceOf(Recipient::class, $recipient);

        $this->assertEquals('bcc', $recipient->getType());
    }
}
