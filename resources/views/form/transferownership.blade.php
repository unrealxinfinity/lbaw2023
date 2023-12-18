<form class="form-outline outline-none" id="transfer-ownership" method="POST" action="{{ route('transfer-world', ['id' => $world->id]) }}">
    <fieldset class="form-post">
        <legend>Transfer Ownership</legend>
        @csrf
        <label> Select a new owner:
            <select name="owner" class="type" required>
                @foreach ($members as $member)
                    <option value="{{ $member->id }}">{{ $member->persistentUser->user->username }}</option>
                @endforeach
            </select>
        </label>
        <input class="button" type="submit" value="Transfer">
    </fieldset>
    
</form>