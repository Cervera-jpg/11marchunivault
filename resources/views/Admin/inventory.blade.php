@extends('layouts.user_type.auth')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6>INVENTORY SUPPLIES</h6>
                        <a href="{{ route('admin.stock.supplyinventory') }}" class="btn btn-primary" style="background-color: #821131;">+ ADD ITEM</a>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Control Code</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Product Name</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Quantity</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Unit Type</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Image</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($supplies as $supply)
                                <tr>
                                    <td class="align-middle text-sm">
                                        <p class="text-sm font-weight-bold mb-0">{{ $supply->control_code }}</p>
                                    </td>
                                    <td class="align-middle text-sm">
                                        <p class="text-sm font-weight-bold mb-0">{{ $supply->product_name }}</p>
                                    </td>
                                    <td class="align-middle text-sm">
                                        <p class="text-sm font-weight-bold mb-0 text-center">{{ $supply->quantity }}</p>
                                    </td>
                                    <td class="align-middle text-sm">
                                        @if($supply->quantity == 0)
                                            <span class="badge badge-sm" style="background-color: #FF0000;">
                                                Out of Stock
                                            </span>
                                        @elseif($supply->quantity <= 50)
                                            <span class="badge badge-sm"  style="background-color: #ffd700;">
                                                Low Stock
                                            </span>
                                        @else
                                            <span class="badge badge-sm bg-success">
                                                In Stock
                                            </span>
                                        @endif
                                    </td>
                                    <td class="align-middle text-sm">
                                        <p class="text-sm font-weight-bold mb-0">{{ $supply->unit_type }}</p>
                                    </td>
                                    <td class="align-middle text-sm">
                                        @if($supply->product_image)
                                            <img src="{{ asset('storage/' . $supply->product_image) }}" alt="{{ $supply->product_name }}" style="max-width: 50px;">
                                        @else
                                            No Image
                                        @endif
                                    </td>
                                    <td class="align-middle">
                                        <a href="{{ route('admin.supplies.edit', $supply->id) }}" style="text-decoration: none;">
                                            <span class="badge bg-dark">
                                                <i class="fas fa-pencil-alt"></i> EDIT
                                            </span>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


