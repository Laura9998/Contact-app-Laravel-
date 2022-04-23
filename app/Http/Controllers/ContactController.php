<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Contact;
use App\Models\Company;

use Illuminate\Http\Request;
use App\Http\Requests\ContactRequest;

class ContactController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function index() {

        // $user = Auth::user();
        // $companies = $user->companies()->orderBy('name')->pluck('name', 'id')->prepend('All Companies', '');
        $companies = Company::userCompanies();
        // \DB::enableQueryLog();
        $contacts = auth()->user()->contacts()->latestFirst()->paginate(10);

        // dd(\DB::getQueryLog());
        return view('contacts.index', compact('contacts', 'companies'));
    }

    public function create() {
        $contact = new Contact();
        // $companies = auth()->user()->companies()->orderBy('name')->pluck('name', 'id')->prepend('All Companies', '');
        $companies = Company::userCompanies();
        return view('contacts.create', compact('companies','contact'));
    }

    public function store(ContactRequest $request) {
        // $request->validate([
        //     'first_name' => 'required',
        //     'last_name' => 'required',
        //     'email' => 'required|email',
        //     'address' => 'required',
        //     'company_id' => 'required|exists:companies,id',
        // ]);
        $request->user()->contacts()->create($request->all());
        return redirect()->route('contacts.index')->with('message', 'Contact has been added successfully');
    }

    public function edit(Contact $contact) {
        // $contact = Contact::findOrFail($id);
        // $companies = auth()->user()->companies()->orderBy('name')->pluck('name', 'id')->prepend('All Companies', '');
        $companies = Company::userCompanies();
        return view('contacts.edit', compact('companies', 'contact'));
    }

    public function update(Contact $contact, ContactRequest $request) {
        // $request->validate([
        //     'first_name' => 'required',
        //     'last_name' => 'required',
        //     'email' => 'required|email',
        //     'address' => 'required',
        //     'company_id' => 'required|exists:companies,id',
        // ]);

        // $contact = Contact::findOrFail($id);
        $contact->update($request->all());

        return redirect()->route('contacts.index')->with('message', 'Contact has been updated successfully');
    }

    public function show(Contact $contact) {
        // $contact = Contact::findOrFail($id);
        return view('contacts.show', compact('contact'));
    }

    public function destroy(Contact $contact) {
        // $contact = Contact::findOrFail($id);
        $contact->delete();

        return redirect()->route('contacts.index')->with('message', "Contact has been deleted successfully");
    }
}
