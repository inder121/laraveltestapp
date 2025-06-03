<?php

namespace App\Http\Controllers\Auth;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use Illuminate\Support\Facades\File;
use SimpleXMLElement;
use Illuminate\Support\Facades\DB;
class ContactController extends Controller
{
    /**
     * Display contacts.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $contacts = Contact::orderBy('id')->paginate(25);
        return view('contacts.index', compact('contacts'));
    }
    /**
     * add a new contact.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('contacts.create');
    }
    
    /**
     * update contact.
     *
     * @param  ContactRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ContactRequest $request)
    {

        Contact::create($request->all());

        return redirect()->route('contacts.index')->with('success', trans('messages.contact_created'));
    }
    /**
     * show contact.
     *
     * @return \Illuminate\Contracts\View\View
     */

    public function show(Contact $contact)
    {
        return view('contacts.show', compact('contact'));
    }
    /**
     * edit contact.
     *
     * @return \Illuminate\Contracts\View\View
     */

    public function edit(Contact $contact)
    {
        return view('contacts.edit', compact('contact'));
    }

    /**
     * update contact.
     *
     * @param  ContactRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */

    public function update(ContactRequest $request, Contact $contact)
    {
        $contact->update($request->all());

        return redirect()->route('contacts.index')->with('success', trans('messages.contact_updated'));
    }
    /**
     * delete contact.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();
        return redirect()->route('contacts.index')->with('success', trans('messages.contact_deleted'));
    }
        /**
     * upload contacts using xml format file.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function uploadxml()
    {
        return view('contacts.uploadxml');
    }
    /**
     * update contact.
     *
     * @param  ContactRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function import(Request $request)
    {

        $request->validate([
            'xmlfile' => [
                'bail',
                'required',
                'max:2048',
                function ($attribute, $value, $fail) {
                    if ($value->getClientMimeType() !== 'text/xml') {
                        $fail($attribute.'\'s extension is invalid.');
                    }
                },
            ]
        ]);
        $fileName = $request->xmlfile->getClientoriginalName();
        $request->xmlfile->move(public_path('uploads'), $fileName);
        $filePath = public_path('uploads').'/'.$fileName;
        if (File::exists($filePath)) {
            $xmlString = File::get($filePath);
            $xmldata = new SimpleXMLElement($xmlString);
            $data = [];
            $count =0;
            foreach ($xmldata as $xml) {
              $data[$count]['name'] = (string)$xml->name;
              $data[$count]['phone'] = (string)$xml->phone;
              $count++;  
            }
            DB::beginTransaction();
            try {
                Contact::upsert($data, 'phone', ['name','created_at', 'updated_at']);
                DB::commit();
            } catch (\Throwable $th) {
                DB::rollback();
                return back()->with('success', trans($th->getMessage()))->with('xmlfile', $fileName);
            }
        }
        return redirect()->route('contacts.index')->with('success', trans('messages.file_uploaded'));
    }

}
