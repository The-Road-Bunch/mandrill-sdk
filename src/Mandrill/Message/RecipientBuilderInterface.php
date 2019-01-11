<?php
/**
 * This file is part of the theroadbunch/mandrill-sdk package.
 *
 * (c) Dan McAdams <danmcadams@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RoadBunch\Mandrill\Message;


/**
 * Interface RecipientBuilderInterface
 *
 * @author  Dan McAdams
 * @package RoadBunch\Mandrill\Message
 */
interface RecipientBuilderInterface
{
    /**
     * per-recipient merge variables, which override global merge variables with the same name.
     *
     * @param string $name
     * @param        $content
     *
     * @return $this
     */
    public function addMergeVar(string $name, $content): RecipientBuilderInterface;

    /**
     * per-recipient metadata that will override the global values specified in the metadata parameter.
     *
     * @param $key
     * @param $value
     *
     * @return $this
     */
    public function addMetadata($key, $value): RecipientBuilderInterface;
}
