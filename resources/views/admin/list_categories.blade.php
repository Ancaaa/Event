@extends('layouts.admin_full')

@section('content_full')

<div class="content">
    <div id="container">
        <div id="content" role="main">

            <div class="header_actions">
                <a href="{{ route('admin.create_category') }}" class="button button-secondary">Create Category</a>
            </div>

            <table>
                <thead>
                    <td>ID</td>
                    <td>Category Name</td>
                    <td>Image</td>
                    <td width="150">Number of Events</td>
                    <td width="150">Actions</td>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td>{{ $category->name }}</td>
                            <td><a href="{{ url('/images/categories/' . $category->image) }}" target="_blank">{{ $category->image }}</a></td>
                            <td>{{ $category->events->count() }}</td>
                            <td class="actions">
                                <a href="{{ route('admin.edit_category', $category->id) }}" class="button button-secondary">Edit</a>
                                <a href="{{ route('admin.delete_category', $category->id) }}" class="button button-secondary">Delete</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection