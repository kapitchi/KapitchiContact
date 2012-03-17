<?php

namespace KapitchiContact\Model\Mapper;

use KapitchiContact\Model\Contact as ContactModel;

interface Contact {
    public function persist(ContactModel $contact);
    public function remove(ContactModel $contact);
    public function findById($id);
}