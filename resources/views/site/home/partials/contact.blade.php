<div class="container py-2">
    <div class="row g-5 align-items-center">
        <div class="col-lg-6">
            <div class="container-fluid subscribe py-5">
                <div class="container text-center py-3">
                    <div class="mx-auto text-center" style="max-width: 900px;">
                        <h5 class="subscribe-title px-3">Our Newsletter</h5>
                        <h1 class="text-white mb-4">Get Exclusive updates from C&W Department, KP</h1>
                        <p class="text-white mb-5">Enter your email and subscribe to important updates from Communication and Works Department Government of Khyber Pakhtunkhwa</p>
                        
                        <form action="{{ route('newsletter.store') }}" method="POST">
                            @csrf
                            <div class="position-relative mx-auto">
                                <input class="form-control border-primary rounded-pill w-100 py-3 ps-4 pe-5" type="email" name="email" placeholder="Your email" required>
                                <button type="submit" class="btn btn-primary rounded-pill position-absolute top-0 end-0 py-2 px-4 mt-2 me-2">Subscribe</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <h1 class="text-white mb-3">Contact Us</h1>
            <form>
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" class="form-control bg-white border-0" id="name" name="name" placeholder="Your Name">
                            <label for="name">Your Name</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="email" class="form-control bg-white border-0" id="email" name="email" placeholder="Your Email">
                            <label for="email">Your Email</label>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" class="form-control bg-white border-0" id="mobile_number" name="mobile_number" placeholder="Phone / Mobile Number">
                            <label for="name">Phone/Mobile Number</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="email" class="form-control bg-white border-0" id="cnic" name="cnic" placeholder="CNIC">
                            <label for="email">CNIC Number</label>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-floating">
                            <textarea class="form-control bg-white border-0" placeholder="Special Request" id="message" name="message" style="height: 150px"></textarea>
                            <label for="message">Message Detail</label>
                        </div>
                    </div>
                    <div class="col-12">
                        <button class="btn btn-primary text-white w-100 py-3" type="submit">Send</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>