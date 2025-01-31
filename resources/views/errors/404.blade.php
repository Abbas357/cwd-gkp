<x-guest-layout title="404 Page">

  <div class="container-fluid py-5">
    <div class="container py-5 text-center">
        <div class="row justify-content-center p-5" style="background: linear-gradient(rgba(255, 255, 255, 0.5), rgba(255, 255, 255, 0.5)); object-fit: cover; border-radius:20px">
            <div class="col-lg-6">
                <i class="bi bi-exclamation-triangle display-1 text-primary"></i>
                <h1 class="display-1">404</h1>
                <h1 class="mb-4 text-dark">Page Not Found</h1>
                <p class="mb-4 text-dark">We’re sorry, the page you have looked for does not exist in our website! Maybe go to our home page or try to use a search?</p>
                <a class="btn btn-primary rounded-pill py-3 px-5" onclick="history.back()">Go Back</a>
            </div>
        </div>
    </div>
</div>

</x-guest-layout>
