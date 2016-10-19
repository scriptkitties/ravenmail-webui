@extends('main')

@section('content')
<h2>Domains</h2>
<a href="{{ route('domains.create') }}"><i class="fa fa-plus"></i> Add domain</a>
<table>
    <thead>
        <tr>
            <th>Domain name</th>
            <th>Users</th>
            <th>Aliases</th>
            <th>Public domain</th>
        <tr>
    </thead>
    <tbody>
        @foreach($domains as $domain)
            <tr>
                <td>
                    <a href="{{ URL::route('domains.show', ['name' => $domain->name]) }}">{{ $domain->name }}</a>
                </td>
                <td>
                    {{ $domain->users()->count() }}
                </td>
                <td>
                    {{ $domain->aliases()->count() }}
                </td>
                <td>
                    @if($domain->public)
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

