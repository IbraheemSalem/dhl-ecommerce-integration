@extends('dhl::layout')

@section('content')
<h3>Merchants</h3>

@if(session('success'))
    <div class="alert success">{{ session('success') }}</div>
@endif

<form method="POST" action="{{ route('dhl.admin.merchants.add') }}">
    @csrf
    <div class="form-group">
        <input type="text" name="name" placeholder="Merchant Name">
        <input type="text" name="client_id" placeholder="Client ID">
        <input type="text" name="client_secret" placeholder="Client Secret">
        <input type="text" name="account_number" placeholder="Account Number">
    </div>
    <button>Add Merchant</button>
</form>

<hr>

<table class="dhl-table">
    <thead>
    <tr>
        <th>Name</th>
        <th>Account No.</th>
        <th>Status</th>
    </tr>
    </thead>
    <tbody>
    @foreach($merchants as $merchant)
        <tr>
            <td>{{ $merchant->name }}</td>
            <td>{{ $merchant->account_number }}</td>
            <td>{{ $merchant->active ? 'Active' : 'Disabled' }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
@endsection
