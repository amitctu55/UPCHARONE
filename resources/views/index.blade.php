@extends('layouts.app')

@section('content')
@include('layouts.header')

<!-- ==========================================================================
     1. DYNAMIC SPLIT HERO SECTION WITH MULTI-TAB SEARCH
     ========================================================================== -->
<section class="hero-wrapper py-5 position-relative overflow-hidden" style="background: linear-gradient(135deg, #f8fafc 0%, #e0f2fe 100%);">
  <div class="container py-4">
    <div class="row align-items-center g-5">
      <!-- Left Hero Content & Dynamic Search Widget -->
      <div class="col-lg-7">
        <div class="d-inline-flex align-items-center bg-white px-3 py-2 rounded-pill shadow-sm mb-3">
          <span class="badge bg-success rounded-circle p-1 me-2"><i class="fas fa-check fs-8 text-white"></i></span>
          <small class="fw-bold text-dark me-2">India's Trusted Healthcare Network</small>
        </div>

        <h1 class="display-5 fw-extrabold text-dark mb-3">
          Your Home For Health &amp; <span class="text-primary">Doctor Consultations</span>
        </h1>

        <p class="fs-5 text-muted mb-4 pe-lg-4">
          Book verified in-clinic appointments, instant 24/7 video consultations, certified lab tests, and hospital care seamlessly.
        </p>

        <!-- MULTI-TAB SEARCH CONTAINER -->
        <div class="search-card bg-white p-4 rounded-4 shadow-lg border border-light">
          <!-- Search Pill Tabs -->
          <div class="d-flex align-items-center gap-2 mb-3 search-tab-group">
            <button type="button" class="btn btn-sm search-tab-btn active" data-type="doctors" data-action="{{ url('/doctors') }}" data-placeholder="Search doctors, specialties (e.g. Cardiologist, Dentist)...">
              <i class="fas fa-user-md me-1"></i> Doctors
            </button>
            <button type="button" class="btn btn-sm search-tab-btn" data-type="lab-tests" data-action="{{ url('/lab-tests') }}" data-placeholder="Search lab tests & packages (e.g. CBC, Full Body)...">
              <i class="fas fa-flask me-1"></i> Lab Tests
            </button>
            <button type="button" class="btn btn-sm search-tab-btn" data-type="hospitals" data-action="{{ url('/hospitals') }}" data-placeholder="Search hospitals & clinics by name or treatment...">
              <i class="fas fa-hospital me-1"></i> Hospitals
            </button>
          </div>

          <!-- Search Form -->
          <form id="heroSearchForm" action="{{ url('/doctors') }}" method="GET" class="row g-2 align-items-center">
            <div class="col-md-4">
              <div class="input-group">
                <span class="input-group-text bg-light border-0 text-danger"><i class="fas fa-map-marker-alt"></i></span>
                <select name="city" id="heroCitySelect" class="form-select border-0 bg-light fs-7 fw-semibold">
                  <option value="Varanasi" selected>Varanasi</option>
                  <option value="Lucknow">Lucknow</option>
                  <option value="Delhi">Delhi</option>
                  <option value="Mumbai">Mumbai</option>
                </select>
              </div>
            </div>
            <div class="col-md-5">
              <div class="input-group">
                <span class="input-group-text bg-light border-0 text-muted"><i class="fas fa-search"></i></span>
                <input type="text" id="heroKeywordInput" name="keyword" class="form-control border-0 bg-light fs-7" placeholder="Search doctors, specialties...">
              </div>
            </div>
            <div class="col-md-3">
              <button type="submit" class="btn btn-primary w-100 py-2 fw-bold rounded-3 shadow-sm">
                Find Care <i class="fas fa-arrow-right ms-1"></i>
              </button>
            </div>
          </form>
        </div>
      </div>

      <!-- Right Hero Graphic with Live Stat Badges -->
      <div class="col-lg-5 position-relative text-center">
        <div class="hero-image-container position-relative d-inline-block">
          <img src="{{ asset('images/hero-doctor.png') }}" alt="Healthcare Specialists" class="img-fluid rounded-4 shadow-lg hero-main-graphic">
          
          <!-- Floating Live Stat Badge 1 (Specialists) -->
          <div class="hero-floating-badge badge-top shadow-lg">
            <div class="badge-icon-box bg-soft-primary text-primary">
              <i class="fas fa-user-md"></i>
            </div>
            <div class="text-start">
              <div class="fw-extrabold text-dark fs-6">1,400+</div>
              <small class="text-muted fw-semibold">Verified Specialists</small>
            </div>
          </div>

          <!-- Floating Live Stat Badge 2 (24/7 Care) -->
          <div class="hero-floating-badge badge-bottom shadow-lg">
            <div class="badge-icon-box bg-soft-success text-success">
              <i class="fas fa-clock"></i>
            </div>
            <div class="text-start">
              <div class="fw-extrabold text-dark fs-6">24/7 Care</div>
              <small class="text-muted fw-semibold">Instant Video Connect</small>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ==========================================================================
     2. QUICK SERVICE CARDS GRID (4-COLUMN RESPONSIVE)
     ========================================================================== -->
