<?php

namespace App\Http\Controllers;

use App\Company;
use App\Http\Controllers\Controller;
use App\Image;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Company::all();
        // dd($companies);
        return view('settings.companies', ['companies' => $companies]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // dd($request->created_at, md5($request->created_at));
        // dd($request->file('image'));
        $newCompany = Company::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'api_url' => $request->api_url,
            'address' => $request->address,
            'company_key' => md5(Carbon::now()),
        ]);
        // dd($request->file('image_user'));

        // $company_key =
        // dd($newCompany->created_at, md5($newCompany->created_at), $newCompany->company_key);

        if ($request->file('image')) {
            $path = $request->file('image')->storeAs('company_images', 'company-' . $newCompany->id . '.' . $request->file('image')->guessExtension());
            // dd($path);
            $newCompany->image()->save(
                Image::make(['image_path' => $path])
            );
        }

        $request->session()->flash('status', 'Company was created successfully!');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {
        $currCompany = Company::findorfail($company)->first();
        // dd($currCompany);
        // dd($currUser->username, $validatedEmp);
        if ($currCompany->name != $request->name) {
            $currCompany->name = $request->name;
        }
        if ($currCompany->api_url != $request->api_url) {
            $currCompany->api_url = $request->api_url;
        }
        if ($currCompany->address != $request->address) {
            $currCompany->address = $request->address;
        }
        if ($currCompany->phone != $request->phone) {
            $currCompany->phone = $request->phone;
        }

        // dd($request->file('image_user'));
        if ($request->file('image')) {
            $path = $request->file('image')->storeAs('company_images', 'company-' . $currCompany->id . '.' . $request->file('image')->guessExtension());
            // $request->file('image')->store('avatars');
            // dd($path, $request->file('image'));
            if ($currCompany->image) {
                Storage::delete($currCompany->image->image_path);
                $currCompany->image->image_path = $path;
                $currCompany->image->save();
            } else {
                $currCompany->image()->update(['image_path' => $path]);
            }
        }
        $currCompany->save();
        $request->session()->flash('status', 'Company ' . $currCompany->name . ' was edited successfully!');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $delete_company = Company::findorfail($request->company);
        // dd($request->company);
        // $this->authorize('delete', Auth::user());
        // DB::table('logup')->where('user_logup', '=', $request->user)->delete();
        // DB::table('logout')->where('user_logup', '=', $request->user)->delete();
        $delete_company->delete();

        $request->session()->flash('status', 'Company ' . $delete_company->name . ' was deleted!');

        return redirect()->back();
    }
}
