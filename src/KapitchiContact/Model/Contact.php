<?php

namespace KapitchiContact\Model;

use KapitchiBase\Stdlib\PluralField,
    ZfcBase\Model\ModelAbstract;

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
    
    public function setPhoneNumbers($phoneNumbers) {
        if(!$phoneNumbers instanceof PluralField) {
            $phoneNumbers = PluralField::fromArray($phoneNumbers);
        }
        
        $this->phoneNumbers = $phoneNumbers;
    }
    
    public function getPhoneNumbers() {
        return $this->phoneNumbers;
    }
    
    public function setEmails($emails) {
        if(!$emails instanceof PluralField) {
            $emails = PluralField::fromArray($emails);
        }
        
        $this->emails = $emails;
    }
    
    public function getEmails() {
        return $this->emails;
    }
    
    public function setAddresses($addresses) {
        if(!$addresses instanceof PluralField) {
            //TODO this is fix until we decide how to handle object pluralfields
            $array = array();
            foreach($addresses as $type => $address) {
                $address['value'] = \KapitchiLocation\Model\Address::fromArray($address['value']);
                $array[$type] = $address;
                
            }
            $addresses = PluralField::fromArray($array);
        }
        
        $this->addresses = $addresses;
    }
    
    public function getAddresses() {
        return $this->addresses;
    }
    
    public function setName($name) {
        if(!$name instanceof Name) {
            $name = Name::fromArray($name);
        }
        
        $this->name = $name;
    }
    
    public function getName() {
        return $this->name;
    }
    
    public function getDisplayName() {
        if($this->name) {
            
        }
    }
    
}