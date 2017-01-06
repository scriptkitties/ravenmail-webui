@extends('main')

@section('content')
    <form method="post" action="{{ route('user.update', ['user' => $user->getAddress()]) }}" class="pure-form pure-form-stacked">
    {{ csrf_field() }}
    <fieldset>
        <div class="pure-control-group">
            <label for="password">New password</label>
            <input id="password" name="password" type="password">
        </div>
        <div class="pure-control-group">
            <label for="password-verify">Repeat new password</label>
            <input id="password-verify" name="password-verify" type="password">
        </div>
    </fieldset>
    <div class="pure-control-group">
        <button class="pure-button" type="submit">
            <i class="fa fa-fw fa-save"></i>
            Update password
        </button>
    </div>
</form>
@endsection

