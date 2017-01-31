@extends('layouts.application_full')

@section('extra-headers')
    <script src="{{ URL::asset('js/create-event.js') }}"></script>
    <style>
        #map {
            height: 300px;
        }
    </style>
@endsection

@section('content_full')
<div id="container" class="force-fullwidth narrow">
  <div id="primary">
    <div class="posts">
      <div class="post page type-page status-publish hentry">
        <form method="POST" class="listing-manager-submission-form" enctype="multipart/form-data" action="{{ route('events.store') }}">

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
                <div class="form-group ">
                  <label for="title">Title<span class="required">*</span></label>
                  <input type="text" required="required" id="title" name="title" value="" class="form-control" />
                </div>
                <div class="form-group">
                  <label for="category_id">Category<span class="required">*</span></label>
                    <select name="category_id">
                    @foreach($categories as $category)
                      <option value="{{$category->id}}">{{$category->name}}</option>
                     @endforeach
                    </select>
                </div>
                <div class="form-group ">
                  <label for="description">Description<span class="required">*</span></label>
                  <textarea class="form-control" rows="5" required="required" name="description" id="description"></textarea>
                </div>
                <div class="form-group ">
                  <label for="image">Image</label>
                  <input type="file" id="image" name="image" class="form-control" />
                </div>
              </div>
            </fieldset>

            <fieldset>
                <legend>Location</legend>
                <div class="fieldset-content">
                    <div class="form-group">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="location_lat" value="" id="location_lat">
                        <input type="hidden" name="location_lng" value="" id="location_lng">

                        <label for="startdate">Address</label>
                        <input id="pac-input" class="controls form-control" name="location" type="text" placeholder="Address">
                        <div id="map"></div>

                        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDC5eNDyxYWDkm8_2n-bJ39vaJDFFr4Hrw&libraries=places&callback=initCreateEventMap&language=ro&region=RO" async defer></script>
                    </div>
                </div>
            </fieldset>

            <fieldset class="listing-manager-submission-form-event collapsible">
              <legend>Date Information</legend>
              <div class="fieldset-content">
                <div class="form-group ">
                  <label for="startdate">
                    Start Date
                  </label>
                  <input type="date" id="startdate" name="startdate" value="" class="form-control date hasDatepicker">
                </div>
                <!-- /.form-group -->
                <div class="form-group ">
                  <label for="starttime">
                    Start Time
                  </label>
                  <input type="time" id="starttime" name="starttime" value="" class="form-control time">
                </div>
                <!-- /.form-group -->
                <div class="form-group ">
                  <label for="enddate">
                    End Date
                  </label>
                  <input type="date" id="enddate" name="enddate" value="" class="form-control date hasDatepicker">
                </div>
                <!-- /.form-group -->
                <div class="form-group ">
                  <label for="endtime">
                    End Time
                  </label>
                  <input type="time" id="endtime" name="endtime" value="" class="form-control time">
                </div>
                <!-- /.form-group -->
              </div>
            </fieldset>

            <fieldset>
                <legend>Price Options</legend>
                <div class="fieldset-content">
                    <div class="form-group ">
                  <label for="price">Price Value</label>
                  <input class="form-control" value="0" name="price" type="number" id="price" />
                </div>
                <div class="form-group ">
                  <label for="currency">Price Currency</label>
                  <select name="currency">
                      <option value="RON">RON</option>
                      <option value="USD">USD</option>
                      <option value="EUR">EUR</option>
                      <option value="GBP">GBP</option>
                  </select>
                </div>
                </div>
            </fieldset>

            <button type="submit" name="submit" value="1" class="button">Create Event</button>

        </form>
      </div>
  </div>
</div>
</div>
@endsection
