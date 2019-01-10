<?php declare(strict_types=1);

/**
 * This file is part of the theroadbunch/mandrill-sdk package.
 *
 * (c) Dan McAdams <danmcadams@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DZMC\Mandrill\Message;


/**
 * Class SendResponse
 *
 * @author  Dan McAdams
 * @package DZMC\Mandrill\Message
 */
class SendResponse
{
    /**
     * the message's unique id
     *
     * @var string $id
     */
    public $id;

    /**
     * the email address of the recipient
     *
     * @var string $email
     */
    public $email;

    /**
     * the sending status of the recipient
     *      - either "sent", "queued", "scheduled", "rejected", or "invalid"
     *
     * @var string $status
     */
    public $status;

    /**
     * the reason for the rejection if the recipient status is "rejected"
     *      - one of "hard-bounce", "soft-bounce", "spam", "unsub", "custom",
     *        "invalid-sender", "invalid", "test-mode-limit", "unsigned", or "rule"
     *
     * @var string $rejectReason
     */
    public $rejectReason;

    /**
     * SendResponse constructor.
     * @param string      $id
     * @param string      $email
     * @param string      $status
     * @param string|null $rejectReason
     */
    public function __construct(string $id, string $email, string $status, string $rejectReason = null)
    {
        $this->id           = $id;
        $this->email        = $email;
        $this->status       = $status;
        $this->rejectReason = $rejectReason;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'email'         => $this->email,
            'status'        => $this->status,
            'reject_reason' => $this->rejectReason,
            '_id'           => $this->id
        ];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return json_encode($this->toArray());
    }
}
