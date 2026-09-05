<head>
    <link rel="icon" href="<?=base_url('images/logo.png');?>" type="image/gif" sizes="16x16">
    <!-- Owl Carousel CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" />
</head>
<!-- Mirrored from eyecix.com/html/careplus/team-list.html by --->
<?php include ("includes/header_new.php"); ?>
<style>
::-webkit-scrollbar {
  width: 10px;
}

/* Track */
::-webkit-scrollbar-track {
  background: #295771; 
}
 
/* Handle */
::-webkit-scrollbar-thumb {
  background: #9bc03c; 
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
  background: white; 
}

.BtnAds {
    background: white;
    color: #9bc03c;
    border-radius: 23px;
    font-size: 25px;
    margin: 6px;
}
.BackHeight{
    height:374px;
    overflow-y:scroll;
}

#MoreShow{


}
.box_sh_bg:hover #MoreShow{
  
    transition:0.9s;
}

/* Sidebar Featured Doctor Card Container */
.sidebar-promoted-section {
    width: 100%;
    margin-top: 20px;
    margin-bottom: 24px;
}
.sidebar-promoted-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 12px;
    padding: 0 4px;
}
.sidebar-promoted-title {
    font-size: 14px;
    font-weight: 700;
    color: #0A2540;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 6px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
.sidebar-promoted-title i {
    color: #f59e0b;
}

.sidebar-doctor-card {
    width: 100%;
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 22px 14px 18px;
    box-shadow: 0 4px 14px rgba(0, 0, 0, 0.07);
    position: relative;
    box-sizing: border-box;
    text-align: center;
    margin: 0 auto;
}

/* Sponsored / Featured Tag */
.sidebar-doctor-card .badge-sponsored {
    position: absolute;
    top: 10px;
    right: 10px;
    background-color: #fff3cd;
    color: #856404;
    border: 1px solid #ffeeba;
    font-size: 10px;
    font-weight: 700;
    padding: 2px 7px;
    border-radius: 4px;
    letter-spacing: 0.4px;
    text-transform: uppercase;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    z-index: 2;
}

.sidebar-doctor-avatar {
    width: 88px;
    height: 88px;
    border-radius: 50%;
    object-fit: cover;
    margin: 0 auto 12px auto;
    border: 3px solid #f0fdfa;
    box-shadow: 0 3px 10px rgba(0, 168, 150, 0.18);
    display: block;
}

.sidebar-doctor-name {
    font-size: 15px;
    font-weight: 700;
    color: #0A2540;
    margin: 0 0 4px 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    padding: 0 4px;
}
.sidebar-doctor-spec {
    font-size: 12px;
    font-weight: 600;
    color: #00a896;
    margin-bottom: 4px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.sidebar-doctor-hosp {
    font-size: 11.5px;
    color: #64748b;
    margin-bottom: 15px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* Fix Full-Width Action Buttons (No Clipping / Truncation) */
.sidebar-doctor-card .btn-action {
    display: block;
    width: 100%;
    margin-bottom: 8px;
    padding: 8px 10px;
    font-size: 13px;
    font-weight: 600;
    text-align: center;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    border-radius: 6px;
    box-sizing: border-box;
    text-decoration: none !important;
    transition: all 0.2s ease;
    line-height: 1.35;
}
.sidebar-doctor-card .btn-action:last-child {
    margin-bottom: 0;
}

.btn-sidebar-contact {
    background: #f8fafc;
    color: #334155 !important;
    border: 1px solid #cbd5e1;
}
.btn-sidebar-contact:hover {
    background: #f1f5f9;
    color: #0f172a !important;
    border-color: #94a3b8;
}

.btn-sidebar-profile {
    background: #043d5b;
    color: #ffffff !important;
    border: 1px solid #043d5b;
}
.btn-sidebar-profile:hover {
    background: #032b40;
    color: #ffffff !important;
}

.btn-sidebar-book {
    background: #00a896;
    color: #ffffff !important;
    border: 1px solid #00a896;
}
.btn-sidebar-book:hover {
    background: #028072;
    color: #ffffff !important;
}

/* Owl Carousel Custom Nav for Sidebar */
.sidebar-doctor-slider.owl-carousel .owl-nav {
    display: flex;
    justify-content: space-between;
    margin-top: 10px;
}
.sidebar-doctor-slider.owl-carousel .owl-nav button.owl-prev,
.sidebar-doctor-slider.owl-carousel .owl-nav button.owl-next {
    background: #ffffff !important;
    border: 1px solid #cbd5e1 !important;
    color: #475569 !important;
    width: 32px;
    height: 32px;
    border-radius: 50% !important;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 13px !important;
    transition: all 0.2s ease;
    box-shadow: 0 1px 4px rgba(0,0,0,0.06);
    cursor: pointer;
}
.sidebar-doctor-slider.owl-carousel .owl-nav button.owl-prev:hover,
.sidebar-doctor-slider.owl-carousel .owl-nav button.owl-next:hover {
    background: #00a896 !important;
    border-color: #00a896 !important;
    color: #ffffff !important;
}

.advrtzmnt {
    background: #ffffff;
    margin-top: 24px;
    border-radius: 3px 23px;
    padding: 20px 12px;
}
.advrtzmnt img {
    height: 134px;
    width: 144px;
}
.hosp_name ul li {
    display: inline-block;
    margin-right: 0px;
    margin-top: 10px;
    transition: 0.3s;
}
.hosp_name ul li img {
    border: 1px solid #cccccc4a;
    height: 94px;
    width: 100%;
}
.colorwhite{
    color: black;
}
.add_list {
    border-bottom: 1px solid #d0d0d078;
    margin-top: 16px;
}
.add_list li {
    margin:0px;
    background:none;
   color: #08364b;  
}
.lastViewBtn {
    float: right;
    background: #9bc03c;
    color: white;
    padding: 0px 20px;
}
.box_sh_bg {
    border: 1px solid #e8e8e8;
    background-color: #fff;
    box-shadow: 0 1px 2px 1px hsla(0, 0%, 43%, 0.1);
    padding: 15px;
    margin: 20px 0 0px 0px;
    border-radius:23px 0px 0px 23px;
    box-shadow: 0px 0px 0px 0px;
    height: auto;
    transition:0.9s;

}
.docimg {
    height: 171px;
    border-radius: 83px;
    box-shadow: 0px -5px 4px -1px #848181;
    width: 100%;
}
.docName {
    font-size: 12px;
    color: #043d5b;
    letter-spacing: 0.8px;
    font-size: 16px;
    font-weight: 600;
    font-family: 'Lato', sans-serif;
}
.timeicon{color: #295771;font-size: 35px;transition: 0.3s;}
.timeicon:hover{transform: scale(1.1,1.1);}
.boxbtn {
    background: #295771;
    padding: 9px 12px;
    color: #ffffff;
    border-radius: 4px;
    transition: 0.5s;
    box-shadow: 0px 0px green inset;
    width: 100%;
    margin: 3px;
}

.boxbtn:last-child{
    background: #9bc03c;

    box-shadow: 0px -2px 5px #797676;
}
.boxbtn:last-child:hover{
	transition: 0.5s;
    box-shadow: 0px 40px white inset;
}
.boxbtn:hover{
    box-shadow: 0px 40px white inset;
    color: black;
}

.secondmenuicon{
    font-size:31px;
    color:white;
    display:none;
    
}
#searchBTN {
    width: 100%;
    padding: 12px;
    border: none;
    background-color:#9bc03c;
    color: white;
    margin-top: 5px;
    font-size: 16px;
    border-radius: 2px 2px 18px 0px;
}
    .careplus-navigation-section.careplus-bgcolor, .box-form .careplus-fancy-title{
        display:none;
    }

.book-btn{
    background: #9bc03c;
    color: white;
    border-radius: 2px;
        margin-bottom: 19px;
}

.small-btn-hospital {
    background: #01324c;
    padding: 8px 16px;
    line-height: 3.2;
}
.menutab{
    background: #043d5b;
    margin-bottom:3px;
}
.menutab:first-child { 
    border-radius:14px 0px 0px 0px;
}
.menutab:last-child { 
    border-radius:0px 0px 14px 0px;
}

@media screen and (max-width: 480px) {
    .box_sh_bg {
    width: 100%;
}
.docimg {
    width: 156px;
}
.hosp_name ul li {
    display:block;

    width: 100%;
}

#mobledoctor {
       width: 100%;
  }
  .col-sm-2{
      text-align:center;
  }

.view_profile {width:100%;margin: 3px;}

/*--small photos
.smallImg{width:100%;}
small photos close--*/
}


@media screen and (max-width: 786px) {
#sidebartab{position:absolute;z-index:432;margin:5px 0px; width: 263px;transition:0.3s;}
}

@media screen and (max-width: 786px) {
.paddl0{
    width: 100%;
    padding: 0px 165px;
}
.mobilesearchicons{
    width:46px;
}
}
@media screen and (max-width: 786px) {
#sidebartab{position:absolute;z-index:432;margin:5px 0px; width: 263px;display:none;}
}

@media screen and (max-width: 786px) {
.paddl0{
    width: 100%;
    padding: 0px 165px;
}

.secondmenuicon {
    font-size: 31px;
    color: white;
    display: block;
    width: 41px;
    padding: 6px;
    margin: 7px;
    cursor: pointer;
    background: #22495f;
}
#searchBTN {
    width: 100%;
    padding: 12px;
    border: none;
    background-color:#9bc03c;
    color: white;
    margin-top: 5px;
    font-size: 16px;
    border-radius: 2px 2px 18px 0px;
}
.menutab {
    background: #ffffff;
    margin-bottom: 3px;
}
.nav > li > a {
    color: black;
}
.nav > li > a:hover, .nav > li > a:focus {
    text-decoration: none;
    background-color: #295771;
    border-radius:0px 0px;
    color: white;
}

#mobledoctor{
    padding:0px;
    text-align:center;
}
}

