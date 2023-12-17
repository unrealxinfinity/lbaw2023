<form class="form-post outline-none" id="transfer-ownership" method="POST" action="{{ route('transfer-world', ['id' => $world->id]) }}">
    @csrf

    <label> Select a new owner:
    <select name="owner" class="type" required>
        @foreach ($members as $member)
            <option value="{{ $member->id }}">{{ $member->persistentUser->user->username }}</option>
        @endforeach
    </select>
    </label>
    <input class="button" type="submit" value="Transfer">
</form>