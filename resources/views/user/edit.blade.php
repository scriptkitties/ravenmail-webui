@extends('main')

@section('content')
    <form method="post" action="{{ route('user.update', ['user' => $user->getAddress()]) }}">
    {{ csrf_field() }}
    <fieldset>
        <div>
            <label for="password">New password</label>
            <input id="password" name="password" type="password">
        </div>
        <div>
            <label for="password-verify">Repeat new password</label>
            <input id="password-verify" name="password-verify" type="password">
        </div>
    </fieldset>
    <div>
        <button class="button-primary" type="submit">
            <i class="fa fa-fw fa-save"></i>
            Update password
        </button>
    </div>
</form>
@endsection

