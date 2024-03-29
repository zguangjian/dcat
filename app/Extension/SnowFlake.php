<?php

namespace App\Extension;

use Exception;

/**
 * 雪花算法
 * ID 生成策略
 * 毫秒级时间41位+机器ID, 10位+毫秒内序列12位。高位始终为0，表示正数。
 * 0           41     51     64
 * +-----------+------+------+
 * |time       |pc    |inc   |
 * +-----------+------+------+
 *  前41bits是以微秒为单位的timestamp。
 *  接着10bits是事先配置好的机器ID。
 *  最后12bits是累加计数器。
 *  macheine id(10bits)标明最多只能有1024台机器同时产生ID，sequence number(12bits)也标明1台机器1ms中最多产生4096个ID，
 *
 */
class SnowFlake
{
    private static $workerId;
    private static $maxWorkerId = 1023; //最大的机器节点, 2^10 - 1

    private static $sequence = 0;
    private static $sequenceMask = 4095; //最大的序列节点, 2^12 - 1

    private static $workerIdShift = 12; //机器ID左移位数,63 - 51
    private static $timestampLeftShift = 22; //毫秒时间戳左移位数,63 - 41

    private static $twepoch = 1288834974657;
    private static $lastTimestamp = -1;

    /**
     * @var self
     */
    private static $self = null;

    /**
     * @return self
     */
    public static function getInstance(): ?SnowFlake
    {
        if (self::$self == null) {
            self::$self = new self();
        }
        return self::$self;
    }

    /**
     * @return SnowFlake
     * @throws Exception
     * @throws Exception
     */
    public function setWorkId(): ?SnowFlake
    {
        $workId = rand(1, 1023);
        if ($workId > self::$maxWorkerId || $workId < 0) {
            throw new Exception("worker Id can't be greater than " . self::$maxWorkerId . " or less than 0");
        }
        self::$workerId = $workId;
        return self::$self;
    }

    /**
     * @return string
     */
    private function timeGen()
    {
        //获得当前时间戳
        $time = explode(' ', microtime());
        $time2 = substr($time[0], 2, 3);
        return $time[1] . $time2;
    }

    /**
     * @param $lastTimestamp
     * @return string
     */
    private function tilNextMillis($lastTimestamp): string
    {
        $timestamp = $this->timeGen();
        while ($timestamp <= $lastTimestamp) {
            $timestamp = $this->timeGen();
        }
        return $timestamp;
    }

    /**
     * @return int
     * @throws Exception
     */
    public function id(): int
    {
        $timestamp = $this->timeGen();

        //如果存在并发调用，则自增sequence
        if (self::$lastTimestamp == $timestamp) {
            self::$sequence = (self::$sequence + 1) & self::$sequenceMask;

            //如果sequence自增到4095，也就是4096 & 4095 = 0，重新取时间戳
            if (self::$sequence == 0) {
                $timestamp = $this->tilNextMillis(self::$lastTimestamp);
            }
        } else {
            self::$sequence = 0;
        }

        if ($timestamp < self::$lastTimestamp) {
            throw new Exception("Clock moved backwards.  Refusing to generate id for " . (self::$lastTimestamp - $timestamp) . " milliseconds");
        }

        self::$lastTimestamp = $timestamp;

        if (PHP_INT_SIZE === 4) {
            return 0;
        }

        return ((sprintf('%.0f', $timestamp) - sprintf(
                        '%.0f',
                        self::$twepoch
                    )) << self::$timestampLeftShift) | (self::$workerId << self::$workerIdShift) | self::$sequence;
    }
}
