class ProductImageManager {
    constructor() {
        this.imageContainer = document.getElementById('image-preview-container');
        this.imageInput = document.getElementById('images');
        this.mainImageInput = document.getElementById('image');
        this.mainImagePreview = document.getElementById('main-image-preview');
        this.dropZone = document.getElementById('image-drop-zone');
        this.uploadedImages = [];
        this.existingImages = [];
        
        this.init();
    }

    init() {
        this.setupEventListeners();
        this.loadExistingImages();
        this.updateImageCount();
    }

    setupEventListeners() {
        // Main image input
        if (this.mainImageInput) {
            this.mainImageInput.addEventListener('change', (e) => {
                this.handleMainImageUpload(e);
            });
        }

        // Multiple images input
        if (this.imageInput) {
            this.imageInput.addEventListener('change', (e) => {
                this.handleMultipleImageUpload(e);
            });
        }

        // Drag and drop functionality
        this.setupDragAndDrop();
        

    }

    setupDragAndDrop() {
        if (!this.dropZone) return;

        this.dropZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            this.dropZone.classList.add('border-blue-500', 'bg-blue-50', 'dragover');
        });

        this.dropZone.addEventListener('dragleave', (e) => {
            e.preventDefault();
            this.dropZone.classList.remove('border-blue-500', 'bg-blue-50', 'dragover');
        });

        this.dropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            this.dropZone.classList.remove('border-blue-500', 'bg-blue-50', 'dragover');
            
            const files = Array.from(e.dataTransfer.files);
            this.processFiles(files);
        });

        // Click to upload functionality
        this.dropZone.addEventListener('click', (e) => {
            if (e.target.tagName !== 'LABEL' && !e.target.closest('label')) {
                this.imageInput.click();
            }
        });
    }

    handleMainImageUpload(event) {
        const file = event.target.files[0];
        if (!file) return;

        if (!this.validateImage(file)) return;

        this.showLoadingState(this.mainImagePreview);
        
        const reader = new FileReader();
        reader.onload = (e) => {
            this.displayMainImagePreview(e.target.result, file.name);
            this.showSuccessState(this.mainImagePreview);
        };
        reader.onerror = () => {
            this.showError('Failed to read image file');
            this.hideLoadingState(this.mainImagePreview);
        };
        reader.readAsDataURL(file);
    }

    handleMultipleImageUpload(event) {
        const files = Array.from(event.target.files);
        this.processFiles(files);
    }

    processFiles(files) {
        files.forEach(file => {
            if (this.validateImage(file)) {
                this.addImagePreview(file);
            }
        });
    }

    validateImage(file) {
        const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
        const maxSize = 2 * 1024 * 1024; // 2MB

        if (!validTypes.includes(file.type)) {
            this.showError('Please select a valid image file (JPEG, PNG, JPG, GIF)');
            return false;
        }

        if (file.size > maxSize) {
            this.showError('Image size must be less than 2MB');
            return false;
        }

        return true;
    }

    displayMainImagePreview(src, filename) {
        if (!this.mainImagePreview) return;

        this.mainImagePreview.innerHTML = `
            <div class="relative group image-preview-item">
                <img src="${src}" alt="Main image preview" class="w-32 h-32 object-cover rounded-lg border">
                <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity rounded-lg flex items-center justify-center">
                    <button type="button" onclick="productImageManager.removeMainImage()" 
                            class="bg-red-500 text-white p-1 rounded-full hover:bg-red-600 remove-btn">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        `;
    }

    addImagePreview(file) {
        const reader = new FileReader();
        reader.onload = (e) => {
            const imageId = 'img_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
            
            const imageElement = document.createElement('div');
            imageElement.id = imageId;
            imageElement.className = 'relative group image-preview-item';
            imageElement.innerHTML = `
                <img src="${e.target.result}" alt="Image preview" class="w-24 h-24 object-cover rounded-lg border">
                <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity rounded-lg flex items-center justify-center">
                    <button type="button" onclick="productImageManager.removeImage('${imageId}')" 
                            class="bg-red-500 text-white p-1 rounded-full hover:bg-red-600 remove-btn">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <input type="file" name="images[]" value="" style="display: none;" data-file="${file.name}">
            `;

            // Store file data
            this.uploadedImages.push({
                id: imageId,
                file: file,
                element: imageElement
            });

            this.imageContainer.appendChild(imageElement);
            this.updateImageCount();
            this.showSuccessState(imageElement);
        };
        
        reader.onerror = () => {
            this.showError('Failed to read image file');
        };
        
        reader.readAsDataURL(file);
    }

    removeMainImage() {
        // Check if there's an existing main image to delete
        const existingMainImage = document.getElementById('existing-main-image');
        if (existingMainImage) {
            const imagePath = existingMainImage.getAttribute('data-image-path');
            if (imagePath) {
                // Create a hidden input for main image deletion (using CSS to hide)
                const deleteInput = document.createElement('input');
                deleteInput.type = 'text';
                deleteInput.name = 'delete_images[]';
                deleteInput.value = imagePath;
                deleteInput.style.display = 'none';
                deleteInput.style.visibility = 'hidden';
                deleteInput.style.position = 'absolute';
                deleteInput.style.left = '-9999px';
                document.querySelector('form[action*="products"]').appendChild(deleteInput);
                
                // Add visual indicator that main image is marked for deletion
                existingMainImage.style.border = '2px solid #ef4444';
                existingMainImage.style.opacity = '0.6';
                
                // Add a "Marked for deletion" overlay
                const overlay = document.createElement('div');
                overlay.className = 'absolute inset-0 bg-red-500 bg-opacity-75 flex items-center justify-center text-white text-xs font-medium';
                overlay.textContent = 'Will be deleted';
                overlay.id = 'delete-overlay-main';
                existingMainImage.appendChild(overlay);
                
                // Remove the image element after a delay
                setTimeout(() => {
                    existingMainImage.remove();
                }, 1000);
            }
        }

        if (this.mainImageInput) {
            this.mainImageInput.value = '';
        }
        if (this.mainImagePreview) {
            this.mainImagePreview.innerHTML = `
                <div class="w-32 h-32 border-2 border-dashed border-gray-300 rounded-lg flex items-center justify-center bg-gray-50 hover:bg-gray-100 transition-colors cursor-pointer" onclick="document.getElementById('image').click()">
                    <div class="text-center">
                        <svg class="mx-auto h-8 w-8 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <p class="text-xs text-gray-500 mt-1">Click to upload</p>
                    </div>
                </div>
            `;
        }
    }

    removeImage(imageId) {
        const imageElement = document.getElementById(imageId);
        if (imageElement) {
            // Add fade-out animation
            imageElement.style.transition = 'all 0.3s ease';
            imageElement.style.transform = 'scale(0.8)';
            imageElement.style.opacity = '0';
            
            setTimeout(() => {
                imageElement.remove();
                
                // Remove from uploaded images array
                this.uploadedImages = this.uploadedImages.filter(img => img.id !== imageId);
                
                // Remove from existing images array if it was an existing image
                this.existingImages = this.existingImages.filter(img => img.id !== imageId);
                
                this.updateImageCount();
            }, 300);
        }
    }

    removeExistingImage(imageId, imagePath) {
        const form = document.querySelector('form[action*="products"]');
        if (!form) {
            return;
        }
        
        // Check if this image is already marked for deletion
        const existingDeleteInput = form.querySelector(`input[name="delete_images[]"][value="${imagePath}"]`);
        if (existingDeleteInput) {
            return;
        }
        
        // Create a hidden input for each image to be deleted (using CSS to hide)
        const deleteInput = document.createElement('input');
        deleteInput.type = 'text';
        deleteInput.name = 'delete_images[]';
        deleteInput.value = imagePath;
        deleteInput.id = 'delete-' + imageId;
        deleteInput.style.display = 'none';
        deleteInput.style.visibility = 'hidden';
        deleteInput.style.position = 'absolute';
        deleteInput.style.left = '-9999px';
        
        // Add directly to the form (not to a container)
        form.appendChild(deleteInput);

        // Add visual indicator that image is marked for deletion
        const imageElement = document.getElementById(imageId);
        if (imageElement) {
            // Add a red border to indicate it's marked for deletion
            imageElement.style.border = '2px solid #ef4444';
            imageElement.style.opacity = '0.6';
            
            // Add a "Marked for deletion" overlay
            const overlay = document.createElement('div');
            overlay.className = 'absolute inset-0 bg-red-500 bg-opacity-75 flex items-center justify-center text-white text-xs font-medium';
            overlay.textContent = 'Will be deleted';
            overlay.id = 'delete-overlay-' + imageId;
            imageElement.appendChild(overlay);
            
            // Remove the image element after a delay
            setTimeout(() => {
                imageElement.remove();
                this.updateImageCount();
            }, 1000);
        }
    }

    loadExistingImages() {
        const existingImagesContainer = document.getElementById('existing-images-container');
        if (!existingImagesContainer) {
            return;
        }

        const images = existingImagesContainer.querySelectorAll('[data-image-path]');
        
        images.forEach((img, index) => {
            const imagePath = img.getAttribute('data-image-path');
            const imageId = 'existing_img_' + index;
            
            img.id = imageId;
            img.className = 'relative group cursor-pointer image-preview-item';
            
            // Check if remove button already exists
            const existingRemoveBtn = img.querySelector('.remove-btn');
            if (!existingRemoveBtn) {
                // Add remove button
                const removeBtn = document.createElement('div');
                removeBtn.className = 'absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity rounded-lg flex items-center justify-center';
                removeBtn.innerHTML = `
                    <button type="button" onclick="productImageManager.removeExistingImage('${imageId}', '${imagePath}')" 
                            class="bg-red-500 text-white p-1 rounded-full hover:bg-red-600 remove-btn">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                `;
                
                img.appendChild(removeBtn);
            }
            
            this.existingImages.push({ id: imageId, path: imagePath });
        });
    }

    updateImageCount() {
        const countElement = document.getElementById('image-count');
        if (countElement) {
            const totalImages = this.uploadedImages.length + this.existingImages.length;
            countElement.textContent = totalImages;
        }
    }

    showLoadingState(element) {
        if (element) {
            element.classList.add('image-upload-loading');
        }
    }

    hideLoadingState(element) {
        if (element) {
            element.classList.remove('image-upload-loading');
        }
    }

    showSuccessState(element) {
        if (element) {
            element.classList.add('image-success');
            setTimeout(() => {
                element.classList.remove('image-success');
            }, 600);
        }
    }

    showError(message) {
        // Create or update error message
        let errorDiv = document.getElementById('image-error');
        if (!errorDiv) {
            errorDiv = document.createElement('div');
            errorDiv.id = 'image-error';
            errorDiv.className = 'text-red-500 text-sm mt-2 image-error';
            this.imageContainer.parentNode.appendChild(errorDiv);
        }
        
        errorDiv.textContent = message;
        errorDiv.classList.add('image-error');
        
        // Auto-hide after 3 seconds
        setTimeout(() => {
            errorDiv.textContent = '';
            errorDiv.classList.remove('image-error');
        }, 3000);
    }

    // Method to get all selected files for form submission
    getSelectedFiles() {
        const files = [];
        this.uploadedImages.forEach(img => {
            files.push(img.file);
        });
        return files;
    }




}

// Make testImageDeletion globally accessible
window.testImageDeletion = function() {
    if (window.productImageManager) {
        window.productImageManager.testImageDeletion();
    } else {
        console.error('ProductImageManager not initialized');
    }
};



// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    window.productImageManager = new ProductImageManager();
    

}); 