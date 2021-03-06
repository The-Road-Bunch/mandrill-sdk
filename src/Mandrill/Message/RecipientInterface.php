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


interface RecipientInterface
{
    /**
     * per-recipient merge variables, which override global merge variables with the same name.
     *
     * @return array
     */
    public function getMergeVars(): array;

    /**
     * per-recipient metadata that will override the global values specified in the metadata parameter.
     *
     * @return array
     */
    public function getMetadata(): array;

    /**
     * the email address of the recipient
     *
     * @return string
     */
    public function getEmail(): string;

    /**
     * the optional display name to use for the recipient
     *
     * @return string
     */
    public function getName();

    /**
     * the header type to use for the recipient, defaults to "to" if not provided
     *
     * @return string to|cc|bcc
     */
    public function getType(): string;
}
