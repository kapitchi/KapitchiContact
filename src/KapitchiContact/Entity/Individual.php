<?php
namespace KapitchiContact\Entity;

/**
 *
 * @author Matus Zeman <mz@kapitchi.com>
 */
class Individual
{
    protected $id;
    protected $contactId;
    protected $givenName;
    protected $middleName;
    protected $familyName;
    protected $maidenName;
    protected $honorificPrefix;
    protected $honorificSuffix;
    protected $dob;
    protected $personalId;
    
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
    
    public function getGivenName()
    {
        return $this->givenName;
    }

    public function setGivenName($givenName)
    {
        $this->givenName = $givenName;
    }

    public function getMiddleName()
    {
        return $this->middleName;
    }

    public function setMiddleName($middleName)
    {
        $this->middleName = $middleName;
    }

    public function getFamilyName()
    {
        return $this->familyName;
    }

    public function setFamilyName($familyName)
    {
        $this->familyName = $familyName;
    }

    public function getHonorificPrefix()
    {
        return $this->honorificPrefix;
    }

    public function setHonorificPrefix($honorificPrefix)
    {
        $this->honorificPrefix = $honorificPrefix;
    }

    public function getHonorificSuffix()
    {
        return $this->honorificSuffix;
    }

    public function setHonorificSuffix($honorificSuffix)
    {
        $this->honorificSuffix = $honorificSuffix;
    }

    public function getMaidenName()
    {
        return $this->maidenName;
    }

    public function setMaidenName($maidenName)
    {
        $this->maidenName = $maidenName;
    }

    public function getDob()
    {
        return $this->dob;
    }

    public function setDob($dob)
    {
        $this->dob = $dob;
    }

    public function getPersonalId()
    {
        return $this->personalId;
    }

    public function setPersonalId($personalId)
    {
        $this->personalId = $personalId;
    }

}