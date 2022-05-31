@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h1>Add new user</h1>
        <div class="lead">
            Add new user and assign role.
        </div>

        <div class="container mt-4">
            <form method="POST" action="">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">PIC Name</label>
                    <input value="{{ old('name') }}" 
                        type="text" 
                        class="form-control" 
                        name="name" 
                        placeholder="Name" required>

                    @if ($errors->has('name'))
                        <span class="text-danger text-left">{{ $errors->first('name') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input value="{{ old('email') }}"
                        type="email" 
                        class="form-control" 
                        name="email" 
                        placeholder="Email address" required>
                    @if ($errors->has('email'))
                        <span class="text-danger text-left">{{ $errors->first('email') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input value="{{ old('username') }}"
                        type="text" 
                        class="form-control" 
                        name="username" 
                        placeholder="Username" required>
                    @if ($errors->has('username'))
                        <span class="text-danger text-left">{{ $errors->first('username') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input value="{{ old('password') }}"
                        type="password" 
                        class="form-control" 
                        name="password" 
                        placeholder="Password" required>
                    @if ($errors->has('password'))
                        <span class="text-danger text-left">{{ $errors->first('password') }}</span>
                    @endif
                </div>

                <div class="mb-3">
                    <label for="dept_id" class="form-label">Department</label>
                    <select class="form-control" id="dept_id" name="dept_id" required="required" >
                        <option value="" selected="selected"> -- Select -- </option>
                        @foreach ($departments as $dept)
                            <option value="{{ $dept->id }}" >{{ $dept->name}}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('dept_id'))
                        <span class="text-danger text-left">{{ $errors->first('dept_id') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Npk</label>
                    <input value="{{ old('npk') }}"
                        type="text" 
                        class="form-control" 
                        name="npk" 
                        placeholder="npk " required>
                    @if ($errors->has('npk'))
                        <span class="text-danger text-left">{{ $errors->first('npk') }}</span>
                    @endif
                </div>

                <button type="submit" class="btn btn-primary">Save User</button>
                <a href="{{ route('users.index') }}" class="btn btn-default">Back</a>
            </form>
        </div>

    </div>
@endsection
