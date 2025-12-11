<!-- Create Post Modal -->
<div class="modal fade" id="createPostModal" tabindex="-1" aria-labelledby="createPostLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border: none; border-radius: 12px; box-shadow: 0 10px 40px rgba(0,0,0,0.15);">
            <form action="{{ route('discover.create') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body" style="padding: 40px;">
                    <!-- Title Section -->
                    <div style="margin-bottom: 30px;">
                        <h2 style="font-weight: 700; color: #1a1a1a; font-size: 1.8rem; margin-bottom: 8px;">Create a New Post</h2>
                        <p style="color: #999; font-size: 0.95rem;">Share your concert plans and find companions</p>
                    </div>

                    <!-- Which concert are you going to? -->
                    <div style="margin-bottom: 24px;">
                        <label style="font-weight: 600; color: #1a1a1a; display: block; margin-bottom: 10px;">Which concert are you going to? *</label>
                        <div style="position: relative;">
                            <input type="text" name="concert_name" id="concert_name_modal" placeholder="Search concerts, artists (e.g., Arctic Monkeys, Mariah Carey)" class="form-control" style="border: 1px solid #ddd; border-radius: 8px; padding: 12px 16px; font-size: 0.95rem;" required>
                            <i class="fas fa-search" style="position: absolute; right: 16px; top: 50%; transform: translateY(-50%); color: #ccc;"></i>
                        </div>
                    </div>

                    <!-- Date and Time Row -->
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 24px;">
                        <div>
                            <label style="font-weight: 600; color: #1a1a1a; display: block; margin-bottom: 10px;">Date *</label>
                            <input type="date" name="concert_date" id="concert_date_modal" class="form-control" style="border: 1px solid #ddd; border-radius: 8px; padding: 12px 16px; font-size: 0.95rem;" required>
                        </div>
                        <div>
                            <label style="font-weight: 600; color: #1a1a1a; display: block; margin-bottom: 10px;">Time *</label>
                            <input type="time" name="concert_time" id="concert_time_modal" class="form-control" style="border: 1px solid #ddd; border-radius: 8px; padding: 12px 16px; font-size: 0.95rem;" required>
                        </div>
                    </div>

                    <!-- Venue and City Row -->
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 24px;">
                        <div>
                            <label style="font-weight: 600; color: #1a1a1a; display: block; margin-bottom: 10px;">Venue *</label>
                            <div style="position: relative;">
                                <input type="text" name="location" id="location_modal" placeholder="e.g., ICE BSD, Gelora Bung Karno Stadium" class="form-control" style="border: 1px solid #ddd; border-radius: 8px; padding: 12px 16px; font-size: 0.95rem;" required>
                                <i class="fas fa-map-marker-alt" style="position: absolute; right: 16px; top: 50%; transform: translateY(-50%); color: #ccc;"></i>
                            </div>
                        </div>
                        <div>
                            <label style="font-weight: 600; color: #1a1a1a; display: block; margin-bottom: 10px;">City, Region *</label>
                            <div style="position: relative;">
                                <input type="text" name="city" id="city_modal" placeholder="e.g., Jakarta, Indonesia" class="form-control" style="border: 1px solid #ddd; border-radius: 8px; padding: 12px 16px; font-size: 0.95rem;" required>
                                <i class="fas fa-map-marker-alt" style="position: absolute; right: 16px; top: 50%; transform: translateY(-50%); color: #ccc;"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Looking For Section -->
                    <div style="background-color: #f5f3ff; border-radius: 12px; padding: 20px; margin-bottom: 24px;">
                        <p style="font-weight: 600; color: #1a1a1a; margin-bottom: 16px;">Looking For</p>
                        <p style="color: #666; font-size: 0.9rem; margin-bottom: 16px;">Number of spots available</p>
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <button type="button" style="width: 36px; height: 36px; border: 1px solid #ddd; background: white; border-radius: 6px; cursor: pointer; font-size: 1.2rem; color: #999;" onclick="document.getElementById('spots_available_modal').value = Math.max(1, parseInt(document.getElementById('spots_available_modal').value) - 1);">−</button>
                            <input type="number" name="spots_available" id="spots_available_modal" value="1" class="form-control" style="border: 1px solid #ddd; border-radius: 8px; text-align: center; width: 60px; font-size: 0.95rem;" min="1" required>
                            <button type="button" style="width: 36px; height: 36px; border: 1px solid #ddd; background: white; border-radius: 6px; cursor: pointer; font-size: 1.2rem; color: #999;" onclick="document.getElementById('spots_available_modal').value = parseInt(document.getElementById('spots_available_modal').value) + 1;">+</button>
                        </div>
                    </div>

                    <!-- Tell others about your plan -->
                    <div style="margin-bottom: 24px;">
                        <label style="font-weight: 600; color: #1a1a1a; display: block; margin-bottom: 10px;">Tell others about your plan *</label>
                        <textarea name="description" id="description_modal" placeholder="Looking for someone to watch Keshi together!" class="form-control" style="border: 1px solid #ddd; border-radius: 8px; padding: 12px 16px; font-size: 0.95rem; min-height: 120px; resize: vertical;" required></textarea>
                        <div style="text-align: right; margin-top: 8px; color: #999; font-size: 0.85rem;">
                            <span id="charCount_modal">0</span> / 500
                        </div>
                    </div>

                    <!-- Cover Image Section -->
                    <div style="margin-bottom: 24px;">
                        <p style="font-weight: 600; color: #1a1a1a; margin-bottom: 16px;">Cover Image</p>
                        <div id="colorPresets_modal" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; margin-bottom: 16px;">
                            <div class="color-preset-modal" data-color="linear-gradient(135deg, #D75BA8, #9D4EDD)" style="width: 100%; height: 60px; background: linear-gradient(135deg, #D75BA8, #9D4EDD); border-radius: 8px; cursor: pointer; border: 3px solid transparent; transition: all 0.3s ease;" onclick="setColorImageModal(this)" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'"></div>
                            <div class="color-preset-modal" data-color="linear-gradient(135deg, #00D9FF, #0081CF)" style="width: 100%; height: 60px; background: linear-gradient(135deg, #00D9FF, #0081CF); border-radius: 8px; cursor: pointer; border: 3px solid transparent; transition: all 0.3s ease;" onclick="setColorImageModal(this)" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'"></div>
                            <div class="color-preset-modal" data-color="linear-gradient(135deg, #FF6B9D, #FF9975)" style="width: 100%; height: 60px; background: linear-gradient(135deg, #FF6B9D, #FF9975); border-radius: 8px; cursor: pointer; border: 3px solid transparent; transition: all 0.3s ease;" onclick="setColorImageModal(this)" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'"></div>
                            <div class="color-preset-modal" data-color="linear-gradient(135deg, #7C5CEE, #5A3FBD)" style="width: 100%; height: 60px; background: linear-gradient(135deg, #7C5CEE, #5A3FBD); border-radius: 8px; cursor: pointer; border: 3px solid transparent; transition: all 0.3s ease;" onclick="setColorImageModal(this)" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'"></div>
                        </div>
                        <input type="hidden" id="selectedColor_modal" name="cover_color" value="">
                        <button type="button" style="width: 100%; padding: 12px 16px; border: 2px dashed #ddd; background: white; border-radius: 8px; cursor: pointer; font-weight: 600; color: #666; display: flex; align-items: center; gap: 8px; justify-content: center; font-size: 0.95rem;" onclick="document.getElementById('cover_image_modal').click();">
                            <i class="fas fa-download"></i> Upload Custom Image
                        </button>
                        <input type="file" name="cover_image" id="cover_image_modal" accept="image/*" style="display: none;">
                        <div id="imagePreview_modal" style="margin-top: 12px; display: none;">
                            <img id="previewImg_modal" src="" alt="Preview" style="width: 100%; max-height: 200px; object-fit: cover; border-radius: 8px;">
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                        <button type="button" class="btn" style="padding: 12px 24px; border: 1px solid #ddd; background: white; color: #666; border-radius: 8px; font-weight: 600; font-size: 0.95rem; cursor: pointer;" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" style="padding: 12px 24px; background: linear-gradient(135deg, #7C5CEE, #9D4EDD); color: white; border: none; border-radius: 8px; font-weight: 600; font-size: 0.95rem; cursor: pointer; display: flex; align-items: center; gap: 8px; justify-content: center;">
                            <i class="fas fa-music"></i> Post Event
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Character counter for description in modal
if (document.getElementById('description_modal')) {
    document.getElementById('description_modal').addEventListener('input', function() {
        document.getElementById('charCount_modal').textContent = this.value.length;
    });
}

// Color selection function with visual feedback for modal
function setColorImageModal(element) {
    // Remove border from all presets
    document.querySelectorAll('.color-preset-modal').forEach(preset => {
        preset.style.borderColor = 'transparent';
    });
    
    // Add border to selected preset
    element.style.borderColor = '#333';
    
    // Set the hidden input value
    document.getElementById('selectedColor_modal').value = element.getAttribute('data-color');
    
    // Hide image preview when color is selected
    document.getElementById('imagePreview_modal').style.display = 'none';
    document.getElementById('cover_image_modal').value = '';
}

// Handle file input change for modal
if (document.getElementById('cover_image_modal')) {
    document.getElementById('cover_image_modal').addEventListener('change', function() {
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('previewImg_modal').src = e.target.result;
                document.getElementById('imagePreview_modal').style.display = 'block';
                
                // Clear color selection when image is uploaded
                document.querySelectorAll('.color-preset-modal').forEach(preset => {
                    preset.style.borderColor = 'transparent';
                });
                document.getElementById('selectedColor_modal').value = '';
            };
            reader.readAsDataURL(this.files[0]);
        }
    });
}
</script>
