@extends("layouts.app")

@section('title',"Product")

@section('content')
  <!-- Begin Page Content -->
  <div class="container-fluid">
    <div class="row">
        <div class="col">
            <a href="{{ route("product.create") }}" type="button" id="next-button" class="btn btn-success">
                <i class="fa fa-plus" aria-hidden="true"></i>
                Create Product
            </a>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-4">
                            <select name="category" class="form-control">
                                <option value="">Pilih Kategori</option>
                                @foreach ($categories as $eachCategory)
                                    <option value="{{ $eachCategory->id }}">{{ $eachCategory->name }}</option>
                                @endforeach
                            </select>
                        </div>
                         <div class="col-4">
                            <div class="input-group">
                                <input type="text" name="keyword" class="form-control mr-3">
                                <button class="btn btn-success" name="search-button">Cari</button>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3" id="product-content">
                      
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<div class="modal fade" id="delete-modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header bg-warning">
        <h5 class="modal-title text-white" id="deleteModalLabel">Peringatan!</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
        <h6 class="text-dark">
            Apakah anda yakin untuk menghapus data produk?
        </h6>
        </div>
        <div class="modal-footer">
            <button type="button" id="confirmDelete" class="btn btn-success">Ya</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Tidak</button>
        </div>
    </div>
    </div>
</div>


<div class="modal fade" id="detail-modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
    <div class="modal-content">
        <div class="modal-header">
            <button class="btn btn-success mr-2" name="edit-barang">Edit Barang</button>
            <button class="btn btn-primary" name="edit-harga">Harga Produk</button>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body px-5">
          
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
    </div>
    </div>
</div>

<div class="modal fade" id="price-modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
    <div class="modal-content">
        <div class="modal-header">
            <h4>Harga Barang</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="price-form" method="POST">
                @csrf
                <div class="row">
                    <div class="col-sm-3">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Ukuran</span>
                                </div>
                            <select class="select2 form-control"  name="size">
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Harga</span>
                            </div>
                            <input type="text" name="price" class="form-control" value="0">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </div>
            </form>
            <table class="table mt-3">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Product</th>
                        <th scope="col">Ukuran</th>
                        <th scope="col">Harga</th>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
    </div>
    </div>
</div>
@endsection

