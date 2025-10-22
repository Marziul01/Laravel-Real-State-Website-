<header id="masthead"
    class="site-header navbar-static-top headerV2 {{ Route::currentRouteName() != 'home' ? 'OtherPages' : '' }} "
    role="banner">
    <div class="container">
        <nav class="row navbar navbar-expand-xl p-lg-0 m-0">
            <div class="col-2 col-sm-1 col-md-1 d-lg-none hamburger-wrap">
                <a href="#mobile_nav" class="hamburger-menu">
                    <span></span>
                </a>
            </div>
            <div class="col-3 col-sm-3 col-lg-2 col-md-2 navbar-brand">
                <a href="{{ route('home') }}">
                    <img src="{{ asset($setting->site_logo) }}" width="100" height="100%">
                </a>
            </div>
            <div class="col-7 col-sm-8 col-lg-10 col-md-9 nav-band pl-0">
                <div class="row align-items-center">
                    <div id="main-nav" class="col-lg-6 pl-0 d-none d-lg-block">
                        <button class="close-menu d-lg-none">&times;</button>
                        <ul id="menu-top-menu" class="navbar-nav">
                            <li id="menu-item-62646"
                                class="menu-item menu-item-type-custom menu-item-object-custom menu-item-62646"><a
                                    href="{{ route('about') }}">About Us</a></li>
                            <li id="menu-item-75101"
                                class="menu-item menu-item-type-custom menu-item-object-custom menu-item-75101"><a
                                    href="{{ route('services') }}">Services</a></li>
                            <li id="menu-item-16669"
                                class="menu-item menu-item-type-custom menu-item-object-custom menu-item-16669"><a
                                    href="{{ route('rent') }}">Property Rent & Booking</a></li>
                            <li id="menu-item-52769"
                                class="menu-item menu-item-type-custom menu-item-object-custom menu-item-52769"><a
                                    href="{{ route('property') }}">Buy Properties</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-6 d-flex nav-band-right justify-content-end">
                        <ul>
                            {{-- <li class="d-lg-none">
                              <a href="" class="search-cion" id="search-div"><i class="fa-solid fa-magnifying-glass"></i></a>
                            </li> --}}
                            <li class="watsapp-tab">
                                @if (!Auth::check())
                                    <a href="#" target="_blank" class="header_whatsapp">
                                        <i class="fa-regular fa-user"></i>
                                        <span>Login / Signup</span>
                                    </a>
                                @else
                                    <div class="dropdown">
                                      <button class=" dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                       <i class="fa-regular fa-user"></i> <span>Hello, {{ Auth::user()->name }}</span> 
                                      </button>
                                      <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li><a class="dropdown-item" href="{{ route('user.dashboard') }}">Dashboard</a></li>
                                        <li><a class="dropdown-item" href="{{ route('user.logout') }}">Logout</a></li>
                                      </ul>
                                    </div>
                                @endif
                            </li>
                            
                            <li class="register-tab">
                                <a href="#contact-section" class="btn-blue get-touch-btn" data-toggle="modal"
                                    data-target="#registerModal" data-formname="Get in Touch">Get in Touch</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

        </nav>
    </div>
</header>