<section class="py-5 bg-white">
  <div class="container py-2">
    <div class="row g-4">
      <!-- 1. Instant Video Consult -->
      <div class="col-lg-3 col-md-6">
        <a href="{{ url('/doctors') }}" class="card service-card h-100 border-0 shadow-sm p-4 text-decoration-none">
          <div class="service-card-icon-box bg-soft-blue text-primary mb-3">
            <i class="fas fa-video fa-2x"></i>
          </div>
          <h5 class="fw-bold text-dark mb-2">Instant Video Consult</h5>
          <p class="text-muted fs-7 mb-3 flex-grow-1">24/7 connectivity in 60s with certified specialist doctors right from home.</p>
          <div class="fw-bold text-primary fs-7 d-flex align-items-center">
            Consult Online <i class="fas fa-arrow-right ms-2 fs-8"></i>
          </div>
        </a>
      </div>

      <!-- 2. In-Clinic Appointments -->
      <div class="col-lg-3 col-md-6">
        <a href="{{ url('/doctors') }}" class="card service-card h-100 border-0 shadow-sm p-4 text-decoration-none">
          <div class="service-card-icon-box bg-soft-emerald text-success mb-3">
            <i class="fas fa-user-md fa-2x"></i>
          </div>
          <h5 class="fw-bold text-dark mb-2">In-Clinic Appointments</h5>
          <p class="text-muted fs-7 mb-3 flex-grow-1">Zero wait time &amp; no booking fees. Book verified specialists near you.</p>
          <div class="fw-bold text-success fs-7 d-flex align-items-center">
            Find Doctors <i class="fas fa-arrow-right ms-2 fs-8"></i>
          </div>
        </a>
      </div>

      <!-- 3. Lab Tests & Checkups -->
      <div class="col-lg-3 col-md-6">
        <a href="{{ url('/lab-tests') }}" class="card service-card h-100 border-0 shadow-sm p-4 text-decoration-none">
          <div class="service-card-icon-box bg-soft-indigo text-indigo mb-3">
            <i class="fas fa-flask fa-2x"></i>
          </div>
          <h5 class="fw-bold text-dark mb-2">Lab Tests &amp; Checkups</h5>
          <p class="text-muted fs-7 mb-3 flex-grow-1">100% NABL certified partner labs with free doorstep sample collection.</p>
          <div class="fw-bold text-indigo fs-7 d-flex align-items-center">
            Book Lab Test <i class="fas fa-arrow-right ms-2 fs-8"></i>
          </div>
        </a>
      </div>

      <!-- 4. Surgeries & Hospitals -->
      <div class="col-lg-3 col-md-6">
        <a href="{{ url('/hospitals') }}" class="card service-card h-100 border-0 shadow-sm p-4 text-decoration-none">
          <div class="service-card-icon-box bg-soft-sky text-info mb-3">
            <i class="fas fa-hospital fa-2x"></i>
          </div>
          <h5 class="fw-bold text-dark mb-2">Surgeries &amp; Hospitals</h5>
          <p class="text-muted fs-7 mb-3 flex-grow-1">NABH accredited hospitals with seamless admission and full insurance support.</p>
          <div class="fw-bold text-info fs-7 d-flex align-items-center">
            Explore Care <i class="fas fa-arrow-right ms-2 fs-8"></i>
          </div>
        </a>
      </div>
    </div>
  </div>
