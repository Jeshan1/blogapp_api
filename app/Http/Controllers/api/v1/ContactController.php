<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Jobs\SendContactMail;
use App\Models\Contact;
use App\Repositories\ContactRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use function App\Helper\apiResponse;
use function App\Helper\handleException;

class ContactController extends Controller
{
    protected $contactRepository;
    public function __construct(ContactRepository $contactRepository)
    {
        $this->contactRepository = $contactRepository;
        
    }

    public function index(){

        return handleException(function(){
            $contacts = $this->contactRepository->getAllContacts();
            if ($contacts) {
                return apiResponse($contacts,"Contacts fetched successfully",200);
            }
            return apiResponse([],"No any contacts found",400);
        });

    }

    public function delete(int $id){
        return handleException(function() use($id){
            $deleted = $this->contactRepository->deleteContact($id);
            if ($deleted) {
                return apiResponse([],"Contact Deleted Successfully",201);
            }
            return apiResponse([],"Error occured when deleting user",400);
        });
    }

    public function create(Request $request){

        return handleException(function() use($request){
            $data = $request->only(['name', 'email', 'subject', 'message']);
            // Log::info($data);
            SendContactMail::dispatch($data);
            
            if (!empty($data)) {
                $added = Contact::create($data);
                return apiResponse($added,"Contact Submitted Successfully",201);
            }

            return apiResponse([],"Contact information Not filled",404);
            
        });
        
    }
    
}
