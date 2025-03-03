<?php
namespace App\Http\Services;

use App\Exceptions\NoAdminsFoundException;
use App\Exceptions\NoBungalowOfficersFoundException;
use App\Exceptions\NoFacilitatorOfficersFoundException;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function create($validatedData)
    {
        return User::create($validatedData);
    }


    public function login($credentials)
    {
        if (Auth::attempt($credentials)) {
            return Auth::user();
        }

        return null;
    }

    public function getAll()
    {
        return User::all();
    }
    // public function getAdmins()
    // {
    //     try {
    //         $admins = User::role('admin')->get();
    //         return $admins;
    //     } catch (\Exception $e) {
    //         throw new NoAdminsFoundException($e->getMessage());
    //     }
    // }

    // public function getBookingOfficers()
    // {
    //     try {
    //         $bungalowOfficers = User::role('booking_officer')->get();
    //         return $bungalowOfficers;
    //     } catch (\Exception $e) {
    //         throw new NoBungalowOfficersFoundException($e->getMessage());
    //     }
    // }

    // public function getFacilitatorOfficers()
    // {
    //     try {
    //         $facilitatorOfficers = User::role('facilitator_officer')->get();
    //         return $facilitatorOfficers;
    //     } catch (\Exception $e) {
    //         throw new NoFacilitatorOfficersFoundException($e->getMessage());
    //     }
    // }

    // public function storeUser($validatedData)
    // {
    //     if ($validatedData['role'] == 'facilitator') {
    //         $defaultPassword = config('app.default_facilitator_password', '@facRTB123');
    //     } else {
    //         $defaultPassword = config('app.default_user_password', '@rtb123');
    //     }
    //     $validatedData['password'] = Hash::make($defaultPassword);

    //     return User::create($validatedData);
    // }


    // public function getFilteredUsers(array $filters)
    // {
    //     $query = User::query();

    //     if (isset($filters['name']) && $filters['name']) {
    //         $query->where('name', 'like', '%' . $filters['name'] . '%');
    //     }

    //     if (isset($filters['role']) && $filters['role']) {
    //         $query->whereHas('roles', function ($query) use ($filters) {
    //             $query->where('name', $filters['role']);
    //         });
    //     }

    //     return $query->paginate(10)->appends(request()->query());
    // }

    // public function getUser($id)
    // {
    //     return User::findOrFail($id);
    // }

    // public function getUserByEmail($email)
    // {
    //     return User::where('email', $email)->first();
    // }

    // public function updateUser(array $validatedData, $userId)
    // {
    //     $user = User::findOrFail($userId);
    //     $user->update($validatedData);
    //     return $user;
    // }

    // public function resetPassword(string $defaultPassword, int $userId)
    // {
    //     $user = User::findOrFail($userId);
    //     $user->update(['password' => Hash::make($defaultPassword)]);

    //     return $user;
    // }

    // public function updateProfile($password)
    // {
    //     $user = Auth::user();

    //     if (isset($password['password'])) {
    //         $password['password'] = bcrypt($password['password']);
    //     }

    //     $user->update($password);

    //     return $user;
    // }

    // public function getLatestUserName($roleCode, $currentYear)
    // {
    //     return User::where('username', 'like', "RTB{$roleCode}{$currentYear}%")
    //         ->latest('id')
    //         ->first();
    // }
}
