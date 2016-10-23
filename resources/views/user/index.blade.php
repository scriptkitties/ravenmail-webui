@extends('main')

@section('content')
<h2>Users on {{ $domain->name }}</h2>
<a href="{{ route('users.create', ['domain' => $domain->name]) }}">
    <i class="fa fa-plus"></i> Add user
</a>
<table>
    <thead>
        <tr>
            <th>Email address</th>
            <th>Admin</th>
            <th>Active</th>
        </tr>
    </thead>
    <tbody>
        @foreach($domain->users()->get() as $user)
            <tr>
                <td>
                    <a href="{{ route('users.show', ['domain' => $domain->name, 'address' => $user->getAddress()]) }}">
                        {{ $user->getAddress() }}
                    </a>
                </td>
                <td>
                    @if($user->admin)
                        <i class="fa fa-fw fa-check-square-o"></i>
                    @else
                        <i class="fa fa-fw fa-square-o"></i>
                    @endif
                </td>
                <td>
                    @if($user->active)
                        <i class="fa fa-fw fa-check-square-o"></i>
                    @else
                        <i class="fa fa-fw fa-square-o"></i>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection

