

@extends('admin.layouts.app')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">					
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Order: #{{ $order->id}}</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('orders.index')}}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header pt-3">
                            <div class="row invoice-info">
                                <div class="col-sm-4 invoice-col">
                                <h1 class="h5 mb-3">Shipping Address</h1>
                                <address>
                                    <strong>{{ $order->first_name.' '.$order->last_name}}</strong><br>
                                   {{ $order->address}}<br>
                                   {{ $order->city}},  {{ $order->zip}}<br>
                                    Country:  {{ $order->countryName}}<br>
                                    Phone:  {{ $order->mobile}}<br>
                                    Email:  {{ $order->email}}
                                </address>
                                </div>
                                
                                
                                
                                <div class="col-sm-4 invoice-col">
                                    {{-- <b>Invoice #007612</b><br> --}}
                                    <br>
                                    <b>Order ID:</b>{{ $order->id}}<br>
                                    <b>Total:</b> ${{ number_format($order->grand_total,2)}}<br>
                                    <b>Status:</b>
                                    @if ($order->status == 'pending')
                                        <span class="text-danger">Pending</span>
                                    @elseif ($order->status == 'shipped')
                                        <span class="text-info">Shipped</span>
                                    @else
                                        <span class="text-success">Delivered</span>
                                    @endif
                                    <br>
                                </div>
                            </div>
                        </div>
                        <div class="card-body table-responsive p-3">								
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th width="100">Price</th>
                                        <th width="100">Qty</th>                                        
                                        <th width="100">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Call of Duty</td>
                                        <td>$10.00</td>                                        
                                        <td>2</td>
                                        <td>$20.00</td>
                                    </tr>
                                    <tr>
                                        <td>Call of Duty</td>
                                        <td>$10.00</td>                                        
                                        <td>2</td>
                                        <td>$20.00</td>
                                    </tr>
                                    <tr>
                                        <td>Call of Duty</td>
                                        <td>$10.00</td>                                        
                                        <td>2</td>
                                        <td>$20.00</td>
                                    </tr>
                                    <tr>
                                        <td>Call of Duty</td>
                                        <td>$10.00</td>                                        
                                        <td>2</td>
                                        <td>$20.00</td>
                                    </tr>
                                    <tr>
                                        <th colspan="3" class="text-right">Subtotal:</th>
                                        <td>$80.00</td>
                                    </tr>
                                    
                                    <tr>
                                        <th colspan="3" class="text-right">Shipping:</th>
                                        <td>$5.00</td>
                                    </tr>
                                    <tr>
                                        <th colspan="3" class="text-right">Grand Total:</th>
                                        <td>$85.00</td>
                                    </tr>
                                </tbody>
                            </table>								
                        </div>                            
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="h4 mb-3">Order Status</h2>
                            <div class="mb-3">
                                <select name="status" id="status" class="form-control">
                                    <option value="">Pending</option>
                                    <option value="">Shipped</option>
                                    <option value="">Delivered</option>
                                    <option value="">Cancelled</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <button class="btn btn-primary">Update</button>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h2 class="h4 mb-3">Send Inovice Email</h2>
                            <div class="mb-3">
                                <select name="status" id="status" class="form-control">
                                    <option value="">Customer</option>                                                
                                    <option value="">Admin</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <button class="btn btn-primary">Send</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
</div>

@endsection

@section('customJs')

@endsection