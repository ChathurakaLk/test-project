<?php
namespace App\Http\Handlers;

use App\Http\Services\UserService;
use App\Models\User;
use App\Services\MailService;
use App\Services\RoleService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Str;
use Symfony\Component\Mailer\Exception\TransportException;

class UserHandler
{
    public function __construct(
        // private RoleService $roleService,
        private UserService $userService,
        // private MailService $mailService,
    ) {
        //
    }

    public function HandleLoginUser($credentials)
    {
        return $this->userService->login($credentials);
    }

    public function HandleGetAllUsers()
    {
        try {
            return $this->userService->getAll();
        } catch (QueryException $e) {
            Log::error('Database error when registered users.', [
                'error' => $e->getMessage(),
                'sql' => $e->getSql(),
                'bindings' => $e->getBindings(),
            ]);
            throw $e;
        } catch (Exception $e) {
            Log::error('General error when registered users.', [
                'error' => $e->getMessage(),
            ]);
            throw $e;
        }
    }
    
    public function HandleRegisterUser(array $validatedData)
    {
        try {
            $user = $this->userService->create($validatedData);
            $user->assignRole('teacher');
            return $user;

        } catch (QueryException $e) {
            Log::error('Database error when registered users.', [
                'error' => $e->getMessage(),
                'sql' => $e->getSql(),
                'bindings' => $e->getBindings(),
            ]);
            throw $e;
        } catch (Exception $e) {
            Log::error('General error when registered users.', [
                'error' => $e->getMessage(),
            ]);
            throw $e;
        }
    }

    // public function handleGetUser($id)
    // {
    //     try {
    //         return $this->userService->getUser($id);
    //     } catch (QueryException $e) {
    //         Log::error('Database error when getting user.', [
    //             'error' => $e->getMessage(),
    //             'sql' => $e->getSql(),
    //             'bindings' => $e->getBindings(),
    //         ]);
    //         throw $e;
    //     } catch (ModelNotFoundException $e) {
    //         Log::error('Model not found when getting user.', [
    //             'error' => $e->getMessage(),
    //         ]);
    //         throw $e;
    //     } catch (Exception $e) {
    //         Log::error('General error when getting user.', [
    //             'error' => $e->getMessage(),
    //         ]);
    //         throw $e;
    //     }
    // }
    // public function handleGetAllRoles()
    // {
    //     try {
    //         return $this->roleService->getRoles();
    //     } catch (QueryException $e) {
    //         Log::error('Database error when getting roles.', [
    //             'error' => $e->getMessage(),
    //             'sql' => $e->getSql(),
    //             'bindings' => $e->getBindings(),
    //         ]);
    //         throw $e;
    //     } catch (Exception $e) {
    //         Log::error('General error when getting roles.', [
    //             'error' => $e->getMessage(),
    //         ]);
    //         throw $e;
    //     }
    // }

    // public function handleStoreUser($validatedData, $type = false)
    // {
    //     try {
    //         if($validatedData['role'] == 'facilitator') {
    //             $username = 'fac_' . str_pad($validatedData['id'], 4, '0', STR_PAD_LEFT);
    //         } else {
    //             $username = Str::snake($validatedData['name']);
    //         }
    //         $validatedData['username'] = $username;
    //         $user = $this->userService->storeUser($validatedData);
    //         $user->assignRole($validatedData['role']);

    //         if ($type == 'import') {
    //             if ($validatedData['email'] != null) {
    //                 $this->mailService->sendLoginCredintialsToOldFacilitator(
    //                     $validatedData['email'],
    //                     $validatedData['username'],
    //                     config('app.default_facilitator_password'),
    //                     $validatedData['name'],
    //                     $validatedData['reg_no'],
    //                 );
    //             }

    //             if ($validatedData['phone'] != null) {
    //                 $this->smsHandler->sendLoginCredintialsToOldFacilitator(
    //                     [$validatedData['phone']],
    //                     $validatedData['username'],
    //                     config('app.default_facilitator_password')
    //                 );
    //             }
    //             return $user;

