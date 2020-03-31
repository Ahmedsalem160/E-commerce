@extends('layouts.app')

@section('content')

    <div class="container">
        
         
        @if(session()->has('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif
        <section>
            <div class="row">
                @foreach($Products as $product)
                    <div class="col-md-4">
                        <div class="card mb-2">
                            <img src="{{$product->image}}" class="card-img-top">
                            <div class="card-body">
                                <h5 class="card-title">{{$product->title}}</h5>
                                <p class="card-text">the card title andthe card's content.</p>
                                <b>{{$product->price}}$</b><hr/>
                                <a href="{{route('cart.add',$product->id )}}" class="btn btn-primary">Buy</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

    </div>

@endsection