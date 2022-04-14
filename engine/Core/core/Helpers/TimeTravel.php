<?php

/**
 * TimeTravel
 * 
 * Travel through time
 *
 * A helper class to work with some
 * DateTime | DatePeriod | DateInterval functionalities
 * 
 * @author Developer Kwame | <Kwame Oteng Appiah-Nti>
 */

namespace Base\Helpers;

use DateTime;
use DatePeriod;
use DateInterval;
use Exception;

class TimeTravel
{
    /**
     * Default minutes
     *
     * @var string
     */
    private $defaultMinutes = "30 minutes";

    /**
     * Start Date Time for a
     * time travel
     *
     * @var mixed
     */
    private $startDatetime = null;

    /**
     * End Date Time for a 
     * time travel
     *
     * @var mixed
     */
    private $endDatetime = null;

    /**
     * Hold datetime
     *
     * @var mixed
     */
    protected $datetime;

    /**
     * Periods between a timetravel
     *
     * @var array
     */
    public $periods = [];

    /**
     * Set DateTime Interval
     *
     * @param string $interval
     * @return DateInterval
     */
    public static function interval($interval = '1 hour'): DateInterval
    {

        $time_interval = '';

        $interval = strtolower($interval);

        $number = str_extract($interval, ' ');

        if (contains('hour', $interval)) {
            $time_interval = "PT" . $number . "H";
        }

        if (contains('minute', $interval)) {
            $time_interval = "PT" . $number . "M";
        }

        if (contains('second', $interval)) {
            $time_interval = "PT" . $number . "S";
        }

        if (contains('year', $interval)) {
            $time_interval = "P" . $number . "Y";
        }

        if (contains('month', $interval)) {
            $time_interval = "P" . $number . "M";
        }

        if (contains('week', $interval)) {
            $time_interval = "P" . $number . "W";
        }

        if (contains('day', $interval)) {
            $time_interval = "P" . $number . "D";
        }

        try {
            return new DateInterval($time_interval);
        } catch (Exception $e) {
            return new DateInterval('PT0M');
        }
    }

    /**
     * Use to set Timestamp for passed string
     *
     * @param string $dayOfWeek
     * @return int
     */
    private function useTimestamp(string $dayOfWeek)
    {
        if (contains('next', $dayOfWeek)) {
            return strtotime($dayOfWeek);
        }

        if (contains('last', $dayOfWeek)) {
            return strtotime($dayOfWeek);
        }

        return time();
    }

    /**
     * Travel to a said time
     *
     * @param string $date
     * @param string $interval
     * @return TimeTravel
     */
    public function to($date = '', $interval = ''): TimeTravel
    {
        if (empty($date)) {
            $date = date('Y-m-d H:i:s');
        }

        $datetime = new DateTime($date);

        if (empty($interval)) {
            $this->datetime = $datetime;
            return $this;
        }

        $interval = self::interval($interval);

        $this->datetime = $datetime->add($interval);

        return $this;
    }

    /**
     * Travel into the future
     *
     * @param string $interval
     * @return TimeTravel
     */
    public function for($interval = '1 minute'): TimeTravel
    {

        $date = date('Y-m-d H:i:s');

        $datetime = new DateTime($date);

        $interval = self::interval($interval);

        $this->datetime = $datetime->add($interval);

        return $this;
    }

    /**
     * Travel between two periods
     *
     * @return TimeTravel
     */
    public function between($startDatetime, $endDatetime): TimeTravel
    {
        $start = new DateTime($startDatetime);
        $end   = new DateTime($endDatetime);

        $this->startDatetime = $start;
        $this->endDatetime = $end;

        return $this;
    }

    /**
     * Travel occassionally in the future
     *
     * @param string $interval
     * @return TimeTravel
     */
    public function every($interval = '1 minute'): TimeTravel
    {
        $date = date('Y-m-d H:i:s');

        $ranges = null;

        if ($this->startDatetime && $this->endDatetime) {

            $interval = self::interval($interval);

            $ranges = new DatePeriod($this->startDatetime, $interval, $this->endDatetime);
        }

        $periods = [];

        // Start period (inclusive), jump through every period
        // until Last period (exclusive)
        if ($ranges) {
            foreach ($ranges as $range) {
                $periods[] = $range;
            }
            $this->periods = $periods;
            return $this;
        }

        $datetime = new DateTime($date);

        if (empty($interval)) {
            $interval = $this->defaultMinutes;
        }

        $interval = self::interval($interval);

        $this->datetime = $datetime->add($interval);
        return $this;
    }

    /**
     * Travel back in time
     *
     * @param string $interval
     * @return TimeTravel
     */
    public function back($interval = '0 day', $time = ''): TimeTravel
    {
        $date = new DateTime($time);

        if ($timestamp = $this->useTimestamp($interval)) {
            $date->setTimestamp($timestamp);
        }

        $interval = self::interval($interval);

        $this->datetime = !empty($time)
            ? $date->sub($interval)
            : $date->sub($interval);
        return $this;
    }

    /**
     * Format Datetime
     *
     * @param string $format
     * @return string
     */
    public function format($format = 'Y-m-d H:i:s')
    {
        return $this->datetime->format($format);
    }

    /**
     * Grab all periods, format them in a
     * date format and return as array
     *
     * @param string $format
     * @return mixed
     */
    public function formatTo($format = 'Y-m-d H:i:s')
    {

        if (!empty($this->periods)) {

            $periods = [];

            foreach ($this->periods as $value) {
                $periods[] = $value->format($format);
            }

            return $periods;
        }

        return false;
    }
}
