@extends("layouts.app")

@section('title',"Product")

@section('content')
  <!-- Begin Page Content -->
  <div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-3">
        <a href="{{ route("product.index") }}" class="btn btn-success">
            <i class="fa fa-arrow-left" aria-hidden="true"></i>
        </a>
    </div>
  
    <div class="row mt-3">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <form id="productForm" action="{{ route("product.api.store") }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Nama :</label>
                                    <input type="text" name="name" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Kategori :</label>
                                    <select name="category" class="form-control">
                                        @foreach ($categories as $eachCategory)
                                            <option value="{{ $eachCategory->id }}">{{ $eachCategory->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> 
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Warna :</label>
                                    <select  class="select2 form-control" multiple="multiple" name="colors[]">
                                        @foreach ($colors as $eachColor)
                                            <option value="{{ $eachColor->id }}">{{ $eachColor->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> 
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Ukuran :</label>
                                    <select class="select2 form-control" multiple="multiple"  name="sizes[]">
                                        @foreach ($sizes as $eachSize)
                                            <option value="{{ $eachSize->id }}">{{ $eachSize->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> 
                        
                        </div>
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label>Deskripsi</label>
                                    <textarea class="form-control"  name="description"></textarea>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Picture</label>
                                    <div class="row mt-1">
                                        <div   div class="input-group control-group increment">
                                            <input type="file" name="picture[]" class="form-control">
                                            <div class="input-group-btn"> 
                                                <button class="btn btn-success add-picture" type="button"><i class="glyphicon glyphicon-plus"></i>Add</button>
                                            </div>
                                        </div>
                                        <div class="clone hide">
                                            <div class="control-group input-group" style="margin-top:10px">
                                                <input type="file" name="picture[]" class="form-control">
                                                <div class="input-group-btn"> 
                                                <button class="btn btn-danger delete-picture" type="button"><i class="glyphicon glyphicon-remove"></i> Remove</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <button type="submit" class="btn btn-success">
                                    Simpan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->
@endsection