</section>

<!-- ==========================================================================
     3. TOP SPECIALTIES GRID (6-COLUMN RESPONSIVE)
     ========================================================================== -->
<section class="py-5 bg-light">
  <div class="container py-2">
    <div class="text-center mb-5">
      <span class="badge bg-soft-primary text-primary px-3 py-2 rounded-pill fw-bold text-uppercase fs-8 mb-2">Top Specialties</span>
      <h2 class="fw-extrabold text-dark mb-2">Consult Top Doctors by Specialization</h2>
      <p class="text-muted fs-6 max-w-600 mx-auto">Get expert medical advice for any health condition from experienced, verified clinicians.</p>
    </div>

    <div class="row g-3">
      <!-- General Medicine -->
      <div class="col-lg-2 col-md-4 col-6">
        <a href="{{ url('/doctors?spl=General+Medicine') }}" class="card specialty-card text-center p-3 h-100 border-0 shadow-sm text-decoration-none">
          <div class="specialty-icon-circle bg-soft-blue text-primary mx-auto mb-3">
            <i class="fas fa-stethoscope fa-lg"></i>
          </div>
          <h6 class="fw-bold text-dark mb-1">General Medicine</h6>
          <small class="text-muted fs-8">Fever, Flu, Fatigue</small>
        </a>
      </div>

      <!-- Gynecology -->
      <div class="col-lg-2 col-md-4 col-6">
        <a href="{{ url('/doctors?spl=Gynecology') }}" class="card specialty-card text-center p-3 h-100 border-0 shadow-sm text-decoration-none">
          <div class="specialty-icon-circle bg-soft-pink text-pink mx-auto mb-3">
            <i class="fas fa-female fa-lg"></i>
          </div>
          <h6 class="fw-bold text-dark mb-1">Gynecology</h6>
          <small class="text-muted fs-8">Women &amp; Maternity</small>
        </a>
      </div>

      <!-- Dermatology -->
      <div class="col-lg-2 col-md-4 col-6">
        <a href="{{ url('/doctors?spl=Dermatology') }}" class="card specialty-card text-center p-3 h-100 border-0 shadow-sm text-decoration-none">
          <div class="specialty-icon-circle bg-soft-amber text-warning mx-auto mb-3">
            <i class="fas fa-allergies fa-lg"></i>
          </div>
          <h6 class="fw-bold text-dark mb-1">Dermatology</h6>
          <small class="text-muted fs-8">Skin, Hair &amp; Acne</small>
        </a>
      </div>

      <!-- Pediatrics -->
      <div class="col-lg-2 col-md-4 col-6">
        <a href="{{ url('/doctors?spl=Pediatrics') }}" class="card specialty-card text-center p-3 h-100 border-0 shadow-sm text-decoration-none">
          <div class="specialty-icon-circle bg-soft-cyan text-info mx-auto mb-3">
            <i class="fas fa-baby fa-lg"></i>
          </div>
          <h6 class="fw-bold text-dark mb-1">Pediatrics</h6>
          <small class="text-muted fs-8">Child Care &amp; Vaccine</small>
        </a>
      </div>

      <!-- Orthopedics -->
      <div class="col-lg-2 col-md-4 col-6">
        <a href="{{ url('/doctors?spl=Orthopedics') }}" class="card specialty-card text-center p-3 h-100 border-0 shadow-sm text-decoration-none">
          <div class="specialty-icon-circle bg-soft-purple text-purple mx-auto mb-3">
            <i class="fas fa-bone fa-lg"></i>
          </div>
          <h6 class="fw-bold text-dark mb-1">Orthopedics</h6>
          <small class="text-muted fs-8">Joints, Bones &amp; Spine</small>
        </a>
      </div>

      <!-- Dentistry -->
      <div class="col-lg-2 col-md-4 col-6">
        <a href="{{ url('/doctors?spl=Dentistry') }}" class="card specialty-card text-center p-3 h-100 border-0 shadow-sm text-decoration-none">
          <div class="specialty-icon-circle bg-soft-emerald text-success mx-auto mb-3">
            <i class="fas fa-tooth fa-lg"></i>
          </div>
          <h6 class="fw-bold text-dark mb-1">Dentistry</h6>
          <small class="text-muted fs-8">Teeth &amp; Root Canal</small>
        </a>
      </div>
    </div>
  </div>
