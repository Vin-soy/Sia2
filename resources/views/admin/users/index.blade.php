@extends('admin.dashboard')


@section('content')
<div class="add-user">
    <form action="{{ route('users.store') }}" method="POST">
        @csrf
    
        <div class="form-grid">
            <div class="form-column">
                <div class="form-group">
                    <label for="first_name">First Name:</label>
                    <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}">
                    @error('first_name')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>
    
                <div class="form-group">
                    <label for="middle_name">Middle Name:</label>
                    <input type="text" name="middle_name" id="middle_name" value="{{ old('middle_name') }}">
                    @error('middle_name')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>
    
                <div class="form-group">
                    <label for="last_name">Last Name:</label>
                    <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}">
                    @error('last_name')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>
            </div>
    
            <div class="form-column">
                <div class="form-group">
                    <label for="email">Email Name:</label>
                    <input type="text" name="email" id="email" value="{{ old('email') }}">
                    @error('email')
                        <div class="error" style="color: red">{{ $message }}</div>
                    @enderror
                </div>
    
                <div class="form-group">
                    <label for="birth_date">Birth Date:</label>
                    <input type="date" name="birth_date" id="birth_date" value="{{ old('birth_date') }}">
                    @error('birth_date')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>
    
                <div class="form-group">
                    <label for="contact">Contact Number:</label>
                    <input type="text" name="contact" id="contact" value="{{ old('contact') }}">
                    @error('contact')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>
            </div>
    
            <div class="form-column">
                <div class="form-group">
                    <label for="role">Role:</label>
                    <select name="role" id="role">
                        <option value="">-- Select Role --</option>
                        <option value="landlord" {{ old('role') == 'landlord' ? 'selected' : '' }}>Landlord</option>
                        <option value="tenant" {{ old('role') == 'tenant' ? 'selected' : '' }}>Tenant</option>
                    </select>
                    @error('role')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>
                
    
                <button type="submit" onclick="this.disabled=true; this.form.submit();">Add</button>
            </div>
        </div>
    </form>
    
    
</div>
<div class="user-container">
    <div class="tenant">
        <h2>Tenants</h2>
    
        <div class="tenant-col">
            @foreach ($tenants as $tenant)
                <div class="tenant-info">
                    <div class="left-side">
                        <img class="user-img" src="{{ asset('images/2.jpg') }}" alt="">
                        <p>{{ $tenant->name }}</p>
                    </div>
                    <div class="right-side">
                        <form action="{{ route('users.destroy', $tenant->id) }}" method="POST" onsubmit="return confirm('are you sure')">
                            @csrf
                            @method('DELETE')
                            <button type="submit">delete</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    
    <div class="landlord">
        <h2>Landlords</h2>
    
        <div class="tenant-col">
            @foreach ($landlords as $landlord)
                <div class="tenant-info">
                    <div class="left-side">
                        <img class="user-img" src="{{ asset('images/2.jpg') }}" alt="">
                        <p>{{ $landlord->name }}</p>
                    </div>
                    <div class="right-side">
                        <form action="{{ route('users.destroy', $landlord->id) }}" method="POST" onsubmit="return confirm('are you sure')">
                            @csrf
                            @method('DELETE')
                            <button type="submit">delete</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<script>
    const tenant = @json($landlords);
    console.log(tenant);
</script>
@endsection