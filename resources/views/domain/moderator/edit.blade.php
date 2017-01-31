@extends('main')

@section('content')
    <form method="post" action="{{ route('domain.moderator.update', [
        'name' => $moderator->domain->name,
        'address' => $moderator->user->getAddress(),
    ]) }}" class="pure-form pure-form-stacked">
        {{ csrf_field() }}
        {{ method_field('PUT') }}
        <fieldset>
            <div class="pure-control-group">
                <label class="pure-checkbox" for="admin">
                    <input id="admin" name="admin" type="checkbox">
                    Domain admin powers
                </label>
            </div>
        </fieldset>
        <div class="pure-control-group">
            <button class="pure-button" type="submit">
                <i class="fa fa-fw fa-save"></i>
                Update domain moderator
            </button>
        </div>
    </form>
@endsection

