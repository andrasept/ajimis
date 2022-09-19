@extends('layouts.app-master')
 
@section('title', 'AJI PORTAL | EDIT USER')
 
 
@section('content')
    <div class="ibox " >
        <div class="ibox-title">
            <h4>Add Part</h4>
        </div>
        <div class="ibox-content" >
            @if(session()->has('fail'))
                <div class="alert alert-danger">{{session('fail')}}</div>
            @endif
          <div style="overflow-x: auto">
            <form action="{{route('delivery.master.master_part.insert')}}" method="post">
                {{csrf_field()}}
                {{method_field("PUT")}}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>SKU</label> 
                            <input type="number" placeholder="sku" name="sku" class="form-control @error('sku') is-invalid @enderror" value="{{old('sku')}}">
                            @error('sku') 
                                <div class="text-danger">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Part Name</label> 
                            <input type="text" placeholder="part name" name="part_name" class="form-control @error('part_name') is-invalid @enderror" value="{{old('part_name')}}">
                            @error('part_name') 
                                <div class="text-danger">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Part No Customer</label> 
                            <input type="text" placeholder="part no customer" name="part_no_customer" class="form-control @error('part_no_customer') is-invalid @enderror" value="{{old('part_no_customer')}}">
                            @error('part_no_customer') 
                                <div class="text-danger">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label>Packaging Code</label> 
                            <select name="packaging_id" class="form-control @error('packaging_id') is-invalid @enderror" id="packaging_id">
                                <option value="-">-</option>
                                @foreach ($packagings as $packaging)
                                <option value="{{$packaging->packaging_code}}" >{{$packaging->packaging_code}}</option>
                                @endforeach
                            </select>
                            @error('packaging_id') 
                                <div class="text-danger">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Part Card</label> 
                            <select name="color_id" class="form-control @error('color_id') is-invalid @enderror" id="color_id">
                                <option value="-">-</option>
                                @foreach ($partcards as $partcard)
                                <option value="{{$partcard->color_code}}" >{{$partcard->description}}</option>
                                @endforeach
                            </select>
                            @error('color_id') 
                                <div class="text-danger">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Addresing</label> 
                            <input type="text" placeholder="addresing" name="addresing" class="form-control" value="{{old('addresing')}}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Part No AJI</label> 
                            <input type="text" placeholder="part no aji" name="part_no_aji" class="form-control @error('part_no_aji') is-invalid @enderror" value="{{old('part_no_aji')}}">
                            @error('part_no_aji') 
                                <div class="text-danger">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Model</label> 
                            <input type="text" placeholder="model" name="model" class="form-control @error('model') is-invalid @enderror" value="{{old('model')}}">
                            @error('model') 
                                <div class="text-danger">
                                    {{$message}}
                                </div>
                            @enderror
                        </div> 
                        <div class="form-group">
                            <label>Cycle Time</label> 
                            <input type="number" placeholder="cycle time" name="cycle_time" class="form-control @error('cycle_time') is-invalid @enderror" value="0">
                            @error('cycle_time') 
                                <div class="text-danger">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label>Customer</label> 
                            <select name="customer_id" class="form-control  @error('customer_id') is-invalid @enderror" id="customer_id">
                                <option value="-">-</option>
                                @foreach ($customers as $customer)
                                <option value="{{$customer->customer_code}}" >{{$customer->customer_name}}</option>
                                @endforeach
                            </select>
                            @error('customer_id') 
                                <div class="text-danger">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Line</label> 
                            <select name="line_id" class="form-control @error('line_id') is-invalid @enderror" id="line_id">
                                <option value="-">-</option>
                                @foreach ($lines as $line)
                                <option value="{{$line->line_code}}" >{{$line->line_name}}</option>
                                @endforeach
                            </select>
                            @error('line_id') 
                                <div class="text-danger">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Category</label> 
                            <select name="category" class="form-control" id="category">
                                <option value="-">-</option> 
                                <option value="FG" >FG</option> 
                                <option value="SFG">SFG</option> 
                            </select>
                        </div>
                    </div>
                </div>
          </div>
        </div>
        <div class="ibox-footer text-right">
                <button class="btn btn-primary btn-sm " >Save</button>
        </form>
                <a class="btn btn-default float-left" href="{{route('delivery.master.master_part')}}">Back</a>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // mini nav bar
        $("body").addClass("body-small mini-navbar");
    // huruf kecil table
      $(".ibox").css({fontSize:10, textTransform:'Uppercase'});
      $("select").css({fontSize:12});
      $("input").css({fontSize:12});
</script>
@endpush




















