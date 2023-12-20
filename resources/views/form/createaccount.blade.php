<form method="POST" class="form-outline" action="{{ route('register') }}">
  <fieldset class="form-post">
    <legend>Create an Account</legend>
    @csrf

    <input type="hidden" name="login" value="0">

    <h3 class="my-0"><label for="username"> <b class="text-red">*</b></label></h3>
    <input id="username" type="text" name="username" placeholder="New Username" value="{{ old('username') }}" required>
    @if ($errors->has('username'))
        <span class="error">
          {{ $errors->first('username') }}
      </span>
    @endif

    <h3 class="my-0"><label for="name">Display name</label></h3>
    <input id="name" type="text" name="name" placeholder="Display Name" value="{{ old('name') }}">
    @if ($errors->has('name'))
        <span class="error">
          {{ $errors->first('name') }}
      </span>
    @endif

    <h3 class="my-0"><label for="email">E-Mail Address <b class="text-red">*</b></label></h3>
    <input id="email" type="email" name="email" placeholder="example@email.com" value="{{ old('email') }}" required>
    @if ($errors->has('email'))
        <span class="error">
          {{ $errors->first('email') }}
      </span>
    @endif

    <h3 class="my-0"><label for="password">Password <b class="text-red">*</b></label></h3>
    <input id="password" type="password" placeholder="New Password" name="password" required>
    @if ($errors->has('password'))
        <span class="error">
          {{ $errors->first('password') }}
      </span>
    @endif

    <h3 class="my-0"><label for="password-confirm">Confirm Password <b class="text-red">*</b></label></h3>
    <input id="password-confirm" type="password" placeholder="Repeat Password" name="password_confirmation" required>

    <div class="flex">
    <input type="checkbox" id="member-box" name="member">
    <h3 class="my-0"><label for="member-box">Create as member?</label></h3>
    </div>
    <button class="button" type="submit">
        Register
    </button>
  </fieldset>
</form>