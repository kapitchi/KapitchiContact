<?php
namespace KapitchiContact\Entity;

/**
 *
 * @author Matus Zeman <mz@kapitchi.com>
 */
class Company
{
    protected $id;
    protected $contactId;
    protected $name;
    protected $refNumber;
    protected $taxRefNumber;
    protected $primaryContactId;
    
    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }
    
    public function getContactId()
    {
        return $this->contactId;
    }

    public function setContactId($contactId)
    {
        $this->contactId = $contactId;
    }
    
    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getRefNumber()
    {
        return $this->refNumber;
    }

    public function setRefNumber($refNumber)
    {
        $this->refNumber = $refNumber;
    }

    public function getTaxRefNumber()
    {
        return $this->taxRefNumber;
    }

    public function setTaxRefNumber($taxRefNumber)
    {
        $this->taxRefNumber = $taxRefNumber;
    }

    public function getPrimaryContactId()
    {
        return $this->primaryContactId;
    }

    public function setPrimaryContactId($primaryContactId)
    {
        $this->primaryContactId = $primaryContactId;
    }
}