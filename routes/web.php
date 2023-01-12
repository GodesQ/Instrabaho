<?php

use Illuminate\Support\Facades\Route;

/*===MIDDLEWARE===*/
use App\Http\Middleware\WebAuth;

/*===CONTROLLERS===*/
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\UserController;
use App\Http\Controllers\Web\FreelancerController;
use App\Http\Controllers\Web\FreelancePackagesController;
use App\Http\Controllers\Web\EmployerPackagesController;
use App\Http\Controllers\Web\EmployerController;
use App\Http\Controllers\Web\PackageCheckoutController;
use App\Http\Controllers\Web\AddonsController;
use App\Http\Controllers\Web\ServicesController;
use App\Http\Controllers\Web\ProjectsController;
use App\Http\Controllers\Web\HomeScreenController;
use App\Http\Controllers\Web\ServicesProposalController;
use App\Http\Controllers\Web\ChatController;
use App\Http\Controllers\Web\SaveProjectController;
use App\Http\Controllers\Web\SaveServiceController;
use App\Http\Controllers\Web\FollowEmployerController;
use App\Http\Controllers\Web\FollowFreelancerController;
use App\Http\Controllers\Web\ProjectProposalController;
use App\Http\Controllers\Web\ProjectOffersController;
use App\Http\Controllers\Web\ForgotPasswordController;
use App\Http\Controllers\Web\ProjectChatController;
use App\Http\Controllers\Web\UserFundsController;
use App\Http\Controllers\Web\TransactionsController;
use App\Http\Controllers\Web\SkillsController;
use App\Http\Controllers\Web\ServiceCategoriesController;
use App\Http\Controllers\Web\ProjectContractController;
use App\Http\Controllers\Web\NotificationController;
use App\Http\Controllers\Web\FreelancerReviewsController;
use App\Http\Controllers\Web\EmployerReviewsController;
use App\Http\Controllers\Web\EWalletCallBackController;
use App\Http\Controllers\Web\ProjectPayJobController;
use App\Http\Controllers\Web\CardPaymentCallBackController;

use App\Http\Controllers\Web\Accounting\AccountingAuthController;

use App\Http\Controllers\Web\Admin\AdminAuthController;
use App\Http\Controllers\Web\Admin\AdminController;
use App\Http\Controllers\Web\Admin\UserPermissionController;
use App\Http\Controllers\Web\Admin\UserTypesController;

