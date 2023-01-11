@extends('back.layouts.main')
@section('content')
<div id="page-wrapper">
    <div class="row">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header"> Edit Products</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        Edit Product
                    </div>
                    <form action="{{ route('products.update', $product->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
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
                                            <option value="{{ $productTypes->id }}" {{$productTypes->id === $product->product_type_id ? 'selected' : ''}}>
                                                {{ $productTypes->name }}
                                            </option>
                                            @endforeach
                                            @if ($errors->has('product_type_id'))
                                            <div class="error" style="margin-left:8px; margin-top:5px; color:red;">
                                                {{ $errors->first('product_type_id') }}
                                            </div>
                                            @endif
                                        </select>

                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <label>Photo</label>
                                    <img src="../../public/images/products/{{ $product->image }}" height="80" width="80"><br><br>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-file"></i>
                                        </div>
                                        <input type="file" class="form-control" name="image">
                                        @if ($errors->has('image'))
                                        <div class="error" style="margin-left:8px; margin-top:5px; color:red;">
                                            {{ $errors->first('image') }}
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <label>Product Name</label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-user"></i>
                                        </div>
                                        <input type="text" class="form-control" name="name" placeholder="Enter Product Name" value="{{$product->name}}">
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
                                            <option value="1" {{ $product->status ? 'selected' : '' }}>Active
                                            </option>
                                            <option value="0" {{ $product->status ? '' : 'selected' }}>Inactive
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <label>Description</label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-comment"></i>
                                        </div>
                                        <textarea class="form-control" name="description" rows="3" placeholder="Enter Product Type Description">{{$product->description}}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <button type="submit" class="btn btn-success">Update</button>
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