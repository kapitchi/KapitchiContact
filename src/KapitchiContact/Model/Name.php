<?php

namespace KapitchiContact\Model;

use KapitchiBase\Model\ModelAbstract;
/**
 * Let's try to be as much compatible with OpenSocial as possible.
 * http://opensocial-resources.googlecode.com/svn/spec/2.0.1/Social-Data.xml#Name
 */
class Name extends ModelAbstract {
    protected $formatted;
    protected $givenName;
    protected $middleName;
    protected $familyName;
    protected $honorificPrefix;
    protected $honorificSuffix;
    
    public function generateFormatted() {
        $name = sprintf("%s, %s %s",
                $this->getHonorificPrefix(),
                $this->getGivenName(),
                $this->getFamilyName()
                );
        
        return $name;
    }
    
    public function getFormatted() {
        if(empty($this->formatted)) {
            $this->formatted = $this->generateFormatted();
        }
        return $this->formatted;
    }

    public function setFormatted($formatted) {
        $this->formatted = $formatted;
    }

    public function getGivenName() {
        return $this->givenName;
    }

    public function setGivenName($givenName) {
        $this->givenName = $givenName;
    }

    public function getMiddleName() {
        return $this->middleName;
    }

    public function setMiddleName($middleName) {
        $this->middleName = $middleName;
    }

    public function getFamilyName() {
        return $this->familyName;
    }

    public function setFamilyName($familyName) {
        $this->familyName = $familyName;
    }

    public function getHonorificPrefix() {
        return $this->honorificPrefix;
    }

    public function setHonorificPrefix($honorificPrefix) {
        $this->honorificPrefix = $honorificPrefix;
    }

    public function getHonorificSuffix() {
        return $this->honorificSuffix;
    }

    public function setHonorificSuffix($honorificSuffix) {
        $this->honorificSuffix = $honorificSuffix;
    }


}