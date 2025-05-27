@extends('landlord.dashboard')

@section('content')
<div class="account-container">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-content">
            <h1><i class="bx bx-building-house"></i> Add New Property</h1>
            <p>Fill in the details below to create a new property listing</p>
        </div>
    </div>

    @if ($errors->any())
    <div class="alert alert-error">
        <i class="bx bx-error-circle"></i>
        <div class="alert-content">
            <h4>Error</h4>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

    @if (session('success'))
    <div class="alert alert-success">
        <i class="bx bx-check-circle"></i>
        <div class="alert-content">
            <h4>Success</h4>
            <p>{{ session('success') }}</p>
        </div>
    </div>
    @endif

    <form action="{{ route('landlord.account.store') }}" class="property-form" method="POST" enctype="multipart/form-data" id="propertyForm">
        @csrf
        
        <div class="form-grid">
            <!-- Basic Information -->
            <div class="form-section">
                <div class="section-header">
                    <h2><i class="bx bx-info-circle"></i> Basic Information</h2>
                </div>
                
                <div class="info-grid">
                    <div class="info-group full-width">
                        <label for="address">Property Address</label>
                        <div class="input-wrapper">
                            <i class="bx bx-map"></i>
                            <input type="text" name="address" id="address" placeholder="Enter complete property address" value="{{ old('address') }}" class="form-input" required>
                        </div>
                        @error('address')
                            <div class="error-message"><i class="bx bx-error"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="info-group full-width">
                        <label for="description">Property Description</label>
                        <div class="input-wrapper">
                            <textarea name="description" id="description" placeholder="Describe your property's features and amenities" class="form-input" rows="4" required>{{ old('description') }}</textarea>
                        </div>
                        @error('description')
                            <div class="error-message"><i class="bx bx-error"></i> {{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Property Details -->
            <div class="form-section">
                <div class="section-header">
                    <h2><i class="bx bx-detail"></i> Property Details</h2>
                </div>
                
                <div class="info-grid">
                    <div class="info-group">
                        <label for="home_type">Property Type</label>
                        <div class="input-wrapper">
                            <i class="bx bx-home"></i>
                            <select name="home_type" id="home_type" class="form-select" required>
                                <option value="" disabled selected>Select property type</option>
                                <option value="apartment" {{ old('home_type') == 'apartment' ? 'selected' : '' }}>Apartment</option>
                                <option value="house" {{ old('home_type') == 'house' ? 'selected' : '' }}>House</option>
                                <option value="studio" {{ old('home_type') == 'studio' ? 'selected' : '' }}>Studio</option>
                                <option value="duplex" {{ old('home_type') == 'duplex' ? 'selected' : '' }}>Duplex</option>
                                <option value="flat" {{ old('home_type') == 'flat' ? 'selected' : '' }}>Flat</option>
                            </select>
                        </div>
                        @error('home_type')
                            <div class="error-message"><i class="bx bx-error"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="info-group">
                        <label for="price">Monthly Rent</label>
                        <div class="input-wrapper">
                            <i class="bx bx-money"></i>
                            <input type="number" name="price" id="price" placeholder="Enter monthly rent" value="{{ old('price') }}" class="form-input" min="0" step="0.01" required>
                        </div>
                        @error('price')
                            <div class="error-message"><i class="bx bx-error"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="info-group">
                        <label for="number_of_rooms">Number of Rooms</label>
                        <div class="input-wrapper">
                            <i class="bx bx-bed"></i>
                            <input type="number" name="number_of_rooms" id="number_of_rooms" placeholder="Enter number of rooms" value="{{ old('number_of_rooms') }}" class="form-input" min="1" required>
                        </div>
                        @error('number_of_rooms')
                            <div class="error-message"><i class="bx bx-error"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="info-group">
                        <label for="status">Availability Status</label>
                        <div class="input-wrapper">
                            <i class="bx bx-check-circle"></i>
                            <select name="status" id="status" class="form-select" required>
                                <option value="" disabled selected>Select status</option>
                                <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Available</option>
                                <option value="rented" {{ old('status') == 'rented' ? 'selected' : '' }}>Rented</option>
                                <option value="under_maintenance" {{ old('status') == 'under_maintenance' ? 'selected' : '' }}>Under Maintenance</option>
                            </select>
                        </div>
                        @error('status')
                            <div class="error-message"><i class="bx bx-error"></i> {{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Image Upload Section -->
        <div class="form-section">
            <div class="section-header">
                <h2><i class="bx bx-images"></i> Property Images</h2>
            </div>
            
            <div class="upload-container">
                <!-- Front Image Upload -->
                <div class="front-image-section">
                    <h3>Front Image (Required)</h3>
                    <p class="upload-info">This will be the main image of your property</p>
                    
                    <div class="front-image-upload" id="front-image-area">
                        <div class="upload-placeholder" id="front-image-placeholder">
                            <i class="bx bx-building-house"></i>
                            <p>Upload Front View</p>
                            <label class="upload-btn" for="front-image-input">
                                Choose Image
                                <input type="file" id="front-image-input" name="front_image" accept="image/jpeg,image/png,image/jpg" class="hidden-input" onchange="handleFrontImageUpload(event)" required>
                            </label>
                        </div>
                        <div id="front-image-preview" class="front-image-preview"></div>
                        @error('front_image')
                            <div class="error-message"><i class="bx bx-error"></i> {{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Sub Images Upload -->
                <div class="sub-images-section">
                    <h3>Additional Images (Optional)</h3>
                    <p class="upload-info">Add up to 4 more images of your property</p>
                    
                    <div class="sub-images-upload" id="sub-images-area">
                        <div class="upload-area" id="upload-area">
                            <i class="bx bx-cloud-upload"></i>
                            <h3>Drag & Drop Images Here</h3>
                            <p>or</p>
                            <label class="upload-btn" for="sub-images-input">
                                Choose Files
                                <input type="file" id="sub-images-input" name="sub_images[]" multiple accept="image/jpeg,image/png,image/jpg" class="hidden-input" onchange="handleSubImagesUpload(event)">
                            </label>
                            <p class="upload-info">Maximum 4 images, JPEG or PNG (max. 5MB each)</p>
                        </div>

                        <div class="preview-container">
                            <div class="preview-header">
                                <h3>Additional Images (<span id="sub-image-count">0</span>/4)</h3>
                                <button type="button" class="clear-btn" onclick="clearSubImages()">
                                    <i class="bx bx-trash"></i> Clear All
                                </button>
                            </div>
                            <div id="sub-images-preview" class="image-preview"></div>
                            @error('sub_images')
                                <div class="error-message"><i class="bx bx-error"></i> {{ $message }}</div>
                            @enderror
                            @error('sub_images.*')
                                <div class="error-message"><i class="bx bx-error"></i> {{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <input type="hidden" name="landlord_id" value="{{ auth()->id() }}">
        
        <div class="form-actions">
            <button type="button" class="cancel-btn" onclick="history.back()">
                <i class="bx bx-x"></i> Cancel
            </button>
            <button type="submit" class="submit-btn" id="submitBtn">
                <i class="bx bx-check"></i> Create Property
            </button>
        </div>
    </form>
</div>

<style>
/* Container */
.account-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem;
}

/* Page Header */
.page-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 16px;
    padding: 2rem;
    margin-bottom: 2rem;
    color: white;
}

.page-header h1 {
    font-size: 1.75rem;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.page-header p {
    margin: 0.5rem 0 0;
    opacity: 0.9;
}

/* Form Layout */
.property-form {
    display: flex;
    flex-direction: column;
    gap: 2rem;
}

.form-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(500px, 1fr));
    gap: 2rem;
}

/* Form Sections */
.form-section {
    background: white;
    border-radius: 16px;
    padding: 1.75rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
}

.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.75rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid #e2e8f0;
}

.section-header h2 {
    font-size: 1.25rem;
    color: #2d3748;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.section-header h2 i {
    font-size: 1.5rem;
    color: #4a5568;
}

/* Form Groups */
.info-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.5rem;
}

.info-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.info-group.full-width {
    grid-column: span 2;
}

.info-group label {
    font-size: 0.9rem;
    color: #4a5568;
    font-weight: 500;
}

.input-wrapper {
    position: relative;
    display: flex;
    align-items: center;
}

.input-wrapper i {
    position: absolute;
    left: 1rem;
    color: #718096;
    font-size: 1.25rem;
}

.form-input,
.form-select {
    width: 100%;
    padding: 0.75rem 1rem 0.75rem 2.75rem;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    font-size: 1rem;
    color: #2d3748;
    background: #f8fafc;
    transition: all 0.3s ease;
}

textarea.form-input {
    padding-left: 1rem;
    min-height: 120px;
    resize: vertical;
}

.form-input:focus,
.form-select:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    background: white;
}

/* Upload Area */
.upload-container {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.upload-area {
    border: 2px dashed #e2e8f0;
    border-radius: 12px;
    padding: 2rem;
    text-align: center;
    background: #f8fafc;
    transition: all 0.3s ease;
}

.upload-area:hover {
    border-color: #667eea;
    background: white;
}

.upload-area i {
    font-size: 3rem;
    color: #667eea;
    margin-bottom: 1rem;
}

.upload-area h3 {
    margin: 0;
    color: #2d3748;
    font-size: 1.25rem;
}

.upload-area p {
    margin: 0.5rem 0;
    color: #718096;
}

.upload-btn {
    display: inline-block;
    padding: 0.75rem 1.5rem;
    background: #667eea;
    color: white;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
    margin: 1rem 0;
}

.upload-btn:hover {
    background: #5a67d8;
    transform: translateY(-2px);
}

.hidden-input {
    display: none;
}

.upload-info {
    font-size: 0.875rem;
    color: #718096;
}

/* Preview Area */
.preview-container {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    border: 1px solid #e2e8f0;
}

.preview-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.preview-header h3 {
    margin: 0;
    font-size: 1.1rem;
    color: #2d3748;
}

.clear-btn {
    padding: 0.5rem 1rem;
    background: #fff;
    color: #e53e3e;
    border: 1px solid #e53e3e;
    border-radius: 8px;
    cursor: pointer;
    font-size: 0.875rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
}

.clear-btn:hover {
    background: #e53e3e;
    color: white;
}

.image-preview {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
    gap: 1rem;
}

.preview-item {
    position: relative;
    border-radius: 8px;
    overflow: hidden;
    aspect-ratio: 1;
}

.preview-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.remove-btn {
    position: absolute;
    top: 0.5rem;
    right: 0.5rem;
    background: rgba(0, 0, 0, 0.5);
    color: white;
    border: none;
    border-radius: 50%;
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
}

.remove-btn:hover {
    background: rgba(229, 62, 62, 0.9);
    transform: scale(1.1);
}

/* Error Messages */
.error-message {
    color: #e53e3e;
    font-size: 0.875rem;
    margin-top: 0.25rem;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

/* Form Actions */
.form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 1rem;
    margin-top: 2rem;
}

.submit-btn,
.cancel-btn {
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 8px;
    font-size: 1rem;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
}

.submit-btn {
    background: #667eea;
    color: white;
}

.cancel-btn {
    background: #edf2f7;
    color: #4a5568;
}

.submit-btn:hover,
.cancel-btn:hover {
    transform: translateY(-2px);
}

.submit-btn:hover {
    background: #5a67d8;
}

.cancel-btn:hover {
    background: #e2e8f0;
}

/* Responsive Design */
@media (max-width: 768px) {
    .account-container {
        padding: 1rem;
    }

    .form-grid {
        grid-template-columns: 1fr;
    }

    .info-grid {
        grid-template-columns: 1fr;
    }

    .info-group.full-width {
        grid-column: span 1;
    }

    .form-actions {
        flex-direction: column-reverse;
    }

    .submit-btn,
    .cancel-btn {
        width: 100%;
        justify-content: center;
    }
}

/* Alert Styles */
.alert {
    margin-bottom: 2rem;
    padding: 1rem;
    border-radius: 8px;
    display: flex;
    align-items: flex-start;
    gap: 1rem;
}

.alert i {
    font-size: 1.5rem;
    padding-top: 0.2rem;
}

.alert-content {
    flex: 1;
}

.alert-content h4 {
    margin: 0 0 0.5rem 0;
    font-size: 1.1rem;
}

.alert-content ul {
    margin: 0;
    padding-left: 1.5rem;
}

.alert-content p {
    margin: 0;
}

.alert-error {
    background-color: #FEE2E2;
    border: 1px solid #FCA5A5;
    color: #B91C1C;
}

.alert-success {
    background-color: #DCFCE7;
    border: 1px solid #86EFAC;
    color: #15803D;
}

/* Front Image Styles */
.front-image-section {
    margin-bottom: 2rem;
    padding-bottom: 2rem;
    border-bottom: 1px solid #e2e8f0;
}

.front-image-upload {
    width: 100%;
    max-width: 400px;
    margin: 0 auto;
}

.upload-placeholder {
    border: 2px dashed #e2e8f0;
    border-radius: 12px;
    padding: 2rem;
    text-align: center;
    background: #f8fafc;
    transition: all 0.3s ease;
}

.upload-placeholder i {
    font-size: 3rem;
    color: #667eea;
    margin-bottom: 1rem;
}

.front-image-preview {
    display: none;
    position: relative;
    width: 100%;
    height: 300px;
    border-radius: 12px;
    overflow: hidden;
    margin-top: 1rem;
}

.front-image-preview img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.front-image-preview .remove-btn {
    position: absolute;
    top: 1rem;
    right: 1rem;
    background: rgba(0, 0, 0, 0.5);
    color: white;
    border: none;
    border-radius: 50%;
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
}

.front-image-preview .remove-btn:hover {
    background: rgba(229, 62, 62, 0.9);
    transform: scale(1.1);
}

/* Sub Images Section */
.sub-images-section {
    margin-top: 2rem;
}

.image-preview {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
    gap: 1rem;
    margin-top: 1rem;
}
</style>

<script>
function handleFrontImageUpload(event) {
    const file = event.target.files[0];
    const maxSize = 5 * 1024 * 1024; // 5MB
    const preview = document.getElementById('front-image-preview');
    const placeholder = document.getElementById('front-image-placeholder');
    
    if (!file) return;
    
    // Validate file size
    if (file.size > maxSize) {
        alert('Front image is too large. Maximum size is 5MB.');
        event.target.value = '';
        return;
    }
    
    // Validate file type
    if (!['image/jpeg', 'image/png', 'image/jpg'].includes(file.type)) {
        alert('Invalid file type. Please use JPEG or PNG.');
        event.target.value = '';
        return;
    }
    
    const reader = new FileReader();
    
    reader.onload = function(e) {
        preview.innerHTML = `
            <img src="${e.target.result}" alt="Front View">
            <button type="button" class="remove-btn" onclick="removeFrontImage()">
                <i class="bx bx-x"></i>
            </button>
        `;
        preview.style.display = 'block';
        placeholder.style.display = 'none';
    };
    
    reader.readAsDataURL(file);
    validateForm();
}

function removeFrontImage() {
    const preview = document.getElementById('front-image-preview');
    const placeholder = document.getElementById('front-image-placeholder');
    const input = document.getElementById('front-image-input');
    
    preview.innerHTML = '';
    preview.style.display = 'none';
    placeholder.style.display = 'block';
    input.value = '';
    validateForm();
}

function handleSubImagesUpload(event) {
    const files = event.target.files;
    const preview = document.getElementById('sub-images-preview');
    const maxFiles = 4;
    const maxSize = 5 * 1024 * 1024; // 5MB
    const currentCount = document.querySelectorAll('.sub-image-item').length;
    
    // Check if adding new files would exceed the limit
    if (currentCount + files.length > maxFiles) {
        alert(`You can only upload up to ${maxFiles} additional images.`);
        event.target.value = '';
        return;
    }
    
    Array.from(files).forEach(file => {
        // Validate file size
        if (file.size > maxSize) {
            alert(`File ${file.name} is too large. Maximum size is 5MB.`);
            return;
        }
        
        // Validate file type
        if (!['image/jpeg', 'image/png', 'image/jpg'].includes(file.type)) {
            alert(`File ${file.name} is not a valid image type. Please use JPEG or PNG.`);
            return;
        }
        
        const reader = new FileReader();
        
        reader.onload = function(e) {
            const previewItem = document.createElement('div');
            previewItem.className = 'preview-item sub-image-item';
            
            previewItem.innerHTML = `
                <img src="${e.target.result}" alt="Property Image">
                <button type="button" class="remove-btn" onclick="this.parentElement.remove(); updateSubImageCount(); validateForm();">
                    <i class="bx bx-x"></i>
                </button>
            `;
            
            preview.appendChild(previewItem);
            updateSubImageCount();
            validateForm();
        };
        
        reader.readAsDataURL(file);
    });
}

function clearSubImages() {
    const preview = document.getElementById('sub-images-preview');
    preview.innerHTML = '';
    document.getElementById('sub-images-input').value = '';
    updateSubImageCount();
    validateForm();
}

function updateSubImageCount() {
    const count = document.querySelectorAll('.sub-image-item').length;
    document.getElementById('sub-image-count').textContent = count;
}

function validateForm() {
    const submitBtn = document.getElementById('submitBtn');
    const hasFrontImage = document.getElementById('front-image-preview').innerHTML !== '';
    const subImagesCount = document.querySelectorAll('.sub-image-item').length;
    
    if (!hasFrontImage) {
        submitBtn.disabled = true;
        submitBtn.style.opacity = '0.7';
        submitBtn.style.cursor = 'not-allowed';
    } else {
        submitBtn.disabled = false;
        submitBtn.style.opacity = '1';
        submitBtn.style.cursor = 'pointer';
    }
}

// Form validation before submission
document.getElementById('propertyForm').addEventListener('submit', function(e) {
    const hasFrontImage = document.getElementById('front-image-preview').innerHTML !== '';
    const subImagesCount = document.querySelectorAll('.sub-image-item').length;
    
    if (!hasFrontImage) {
        e.preventDefault();
        alert('Please upload a front image of the property.');
        return false;
    }
    
    if (subImagesCount > 4) {
        e.preventDefault();
        alert('You can only upload up to 4 additional images.');
        return false;
    }
    
    return true;
});

// Initialize form validation
validateForm();

// Drag and drop functionality for sub-images
const uploadArea = document.getElementById('upload-area');

uploadArea.addEventListener('dragover', (e) => {
    e.preventDefault();
    uploadArea.style.borderColor = '#667eea';
    uploadArea.style.background = 'white';
});

uploadArea.addEventListener('dragleave', (e) => {
    e.preventDefault();
    uploadArea.style.borderColor = '#e2e8f0';
    uploadArea.style.background = '#f8fafc';
});

uploadArea.addEventListener('drop', (e) => {
    e.preventDefault();
    uploadArea.style.borderColor = '#e2e8f0';
    uploadArea.style.background = '#f8fafc';
    
    const files = e.dataTransfer.files;
    const input = document.getElementById('sub-images-input');
    
    // Create a new FileList-like object
    const dataTransfer = new DataTransfer();
    Array.from(files).forEach(file => dataTransfer.items.add(file));
    input.files = dataTransfer.files;
    
    handleSubImagesUpload({ target: { files } });
});
</script>

@endsection