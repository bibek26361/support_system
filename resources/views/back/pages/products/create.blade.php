@extends('back.layouts.main')
@section('content')
<div id="page-wrapper">
    <div class="row">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header"> Manage Products</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        Create Product
                    </div>
                    <form action="{{ route('products.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="panel-body">
                            <div class="row">

                                <div class="col-lg-6">
                                    <label>Product Type :</label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-user"></i>
                                        </div>
                                        <select name="product_type_id" class="form-control ">
                                            <option value="">Select Product Type</option>
                                            @foreach ($productType as $productTypes)
                                            <option value="{{ $productTypes->id }}">
                                                {{ $productTypes->name }}
                                            </option>
                                            @endforeach
                                            @if ($errors->has('product_type_id'))
                                            <span class="error text-danger">
                                                {{ $errors->first('product_type_id') }}</span>
                                            @endif
                                        </select>

                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <label>Photo</label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-file"></i>
                                        </div>
                                        <input type="file" class="form-control" name="image">
                                        @if ($errors->has('image'))
                                        <span class="error text-danger">
                                            {{ $errors->first('image') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <label>Product Name</label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-user"></i>
                                        </div>
                                        <input type="text" class="form-control" name="name" placeholder="Enter Product Name">
                                    </div>
                                    @if ($errors->has('name'))
                                    <div class="error" style="margin-left:8px; margin-top:5px; color:red;">
                                        {{ $errors->first('name') }}
                                    </div>
                                    @endif
                                </div>

                                <div class="col-lg-6">
                                    <label>Status:</label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-user"></i>
                                        </div>
                                        <select class="form-control" name="status" id="status">
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <label>Description</label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-comment"></i>
                                        </div>
                                        <textarea class="form-control" name="description" rows="3" placeholder="Enter Product Type Description"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="panel-footer">
                    <button type="submit" class="btn btn-success">Create</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>
@endsection