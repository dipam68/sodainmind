@extends('admin.layout')
@section('title', 'User Dashboard')
@section('content')

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">My Subscription</h4>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Join Date</th>
                                <th>Subsription</th>
                                @if($data[0]->is_trial == 1)
                                <th>Trial End</th>
                                @endif
                                <th class="text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    {{$data[0]->created_at}}
                                </td>
                                <td>
                                    {{$data[0]->title}}
                                </td>
                                @if($data[0]->is_trial == 1)
                                <td>
                                    {{$data[0]->trial_end}}
                                </td>
                                @endif
                                <td class="text-right">
                                    @if($data[0]->is_trial == 1)
                                    <button type="button" class="btn btn-success" onclick="upgrade({{$data[0]->id}})">
                                        Upgrade Plan
                                    </button>
                                    @endif
                                    @if($data[0]->is_trial == 0)
                                    <button type="button" class="btn btn-danger" onclick="cancel({{$data[0]->id}})">
                                        Cancel Subscription
                                    </button>
                                    @endif
                                </td>
                            </tr>
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
                <h5 class="modal-title" id="exampleModalLabel">Upgrade Plan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h3>{{$data[0]->title}}</h3>
                <h3>${{$data[0]->price}}</h3>
                <form action="/pay-upgrade" method="POST">
                    @csrf
                    <script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                        data-key="{{env('STRIPE_KEY')}}" data-amount="{{$data[0]->price}}00"
                        data-name="{{$data[0]->title}} Membership" data-description="Argon Membership"
                        data-image="https://stripe.com/img/documentation/checkout/marketplace.png" data-local="auto"
                        data-currency="usd">
                    </script>
                    <input type="hidden" name="id_user" value="{{$data[0]->id_user}}" />
                    <input type="hidden" name="email" value="{{$data[0]->email}}" />
                    <input type="hidden" name="description" value="Upgrade Subscripton for {{$data[0]->title}}" />
                    <input type="hidden" name="amount" value="{{$data[0]->price}}" />
                </form>

            </div>
        </div>
    </div>
</div>

<!-- Modal cancel-->
<div class="modal fade" id="cancelModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cancel Membership</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure to cancel this membership?</p>
                <input type="hidden" id="id-delete" value="" />
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="yesDelete('{{$data[0]->id_user}}')">YES</button>
            </div>
        </div>
    </div>
</div>

<script>
function cancel(idplan) {
    $("#cancelModal").modal()
}

function yesDelete(id) {
    $.ajax({
        url: '/cancel-plan/',
        type: 'PUT',
        data: {
            'id_user': id,
            'email': '{{$data[0]->email}}',
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

function upgrade(idplan) {
    // alert(idplan)
    $("#exampleModal").modal()

}
</script>
@stop