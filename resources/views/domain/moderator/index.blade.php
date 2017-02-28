@extends('main')

@section('content')
    <h2>Moderators of {{ $domain->name }}</h2>
    <section>
        <p>
            <a href="{{ route('domain.moderator.create', ['domain' => $domain->name]) }}">
                <i class="fa fa-plus"></i>
                Add moderator
            </a>
        </p>
    </section>
    <table>
        <thead>
            <tr>
                <th>User</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($moderators as $moderator)
                <tr>
                    <td>
                        <a href="{{ route('domain.user.show', ['domain' => $domain->name, 'user' => $moderator->user->getAddress()]) }}">
                            {{ $moderator->user->getAddress() }}
                        </a>
                        @if($moderator->admin)
                            <i class="fa fa-fw fa-star"></i>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('domain.moderator.edit', [
                            'name' => $domain->name,
                            'address' => $moderator->user->getAddress(),
                        ]) }}">
                            <i class="fa fa-fw fa-pencil"></i>
                            Edit
                        </a>
                        <form method="post" action="{{ route('domain.moderator.destroy', [
                            'domain' => $domain->name,
                            'moderator' => $moderator->user->getAddress()
                        ]) }}" style="display: inline">
                            {{ csrf_field() }}
                            {{ method_field('delete') }}
                            <button class="button-primary" type="submit">
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

