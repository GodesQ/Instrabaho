@extends('layout.admin-layout')

@section('content')
<div class="page-wrapper">
    <div class="page-content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <form action="" class="table-responsive">
                        <table class="table table-bordered text-center">
                            <thead>
                                <tr>
                                    <th>Functionalities</th>
                                    <th>Employer</th>
                                    <th>Freelancer</th>
                                    <th>Customer Support</th>
                                    <th>Human Resource</th>
                                    <th>Admin</th>
                                    <th>Super Admin</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="" class="font-weight-bold">Services</td>
                                    <td>
                                        <input type="checkbox" name="employer" id="">
                                    </td>
                                    <td>
                                        <input type="checkbox" name="freelancer" id="">
                                    </td>
                                    <td>
                                        <input type="checkbox" name="customer_support" id="">
                                    </td>
                                    <td>
                                        <input type="checkbox" name="human_resource" id="">
                                    </td>
                                    <td>
                                        <input type="checkbox" name="admin" id="">
                                    </td>
                                    <td>
                                        <input type="checkbox" name="super_admin" id="">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="" class="font-weight-bold">Projects</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                </tr>
                                <tr>
                                    <td colspan="" class="font-weight-bold">Services Proposal</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                </tr>
                                <tr>
                                    <td colspan="" class="font-weight-bold">Projects Proposal</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                </tr>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection