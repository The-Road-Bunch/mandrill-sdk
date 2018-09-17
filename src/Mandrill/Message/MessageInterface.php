<?php
/**
 * This file is part of the danmcadams/mandrill-sdk package.
 *
 * (c) Dan McAdams <danmcadams@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DZMC\Mandrill\Message;

use DZMC\Mandrill\Exception\ValidationException;


/**
 * Class Message
 *
 * @author  Dan McAdams
 * @package DZMC\Mandrill
 */
interface MessageInterface
{
    /**
     * @param string $subject
     */
    public function setSubject(string $subject);

    /**
     * @param string      $email
     * @param string|null $name
     *
     * @return mixed
     */
    public function setFrom(string $email, string $name = null);

    /**
     * @param string $html
     */
    public function setHtml(string $html);

    /**
     * @param string $text
     */
    public function setText(string $text);

    /**
     * @param string $email
     */
    public function setReplyTo(string $email);

    /**
     * @param string $email
     * @param string $name
     *
     * @throws ValidationException
     */
    public function addTo(string $email, string $name = '');

    /**
     * @param string $email
     * @param string $name
     *
     * @throws ValidationException
     */
    public function addCc(string $email, string $name = '');

    /**
     * @param string $email
     * @param string $name
     *
     * @throws ValidationException
     */
    public function addBcc(string $email, string $name = '');

    /**
     * @return array
     */
    public function toArray(): array;
}
