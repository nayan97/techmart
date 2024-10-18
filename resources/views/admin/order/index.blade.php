

@extends('admin.layouts.app')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">					
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Orders</h1>
                </div>
                <div class="col-sm-6 text-right">
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <div class="card-tools">
                        <div class="input-group input-group" style="width: 250px;">
                            <input type="text" name="table_search" class="form-control float-right" placeholder="Search">
        
                            <div class="input-group-append">
                              <button type="submit" class="btn btn-default">
                                <i class="fas fa-search"></i>
                              </button>
                            </div>
                          </div>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">								
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>Orders #</th>											
                                <th>Customer</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Status</th>
                                <th>Total</th>
                                <th>Date Purchased</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($orders->isNotEmpty())
                                @foreach ($orders as $order)
                                <tr>
                                    <td><a href="order-detail.html">{{ $order->id}}</a></td>
                                    <td>{{ $order->name}}</td>
                                    <td>{{ $order->email}}</td>
                                    <td>{{ $order->mobile}}</td>
                                    <td>
                                        @if ($order->status == 'pending')
                                          <span class="badge bg-danger">Pending</span>
                                        @elseif ($order->status == 'shipped')
                                          <span class="badge bg-info">Shipped</span>
                                        @else
                                          <span class="badge bg-success">Delivered</span>
                                        @endif
                                    </td>
                                    <td>{{ number_format($order->grand_total,2)}}</td>
                                    <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d M Y') }}</td>																				
                                </tr>
                                @endforeach
                                
                            @else
                                
                            @endif
                         
            
                        </tbody>
                    </table>										
                </div>
                <div class="card-footer clearfix">
                    <ul class="pagination pagination m-0 float-right">
                      <li class="page-item"><a class="page-link" href="#">«</a></li>
                      <li class="page-item"><a class="page-link" href="#">1</a></li>
                      <li class="page-item"><a class="page-link" href="#">2</a></li>
                      <li class="page-item"><a class="page-link" href="#">3</a></li>
                      <li class="page-item"><a class="page-link" href="#">»</a></li>
                    </ul>
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