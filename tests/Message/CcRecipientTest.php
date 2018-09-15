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

use DZMC\Mandrill\Message\CcRecipient;
use DZMC\Mandrill\Message\Recipient;
use DZMC\Mandrill\Message\RecipientBuilderInterface;
use PHPUnit\Framework\TestCase;


/**
 * Class CcRecipientTest
 *
 * @author  Dan McAdams
 * @package DZMC\Mandrill\Tests\Message
 */
class CcRecipientTest extends TestCase
{
    public function testCreateCcRecipient()
    {
        /** @var Recipient|RecipientBuilderInterface $recipient */
        $email     = 'test@example.com';
        $recipient = new CcRecipient($email);

        $this->assertInstanceOf(Recipient::class, $recipient);

        $expectedTo = [
            'email' => $email,
            'name'  => null,
            'type'  => 'cc'
        ];
        $this->assertEquals($expectedTo, $recipient->getToArray());
    }
}
