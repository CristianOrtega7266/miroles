<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    // Muestra la lista de usuarios
    public function index()
    {
        $users = User::with('roles')->get();
        $roles = Role::all(); // Obtener todos los roles

        return view('home', compact('users', 'roles'));
    }


    public function showUsuarios()
    {

        $users = User::with('roles')->get();
        $roles = Role::all(); // Obtener todos los roles

        return view('home', compact('users', 'roles'));
       

    }

    public function showEstudiantes()
    {

        
        $estudiantes = Estudiante::all(); // Obtener todos los roles

        return view('estudiantes', compact('estudiantes'));
       

    }


    // Asigna un rol a un usuario
    public function assignRole(Request $request, $id)
    {
        // Validar la solicitud
        $request->validate([
            'role_id' => 'required|exists:roles,id', // Asegurarse de que el role_id es válido
        ]);

        // Verificar si el usuario autenticado tiene el rol de Administrador
        if (!Auth::user()->hasRole('Administrador')) {
            return redirect()->back()->with('error', 'No tienes permisos para asignar roles.');
        }

        $userToAssign = User::findOrFail($id);
        $role = Role::findOrFail($request->role_id);

        // Comprobar si el usuario ya tiene este rol
        if ($userToAssign->hasRole($role->name)) {
            return redirect()->back()->with('error', 'El usuario ya tiene este rol.');
        }

        // Asignar el rol al usuario
        $userToAssign->assignRole($role);

        return redirect()->back()->with('success', 'Rol asignado correctamente.');
    }

    // Elimina un rol de un usuario
    public function removeRole(Request $request, $id)
    {
        // Validar la solicitud
        $request->validate([
            'role_id' => 'required|exists:roles,id', // Asegurarse de que el role_id es válido
        ]);

        // Verificar si el usuario autenticado tiene el rol de Administrador
        if (!Auth::user()->hasRole('Administrador')) {
            return redirect()->back()->with('error', 'No tienes permisos para eliminar roles.');
        }

        $userToRemoveRole = User::findOrFail($id);
        $role = Role::findOrFail($request->role_id);

        // Comprobar si el usuario no tiene este rol
        if (!$userToRemoveRole->hasRole($role->name)) {
            return redirect()->back()->with('error', 'El usuario no tiene este rol.');
        }

        // Eliminar el rol del usuario
        $userToRemoveRole->removeRole($role);

        return redirect()->back()->with('success', 'Rol eliminado correctamente.');
    }
}
