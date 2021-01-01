@extends('admin.layout')
@section('title', 'Admin Dashboard')
@section('content')

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Registered User</h4>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Subsription</th>
                                <th>Join Date</th>
                                <th>Status</th>
                                <!-- <th class="text-right">Actions</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $key => $user)
                            <tr>
                                <td class="text-center">{{$key +1}}</td>
                                <td>{{$user->username}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->is_trial == 1 ? "Trial, " : ""}} {{$user->title}}</td>
                                <td>{{$user->created_at}}</td>
                                <td>{{$user->is_active == 0 ? "Inactive" : "Active"}}</td>
                                <!-- <td class="td-actions text-right">
                                    <button type="button" rel="tooltip" class="btn btn-info btn-round">
                                        <i class="material-icons">person</i>
                                    </button>
                                    <button type="button" rel="tooltip" class="btn btn-success btn-round">
                                        <i class="material-icons">edit</i>
                                    </button>
                                    <button type="button" rel="tooltip" class="btn btn-danger btn-round">
                                        <i class="material-icons">close</i>
                                    </button> -->
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@stop