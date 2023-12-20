
@if($operation == 'delete')
    <form class="ml-auto" action="{{ route('delete-faq', ['id' => $faq->id]) }}" method="POST">
        <fieldset class="flex flex-col items-end justify-center w-full">
            <legend class="sr-only">Delete a FAQ</legend>
            @csrf
            @method('DELETE')
            <button class="text-lg font-semibold text-red cursor-pointer transition duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:shadow-outline" type="submit">Delete</button>
        </fieldset>
    </form>
@elseif($operation == 'add')
    <form action="{{ route('delete-faq', ['id' => $faq->id]) }}" method="POST">
        <fieldset class="relative flex flex-col items-end justify-center bg-lime rounded-lg w-full mt-8 mb-4">
        <legend class="absolute -top-6 left-2 text-lg font-semibold text-green mb-2">Create a FAQ</legend>
            <div class="w-auto m-1 flex flex-row">
                
                <label for="add-faq-question" class="m-2 text-black">
                    Frequently Asked Question <b class="text-red">*</b>
                </label>
                <input id="add-faq-question" class="mx-2 mt-2 mb-1" type="text" placeholder="Question" name="faq" required>
            </div>
            <div class="w-auto m-1 flex flex-row">
                <label for="add-faq-answer" class="m-2 text-black">
                    Answer <b class="text-red">*</b>
                </label>
                <input id="add-faq-answer" class="mx-2 mt-1 mb-2" type="text" placeholder="Answer" name="answer" required>
            </div>
            <button class="mx-3 mt-1 mb-2 justify-center text-lg font-semibold text-lightlime cursor-pointer transition duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:shadow-outline" type="submit">Add</button>
        </fieldset>
    </form>

@endif
