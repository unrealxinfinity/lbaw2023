<form class="form-post" id="transfer-ownership" method="POST" action="{{ route('transfer-world', ['id' => $world->id]) }}">
    @csrf
    <select name="id" class="type" required>
        @foreach ($members as $member)
            <option value="{{ $member->id }}">{{ $member->persistentUser->user->username }}</option>
        @endforeach
    </select>
    <input class="button" type="submit" value="Transfer">
</form>