<article class="homepage flex">
    @include('partials.container', ['description' => "There are $nMembers members currently signed up for MineMax.", 'title' => 'Manage members', 'link' => route('list-members')])
    @include('partials.container', ['description' => "$nAppeals blocked members wish to appeal their blocks.", 'title' => 'Manage appeals', 'link' => route('admin-appeals')])
</article>