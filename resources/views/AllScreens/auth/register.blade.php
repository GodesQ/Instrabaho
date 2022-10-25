@extends('layout.layout')
    @section('content')
		<section class="fr-sign-in-hero">
		   <div class="container">
		      <div class="row">
		         <div class="col-lg-6 col-xs-12 col-sm-12 col-xl-6 col-md-12 align-self-center no-padding-hero">
		            <div class="fr-sign-container">
		               <div class="fr-sign-content">
		                  <div class="heading-panel">
		                     <h2>Register With Us</h2>
		                     <p>Create a new account with us and start using the most trusted platform to hire freelancers and provide services </p>
		                  </div>
		                  <form id="signup-form" method="POST" novalidate>
							@csrf
							<div class="row">
								<div class="col-md-4">
									<div class="fr-sign-form">
										<div class="fr-sign-logo"> <img src="../../../images/icons/name.png" alt="" class="img-fluid"> </div>
										<div class="form-group">
										   <input type="text" name="firstname" placeholder="Firstname" class="form-control" required="" data-smk-msg="Please provide firstname">
										   <span class="danger text-danger p-1">@error('firstname'){{$message}}@enderror</span>
										</div>
									 </div>
								</div>
								<div class="col-md-4">
									<div class="fr-sign-form">
										<div class="fr-sign-logo"> <img src="../../../images/icons/name.png" alt="" class="img-fluid"> </div>
										<div class="form-group">
										   <input type="text" name="middlename" placeholder="Middlename" class="form-control" required="" data-smk-msg="Please provide middlename">
										   <span class="danger text-danger p-1">@error('middlename'){{$message}}@enderror</span>
										</div>
									 </div>
								</div>
								<div class="col-md-4">
									<div class="fr-sign-form">
										<div class="fr-sign-logo"> <img src="../../../images/icons/name.png" alt="" class="img-fluid"> </div>
										<div class="form-group">
										   <input type="text" name="lastname" placeholder="Lastname" class="form-control" required="" data-smk-msg="Please provide lastname">
										   <span class="danger text-danger p-1">@error('lastname'){{$message}}@enderror</span>
										</div>
									 </div>
								</div>
							</div>
		                     <div class="fr-sign-form">
		                        <div class="fr-sign-logo"> <img src="../../../images/icons/username.png" alt="" class="img-fluid"> </div>
		                        <div class="form-group">
		                           <input type="text" name="username" placeholder="Username" class="form-control" required="" data-smk-msg="Please provide username">
								   <span class="danger text-danger p-1">@error('username'){{$message}}@enderror</span>
		                        </div>
		                     </div>
		                     <div class="fr-sign-form">
		                        <div class="fr-sign-logo"> <img src="../../../images/icons/mail.png" alt="" class="img-fluid"> </div>
		                        <div class="form-group">
		                           <input type="email" name="email" placeholder="Email address" class="form-control" required="" data-smk-msg="Email address is required">
								   <span class="danger text-danger p-1">@error('email'){{$message}}@enderror</span>
		                        </div>
		                     </div>
		                     <div class="fr-sign-form">
		                        <div class="fr-sign-logo"> <img src="../../../images/icons/password.png" alt="" class="img-fluid"> </div>
		                        <div class="form-group">
		                           <input type="password" name="password" placeholder="Password" class="form-control" id="password-field" required="" data-smk-msg="Please provide password">
		                           <span class="danger text-danger p-1">@error('password'){{$message}}@enderror</span>
								   <div data-toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password change-top" aria-hidden="true"></div>
		                        </div>
		                     </div>
		                     <div class="fr-sign-submit">
		                        <div class="form-group d-grid">
		                           <button type="submit" class="btn btn-theme btn-loading" id="signup-btn"> 
										Create Account
									</button>
		                        </div>
		                     </div>
		                     <div class="fr-sign-top-content">
		                        <p> OR</p>
		                     </div>
		                     <div>No apps configured. Please contact your administrator.</div>
		                  </form>
		               </div>
		               <div class="fr-sign-bundle-content">
		                  <p> Already have an account? <span><a href="/login">Login here</a></span></p>
		               </div>
		            </div>
		         </div>
		         <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
		            <div class="fr-sign-user-dashboard d-flex align-items-end">
		               <div class="sign-in owl-carousel owl-theme owl-loaded owl-drag two-item-owl">
		                  <div class="owl-stage-outer">
		                     <div class="owl-stage">
		                        <div class="owl-item">
		                           <div class="item">
		                              <div class="fr-sign-assets-2">
		                                 <div class="fr-sign-main-content"> <img src="../../../images/icons/house-2.png" alt="" class="img-fluid"> </div>
		                                 <div class="fr-sign-text">
		                                    <h3>User Dashboard</h3>
		                                    <p>Each user will have their own dashboard and enjoy working </p>
		                                 </div>
		                              </div>
		                           </div>
		                        </div>
		                        <div class="owl-item">
		                           <div class="item">
		                              <div class="fr-sign-assets-2">
		                                 <div class="fr-sign-main-content"> <img src="../../../images/icons/phone-s1.png" alt="" class="img-fluid"> </div>
		                                 <div class="fr-sign-text">
		                                    <h3>Chat Powered by WhizzChat</h3>
		                                    <p>The most extensive chat plugin is compatible with Exertion Theme </p>
		                                 </div>
		                              </div>
		                           </div>
		                        </div>
		                  		<div class="owl-nav"><button type="button" class="owl-prev"><span aria-label="Previous">‹</span></button><button type="button" class="owl-next"><span aria-label="Next">›</span></button></div>
		               	  	 </div>
		         		  </div>
		         	   </div>
		   			</div>
		   		 </div>
		   	  </div>
		   </div>
		   <div class="fr-sign-background add-bg">
		   </div>
		</section>
    @endsection
</html>