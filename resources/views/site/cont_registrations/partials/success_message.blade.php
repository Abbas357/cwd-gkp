<div class="alert alert-success shadow-sm rounded border-0 p-3">
    <h4 class="alert-heading mb-2">Registration Successful!</h4>
    <p>Your form has been submitted successfully. Please use the credentials below to log in and manage your registration.</p>
    <ul class="list-unstyled">
        <li><strong>Email:</strong> <span class="text-primary">{{ $email }}</span></li>
        <li><strong>Password:</strong> <span class="text-primary">{{ $password }}</span></li>
    </ul>
    <a href="{{ $loginUrl }}" class="btn btn-success mt-3">
        <i class="bi bi-box-arrow-in-right"></i> Log in Now
    </a>
</div>
