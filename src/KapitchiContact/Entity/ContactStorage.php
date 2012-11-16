<?php
namespace KapitchiContact\Entity;

/**
 *
 * @author Matus Zeman <mz@kapitchi.com>
 */
class Contact
{
    protected $id;
    protected $typeHandle;
    protected $identityId;
    protected $displayName;
    
    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getTypeHandle()
    {
        return $this->typeHandle;
    }

    public function setTypeHandle($typeHandle)
    {
        $this->typeHandle = $typeHandle;
    }

    public function getIdentityId()
    {
        return $this->identityId;
    }

    public function setIdentityId($identityId)
    {
        $this->identityId = $identityId;
    }

    public function getDisplayName()
    {
        return $this->displayName;
    }

    public function setDisplayName($displayName)
    {
        $this->displayName = $displayName;
    }

}