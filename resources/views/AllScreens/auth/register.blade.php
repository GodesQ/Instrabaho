@extends('layout.layout')
    @section('title', 'Register')
    @section('content')
		<section class="fr-sign-in-hero">
            <div class="row">
                <div class="col-xl-6">
                    <div class="fr-sign-background add-bg"></div>
                </div>
                <div class="col-xl-6">
                    <div class="container-fluid">
                        <div class="row">
                           <div class="col-lg-11 col-xs-12 col-sm-12 col-xl-11 col-md-12 align-self-center no-padding-hero">
                              <div class="fr-sign-container">
                                 <div class="fr-sign-content">
                                    <div class="heading-panel">
                                       <h2>Create your Instrabaho Account</h2>
                                       <p class="font-weight-bold"> Have an account already? <span><a href="/login" class="text-primary">Login here</a></span></p>
                                    </div>
                                    <form id="signup-form" method="POST" novalidate>
                                      @csrf
                                        <div class="row">
                                          <div class="col-md-12">
                                              <div class="form-group">
                                                <label class="font-weight-bold" for="firstname">First name <span class="text-danger">*</span></label>
                                                <input type="text" name="firstname" value="{{ old('firstname') }}" placeholder="Firstname" class="form-control" maxlength="15">
                                                <span class="danger text-danger p-1">@error('firstname'){{$message}}@enderror</span>
                                              </div>
                                          </div>
                                          <div class="col-md-6">
                                              <div class="form-group">
                                                <label class="font-weight-bold" for="middlename">Middle name </label>
                                                  <input type="text" name="middlename" placeholder="Middlename" class="form-control" value="{{ old('middlename') }}" maxlength="15">
                                                  <span class="danger text-danger p-1">@error('middlename'){{$message}}@enderror</span>
                                              </div>
                                          </div>
                                          <div class="col-md-6">
                                              <div class="form-group">
                                                <label class="font-weight-bold" for="lastname">Last name <span class="text-danger">*</span></label>
                                                <input type="text" name="lastname" placeholder="Lastname" class="form-control" value="{{ old('lastname') }}" maxlength="15">
                                                <span class="danger text-danger p-1">@error('lastname'){{$message}}@enderror</span>
                                              </div>
                                          </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="font-weight-bold" for="username">Username <span class="text-danger">*</span></label>
                                            <input type="text" name="username" placeholder="Username" class="form-control" value="{{ old('username') }}" maxlength="15">
                                            <span class="danger text-danger p-1">@error('username'){{$message}}@enderror</span>
                                        </div>
                                        <div class="form-group">
                                            <label class="font-weight-bold" for="email">Email <span class="text-danger">*</span></label>
                                            <input type="email" name="email" placeholder="Email address" class="form-control" value="{{ old('email') }}">
                                            <span class="danger text-danger p-1">@error('email'){{$message}}@enderror</span>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-6 col-md-12">
                                                <div class="form-group">
                                                    <label class="font-weight-bold" for="email">Password <span class="text-danger">*</span></label>
                                                    <input type="password" name="password" placeholder="Password" class="form-control" id="password-field" value="{{ old('password') }}">
                                                    <span class="danger text-danger p-1">@error('password'){{$message}}@enderror</span>
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-md-12">
                                                <div class="form-group">
                                                    <label class="font-weight-bold" for="email">Confirm Password <span class="text-danger">*</span></label>
                                                    <input type="password" name="password_confirmation" placeholder="Confirm Password" class="form-control" id="password-field" value="{{ old('password_confirmation') }}">
                                                    <span class="danger text-danger p-1">@error('password_confirmation'){{$message}}@enderror</span>
                                                </div>
                                            </div>
                                        </div>
                                       <button type="submit" class="btn-theme btn-primary">Create Account</button>
                                       {{-- <div class="fr-sign-top-content">
                                          <p> OR</p>
                                       </div>
                                       <div>No apps configured. Please contact your administrator.</div> --}}
                                    </form>
                                 </div>
                              </div>
                           </div>
                        </div>
                    </div>
                </div>
            </div>
		</section>
    @endsection
</html>
