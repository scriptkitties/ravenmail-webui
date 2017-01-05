@extends('main')

@section('content')
<form class="pure-form pure-form-stacked" method="post" action="{{ route('registration.store') }}">
    {{ csrf_field() }}
    <fieldset>
        <div class="pure-control-group">
            <label for="local">Local part</label>
            <input id="local" name="local" type="text" required>
        </div>
        <div class="pure-control-group">
            <label for="domain">Domain name</label>
            <select id="domain" name="domain" required>
                @foreach($domains as $domain)
                    <option valua="{{ $domain->name }}">{{ $domain->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="pure-control-group">
            <label for="password">Password</label>
            <input id="password" name="password" type="password" required>
        </div>
        <div class="pure-control-group">
            <label for="password-verify">Verify password</label>
            <input id="password-verify" name="password-verify" type="password" required>
        </div>
    </fieldset>
    <fieldset>
        <div class="pure-control-group">
            <label for="accept-tos">
                <input id="accept-tos" name="accept-tos" type="checkbox" required>
                I have read and accept the <a href="{{ route('legal.tos') }}">Terms of Service</a>
            </label>
        </div>
    </fieldset>
    <fieldset>
        <div class="pure-control-group">
            <label for="captcha">
                Captcha<br>
                {!! captcha_img() !!}
                <input id="captcha" name="captcha" type="text" required>
            </label>
        </div>
    </fieldset>
    <div class="pure-control-group">
        <div class="content-center">
            <button class="pure-button" type="submit">
                <i class="fa fa-fw fa-save"></i>
                Register
            </button>
        </div>
    </div>
</form>
@endsection

