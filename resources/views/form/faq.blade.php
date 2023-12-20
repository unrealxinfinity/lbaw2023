
@if($operation == 'delete')
    <form class="ml-auto" action="{{ route('delete-faq', ['id' => $faq->id]) }}" method="POST">
        <fieldset class="flex flex-col items-end justify-center w-full">
            <legend class="sr-only">Delete a FAQ</legend>
            @csrf
            @method('DELETE')
            <button tabindex="0" class="text-lg font-semibold text-red cursor-pointer transition duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:shadow-outline" type="submit">Delete</button>
        </fieldset>
    </form>
@elseif($operation == 'add')
    <form class="m-0 w-full" action="{{ route('add-faq')}}" method="POST">
        @csrf
        @method('POST')
        <fieldset class="relative flex flex-col items-end justify-center bg-lime rounded-lg w-full mt-10 mb-4 p-4 md:p-6">
            <legend class=" absolute -top-12 left-2 text-lg font-semibold text-green mb-2">Create a FAQ</legend>
            <div class="w-full md:w-auto m-1 flex flex-col md:flex-row">
                <label for="add-faq-question" class="m-2 text-black">
                    Frequently Asked Question <b class="text-red">*</b>
                </label>
                <input id="add-faq-question" class="mx-2 mt-2 mb-1" type="text" placeholder="Question" name="faq" required tabindex="0">
            </div>
            <div class="w-full md:w-auto m-1 flex flex-col md:flex-row">
                <label for="add-faq-answer" class="m-2 text-black">
                    Answer <b class="text-red">*</b>
                </label>
                <input id="add-faq-answer" class="mx-2 mt-1 mb-2" type="text" placeholder="Answer" name="answer" required tabindex="0">
            </div>
            <button tabindex="0" class="mx-3 mt-1 mb-2 w-full md:w-auto justify-center text-lg font-semibold text-lightlime cursor-pointer transition duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:shadow-outline" type="submit">Add</button>
        </fieldset>
    </form>


@endif
