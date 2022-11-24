@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }} <a href="{{route('products.create')}}" class="btn btn-secondary float-right">Ürün Ekle</a></div>
                <div class="p-2">

                    <table id="example" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>Resim</th>
                                <th>Ürün Adı</th>
                                <th>Ürün Açıklaması</th>
                                <th>Stok Miktarı</th>
                                <th>Ürün Fiyatı</th>
                                <th>Ekleme Tarihi</th>
                                <th>Satış Yap</th>
                                <th>Güncelle</th>
                                <th>Sil</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($data['products'] as $product)
                            <tr>
                                <td><img width="80" src="{{ url('images/products/'.$product->image) }}" alt=""></td>
                                <td>{{$product->name}}</td>
                                <td><textarea class="form-control" name="" id="" cols="10" rows="2">{{$product->description}}</textarea></td>
                                <td>{{$product->stok}}</td>
                                <td>{{$product->price}}</td>
                                <td>2011-04-25</td>

                                <td>
                                    <a href="javascript:void(0)" type="submit" class="btn btn-secondary salesButton" id="{{$product->id}}">
                                        Satış
                                    </a>
                                </td>

                                <td width="10">
                                    <a href="{{route('products.edit',$product->id)}}" type="submit" class="btn btn-warning">
                                        güncel
                                    </a>
                                </td>

                                <td>
                                    <a href="javascript:void(0)" class="btn btn-danger deleteButton">
                                        <i id="{{$product->id}}" class="fas fa-trash"></i>
                                    </a>
                                </td>

                            </tr>



                            @endforeach

                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Resim</th>
                                <th>Ürün Adı</th>
                                <th>Ürün Açıklaması</th>
                                <th>Stok Miktarı</th>
                                <th>Ürün Fiyatı</th>

                                <th>Ekleme Tarihi</th>
                                <th>Satış Yap</th>

                                <th>Güncelle</th>
                                <th>Sil</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>


                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(".deleteButton").click(function() {
        destroy_id = $(this).attr('id');
        alertify.confirm('Silme işlemini onaylayın', 'Bu işlem geri alınamaz',
            function() {
                $.ajax({
                    type: "DELETE",
                    url: "products/" + destroy_id,
                    success: function(msg) {
                        if (msg) {
                            $("#item-" + destroy_id).remove();
                            alertify.success("Silme İşlemi Tamamlandı");
                        } else {
                            alertify.error("İşlem Tamamlanamadı");
                        }
                    }
                });
            },
            function() {
                alertify.error('Silme İşlemi İptal Edildi');
            }
        )
    });



    $(".salesButton").click(function() {
        product_id = $(this).attr('id');


        let data = { 
            product_id: product_id 
        }

        $.ajax({
            type: "GET",
            data: data,
            url: "/addsales",
            success: function(msg) {
                if (msg) {

                    alertify.success(msg);
                } else {
                    alertify.error("İşlem Tamamlanamadı");
                }
            }
        });

    });
</script>
@endsection