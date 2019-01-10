<?php declare(strict_types=1);

/**
 * This file is part of the theroadbunch/mandrill-sdk package.
 *
 * (c) Dan McAdams <danmcadams@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DZMC\Mandrill;


/**
 * Class Response
 *
 * @author  Dan McAdams
 * @package DZMC\Mandrill
 */
class Response
{
    /**
     * The response provided from the mandrill sdk is an array
     * we'll just store it in here for now
     *
     * @var array $response
     */
    protected $response;

    /**
     * Response constructor.
     *
     * @param array $mandrillResponse
     */
    public function __construct(array $mandrillResponse)
    {
        $this->response = $mandrillResponse;
    }

    /**
     * @param string $index
     *
     * @return mixed
     */
    public function get(string $index)
    {
        if (!empty($this->response[$index])) {
            return $this->response[$index];
        }
        return null;
    }

    /**
     * Return the raw array provided by mandrill
     *
     * @return array
     */
    public function toArray()
    {
        return $this->response;
    }
}
