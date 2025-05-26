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

    .form input,
    .form select,
    .form textarea {
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

    .error {
        color: red;
        font-size: 0.9em;
        margin-bottom: 10px;
    }

    #image-preview {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 15px;
    }

    #image-preview img {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .add-btn {
        margin-bottom: 15px;
        background-color: #28a745;
    }

    .add-btn:hover {
        background-color: #218838;
    }
 </style>

<form action="{{ route('landlord.account.store') }}" class="form" method="POST" enctype="multipart/form-data">
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
      <label for="images">Upload Images</label>

    <div id="image-fields">
        <input type="file" name="images[]" class="image-input" accept="image/*">
    </div>

    <button type="button" class="add-btn" onclick="addImageInput()">+ Add More Images</button>

    <div id="image-preview"></div>

    @error('images')
        <div class="error">{{ $message }}</div>
    @enderror
    @error('images.*')
        <div class="error">{{ $message }}</div>
    @enderror

    <input type="hidden" name="landlord_id" value="{{ auth()->id() }}">
    <button type="submit">Submit</button>
</form>
<script>
    const imageFields = document.getElementById('image-fields');
    const previewContainer = document.getElementById('image-preview');

    function addImageInput() {
        const input = document.createElement('input');
        input.type = 'file';
        input.name = 'images[]';
        input.accept = 'image/*';
        input.classList.add('image-input');
        input.style.marginBottom = '15px';

        input.addEventListener('change', handlePreview);
        imageFields.appendChild(input);
    }

    function handlePreview(event) {
        const files = event.target.files;

        Array.from(files).forEach(file => {
            const reader = new FileReader();

            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                previewContainer.appendChild(img);
            };

            reader.readAsDataURL(file);
        });
    }

    // Initial image input preview binding
    document.querySelectorAll('.image-input').forEach(input => {
        input.addEventListener('change', handlePreview);
    });
</script>
@endsection