@extends('main')

@section('content')
<form method="post" action="{{ route('user.store') }}">
    {{ csrf_field() }}
    <fieldset>
        <div>
            <label for="local">Local part</label>
            <input id="local" name="local" type="text" value="{{ old('local') }}" required>
        </div>
        <div>
            <label for="domain">Domain name</label>
            <select id="domain" name="domain" required>
                @foreach($domains as $domain)
                    <option valua="{{ $domain->name }}">{{ $domain->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="password">Password</label>
            <input id="password" name="password" type="password" value="{{ old('password') }}" required>
        </div>
        <div>
            <label for="password-verify">Verify password</label>
            <input id="password-verify" name="password-verify" type="password" value="{{ old('password') }}" required>
        </div>
    </fieldset>
    <fieldset>
        <div>
            <label for="accept-tos">
                <input id="accept-tos" name="accept-tos" type="checkbox" required>
                I have read and accept the <a href="{{ route('legal.tos') }}">Terms of Service</a>
            </label>
        </div>
    </fieldset>
    <fieldset>
        <div>
            <label for="captcha">
                Captcha<br>
                {!! captcha_img() !!}
                <input id="captcha" name="captcha" type="text" required>
            </label>
        </div>
    </fieldset>
    <div class="content-center">
        <button class="button-primary" type="submit">
            <i class="fa fa-fw fa-save"></i>
            Register
        </button>
    </div>
</form>
@endsection

