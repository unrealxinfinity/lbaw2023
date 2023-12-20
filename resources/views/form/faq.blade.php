
@if($operation == 'delete')
    <form class="ml-auto" action="{{ route('delete-faq', ['id' => $faq->id]) }}" method="POST">
        <fieldset>
            <legend class="sr-only">Delete a FAQ</legend>
            @csrf
            @method('DELETE')
            <h3><button tabindex="0" class="text-red cursor-pointer transition duration-300 hover:scale-105" type="submit">Delete</button></h3>
        </fieldset>
    </form>
@elseif($operation == 'add')
    <form action="{{ route('add-faq')}}" method="POST">
        @csrf
        @method('POST')
        <fieldset>
            <legend class="text-green font-bold m-2">Create a FAQ</legend>
            <div class="form-post m-2 bg-lime rounded-lg">
                <h3><label for="add-faq-question" class="text-black">
                    Frequently Asked Question <b class="text-red">*</b>
                </label></h3>
                <input id="add-faq-question" type="text" placeholder="Question" name="faq" required tabindex="0">
                <h3><label for="add-faq-answer" class="text-black">
                    Answer <b class="text-red">*</b>
                </label></h3>
                <input id="add-faq-answer" type="text" placeholder="Answer" name="answer" required tabindex="0">
                <h2 class="text-center"><button tabindex="0" class="mx-auto transition duration-300 hover:scale-105" type="submit">Add</button></h2>
            </div>
        </fieldset>
    </form>


@endif
