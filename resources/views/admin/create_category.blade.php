@extends('layouts.admin_full')

@section('content_full')

<div class="content">
    <div id="container">
        <div id="content" role="main">
            <div class="posts">
              <div class="post page type-page status-publish hentry">
                <form method="POST" class="listing-manager-submission-form" enctype="multipart/form-data">
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
                      <legend>Category Information</legend>
                      <div class="fieldset-content">
                        <div class="form-group ">
                          <label for="name">Category Name<span class="required">*</span></label>
                          <input type="text" required="required" id="name" name="name" value="" class="form-control" />
                        </div>
                        <div class="form-group ">
                          <label for="image">Image</label>
                          <input type="file" id="image" name="image" class="form-control" />
                        </div>
                      </div>
                    </fieldset>

                    <button type="submit" name="submit" value="1" class="button">Create Category</button>
                </form>
              </div>
          </div>
        </div>
    </div>
</div>
@endsection