    //         } elseif ($validatedData['role'] == 'facilitator') {
    //             $this->mailService->sendApprovedMessageToFacilitator(
    //                 $validatedData['email'],
    //                 $validatedData['username'],
    //                 config('app.default_facilitator_password'),
    //                 $validatedData['name'],
    //                 $validatedData['reg_no'],
    //             );

    //             if ($validatedData['phone'] != null) {
    //                 $this->smsHandler->sendLoginCredintialsToOldFacilitator(
    //                     [$validatedData['phone']],
    //                     $validatedData['username'],
    //                     config('app.default_facilitator_password')
    //                 );
    //             }
    //             return $user;

    //         } else {
    //             $this->mailService->sendCredentialsToUser(
    //                 $validatedData['email'],
    //                 $validatedData['username'],
    //                 config('app.default_user_password'),
    //                 $validatedData['name']
    //             );
    //         }
    //     } catch (TransportException $e) {
    //         Log::error('Mail transport failed.', [
    //             'error' => $e->getMessage(),
    //         ]);
    //         throw $e;

    //     } catch (QueryException $e) {
    //         Log::error('Database error when storing user.', [
    //             'error' => $e->getMessage(),
    //             'sql' => $e->getSql(),
    //             'bindings' => $e->getBindings(),
    //         ]);
    //         throw $e;
    //     } catch (Exception $e) {
    //         Log::error('General error when storing user.', [
    //             'error' => $e->getMessage(),
    //         ]);
    //         throw $e;
    //     }
    // }

    // public function handleUpdateUser($validatedData, int $userId)
    // {
    //     try {
    //         $user = $this->userService->updateUser($validatedData, $userId);
    //         $user->syncRoles($validatedData['role']);

    //     } catch (QueryException $e) {
    //         Log::error('Database error when updating user.', [
    //             'error' => $e->getMessage(),
    //             'sql' => $e->getSql(),
    //             'bindings' => $e->getBindings(),
    //         ]);
    //         throw $e;
    //     } catch (Exception $e) {
    //         Log::error('General error when updating user.', [
    //             'error' => $e->getMessage(),
    //         ]);
    //         throw $e;
    //     }
    // }

    // public function handleResetPassword(string $defaultPassword, int $userId)
    // {
    //     try {
    //         $this->userService->resetPassword($defaultPassword, $userId);
    //         $this->mailService->sendPasswordResetNotification($userId, $defaultPassword);
    //     } catch (TransportException $e) {
    //         Log::error('Mail transport failed.', [
    //             'error' => $e->getMessage(),
    //         ]);
    //         throw $e;

    //     } catch (QueryException $e) {
    //         Log::error('Database error when updating password.', [
    //             'error' => $e->getMessage(),
    //             'sql' => $e->getSql(),
    //             'bindings' => $e->getBindings(),
    //         ]);
    //         throw $e;
    //     } catch (Exception $e) {
    //         Log::error('General error when changing password.', [
    //             'error' => $e->getMessage(),
    //         ]);
    //         throw $e;
    //     }
    // }

    // public function handleUpdateProfile($password)
    // {
    //     try {
    //         $this->userService->updateProfile($password);
    //     } catch (QueryException $e) {
    //         Log::error('Database error when updating profile.', [
    //             'error' => $e->getMessage(),
    //             'sql' => $e->getSql(),
    //             'bindings' => $e->getBindings(),
    //         ]);
    //         throw $e;
    //     } catch (Exception $e) {
    //         Log::error('General error when updating user profile.', [
    //             'error' => $e->getMessage(),
    //         ]);
    //         throw $e;
    //     }
    // }

    // public function handleCheckEmailExist($email)
    // {
    //     try {
    //         return $this->userService->getUserByEmail($email);
    //     } catch (QueryException $e) {
    //         Log::error('Database error when checking email.', [
    //             'error' => $e->getMessage(),
    //             'sql' => $e->getSql(),
    //             'bindings' => $e->getBindings(),
    //         ]);
    //         throw $e;
    //     }
    // }
}
