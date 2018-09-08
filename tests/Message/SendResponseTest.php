<?php declare(strict_types=1);

/**
 * This file is part of the danmcadams/mandrill-sdk package.
 *
 * (c) Dan McAdams <danmcadams@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DZMC\Mandrill\Tests\Message;


use DZMC\Mandrill\Message\SendResponse;
use PHPUnit\Framework\TestCase;

/**
 * Class SendResponseTest
 *
 * @author  Dan McAdams
 * @package DZMC\Mandrill\Tests\Message
 */
class SendResponseTest extends TestCase
{
    public function testCreateSendResponse()
    {
        $mr = $this->getSampleMandrillResponse();
        $sr = $this->createSendResponse($mr);

        $this->assertEquals($mr['_id'], $sr->id);
        $this->assertEquals($mr['email'], $sr->email);
        $this->assertEquals($mr['status'], $sr->status);
        $this->assertEquals($mr['reject_reason'], $sr->rejectReason);
    }

    public function testSendResponseToArray()
    {
        $mr = $this->getSampleMandrillResponse();
        $sr = $this->createSendResponse($mr);

        $this->assertEquals($mr, $sr->toArray());
    }

    public function testToStringReturnProperJson()
    {
        $mr = $this->getSampleMandrillResponse();
        $sr = $this->createSendResponse($mr);

        $this->assertEquals(json_encode($mr), (string) $sr);
    }

    private function getSampleMandrillResponse(): array
    {
        return [
            'email'         => 'test@example.com',
            'status'        => 'sent',
            'reject_reason' => null,
            '_id'           => uniqid()
        ];
    }

    /**
     * @param array $mr A response from Mandrill
     * @return SendResponse
     */
    private function createSendResponse(array $mr): SendResponse
    {
        $sr = new SendResponse($mr['_id'], $mr['email'], $mr['status'], $mr['reject_reason']);
        return $sr;
    }
}
