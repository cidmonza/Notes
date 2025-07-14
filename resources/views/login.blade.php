@extends('layouts.main-layout')
@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-sm-8">
                <div class="card p-5">

                    <!-- logo -->
                    <div class="text-center p-3">
                        <img src="assets/images/logo.png" alt="Notes logo">
                    </div>

                    <!-- form -->
                    <div class="row justify-content-center">
                        <div class="col-md-10 col-12">
                            {{-- novalidade faz com que não há validações por parte do HTML 5 --}}
                            <form action="/loginSubmit" method="post" novalidate>
                                @csrf
                                <div class="mb-3">
                                    <label for="text-username" class="form-label">Username</label>
                                    <input type="email" class="form-control bg-dark text-info" name="text-username" value="{{old('text-username')}}" required>
                                    {{-- Show Error --}}
                                    @error('text-username')
                                        <div class="alert-danger">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="text-password" class="form-label">Password</label>
                                    <input type="password" class="form-control bg-dark text-info" name="text-password" value="{{old('text-password')}}" required>
                                    {{-- Show Error --}}
                                    @error('text-password')
                                        <div class="alert-danger">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-secondary w-100">LOGIN</button>
                                </div>
                            </form>

                            <!-- invalid login -->

                            @if(session('loginError'))
                                <div class="aler alert-danger text-center">
                                    {{session('loginError')}}
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- copy -->
                    <div class="text-center text-secondary mt-3">
                        <small>&copy; <?= date('Y') ?> Notes</small>
                    </div>

                </div>
            </div>
        </div>
</div @endsection
