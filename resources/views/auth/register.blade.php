<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Register &mdash; Stisla</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fontawesome/css/all.min.css') }}">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('assets/bootstrap-social/bootstrap-social.css') }}">

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">
    <!-- Start GA -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-94034622-3');

    </script>
    <!-- /END GA -->
</head>

<body>
    <div id="app">
        <section class="section">
            <div class="container mt-2">
                <div class="row">
                    <div class="col-lg-4"></div>
                    <div class="col-lg-5">
                        <div class="login-brand">
                            <img src="assets/img/stisla-fill.svg" alt="logo" width="100"
                                class="shadow-light rounded-circle shadow">
                        </div>

                        <div class="card shadow" style="border-radius: 12px">
                            <div class="card-header">
                                <h4>Register</h4>
                            </div>

                            <div class="card-body">
                                <form method="POST" action="{{ route('register') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input id="name" type="text" class="form-control" name="name">
                                        <div class="invalid-feedback">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input id="email" type="email" class="form-control" name="email">
                                        <div class="invalid-feedback">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label for="password" class="d-block">Password</label>
                                            <input id="password" type="password" class="form-control pwstrength"
                                                data-indicator="pwindicator" name="password">
                                            <div id="pwindicator" class="pwindicator">
                                                <div class="bar"></div>
                                                <div class="label"></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-6">
                                            <label for="password2" class="d-block">Password Confirmation</label>
                                            <input id="password2" type="password" class="form-control"
                                                name="password_confirmation">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="role_user">Role User</label>
                                        <select name="role_id" id="role_user" class="form-control">
                                            <option value="admin">Admin</option>
                                            <option value="user">User</option>
                                            <option value="developer">Developer</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-lg btn-block">
                                            Register
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="simple-footer">
                            <div class="text-muted text-center">
                                Have an account? <a href="{{ url('/') }}">Sign In</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4"></div>
                </div>
            </div>
        </section>
    </div>

    <!-- General JS Scripts -->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/popper.js') }}"></script>
    <script src="{{ asset('assets/js/tooltip.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/nicescroll/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('assets/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/stisla.js') }}"></script>

    <!-- JS Libraies -->

    <!-- Page Specific JS File -->

    <!-- Template JS File -->
    <script src="{{ asset('assets/js/scripts.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>
</body>

</html>

{{-- <x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="tw-w-20 tw-h-20 tw-fill-current tw-text-gray-500" />
            </a>
        </x-slot>

        <form method="POST" action="{{ route('register') }}">
@csrf

<!-- Name -->
<div>
    <x-input-label for="name" :value="__('Name')" />
    <x-text-input id="name" class="tw-block tw-mt-1 tw-w-full" type="text" name="name" :value="old('name')" required
        autofocus />
    <x-input-error :messages="$errors->get('name')" class="tw-mt-2" />
</div>

<!-- Email Address -->
<div class="tw-mt-4">
    <x-input-label for="email" :value="__('Email')" />
    <x-text-input id="email" class="tw-block tw-mt-1 tw-w-full" type="email" name="email" :value="old('email')"
        required />
    <x-input-error :messages="$errors->get('email')" class="tw-mt-2" />
</div>

<!-- Password -->
<div class="tw-mt-4">
    <x-input-label for="password" :value="__('Password')" />

    <x-text-input id="password" class="tw-block tw-mt-1 tw-w-full" type="password" name="password" required
        autocomplete="new-password" />

    <x-input-error :messages="$errors->get('password')" class="tw-mt-2" />
</div>

<!-- Confirm Password -->
<div class="tw-mt-4">
    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

    <x-text-input id="password_confirmation" class="tw-block tw-mt-1 tw-w-full" type="password"
        name="password_confirmation" required />

    <x-input-error :messages="$errors->get('password_confirmation')" class="tw-mt-2" />
</div>

<div class="tw-mt-4">
    <label class="tw-block tw-mb-2 tw-text-sm tw-font-medium tw-text-gray-900 dark:tw-text-gray-300">Role
        user</label>
    <select
        class="tw-block tw-mt-1 tw-w-full tw-border-gray-300 focus:tw-border-indigo-300 focus:tw-ring-indigo-200 focus:tw-ring-opacity-50 tw-rounded-md tw-shadow-sm dark:tw-text-gray-400 dark:hover:tw-text-gray-100 dark:focus:tw-ring-offset-gray-800 dark:tw-border-gray-700 dark:tw-bg-gray-900 dark:focus:tw-border-indigo-600 dark:tw-focus:ring-indigo-600"
        name="role_id">
        <option value="developer">Developer</option>
        <option value="admin">Admin</option>
        <option value="user">User</option>
    </select>
</div>

<div class="tw-flex tw-items-center tw-justify-end tw-mt-4">
    <a class="tw-underline tw-text-sm tw-text-gray-600 dark:tw-text-gray-400 hover:tw-text-gray-900 dark:hover:tw-text-gray-100 tw-rounded-md focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-offset-2 focus:tw-ring-indigo-500 dark:focus:tw-ring-offset-gray-800"
        href="{{ route('login') }}">
        {{ __('Already registered?') }}
    </a>

    <x-primary-button class="tw-ml-4">
        {{ __('Register') }}
    </x-primary-button>
</div>
</form>
</x-auth-card>
</x-guest-layout> --}}
