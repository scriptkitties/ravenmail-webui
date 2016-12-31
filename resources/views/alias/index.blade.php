@extends('main')

@section('content')
<h2>Aliases</h2>
<section>
    <p>
        <a class="pure-button" href="{{ route('aliases.create', ['domain' => $domain]) }}"><i class="fa fa-plus"></i> Add alias</a>
    </p>
</section>
<table class="pure-table pure-table-striped">
    <thead>
        <tr>
            <th>Origin</th>
            <th>Destination</th>
        </tr>
    </thead>
    <tbody>
        @foreach($aliases as $alias)
            <tr>
                <td>{{ $alias->getAddress() }}</td>
                <td>{{ $alias->destination }}</td>
                <td>
                    <form method="post" action="{{ route('aliases.destroy', ['domain' => $alias->domain, 'address' => $alias->getAddress()]) }}">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <button class="pure-button" type="submit">
                            <i class="fa fa-fw fa-trash"></i>
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection

