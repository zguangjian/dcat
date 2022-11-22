<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: user.proto

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>UserModel</code>
 */
class UserModel extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>int32 Id = 1;</code>
     */
    protected $Id = 0;
    /**
     * Generated from protobuf field <code>string Name = 2;</code>
     */
    protected $Name = '';
    /**
     * Generated from protobuf field <code>int32 Sex = 3;</code>
     */
    protected $Sex = 0;
    /**
     * Generated from protobuf field <code>int32 Status = 4;</code>
     */
    protected $Status = 0;
    /**
     * Generated from protobuf field <code>int32 Ctime = 5;</code>
     */
    protected $Ctime = 0;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type int $Id
     *     @type string $Name
     *     @type int $Sex
     *     @type int $Status
     *     @type int $Ctime
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\User::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>int32 Id = 1;</code>
     * @return int
     */
    public function getId()
    {
        return $this->Id;
    }

    /**
     * Generated from protobuf field <code>int32 Id = 1;</code>
     * @param int $var
     * @return $this
     */
    public function setId($var)
    {
        GPBUtil::checkInt32($var);
        $this->Id = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string Name = 2;</code>
     * @return string
     */
    public function getName()
    {
        return $this->Name;
    }

    /**
     * Generated from protobuf field <code>string Name = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setName($var)
    {
        GPBUtil::checkString($var, True);
        $this->Name = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>int32 Sex = 3;</code>
     * @return int
     */
    public function getSex()
    {
        return $this->Sex;
    }

    /**
     * Generated from protobuf field <code>int32 Sex = 3;</code>
     * @param int $var
     * @return $this
     */
    public function setSex($var)
    {
        GPBUtil::checkInt32($var);
        $this->Sex = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>int32 Status = 4;</code>
     * @return int
     */
    public function getStatus()
    {
        return $this->Status;
    }

    /**
     * Generated from protobuf field <code>int32 Status = 4;</code>
     * @param int $var
     * @return $this
     */
    public function setStatus($var)
    {
        GPBUtil::checkInt32($var);
        $this->Status = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>int32 Ctime = 5;</code>
     * @return int
     */
    public function getCtime()
    {
        return $this->Ctime;
    }

    /**
     * Generated from protobuf field <code>int32 Ctime = 5;</code>
     * @param int $var
     * @return $this
     */
    public function setCtime($var)
    {
        GPBUtil::checkInt32($var);
        $this->Ctime = $var;

        return $this;
    }

}

