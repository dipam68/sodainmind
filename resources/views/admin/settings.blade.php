@extends('admin.layout')
@section('title', 'Settings')
@section('content')

<div class="content">

    @if(Session::get('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> {{Session::get('success')}}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    @if(Session::get('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error!</strong> {{Session::get('error')}}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    <button type="button" class="btn btn-success new-plan" data-toggle="modal" data-target="#exampleModal">
        Add New Plan
    </button>
    <button type="button" class="btn btn-default trial-day"">
        Set Trial Day
    </button>

    <div class=" container-fluid">
        <div class="row">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Subscription Plans</h4>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Price ($)</th>
                                <th class="text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($plans as $key => $plan)
                            <tr>
                                <td class="text-center">{{$key +1}}</td>
                                <td>{{$plan->title}}</td>
                                <td>{{$plan->description}}</td>
                                <td>{{$plan->price}}</td>
                                <td class="td-actions text-right">
                                    <button type="button" rel="tooltip" class="btn btn-success btn-round"
                                        onclick="getPlan({{$plan->id}})">
                                        <i class="material-icons">edit</i>
                                    </button>
                                    <button type="button" rel="tooltip" class="btn btn-danger btn-round"
                                        onclick="deletePlan({{$plan->id}})">
                                        <i class="material-icons">close</i>
                                    </button>
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

<!-- Modal FORM-->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/admin/new-plan" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="exampleInputEmail1">Title</label>
                        <input type="text" value="" name="title" class="form-control title" id="exampleInputEmail1"
                            aria-describedby="emailHelp">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Price ($)</label>
                        <input type="number" value="" name="price" class="form-control price" id="exampleInputEmail1"
                            aria-describedby="emailHelp">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Description</label>
                        <textarea name="description" value="" class="form-control description"
                            id="exampleFormControlTextarea1" rows="3"></textarea>
                    </div>
                    <input type="hidden" value="" name="id" class="id" />

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
                </form>

            </div>
        </div>
    </div>
</div>

<!-- Modal Confirm Delete-->
<div class="modal fade" id="confirmDelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete Plan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure to delete this plan?</p>
                <input type="hidden" id="id-delete" value="" />
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="yesDelete()">YES</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Trial Day-->
<div class="modal fade" id="trialDay" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Set Trial Day</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="/admin/set-trial">
                    @csrf
                    <div class="form-group">
                        <label for="exampleInputEmail1">Trial Day</label>
                        <input type="number" value="" name="trial_day" class="form-control trialDay"
                            id="exampleInputEmail1" aria-describedby="emailHelp">
                        <input type="hidden" class="trialId" name="id" value="" />
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>

<script>
$('.trial-day').on("click", () => {
    $.get('/admin/get-trial', (response) => {
        $('#trialDay').modal('show')
        if (response.length > 0) {
            response.map(res => {
                $('.trialId').val(res.id)
                $('.trialDay').val(res.trial_day)
            })


        }
    })
})

$('.new-plan').on("click", () => {
    $('#exampleModalLabel').html('Add New Plan')
})

function getPlan(id) {
    $('#exampleModalLabel').html('Edit Plan')
    $.get('/admin/get-plan/' + id, (response) => {
        //put values into form
        $('.id').val(response.id)
        $('.title').val(response.title)
        $('.price').val(response.price)
        $('.description').val(response.description)
        $("#exampleModal").modal();

    })
}

function deletePlan(id) {
    $('#confirmDelete').modal('show')
    $('#id-delete').val(id)
}

function yesDelete() {
    var id = $("#id-delete").val()

    $.ajax({
        url: '/admin/delete-plan/' + id,
        type: 'DELETE',
        data: {
            'id': id,
            '_token': '{{ csrf_token() }}',
        },
        success: function(result) {
            // Do something with the 
            // if(result == 1) {
            //     alert("Successfully Remove Plan");
            // } else {
            //     alert("Failed to remove plan!")
            // }
            location.reload();

        }
    });

}
</script>
@stop