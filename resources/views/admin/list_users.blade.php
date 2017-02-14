@extends('layouts.admin_full')

@section('content_full')

<div class="content">
    <div id="container">
        <div id="content" role="main">

            <div class="header_actions">
                {{-- <a href="{{ route('admin.create_category') }}" class="button button-secondary">Create Category</a> --}}
            </div>

            <table>
                <thead>
                    <td>ID</td>
                    <td>Username</td>
                    <td>E-Mail Address</td>
                    <td>Name</td>
                    <td>Location</td>
                    <td>Birthdate</td>
                    <td>Gender</td>
                    <td>Image</td>
                    <td width="150">Actions</td>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->profile->firstname }} {{ $user->profile->lastname }}</td>
                            <td>{{ $user->profile->location }}</td>
                            <td>{{ $user->profile->birthdate }}</td>
                            <td>{{ $user->profile->gender }}</td>
                            <td><a href="{{ url('/images/avatars/' . $user->profile->profilepic) }}" target="_blank">{{ $user->profile->profilepic }}</a></td>
                            <td class="actions">
                                @if ($user->isBlocked())
                                    <a href="{{ route('admin.unblock_user', $user->id) }}" class="button button-secondary">Unblock</a>
                                @else
                                    <a href="{{ route('admin.block_user', $user->id) }}" class="button button-secondary">Block</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection