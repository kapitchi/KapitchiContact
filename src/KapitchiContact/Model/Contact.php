<?php

namespace KapitchiContact\Model;

use KapitchiBase\Stdlib\PluralField,
        KapitchiBase\Model\ModelAbstract;

/**
 * Let's try to be as much compatible with OpenSocial as possible.
 * http://opensocial-resources.googlecode.com/svn/spec/2.0.1/Social-Data.xml#Person
 */
class Contact extends ModelAbstract {
    protected $id;
    
    protected $name;
    protected $displayName;
    
    //PluralField<string>
    protected $phoneNumbers;
    
    //PluralField<string>
    protected $emails;
    
    //PluralField<Address>
    protected $addresses;
    
    public function __construct() {
        $this->name = new Name();
        $this->phoneNumbers = new PluralField();
        $this->emails = new PluralField();
        $this->addresses = new PluralField();
    }
    
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }
    
    public function setPhoneNumbers(array $phoneNumbers) {
        $this->phoneNumbers = PluralField::fromArray($phoneNumbers);
    }
    
    public function getPhoneNumbers() {
        return $this->phoneNumbers;
    }
    
    public function setEmails(array $emails) {
        $this->emails = PluralField::fromArray($emails);
    }
    
    public function getEmails() {
        return $this->emails;
    }
    
    public function setAddresses(array $addresses) {
        $this->addresses = PluralField::fromArray($addresses);
    }
    
    public function getAddresses() {
        return $this->addresses;
    }
    
    public function setName(array $name) {
        $this->name = Name::fromArray($name);
    }
    
    public function getName() {
        return $this->name;
    }
    
    public function getDisplayName() {
        if($this->name) {
            
        }
    }
    
}