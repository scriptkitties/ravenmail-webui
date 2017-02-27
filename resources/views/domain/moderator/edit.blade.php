@extends('main')

@section('content')
    <form method="post" action="{{ route('domain.moderator.update', [
        'name' => $moderator->domain->name,
        'address' => $moderator->user->getAddress(),
    ]) }}">
        {{ csrf_field() }}
        {{ method_field('PUT') }}
        <fieldset>
            <div>
                <label for="admin">
                    <input id="admin" name="admin" type="checkbox">
                    Domain admin powers
                </label>
            </div>
        </fieldset>
        <div>
            <button class="button-primary" type="submit">
                <i class="fa fa-fw fa-save"></i>
                Update domain moderator
            </button>
        </div>
    </form>
@endsection