<!-- Sliding Panel -->
<div id="sideLoginModal" class="custom-slide-panel">
    <div class="panel-content">
        <div class="panel-header">
            <h5>Login / Signup</h5>
            <button class="close-panel">&times;</button>
        </div>
        <div class="panel-body">
            <div class="w-100 position-relative">
              <form id="formAuthentication" class="w-100" method="POST">
                @csrf
                <!-- Full Name -->
                <div class="mb-2 position-relative d-none" id="nameField">
                    <label for="name" class="form-label">Full Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter your full name" />
                    <small class="text-danger" id="nameError"></small>
                </div>

                <!-- Email -->
                <div class="mb-2 position-relative">
                    <label for="email" class="form-label">Email</label>
                    <input type="text" class="form-control" id="email" name="email" placeholder="Enter your email" />
                    <small class="text-danger" id="emailError"></small>
                </div>

                <!-- Phone (with country code) -->
                
                <div class="mb-2 position-relative d-none" id="phoneField">
                  <label for="phone" class="form-label">Phone</label>
                  <div>
                    <input type="tel" id="phone" name="phone" class="form-control" placeholder="Enter your phone number">
                    <small class="text-danger" id="phoneError"></small>
                  </div>
                </div>


                <!-- Password -->
                <div class="mb-2 position-relative">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group input-group-merge">
                        <input type="password" id="password" class="form-control" name="password" placeholder="••••••••••••" />
                        <span class="input-group-text cursor-pointer" id="togglePassword">
                            <i class="fa-solid fa-eye"></i>
                        </span>
                    </div>
                    <small class="text-danger" id="passwordError"></small>
                </div>

                <div class="">
                    <button class="btn btn-primary w-100 mt-3" type="submit" id="submitBtn">
                        <i class="fa-solid fa-arrow-right-to-bracket"></i> Login
                    </button>
                </div>
            </form>
            <div id="formLoader" class="form-loader d-none">
              <div class="spinner-border text-primary" role="status"></div>
            </div>
            <div class="w-100 text-center mt-3">
                <button class="btn btn-outline-primary w-100" id="toggleFormBtn">
                    <i class="fa-regular fa-circle-user"></i> Sign Up
                </button>
            </div>

            

            <!-- Verification Form (hidden by default) -->
            <form id="verifyEmailForm" class="w-100 d-none mt-3">
                @csrf
                <div class="mb-2 position-relative">
                    <label for="verificationCode" class="form-label">Enter Verification Code</label>
                    <input type="text" class="form-control" id="verificationCode" name="verification_code" placeholder="Enter code sent to email" />
                    <small class="text-danger" id="verificationError"></small>
                </div>
                <div class="">
                    <button class="btn btn-success w-100 mt-3" type="submit" id="verifyBtn">
                        Verify Email
                    </button>
                </div>
            </form>

            <form id="forgotPasswordForm" class="w-100 d-none mt-3">
  @csrf
  <div class="mb-2 position-relative">
    <label for="forgotEmail" class="form-label">Email</label>
    <input type="email" class="form-control" id="forgotEmail" name="email" placeholder="Enter your registered email" />
    <small class="text-danger" id="forgotEmailError"></small>
  </div>
  <div class="">
    <button class="btn btn-warning w-100 mt-3" type="submit">
      <i class="fa-solid fa-envelope"></i> Send Verification Code
    </button>
  </div>
</form>

  <!-- Verify Code Form -->
  <form id="verifyForgotCodeForm" class="w-100 d-none mt-3">
    @csrf
    <div class="mb-2 position-relative">
      <label for="forgotVerificationCode" class="form-label">Enter Verification Code</label>
      <input type="text" class="form-control" id="forgotVerificationCode" name="verification_code" placeholder="Enter the code sent to your email" />
      <small class="text-danger" id="forgotVerificationError"></small>
    </div>
    <div class="">
      <button class="btn btn-success w-100 mt-3" type="submit">
        Verify Code
      </button>
    </div>
  </form>

  <!-- Reset Password Form -->
  <form id="resetPasswordForm" class="w-100 d-none mt-3">
    @csrf
    <div class="mb-2 position-relative">
      <label for="newPassword" class="form-label">New Password</label>
      <input type="password" class="form-control" id="newPassword" name="password" placeholder="Enter new password" />
      <small class="text-danger" id="newPasswordError"></small>
    </div>

    <div class="mb-2 position-relative">
      <label for="confirmPassword" class="form-label">Confirm Password</label>
      <input type="password" class="form-control" id="confirmPassword" name="confirm_password" placeholder="Confirm password" />
      <small class="text-danger" id="confirmPasswordError"></small>
    </div>

    <div class="">
      <button class="btn btn-primary w-100 mt-3" type="submit">
        <i class="fa-solid fa-check"></i> Reset Password
      </button>
    </div>
  </form>

              <div class="w-100 text-center mt-3">
                <a class="text-center text-sm forget-toogle" id="forget-toogle" href=""><i class="fa-solid fa-unlock-keyhole"></i> Forgot password?</a>
              </div>
              <div class="w-100 text-center mt-3 d-none" id="toggleBACK">
                  <button class="btn btn-outline-primary w-100" >
                      <i class="fa-solid fa-arrow-left"></i> Go Back
                  </button>
              </div>
            </div>
            
            <div class="panel-footer w-100"> 
              <hr>
              <p class="text-center"> Follow us on : </p>
              <div class="social-icons text-center mb-2 mb-md-0">
                    <a href="#" class="social-link"><i class="fab fa-youtube"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                </div>
            </div>  
        </div>
    </div>
</div>

