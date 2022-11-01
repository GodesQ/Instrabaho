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
use App\Http\Controllers\Web\ForgotPasswordController;
use App\Http\Controllers\Web\ProjectChatController;
use App\Http\Controllers\Web\UserFundsController;
use App\Http\Controllers\Web\TransactionsController;
use App\Http\Controllers\Web\SkillsController;
use App\Http\Controllers\Web\ServiceCategoriesController;

use App\Http\Controllers\Web\Admin\AdminAuthController;
use App\Http\Controllers\Web\Admin\AdminController;
use App\Http\Controllers\Web\Admin\UserPermissionController;
/*
|--------------------------------------------------------------------------
| PUBLIC Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['throttle:global'])->group(function () {
    Route::get('/', [HomeScreenController::class, 'index']);

    Route::get('/contact-us', [HomeScreenController::class, 'contact_us']);
    Route::get('/the-process', [HomeScreenController::class, 'the_process']);

    Route::get('/search_services', [HomeScreenController::class, 'services']);
    Route::get('/search_projects', [HomeScreenController::class, 'projects']);
    Route::get('/search_freelancers', [HomeScreenController::class, 'freelancers']);

    Route::get('/project/{id}', [HomeScreenController::class, 'project']);
    Route::get('/service/{id}', [HomeScreenController::class, 'service']);

    Route::get('/freelancer/{id}', [FreelancerController::class, 'view_profile'])->name('view_profile');
    Route::get('/employer/{id}', [EmployerController::class, 'view_profile'])->name('view_employer_profile');



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

    Route::post('/send_forgot_form', [ForgotPasswordController::class, 'send_forgot_form'])->name('send_forgot_form');
    Route::get('/forgot-message', [ForgotPasswordController::class, 'forgot_message']);
    Route::get('/forgot-reset-form', [ForgotPasswordController::class, 'forgot_reset_form']);
    Route::post('/submit-reset-form', [ForgotPasswordController::class, 'submit_reset_form']);

    /*
    |--------------------------------------------------------------------------
    | PROTECTED Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware([WebAuth::class])->group( function () {
        Route::get('/logout', [AuthController::class, 'logout'])->name('user.logout');
        Route::get('/change_login', [AuthController::class, 'change_login'])->name('user.change_login');

        Route::get('/employer_role_form', [EmployerController::class, 'employer_role_form'])->name('employer_role_form');
        Route::post('/employer_role_form', [EmployerController::class, 'save_employer_role_form'])->name('employer_role_form.post');

        Route::get('/freelancer_role_form', [FreelancerController::class, 'freelancer_role_form'])->name('freelancer_role_form');
        Route::post('/freelancer_role_form', [FreelancerController::class, 'save_freelancer_role_form'])->name('freelancer_role_form.post');

        Route::get('/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
        Route::get('/profile', [UserController::class, 'profile'])->name('profile');
        Route::post('/profile', [UserController::class, 'update_profile'])->name('profile.update');
        Route::post('/user_change_password', [UserController::class, 'user_change_password'])->name('user_change_password');
        Route::post('/change_user_picture', [UserController::class, 'change_user_picture'])->name('change_user_picture');
        Route::post('/store_certificates', [UserController::class, 'store_certificates'])->name('store_certificates');
        Route::get('/remove_certificate_image/{id}/{key_id}', [UserController::class, 'remove_certificate_image'])->name('remove_certificate_image');
        Route::post('/store_experiences', [UserController::class, 'store_experiences'])->name('store_experiences');
        Route::post('/store_educations', [UserController::class, 'store_educations'])->name('store_educations');
        Route::post('/store_skills', [UserController::class, 'store_skills'])->name('store_skills');
        Route::post('/update_payment_method', [UserController::class, 'change_user_payment_method'])->name('change_user_payment_method');
        
        Route::get('/freelance_packages', [FreelancePackagesController::class, 'freelance_packages'])->name('freelance_package');
        Route::get('/employer_packages', [EmployerPackagesController::class, 'employer_package'])->name('employer_package');

        Route::get('/package_checkout', [PackageCheckoutController::class, 'package_checkout'])->name('package_checkout');
        Route::post('/store_package_checkout', [PackageCheckoutController::class, 'store_package_checkout'])->name('store_package_checkout');

        /* ---------------------------------------- FREELANCER ACCESS ---------------------------------------------- */
        Route::middleware(['freelancer.access'])->group(function () {
            Route::get('/addons', [AddonsController::class, 'index'])->name('index');
            Route::get('/create_addon', [AddonsController::class, 'create'])->name('create_addon');
            Route::post('/store_addon', [AddonsController::class, 'store'])->name('store_addon');
            Route::get('/edit_addon/{id}', [AddonsController::class, 'edit'])->name('edit_addon');
            Route::post('/update_addon', [AddonsController::class, 'update'])->name('update_addon');
            Route::get('/destroy_addon/{id}', [AddonsController::class, 'destroy'])->name('destroy_addon');

            Route::get('/services', [ServicesController::class, 'index'])->name('index');
            Route::get('/create_service', [ServicesController::class, 'create'])->name('create_service')->middleware('plan.expiration');
            Route::post('/store_service', [ServicesController::class, 'store'])->name('store_service')->middleware('plan.expiration');
            Route::get('/edit_service/{id}', [ServicesController::class, 'edit'])->name('edit_service');
            Route::post('/update_service', [ServicesController::class, 'update'])->name('update_service')->middleware('plan.expiration');;
            Route::get('/remove_image/{id}/{key_id}', [ServicesController::class, 'remove_image'])->name('remove_image')->middleware('plan.expiration');
            Route::get('/destroy_service', [ServicesController::class, 'destroy'])->name('destroy_service');

            Route::get('saved_projects/freelancers', [SaveProjectController::class, 'freelancer_saved_projects'])->name('freelancer_saved_projects');
            Route::delete('saved_projects/delete/{id}', [SaveProjectController::class, 'destroy'])->name('saved_project.destroy');
            Route::get('/followed_employer', [FollowEmployerController::class, 'followed_employer'])->name('followed_employer');
            Route::get('/proposal_lists/freelancer', [ProjectProposalController::class, 'proposals_for_freelancers'])->name('proposals_for_freelancers');
        });
        /* ---------------------------------------- END FREELANCER ACCESS ---------------------------------------------- */


        /* ---------------------------------------- EMPLOYER ACCESS ---------------------------------------------- */
        Route::middleware(['employer.access'])->group(function () {
            Route::get('/projects', [ProjectsController::class, 'index'])->name('index');
            Route::get('/create_project', [ProjectsController::class, 'create'])->name('create_project')->middleware('plan.expiration');
            Route::post('/store_project', [ProjectsController::class, 'store'])->name('store_project')->middleware('plan.expiration');
            Route::get('/edit_project/{id}', [ProjectsController::class, 'edit'])->name('edit_project');
            Route::post('/update_project', [ProjectsController::class, 'update'])->name('update_project')->middleware('plan.expiration');
            Route::get('/remove_project_image/{id}/{key_id}', [ProjectsController::class, 'remove_project_image'])->name('remove_project_image')->middleware('plan.expiration');
            Route::get('/destroy_project/{id}', [ProjectsController::class, 'destroy'])->name('destroy_project'); 

            Route::get('/followed_freelancer', [FollowFreelancerController::class, 'followed_freelancer'])->name('followed_freelancer');
            Route::get('/proposal_lists/employer', [ProjectProposalController::class, 'proposals_for_employers'])->name('proposals_for_employers');
        });
        /* ---------------------------------------- END EMPLOYER ACCESS ---------------------------------------------- */

        Route::post('/submit_proposal', [ServicesProposalController::class, 'submit_proposal'])->name('submit_proposal');
        Route::post('/purchased_service/change_status', [ServicesProposalController::class, 'change_status'])->name('change_status');

        // Route::get('/purchased_service/view/{id}', [ServicesProposalController::class, 'view_service'])->name('view_service');
        Route::get('/services_offer/pending', [ServicesProposalController::class, 'pending'])->name('pending');
        Route::get('/services_offer/cancel', [ServicesProposalController::class, 'cancel'])->name('cancel');
        Route::get('/services_offer/approved', [ServicesProposalController::class, 'approved'])->name('approved');
        Route::get('/services_offer/get_approved_services', [ServicesProposalController::class, 'get_approved_services'])->name('get_approved_services');

        Route::get('/service_proposal_information/{id}', [ServicesProposalController::class, 'service_proposal_information'])->name('service_proposal_information');
        
        // This is for service chat
        Route::get('/get_chat/{id}', [ChatController::class, 'get_chat'])->name('get_chat');
        Route::post('/send_chat', [ChatController::class, 'send_chat'])->name('send_chat');

        Route::get('/save_project/{id}/{owner_id}', [SaveProjectController::class, 'save_project'])->name('save_project');

        Route::get('/follow_freelancer/{freelancer_id}', [FollowFreelancerController::class, 'follow_freelancer']);
        Route::get('/follow_employer/{employer_id}', [FollowEmployerController::class, 'follow_employer']);

        Route::post('/store_proposal', [ProjectProposalController::class, 'store'])->name('store_proposal');
        Route::post('/update_proposal_status', [ProjectProposalController::class, 'update_proposal_status'])->name('update_proposal_status');

        Route::get('/project_proposals/approved', [ProjectProposalController::class, 'approved'])->name('proposal_approved');
        Route::get('/project_proposals/get_approved_proposals', [ProjectProposalController::class, 'get_approved_proposals'])->name('get_approved_proposals');
        Route::get('/project_proposal_information/{id}', [ProjectProposalController::class, 'project_proposal_information'])->name('project_proposal_information');

        // Route::get('/invoices')

        Route::get('/project_get_chat/{id}', [ProjectChatController::class, 'project_get_chat'])->name('project_get_chat');
        Route::post('/send_project_chat', [ProjectChatController::class, 'send_project_chat'])->name('send_project_chat');
        
        Route::get('/user_fund', [UserFundsController::class, 'user_funds'])->name('user_funds');
        Route::post('/deposit', [UserFundsController::class, 'deposit'])->name('deposit');
        
        Route::get('/pay_job/{type}/{id}', [TransactionsController::class, 'view_pay_job'])->name('view_pay_job');
        Route::post('/pay_job', [TransactionsController::class, 'pay_job'])->name('pay_job');

        Route::get('/transaction-message', [TransactionsController::class, 'transaction_messaage'])->name('transaction_messaage');
        Route::post('/transaction-message',  [TransactionsController::class, 'postback_transaction'])->name('postback_transaction');
        Route::get('/check_status',  [TransactionsController::class, 'check_status'])->name('check_status');

        Route::get('/transaction_details/paid_by_wallet', [TransactionsController::class, 'paid_by_wallet_message'])->name('transaction_paid_by_wallet');
    });

    /* ----------------------------------------- ADMIN ROUTES -------------------------------------------- */
    Route::get('/admin/login', [AdminAuthController::class, 'login'])->name('login.get');
    Route::post('/admin/login', [AdminAuthController::class, 'save_login'])->name('login.post');

    Route::middleware(['admin.access'])->group( function () {
        Route::get('/admin/logout', [AdminAuthController::class, 'logout'])->name('logout.get');
        Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard'); 

        Route::get('/admin/freelancer_packages', [FreelancePackagesController::class, 'index'])->name('admin.freelancer_packages');
        Route::get('/admin/freelancer_packages/data_table', [FreelancePackagesController::class, 'data_table'])->name('admin.freelancer_packages.data_table');
        Route::get('/admin/freelancer_packages/edit/{id}', [FreelancePackagesController::class, 'edit'])->name('admin.freelancer_packages.edit');
        Route::put('/admin/freelancer_packages/update', [FreelancePackagesController::class, 'update'])->name('admin.freelancer_packages.update');
        Route::get('/admin/freelancer_packages/create', [FreelancePackagesController::class, 'create'])->name('admin.freelancer_packages.create');
        Route::post('/admin/freelancer_packages/store', [FreelancePackagesController::class, 'store'])->name('admin.freelancer_packages.store');

        Route::get('/admin/employer_packages', [EmployerPackagesController::class, 'index'])->name('admin.employer_packages');
        Route::get('/admin/employer_packages/data_table', [EmployerPackagesController::class, 'data_table'])->name('admin.employer_packages.data_table');
        Route::get('/admin/employer_packages/edit/{id}', [EmployerPackagesController::class, 'edit'])->name('admin.employer_packages.edit');
        Route::put('/admin/employer_packages/update', [EmployerPackagesController::class, 'update'])->name('admin.employer_packages.update');
        Route::get('/admin/employer_packages/create', [EmployerPackagesController::class, 'create'])->name('admin.employer_packages.create');
        Route::post('/admin/employer_packages/store', [EmployerPackagesController::class, 'store'])->name('admin.employer_packages.store');

        Route::get('/admin/freelancers', [FreelancerController::class, 'index'])->name('admin.freelancers');
        Route::get('/admin/freelancers/data_table', [FreelancerController::class, 'data_table'])->name('admin.freelancers.data_table');
        Route::get('/admin/freelancers/edit/{id}', [FreelancerController::class, 'edit'])->name('admin.freelancers.edit');
        Route::put('/admin/freelancers/update', [FreelancerController::class, 'update'])->name('admin.freelancers.update');

        Route::get('/admin/employers', [EmployerController::class, 'index'])->name('admin.employers');
        Route::get('/admin/employers/data_table', [EmployerController::class, 'data_table'])->name('admin.employers.data_table');
        Route::get('/admin/employers/edit/{id}', [EmployerController::class, 'edit'])->name('admin.employers.edit');
        Route::put('/admin/employers/update', [EmployerController::class, 'update'])->name('admin.employers.update');

        Route::get('/admin/services', [ServicesController::class, 'admin_index'])->name('admin.services');
        Route::get('/admin/services/data_table', [ServicesController::class, 'data_table'])->name('admin.services.data_table');
        Route::get('/admin/services/edit/{id}', [ServicesController::class, 'admin_edit'])->name('admin.services.edit');
        Route::put('/admin/services/update', [ServicesController::class, 'update'])->name('admin.services.update');

        Route::get('/admin/addons', [AddonsController::class, 'admin_index'])->name('admin.addons');
        Route::get('/admin/addons/data_table', [AddonsController::class, 'data_table'])->name('admin.addons.data_table');

        Route::get('/admin/projects', [ProjectsController::class, 'admin_index'])->name('admin.projects');
        Route::get('/admin/projects/data_table', [ProjectsController::class, 'data_table'])->name('admin.projects.data_table');

        Route::get('/admin/skills', [SkillsController::class, 'index'])->name('admin.skills');
        Route::get('/admin/skills/data_table', [SkillsController::class, 'data_table'])->name('admin.skills.data_table');

        Route::get('/admin/service_categories', [ServiceCategoriesController::class, 'index'])->name('admin.service_categories');
        Route::get('/admin/service_categories/data_table', [ServiceCategoriesController::class, 'data_table'])->name('admin.service_categories.data_table');

        Route::get('/admin/saved_projects', [SaveProjectController::class, 'admin_index'])->name('admin.saved_projects');

        Route::get('/admin/user_permission', [UserPermissionController::class, 'permission'])->name('user_permission');
    });
    /* ----------------------------------------- END ADMIN ROUTES -------------------------------------------- */
});