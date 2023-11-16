<article class="member" data-id="{{ $member->id }}">
    <header>
        <h2><a href="/members/{{ $member->id }}">{{ $member->persistentUser->user->username }}</a></h2>
    </header>
    {{ $member->description }}
    <form class="edit-member" method="POST" action="{{ route('update-member', ['id' => $member->id]) }}">
        @csrf
        @method('PUT')

        <input type="hidden" class="member-id" name="id" value="{{ $member->id }}">

        <label for="name-{{ $member->id }}">Name</label>
        <input id="name-{{ $member->id }}" type="text" class="name" name="name" value="{{ $member->name }}" required>

        <label for="email-{{ $member->id }}">Email</label>
        <input id="email-{{ $member->id }}" type="email" class="email" name="email" value="{{ $member->email }}" required>

        <label for="birthday-{{ $member->id }}">Birthday</label>
        <input id="birthday-{{ $member->id }}" type="text" class="birthday" name="birthday" value="{{ $member->birthday }}" required>

        <label for="description-{{ $member->id }}">Description</label>
        <input id="description-{{ $member->id }}" type="text" class="description" name="description" value="{{ $member->description }}" required>

        <input type="submit" id="submit-{{ $member->id }}" value="Edit Profile">
    </form>
</article>