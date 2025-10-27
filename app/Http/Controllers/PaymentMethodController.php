<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaymentMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.payment.payment',[
            'payments' => PaymentMethod::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'payment_method_type' => 'required|in:bank,mobile_banking',
            'name' => 'required|string|max:100',
            'account_number' => 'required|numeric',
        ];

        // If bank type, require extra fields
        if ($request->payment_method_type === 'bank') {
            $rules['account_name'] = 'required|string|max:100';
            $rules['branch_name'] = 'required|string|max:100';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        PaymentMethod::create([
            'payment_method_type' => $request->payment_method_type,
            'name' => $request->name,
            'account_number' => $request->account_number,
            'account_name' => $request->account_name,
            'branch_name' => $request->branch_name,
        ]);

        return response()->json(['message' => 'Payment method added successfully!']);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $method = PaymentMethod::findOrFail($id);

        $rules = [
            'payment_method_type' => 'required|in:bank,mobile_banking',
            'name' => 'required|string|max:100',
            'account_number' => 'required|numeric|unique:payment_methods,account_number,' . $method->id,
        ];

        if ($request->payment_method_type === 'bank') {
            $rules['account_name'] = 'required|string|max:100';
            $rules['branch_name'] = 'required|string|max:100';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $method->update([
            'payment_method_type' => $request->payment_method_type,
            'name' => $request->name,
            'account_number' => $request->account_number,
            'account_name' => $request->account_name,
            'branch_name' => $request->branch_name,
        ]);

        return response()->json(['message' => 'Payment method updated successfully!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $method = PaymentMethod::findOrFail($id);
        $method->delete();

        return back()->with('success', 'Payment method Deleted successfully !');
    }
}
