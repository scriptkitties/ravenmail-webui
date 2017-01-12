@extends('main')

@section('content')
<h2>Aliases</h2>
<section>
    <p>
        @if(!$user->admin && $user->aliases()->count() > $max)
            You have reached the maximum number of aliases for your account.
        @else
            <a class="pure-button" href="{{ route('user.alias.create', ['user' => $user->getAddress()]) }}">
                <i class="fa fa-plus"></i>
                Add alias
            </a>
        @endif
    </p>
</section>
<table class="pure-table pure-table-striped">
    <thead>
        <tr>
            <th>Destination</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($aliases as $alias)
            <tr>
                <td>
                    {{ $alias->destination }}
                    @if(!$alias->active)
                        <i class="fa fa-fw fa-exclamation-circle"></i>
                    @endif
                </td>
                <td>
                    <form method="post" action="{{ route('user.alias.destroy', ['user' => Auth::user()->getAddress(), 'alias' => $alias->id]) }}">
                        {{ csrf_field() }}
                        {{ method_field('delete') }}
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

