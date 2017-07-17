<?php
/**
 * LocalDateTime
 *
 * PHP version 5
 *
 * @category Class
 * @package  Swagger\Client
 * @author   http://github.com/swagger-api/swagger-codegen
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache Licene v2
 * @link     https://github.com/swagger-api/swagger-codegen
 */

/**
 * discussion
 *
 * No descripton provided (generated by Swagger Codegen https://github.com/swagger-api/swagger-codegen)
 *
 * OpenAPI spec version: 0.1.0-SNAPSHOT
 * 
 * Generated by: https://github.com/swagger-api/swagger-codegen.git
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/**
 * NOTE: This class is auto generated by the swagger code generator program.
 * https://github.com/swagger-api/swagger-codegen
 * Do not edit the class manually.
 */

namespace Swagger\Client\Discussion\Models;

use \ArrayAccess;

/**
 * LocalDateTime Class Doc Comment
 *
 * @category    Class */
/** 
 * @package     Swagger\Client
 * @author      http://github.com/swagger-api/swagger-codegen
 * @license     http://www.apache.org/licenses/LICENSE-2.0 Apache Licene v2
 * @link        https://github.com/swagger-api/swagger-codegen
 */
class LocalDateTime implements ArrayAccess
{
    /**
      * The original name of the model.
      * @var string
      */
    protected static $swaggerModelName = 'LocalDateTime';

    /**
      * Array of property to type mappings. Used for (de)serialization
      * @var string[]
      */
    protected static $swaggerTypes = array(
        'hour' => 'int',
        'minute' => 'int',
        'second' => 'int',
        'nano' => 'int',
        'day_of_year' => 'int',
        'day_of_week' => 'string',
        'month' => 'string',
        'day_of_month' => 'int',
        'year' => 'int',
        'month_value' => 'int',
        'chronology' => '\Swagger\Client\Discussion\Models\Chronology'
    );

    public static function swaggerTypes()
    {
        return self::$swaggerTypes;
    }

    /**
     * Array of attributes where the key is the local name, and the value is the original name
     * @var string[]
     */
    protected static $attributeMap = array(
        'hour' => 'hour',
        'minute' => 'minute',
        'second' => 'second',
        'nano' => 'nano',
        'day_of_year' => 'dayOfYear',
        'day_of_week' => 'dayOfWeek',
        'month' => 'month',
        'day_of_month' => 'dayOfMonth',
        'year' => 'year',
        'month_value' => 'monthValue',
        'chronology' => 'chronology'
    );

    public static function attributeMap()
    {
        return self::$attributeMap;
    }

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     * @var string[]
     */
    protected static $setters = array(
        'hour' => 'setHour',
        'minute' => 'setMinute',
        'second' => 'setSecond',
        'nano' => 'setNano',
        'day_of_year' => 'setDayOfYear',
        'day_of_week' => 'setDayOfWeek',
        'month' => 'setMonth',
        'day_of_month' => 'setDayOfMonth',
        'year' => 'setYear',
        'month_value' => 'setMonthValue',
        'chronology' => 'setChronology'
    );

    public static function setters()
    {
        return self::$setters;
    }

    /**
     * Array of attributes to getter functions (for serialization of requests)
     * @var string[]
     */
    protected static $getters = array(
        'hour' => 'getHour',
        'minute' => 'getMinute',
        'second' => 'getSecond',
        'nano' => 'getNano',
        'day_of_year' => 'getDayOfYear',
        'day_of_week' => 'getDayOfWeek',
        'month' => 'getMonth',
        'day_of_month' => 'getDayOfMonth',
        'year' => 'getYear',
        'month_value' => 'getMonthValue',
        'chronology' => 'getChronology'
    );

    public static function getters()
    {
        return self::$getters;
    }

    const DAY_OF_WEEK_MONDAY = 'MONDAY';
    const DAY_OF_WEEK_TUESDAY = 'TUESDAY';
    const DAY_OF_WEEK_WEDNESDAY = 'WEDNESDAY';
    const DAY_OF_WEEK_THURSDAY = 'THURSDAY';
    const DAY_OF_WEEK_FRIDAY = 'FRIDAY';
    const DAY_OF_WEEK_SATURDAY = 'SATURDAY';
    const DAY_OF_WEEK_SUNDAY = 'SUNDAY';
    const MONTH_JANUARY = 'JANUARY';
    const MONTH_FEBRUARY = 'FEBRUARY';
    const MONTH_MARCH = 'MARCH';
    const MONTH_APRIL = 'APRIL';
    const MONTH_MAY = 'MAY';
    const MONTH_JUNE = 'JUNE';
    const MONTH_JULY = 'JULY';
    const MONTH_AUGUST = 'AUGUST';
    const MONTH_SEPTEMBER = 'SEPTEMBER';
    const MONTH_OCTOBER = 'OCTOBER';
    const MONTH_NOVEMBER = 'NOVEMBER';
    const MONTH_DECEMBER = 'DECEMBER';
    

    
    /**
     * Gets allowable values of the enum
     * @return string[]
     */
    public function getDayOfWeekAllowableValues()
    {
        return [
            self::DAY_OF_WEEK_MONDAY,
            self::DAY_OF_WEEK_TUESDAY,
            self::DAY_OF_WEEK_WEDNESDAY,
            self::DAY_OF_WEEK_THURSDAY,
            self::DAY_OF_WEEK_FRIDAY,
            self::DAY_OF_WEEK_SATURDAY,
            self::DAY_OF_WEEK_SUNDAY,
        ];
    }
    
    /**
     * Gets allowable values of the enum
     * @return string[]
     */
    public function getMonthAllowableValues()
    {
        return [
            self::MONTH_JANUARY,
            self::MONTH_FEBRUARY,
            self::MONTH_MARCH,
            self::MONTH_APRIL,
            self::MONTH_MAY,
            self::MONTH_JUNE,
            self::MONTH_JULY,
            self::MONTH_AUGUST,
            self::MONTH_SEPTEMBER,
            self::MONTH_OCTOBER,
            self::MONTH_NOVEMBER,
            self::MONTH_DECEMBER,
        ];
    }
    

    /**
     * Associative array for storing property values
     * @var mixed[]
     */
    protected $container = array();

    /**
     * Constructor
     * @param mixed[] $data Associated array of property value initalizing the model
     */
    public function __construct(array $data = null)
    {
        $this->container['hour'] = isset($data['hour']) ? $data['hour'] : null;
        $this->container['minute'] = isset($data['minute']) ? $data['minute'] : null;
        $this->container['second'] = isset($data['second']) ? $data['second'] : null;
        $this->container['nano'] = isset($data['nano']) ? $data['nano'] : null;
        $this->container['day_of_year'] = isset($data['day_of_year']) ? $data['day_of_year'] : null;
        $this->container['day_of_week'] = isset($data['day_of_week']) ? $data['day_of_week'] : null;
        $this->container['month'] = isset($data['month']) ? $data['month'] : null;
        $this->container['day_of_month'] = isset($data['day_of_month']) ? $data['day_of_month'] : null;
        $this->container['year'] = isset($data['year']) ? $data['year'] : null;
        $this->container['month_value'] = isset($data['month_value']) ? $data['month_value'] : null;
        $this->container['chronology'] = isset($data['chronology']) ? $data['chronology'] : null;
    }

    /**
     * show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalid_properties = array();
        $allowed_values = array("MONDAY", "TUESDAY", "WEDNESDAY", "THURSDAY", "FRIDAY", "SATURDAY", "SUNDAY");
        if (!in_array($this->container['day_of_week'], $allowed_values)) {
            $invalid_properties[] = "invalid value for 'day_of_week', must be one of #{allowed_values}.";
        }

        $allowed_values = array("JANUARY", "FEBRUARY", "MARCH", "APRIL", "MAY", "JUNE", "JULY", "AUGUST", "SEPTEMBER", "OCTOBER", "NOVEMBER", "DECEMBER");
        if (!in_array($this->container['month'], $allowed_values)) {
            $invalid_properties[] = "invalid value for 'month', must be one of #{allowed_values}.";
        }

        return $invalid_properties;
    }

    /**
     * validate all the properties in the model
     * return true if all passed
     *
     * @return bool True if all properteis are valid
     */
    public function valid()
    {
        $allowed_values = array("MONDAY", "TUESDAY", "WEDNESDAY", "THURSDAY", "FRIDAY", "SATURDAY", "SUNDAY");
        if (!in_array($this->container['day_of_week'], $allowed_values)) {
            return false;
        }
        $allowed_values = array("JANUARY", "FEBRUARY", "MARCH", "APRIL", "MAY", "JUNE", "JULY", "AUGUST", "SEPTEMBER", "OCTOBER", "NOVEMBER", "DECEMBER");
        if (!in_array($this->container['month'], $allowed_values)) {
            return false;
        }
        return true;
    }


    /**
     * Gets hour
     * @return int
     */
    public function getHour()
    {
        return $this->container['hour'];
    }

    /**
     * Sets hour
     * @param int $hour
     * @return $this
     */
    public function setHour($hour)
    {
        $this->container['hour'] = $hour;

        return $this;
    }

    /**
     * Gets minute
     * @return int
     */
    public function getMinute()
    {
        return $this->container['minute'];
    }

    /**
     * Sets minute
     * @param int $minute
     * @return $this
     */
    public function setMinute($minute)
    {
        $this->container['minute'] = $minute;

        return $this;
    }

    /**
     * Gets second
     * @return int
     */
    public function getSecond()
    {
        return $this->container['second'];
    }

    /**
     * Sets second
     * @param int $second
     * @return $this
     */
    public function setSecond($second)
    {
        $this->container['second'] = $second;

        return $this;
    }

    /**
     * Gets nano
     * @return int
     */
    public function getNano()
    {
        return $this->container['nano'];
    }

    /**
     * Sets nano
     * @param int $nano
     * @return $this
     */
    public function setNano($nano)
    {
        $this->container['nano'] = $nano;

        return $this;
    }

    /**
     * Gets day_of_year
     * @return int
     */
    public function getDayOfYear()
    {
        return $this->container['day_of_year'];
    }

    /**
     * Sets day_of_year
     * @param int $day_of_year
     * @return $this
     */
    public function setDayOfYear($day_of_year)
    {
        $this->container['day_of_year'] = $day_of_year;

        return $this;
    }

    /**
     * Gets day_of_week
     * @return string
     */
    public function getDayOfWeek()
    {
        return $this->container['day_of_week'];
    }

    /**
     * Sets day_of_week
     * @param string $day_of_week
     * @return $this
     */
    public function setDayOfWeek($day_of_week)
    {
        $allowed_values = array('MONDAY', 'TUESDAY', 'WEDNESDAY', 'THURSDAY', 'FRIDAY', 'SATURDAY', 'SUNDAY');
        if (!in_array($day_of_week, $allowed_values)) {
            throw new \InvalidArgumentException("Invalid value for 'day_of_week', must be one of 'MONDAY', 'TUESDAY', 'WEDNESDAY', 'THURSDAY', 'FRIDAY', 'SATURDAY', 'SUNDAY'");
        }
        $this->container['day_of_week'] = $day_of_week;

        return $this;
    }

    /**
     * Gets month
     * @return string
     */
    public function getMonth()
    {
        return $this->container['month'];
    }

    /**
     * Sets month
     * @param string $month
     * @return $this
     */
    public function setMonth($month)
    {
        $allowed_values = array('JANUARY', 'FEBRUARY', 'MARCH', 'APRIL', 'MAY', 'JUNE', 'JULY', 'AUGUST', 'SEPTEMBER', 'OCTOBER', 'NOVEMBER', 'DECEMBER');
        if (!in_array($month, $allowed_values)) {
            throw new \InvalidArgumentException("Invalid value for 'month', must be one of 'JANUARY', 'FEBRUARY', 'MARCH', 'APRIL', 'MAY', 'JUNE', 'JULY', 'AUGUST', 'SEPTEMBER', 'OCTOBER', 'NOVEMBER', 'DECEMBER'");
        }
        $this->container['month'] = $month;

        return $this;
    }

    /**
     * Gets day_of_month
     * @return int
     */
    public function getDayOfMonth()
    {
        return $this->container['day_of_month'];
    }

    /**
     * Sets day_of_month
     * @param int $day_of_month
     * @return $this
     */
    public function setDayOfMonth($day_of_month)
    {
        $this->container['day_of_month'] = $day_of_month;

        return $this;
    }

    /**
     * Gets year
     * @return int
     */
    public function getYear()
    {
        return $this->container['year'];
    }

    /**
     * Sets year
     * @param int $year
     * @return $this
     */
    public function setYear($year)
    {
        $this->container['year'] = $year;

        return $this;
    }

    /**
     * Gets month_value
     * @return int
     */
    public function getMonthValue()
    {
        return $this->container['month_value'];
    }

    /**
     * Sets month_value
     * @param int $month_value
     * @return $this
     */
    public function setMonthValue($month_value)
    {
        $this->container['month_value'] = $month_value;

        return $this;
    }

    /**
     * Gets chronology
     * @return \Swagger\Client\Discussion\Models\Chronology
     */
    public function getChronology()
    {
        return $this->container['chronology'];
    }

    /**
     * Sets chronology
     * @param \Swagger\Client\Discussion\Models\Chronology $chronology
     * @return $this
     */
    public function setChronology($chronology)
    {
        $this->container['chronology'] = $chronology;

        return $this;
    }
    /**
     * Returns true if offset exists. False otherwise.
     * @param  integer $offset Offset
     * @return boolean
     */
    public function offsetExists($offset)
    {
        return isset($this->container[$offset]);
    }

    /**
     * Gets offset.
     * @param  integer $offset Offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return isset($this->container[$offset]) ? $this->container[$offset] : null;
    }

    /**
     * Sets value based on offset.
     * @param  integer $offset Offset
     * @param  mixed   $value  Value to be set
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    /**
     * Unsets offset.
     * @param  integer $offset Offset
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->container[$offset]);
    }

    /**
     * Gets the string presentation of the object
     * @return string
     */
    public function __toString()
    {
        if (defined('JSON_PRETTY_PRINT')) { // use JSON pretty print
            return json_encode(\Swagger\Client\ObjectSerializer::sanitizeForSerialization($this), JSON_PRETTY_PRINT);
        }

        return json_encode(\Swagger\Client\ObjectSerializer::sanitizeForSerialization($this));
    }
}


