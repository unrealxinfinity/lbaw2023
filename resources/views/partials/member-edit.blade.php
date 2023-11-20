<article class="member" data-id="{{ $member->id }}">
    <p><a href="/">Home</a> > <a href="/members/{{$member->persistentUser->user->username}}">{{$member->persistentUser->user->username}}</a> > <a href="/members/{{$member->persistentUser->user->username}}/edit">Edit Profile</a></p>
    <header>
        <h2><a href="/members/{{ $member->persistentUser->user->username }}">{{ $member->persistentUser->user->username }}</a></h2>
    </header>
    {{ $member->description }}
    <form class="edit-member" method="POST" action="{{ route('update-member', ['username' => $member->persistentUser->user->username]) }}">
        @csrf
        @method('PUT')

        <input type="hidden" class="member-id" name="id" value="{{ $member->id }}">

        @if ($errors->has('username'))
            <span class="error">
                {{ $errors->first('username') }}
            </span>
        @endif
        <label for="username-{{ $member->id }}">Username</label>
        <input id="username-{{ $member->id }}" type="text" class="username" name="username" value="{{ $member->persistentUser->user->username }}" required>

        @if ($errors->has('name'))
            <span class="error">
                {{ $errors->first('name') }}
            </span>
        @endif
        <label for="name-{{ $member->id }}">Name</label>
        <input id="name-{{ $member->id }}" type="text" class="name" name="name" value="{{ $member->name }}" required>

        @if ($errors->has('email'))
            <span class="error">
                {{ $errors->first('email') }}
            </span>
        @endif
        <label for="email-{{ $member->id }}">Email</label>
        <input id="email-{{ $member->id }}" type="email" class="email" name="email" value="{{ $member->email }}" required>

        @if ($errors->has('birthday'))
            <span class="error">
                {{ $errors->first('birthday') }}
            </span>
        @endif
        <label for="birthday-{{ $member->id }}">Birthday</label>
        <input id="birthday-{{ $member->id }}" type="text" class="birthday" name="birthday" value="{{ $member->birthday }}" required>

        @if ($errors->has('description'))
            <span class="error">
                {{ $errors->first('description') }}
            </span>
        @endif
        <label for="description-{{ $member->id }}">Description</label>
        <input id="description-{{ $member->id }}" type="text" class="description" name="description" value="{{ $member->description }}" required>

        @if ($errors->has('password'))
            <span class="error">
                {{ $errors->first('password') }}
            </span>
        @endif
        <label for="password-{{ $member->id }}">New Password</label>
        <input id="password-{{ $member->id }}" type="password" class="password" name="password">

        @if ($errors->has('password_confirmation'))
            <span class="error">
                {{ $errors->first('password_confirmation') }}
            </span>
        @endif
        <label for="password_confirmation-{{ $member->id }}">Confirm New Password</label>
        <input id="password_confirmation-{{ $member->id }}" type="password" class="password_confirmation" name="password_confirmation">

        @if ($errors->has('old_password'))
            <span class="error">
                {{ $errors->first('old_password') }}
            </span>
        @endif
        @if (Auth::user()->persistentUser->type_=='Administrator')
            <label type ="hidden" for="old_password-{{ $member->id }}"></label>
            <input type ="hidden" id="old_password-{{ $member->id }}" type="password" class="old_password" name="old_password" value="{{ $member->persistentUser->user->password }}" required>
        @else
            <label for="old_password-{{ $member->id }}">Old Password</label>
            <input id="old_password-{{ $member->id }}" type="password" class="old_password" name="old_password" required>
        @endif

        <input type="submit" id="submit-{{ $member->id }}" value="Edit Profile">
    </form>
</article>