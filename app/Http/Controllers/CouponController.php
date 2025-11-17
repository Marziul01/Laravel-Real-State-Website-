<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(auth()->user()->adminAccess->coupons == 2){
            return redirect(route('admin.dashboard'))->with('error', 'Access Denied! You do not have permission to access this page.');
        }
        return view('admin.coupon.coupon',[
            'coupons' => Coupon::all(),
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
        if(auth()->user()->adminAccess->coupons != 3){
            return redirect(route('admin.dashboard'))->with('error', 'Access Denied! You do not have permission to access this page.');
        }
        $validator = Validator::make($request->all(), [
            'code' => 'required|unique:coupons,code|max:50',
            'discount_type' => 'required|in:percent,amount',
            'discount' => 'required|integer|min:1',
            'start_date' => 'required|date',
            'expire_date' => 'nullable|date|after_or_equal:start_date',
            'max_uses' => 'nullable|integer|min:1',
            'max_user_uses' => 'nullable|integer|min:1',
        ]);

        // ✅ Extra conditional check for percentage discount
        $validator->after(function ($validator) use ($request) {
            if ($request->discount_type === 'percent' && $request->discount > 100) {
                $validator->errors()->add('discount', 'Percentage discount cannot be greater than 100.');
            }
        });

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        Coupon::create([
            'code' => $request->code,
            'discount_type' => $request->discount_type,
            'discount' => $request->discount,
            'start_date' => $request->start_date,
            'expire_date' => $request->expire_date,
            'max_uses' => $request->max_uses,
            'max_user_uses' => $request->max_user_uses,
        ]);

        return response()->json(['message' => 'Coupon created successfully!']);
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
        if(auth()->user()->adminAccess->coupons != 3){
            return redirect(route('admin.dashboard'))->with('error', 'Access Denied! You do not have permission to access this page.');
        }
         $coupon = Coupon::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'code' => 'required|max:50|unique:coupons,code,' . $coupon->id,
            'discount_type' => 'required|in:percent,amount',
            'discount' => 'required|integer|min:1',
            'start_date' => 'required|date',
            'expire_date' => 'nullable|date|after_or_equal:start_date',
            'max_uses' => 'nullable|integer|min:1',
            'max_user_uses' => 'nullable|integer|min:1',
        ]);

        // ✅ Extra conditional check for percentage discount
        $validator->after(function ($validator) use ($request) {
            if ($request->discount_type === 'percent' && $request->discount > 100) {
                $validator->errors()->add('discount', 'Percentage discount cannot be greater than 100.');
            }
        });

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $coupon->update([
            'code' => $request->code,
            'discount_type' => $request->discount_type,
            'discount' => $request->discount,
            'start_date' => $request->start_date,
            'expire_date' => $request->expire_date,
            'max_uses' => $request->max_uses,
            'max_user_uses' => $request->max_user_uses,
        ]);

        return response()->json(['message' => 'Coupon updated successfully!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(auth()->user()->adminAccess->coupons != 3){
            return redirect(route('admin.dashboard'))->with('error', 'Access Denied! You do not have permission to access this page.');
        }
        $coupon = Coupon::findOrFail($id); 

        $coupon->delete();
        return back()->with('success', 'Coupon Deleted successfully !');

    }
}
