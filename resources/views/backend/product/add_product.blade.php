@extends('admin_dashboard')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

    <div class="content">
        <div class="container-fluid">

            <!-- Page Title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Add Product</a></li>
                            </ol>
                        </div>
                        <h4 class="page-title">Add Product</h4>
                    </div>
                </div>
            </div>

            <!-- Form Section -->
            <div class="row">
                <div class="col-lg-8 col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="tab-pane" id="settings">
                                <form method="post" action="{{ route('product.store') }}" enctype="multipart/form-data">
                                    @csrf
                                    <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i> Add Product</h5>
                                    <div class="row">

                                        <!-- Product Name -->
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Product Name</label>
                                                <input type="text" name="product_name" class="form-control" required value="{{ old('product_name') }}">
                                                @error('product_name') <span class="text-danger">{{ $message }}</span> @enderror
                                            </div>
                                        </div>

                                        <!-- Category -->
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Category</label>
                                                <select name="category_id" class="form-select" required>
                                                    <option disabled selected>Select Category</option>
                                                    @foreach($category as $cat)
                                                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->category_name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('category_id') <span class="text-danger">{{ $message }}</span> @enderror
                                            </div>
                                        </div>

                                        <!-- Supplier -->
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Supplier</label>
                                                <select name="supplier_id" class="form-select" required>
                                                    <option disabled selected>Select Supplier</option>
                                                    @foreach($supplier as $sup)
                                                        <option value="{{ $sup->id }}" {{ old('supplier_id') == $sup->id ? 'selected' : '' }}>{{ $sup->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('supplier_id') <span class="text-danger">{{ $message }}</span> @enderror
                                            </div>
                                        </div>

                                        <!-- Product Code -->
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Product Code</label>
                                                <input type="text" name="product_code" class="form-control" required value="{{ old('product_code') }}">
                                                @error('product_code') <span class="text-danger">{{ $message }}</span> @enderror
                                            </div>
                                        </div>

                                        <!-- Product Garage -->
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Product Garage</label>
                                                <input type="text" name="product_garage" class="form-control" required value="{{ old('product_garage') }}">
                                            </div>
                                        </div>

                                        <!-- Product Store -->
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Product Store</label>
                                                <input type="text" name="product_store" class="form-control" required value="{{ old('product_store') }}">
                                            </div>
                                        </div>

                                        <!-- Buying Date -->
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Buying Date</label>
                                                <input type="date" name="buying_date" class="form-control" required value="{{ old('buying_date') }}">
                                                @error('buying_date') <span class="text-danger">{{ $message }}</span> @enderror
                                            </div>
                                        </div>

                                        <!-- Expire Date -->
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Expire Date</label>
                                                <input type="date" name="expire_date" class="form-control" required value="{{ old('expire_date') }}">
                                                @error('expire_date') <span class="text-danger">{{ $message }}</span> @enderror
                                            </div>
                                        </div>

                                        <!-- Buying Price -->
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Buying Price</label>
                                                <input type="text" name="buying_price" class="form-control" required value="{{ old('buying_price') }}">
                                                @error('buying_price') <span class="text-danger">{{ $message }}</span> @enderror
                                            </div>
                                        </div>

                                        <!-- Selling Price -->
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Selling Price</label>
                                                <input type="text" name="selling_price" class="form-control" required value="{{ old('selling_price') }}">
                                                @error('selling_price') <span class="text-danger">{{ $message }}</span> @enderror
                                            </div>
                                        </div>

                                        <!-- Product Image -->
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="form-label">Product Image</label>
                                                <input type="file" name="product_image" id="image" class="form-control" required>
                                                @error('product_image') <span class="text-danger">{{ $message }}</span> @enderror
                                            </div>
                                        </div>

                                        <!-- Image Preview -->
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <img id="showImage" src="{{ url('upload/no_image.jpg') }}" class="rounded-circle avatar-lg img-thumbnail" alt="profile-image">
                                            </div>
                                        </div>

                                    </div>

                                    <div class="text-end">
                                        <button type="submit" class="btn btn-success waves-effect waves-light mt-2">
                                            <i class="mdi mdi-content-save"></i> Save
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div> <!-- end card -->
                </div>
            </div>
        </div>
    </div>

    <!-- Preview JS -->
    <script type="text/javascript">
        $(document).ready(function(){
            $('#image').change(function(e){
                var reader = new FileReader();
                reader.onload =  function(e){
                    $('#showImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
        });
    </script>
@endsection
