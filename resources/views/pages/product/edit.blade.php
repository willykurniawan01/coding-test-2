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
                    <form id="productForm" action="{{ route("product.update",$product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Nama :</label>
                                    <input type="text" name="name" value="{{ $product->name }}" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Kategori :</label>
                                    <select name="category" class="form-control">
                                        <option value="">Pilih Kategori</option>
                                        @foreach ($categories as $eachCategory)
                                            <option {{ $eachCategory->id == $product->category_id  ? "selected" :""}} value="{{ $eachCategory->id }}">{{ $eachCategory->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> 
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Warna :</label>
                                    <select  class="select2 form-control" multiple="multiple" name="colors[]">
                                        @foreach ($colors as $eachColor)
                                            <option {{ in_array($eachColor->id,$product->colors->pluck("id")->toArray()) ? "selected" :"" }} value="{{ $eachColor->id }}">{{ $eachColor->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> 
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Ukuran :</label>
                                    <select class="select2 form-control" multiple="multiple"  name="sizes[]">
                                        @foreach ($sizes as $eachSize)
                                            <option {{ in_array($eachSize->id,$product->sizes->pluck("id")->toArray()) ? "selected" :"" }}  value="{{ $eachSize->id }}">{{ $eachSize->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> 
                        
                        </div>
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label>Deskripsi</label>
                                    <textarea class="form-control"  name="description">{{ $product->description }}</textarea>
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

@push('style')
<link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

@endpush

@push('script')

<script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>
<script src="https://unpkg.com/jquery-filepond/filepond.jquery.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(function(){
            const colorSelect = $("select[name='color']");
            const sizeSelect = $("select[name='size']");
            const productForm = $("form#productForm");
            
            $('.select2').select2();

            $(".add-picture").click(function(){ 
                var html = $(".clone").html();
                $(".increment").after(html);
            });
            $("body").on("click",".delete-picture",function(){ 
                $(this).parents(".control-group").remove();
            });
            
        });
    </script>
@endpush