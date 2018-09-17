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

use DZMC\Mandrill\Exception\ValidationException;
use DZMC\Mandrill\Message\Recipient;
use PHPUnit\Framework\TestCase;


/**
 * Class RecipientTest
 *
 * @author  Dan McAdams
 * @package DZMC\Mandrill\Tests\Message
 */
class RecipientTest extends TestCase
{
    /**
     * @var Recipient $recipient
     */
    protected $recipient;

    protected function setUp()
    {
        $this->recipient = $this->createToRecipient('test@example.com', 'Test Name');
    }

    public function testGetToArray()
    {
        $email = 'test@example.com';
        $name  = 'Dan McAdams';

        $recipient = $this->createToRecipient($email, $name);

        $this->assertEquals(
            [
                'email' => $email,
                'name'  => $name,
                'type'  => 'to'
            ],
            $recipient->getToArray()
        );
    }

    public function testCreateWithEmptyEmail()
    {
        $this->expectException(ValidationException::class);
        $this->createToRecipient('');
    }

    public function testDefaultMergeVars()
    {
        $this->assertEquals([], $this->recipient->getMergeVars());
    }

    public function testDefaultMetadata()
    {
        $this->assertEquals([], $this->recipient->getMetadata());
    }

    public function testAddMetadata()
    {
        $this->recipient->addMetadata($key = 'test-key', $value = 'test value');
        $this->assertEquals(['test-key' => 'test value'], $this->recipient->getMetadata());
    }

    public function testAddMergeVarInvalidKey()
    {
        $this->expectException(ValidationException::class);
        $this->recipient->addMergeVar('_invalid', 'this will fail');
    }

    public function testAddMergeVar()
    {
        $expectedVars = [
            ['name' => 'var 1', 'content' => 'content 1'],
            ['name' => 'var 2', 'content' => 'content 2']
        ];

        foreach ($expectedVars as $var) {
            $this->recipient->addMergeVar($var['name'], $var['content']);
        }

        $this->assertEquals($expectedVars, $this->recipient->getMergeVars());
    }

    public function testGetEmail()
    {
        $email     = 'test@example.com';
        $recipient = $this->createToRecipient($email);

        $this->assertEquals($email, $recipient->getEmail());
    }

    private function createToRecipient($email, $name = '')
    {
        return new class($email, $name) extends Recipient
        {
            protected function getType(): string
            {
                return 'to';
            }
        };
    }
}
