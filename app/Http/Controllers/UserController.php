<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UserStoreRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Container\Attributes\Storage;
use Illuminate\Http\Request;
use Inertia\Inertia;


class UserController extends Controller
{

    public function index()
    {
        $users = User::with('roles')->paginate(10);

        return Inertia::render('GestionarUsuarios/Usuarios/index', [
            'users' => $users,
        ]);
    }


    public function create()
    {
        $roles = Role::all();

        return Inertia::render('GestionarUsuarios/Usuarios/create', [
            'roles' => $roles,
        ]);
    }


    public function store(UserStoreRequest $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'cedula' => 'required|string|max:255',
            'celular' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|exists:roles,id',
        ]);

        $validated['password'] = bcrypt($validated['password']);
        $user = User::create($validated);

        $user->roles()->attach($validated['role']);

        return redirect()->route('admin.users')->with('success', 'Usuario creado exitosamente.');
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return Inertia::render('GestionarUsuarios/Usuarios/edit', [
            'user' => $user,
            'roles' => $roles,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        // Validar los datos del request
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'cedula' => 'required|string|max:255',
            'celular' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'email' => 'required',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|exists:roles,id',
        ]);

        // Si se proporciona una nueva contraseña, encriptarla
        if (!empty($validatedData['password'])) {
            $validatedData['password'] = bcrypt($validatedData['password']);
        } else {
            unset($validatedData['password']); // Eliminar el campo si no se actualiza
        }

        // Actualizar los datos del usuario
        $user->update($validatedData);

        // Actualizar el rol del usuario en la tabla role_user
        $user->roles()->sync([$validatedData['role']]); // Reemplaza los roles actuales con el nuevo rol

        // Redirigir a la lista de usuarios con un mensaje de éxito
        return redirect()->route('admin.users')->with('success', 'Usuario y rol actualizados exitosamente.');
    }




    public function destroy(User $user)
    {
        // Eliminar el usuario
        $user->delete();

        // Redirigir a la lista de usuarios después de eliminar
        return redirect()->route('admin.users');
    }


}
