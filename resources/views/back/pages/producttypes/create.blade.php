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
                            Create Product Type
                        </div>
                        <form action="{{ route('producttypes.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Product Type</label>
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-user"></i>
                                                </div>
                                                <input type="text" class="form-control" name="name"
                                                    placeholder="Enter Product Type" required>
                                            </div>
                                            @if ($errors->has('name'))
                                                <div class="error" style="margin-left:8px; margin-top:5px; color:red;">
                                                    {{ $errors->first('name') }}</div>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label>Description</label>
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-comment"></i>
                                                </div>
                                                <textarea class="form-control" name="description" rows="3" placeholder="Enter Product Type Description"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
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