@media screen and (max-width: 486px) {
.boxbtn {
    width: 100%;
    margin: 3px 0px;
}
.docimg {
    height: 171px;
    box-shadow: 0px -5px 4px -1px #848181;
    width: 168px;
    border-radius: 2px;
}
.hosp_name ul li img {
    border: 1px solid #cccccc4a;
    height: 139px;
    width: 100%;
}
}
</style>
<div class="container-fluid">
    <form action='<?=base_url();?>search' method='GET'>
        <div class="box-form">
            <div class="col-sm-3">
                <div class="input-group shadow">
                    <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                    <select class="form-control" name="city">
                        <option value="">All Locations / Cities</option>
                        <?php if (!empty($cities)) { foreach($cities as $c){ ?>
                        <option value='<?=$c->id;?>' <?=(isset($_GET['city']) && $_GET['city'] == $c->id) ? 'selected' : '';?>><?=$c->name;?></option>
                        <?php } } ?>
                    </select>
                </div>
            </div>
            <div class="col-sm-5">
                <div class="input-group shadow">
                    <span class="input-group-addon"><i class="fa fa-search"></i></span>
                    <input type="text" id="hint" class="form-control ui-autocomplete-input" name="keyword" value="<?=@$_GET['keyword'];?>" placeholder="Search Hospitals/Doctors/Clinics etc" autocomplete="off">
                </div>
            </div>
            <div class="col-sm-3">
                <div class="input-group shadow">
                    <span class="input-group-addon"><i class="fa fa-user-md"></i></span>
                    <select class="form-control" name="spl">
                        <option value="">-Specialization-</option>
                        <?php foreach($specialization as $s){ ?>
                        <option value='<?=$s->id;?>' <?=(isset($_GET['spl']) && $_GET['spl'] == $s->id) ? 'selected' : '';?>><?=$s->name;?></option>
                        <?php } ?>               
                    </select>
                </div>   
            </div>
            <div class="col-sm-1">
                <button class="careplus-booking-btn careplus-bgcolor-two" id="searchBTN"><i class="fa fa-search" aria-hidden="true"></i></button>
            </div>
            <div class="clearfix"></div>
        </div>
    </form>
    <section id="doctor_list">
        <div class="container">
            <?php $promoted_list = !empty($promoted_doctors) ? $promoted_doctors : array(); ?>
            <?php if (!empty($promoted_list)): ?>
            <div class="col-md-3 col-sm-4 col-xs-12" style="padding-left: 0; padding-right: 15px;">
                <div class="sidebar-promoted-section">
                    <div class="sidebar-promoted-header" style="margin-bottom: 12px;">
                        <h5 class="sidebar-promoted-title">
                            <i class="fa fa-star"></i> Promoted Specialists
                        </h5>
                    </div>

                    <div class="owl-carousel sidebar-doctor-slider owl-theme">
                        <?php foreach($promoted_list as $d): 
                            $drImg = (!empty($d->drimage) && file_exists('admin1947/public/assets/upload/'.$d->drimage)) 
                                ? admin_url('public/assets/upload/'.$d->drimage) 
                                : base_url('images/dummydr.jpg');
                            $drName = (stripos($d->fname, 'dr') === false ? 'Dr. ' : '') . trim($d->fname . ' ' . $d->lname);
                            $drSpl = !empty($d->spl_name) ? $d->spl_name : 'Verified Specialist';
                            $hospName = !empty($d->hosp_name) ? $d->hosp_name : 'Upchar Partner Hospital';
                            $contactPhone = !empty($d->contact_phone) ? $d->contact_phone : '8448440603';
                        ?>
                        <div class="sidebar-doctor-card text-center">
                            <span class="badge-sponsored"><i class="fa fa-bolt"></i> Sponsored</span>
                            
                            <img src="<?=$drImg;?>" alt="<?=htmlspecialchars($drName);?>" class="doctor-avatar img-fluid rounded-circle mb-2 sidebar-doctor-avatar">
                            
                            <h6 class="doctor-name sidebar-doctor-name mt-2 mb-1" title="<?=htmlspecialchars($drName);?>"><?=htmlspecialchars($drName);?></h6>
                            <div class="sidebar-doctor-spec" title="<?=htmlspecialchars($drSpl);?>"><?=htmlspecialchars($drSpl);?></div>
                            <div class="sidebar-doctor-hosp" title="<?=htmlspecialchars($hospName);?>" style="margin-bottom: 15px;"><i class="fa fa-hospital-o"></i> <?=htmlspecialchars($hospName);?></div>

                            <a href="tel:<?=$contactPhone;?>" class="btn btn-secondary btn-action btn-sidebar-contact" title="Call <?=htmlspecialchars($hospName);?>">
                                <i class="fa fa-phone"></i> Contact Hospital
                            </a>
                            <a href="<?=base_url('doctor/'.$d->id);?>" class="btn btn-info btn-action btn-sidebar-profile" title="View Full Doctor Profile">
                                <i class="fa fa-user-md"></i> View Profile
                            </a> 
                            <a href="#" class="btn btn-success btn-action btn-sidebar-book getappointment btn-book-appointment" 
                               data-doctor-id="<?=$d->id;?>" 
                               data-upchar-did="<?=$d->id;?>" 
                               data-toggle="modal" 
                               data-target="#myModal"
                               title="Instant Online Appointment Booking">
                                <i class="fa fa-calendar-check-o"></i> Book Appointment
                            </a>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="col-md-9 col-sm-8 col-xs-12">
            <?php else: ?>
            <div class="col-xs-12">
            <?php endif; ?>
                <div class="col-sm-12" style="padding: 0;">
                    <?php if (!empty($doctors)) { foreach($doctors as $d){ 
                        $quastring = '';
                        $qu = $this->db->get_where('dr_qualifications', array('user_id' => $d->id));
                        if ($qu && $qu->num_rows() > 0) {
                            foreach($qu->result() as $q) {
                                $quastring .= getQualificationName($q->qualification_id).', ';
                            }
                            $quastring = rtrim($quastring, ', ');
                        }

                        $practdata = $this->db->get_where('dr_practice', array('user_id' => $d->id, 'status' => '1'));
                        $practcount = $practdata->num_rows(); 
                        $pract = $practdata->row(); 
                        $institution_table = '';
                        if(@$pract->type == 'C') $institution_table = 'clinic';
                        else if(@$pract->type == 'H') $institution_table = 'hospital';
                        $institution = null;
                        if($institution_table){
                            $institutiondata = $this->db->get_where($institution_table, array('id' => @$pract->institution_id, 'status' => '1'));
                            $institution = @$institutiondata->row();
                        }

                        $specList = $this->db->get_where('dr_specialization', array('user_id' => $d->id))->result();
                        $drImg = ($d->drimage && file_exists('admin1947/public/assets/upload/'.$d->drimage)) 
                                 ? admin_url().'public/assets/upload/'.$d->drimage 
                                 : admin_url().'public/assets/upload/dummydr.jpg';
                        $drPrefix = (strcasecmp(substr($d->fname, 0, 2), 'Dr') != 0) ? 'Dr. ' : '';
                        $fee = (!empty($pract->fee)) ? $pract->fee : '500';
                        $clinicName = (!empty($institution->name)) ? $institution->name : 'Upchar Partner Clinic';
                        $clinicAddress = (!empty($institution->address)) ? $institution->address : (getCityName($d->city) ?: 'Varanasi, India');
                    ?>
                    <!-- 3-Column Modern Doctor Profile Card -->
                    <div class="doctor-card">
                        <!-- Column 1: Profile & Trust -->
                        <div class="doc-col-left">
                            <div class="avatar-wrapper">
                                <img src="<?=$drImg;?>" alt="<?=$drPrefix.$d->fname.' '.$d->lname;?>" class="doc-avatar" loading="lazy">
                            </div>
                            <div class="trust-badges">
                                <span class="badge-rating"><i class="fa fa-thumbs-up"></i> 93%</span>
                                <span class="badge-fee">₹<?=$fee;?></span>
                            </div>
                        </div>

                        <!-- Column 2: Layered Details (Name, Spec, Experience, Clinic) -->
                        <div class="doc-col-mid">
                            <div class="doc-header">
                                <h3 class="doc-name">
                                    <a href="<?=base_url();?>doctor/<?=$d->id;?>"><?=$drPrefix.$d->fname.' '.$d->lname;?></a>
                                </h3>
                                <?php if (!empty($quastring)) { ?>
                                <span class="doc-qualifications"><?=$quastring;?></span>
                                <?php } ?>
                            </div>
                            
                            <div class="doc-spec-tags">
                                <span class="spec-pill" style="background: #E8F0FE; color: #1A73E8; border: 1px solid #D2E3FC; font-weight: 600;">
                                    <i class="fa fa-video-camera"></i> Video Consult
                                </span>
                                <?php if (!empty($specList)) { 
                                    foreach($specList as $sp) {
                                        $sname = getSpecilizationName($sp->specialization_id);
                                        if ($sname) { ?>
                                            <span class="spec-pill"><?=$sname;?></span>
                                        <?php }
                                    }
                                } else { ?>
                                    <span class="spec-pill">General Physician</span>
                                <?php } ?>
                            </div>

                            <div class="doc-meta-info">
                                <?php if ($d->exp > 0) { ?>
                                <p class="meta-item exp-item">
                                    <i class="fa fa-briefcase"></i> <strong><?=$d->exp;?> Years</strong> Experience
                                </p>
                                <?php } ?>
                                <p class="meta-item clinic-item">
                                    <i class="fa fa-hospital-o"></i> <strong><?=$clinicName;?></strong>
                                    <?php if($practcount > 1){ echo '<span class="text-muted" style="font-size: 0.8rem;"> (+'.($practcount-1).' more places)</span>'; } ?>
                                </p>
                                <p class="meta-item location-item">
                                    <i class="fa fa-map-marker"></i> <?=$clinicAddress;?>
                                </p>
                            </div>
                        </div>

                        <!-- Column 3: Booking Actions & Assurance -->
                        <div class="doc-col-right">
                            <div class="wait-time-badge">
                                <i class="fa fa-clock-o"></i> 30 mins or less wait time assured
                            </div>
                            <div class="action-buttons">
                                <a href="<?=base_url();?>doctor/<?=$d->id;?>" class="btn btn-outline">View Profile</a>
                                <a href="tel:8448440603" class="btn btn-secondary">Contact Hospital</a>
                                <a href="#" class="btn btn-primary-cta getappointment btn-book-appointment" data-doctor-id="<?=$d->id;?>" data-upchar-did="<?=$d->id;?>" data-toggle="modal" data-target="#myModal">Book Appointment</a>
                            </div>
                        </div>
                    </div>
                    <?php } } else { ?>
                    <div class="doctor-card text-center" style="display: block; padding: 40px;">
                        <h4 style="color: #64748b; margin-bottom: 8px;">No doctors found matching your criteria.</h4>
                        <p style="color: #94a3b8;">Try changing your location or specialization filter.</p>
                    </div>
                    <?php } ?>

                    <?php 
                    $curr_city = isset($_GET['city']) ? $_GET['city'] : '';
                    $curr_keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
                    $curr_spl = isset($_GET['spl']) ? $_GET['spl'] : '';
                    $curr_per_page = isset($per_page_param) ? $per_page_param : '10';
                    $c_page = isset($current_page) ? $current_page : 1;
                    $t_pages = isset($total_pages) ? $total_pages : 1;
                    $t_docs = isset($total_doctors) ? $total_doctors : (isset($doctors) ? count($doctors) : 0);
                    $p_size = isset($per_page) ? $per_page : 10;

                    if (!function_exists('buildPageUrl')) {
                        function buildPageUrl($p, $city, $kw, $spl, $pp) {
                            return base_url('search').'?city='.urlencode($city).'&keyword='.urlencode($kw).'&spl='.urlencode($spl).'&per_page='.urlencode($pp).'&page='.$p;
                        }
                    }
                    ?>

                    <?php if ($t_docs > 0) { ?>
                    <!-- Pagination Toolbar -->
                    <div class="pagination-toolbar">
                        <div class="pagination-info">
                            Showing <strong><?=($c_page - 1) * $p_size + 1;?></strong> - <strong><?=min($c_page * $p_size, $t_docs);?></strong> of <strong><?=$t_docs;?></strong> verified doctors
                        </div>

                        <div class="pagination-controls">
                            <!-- Previous Page -->
                            <a href="<?=buildPageUrl($c_page - 1, $curr_city, $curr_keyword, $curr_spl, $curr_per_page);?>" class="page-btn <?=($c_page <= 1) ? 'disabled' : '';?>" title="Previous Page">
                                <i class="fa fa-chevron-left"></i>
                            </a>

                            <!-- Page Numbers -->
                            <?php 
                            $start_p = max(1, $c_page - 2);
                            $end_p = min($t_pages, $c_page + 2);
                            if ($start_p > 1) {
                                echo '<a href="'.buildPageUrl(1, $curr_city, $curr_keyword, $curr_spl, $curr_per_page).'" class="page-btn">1</a>';
                                if ($start_p > 2) echo '<span class="page-btn disabled">...</span>';
                            }
                            for ($p = $start_p; $p <= $end_p; $p++) {
                                $activeClass = ($p == $c_page) ? 'active' : '';
                                echo '<a href="'.buildPageUrl($p, $curr_city, $curr_keyword, $curr_spl, $curr_per_page).'" class="page-btn '.$activeClass.'">'.$p.'</a>';
                            }
                            if ($end_p < $t_pages) {
                                if ($end_p < $t_pages - 1) echo '<span class="page-btn disabled">...</span>';
                                echo '<a href="'.buildPageUrl($t_pages, $curr_city, $curr_keyword, $curr_spl, $curr_per_page).'" class="page-btn">'.$t_pages.'</a>';
                            }
                            ?>

                            <!-- Next Page -->
                            <a href="<?=buildPageUrl($c_page + 1, $curr_city, $curr_keyword, $curr_spl, $curr_per_page);?>" class="page-btn <?=($c_page >= $t_pages) ? 'disabled' : '';?>" title="Next Page">
                                <i class="fa fa-chevron-right"></i>
                            </a>
                        </div>

                        <div class="per-page-wrapper">
                            <label for="perPageSelect" style="margin: 0; font-weight: 500; color: #64748B;">Per Page:</label>
                            <select id="perPageSelect" class="per-page-select" onchange="location = this.value;">
                                <option value="<?=buildPageUrl(1, $curr_city, $curr_keyword, $curr_spl, '10');?>" <?=($curr_per_page == '10') ? 'selected' : '';?>>10</option>
                                <option value="<?=buildPageUrl(1, $curr_city, $curr_keyword, $curr_spl, '20');?>" <?=($curr_per_page == '20') ? 'selected' : '';?>>20</option>
                                <option value="<?=buildPageUrl(1, $curr_city, $curr_keyword, $curr_spl, '50');?>" <?=($curr_per_page == '50') ? 'selected' : '';?>>50</option>
                                <option value="<?=buildPageUrl(1, $curr_city, $curr_keyword, $curr_spl, 'all');?>" <?=($curr_per_page == 'all') ? 'selected' : '';?>>All</option>
                            </select>
                        </div>
                    </div>
                    <?php } ?>
                </div>

                <?php if (!empty($hospital)) { ?>
                <div class="col-sm-12" style="padding: 0; margin-top: 10px;">
                    <h4 style="font-weight: 700; color: #05668d; margin-bottom: 16px;"><i class="fa fa-hospital-o"></i> Healthcare Facilities & Hospitals</h4>
                    <?php foreach($hospital as $institution) { 
                        $hImg = ($institution->drimage && file_exists('admin1947/public/assets/upload/'.$institution->drimage)) 
                                ? admin_url().'public/assets/upload/'.$institution->drimage 
                                : admin_url().'public/assets/upload/dummyhospital.jpg';
                    ?>                 
                    <div class="hospital-card">
                        <div class="doc-col-left">
                            <div class="avatar-wrapper">
                                <img src="<?=$hImg;?>" alt="<?=$institution->name;?>" class="doc-avatar" loading="lazy">
                            </div>
                            <div class="trust-badges">
                                <span class="badge-rating"><i class="fa fa-thumbs-up"></i> 99%</span>
                                <span class="badge-fee">₹500 Fee</span>
                            </div>
                        </div>

                        <div class="doc-col-mid">
                            <div class="doc-header">
                                <h3 class="doc-name">
                                    <a href="<?=base_url();?>hospital/<?=$institution->id;?>"><?=$institution->name;?></a>
                                </h3>
                                <span class="doc-qualifications"><i class="fa fa-hospital-o"></i> Verified Hospital & Clinical Center</span>
                            </div>
                            <div class="doc-spec-tags">
                                <span class="spec-pill">24/7 Emergency</span>
                                <span class="spec-pill">Inpatient / Outpatient</span>
                                <span class="spec-pill">Multi-Specialty</span>
                            </div>
                            <div class="doc-meta-info">
                                <p class="meta-item"><i class="fa fa-clock-o"></i> <strong>24/7 Service</strong> (Mon - Sun)</p>
                                <p class="meta-item"><i class="fa fa-map-marker"></i> <?=$institution->address ?: 'India';?></p>
                            </div>
                        </div>

                        <div class="doc-col-right">
                            <div class="wait-time-badge">
                                <i class="fa fa-phone"></i> Helpline: 844-844-0603
                            </div>
                            <div class="action-buttons">
                                <a href="<?=base_url();?>hospital/<?=$institution->id;?>" class="btn btn-outline">View Hospital Profile</a>
                                <a href="tel:8448440603" class="btn btn-primary-cta">Call Hospital</a>
                            </div>
                        </div>
                    </div>	 
                    <?php } ?>
                </div> 
                <?php } ?>
            </div>
        </div>
    </section>
    <br/><br/>
    <?php include ('includes/footer.php'); ?>
    <!-- Owl Carousel 2 JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script> 
        $(document).ready(function(){
            $(".secondmenuicon").click(function(){
                $("#sidebartab").slideToggle("slow");
            });

            if (typeof $.fn.owlCarousel !== 'undefined' && $('.sidebar-doctor-slider').length) {
                var itemCount = $('.sidebar-doctor-slider .sidebar-doctor-card').length;
                $('.sidebar-doctor-slider').owlCarousel({
                    loop: (itemCount > 1),
                    margin: 10,
                    nav: (itemCount > 1),
                    dots: false,
                    autoplay: (itemCount > 1),
                    autoplayTimeout: 4000,
                    autoplayHoverPause: true,
                    items: 1, // Show 1 card at a time in the sidebar
                    navText: [
                        '<i class="fa fa-arrow-left"></i>',
                        '<i class="fa fa-arrow-right"></i>'
                    ]
                });
            }
        });
    </script>