</section>

<!-- ==========================================================================
     4. VERIFIED SPECIALIST DOCTORS SECTION
     ========================================================================== -->
<section class="py-5 bg-white">
  <div class="container py-2">
    <div class="d-flex justify-content-between align-items-end mb-4 flex-wrap gap-2">
      <div>
        <span class="badge bg-soft-primary text-primary px-3 py-2 rounded-pill fw-bold text-uppercase fs-8 mb-2">Verified Consultants</span>
        <h2 class="fw-extrabold text-dark mb-1">Book Our Leading Specialists</h2>
        <p class="text-muted fs-6 mb-0">Certified clinicians with high patient satisfaction ratings.</p>
      </div>
      <a href="{{ url('/doctors') }}" class="btn btn-outline-primary rounded-pill px-4 fw-semibold">
        View All Doctors <i class="fas fa-arrow-right ms-1"></i>
      </a>
    </div>

    <div class="row g-4">
      @forelse($doctors ?? [] as $dr)
        <div class="col-lg-3 col-md-6">
          <div class="card doctor-card border-0 shadow-sm p-4 text-center h-100">
            <div class="doctor-avatar-wrap mx-auto mb-3 position-relative">
              <img src="{{ $dr->drimage ? asset('public/assets/upload/' . $dr->drimage) : asset('images/dummydr.jpg') }}" alt="{{ $dr->fname }}" class="doctor-avatar rounded-circle shadow-sm">
              <span class="doctor-verified-badge"><i class="fas fa-check"></i></span>
            </div>
            <h5 class="fw-bold text-dark mb-1">{{ (stripos($dr->fname, 'Dr') === false ? 'Dr. ' : '') . $dr->fname . ' ' . $dr->lname }}</h5>
            <div class="text-muted fs-7 mb-2">{{ $dr->specialization_name ?? 'Senior Consultant' }}</div>
            <div class="badge bg-soft-primary text-primary fs-8 px-3 py-1 rounded-pill mb-3">MBBS, MD</div>
            
            <div class="d-flex gap-2 mt-auto">
              <a href="{{ url('/doctor/' . $dr->id) }}" class="btn btn-sm btn-outline-primary w-50 rounded-pill">Profile</a>
              <a href="{{ url('/doctor/' . $dr->id) }}" class="btn btn-sm btn-primary w-50 rounded-pill">Book Now</a>
            </div>
          </div>
        </div>
      @empty
        <!-- Static High-Conversion Doctor Cards Fallback -->
        <div class="col-lg-3 col-md-6">
          <div class="card doctor-card border-0 shadow-sm p-4 text-center h-100">
            <div class="doctor-avatar-wrap mx-auto mb-3 position-relative">
              <img src="{{ asset('images/dummydr.jpg') }}" alt="Dr. Rajesh Gupta" class="doctor-avatar rounded-circle shadow-sm">
              <span class="doctor-verified-badge"><i class="fas fa-check"></i></span>
            </div>
            <h5 class="fw-bold text-dark mb-1">Dr. Rajesh Gupta</h5>
            <div class="text-muted fs-7 mb-2">Cardiologist &bull; 14 Yrs Exp</div>
            <div class="badge bg-soft-primary text-primary fs-8 px-3 py-1 rounded-pill mb-3">MBBS, MD (Cardiology)</div>
            <div class="d-flex gap-2 mt-auto">
              <a href="{{ url('/doctors') }}" class="btn btn-sm btn-outline-primary w-50 rounded-pill">Profile</a>
              <a href="{{ url('/doctors') }}" class="btn btn-sm btn-primary w-50 rounded-pill">Book Now</a>
            </div>
          </div>
        </div>

        <div class="col-lg-3 col-md-6">
          <div class="card doctor-card border-0 shadow-sm p-4 text-center h-100">
            <div class="doctor-avatar-wrap mx-auto mb-3 position-relative">
              <img src="{{ asset('images/dummydr.jpg') }}" alt="Dr. Sunita Patel" class="doctor-avatar rounded-circle shadow-sm">
              <span class="doctor-verified-badge"><i class="fas fa-check"></i></span>
            </div>
            <h5 class="fw-bold text-dark mb-1">Dr. Sunita Patel</h5>
            <div class="text-muted fs-7 mb-2">Gynecologist &bull; 11 Yrs Exp</div>
            <div class="badge bg-soft-pink text-pink fs-8 px-3 py-1 rounded-pill mb-3">MBBS, MS (OB-GYN)</div>
            <div class="d-flex gap-2 mt-auto">
              <a href="{{ url('/doctors') }}" class="btn btn-sm btn-outline-primary w-50 rounded-pill">Profile</a>
              <a href="{{ url('/doctors') }}" class="btn btn-sm btn-primary w-50 rounded-pill">Book Now</a>
            </div>
          </div>
        </div>

        <div class="col-lg-3 col-md-6">
          <div class="card doctor-card border-0 shadow-sm p-4 text-center h-100">
            <div class="doctor-avatar-wrap mx-auto mb-3 position-relative">
              <img src="{{ asset('images/dummydr.jpg') }}" alt="Dr. Amit K. Verma" class="doctor-avatar rounded-circle shadow-sm">
              <span class="doctor-verified-badge"><i class="fas fa-check"></i></span>
            </div>
            <h5 class="fw-bold text-dark mb-1">Dr. Amit K. Verma</h5>
            <div class="text-muted fs-7 mb-2">Pediatrician &bull; 9 Yrs Exp</div>
            <div class="badge bg-soft-cyan text-info fs-8 px-3 py-1 rounded-pill mb-3">MBBS, DCH, DNB</div>
            <div class="d-flex gap-2 mt-auto">
              <a href="{{ url('/doctors') }}" class="btn btn-sm btn-outline-primary w-50 rounded-pill">Profile</a>
              <a href="{{ url('/doctors') }}" class="btn btn-sm btn-primary w-50 rounded-pill">Book Now</a>
            </div>
          </div>
        </div>

        <div class="col-lg-3 col-md-6">
          <div class="card doctor-card border-0 shadow-sm p-4 text-center h-100">
            <div class="doctor-avatar-wrap mx-auto mb-3 position-relative">
              <img src="{{ asset('images/dummydr.jpg') }}" alt="Dr. Meera Nambiar" class="doctor-avatar rounded-circle shadow-sm">
              <span class="doctor-verified-badge"><i class="fas fa-check"></i></span>
            </div>
            <h5 class="fw-bold text-dark mb-1">Dr. Meera Nambiar</h5>
            <div class="text-muted fs-7 mb-2">Dermatologist &bull; 8 Yrs Exp</div>
            <div class="badge bg-soft-amber text-warning fs-8 px-3 py-1 rounded-pill mb-3">MBBS, MD (Derm)</div>
            <div class="d-flex gap-2 mt-auto">
              <a href="{{ url('/doctors') }}" class="btn btn-sm btn-outline-primary w-50 rounded-pill">Profile</a>
              <a href="{{ url('/doctors') }}" class="btn btn-sm btn-primary w-50 rounded-pill">Book Now</a>
            </div>
          </div>
        </div>
      @endforelse
    </div>
  </div>
