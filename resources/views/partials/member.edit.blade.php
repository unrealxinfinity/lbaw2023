<article class="member" data-id="{{ $member->id }}">
    <header>
        <h2><a href="/members/{{ $member->id }}">{{ $member->persistentUser->user->username }}</a></h2>
    </header>
    {{ $member->description }}
    <form class="edit-member">
        {{ csrf_field() }}
        <label for="username-{{ $member->id }}">Username</label>
        <input id="username-{{ $member->id }}" type="text" name="username" value="{{ $member->username }}" required>

        <label for="email-{{ $member->id }}">Email</label>
        <input id="email-{{ $member->id }}" type="email" name="email" value="{{ $member->email }}" required>

        <label for="birthday-{{ $member->id }}">Birthday</label>
        <input id="birthday-{{ $member->id }}" type="text" name="birthday" value="{{ $member->birthday }}" required>

        <label for="description-{{ $member->id }}">Description</label>
        <input id="description-{{ $member->id }}" type="text" name="description" value="{{ $member->description }}" required>

        <button type="button" id="submit-{{ $member->id }}">Edit Profile</button>
    </form>
</article>