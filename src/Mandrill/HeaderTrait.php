<?php declare(strict_types=1);

/**
 * This file is part of the danmcadams/mandrill-sdk-wrapper package.
 *
 * (c) Dan McAdams <danmcadams@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DZMC\Mandrill;

/**
 * Trait HeaderTrait
 *
 * @package DZMC\Mandrill
 */
trait HeaderTrait
{
    /**
     * optional extra headers to add to the message (most headers are allowed)
     *
     * @var array $headers
     */
    protected $headers = [];

    /**
     * @param string $header
     * @param        $content
     */
    public function addHeader(string $header, $content)
    {
        $this->headers[$header] = $content;
    }
}