@extends('layout.master')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- start: FORM VALIDATION 2 PANEL -->
            <div class="panel panel-default btn-squared">
                <div class="panel-heading">
                    <i class="fa fa-external-link-square"></i>
                    Edit Blog
                    <div class="panel-tools">
                        <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                        </a>
                        <a class="btn btn-xs btn-link panel-close" href="#">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="panel-body">
                    @if($errors->count() > 0 )
                        <div class="alert alert-danger btn-squared">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <h6>The following errors have occurred:</h6>
                            <ul>
                                @foreach( $errors->all() as $message )
                                    <li>{{ $message }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if(Session::has('message'))
                        <div class="alert alert-success btn-squared" role="alert">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            {{ Session::get('message') }}
                        </div>
                    @endif
                    @if(Session::has('errormessage'))
                        <div class="alert alert-danger btn-squared" role="alert">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            {{ Session::get('errormessage') }}
                        </div>
                    @endif
                    <form role="form" class="form-horizontal" action="{{ url('/life/update/id-'.$edit->id) }}"
                          id="blog" method="post" role="form" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">
                                    <strong>Life Pack Name</strong>
                                    <span class="symbol required" aria-required="true"></span>
                                </label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" value="{{$edit->life_pack_name}}" name="life_pack_name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">
                                    <strong>Life TYPE</strong>
                                    <span class="symbol required" aria-required="true"></span>
                                </label>
                                <div class="col-sm-8">
                                    <select id="form-field-select-3" class="form-control search-select" name="life_buy_type">
                                        <option value="">&nbsp;Please Select a Type</option>
                                        <option {{($edit->life_buy_type == 'free') ? 'selected' : ''}}  value="free">Free</option>
                                        <option {{($edit->life_buy_type == 'buy') ? 'selected' : ''}}  value="buy">Buy</option>

                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">
                                    <strong>Player</strong>
                                    <span class="symbol required" aria-required="true"></span>
                                </label>
                                <div class="col-sm-8">
                                    <select id="form-field-select-3" class="form-control search-select" name="player_id">
                                        <option value="">&nbsp;Please Select a Player</option>

                                        @if(!empty($all_player))
                                        @foreach($all_player as $key =>$list)
                                            <option {{($edit->player_id == $list->id) ? 'selected' : ''}} value="{{$list->id}}">{{$list->player_name}}</option>
                                        @endforeach
                                        @endif

                                    </select>
                                </div>
                            </div>

                            
                            <div class="form-group">
                                <label class="col-sm-2 control-label">
                                    <strong>Number Of Life </strong>
                                </label>
                                <div class="col-sm-4">
                                    <input type="number" class="form-control" value="{{$edit->num_of_life}}" name="num_of_life">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">
                                    <strong>Life Price </strong>
                                </label>
                                <div class="col-sm-4">
                                    <input type="number" class="form-control" value="{{$edit->life_price}}" name="life_price">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">
                                    <strong>Life Payment Type</strong>
                                    <span class="symbol required" aria-required="true"></span>
                                </label>
                                <div class="col-sm-8">
                                    <select id="form-field-select-3" class="form-control search-select" name="payment_type">
                                        <option {{($edit->payment_type == 'bkash') ? 'selected' : ''}} value="bkash">Bkash</option>
                                    </select>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-sm-2 control-label">
                                    <strong>Payment Transaction Id </strong>
                                </label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" value="{{$edit->payment_transaction_id}}" name="payment_transaction_id">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">
                                    <strong>Life Buy Date</strong>
                                    <span class="symbol required" aria-required="true"></span>
                                </label>
                                <div class="col-sm-6">
                                    <input type="date" class="form-control" value="{{$edit->life_buy_date}}" name="life_buy_date">
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-sm-2 control-label">
                                    <strong>Life Buy End Date</strong>
                                    <span class="symbol required" aria-required="true"></span>
                                </label>
                                <div class="col-sm-6">
                                    <input type="date" class="form-control" value="{{$edit->life_buy_end_date}}" name="life_buy_end_date">
                                </div>
                            </div>
                       
                        <div class="form-group">
                            <div class="col-sm-5">
                            </div>
                            <div class="col-sm-4">
                                <input class="btn btn-danger btn-squared" name="reset" value="Reset" type="reset">
                                <input class="btn btn-success btn-squared" name="submit" value="Update" type="submit">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('JScript')
    <script>
        $(function () {
            $('#blog').validate({
                rules: {
                    album_name: {
                        required: true
                    },
                    album_category: {
                        required: true
                    },
                    country:{
                        required: true
                    },
                    /*domain_name:{
                        required: true
                    },*/
                    service_name:{
                        required: true
                    },
                    album_tags: {
                        required: true
                    },
                    imdb_rating: {
                        number: true
                    },
                    album_genres: {
                        required: true
                    }
                },
                highlight: function (element) {
                    $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
                },
                unhighlight: function (element) {
                    $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
                },
                errorElement: 'span',
                errorClass: 'help-block',
                errorPlacement: function (error, element) {
                    if (element.parent('.input-group').length) {
                        error.insertAfter(element.parent());
                    } else {
                        error.insertAfter(element);
                        element.attr("placeholder",error.text());
                    }
                }
            });
        })
    </script>
@endsection