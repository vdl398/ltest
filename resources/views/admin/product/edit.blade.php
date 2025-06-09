@extends('layouts')

@vite(['resources/js/product_edit.js'])

@section('content')


@if(session('success'))
    <div class="alert alert-success">
        {{session('success')}}
    </div>
@endif
@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
    </div>
@endif
<div><a style="color: blue;" href="/admin/product">к списку</a></div>
<form style="margin-top: 30px;" method="POST" action="{{ url('/admin/product'.($product? '/'.$product->id : '')) }}" id="main_form" enctype="multipart/form-data">
    @if ($product)
        @method('put')
    @endif								
    @csrf
    <div class="mb-3 row">
                        <label for="name" class="col-md-4 col-form-label text-md-end text-start">Название</label>
                        <div class="col-md-6">
                          <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{($product)? $product->name : old('name')}}">
                            @if ($errors->has('name'))
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
    </div>
    <div class="mb-3 row">
                        <label for="description" class="col-md-4 col-form-label text-md-end text-start">Описание</label>
                        <div class="col-md-6">
                          <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description">{{($product)? $product->description : old('description')}}</textarea>
                            @if ($errors->has('description'))
                                <span class="text-danger">{{ $errors->first('description') }}</span>
                            @endif
                        </div>
    </div>
    <div class="mb-3 row">
                        <label for="price" class="col-md-4 col-form-label text-md-end text-start">Цена</label>
                        <div class="col-md-6">
                          <input type="number" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{($product)? $product->priceFormated : old('price')}}">
                            @if ($errors->has('price'))
                                <span class="text-danger">{{ $errors->first('price') }}</span>
                            @endif
                        </div>
    </div>
    <div class="mb-3 row">
                        <label for="category_id" class="col-md-4 col-form-label text-md-end text-start">Категория</label>
                        <div class="col-md-6">
							<select id="category_id" name="category_id">
							    <option value="">Не выбрано</option>
								<?php
								   $categoryVal  = ($product)? $product->category_id : old('category_id');
								?>
                                @foreach ($categories as $key => $value)
                                <option value="{{ $value->id}}"
                                    @if ($value->id == $categoryVal)
                                         selected="selected"
                                    @endif
                                >{{ $value->name}}</option>
                                @endforeach
                            </select>
							@if ($errors->has('category_id'))
                                <span class="text-danger">{{ $errors->first('category_id') }}</span>
                            @endif
                        </div>
    </div>

</form>
<div class="col-md-3 offset-md-5" style="display: flex;">
<button class="btn btn-primary" id="save_btn">Save</button>
@if ($product)
	<button class="btn btn-primary" style="background: red; margin-left: 20px;" id="delete_btn">Delete</button>
	<form method="POST" action="{{ url('/admin/product/'.$product->id) }}" id="delete_form">
        @csrf
        @method('DELETE')
	</form>
@endif
</div>
@endsection