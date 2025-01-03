@include('admin.layouts.header')
@include('admin.layouts.sidebar')
@include('admin.layouts.navbar')


         <!-- Begin Page Content -->
         <div class="container-fluid">

            @session('success')

            <div class="alert alert-success alert-dismissible fade show" role="alert">
              <strong>{{ session('success')}}</strong>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
                
            @endsession
                <!-- Page Heading -->
                <h1 class="h3 mb-2 text-gray-800">Add Destination</h1>
                
                <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Add Destination <a href="{{ route('destination')}}" class="btn btn-primary btn-sm float-right">Back</a></h6>
                    </div>
                    <div class="card-body">
                        <form action="{{route('destination.create')}}" method="POST" enctype="multipart/form-data">
                              @csrf
                              <div class="form-group mb-3">
                                <label for="destination_id">Select Destination</label>
                                <select name="destination_id" class="form-control" id="state">
                                    <option selected hidden>Select Desitination</option>
                                    @foreach ($states as $item)
                                    <option value="{{$item->id}}">{{$item->destination_name}}</option>
                                    @endforeach

                                </select>
                                @error('destination_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                          </div>
                          <div class="form-group mb-3">
                                <label for="name">Destination Name</label>
                                <input type="text" class="form-control" value="{{ old('name')}}" id="name" name="name">
                                @error('name')
                                <small>{{$message}}</small>
                                @enderror
                          </div>
                          <div class="form-group mb-3">
                                <label for="slug">Slug</label>
                                <input type="text" class="form-control"  value="{{ old('slug')}}" id="slug" name="slug">
                                @error('slug')
                                <small>{{$message}}</small>
                                @enderror
                          </div>
                          <div class="form-group mb-3">
                                <label for="heading">Heading</label>
                                <input type="text" class="form-control"  value="{{ old('heading')}}" id="heading" name="heading">
                                @error('heading')
                                <small>{{$message}}</small>
                                @enderror
                              </div>
                          <div class="form-group mb-3">
                                <label for="">Short Description</label>
                               <textarea name="short_description" class="form-control"  id="" cols="30" rows="3"></textarea>
                              
                              </div>
                          <div class="form-group mb-3">
                                <label for="">Package Heading</label>
                                <input type="text" class="form-control" name="package_heading">
                          </div>
                          <div class="form-group mb-3">
                                <label for="">Package Subheading</label>
                                <input type="text" class="form-control" name="package_subheading">
                          </div>
                          <div class="form-group mb-3">
                                <label for="">Detail Heading</label>
                                <input type="text" class="form-control" name="detail_heading">
                          </div>
                          <div class="form-group mb-3">
                                <label for="name">Detail Subheading</label>
                                <input type="text" class="form-control" name="detail_subheading">
                          </div>
                          <div class="form-group mb-3">
                                <label for="image" >Photo*</label>
                                <input type="file" id="image" name="image">
                          </div>
                          
                          <div class="form-group mb-3">
                                <label for="name">Introduction</label>
                               <textarea name="introduction" class="form-control summernote" id="summernote" cols="30" rows="3"></textarea>
                          </div>
                          <div class="form-group mb-3">
                              <label for="name">Experience</label>
                               <textarea name="experience" class="form-control summernote" id="" cols="30" rows="3"></textarea>
                          </div>
                          <div class="form-group mb-3">
                              <label for="name">Weather</label>
                               <textarea name="weather" class="form-control summernote" id="" cols="30" rows="3"></textarea>
                          </div>
                          <div class="form-group mb-3">
                              <label for="name">Hotel</label>
                               <textarea name="hotel" class="form-control summernote" id="" cols="30" rows="3"></textarea>
                          </div>
                          <div class="form-group mb-3">
                              <label for="name">Transportation</label>
                               <textarea name="transportation" class="form-control summernote" id="" cols="30" rows="3"></textarea>
                          </div>
                          <div class="form-group mb-3">
                              <label for="name">Culture</label>
                               <textarea name="culture" class="form-control summernote" id="" cols="30" rows="3"></textarea>
                          </div>

                          <div class="card-header">
                                <h6 class="m-0 font-weight-bold text-primary">SEO Information</h6>
                            </div>

                            <div class="card-body p-0">
                                <div class="form-group">
                                    <label for="">Title</label>
                                    <input type="text" name="seo_title" class="form-control" value="">
                                </div>
                                <div class="form-group">
                                    <label for="">Meta Description</label>
                                    <textarea name="seo_meta_description" class="form-control h_100" cols="30" rows="5"></textarea>
                                </div>
                               
                            </div>
                            <div class="form-group">
                              <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" id="inlineCheckbox1" name="status" value="1">
                                  <label class="form-check-label" for="inlineCheckbox1">Show</label>
                                </div>
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" id="inlineCheckbox2" name="status" value="0">
                                  <label class="form-check-label" for="inlineCheckbox2">Hide</label>
                                </div>

                          </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-success">Submit</button>
                            </div>
                        </form>

                    </div>
                </div>

            </div>
            <!-- /.container-fluid -->




@include('admin.layouts.footer')
        