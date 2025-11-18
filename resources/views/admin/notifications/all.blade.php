@extends('admin.master')

@section('content')
    <div class="container-fluid py-3">
    <h4 class="mb-3">All Unread Notifications</h4>

    <div class="row">
        @foreach($notifications as $n)
        <div class="col-md-3 mb-3">
            <div class="p-3 border rounded bg-unread">
                <div class="fw-bold">
                    @if ($n->user_id)
                    @if ($n->user->role == 0)
                        Admin : {{ $n->user->name }}
                    @else
                        User : {{ $n->user->name }}
                    @endif
                    @else
                    User
                    @endif
                </div>
                <div class="">{{ $n->notification_for }}</div>
                <div>{{ $n->message }}</div>
                <div class="text-end small text-muted mt-2">{{ $n->created_at->diffForHumans() }}</div>
            </div>
        </div>
        @endforeach
    </div>

</div>


@endsection


@section('scripts')

@endsection