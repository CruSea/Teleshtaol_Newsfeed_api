@extends('layouts.app')

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">News Post</div>

                <div class="card-body">
                <div class="container">
                <form action="" method="POST" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="form-group">
                <label>News Title</label>
                <input type="text" name="title" class="form-control" placeholder="Title">
                </div>

                <div class="form-group">
                <label>Video-Url</label>
                <input type="text" name="videourl" class="form-control" placeholder="Video url">
                </div>
                

                <div class="form-group">
                <label>Description</label>
                  
                    <textarea name="description" class="form-control" id="textarea-input" name="textarea-input" placeholder="Content.." rows="9"></textarea>
                  
                </div>

                <div class="input-group">
                <div class="custom-file">
                <label class="custom-file-label">Choose file</label>
                <input type="file" name="image" class="custom-file-input">
                
                </div>
                </div>
                
                <div class="card-footer">
                <button type="submit" name="submit" class="btn btn-primary">Save data</button>
            </div>
                </form>
                <div class="container">
                <label>Post</label><br>
                @foreach($posts as $post)
                {{$post->image}}<br>
                {{$post->title}}<br>
                {{$post->videourl}}<br>
                {{$post->description}}<br>
                
                @endforeach
            </div>
                    
                </div>
            </div>
        </div>
    </div>

@endsection
