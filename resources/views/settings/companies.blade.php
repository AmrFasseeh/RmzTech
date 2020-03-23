@extends('Master.layout')
@section('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('public/app-assets/vendors/css/extensions/sweetalert.css') }}">
@endsection
@section('content')
<div class="app">
    <div class="app-content container center-layout mt-2">
        <div class="row">
            <div class="col-10">
                <h2>Companies</h2>
                <hr>
            </div>
            <div class="col-2">
                <button class="btn btn-primary btn-md " data-toggle="modal" data-target="#AddContactModal"><i
                        class="d-md-none d-block ft-plus white"></i>
                    <span class="d-md-block d-none">Add Company</span></button>
                <div class="modal fade" id="AddContactModal" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel1" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <section class="contact-form">
                                <form id="form-add-company" class="contact-input" action="{{ route('add.company') }}"
                                    method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel1">Add New
                                            Contact</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <fieldset class="form-group col-12">
                                            <input type="text" id="company-name" class="contact-name form-control"
                                                placeholder="Name" name="name">
                                        </fieldset>
                                        <fieldset class="form-group col-12">
                                            <input type="text" id="company-api" class="contact-email form-control"
                                                placeholder="Api-link" name="api_url">
                                        </fieldset>
                                        <fieldset class="form-group col-12">
                                            <input type="text" id="company-phone" class="contact-phone form-control"
                                                placeholder="Phone Number" name="phone">
                                        </fieldset>
                                        <fieldset class="form-group col-12">
                                            <input type="text" id="company-address" class="contact-phone form-control"
                                                placeholder="Addresss" name="address">
                                        </fieldset>
                                        <fieldset class="form-group col-12">
                                            <input type="file" class="form-control-file" id="company-image"
                                                name="image">
                                        </fieldset>
                                    </div>
                                    <div class="modal-footer">
                                        <fieldset class="form-group position-relative has-icon-left mb-0">
                                            <button type="submit" id="add-company-item"
                                                class="btn btn-info add-contact-item"><i
                                                    class="la la-paper-plane-o d-block d-lg-none"></i>
                                                <span class="d-none d-lg-block">Add
                                                    New</span></button>
                                        </fieldset>
                                    </div>
                                </form>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <!-- File export table -->
                <section id="file-export">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-content collapse show">
                                    <div class="card-body card-dashboard dataTables_wrapper dt-bootstrap">
                                        <p class="card-text">Companies list</p>
                                        <div class="table-responsive">
                                            <table
                                                class="table table-striped table-bordered file-export nowrap scroll-horizontal">
                                                <thead>
                                                    <tr>
                                                        <th>Image</th>
                                                        <th>Name</th>
                                                        <th>Api</th>
                                                        <th>Phone</th>
                                                        <th>Address</th>
                                                        <th>Joined at</th>
                                                        <th>Key</th>
                                                        <th>Edit/Delete</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if (!$companies->isEmpty())
                                                    @foreach ($companies as $company)
                                                    <tr>
                                                        <td><img style="width: 64px;height: 64px;"
                                                                src="{{ ($company->image === null) ? url('/').'/public/storage/user_images/default-user.jpg':$company->image->url() }}"
                                                                alt=""></td>
                                                        <td>{{ $company->name }}</td>
                                                        <td>{{ $company->api_url }}</td>
                                                        <td>{{ $company->phone }}</td>
                                                        <td>{{ $company->address }}</td>
                                                        <td>{{ Carbon\Carbon::make($company->created_at)->toDateString() }}
                                                        </td>
                                                        <td><button class="btn btn-success btn-md " data-toggle="modal"
                                                                data-target="#ShowCompanyKey{{$company->id}}"><i
                                                                    class="d-md-none d-block ft-plus white"></i>
                                                                <span class="d-md-block d-none">Show</span></button>
                                                            <div class="modal fade" id="ShowCompanyKey{{$company->id}}"
                                                                tabindex="-1" role="dialog"
                                                                aria-labelledby="exampleModalLabel1" aria-hidden="true">
                                                                <div class="modal-dialog" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <p>Key:</p>
                                                                            <br>
                                                                            <h3 class="modal-title"
                                                                                id="exampleModalLabel1">
                                                                                {{ $company->company_key }}</h3>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div
                                                                style="display:flex;height:39px;justify-content:center;">
                                                                <button class="btn btn-success btn-glow"
                                                                    style="margin-right: 5%;" data-toggle="modal"
                                                                    data-target="#EditContactModal"><i
                                                                        class="d-md-none d-block ft-plus white"></i>
                                                                    <span class="d-md-block d-none">Edit</span></button>
                                                                <div class="modal fade" id="EditContactModal"
                                                                    tabindex="-1" role="dialog"
                                                                    aria-labelledby="exampleModalLabel1"
                                                                    aria-hidden="true">
                                                                    <div class="modal-dialog" role="document">
                                                                        <div class="modal-content">
                                                                            <section class="contact-form">
                                                                                <form id="form-edit-company"
                                                                                    class="contact-input"
                                                                                    action="{{ route('update.company', ['company' => $company]) }}"
                                                                                    method="POST"
                                                                                    enctype="multipart/form-data">
                                                                                    @csrf
                                                                                    <div class="modal-header">
                                                                                        <h5 class="modal-title"
                                                                                            id="exampleModalLabel1">Edit
                                                                                            Company Details</h5>
                                                                                        <button type="button"
                                                                                            class="close"
                                                                                            data-dismiss="modal"
                                                                                            aria-label="Close">
                                                                                            <span
                                                                                                aria-hidden="true">&times;</span>
                                                                                        </button>
                                                                                    </div>
                                                                                    <div class="modal-body">
                                                                                        <fieldset
                                                                                            class="form-group col-12">
                                                                                            <input type="text"
                                                                                                id="company-name"
                                                                                                class="contact-name form-control"
                                                                                                placeholder="Name"
                                                                                                name="name"
                                                                                                value="{{ $company->name }}">
                                                                                        </fieldset>
                                                                                        <fieldset
                                                                                            class="form-group col-12">
                                                                                            <input type="text"
                                                                                                id="company-api"
                                                                                                class="contact-email form-control"
                                                                                                placeholder="Api-link"
                                                                                                name="api_url"
                                                                                                value="{{ $company->api_url }}">
                                                                                        </fieldset>
                                                                                        <fieldset
                                                                                            class="form-group col-12">
                                                                                            <input type="text"
                                                                                                id="company-phone"
                                                                                                class="contact-phone form-control"
                                                                                                placeholder="Phone Number"
                                                                                                name="phone"
                                                                                                value="{{ $company->phone }}">
                                                                                        </fieldset>
                                                                                        <fieldset
                                                                                            class="form-group col-12">
                                                                                            <input type="text"
                                                                                                id="company-address"
                                                                                                class="contact-phone form-control"
                                                                                                placeholder="Addresss"
                                                                                                name="address"
                                                                                                value="{{ $company->address }}">
                                                                                        </fieldset>
                                                                                        <fieldset
                                                                                            class="form-group col-12">
                                                                                            <input type="file"
                                                                                                class="form-control-file"
                                                                                                id="company-image"
                                                                                                name="image">
                                                                                        </fieldset>
                                                                                    </div>
                                                                                    <div class="modal-footer">
                                                                                        <fieldset
                                                                                            class="form-group position-relative has-icon-left mb-0">
                                                                                            <button type="submit"
                                                                                                id="edit-company-item"
                                                                                                class="btn btn-info add-contact-item"><i
                                                                                                    class="la la-paper-plane-o d-block d-lg-none"></i>
                                                                                                <span
                                                                                                    class="d-none d-lg-block">Submit</span></button>
                                                                                        </fieldset>
                                                                                    </div>
                                                                                </form>
                                                                            </section>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <form id="delete-company-form" method="POST"
                                                                    class="fm-inline"
                                                                    action="{{ route('delete.company', ['company' => $company->id]) }}">
                                                                    @csrf
                                                                    {{-- @method('DELETE') --}}
                                                                    <button type="button"
                                                                        class="btn btn-danger btn-glow"
                                                                        id="cancel-button"><i
                                                                            class="la la-remove"></i></button>
                                                                </form>
                                                            </div>
                                                        </td>

                                                    </tr>
                                                    @endforeach
                                                    @else
                                                    <tr>
                                                        <td>No companies regestered!</td>
                                                    </tr>
                                                    @endif

                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th>Image</th>
                                                        <th>Name</th>
                                                        <th>Api</th>
                                                        <th>Phone</th>
                                                        <th>Address</th>
                                                        <th>Joined at</th>
                                                        <th>Key</th>
                                                        <th>Edit/Delete</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- File export table -->
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="{{ asset('/public/app-assets/vendors/js/tables/datatable/datatables.min.js') }}"></script>
<script src="{{ asset('/public/app-assets/vendors/js/tables/datatable/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('/public/app-assets/vendors/js/tables/buttons.flash.min.js') }}"></script>
<script src="{{ asset('/public/app-assets/vendors/js/tables/jszip.min.js') }}"></script>
<script src="{{ asset('/public/app-assets/vendors/js/tables/pdfmake.min.js') }}"></script>
<script src="{{ asset('/public/app-assets/vendors/js/tables/vfs_fonts.js') }}"></script>
<script src="{{ asset('/public/app-assets/vendors/js/tables/buttons.html5.min.js') }}"></script>
<script src="{{ asset('/public/app-assets/vendors/js/tables/buttons.print.min.js') }}"></script>
<script src="{{ asset('/public/app-assets/js/scripts/tables/datatables/datatable-advanced.min.js') }}"></script>
<script src="{{ asset('/public/app-assets/vendors/js/extensions/sweetalert.min.js') }}"></script>
{{-- <script src="../../../app-assets/vendors/js/extensions/sweetalert.min.js"></script> --}}
{{-- <script src="../../../app-assets/js/scripts/extensions/sweet-alerts.min.js"></script> --}}
<script>
    $(document).ready(function () {
        $("button#cancel-button").on("click", function () {
            console.log('clicked');
            
        swal({
            title: "Are you sure?",
            text: "You will not be able to recover this Company!",
            icon: "warning",
            buttons: {
                cancel: {
                    text: "No, cancel!",
                    value: null,
                    visible: !0,
                    className: "",
                    closeModal: !1
                },
                confirm: {
                    text: "Yes, delete it!",
                    value: !0,
                    visible: !0,
                    className: "",
                    closeModal: !1
                }
            }
        }).then(e => {
            if(e){
                $('#delete-company-form').submit();
                swal("Deleted!", "Company has been deleted.", "success")
            } else {
                swal("Cancelled", "Your Company is safe", "error")
            }
            // e ? swal("Deleted!", "Company has been deleted.", "success") : swal("Cancelled", "Your Company is safe", "error")
        })
    })
    })
   
</script>
@endsection