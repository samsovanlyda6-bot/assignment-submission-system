@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Notifications</h5>
                    <div>
                        <form action="{{ route('notifications.markAllAsRead') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-primary">Mark All as Read</button>
                        </form>
                        <form action="{{ route('notifications.destroyAll') }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete all notifications?')">Delete All</button>
                        </form>
                    </div>
                </div>

                <div class="card-body">
                    @if($notifications->count() > 0)
                        <div class="list-group">
                            @foreach($notifications as $notification)
                                <div class="list-group-item list-group-item-action {{ !$notification->is_read ? 'bg-light' : '' }}">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-1">{{ $notification->title }}</h6>
                                            <p class="mb-1 text-muted">{{ $notification->message }}</p>
                                            <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                        </div>
                                        <div>
                                            @if(!$notification->is_read)
                                                <form action="{{ route('notifications.markAsRead', $notification->notification_id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm btn-success">Mark Read</button>
                                                </form>
                                            @endif
                                            <form action="{{ route('notifications.destroy', $notification->notification_id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this notification?')">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-3">
                            {{ $notifications->links() }}
                        </div>
                    @else
                        <p class="text-muted text-center mb-0">No notifications found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection