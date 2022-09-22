<?php 

/**
 * ULID Helper
 *
 * This implements the abilities to create ULID's for Webby.
 * Code has been borrowed from https://github.com/robinvdvleuten/php-ulid
 *
 * Modified to use in Webby
 * by Kwame Oteng Appiah-Nti
 * 
 * @category Helpers
 * @author Robin van der Vleuten <robin@webstronauts.co>
 * @link https://github.com/robinvdvleuten/php-ulid
 * @license MIT
 */

namespace Base\Helpers;

class Ulid
{
    public const ENCODING_CHARS = '0123456789ABCDEFGHJKMNPQRSTVWXYZ';
    public const ENCODING_LENGTH = 32;

    public const TIME_MAX = 281474976710655;
    public const TIME_LENGTH = 10;

    public const RANDOM_LENGTH = 16;

    /**
     * Last Generated Time variable
     *
     * @var integer
     */
    private static $lastGeneratedTime = 0;

    /**
     * Last Random Chars variable
     *
     * @var array
     */
    private static $lastRandomChars = [];

    /**
     * @var string
     */
    private $time;

    /**
     * @var string
     */
    private $randomness;

    /**
     * @var bool
     */
    private $lowercase;

    private function __construct(string $time, string $randomness, bool $lowercase = false)
    {
        $this->time = $time;
        $this->randomness = $randomness;
        $this->lowercase = $lowercase;
    }

    /**
     * Use String function
     *
     * @param string $value
     * @param boolean $lowercase
     * @return self
     */
    public static function useString(string $value, bool $lowercase = false): self
    {
        if (strlen($value) !== static::TIME_LENGTH + static::RANDOM_LENGTH) {
            throw new InvalidUlidStringException('Invalid ULID string (wrong length): ' . $value);
        }

        // Convert to uppercase for regex. Doesn't matter for output later, that is determined by $lowercase.
        $value = strtoupper($value);

        if (!preg_match(sprintf('!^[%s]{%d}$!', static::ENCODING_CHARS, static::TIME_LENGTH + static::RANDOM_LENGTH), $value)) {
            throw new InvalidUlidStringException('Invalid ULID string (wrong characters): ' . $value);
        }

        return new static(substr($value, 0, static::TIME_LENGTH), substr($value, static::TIME_LENGTH, static::RANDOM_LENGTH), $lowercase);
    }

    /**
     * Create a ULID using the given timestamp.
     * @param int $milliseconds Number of milliseconds since the UNIX epoch for which to generate this ULID.
     * @param bool $lowercase True to output lowercase ULIDs.
     * @return Ulid Returns a ULID object for the given microsecond time.
     */
    public static function useTimestamp(int $milliseconds, bool $lowercase = false): self
    {
        $duplicateTime = $milliseconds === static::$lastGeneratedTime;

        static::$lastGeneratedTime = $milliseconds;

        $timeChars = '';
        $randChars = '';

        $encodingChars = static::ENCODING_CHARS;

        for ($i = static::TIME_LENGTH - 1; $i >= 0; $i--) {
            $mod = $milliseconds % static::ENCODING_LENGTH;
            $timeChars = $encodingChars[$mod].$timeChars;
            $milliseconds = ($milliseconds - $mod) / static::ENCODING_LENGTH;
        }

        if (!$duplicateTime) {
            for ($i = 0; $i < static::RANDOM_LENGTH; $i++) {
                static::$lastRandomChars[$i] = random_int(0, 31);
            }
        } else {
            // If the timestamp hasn't changed since last push,
            // use the same random number, except incremented by 1.
            for ($i = static::RANDOM_LENGTH - 1; $i >= 0 && static::$lastRandomChars[$i] === 31; $i--) {
                static::$lastRandomChars[$i] = 0;
            }

            static::$lastRandomChars[$i]++;
        }

        for ($i = 0; $i < static::RANDOM_LENGTH; $i++) {
            $randChars .= $encodingChars[static::$lastRandomChars[$i]];
        }

        return new static($timeChars, $randChars, $lowercase);
    }

    /**
     * Generate Id
     *
     * @param boolean $lowercase
     * @return self
     */
    public static function generate(bool $lowercase = false): self
    {
        $now = (int) (microtime(true) * 1000);
        
        return static::useTimestamp($now, $lowercase);
    }

    /**
     * Get Generated Id
     *
     * @return string
     */
    public function getId(): string
    {
        return ($value = $this->time . $this->randomness) && $this->lowercase ? strtolower($value) : strtoupper($value);
    }

    /**
     * Get Time
     *
     * @return string
     */
    public function getTime(): string
    {
        return $this->time;
    }

    /**
     * Get Randomness
     *
     * @return string
     */
    public function getRandomness(): string
    {
        return $this->randomness;
    }

    /**
     * Is Lower Case
     *
     * @return boolean
     */
    public function isLowercase(): bool
    {
        return $this->lowercase;
    }

    /**
     * To Timestamp
     *
     * @return integer
     */
    public function toTimestamp(): int
    {
        return $this->decodeTime($this->time);
    }

    /**
     * To String When Echoed
     *
     * @return string
     */
    public function __toString(): string
    {
        return ($value = $this->time . $this->randomness) && $this->lowercase ? strtolower($value) : strtoupper($value);
    }

    /**
     * Decode Time
     *
     * @param string $time
     * @return integer
     */
    private function decodeTime(string $time): int
    {
        $timeChars = str_split(strrev($time));
        $carry = 0;

        foreach ($timeChars as $index => $char) {
            if (($encodingIndex = strripos(static::ENCODING_CHARS, $char)) === false) {
                throw new InvalidUlidStringException('Invalid ULID character: ' . $char);
            }

            $carry += ($encodingIndex * pow(static::ENCODING_LENGTH, $index));
        }

        if ($carry > static::TIME_MAX) {
            throw new InvalidUlidStringException('Invalid ULID string: timestamp too large');
        }

        return $carry;
    }
}

/**
 * Thrown to indicate that the parsed ULID string is invalid.
 */
class InvalidUlidStringException extends \InvalidArgumentException {}
