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

use DZMC\Mandrill\Exception\ValidationException;


/**
 * Class Recipient
 *
 * @author  Dan McAdams
 * @package DZMC\Mandrill\Message
 */
abstract class Recipient implements RecipientInterface, RecipientBuilderInterface
{
    /**
     * per-recipient merge variables, which override global merge variables with the same name.
     *
     * @var array $mergeVars
     */
    protected $mergeVars = [];

    /**
     * per-recipient metadata that will override the global values specified in the metadata parameter.
     *
     * @var array $metadata
     */
    protected $metadata  = [];

    /**
     * the email address of the recipient *REQUIRED
     *
     * @var string $email
     */
    protected $email;

    /**
     * the optional display name to use for the recipient
     *
     * @var string $name
     */
    protected $name;

    public function __construct(string $email, string $name = null)
    {
        if (empty($email)) {
            throw new ValidationException('email cannot be empty');
        }

        $this->email = $email;
        $this->name  = $name;
    }

    /**
     * @return array
     */
    public function getMetadata(): array
    {
        return $this->metadata;
    }

    /**
     * @return array
     */
    public function getMergeVars(): array
    {
        return $this->mergeVars;
    }

    /**
     * per-recipient merge variables, which override global merge variables with the same name.
     *
     * @param string $name
     * @param        $content
     *
     * @return $this
     * @throws ValidationException
     */
    public function addMergeVar(string $name, $content): RecipientBuilderInterface
    {
        if (substr($name, 0, 1) === '_') {
            throw new ValidationException('Merge variables may not start with an underscore');
        }
        $this->mergeVars[] = ['name' => $name, 'content' => $content];

        return $this;
    }

    /**
     * @param $key
     * @param $value
     *
     * @return $this
     */
    public function addMetadata($key, $value): RecipientBuilderInterface
    {
        $this->metadata[$key] = $value;

        return $this;
    }

    /**
     * the email address of the recipient
     *
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * the optional display name to use for the recipient
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}