</section>

<!-- ==========================================================================
     5. POPULAR LAB PACKAGES & VERIFIED PARTNER OFFERS
     ========================================================================== -->
<section class="py-5 bg-light">
  <div class="container py-2">
    <div class="text-center mb-5">
      <span class="badge bg-soft-success text-success px-3 py-2 rounded-pill fw-bold text-uppercase fs-8 mb-2">Diagnostic Health Checkups</span>
      <h2 class="fw-extrabold text-dark mb-2">Popular Pathology Tests &amp; Diagnostic Packages</h2>
      <p class="text-muted fs-6 max-w-600 mx-auto">100% NABL Certified tests with free doorstep home sample collection and digital reports in 24 hours.</p>
    </div>

    <div class="row g-4">
      <!-- Test 1: Complete Blood Count -->
      <div class="col-lg-3 col-md-6">
        <div class="card path-test-card border-0 shadow-sm p-4 h-100 d-flex flex-column justify-content-between position-relative">
          <span class="badge bg-soft-success text-success position-absolute top-0 end-0 m-3 rounded-pill fs-8">
            <i class="fas fa-home me-1"></i> Home Pickup
          </span>
          <div>
            <div class="test-icon-box bg-soft-blue text-primary mb-3">
              <i class="fas fa-microscope"></i>
            </div>
            <h5 class="fw-bold text-dark mb-1">Complete Blood Count (CBC)</h5>
            <p class="text-muted fs-7 mb-3">24 Parameters &bull; Automated Cell Counter</p>
            <div class="d-flex gap-2 mb-3">
              <span class="badge bg-light text-muted border fs-8"><i class="far fa-clock me-1"></i> 24 Hrs</span>
              <span class="badge bg-light text-muted border fs-8">Non-Fasting</span>
            </div>
          </div>
          <div class="d-flex align-items-center justify-content-between pt-3 border-top">
            <div>
              <small class="text-muted text-decoration-line-through fs-8">₹500</small>
              <div class="fw-extrabold text-primary fs-5">₹299</div>
            </div>
            <a href="{{ url('/lab-tests') }}" class="btn btn-sm btn-primary rounded-pill px-3">Book Test</a>
          </div>
        </div>
      </div>

      <!-- Test 2: Full Body Health Package -->
      <div class="col-lg-3 col-md-6">
        <div class="card path-test-card border-0 shadow-sm p-4 h-100 d-flex flex-column justify-content-between position-relative">
          <span class="badge bg-soft-success text-success position-absolute top-0 end-0 m-3 rounded-pill fs-8">
            <i class="fas fa-home me-1"></i> Home Pickup
          </span>
          <div>
            <div class="test-icon-box bg-soft-indigo text-indigo mb-3">
              <i class="fas fa-heartbeat"></i>
            </div>
            <h5 class="fw-bold text-dark mb-1">Full Body Checkup (64 Tests)</h5>
            <p class="text-muted fs-7 mb-3">Liver, Kidney, Lipid &amp; Thyroid Profile</p>
            <div class="d-flex gap-2 mb-3">
              <span class="badge bg-light text-muted border fs-8"><i class="far fa-clock me-1"></i> 24 Hrs</span>
              <span class="badge bg-soft-amber text-warning fs-8">10-12h Fasting</span>
            </div>
          </div>
          <div class="d-flex align-items-center justify-content-between pt-3 border-top">
            <div>
              <small class="text-muted text-decoration-line-through fs-8">₹2,999</small>
              <div class="fw-extrabold text-primary fs-5">₹999</div>
            </div>
            <a href="{{ url('/lab-tests') }}" class="btn btn-sm btn-primary rounded-pill px-3">Book Test</a>
          </div>
        </div>
      </div>

      <!-- Test 3: Thyroid Profile Total -->
      <div class="col-lg-3 col-md-6">
        <div class="card path-test-card border-0 shadow-sm p-4 h-100 d-flex flex-column justify-content-between position-relative">
          <span class="badge bg-soft-success text-success position-absolute top-0 end-0 m-3 rounded-pill fs-8">
            <i class="fas fa-home me-1"></i> Home Pickup
          </span>
          <div>
            <div class="test-icon-box bg-soft-cyan text-info mb-3">
              <i class="fas fa-vial"></i>
            </div>
            <h5 class="fw-bold text-dark mb-1">Thyroid Profile (T3, T4, TSH)</h5>
            <p class="text-muted fs-7 mb-3">Advanced CLIA Technology</p>
            <div class="d-flex gap-2 mb-3">
              <span class="badge bg-light text-muted border fs-8"><i class="far fa-clock me-1"></i> 24 Hrs</span>
              <span class="badge bg-light text-muted border fs-8">Non-Fasting</span>
            </div>
          </div>
          <div class="d-flex align-items-center justify-content-between pt-3 border-top">
            <div>
              <small class="text-muted text-decoration-line-through fs-8">₹800</small>
              <div class="fw-extrabold text-primary fs-5">₹399</div>
            </div>
            <a href="{{ url('/lab-tests') }}" class="btn btn-sm btn-primary rounded-pill px-3">Book Test</a>
          </div>
        </div>
      </div>

      <!-- Test 4: Lipid Profile Comprehensive -->
      <div class="col-lg-3 col-md-6">
        <div class="card path-test-card border-0 shadow-sm p-4 h-100 d-flex flex-column justify-content-between position-relative">
          <span class="badge bg-soft-success text-success position-absolute top-0 end-0 m-3 rounded-pill fs-8">
            <i class="fas fa-home me-1"></i> Home Pickup
          </span>
          <div>
            <div class="test-icon-box bg-soft-pink text-pink mb-3">
              <i class="fas fa-notes-medical"></i>
            </div>
            <h5 class="fw-bold text-dark mb-1">Lipid Profile Comprehensive</h5>
            <p class="text-muted fs-7 mb-3">Cholesterol, HDL, LDL, Triglycerides</p>
            <div class="d-flex gap-2 mb-3">
              <span class="badge bg-light text-muted border fs-8"><i class="far fa-clock me-1"></i> 24 Hrs</span>
              <span class="badge bg-soft-amber text-warning fs-8">12h Fasting</span>
            </div>
          </div>
          <div class="d-flex align-items-center justify-content-between pt-3 border-top">
            <div>
              <small class="text-muted text-decoration-line-through fs-8">₹1,200</small>
              <div class="fw-extrabold text-primary fs-5">₹599</div>
            </div>
            <a href="{{ url('/lab-tests') }}" class="btn btn-sm btn-primary rounded-pill px-3">Book Test</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ==========================================================================
     6. HIGH-TRUST STATS COUNTER BAR
     ========================================================================== -->
