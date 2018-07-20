<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company;

use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{
    public function mycompany()
    {
        $user = auth()->user('id');
        $mycompany = $user->company()->first(); //For now a user can only be linked to one company (one-to-many)

        return view('company.mycompany',compact('user','mycompany'));
    }

    public function index()
    {
        $user = auth()->user('id');
        $mycompany = $user->company()->first(); //For now a user can only be linked to one company (one-to-many)
        // If no mycompany->id, give it a value of 0 so that $companies does not break
        if( empty($mycompany) || empty($mycompany->id) ) $mycompany->id = 0;
        $companies = Company::where('id','!=',$mycompany->id)->get();

        return view('company.index',compact('user','companies'));
    }

    public function create()
    {
	    $user = auth()->user();
	    return view('company.add')->with('user',$user);
    }

    public function store(Request $request)
    {
        $user_id = auth()->user()->id;
        // Validation
        $request->validate([
            'abn' => 'required|min:10|max:10',
        ]);

        $company_details = Company::create([
            "abn" => $request->abn,
            "name" => $request->name,
            "address" => $request->address,
            "phone" => $request->phone,
            "email" => $request->email,
            "contact_person" => $request->contact_person,
        ]);

        // Roles should be added manually or through a superadmin interface. You can't register your own company, the companies you register are customers, suppliers, etc.
        //$company_role = DB::insert("INSERT INTO company_roles (user_id,company_id,role_id) VALUES ({$user_id},{$company_details->id},1)");

        return redirect()->action('CompanyController@index');
    }
    public function edit($id)
    {
        $company = Company::find($id);
        return view('company.edit', compact('user','company'));
    }
    public function update($id, Request $request) {
        // Validation
        $request->validate([
            'abn' => 'required|min:10|max:10',
        ]);
        $company = Company::find($id);

        $company->abn = $request->abn;
        $company->name = $request->name;
        $company->address = $request->address;
        $company->phone = $request->phone;
        $company->email = $request->email;
        $company->contact_person = $request->contact_person;        
        $company->save();

        return redirect('home');
    }

    public function balance($id,$account)
    {
        $user = auth()->user();
        $mycompany = $user->company()->first(); //For now a user can only be linked to one company (one-to-many)

        if( $id == $mycompany->id ) return view('pl.index');

        $company = Company::find($id);
        if( $account == 'dr' ) {
            $company->account = 'dr';
            $dr = $company->salesinvoice->merge($company->collections);
            if( !empty($dr) ) return view('accounting.balance',compact('company','dr'));
        } else if( $account == 'cr' ) {
            $company->account = 'cr';
            $cr = $company->purchaseinvoice->merge($company->payments);
            if( !empty($cr) ) return view('accounting.balance',compact('company','cr'));
        }
    }
    public function collection_balances()
    {
        $user = auth()->user();
        $mycompany = $user->company()->first(); //For now a user can only be linked to one company (one-to-many)

        $dr = Company::where('id','!=',$mycompany->id)->get();
        foreach( $dr as &$d ) {
            $d->balance = $d->salesinvoice->sum('amount') - $d->collections->sum('amount');
        }
        return view('accounting.sbalance',compact('dr'));
    }
    public function payment_balances()
    {
        $user = auth()->user();
        $mycompany = $user->company()->first(); //For now a user can only be linked to one company (one-to-many)

        $dr = Company::where('id','!=',$mycompany->id)->get();
        foreach( $dr as &$d ) {
            $d->balance = $d->purchaseinvoice->sum('amount') - $d->payments->sum('amount');
        }
        return view('accounting.pbalance',compact('dr'));
    }
}