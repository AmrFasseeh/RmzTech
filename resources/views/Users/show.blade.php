@extends('Master.layout')
@section('content')
<div class="row">

    <!-- File export table -->
    <section id="file-export">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Users Table</h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                <li><a data-action="close"><i class="ft-x"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-content collapse show">
                        <div class="card-body card-dashboard dataTables_wrapper dt-bootstrap">
                            <p class="card-text">You can export users info to any of those extensions PDF, CSV,
                                EXCEL.</p>
                            <table class="table table-striped table-bordered file-export">
                                <thead>
                                    <tr>
                                        <th>User Avatar</th>
                                        <th>Name</th>
                                        <th>User Name</th>
                                        <th>Phone Number</th>
                                        <th>Email</th>
                                        <th>Joined at</th>
                                        <th>Edit/Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                    <tr>
                                        @if (isset($user->image))
                                        <td><img src="{{ $user->image->url() }}" alt=""
                                                style="width: 64px;height: 64px;"></td>
                                        @else
                                        <td></td>
                                        @endif

                                        <td><a
                                                href="{{ route('show.single', ['user'=>$user->id]) }}">{{ $user->fullname }}</a>
                                        </td>
                                        <td>{{ $user->username }}</td>
                                        <td>{{ $user->phone }}</td>
                                        <td>{{ $user->email }}</td>
                                        @if (isset($user->time_user))
                                        <td>{{ Carbon\Carbon::make($user->time_user)->isoFormat('MMMM Do, YYYY') }}
                                        </td>
                                        @else
                                        <td>Join date not set!
                                        </td>
                                        @endif
                                        <td><div style="display:flex;height:39px;justify-content:center;">
                                            <a href="{{ route('edit.user', ['user' => $user->id]) }}" class="btn btn-success btn-glow" style="margin-right: 5%;"><i class="la la-edit"></i></a> 
                                            @can('delete', $user)
                                            <form method="POST" class="fm-inline" action="{{ route('delete.user', ['user' => $user->id]) }}">
                                                @csrf
                                                {{-- @method('DELETE') --}}
                                
                                                <button type="submit" value="" class="btn btn-danger btn-glow"><i class="la la-remove"></i></button>
                                            </form>
                                            @endcan</div></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>User Avatar</th>
                                        <th>Name</th>
                                        <th>User Name</th>
                                        <th>Phone Number</th>
                                        <th>Email</th>
                                        <th>Joined at</th>
                                        <th>Edit/Delete</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- File export table -->
@endsection
@include('Users.scripts')