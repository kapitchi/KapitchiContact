<?php
namespace KapitchiContact\ContactType;

/**
 * 
 * @author Matus Zeman <mz@kapitchi.com>
 */
interface ContactTypeInterface
{
    public function findByContactId($contactId);
    public function getForm($formType);
}