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

use DZMC\Mandrill\Message\BccRecipient;
use DZMC\Mandrill\Message\Recipient;
use DZMC\Mandrill\Message\RecipientBuilderInterface;
use PHPUnit\Framework\TestCase;


/**
 * Class BccRecipientTest
 *
 * @author  Dan McAdams
 * @package DZMC\Mandrill\Tests\Message
 */
class BccRecipientTest extends TestCase
{
    public function testCreateBccRecipient()
    {
        /** @var Recipient|RecipientBuilderInterface $recipient */
        $email     = 'test@example.com';
        $recipient = new BccRecipient($email);

        $this->assertInstanceOf(Recipient::class, $recipient);

        $expectedTo = [
            'email' => $email,
            'name'  => null,
            'type'  => 'bcc'
        ];
        $this->assertEquals($expectedTo, $recipient->getToArray());
    }
}
