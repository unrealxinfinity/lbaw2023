@can('edit', $member)
<article class="member" data-id="{{ $member->id }}" id="{{ $member->persistentUser->user->username }}">
    @if (Auth::user()->persistentUser->type_=='Member')
        <a href="#member-edit-picture" class="sr-only sr-only-focusable">Change Picture</a>
        <a href="#change-picture-mc-username" class="sr-only sr-only-focusable">Change Picture with Minecraft Username</a>
        <a href="#member-edit-details">Edit Details</a>
    @endif

    <p><a href="/">Home</a> > <a
            href="/members/{{$member->persistentUser->user->username}}">{{$member->persistentUser->user->username}}</a>
        > <a href="/members/{{$member->persistentUser->user->username}}/edit">Edit Profile</a></p>
    <header class="flex justify-start tablet:my-5 my-2 ml-1">
        <form id="member-edit-picture" method="POST" action="/members/upload/{{ $member->id }}" enctype="multipart/form-data">
            <fieldset class="grid mobile:grid-cols-2 mobile:grid-rows-none grid-rows-2">
                <legend>Upload New Profile Picture</legend>
                @csrf
                @method('POST')
                <div>
                    <label for="edit-img">
                        <h1><label class="absolute mobile:h-28 tablet:h-32 desktop:h-40 h-24 aspect-square text-center flex flex-col justify-around pointer-events-none">&#9998;</label></h1>
                        <img id="preview-img" class="mobile:h-28 tablet:h-32 desktop:h-40 h-24 aspect-square hover:opacity-50 object-cover"
                            src={{$member->getProfileImage()}}
                            alt="{{$member->persistentUser->user->username}} profile picture">
                    </label>
                    <input id="edit-img" class="hidden" name="file" type="file" required>
                    <input name="type" type="hidden" value="profile">
                    <input class="button px-1 my-2 mobile:w-28 tablet:w-32 desktop:w-40 w-24" type="submit" value="Upload profile picture">
                </div>
                @if ($self ?? false)
                <div id="change-picture-mc-username" class="form-post">
                    <h2><label for="mc-username">...Or use your Minecraft face!</label></h2>
                    <input type="text" id="mc-username-text" placeholder="MC Username" id="mc-username">
                    <input id="mc-img-submit" class="button" type="submit" value="Confirm">
                </div>
                @endif
            </fieldset>
        </form>
    </header>
    <div class="form-outline m-0 mb-5">
        <form id="member-edit-details" class="edit-member" method="POST" action="{{ route('update-member', ['username' => $member->persistentUser->user->username]) }}">
            <fieldset class="form-post">
                <legend>Edit Details</legend>
                @csrf
                @method('PUT')
    
                <input type="hidden" class="member-id" name="id" value="{{ $member->id }}">
    
                @if ($errors->has('username') && old('id') == $member->id)
                <span class="error">
                    {{ $errors->first('username') }}
                </span>
                @endif
                <h3 class="my-0"><label for="username-{{ $member->id }}">Username</label></h3>
                <input id="username-{{ $member->id }}" type="text" class="username" name="username"
                    value="{{ $member->persistentUser->user->username }}" required>
    
                @if ($errors->has('name') && old('id') == $member->id)
                <span class="error">
                    {{ $errors->first('name') }}
                </span>
                @endif
                <h3 class="my-0"><label for="name-{{ $member->id }}">Name</label></h3>
                <input id="name-{{ $member->id }}" type="text" class="name" name="name" value="{{ $member->name }}"
                    required>
    
                @if ($errors->has('email') && old('id') == $member->id)
                <span class="error">
                    {{ $errors->first('email') }}
                </span>
                @endif
                <h3 class="my-0"><label for="email-{{ $member->id }}">Email</label></h3>
                <input id="email-{{ $member->id }}" type="email" class="email" name="email" value="{{ $member->email }}"
                    required>
    
                @if ($errors->has('birthday') && old('id') == $member->id)
                <span class="error">
                    {{ $errors->first('birthday') }}
                </span>
                @endif
                <h3 class="my-0"><label for="birthday-{{ $member->id }}">Birthday</label></h3>
                <input id="birthday-{{ $member->id }}" type="date" class="birthday" name="birthday"
                    value="{{ $member->birthday }}" required>
    
                @if ($errors->has('description') && old('id') == $member->id)
                <span class="error">
                    {{ $errors->first('description') }}
                </span>
                @endif
                <h3 class="my-0"><label for="description-{{ $member->id }}">Description</label></h3>
                <input id="description-{{ $member->id }}" type="text" class="description" name="description"
                    value="{{ $member->description }}" required>
    
                @if ($errors->has('password') && old('id') == $member->id)
                <span class="error">
                    {{ $errors->first('password') }}
                </span>
                @endif
                <h3 class="my-0"><label for="password-{{ $member->id }}">New Password</label></h3>
                <input id="password-{{ $member->id }}" type="password" class="password" name="password">
    
                @if ($errors->has('password_confirmation') && old('id') == $member->id)
                <span class="error">
                    {{ $errors->first('password_confirmation') }}
                </span>
                @endif
                <h3 class="my-0"><label for="password_confirmation-{{ $member->id }}">Confirm New Password</label></h3>
                <input id="password_confirmation-{{ $member->id }}" type="password" class="password_confirmation"
                    name="password_confirmation">
    
                @if ($errors->has('old_password') && old('id') == $member->id)
                <span class="error">
                    {{ $errors->first('old_password') }}
                </span>
                @endif
                @if (Auth::user()->has_password)
                @if (Auth::user()->persistentUser->type_=='Administrator')
                <label type="hidden" for="old_password-{{ $member->id }}"></label>
                <input type="hidden" id="old_password-{{ $member->id }}" type="password" class="old_password"
                    name="old_password" value="{{ $member->persistentUser->user->password }}" required>
                @else
                <h3 class="my-0"><label for="old_password-{{ $member->id }}">Old Password</label></h3>
                <input id="old_password-{{ $member->id }}" type="password" class="old_password" name="old_password"
                    required>
                @endif
                @endif
    
                <input class="button" type="submit" id="submit-{{ $member->id }}" value="Edit Profile">
            </fieldset>
        </form>
        @if (Auth::user()->persistentUser->type_=='Administrator')
        <form class="admin-delete form-post outline-none mt-0 pt-0 mb-0 pb-0">
            <fieldset>
                <legend>Manage User Block Status</legend>
                @csrf
                @method('POST')
    
                @if ($member->persistentUser->type_ != 'Blocked')
                <button type="submit" class="button bg-dark text-red/80" formmethod="POST"
                    formaction="/members/{{ $member->persistentUser->user->username }}/block">Block</button>
                @else
                <button type="submit" class="button bg-dark text-red/80" formmethod="POST"
                    formaction="/members/{{ $member->persistentUser->user->username }}/unblock">Unblock</button>
                @endif
            </fieldset>
        </form>
        <form class="admin-delete form-post outline-none mt-0 pt-0" method="POST"
            action="/members/{{ $member->persistentUser->user->username }}">
            <fieldset>
                <legend>Delete User</legend>
                @csrf
                @method('DELETE')
    
                <input type="submit" class="button bg-dark text-red/80" value="Delete">
            </fieldset>
        </form>
        @endif
    </div>
</article>
@endcan