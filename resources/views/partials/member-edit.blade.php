<article class="member" data-id="{{ $member->id }}">
    <p><a href="/">Home</a> > <a href="/members/{{$member->persistentUser->user->username}}">{{$member->persistentUser->user->username}}</a> > <a href="/members/{{$member->persistentUser->user->username}}/edit">Edit Profile</a></p>
    <header>
        <h2><a href="/members/{{ $member->persistentUser->user->username }}">{{ $member->persistentUser->user->username }}</a></h2>
    </header>
    {{ $member->description }}
    <form class="edit-member" method="POST" action="{{ route('update-member', ['id' => $member->id]) }}">
        @csrf
        @method('PUT')

        <input type="hidden" class="member-id" name="id" value="{{ $member->id }}">

        <label for="username-{{ $member->id }}">Username</label>
        <input id="username-{{ $member->id }}" type="text" class="username" name="username" value="{{ $member->persistentUser->user->username }}" required>

        <label for="name-{{ $member->id }}">Name</label>
        <input id="name-{{ $member->id }}" type="text" class="name" name="name" value="{{ $member->name }}" required>

        <label for="email-{{ $member->id }}">Email</label>
        <input id="email-{{ $member->id }}" type="email" class="email" name="email" value="{{ $member->email }}" required>

        <label for="birthday-{{ $member->id }}">Birthday</label>
        <input id="birthday-{{ $member->id }}" type="text" class="birthday" name="birthday" value="{{ $member->birthday }}" required>

        <label for="description-{{ $member->id }}">Description</label>
        <input id="description-{{ $member->id }}" type="text" class="description" name="description" value="{{ $member->description }}" required>

        <label for="password-{{ $member->id }}">New Password</label>
        <input id="password-{{ $member->id }}" type="password" class="password" name="password">

        <label for="password_confirmation-{{ $member->id }}">Confirm New Password</label>
        <input id="password_confirmation-{{ $member->id }}" type="password" class="password_confirmation" name="password_confirmation">
        
        @if (Auth::user()->persistentUser->type_=='Administrator')
            <label type ="hidden" for="old_password-{{ $member->id }}"></label>
            <input type ="hidden" id="old_password-{{ $member->id }}" type="password" class="old_password" name="old_password" value="{{ $member->persistentUser->user->password }}" required>
        @else
            <label for="old_password-{{ $member->id }}">Old Passowrd</label>
            <input id="old_password-{{ $member->id }}" type="password" class="old_password" name="old_password" required>
        @endif

        <input type="submit" id="submit-{{ $member->id }}" value="Edit Profile">
    </form>
</article>