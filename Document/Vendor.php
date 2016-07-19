<?php
namespace MDB\AssetBundle\Document;

/**
 */
abstract class Vendor
{
    /**
     */
    protected $name;

    /**
     */
    protected $description;

    /**
     */
    protected $email;

    /**
     */
    protected $phones = array();

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    public function getPhones()
    {
        return $this->phones;
    }

    public function setPhones($phones)
    {
        $this->phones = $phones;

        return $this;
    }

    public function setPhone($type, $number)
    {
        $this->phones = array_merge($this->phones, array($type, $number));

        return $this;
    }

    public function hasPhone($type)
    {
        return isset($this->phones[$type]);
    }

    public function getPhone($type)
    {
        if ($this->hasPhone($type)) {
            return $this->phones[$type];
        }

        return null;
    }
}
