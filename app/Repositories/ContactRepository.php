<?php
namespace App\Repositories;

use App\Models\Contact;

class ContactRepository implements ContactRepositoryInterface{

    public function getAllContacts()
    {
        $contacts = Contact::orderBy('created_at','desc')->paginate(10);
        return $contacts;
        
    }

    public function deleteContact(int $id)
    {
        $deleted = Contact::findOrFail($id)->delete();
        if ($deleted) {
            return true;
        }
        return false;
        
    }
}