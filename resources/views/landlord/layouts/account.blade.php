@extends('landlord.dashboard')

@section('content')
 <h1>Account</h1>
 <style>
    .form {
        display: flex;
        flex-direction: column;
        width: 300px;
        margin: 0 auto;
    }

    .form label {
        margin-bottom: 5px;
    }

    .form input {
        margin-bottom: 15px;
        padding: 10px;
        border-radius: 5px;
        border: 1px solid #ccc;
    }

    .form button {
        padding: 10px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .form button:hover {
        background-color: #0056b3;
    }
 </style>

<form action="{{ route('landlord.account.store') }}" class="form" method="POST">
    @csrf

    <label for="address">Address</label>
    <input type="text" name="address" id="address" placeholder="Enter your address" value="{{ old('address') }}">
    @error('address')
        <div class="error">{{ $message }}</div>
    @enderror

    <label for="description">Description</label>
    <input type="text" name="description" id="description" placeholder="Enter description" value="{{ old('description') }}">
    @error('description')
        <div class="error">{{ $message }}</div>
    @enderror

    <label for="price">Price</label>
    <input type="text" name="price" id="price" placeholder="Enter price" value="{{ old('price') }}">
    @error('price')
        <div class="error">{{ $message }}</div>
    @enderror

    <label for="number_of_rooms">Number of Rooms</label>
    <input type="text" name="number_of_rooms" id="number_of_rooms" placeholder="Enter number of rooms" value="{{ old('number_of_rooms') }}">
    @error('number_of_rooms')
        <div class="error">{{ $message }}</div>
    @enderror

    <label for="home_type">Home Type</label>
   
    <select name="home_type" id="home_type">
        <option value="available" {{ old('home_type') == 'available' ? 'selected' : '' }}>apartment</option>
        <option value="house" {{ old('home_type') == 'house' ? 'selected' : '' }}>house</option>
        <option value="studio" {{ old('home_type') == 'studio' ? 'selected' : '' }}>studio</option>
        <option value="duplex" {{ old('home_type') == 'duplex' ? 'selected' : '' }}>duplex</option>
        <option value="flat" {{ old('stathome_typeus') == 'flat' ? 'selected' : '' }}>flat</option>
    </select>
    @error('home_type')
        <div class="error">{{ $message }}</div>
    @enderror

    <label for="status">Status</label>
    <select name="status" id="status">
        <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Available</option>
        <option value="rented" {{ old('status') == 'rented' ? 'selected' : '' }}>Rented</option>
        <option value="under_maintenance" {{ old('status') == 'under_maintenance' ? 'selected' : '' }}>Under Maintenance</option>
    </select>
    @error('status')
        <div class="error">{{ $message }}</div>
    @enderror

    <input type="hidden" name="landlord_id" value="{{ auth()->id() }}">
    <button type="submit">Submit</button>
</form>


@endsection