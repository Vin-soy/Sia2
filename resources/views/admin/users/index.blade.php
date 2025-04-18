@extends('admin.dashboard')


@section('content')
<div class="add-user">
    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        <label for="">First Name:</label>
        <input type="text" name="first_name" id="">
        <label for="">Middle Name:</label>
        <input type="text" name="" id="">
        <label for="">Email Name:</label>
        <input type="text" name="email" id="">
        <label for="">Birth Date</label>
        <input type="date" name="" id="">

        <button href="" type="submit">add</button>
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

@endsection