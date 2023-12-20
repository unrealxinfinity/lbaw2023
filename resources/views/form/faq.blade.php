@if($operation == 'delete')
    <form class="flex flex-col items-end justify-center w-full" action="{{ route('delete-faq', ['id' => $faq->id]) }}" method="POST">
        <fieldset class="form-post">
            <legend class="sr-only">Delete a FAQ</legend>
            @csrf
            @method('DELETE')
            <button class="text-lg font-semibold text-red ml-auto cursor-pointer transition duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:shadow-outline" type="submit">Delete</button>
        </fieldset>
    </form>
@elseif($operation == 'add')
    <form class="flex flex-col items-end justify-center w-full bg-lime rounded-lg w-full m-2" action="{{ route('delete-faq', ['id' => $faq->id]) }}" method="POST">
        <fieldset class="form-post">
            <legend>Create a FAQ</legend>
            @csrf
            <div class="w-auto m-1 flex flex-row">
                <h3 class="m-2  text-black "><label for="add-faq-question">Frequently Asked Question <b class="text-red">*</b></label></h3>
                <input id="add-faq-question" class="mx-2 mt-2 mb-1" type="text" placeholder="Question" name="faq" required>
            </div>
            <div class=" w-auto m-1 flex flex-row">
                <h3 class="m-2  text-black"><label for="add-faq-answer">Answer <b class="text-red">*</b></label></h3>
                <input id="add-faq-answer" class="mx-2 mt-1 mb-2" type="text" placeholder="Answer" name="answer" required>
            </div>
            <button class="mx-4 mt-1 mb-2 justify-center text-lg font-semibold text-green cursor-pointer transition duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:shadow-outline" type="submit">Add</button>
        </fieldset>
    </form>
@endif
