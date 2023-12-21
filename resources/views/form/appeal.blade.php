<form class="edit-world form-outline outline-none" method="POST" action="{{ route('appeal', ['id' => $member]) }}">
    <fieldset class="form-post">
        <legend>Submit an Unblock Appeal</legend>
        @csrf
        @method('POST')
    
        <h3 class="my-0 mt-3 text-white"> <label for="appeal-description">Unblock Reason <b class="text-red">*</b></label> </h3>
        <textarea class="world-description text-black max-h-40" id="appeal-description" rows="4" name="text" tabindex="0" placeholder="Why do you think you should be unblocked?" required></textarea>
    
        <input class="button" type="submit" value="Appeal" tabindex="0">
    </fieldset>
</form>