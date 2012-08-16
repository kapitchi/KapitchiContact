<?php
namespace KapitchiContact\ContactType;

/**
 * 
 * @author Matus Zeman <mz@kapitchi.com>
 */
interface ContactTypeInterface
{
    public function getName();
    public function findByContactId($contactId);
    public function getForm($formType = null);
    public function createArrayFromType($type);
    public function createTypeFromArray(array $data);
}