<form method="POST" action="{{ route('register') }}">
    @csrf

    <input type="hidden" name="login" value="0">

    <label for="username">Username</label>
    <input id="username" type="text" name="username" value="{{ old('username') }}" required autofocus>
    @if ($errors->has('username'))
        <span class="error">
          {{ $errors->first('username') }}
      </span>
    @endif

    <label for="name">Display name</label>
    <input id="name" type="text" name="name" value="{{ old('name') }}">
    @if ($errors->has('name'))
        <span class="error">
          {{ $errors->first('name') }}
      </span>
    @endif

    <label for="email">E-Mail Address</label>
    <input id="email" type="email" name="email" value="{{ old('email') }}" required>
    @if ($errors->has('email'))
        <span class="error">
          {{ $errors->first('email') }}
      </span>
    @endif

    <label for="password">Password</label>
    <input id="password" type="password" name="password" required>
    @if ($errors->has('password'))
        <span class="error">
          {{ $errors->first('password') }}
      </span>
    @endif

    <label for="password-confirm">Confirm Password</label>
    <input id="password-confirm" type="password" name="password_confirmation" required>

    <label for="member-box">Create as member?</label>
    <input type="checkbox" id="member-box" name="member">

    <button type="submit">
        Register
    </button>
</form>