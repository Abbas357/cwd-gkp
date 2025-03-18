/**
 * Open a modal to quickly create a user
 * @param {Function} callback - Function to execute when user is created successfully
 */
function openUserQuickCreateModal(callback) {
    // Create a unique ID for the modal
    const modalId = 'userQuickCreateModal-' + Math.random().toString(36).substring(2, 9);
    
    // Create the modal HTML
    const modalHTML = `
        <div class="modal fade" id="${modalId}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Quick Create User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="quickCreateUserForm-${modalId}">
                        <div class="modal-body">
                            <div class="loading-spinner text-center">
                                <div class="spinner-border" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                            <div class="form-content"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Create User</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    `;
    
    // Append modal to body
    $('body').append(modalHTML);
    
    // Show the modal
    const modal = new bootstrap.Modal(document.getElementById(modalId));
    modal.show();
    
    // Load the form content
    $.ajax({
        url: '/admin/apps/hr/users/quick-create',
        type: 'GET',
        success: function(response) {
            if (response.success) {
                $(`#${modalId} .loading-spinner`).hide();
                $(`#${modalId} .form-content`).html(response.data.result);
                
                // Initialize Select2 properly (after content is loaded)
                initializeFormComponents(modalId);
            } else {
                $(`#${modalId} .loading-spinner`).hide();
                $(`#${modalId} .form-content`).html('<div class="alert alert-danger">Failed to load form</div>');
            }
        },
        error: function() {
            $(`#${modalId} .loading-spinner`).hide();
            $(`#${modalId} .form-content`).html('<div class="alert alert-danger">Failed to load form</div>');
        }
    });
    
    // Handle form submission
    $(`#quickCreateUserForm-${modalId}`).on('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const submitBtn = $(this).find('button[type="submit"]');
        submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Creating...');
        
        $.ajax({
            url: '/admin/apps/hr/users/quick-store',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    modal.hide();
                    
                    // Show success message with password if generated
                    if (response.generated_password) {
                        showMessage(`${response.success}. The password is: ${response.generated_password}`, 'success', {
                            timer: 8000
                        });
                    } else {
                        showMessage(response.success);
                    }
                    
                    // Execute callback if provided
                    if (typeof callback === 'function') {
                        callback(response.user);
                    }
                } else {
                    showMessage(response.error, 'error');
                    submitBtn.prop('disabled', false).text('Create User');
                }
            },
            error: function(xhr) {
                let errorMessage = 'Failed to create user';
                if (xhr.responseJSON && xhr.responseJSON.error) {
                    errorMessage = xhr.responseJSON.error;
                } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                    errorMessage = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                }
                
                showMessage(errorMessage, 'error');
                submitBtn.prop('disabled', false).text('Create User');
            }
        });
    });
    
    // Remove modal from DOM when hidden
    $(`#${modalId}`).on('hidden.bs.modal', function() {
        $(this).remove();
    });
}

/**
 * Initialize all form components
 * @param {string} modalId - The ID of the modal
 */
function initializeFormComponents(modalId) {
    const modalElement = $(`#${modalId}`);
    
    // Initialize Select2 for all select elements in the modal
    modalElement.find('select').each(function() {
        const selectElement = $(this);
        const parentElement = modalElement.find('.modal-content');
        
        // Initialize Select2
        selectElement.select2({
            theme: "bootstrap-5",
            placeholder: selectElement.attr('placeholder') || "Select an option",
            width: '100%',
            dropdownParent: parentElement
        });
        
        // Add change handlers for dynamic fields
        const id = selectElement.attr('id');
        
        if (id === 'office_id') {
            selectElement.on('change', function() {
                if ($(this).val() === 'new') {
                    modalElement.find('#new_office_container').removeClass('d-none');
                } else {
                    modalElement.find('#new_office_container').addClass('d-none');
                }
            });
        } else if (id === 'designation_id') {
            selectElement.on('change', function() {
                if ($(this).val() === 'new') {
                    modalElement.find('#new_designation_container').removeClass('d-none');
                } else {
                    modalElement.find('#new_designation_container').addClass('d-none');
                }
            });
        } else if (id === 'district_id') {
            selectElement.on('change', function() {
                if ($(this).val() === 'new') {
                    modalElement.find('#new_district_container').removeClass('d-none');
                } else {
                    modalElement.find('#new_district_container').addClass('d-none');
                }
            });
        }
    });
    
    // Initialize image cropper if present
    if (modalElement.find('#image').length) {
        imageCropper({
            fileInput: modalElement.find('#image'),
            inputLabelPreview: modalElement.find('#image-label-preview'),
            aspectRatio: 1
        });
    }
}