use App\Events\ProjectMessageEvent;
/*
|--------------------------------------------------------------------------
| PUBLIC Routes
|--------------------------------------------------------------------------
*/

    Route::get('/', [HomeScreenController::class, 'index']);

    Route::get('/contact-us', [HomeScreenController::class, 'contact_us']);
    Route::get('/the-process', [HomeScreenController::class, 'the_process']);

    Route::get('/search_services', [HomeScreenController::class, 'services']);
    Route::get('/search_services/fetch_data', [HomeScreenController::class, 'fetch_services']);

    Route::get('/search_projects', [HomeScreenController::class, 'projects']);
    Route::get('/search_projects/fetch_data', [HomeScreenController::class, 'fetch_projects']);

    Route::get('/search_freelancers', [HomeScreenController::class, 'freelancers']);
    Route::get('/search_freelancers/fetch_data', [HomeScreenController::class, 'fetch_freelancers']);

    Route::get('/project/view/{id}', [HomeScreenController::class, 'project'])->name('project.view');
    Route::get('/service/view/{id}', [HomeScreenController::class, 'service'])->name('service.view');

    Route::get('/freelancers/{username}', [HomeScreenController::class, 'freelancer'])->name('freelancer.view');
    Route::get('/employer/view/{id}', [HomeScreenController::class, 'employer'])->name('employer.view');

    /*
    |--------------------------------------------------------------------------
    | AUTH Routes
    |--------------------------------------------------------------------------
    */
    Route::get('/login', [AuthController::class, 'login'])->name('login.get');
    Route::post('/login', [AuthController::class, 'save_login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'register'])->name('register.get');
    Route::post('/register', [AuthController::class, 'save_register'])->name('register.post');
    Route::get('/verify_email', [AuthController::class, 'verify_email'])->name('verify');
    Route::get('/verify-message', [AuthController::class, 'verify_message'])->name('verify-message');
    Route::get('/success-verify-message', [AuthController::class, 'success_verify_message'])->name('success-verify-message');

    Route::post('/send_forgot_form', [ForgotPasswordController::class, 'send_forgot_form'])->name('send_forgot_form');
    Route::get('/forgot-message', [ForgotPasswordController::class, 'forgot_ message']);
    Route::get('/forgot-reset-form', [ForgotPasswordController::class, 'forgot_reset_form']);
    Route::post('/submit-reset-form', [ForgotPasswordController::class, 'submit_reset_form']);

    Route::get('/freelance_packages', [FreelancePackagesController::class, 'freelance_packages'])->name('freelance_package');
    Route::get('/employer_packages', [EmployerPackagesController::class, 'employer_package'])->name('employer_package');

    Route::get('/test_paymongo', [HomeScreenController::class, 'test'])->name('paymongo.test');

    Route::post('/webhooks', function() {
        $payLoad = json_decode(request()->getContent(), true);
        $evt = $payLoad['data']['id'];
        session()->put('evt_id', $evt);
    });

    Route::get('/allwebhooks', function(Request $request) {
        // $webhook = Paymongo::webhook()->create([
        //     'url' => 'http://127.0.0.1:8000/webhooks',
        //     'events' => [
        //         'source.chargeable',
        //         'payment.paid',
        //         'payment.failed'
        //     ]
        // ]);

        // $webhook = Paymongo::webhook()->find('hook_3G54foSjYh7Qz3nbyUn7u8XY')->update([
        //     'url' => 'http://127.0.0.1:8000/webhooks'
        // ]);

        $webhook = Paymongo::webhook()->all();
        dd($webhook);
        // Enable webhook
        // $webhook = Paymongo::webhook()->find('hook_3G54foSjYh7Qz3nbyUn7u8XY')->enable();

        // Disable webhook
        // $webhook = Paymongo::webhook()->find('hook_3G54foSjYh7Qz3nbyUn7u8XY')->disable();
    });

    /*
    |--------------------------------------------------------------------------
    | PROTECTED Routes
    |--------------------------------------------------------------------------
    */

    Route::middleware(['webauth'])->group( function () {

        Route::get('notifications', [NotificationController::class, 'notifications'])->name('get.notifications');
        Route::put('notifications/mark_as_read', [NotificationController::class, 'mark_as_read'])->name('put.mark_as_read');

        Route::get('/logout', [AuthController::class, 'logout'])->name('user.logout');
        Route::get('/change_login', [AuthController::class, 'change_login'])->name('user.change_login');

        Route::post('/user_change_password', [UserController::class, 'user_change_password'])->name('user_change_password');
        Route::post('/change_user_picture', [UserController::class, 'change_user_picture'])->name('change_user_picture');
        Route::post('/update_payment_method', [UserController::class, 'change_user_payment_method'])->name('change_user_payment_method');

        Route::get('freelancer/role_form', [FreelancerController::class, 'freelancer_role_form'])->name('freelancer.role_form');
        Route::post('freelancer/role_form', [FreelancerController::class, 'save_freelancer_role_form'])->name('freelancer.save_role_form');

        Route::get('/employer/role_form', [EmployerController::class, 'role_form'])->name('employer.role_form');
        Route::post('/employer/role_form', [EmployerController::class, 'save_role_form'])->name('employer.save_role_form');

        Route::get('/package_checkout', [PackageCheckoutController::class, 'package_checkout'])->name('package_checkout');
        Route::post('/store_package_checkout', [PackageCheckoutController::class, 'store_package_checkout'])->name('store_package_checkout');

        Route::group(['prefix'=> 'freelancer', 'middleware'=>['freelancer.access']], function(){
            Route::get('dashboard', [FreelancerController::class, 'dashboard'])->name('freelancer.dashboard');
            Route::get('profile', [FreelancerController::class, 'profile'])->name('freelancer.profile');
            Route::post('profile', [FreelancerController::class, 'update_profile'])->name('freelancer.profile.update');
            Route::get('addons', [AddonsController::class, 'index'])->name('freelancer.addons.index');
            Route::get('create_addon', [AddonsController::class, 'create'])->name('freelancer.addon.create');
            Route::get('edit_addon/{id}', [AddonsController::class, 'edit'])->name('freelancder.addon.edit');
            Route::get('services', [ServicesController::class, 'index'])->name('freelancer.services.index');
            Route::get('create_service', [ServicesController::class, 'create'])->name('freelancer.service.create');
            Route::get('edit_service/{id}', [ServicesController::class, 'edit'])->name('service.edit');
            Route::get('save_project/{id}/{owner_id}', [SaveProjectController::class, 'save_project'])->name('save_project');
            Route::get('saved_projects', [SaveProjectController::class, 'freelancer_saved_projects'])->name('freelancer.saved_projects');
            Route::get('proposal_lists', [ProjectProposalController::class, 'proposals_for_freelancers'])->name('freelancer.proposals');
            Route::get('follow_employer/{employer_id}', [FollowEmployerController::class, 'freleancer.follow_employer']);
            Route::get('followed_employers', [FollowEmployerController::class, 'followed_employers'])->name('freelancer.followed_employer');

            Route::get('proposals', [ProjectProposalController::class, 'proposals_for_freelancers'])->name('freelancer.proposals');
            Route::get('proposals/fetch_data', [ProjectProposalController::class, 'fetch_proposals_for_freelancers'])->name('freelancer.fetch_proposals');

            Route::get('projects/ongoing', [ProjectsController::class, 'freelancer_ongoing'])->name('freelancer.projects.ongoing');
            Route::get('projects/completed', [ProjectsController::class, 'freelancer_completed'])->name('freelancer.projects.completed');
        });

        Route::post('/store_certificates', [FreelancerController::class, 'store_certificates'])->name('freelancer.store_certificates');
        Route::delete('/remove_certificate', [FreelancerController::class, 'remove_certificate'])->name('freelancer.remove_certificate');
        Route::get('/remove_certificate_image/{id}/{key_id}', [FreelancerController::class, 'remove_certificate_image'])->name('remove_certificate_image');
        Route::post('/store_experiences', [FreelancerController::class, 'store_experiences'])->name('freelancer.store_experiences');
        Route::post('/store_projects', [FreelancerController::class, 'store_projects'])->name('freelancer.store_projects');
        Route::delete('/remove_project', [FreelancerController::class, 'remove_project'])->name('freelancer.remove_project');
        Route::post('/store_educations', [FreelancerController::class, 'store_educations'])->name('freelancer.store_educations');
        Route::post('/store_skills', [FreelancerController::class, 'store_skills'])->name('freelancer.store_skills');

        Route::group(['prefix' => 'employer', 'middleware' => ['employer.access']], function() {
            Route::get('dashboard', [EmployerController::class, 'dashboard'])->name('employer.dashboard');
            Route::get('profile', [EmployerController::class, 'profile'])->name('employer.profile');
            Route::post('profile', [EmployerController::class, 'update_profile'])->name('employer.profile.update');
            Route::get('projects', [ProjectsController::class, 'index'])->name('employer.projects.index');
            Route::get('projects/info/{title}', [ProjectsController::class, 'show'])->name('employer.projects.show');
            Route::get('projects/ongoing', [ProjectsController::class, 'employer_ongoing'])->name('employer.projects.ongoing');
            Route::get('projects/completed', [ProjectsController::class, 'employer_completed'])->name('employer.projects.completed');
            Route::get('create_project', [ProjectsController::class, 'create'])->name('freelancer.project.create');
            Route::get('edit_project/{id}', [ProjectsController::class, 'user_edit'])->name('freelancer.project.edit');
            Route::get('projects/offers', [ProjectOffersController::class, 'employer_offers'])->name('employer.projects.offers');
            Route::get('/offer/create_offer/{freelancer}', [ProjectOffersController::class, 'employer_create_offer'])->name('offer.employer.create');
            Route::get('proposals', [ProjectProposalController::class, 'proposals_for_employers'])->name('employer.proposals');
            Route::get('proposals/fetch_data', [ProjectProposalController::class, 'fetch_proposals_for_employers'])->name('employer.fetch_proposals');
        });

        Route::get('/projects/selected_dates', [ProjectsController::class, 'selected_dates'])->name('projects.selected_dates');

        # Route for offers to freelancer from employer
        Route::post('/offer/store', [ProjectOffersController::class, 'store'])->name('project.offer.store');
        Route::put('/offer/accept_offer', [ProjectOffersController::class, 'accept_offer'])->name('project.offer.accept_offer');
        Route::get('/offer/info/{id}', [ProjectOffersController::class, 'offer'])->name('offer.view');

        # proposal routes
        Route::post('/store_proposal', [ProjectProposalController::class, 'store'])->name('proposal.store');
        Route::get('/proposal/info/{id}', [ProjectProposalController::class, 'proposal'])->name('proposal.view');


        # contract routes
        Route::get('/project/create-contract/{type}/{id}', [ProjectContractController::class, 'create'])->name('create.contract')->middleware('employer.access');
        Route::post("/project/proposal/store-contract", [ProjectContractController::class, 'store'])->name('store.contract')->middleware('employer.access');
        Route::get('/project/contract/view/{id}', [ProjectContractController::class, 'contract'])->name('contract');
        Route::get('/project/contract/code/{id}', [ProjectContractController::class, 'view_code'])->name('contract.code')->middleware('freelancer.access');
        Route::get('/project/contract/validate-code/{id}', [ProjectContractController::class, 'validate_code'])->name('contract.validate_code')->middleware('employer.access');
        Route::post('/project/contract/validate-code', [ProjectContractController::class, 'post_validate_code'])->name('contract.post_validate_code')->middleware('employer.access');
        Route::get('/project/contract/track/{id}', [ProjectContractController::class, 'track'])->name('contract.track');
        Route::put('/project/contract/start_working', [ProjectContractController::class, 'start_working'])->name('contract.start_working');
        Route::post('/project/contract/store_time', [ProjectContractController::class, 'store_time'])->name('contract.store_time');

        Route::get('/review_freelancer/{job_type}/{contract_id}', [FreelancerReviewsController::class, 'create'])->name('review.freelancer');
        Route::post('/review_freelancer', [FreelancerReviewsController::class, 'store'])->name('post-review.freelancer');

        Route::get('/review_employer/{job_type}/{contract_id}', [EmployerReviewsController::class, 'create'])->name('review.employer');
        Route::post('/review_employer', [EmployerReviewsController::class, 'store'])->name('post-review.employer');

        # this is for freelancers
        Route::post('/store_certificates', [FreelancerController::class, 'store_certificates'])->name('freelancer.store_certificates');
        Route::get('/remove_certificate_image/{id}/{key_id}', [FreelancerController::class, 'remove_certificate_image'])->name('remove_certificate_image');
        Route::post('/store_certificates', [FreelancerController::class, 'store_certificates'])->name('freelancer.store_certificates');
        Route::post('/store_experiences', [FreelancerController::class, 'store_experiences'])->name('freelancer.store_experiences');
        Route::post('/store_educations', [FreelancerController::class, 'store_educations'])->name('freelancer.store_educations');
        Route::post('/store_skills', [FreelancerController::class, 'store_skills'])->name('freelancer.store_skills');


        Route::get('/package_checkout', [PackageCheckoutController::class, 'package_checkout'])->name('package_checkout');
        Route::post('/store_package_checkout', [PackageCheckoutController::class, 'store_package_checkout'])->name('store_package_checkout');

        # addons
        Route::post('/store_addon', [AddonsController::class, 'store'])->name('addon.store');
        Route::post('/update_addon', [AddonsController::class, 'update'])->name('addon.update');
        Route::delete('/destroy_addon', [AddonsController::class, 'destroy'])->name('addon.destroy');

        # services
        Route::post('/store_service', [ServicesController::class, 'store'])->name('service.store');
        Route::post('/update_service', [ServicesController::class, 'update'])->name('service.update')->middleware('plan.expiration', 'admin.access');
        Route::get('/service/remove_image/{id}/{key_id}', [ServicesController::class, 'remove_image'])->name('service.remove_image');
        Route::delete('/destroy_service', [ServicesController::class, 'destroy'])->name('service.destroy');

        #services_offer
        Route::get('/services_offer/employer', [ServicesProposalController::class, 'employer_proposals'])->name('employer_proposals')->middleware('employer.access');
        Route::get('/services_offer/employer/fetch_data', [ServicesProposalController::class, 'fetch_employer_proposals'])->name('fetch_employer_proposals')->middleware('employer.access');
        Route::get('/services_offer/pending', [ServicesProposalController::class, 'pending'])->name('pending');
        Route::get('/services_offer/cancel', [ServicesProposalController::class, 'cancel'])->name('cancel');

        Route::get('/service_proposal_information/{id}', [ServicesProposalController::class, 'service_proposal_information'])->name('service_proposal_information');
        Route::delete('saved_projects/delete/{id}', [SaveProjectController::class, 'destroy'])->name('saved_project.destroy');

        # projects
        Route::post('/store_project', [ProjectsController::class, 'store'])->name('project.store');
        Route::post('/update_project', [ProjectsController::class, 'update'])->name('project.update');
        Route::get('/remove_project_image/{id}/{key_id}', [ProjectsController::class, 'remove_project_image'])->name('project.remove_image');
        Route::get('/destroy_project/{id}', [ProjectsController::class, 'destroy'])->name('project.destroy');

        Route::get('/followed_freelancer', [FollowFreelancerController::class, 'followed_freelancer'])->name('followed_freelancer');

        Route::post('/submit_proposal', [ServicesProposalController::class, 'submit_proposal'])->name('submit_proposal');
        Route::post('/purchased_service/change_status', [ServicesProposalController::class, 'change_status'])->name('change_status');

        // This is for service chat
        Route::get('/get_chat/{id}', [ChatController::class, 'get_chat'])->name('get_chat');
        Route::post('/send_chat', [ChatController::class, 'send_chat'])->name('send_chat');

        Route::get('/follow_freelancer/{freelancer_id}', [FollowFreelancerController::class, 'follow_freelancer']);

        Route::get('/project_get_chat/{id}/{type}', [ProjectChatController::class, 'project_get_chat'])->name('project_get_chat');
        Route::post('/send_project_chat', [ProjectChatController::class, 'send_project_chat'])->name('send_project_chat');

        Route::get('/user_fund', [UserFundsController::class, 'user_funds'])->name('user_funds');
        Route::post('/deposit', [UserFundsController::class, 'deposit'])->name('deposit');

        Route::get('/project_pay_job/{type}/{id}', [ProjectPayJobController::class, 'view_pay_job'])->name('view_pay_job')->middleware('employer.access');
        Route::post('/project_pay_job', [ProjectPayJobController::class, 'pay_job'])->name('pay_job')->middleware('employer.access');

        Route::get('/card_payment/security-check/{id}', [CardPaymentCallBackController::class, 'security_check'])->name('card-payment.security_check');
        Route::put('/card_payment/update/{id}/{type?}', [CardPaymentCallBackController::class, 'card_update'])->name('card-payment.update');

        Route::get('/ewallet/{txn_code}/{type?}/success', [EWalletCallbackController::class, 'success'])->name('ewallet.success');
        Route::get('/ewallet/{txn_code}/{type?}/failed', [EWalletCallbackController::class, 'failed'])->name('ewallet.failed');

        Route::get('/transaction_message/card_payment/{txn_code}/success', [TransactionsController::class, 'card_payment_success'])->name('card_payment.success');
        Route::get('/transaction_message/ewallet/{txn_code}/success', [TransactionsController::class, 'ewallet_payment_success'])->name('transaction_message.ewallet.success');
        Route::get('/transaction_message/ewallet/{txn_code}/failed', [TransactionsController::class, 'ewallet_payment_failed'])->name('transaction_message.ewallet.failed');
    });

    Route::get('/accounting/login', [AccountingAuthController::class, 'login'])->name('accounting.login.get');
    Route::post('/accounting/login', [AccountingAuthController::class, 'save_login'])->name('login.post');

    Route::group(['prefix' => 'accounting', 'as' => 'accounting.', 'middleware' => ['accounting.access']], function() {
        Route::get('/dashboard', [])->name('accounting.dashboard');
    });

    /* ----------------------------------------- ADMIN ROUTES -------------------------------------------- */

    Route::get('/admin/login', [AdminAuthController::class, 'login'])->name('login.get');
    Route::post('/admin/login', [AdminAuthController::class, 'save_login'])->name('login.post');

    Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['admin.access']], function() {
        Route::get('logout', [AdminAuthController::class, 'logout'])->name('logout.get');
        Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

        Route::get('admins', [AdminController::class, 'index'])->name('admins');
        Route::get('admins/data_table', [AdminController::class, 'data_table'])->name('admins.data_table');
        Route::get('admins/edit/{id}', [AdminController::class, 'edit'])->name('admins.edit');
        Route::put('admins/update', [AdminController::class, 'update'])->name('admins.update');
        Route::get('admins/create', [AdminController::class, 'create'])->name('admins.create');
        Route::post('admins/store', [AdminController::class, 'store'])->name('admins.store');

        Route::get('freelancer_packages', [FreelancePackagesController::class, 'index'])->name('freelancer_packages');
        Route::get('freelancer_packages/data_table', [FreelancePackagesController::class, 'data_table'])->name('freelancer_packages.data_table');
        Route::get('freelancer_packages/edit/{id}', [FreelancePackagesController::class, 'edit'])->name('freelancer_packages.edit');
        Route::put('freelancer_packages/update', [FreelancePackagesController::class, 'update'])->name('freelancer_packages.update');
        Route::get('freelancer_packages/create', [FreelancePackagesController::class, 'create'])->name('freelancer_packages.create');
        Route::post('freelancer_packages/store', [FreelancePackagesController::class, 'store'])->name('freelancer_packages.store');

        Route::get('employer_packages', [EmployerPackagesController::class, 'index'])->name('employer_packages');
        Route::get('employer_packages/data_table', [EmployerPackagesController::class, 'data_table'])->name('employer_packages.data_table');
        Route::get('employer_packages/edit/{id}', [EmployerPackagesController::class, 'edit'])->name('employer_packages.edit');
        Route::put('employer_packages/update', [EmployerPackagesController::class, 'update'])->name('employer_packages.update');
        Route::get('employer_packages/create', [EmployerPackagesController::class, 'create'])->name('employer_packages.create');
        Route::post('employer_packages/store', [EmployerPackagesController::class, 'store'])->name('employer_packages.store');

        Route::get('freelancers', [FreelancerController::class, 'index'])->name('freelancers')->middleware('can:manage_freelancers');
        Route::get('freelancers/data_table', [FreelancerController::class, 'data_table'])->name('freelancers.data_table')->middleware('can:manage_freelancers');
        Route::get('freelancers/edit/{id}', [FreelancerController::class, 'edit'])->name('freelancers.edit')->middleware('can:edit_freelancer');
        Route::put('freelancers/update', [FreelancerController::class, 'update'])->name('freelancers.update')->middleware('can:edit_freelancer');
        Route::get('freelancers/search', [FreelancerController::class, 'search'])->name('freelancers.search');

        Route::get('employers', [EmployerController::class, 'index'])->name('employers');
        Route::get('employers/data_table', [EmployerController::class, 'data_table'])->name('employers.data_table');
        Route::get('employers/edit/{id}', [EmployerController::class, 'edit'])->name('employers.edit');
        Route::put('employers/update', [EmployerController::class, 'update'])->name('employers.update');
        Route::get('employers/search', [EmployerController::class, 'search'])->name('employers.search');

        Route::get('services', [ServicesController::class, 'admin_index'])->name('services');
        Route::get('services/data_table', [ServicesController::class, 'data_table'])->name('services.data_table');
        Route::get('services/edit/{id}', [ServicesController::class, 'admin_edit'])->name('services.edit');
        Route::get('services/create', [ServicesController::class, 'admin_create'])->name('services.create');

        Route::get('addons', [AddonsController::class, 'admin_index'])->name('addons');
        Route::get('addons/data_table', [AddonsController::class, 'data_table'])->name('addons.data_table');
        Route::get('addons/edit/{id}', [AddonsController::class, 'admin_edit'])->name('addons.edit');
        Route::get('addons/create', [AddonsController::class, 'admin_create'])->name('addons.create');

        Route::get('projects', [ProjectsController::class, 'admin_index'])->name('projects');
        Route::get('projects/data_table', [ProjectsController::class, 'data_table'])->name('projects.data_table');
        Route::get('projects/edit/{id}', [ProjectsController::class, 'admin_edit'])->name('projects.edit');
        Route::get('projects/create', [ProjectsController::class, 'admin_create'])->name('projects.create');

        Route::get('skills', [SkillsController::class, 'index'])->name('skills');
        Route::get('skills/data_table', [SkillsController::class, 'data_table'])->name('skills.data_table');
        Route::get('skills/edit', [SkillsController::class, 'edit'])->name('skills.edit');
        Route::post('skills/update', [SkillsController::class, 'update'])->name('skills.update');
        Route::post('skills/store', [SkillsController::class, 'store'])->name('skills.store');
        Route::delete('skills/destroy', [SkillsController::class, 'destroy'])->name('skills.destroy');

        Route::get('service_categories', [ServiceCategoriesController::class, 'index'])->name('service_categories');
        Route::get('service_categories/data_table', [ServiceCategoriesController::class, 'data_table'])->name('service_categories.data_table');
        Route::get('service_categories/edit', [ServiceCategoriesController::class, 'edit'])->name('service_categories.edit');
        Route::post('service_categories/update', [ServiceCategoriesController::class, 'update'])->name('service_categories.update');
        Route::post('service_categories/store', [ServiceCategoriesController::class, 'store'])->name('service_categories.store');
        Route::delete('service_categories/destroy', [ServiceCategoriesController::class, 'destroy'])->name('service_categories.destroy');

        Route::get('saved_projects', [SaveProjectController::class, 'admin_index'])->name('saved_projects');
        Route::get('saved_projects/data_table', [SaveProjectController::class, 'data_table'])->name('saved_projects.datatables');

        Route::get('saved_categories', [SaveServiceController::class, 'admin_index'])->name('saved_categories');
        Route::get('saved_categories/data_table', [SaveServiceController::class, 'data_table'])->name('saved_categories.datatables');

        Route::get('freelancers_followers', [FollowFreelancerController::class, 'admin_index'])->name('freelancers_followers');
        Route::get('freelancers_followers/data_table', [FollowFreelancerController::class, 'data_table'])->name('freelancers_followers.datatables');

        Route::get('employers_followers', [FollowEmployerController::class, 'admin_index'])->name('employers_followers');
        Route::get('employers_followers/data_table', [FollowEmployerController::class, 'data_table'])->name('employers_followers.datatables');

        Route::get('saved_services', [SaveServiceController::class, 'admin_index'])->name('saved_services');

        Route::get('user_types', [UserTypesController::class, 'index'])->name('user_types');
        Route::get('user_types/data_table', [UserTypesController::class, 'data_table'])->name('user_types.data_table');
        Route::post('user_types/store', [UserTypesController::class, 'store'])->name('user_types.store');
        Route::get('user_types/edit', [UserTypesController::class, 'edit'])->name('user_types.edit');
        Route::post('user_types/update', [UserTypesController::class, 'update'])->name('user_types.update');

        Route::get('user_permissions', [UserPermissionController::class, 'permission'])->name('user_permissions');
        Route::get('user_permissions/data_table', [UserPermissionController::class, 'data_table'])->name('user_permissions.data_table');
        Route::get('user_permissions/create', [UserPermissionController::class, 'create'])->name('user_permissions.create');
        Route::post('user_permissions/store', [UserPermissionController::class, 'store'])->name('user_permissions.store');
        Route::get('user_permissions/edit/{id}', [UserPermissionController::class, 'edit'])->name('user_permissions.edit');
        Route::post('user_permissions/update', [UserPermissionController::class, 'update'])->name('user_permissions.update');
        Route::delete('user_permissions/delete', [UserPermissionController::class, 'destroy'])->name('user_permissions.destroy');
    });
