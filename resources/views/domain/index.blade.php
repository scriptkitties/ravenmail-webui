@extends('main')

@section('content')
<h1>Domains</h1>
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
                <td>NYI</td>
                <td>NYI</td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection

