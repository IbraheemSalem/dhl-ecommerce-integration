@extends('dhl::layout')

@section('content')
<h3>DHL Settings</h3>

@if(session('success'))
    <div class="alert success">{{ session('success') }}</div>
@endif

<form method="POST" action="{{ route('dhl.admin.settings.save') }}">
    @csrf
    <label>Default Account Number</label>
    <input type="text" name="account" value="{{ $config['account'] }}">

    <label>Webhook Secret</label>
    <input type="text" name="webhook_secret" value="{{ $config['webhook_secret'] }}">

    <button class="btn btn-primary">Save Settings</button>
</form>
@endsection
