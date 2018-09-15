<?php
/**
 * This file is part of the danmcadams/mandrill-sdk-wrapper package.
 *
 * (c) Dan McAdams <danmcadams@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DZMC\Mandrill\Message;


interface RecipientInterface
{
    /**
     * an array of recipient's information
     *
     * [
     *      [
     *          'email' => 'example@example.com',
     *          'name'  => 'Example Name',
     *          'type'  => 'to|cc|bcc'
     *      ]
     * ]
     *
     * @return array
     */
    public function getToArray(): array;

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
}
