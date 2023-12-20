<article class="homepage flex">
    <span id="manage-members-home"></span>
    @include('partials.container', ['description' => "There are $nMembers members currently signed up for MineMax.", 'title' => 'Manage members', 'link' => route('list-members'), 'img' => URL('/images/members.png'), 'alt' => ""])
    <span id="manage-appeals-home"></span>
    @include('partials.container', ['description' => "$nAppeals blocked members wish to appeal their blocks.", 'title' => 'Manage appeals', 'link' => route('admin-appeals'), 'img' => URL('/images/appeals.png'), 'alt' => ""])
    <span id="manage-faqs-home"></span>
    @include('partials.container', ['description' => "See and edit FAQs", 'title' => 'Manage FAQs', 'link' => route('show-faqs'), 'img' => URL('/images/bookshelves.png'), 'alt' => ""])
</article>