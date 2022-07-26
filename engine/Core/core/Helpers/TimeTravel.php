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
     * Default Seconds
     *
     * @var int
     */
    private $defaultSeconds = (60 * 60);

    /**
     * Default minutes
     *
     * @var string
     */
    private $defaultMinutes = "30 minutes";

    /**
     * Default Time Format
     *
     * @var string
     */
    public $defaultFormat = 'Y-m-d H:i:s';

    /**
     * Start Time for strtotime
     *
     * @var mixed
     */
    private $startTime = null;

    /**
     * End Time for strtotime
     *
     * @var mixed
     */
    private $endTime = null;

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
     * Day with hour constant
     * 
     * @var string
     */
    private const DAY_WITH_HOUR = '%a Days and %h hours';

    /**
     * Only Days constant
     * 
     * @var string
     */
    private const ONLY_DAYS = '%a Days';

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
            $date = date($this->defaultFormat);
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

        $date = date($this->defaultFormat);

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
        $date = date($this->defaultFormat);

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
     * Grab datetimes and convert to date strings
     *
     * @return TimeTravel
     */
    public function strToTime()
    {
        $startDatetime = $this->startDatetime->format($this->defaultFormat);
        $endDatetime = $this->endDatetime->format($this->defaultFormat);

        $this->startTime = strtotime($startDatetime);
        $this->endTime = strtotime($endDatetime);

        return $this;
    }

    /**
     * Return Days With Hours
     *
     * @return string
     */
    public function dayWithHour()
    {
        $difference = $this->endDatetime->diff($this->startDatetime);

        return $difference->format(TimeTravel::DAY_WITH_HOUR);
    }

    /**
     * Return Day Difference
     *
     * @return string
     */
    public function dayDifference()
    {
        $difference = $this->endDatetime->diff($this->startDatetime);

        return $difference->format(TimeTravel::ONLY_DAYS);
    }

    /**
     * Return Hour Difference
     *
     * @param bool $hrs
     * @return string
     */
    public function hourDifference($hrs = false)
    {
        $this->strToTime();

        $difference = ($this->endTime - $this->startTime);
        $hours = abs($difference / $this->defaultSeconds);

        return ($hrs) ? $hours . ' hrs' : $hours . ' hours';
    }

    /**
     * Return Time Duration
     *
     * @param string $format
     * @return string
     */
    public function duration($format = 'hours')
    {

        switch ($format) {
            case 'hours':
                return $this->hourDifference();
            break;

            case 'days':
                return $this->dayDifference();
            break;

            case 'day_hour':
                return $this->dayWithHour();
            break;

            default:
                return $this->hourDifference();
            break;
        }
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
     * Show Time using $this->format()
     *
     * @param string $format
     * @return string
     */
    public function showTime($format = 'Y-m-d H:i:s')
    {
        return $this->format($format);
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

    /**
     * Show Times using $this->formatTo()
     *
     * @param string $format
     * @return mixed
     */
    public function showTimes($format = 'Y-m-d H:i:s')
    {
        return $this->formatTo($format);
    }
}
