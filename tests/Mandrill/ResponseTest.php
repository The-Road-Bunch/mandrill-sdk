<?php declare(strict_types=1);

/**
 * This file is part of the theroadbunch/mandrill-sdk package.
 *
 * (c) Dan McAdams <danmcadams@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RoadBunch\Tests\Mandrill;

use RoadBunch\Mandrill\Message\RejectReason;
use RoadBunch\Mandrill\Response;
use PHPUnit\Framework\TestCase;


/**
 * Class ResponseTest
 *
 * @author  Dan McAdams
 * @package RoadBunch\Tests\Mandrill
 *
 * @group unit
 */
class ResponseTest extends TestCase
{
    public function testCreateResponse()
    {
        $response = new Response([]);
        $this->assertNotNull($response);
    }

    public function testCreateResponseWithArray()
    {
        $response = new Response([]);
        $this->assertEquals([], $response->toArray());
    }

    public function testGetResponseByIndex()
    {
        $mandrillResponse = [
            'email' => 'test@example.com'
        ];

        $response = new Response($mandrillResponse);

        $this->assertNotNull($response->get('email'));
        $this->assertEquals($mandrillResponse['email'], $response->get('email'));
    }

    public function testGetResponseIndexNotFound()
    {
        // create an empty response
        $response = new Response([]);
        $this->assertNull($response->get('email'));
    }

    public function testFullResponseArray()
    {
        $mandrillResponse = [
            'email'         => 'test@example.com',
            'status'        => 'sent',
            'reject-reason' => RejectReason::SPAM,
            '_id'           => uniqid()
        ];

        $response = new Response($mandrillResponse);

        foreach ($mandrillResponse as $key => $item) {
            $this->assertEquals($item, $response->get($key));
        }
    }
}