<section class="py-5 bg-white border-top border-bottom">
  <div class="container">
    <div class="row g-4 text-center">
      <div class="col-lg-3 col-6">
        <div class="p-3">
          <div class="display-6 fw-extrabold text-primary mb-1">50,000+</div>
          <p class="text-muted fw-semibold fs-7 mb-0">Happy Patients Consulted</p>
        </div>
      </div>
      <div class="col-lg-3 col-6">
        <div class="p-3">
          <div class="display-6 fw-extrabold text-primary mb-1">1,400+</div>
          <p class="text-muted fw-semibold fs-7 mb-0">Verified Doctor Specialists</p>
        </div>
      </div>
      <div class="col-lg-3 col-6">
        <div class="p-3">
          <div class="display-6 fw-extrabold text-primary mb-1">98.6%</div>
          <p class="text-muted fw-semibold fs-7 mb-0">Positive Patient Reviews</p>
        </div>
      </div>
      <div class="col-lg-3 col-6">
        <div class="p-3">
          <div class="display-6 fw-extrabold text-primary mb-1">24/7</div>
          <p class="text-muted fw-semibold fs-7 mb-0">Dedicated Patient Helpline</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ==========================================================================
     7. MULTI-TAB SEARCH JAVASCRIPT
     ========================================================================== -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    var tabs = document.querySelectorAll('.search-tab-btn');
    var form = document.getElementById('heroSearchForm');
    var input = document.getElementById('heroKeywordInput');

    tabs.forEach(function(tab) {
        tab.addEventListener('click', function() {
            tabs.forEach(function(t) { t.classList.remove('active'); });
            this.classList.add('active');

            var action = this.getAttribute('data-action');
            var placeholder = this.getAttribute('data-placeholder');

            if (form) form.action = action;
            if (input) input.placeholder = placeholder;
        });
    });
});
</script>
@endsection
