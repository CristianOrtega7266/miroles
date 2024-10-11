@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>{{ __('Dashboard') }}</span>
                    <a href="{{ route('estudiantes') }}" class="btn btn-primary">Lista de Estudiantes</a>
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @auth
                    <h1>Lista de Usuarios</h1>

                    <p>Como <strong>Administrador</strong> puedes <em>Asignar</em> y <em>Eliminar</em> roles de los usuarios.</p>
                    <p>Como <strong>Administrador</strong> puedes <em>Ver</em>, <em>Agregar</em>, <em>Editar</em> y <em>Eliminar</em> a un Estudiante.</p>
                    <p>Como <strong>Director</strong> puedes <em>Ver</em>, <em>Agregar</em> y <em>Editar</em> a un Estudiante.</p>
                    <p>Como <strong>Docente</strong> puedes <em>Ver</em> la lista de Estudiantes.</p>

                    <style>
                        table {
                            width: 100%;
                            border-collapse: collapse;
                            margin-top: 20px;
                        }

                        table, th, td {
                            border: 1px solid #ddd;
                        }

                        th, td {
                            padding: 12px;
                            text-align: left;
                        }

                        th {
                            background-color: #4CAF50;
                            color: white;
                        }

                        tr:nth-child(even) {
                            background-color: #f2f2f2;
                        }

                        tr:hover {
                            background-color: #ddd;
                        }

                        .alert {
                            margin-top: 20px;
                        }

                        .btn {
                            margin-left: 5px; /* Espaciado para los botones */
                        }
                    </style>

                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Roles</th>
                                @if (Auth::user()->hasRole('Administrador'))
                                    <th>Asignar Rol</th>
                                    <th>Eliminar Rol</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @foreach($user->roles as $role)
                                        {{ $role->name }}@if(!$loop->last), @endif
                                    @endforeach
                                </td>
                                @if (Auth::user()->hasRole('Administrador'))
                                    <td>
                                        @if ($user->hasRole('Administrador') && $user->id === Auth::user()->id)
                                            <span>No se puede cambiar rol</span>
                                        @else
                                            <form action="{{ route('assign.role', $user->id) }}" method="POST">
                                                @csrf
                                                <select name="role_id" required>
                                                    <option value="">Seleccionar rol</option>
                                                    @foreach($roles as $role)
                                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                                    @endforeach
                                                </select>
                                                <button type="submit" class="btn btn-success">Asignar Rol</button>
                                            </form>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($user->hasRole('Administrador') && $user->id === Auth::user()->id)
                                            <span>No se puede cambiar rol</span>
                                        @else
                                            <form action="{{ route('remove.role', $user->id) }}" method="POST">
                                                @csrf
                                                <select name="role_id" required>
                                                    <option value="">Seleccionar rol</option>
                                                    @foreach($user->roles as $role)
                                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                                    @endforeach
                                                </select>
                                                <button type="submit" class="btn btn-danger">Eliminar Rol</button>
                                            </form>
                                        @endif
                                    </td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{-- Mensajes de éxito y error --}}
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    @else
                    <div class="alert alert-warning">
                        Debes iniciar sesión para ver la lista de usuarios.
                    </div>
                    @endauth

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
