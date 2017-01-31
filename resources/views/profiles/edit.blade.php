@extends('layouts.application_full')

@section('content_full')
<div id="container" class="force-fullwidth narrow">
    <div id="primary">
        <div class="posts">
            <div class="post page type-page status-publish hentry">
                <form method="POST" class="listing-manager-submission-form" enctype="multipart/form-data" action="{{ route('profiles.update', $user->id) }}">
                    {{ csrf_field() }}

                    @if (count($errors) > 0)
                        <div class="alert alert-danger" role="alert">
                            <strong> Errors:</strong>
                            <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <fieldset class="listing-manager-submission-form-general">
                        <legend>General Information</legend>
                        <div class="fieldset-content">
                            <div class="form-group">
                                <label for="firstname">First Name<span class="required">*</span></label>
                                <input type="text" required="required" id="firstname" name="firstname" value="{{ old('firstname') ? old('firstname') : $profile->firstname }}" class="form-control" />
                            </div>

                            <div class="form-group">
                                <label for="lastname">Last Name<span class="required">*</span></label>
                                <input type="text" required="required" id="lastname" name="lastname" value="{{ old('lastname') ? old('lastname') : $profile->lastname }}" class="form-control" />
                            </div>

                            <div class="form-group">
                                <label for="location">Location<span class="required">*</span></label>
                                <input type="text" required="required" id="location" name="location" value="{{ old('location') ? old('location') : $profile->location }}" class="form-control" />
                            </div>

                            <div class="form-group">
                                <label for="birthdate">Birthdate<span class="required">*</span></label>
                                <input type="date" required="required" id="birthdate" name="birthdate" value="{{ old('birthdate') ? old('birthdate') : $profile->birthdate }}" class="form-control" />
                            </div>

                            <div class="form-group">
                                <label for="gender">Gender<span class="required">*</span></label>
                                <select name="gender">
                                    <option value="Male" {{ old('gender') ? old('gender') === 'Male' ? 'selected' : '' : 'Male' === $profile->gender }}">Male</option>
                                    <option value="Female" {{ old('gender') ? old('gender') === 'Female' ? 'selected' : '' : 'Female' === $profile->gender }}">Female</option>
                                </select>
                            </div>

                            <div class="form-group ">
                                <label for="bio">About yourself<span class="required">*</span></label>
                                <textarea class="form-control" rows="5" required="required" name="bio" id="bio">{{ old('bio') ? old('bio') : $profile->bio }}</textarea>
                            </div>

                            <div class="form-group ">
                                <label for="profilepic">Avatar</label>
                                <input type="file" id="profilepic" name="profilepic" class="form-control" />
                            </div>
                        </div>
                    </fieldset>

                    <button type="submit" name="submit" value="1" class="button">Edit Profile</button>
                    {{ method_field('PUT') }}
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
