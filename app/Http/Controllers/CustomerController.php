<?php

namespace App\Http\Controllers;
use App\Models\Customer;

use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function createCustomer(Request $request)
    {
        $user = $request->header('userId');
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'mobile' => 'required|string|max:15',
        ]);

        Customer::create([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'user_id' => $user
        ]);
        return response()->json([
            'status' => 'success',
            'message' => 'Customer created successfully'
        ]);
    } //end method

    public function listCustomer(Request $request)
    {
        $user = $request->header('userId');
        $customers = Customer::where('user_id', $user)->get();
        return $customers;
    } //end method
    public function customerById(Request $request)
    {
        $user = $request->header('userId');
        $customer = Customer::where('user_id', $user)->where('id', $request->id)->first();
        return $customer;
    } //end method

    public function customerUpdate(Request $request)
    {
        $user = $request->header('userId');
        $id = $request->input('id');

        Customer::where('user_id', $user)->where('id', $id)->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'mobile' => $request->input('mobile')
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Customer updated successfully'
        ]);
    } //end method
    public function deleteCustomer(Request $request, $id)
    {
        $user = $request->header('userId');

        Customer::where('user_id', $user)->where('id', $id)->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Customer deleted successfully'
        ]);
    } //end method
}