@push('script')
    <script>
        $(function(){
            let content = $("#product-content");
            let prevButton = $("#prev-button");
            let nextButton = $("#next-button");
            let deleteModal = $("#delete-modal");
            let detailModal = $("#detail-modal");
            let priceModal = $("#price-modal");
            let keywordInput = $("input[name='keyword']");
            let searchButton = $("button[name='search-button']");
            let categorySelect = $("select[name='category']");
            let sizeSelect = $("select[name='size']");
            let priceForm = $("form#price-form");
            let buttonEditHarga = detailModal.find("button[name='edit-harga']");
            let buttonEditBarang = detailModal.find("button[name='edit-barang']");
            
            displayProduct();

            searchButton.on("click",function(){
                let keyword = keywordInput.val();
                let category = categorySelect.val();

                console.log(category);
                displayProduct(category,keyword)
            });

            async function displayProduct(categoryId,keyword){
                let html = "";
                let products = await getProduct(categoryId,keyword);
                products = products.data;

                $.each(products,function(i,v){
                    html += `
                        <div class="col-sm-3">
                            <div class="card">
                                <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                                    <div class="carousel-inner">
                                        ${v.pictures.map(function (d) {
                                            return `<div class='carousel-item active'><img src="${d.url}" class="d-block w-100" alt="..."></div>`
                                        }).join("")}
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row justify-content-center">
                                        <h4 class="text-center">
                                            ${v.name}
                                        </h4>
                                    </div>
                                    <div class="row justify-content-center">
                                        <button type="button" id="next-button" data-id= ${v.id} name="detailButton" class="btn btn-success mr-2"><i class="fa fa-eye" aria-hidden="true"></i></button>
                                       
                                        <button type="button" id="next-button" data-id= ${v.id} name="deleteButton" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                });

                content.html(html);
            }


            async function displayPrice(id){
                let html = "";
                let prices = await getProductPrice(id);
                prices = prices.data;

                $.each(prices,function(i,v){
                    html += `
                        <tr>
                            <td>${i+1}</td>
                            <td>${v.product.name}</td>
                            <td>${v.size.name}</td>
                            <td>${v.price}</td>
                        </tr>
                    `;
                });

                priceModal.find("tbody").html(html);
            }


            async function showDetailProduct(id){
                let product = await getProductDetail(id);
                product = product.data;

                let html = `
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Nama</label>
                                    <h5>
                                       ${product.name}
                                    </h5>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Kategori</label>
                                    <h5>
                                       ${product.category ? product.category.name : "-"}
                                    </h5>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Warna</label>
                                    <h5>
                                        ${product.colors.map(function (d) {
                                            return `${d.name}`
                                        }).join(",")}
                                    </h5>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Ukuran</label>
                                    <h5>
                                        ${product.sizes.map(function (d) {
                                            return `${d.name}`
                                        }).join(",")}
                                    </h5>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-5">
                                <div class="form-group">
                                    <label>Deskripsi</label>
                                    <h5>
                                       ${product.description ?? "-"}
                                    </h5>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-5">
                                <div class="form-group">
                                    <label>Gambar</label>
                                    <div class="row">
                                        <div class="col">
                                            ${product.pictures.map(function (d) {
                                                return `<img src="${d.url}" width="200">`
                                            }).join(",")}
                                        </div>
                                    </div>
                                </div>
                            </div>  
                        </div>
                    `;

                detailModal.find(".modal-body").html(html);
            }

            //get product
            async function getProduct(categoryId = "",keyword = ""){
                url = `{{ route("product.api.index") }}`;
                type = "get";

                if(keyword != "" || categoryId != ""){
                    url = `{{ route('product.api.search') }}`;
                    type = "post";
                }
             
                let result =  await $.ajax({
                    url: url,
                    type: type,
                    dataType: 'JSON',
                    data:{
                        category:categoryId,
                        keyword:keyword,
                    }
                });
                
                return result;
            }

            async function getProductDetail(id){
                let result =  await $.ajax({
                    url: `{{ route("product.api.show",['']) }}/${id}`,
                    type: "get",
                    dataType: 'JSON',
                });
                
                return result;
            }   
            
            async function getProductSize(id){
                let result =  await $.ajax({
                    url: `{{ route("product.api.size",['']) }}/${id}`,
                    type: "get",
                    dataType: 'JSON',
                });
                
                return result;
            }

            async function getProductPrice(id){
                let result =  await $.ajax({
                    url: `{{ route("product.api.price",['']) }}/${id}`,
                    type: "get",
                    dataType: 'JSON',
                });
                
                return result;
            }


            //delete button action
            $(document).on("click", "button[name='deleteButton']", function() {
                let id = $(this).attr('data-id');
                deleteModal.modal("show");
                deleteModal.find("#confirmDelete").attr("data-id",id);
             
            })  
            
            $(document).on("click", "button[name='detailButton']",async function() {
                let id = $(this).attr('data-id');
                detailModal.modal("show");
                detailModal.find("#confirmDelete").attr("data-id",id);
                showDetailProduct(id);
                buttonEditHarga.attr("data-id",id);
                buttonEditBarang.attr("data-id",id);
                priceForm.attr("action",`{{ route('product.save-price',['']) }}/${id}`);

            })

            buttonEditHarga.click( async function(){
                let id = $(this).attr('data-id');
                detailModal.modal("hide");
                priceModal.modal("show");
                displayPrice(id);

                let productSize  = await getProductSize(id);
                productSize = productSize.data.sizes;

                console.log(productSize)

                let html = "";

                $.each(productSize,function(i,v){
                    html += `<option value="${v.id}">${v.name}</option>`
                });

                sizeSelect.html(html);
                
            }); 
            
            buttonEditBarang.click(function(){
                let id = $(this).attr('data-id');
                window.location.href = `{{ route('product.edit',['']) }}/${id}`;
                
            });


            deleteModal.find("#confirmDelete").on("click",function(){
                let id = $(this).attr('data-id');

                $.ajax({
                    url: `{{ route('product.api.delete', ['']) }}/${id}`,
                    type: "DELETE",
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    dataType: "JSON",
                    success: function(res) {
                        deleteModal.modal("hide");
                        displayProduct();
                    },
                    error: function(res) {
                       
                    }
                })
            });
        });
    </script>
@endpush