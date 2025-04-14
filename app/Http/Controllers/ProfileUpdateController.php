<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileUpdateController extends Controller
{
    public function showUpdateForm()
    {
        $user = Auth::user();
        $bloodTypes = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
        return view('donor_update_profile', compact('user', 'bloodTypes'));
    }

    public function showUpdateForm1()
    {
        $user = Auth::user();
        $bloodTypes = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
        return view('receiver_update_profile', compact('user', 'bloodTypes'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => ['required', 'regex:/^[A-Za-z]+[A-Za-z0-9]*$/', 'max:25'],
            'age' => ['required', 'integer', 'min:16', 'max:65'],
            'weight' => ['required', 'numeric', 'min:45', 'max:160'],
            'address' => ['required', 'regex:/^[A-Za-z0-9\s,\'.-]+$/', 'regex:/[A-Za-z]/', 'max:30'],
            'phone' => ['required', 'digits:10'],
            'blood_type' => ['required', 'string', 'in:A+,A-,B+,B-,AB+,AB-,O+,O-'],
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($user->id),
            ],
            'current_password' => ['required', 'string', function ($attribute, $value, $fail) use ($user) {
                if (!Hash::check($value, $user->password)) {
                    $fail('The current password is incorrect.');
                }
            }],
            'new_password' => ['nullable', 'string', 'min:6', 'confirmed'],
        ], [
            'name.regex' => 'Name must start with letters and may end with numbers.',
            'age.min' => 'Age must be between 16 and 65.',
            'weight.min' => 'Weight must be at least 45 kg and maximum 160 kg.',
            'address.regex' => 'Address must contain alphabets and can include numbers, spaces, commas, apostrophes, and hyphens.',
            'phone.digits' => 'Phone number must be exactly 10 digits.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already taken.',
            'blood_type.in' => 'Please select a valid blood type.',
        ]);

        $updateData = [
            'name' => $request->name,
            'age' => $request->age,
            'weight' => $request->weight,
            'address' => $request->address,
            'phone' => $request->phone,
            'blood_type' => $request->blood_type,
            'email' => $request->email,
        ];

        if ($request->filled('new_password')) {
            $updateData['password'] = Hash::make($request->new_password);
        }

        $user->update($updateData);

        return back()->with('success', 'Profile updated successfully!');
    }
}
