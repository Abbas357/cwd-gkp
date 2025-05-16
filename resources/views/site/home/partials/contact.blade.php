<style>
/* Contact & Newsletter Section Styling */
.contact-newsletter-section {
    background-color: #f8f9fa;
}

/* Card Styling - Common */
.newsletter-card,
.contact-card {
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    overflow: hidden;
    height: 100%;
    transition: all 0.3s ease;
}

.newsletter-card:hover,
.contact-card:hover {
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
    transform: translateY(-5px);
}

/* Newsletter Card Styling */
.newsletter-card {
    background: var(--cw-primary-light);
    color: #fff;
    padding: 3rem 2rem;
    position: relative;
}

.newsletter-card::before {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    width: 150px;
    height: 150px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    transform: translate(50%, -50%);
}

.newsletter-card::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100px;
    height: 100px;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 50%;
    transform: translate(-30%, 30%);
}

.newsletter-icon {
    font-size: 3rem;
    color: rgba(255, 255, 255, 0.8);
}

.newsletter-title {
    font-size: 1.5rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    position: relative;
    display: inline-block;
    padding-bottom: 10px;
}

.newsletter-title::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 50px;
    height: 3px;
    background-color: rgba(255, 255, 255, 0.5);
    border-radius: 3px;
}

.newsletter-subtitle {
    font-size: 1.3rem;
    font-weight: 600;
}

.newsletter-text {
    font-size: 0.95rem;
    opacity: 0.9;
    max-width: 90%;
    margin: 0 auto;
}

/* Newsletter Form Styling */
.newsletter-input-group {
    position: relative;
    max-width: 90%;
    margin: 0 auto;
}

.newsletter-input {
    width: 100%;
    padding: 15px 120px 15px 20px;
    border: none;
    border-radius: 30px;
    background-color: rgba(255, 255, 255, 0.9);
    font-size: 0.95rem;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.newsletter-input:focus {
    outline: none;
    background-color: #fff;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
}

.newsletter-button {
    position: absolute;
    right: 5px;
    top: 5px;
    padding: 10px 20px;
    border: none;
    border-radius: 25px;
    background: linear-gradient(135deg, #343a40, #212529);
    color: white;
    font-weight: 600;
    font-size: 0.9rem;
    transition: all 0.3s ease;
}

.newsletter-button:hover {
    background: linear-gradient(135deg, #212529, #000);
    transform: translateX(-3px);
}

/* Contact Card Styling */
.contact-card {
    background-color: #fff;
    padding: 2.5rem;
}

.contact-header {
    margin-bottom: 1.5rem;
    text-align: center;
}

.contact-title {
    font-size: 1.8rem;
    font-weight: 700;
    color: #212529;
    margin-bottom: 0.5rem;
}

.contact-subtitle {
    color: #6c757d;
    font-size: 0.95rem;
}

/* Contact Form Styling */
.form-group {
    margin-bottom: 1.25rem;
}

.form-label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 600;
    color: #495057;
    font-size: 0.9rem;
}

.input-group {
    position: relative;
    display: flex;
}

.input-group-text {
    background-color: #f8f9fa;
    border: 1px solid #ced4da;
    border-right: none;
    color: #6c757d;
    padding-left: 15px;
    padding-right: 15px;
}

.form-control {
    flex: 1;
    padding: 0.75rem 1rem;
    border: 1px solid #ced4da;
    border-radius: 0 5px 5px 0 !important;
    font-size: 0.95rem;
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: var(--cw-primary-deep);
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15);
}

textarea.form-control {
    min-height: 120px;
}

/* Submit Button Styling */
.contact-submit-btn {
    display: block;
    width: 100%;
    padding: 12px;
    background: var(--cw-primary);
    color: white;
    border: none;
    border-radius: 5px;
    font-weight: 600;
    font-size: 1rem;
    transition: all 0.3s ease;
    cursor: pointer;
}

.contact-submit-btn:hover {
    background: var(--cw-primary-deep);
    box-shadow: 0 5px 15px rgba(13, 110, 253, 0.3);
}

/* Responsive Adjustments */
@media (max-width: 991px) {
    .newsletter-card,
    .contact-card {
        padding: 2rem 1.5rem;
    }
    
    .newsletter-input {
        padding: 13px 110px 13px 15px;
    }
    
    .newsletter-button {
        padding: 8px 15px;
    }
}

@media (max-width: 767px) {
    .newsletter-subtitle {
        font-size: 1.1rem;
    }
    
    .contact-title {
        font-size: 1.5rem;
    }
}
</style>

<div class="contact-newsletter-section py-5">
    <div class="container">
        <div class="row g-4">
            <!-- Newsletter Section -->
            <div class="col-lg-6">
                <div class="newsletter-card h-100">
                    <div class="newsletter-content text-center">
                        <div class="newsletter-icon mb-3">
                            <i class="bi bi-envelope-paper-heart"></i>
                        </div>
                        <h3 class="newsletter-title mb-3">Our Newsletter</h3>
                        <h4 class="newsletter-subtitle mb-3">Get Exclusive Updates from C&W Department, KP</h4>
                        <p class="newsletter-text mb-4">Enter your email and subscribe to important updates from Communication and Works Department Government of Khyber Pakhtunkhwa</p>
                        
                        <form action="{{ route('newsletter.store') }}" method="POST" class="newsletter-form">
                            @csrf
                            <div class="newsletter-input-group">
                                <input type="email" name="email" class="newsletter-input" placeholder="Your email address" required>
                                <button type="submit" class="newsletter-button">
                                    Subscribe <i class="bi bi-send ms-1"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Contact Form Section -->
            <div class="col-lg-6">
                <div class="contact-card h-100">
                    <div class="contact-header">
                        <h3 class="contact-title">Contact Us</h3>
                        <p class="contact-subtitle">Please complete all fields in the form below to send your message</p>
                    </div>
                    
                    <form action="{{ route('public_contact.store') }}" method="POST" class="contact-form">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="form-label">Full Name</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter your full name" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email" class="form-label">Email Address</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Valid email" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="contact_number" class="form-label">Phone Number</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                                        <input type="text" class="form-control" id="contact_number" name="contact_number" placeholder="e.g. Valid Mobile Number" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="cnic" class="form-label">CNIC Number</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-credit-card"></i></span>
                                        <input type="text" class="form-control" id="cnic" name="cnic" placeholder="e.g., Computerized Identity Card Number" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="message" class="form-label">Message / Query / Complaint</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-chat-left-text"></i></span>
                                        <textarea class="form-control" id="message" name="message" rows="4" placeholder="Please provide details of your query or complaint..." required></textarea>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <button type="submit" class="contact-submit-btn">
                                    <i class="bi bi-send me-2"></i> Submit Message
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>