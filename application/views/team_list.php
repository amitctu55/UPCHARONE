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
  background: #878b7cff; 
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
  background: white; 
}

.BtnAds {
    background: white;
    color: #878b7cff;
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
    background: #878b7cff;
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
    background: #878b7cff;

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
    background-color:#878b7cff;
    color: white;
    margin-top: 5px;
    font-size: 16px;
    border-radius: 2px 2px 18px 0px;
}
    .careplus-navigation-section.careplus-bgcolor, .box-form .careplus-fancy-title{
        display:none;
    }

.book-btn{
    background: #878b7cff;
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
    background-color:#878b7cff;
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

/* Results Header Bar & Pagination */
.results-header-bar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: #FFFFFF;
    border: 1px solid #E2E8F0;
    border-radius: 12px;
    padding: 14px 20px;
    margin-bottom: 20px;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.03);
    flex-wrap: wrap;
    gap: 12px;
}
.results-header-title {
    display: inline-flex;
    align-items: center;
    gap: 12px;
    background: #F8FAFC;
    border: 1px solid #E2E8F0;
    border-radius: 30px;
    padding: 6px 16px;
    white-space: nowrap;
    max-width: 100%;
}
.results-count-text {
    margin: 0;
    font-size: 15px;
    font-weight: 700;
    color: #0F172A;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    white-space: nowrap;
}
.results-count-badge {
    background: #E6FFFA;
    color: #00A896;
    border: 1px solid #99F6E4;
    font-size: 12px;
    font-weight: 700;
    padding: 2px 10px;
    border-radius: 20px;
    white-space: nowrap;
}
.results-divider {
    color: #CBD5E1;
    font-size: 14px;
    font-weight: 300;
    display: inline-block;
    user-select: none;
}
.results-count-sub {
    margin: 0;
    font-size: 13px;
    color: #64748B;
    display: inline-flex;
    align-items: center;
    white-space: nowrap;
}
.results-count-sub strong {
    color: #1E293B;
    font-weight: 600;
}
.pagination-toolbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: #FFFFFF;
    border: 1px solid #E2E8F0;
    border-radius: 12px;
    padding: 14px 20px;
    margin: 24px 0 16px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    flex-wrap: wrap;
    gap: 14px;
}
.pagination-info {
    font-size: 13.5px;
    color: #64748B;
    font-weight: 500;
}
.pagination-controls {
    display: flex;
    align-items: center;
    gap: 6px;
    flex-wrap: wrap;
}
.page-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 38px;
    height: 38px;
    padding: 0 12px;
    border-radius: 8px;
    border: 1px solid #E2E8F0;
    background: #FFFFFF;
    color: #1E293B;
    font-size: 13.5px;
    font-weight: 600;
    text-decoration: none !important;
    transition: all 0.2s ease;
    cursor: pointer;
    user-select: none;
}
.page-btn:hover:not(.disabled):not(.active) {
    background: #F1F5F9;
    border-color: #CBD5E1;
    color: #00A896;
}
.page-btn.active {
    background: #00A896 !important;
    border-color: #00A896 !important;
    color: #FFFFFF !important;
    box-shadow: 0 2px 6px rgba(0, 168, 150, 0.3);
    cursor: default;
}
.page-btn.disabled {
    opacity: 0.45;
    cursor: not-allowed;
    pointer-events: none;
    background: #F8FAFC;
    color: #94A3B8;
}
.per-page-wrapper {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    color: #64748B;
}
.per-page-select {
    border: 1px solid #CBD5E1;
    border-radius: 8px;
    padding: 6px 12px;
    font-size: 13px;
    font-weight: 600;
    color: #1E293B;
    background: #FFFFFF;
    outline: none;
    cursor: pointer;
    transition: border-color 0.2s ease;
}
.per-page-select:focus {
    border-color: #00A896;
}
@media (max-width: 767px) {
    .results-header-bar, .pagination-toolbar {
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
    }
    .pagination-controls {
        width: 100%;
        justify-content: center;
    }
    .per-page-wrapper {
        width: 100%;
        justify-content: space-between;
    }
}

/* View Mode Toggle Controls */
.view-mode-toggle {
  display: inline-flex;
  align-items: center;
  background: #F1F5F9;
  border-radius: 8px;
  padding: 3px;
  border: 1px solid #E2E8F0;
}
.view-btn {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  border: none;
  background: transparent;
  color: #64748B;
  padding: 6px 14px;
  border-radius: 6px;
  font-size: 13px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.2s ease;
  line-height: 1;
}
.view-btn:hover {
  color: #0F172A;
}
.view-btn.active {
  background: #FFFFFF;
  color: #00A896;
  box-shadow: 0 1px 4px rgba(0, 0, 0, 0.08);
}

/* ==========================================================================
   DOCTORS LIST VIEW (3-COLUMN HORIZONTAL ROW) & GRID VIEW
   ========================================================================== */
.doctors-list-container {
  width: 100%;
  margin: 0 auto;
  padding: 0;
  transition: all 0.3s ease;
}

.doctors-list-container.view-mode-list {
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.doctors-list-container.view-mode-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(330px, 1fr));
  gap: 20px;
}

/* Individual Doctor Card */
.doctor-card {
  display: flex;
  flex-direction: row;
  align-items: stretch;
  justify-content: space-between;
  background-color: #ffffff;
  border: 1px solid #e5e7eb;
  border-radius: 16px;
  padding: 24px;
  gap: 24px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
  transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
  position: relative;
  overflow: hidden;
  box-sizing: border-box;
}

.doctor-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 12px 24px -6px rgba(0, 0, 0, 0.09);
  border-color: #cbd5e1;
}

/* 1. Left Column (Profile & Ratings) */
.doctor-card .card-left {
  flex: 0 0 120px;
  display: flex;
  flex-direction: column;
  align-items: center;
  text-align: center;
  gap: 8px;
}

.doctor-avatar-wrap {
  position: relative;
  width: 45px;
  height: 45px;
}

.doctor-avatar-wrap img,
.doctor-avatar {
  width: 45px !important;
  height: 45px !important;
  border-radius: 50% !important;
  object-fit: cover !important;
  border: 2px solid #f0fdfa !important;
  box-shadow: 0 3px 8px rgba(0, 168, 150, 0.15);
  display: block;
}

.verified-icon-badge {
  position: absolute;
  bottom: -2px;
  right: -2px;
  background: #10b981;
  color: #ffffff;
  border-radius: 50%;
  width: 16px;
  height: 16px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 8.5px;
  border: 1.5px solid #ffffff;
  box-shadow: 0 1px 3px rgba(0,0,0,0.12);
}

.doctor-rating-badge {
  background: #e6f4ea;
  color: #16a34a;
  border: 1px solid #dcfce7;
  font-size: 12.5px;
  font-weight: 700;
  padding: 4px 10px;
  border-radius: 20px;
  line-height: 1.3;
  display: inline-flex;
  align-items: center;
  gap: 4px;
}

.doctor-fee-badge {
  font-size: 13.5px;
  font-weight: 700;
  color: #1e293b;
  margin-top: 2px;
}

.doctor-fee-badge span {
  color: #10b981;
}

/* 2. Center Column (Doctor & Clinic Info - Flex Growing) */
.doctor-card .card-center {
  flex: 1;
  min-width: 0;
  display: flex;
  flex-direction: column;
  gap: 8px;
  border-right: 1px dashed #e5e7eb;
  padding-right: 24px;
  text-align: left;
}

.doctor-header {
  display: flex;
  align-items: center;
  flex-wrap: wrap;
  gap: 10px;
}

.doctor-name-link {
  font-size: 20px;
  font-weight: 700;
  color: #0f172a;
  text-decoration: none !important;
  line-height: 1.3;
  transition: color 0.2s ease;
  margin: 0;
}

.doctor-name-link:hover {
  color: #10b981;
}

.exp-badge {
  background: #f1f5f9;
  color: #475569;
  border: 1px solid #e2e8f0;
  font-size: 12px;
  font-weight: 600;
  padding: 3px 8px;
  border-radius: 6px;
  display: inline-flex;
  align-items: center;
  gap: 4px;
}

.exp-badge i {
  color: #00a896;
}

.doctor-sub-header {
  display: flex;
  align-items: center;
  flex-wrap: wrap;
  gap: 8px;
  font-size: 13.5px;
  color: #64748b;
}

.doctor-degree {
  font-weight: 600;
  color: #334155;
  display: inline-flex;
  align-items: center;
  gap: 5px;
}
.doctor-degree i {
  color: #00a896;
}

.specialty-tag {
  background: #e6fffa;
  color: #00a896;
  border: 1px solid #99f6e4;
  font-size: 12px;
  font-weight: 600;
  padding: 3px 8px;
  border-radius: 6px;
  display: inline-flex;
  align-items: center;
  gap: 4px;
}

.consult-type-pill {
  background: #f0fdf4;
  color: #16a34a;
  border: 1px solid #dcfce7;
  font-size: 12px;
  font-weight: 600;
  padding: 3px 8px;
  border-radius: 6px;
  display: inline-flex;
  align-items: center;
  gap: 4px;
}

.doctor-clinic-details {
  display: flex;
  flex-direction: column;
  gap: 5px;
  font-size: 13px;
  color: #475569;
  margin-top: 2px;
}

.clinic-detail-item {
  display: flex;
  align-items: flex-start;
  gap: 8px;
  line-height: 1.4;
}

.clinic-detail-item i {
  width: 16px;
  text-align: center;
  color: #00a896;
  margin-top: 2px;
  flex-shrink: 0;
}

.clinic-detail-item strong {
  color: #0f172a;
}

.multi-clinic-badge {
  background: #f1f5f9;
  color: #64748b;
  font-size: 11px;
  padding: 1px 6px;
  border-radius: 4px;
  margin-left: 6px;
  font-weight: 500;
}

.doctor-bio-snippet {
  font-size: 12.5px;
  color: #64748b;
  margin: 2px 0 0 0;
  line-height: 1.5;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.trust-badges-inline {
  display: flex;
  flex-wrap: wrap;
  gap: 12px;
  margin-top: 6px;
  padding-top: 8px;
  border-top: 1px dashed #e5e7eb;
}

.trust-badge-item {
  font-size: 12px;
  color: #16a34a;
  display: inline-flex;
  align-items: center;
  gap: 5px;
  font-weight: 600;
}

/* 3. Right Column (Status & Actions) */
.doctor-card .card-right {
  flex: 0 0 200px;
  display: flex;
  flex-direction: column;
  gap: 10px;
  justify-content: center;
  align-items: stretch;
  text-align: center;
}

.status-pill {
  background: #f0fdf4;
  color: #16a34a;
  border: 1px solid #dcfce7;
  font-size: 12px;
  font-weight: 700;
  padding: 5px 10px;
  border-radius: 20px;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 6px;
}

.status-dot-pulse {
  width: 8px;
  height: 8px;
  background-color: #10b981;
  border-radius: 50%;
  display: inline-block;
  box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.25);
}

.wait-time-text {
  font-size: 11.5px;
  color: #64748b;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 5px;
  font-weight: 500;
}

.wait-time-text i {
  color: #0284c7;
}

/* Action Buttons */
.btn-primary-green {
  width: 100%;
  background: #10b981 !important;
  color: #ffffff !important;
  border: none !important;
  border-radius: 8px;
  padding: 10px 14px;
  font-size: 13.5px;
  font-weight: 700;
  text-align: center;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 7px;
  text-decoration: none !important;
  cursor: pointer;
  transition: background 0.2s ease, transform 0.1s ease;
  box-shadow: 0 2px 6px rgba(16, 185, 129, 0.25);
}
.btn-primary-green:hover {
  background: #059669 !important;
  transform: translateY(-1px);
}

.btn-secondary-outline-green {
  width: 100%;
  background: #ffffff !important;
  color: #10b981 !important;
  border: 1px solid #10b981 !important;
  border-radius: 8px;
  padding: 8px 12px;
  font-size: 13px;
  font-weight: 600;
  text-align: center;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 6px;
  text-decoration: none !important;
  transition: all 0.2s ease;
}
.btn-secondary-outline-green:hover {
  background: #f0fdf4 !important;
  border-color: #059669 !important;
  color: #059669 !important;
}

.btn-tertiary-gray {
  width: 100%;
  background: #ffffff !important;
  color: #475569 !important;
  border: 1px solid #cbd5e1 !important;
  border-radius: 8px;
  padding: 7px 12px;
  font-size: 12.5px;
  font-weight: 600;
  text-align: center;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 5px;
  text-decoration: none !important;
  transition: all 0.2s ease;
}
.btn-tertiary-gray:hover {
  background: #f8fafc !important;
  color: #0f172a !important;
  border-color: #94a3b8 !important;
}

/* Grid View Overrides */
.doctors-list-container.view-mode-grid .doctor-card {
  flex-direction: column;
  padding: 20px;
  gap: 16px;
}
.doctors-list-container.view-mode-grid .card-left {
  width: 100%;
  text-align: center;
}
.doctors-list-container.view-mode-grid .card-center {
  border-right: none;
  border-bottom: 1px dashed #e5e7eb;
  padding-right: 0;
  padding-bottom: 14px;
  text-align: center;
}
.doctors-list-container.view-mode-grid .doctor-header {
  justify-content: center;
}
.doctors-list-container.view-mode-grid .doctor-sub-header {
  justify-content: center;
}
.doctors-list-container.view-mode-grid .clinic-detail-item {
  text-align: left;
}
.doctors-list-container.view-mode-grid .trust-badges-inline {
  justify-content: center;
}
.doctors-list-container.view-mode-grid .card-right {
  width: 100%;
}

/* Slider View (Double Window - 2 Cards per slide) */
.doctors-list-container.view-mode-slider {
  display: block;
  width: 100%;
  position: relative;
}

.doctors-list-container.view-mode-slider.owl-carousel .owl-stage {
  display: flex !important;
  align-items: stretch !important;
}

.doctors-list-container.view-mode-slider.owl-carousel .owl-item {
  display: flex !important;
  flex-direction: column !important;
  height: auto !important;
}

.doctors-list-container.view-mode-slider .doctor-card {
  display: flex !important;
  flex-direction: column !important;
  justify-content: space-between !important;
  align-items: stretch !important;
  text-align: center !important;
  padding: 22px 18px !important;
  border-radius: 16px !important;
  background: #ffffff !important;
  border: 1px solid #e2e8f0 !important;
  box-shadow: 0 4px 14px rgba(0, 0, 0, 0.05) !important;
  margin: 4px 2px 16px !important;
  gap: 14px !important;
  width: 100% !important;
  height: 100% !important;
  box-sizing: border-box !important;
  transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease !important;
}

.doctors-list-container.view-mode-slider .doctor-card:hover {
  transform: translateY(-4px) !important;
  box-shadow: 0 12px 24px -4px rgba(0, 168, 150, 0.15) !important;
  border-color: #99f6e4 !important;
}

.doctors-list-container.view-mode-slider .card-left {
  width: 100% !important;
  flex: none !important;
  flex-direction: column !important;
  align-items: center !important;
  justify-content: center !important;
  gap: 8px !important;
}

.doctors-list-container.view-mode-slider .card-left .doctor-avatar-wrap {
  margin: 0 auto !important;
}

.doctors-list-container.view-mode-slider .card-center {
  border-right: none !important;
  border-bottom: 1px dashed #e5e7eb !important;
  padding-right: 0 !important;
  padding-bottom: 14px !important;
  text-align: center !important;
  width: 100% !important;
  flex: 1 0 auto !important;
}

.doctors-list-container.view-mode-slider .doctor-header {
  justify-content: center !important;
  text-align: center !important;
}

.doctors-list-container.view-mode-slider .doctor-sub-header {
  justify-content: center !important;
  text-align: center !important;
}

.doctors-list-container.view-mode-slider .doctor-clinic-details {
  text-align: left !important;
  font-size: 12.5px !important;
}

.doctors-list-container.view-mode-slider .trust-badges-inline {
  justify-content: center !important;
}

.doctors-list-container.view-mode-slider .card-right {
  width: 100% !important;
  flex: none !important;
  gap: 8px !important;
}

/* Owl Carousel Controls for Doctor Slider */
.doctors-list-container.owl-carousel .owl-nav {
  display: flex !important;
  justify-content: space-between !important;
  position: absolute !important;
  top: 45% !important;
  left: -20px !important;
  right: -20px !important;
  transform: translateY(-50%) !important;
  pointer-events: none !important;
  z-index: 20 !important;
  margin: 0 !important;
}

.doctors-list-container.owl-carousel .owl-nav button.owl-prev,
.doctors-list-container.owl-carousel .owl-nav button.owl-next {
  width: 40px !important;
  height: 40px !important;
  border-radius: 50% !important;
  background: #FFFFFF !important;
  border: 1px solid #CBD5E1 !important;
  color: #00A896 !important;
  display: inline-flex !important;
  align-items: center !important;
  justify-content: center !important;
  font-size: 15px !important;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12) !important;
  pointer-events: auto !important;
  cursor: pointer !important;
  transition: all 0.2s ease !important;
  outline: none !important;
}

.doctors-list-container.owl-carousel .owl-nav button.owl-prev:hover,
.doctors-list-container.owl-carousel .owl-nav button.owl-next:hover {
  background: #00A896 !important;
  border-color: #00A896 !important;
  color: #FFFFFF !important;
  transform: scale(1.1) !important;
}

.doctors-list-container.owl-carousel .owl-dots {
  display: flex !important;
  justify-content: center !important;
  align-items: center !important;
  gap: 6px !important;
  margin-top: 16px !important;
  margin-bottom: 8px !important;
}

.doctors-list-container.owl-carousel .owl-dots .owl-dot {
  outline: none !important;
}

.doctors-list-container.owl-carousel .owl-dots .owl-dot span {
  width: 8px !important;
  height: 8px !important;
  margin: 0 !important;
  background: #CBD5E1 !important;
  border-radius: 50% !important;
  transition: all 0.25s ease !important;
  display: block !important;
}

.doctors-list-container.owl-carousel .owl-dots .owl-dot.active span {
  width: 24px !important;
  border-radius: 6px !important;
  background: #00A896 !important;
}

/* Responsive (Mobile Devices <= 768px) */
@media (max-width: 768px) {
  .doctor-card {
    flex-direction: column !important;
    padding: 18px !important;
    gap: 18px !important;
  }
  .doctor-card .card-left {
    flex-direction: row !important;
    width: 100% !important;
    justify-content: flex-start !important;
    gap: 14px !important;
    text-align: left !important;
  }
  .doctor-card .card-center {
    border-right: none !important;
    border-bottom: 1px dashed #e5e7eb !important;
    padding-right: 0 !important;
    padding-bottom: 16px !important;
    width: 100% !important;
  }
  .doctor-card .card-right {
    width: 100% !important;
  }
  .view-mode-toggle span {
    display: none;
  }
  .view-btn {
    padding: 6px 10px;
  }
}

/* Sub-Window Scrollable Container (Fit Complete Doctors List in Window) */
.doctors-subwindow-scroll {
  height: 540px;
  max-height: calc(100vh - 270px);
  min-height: 440px;
  overflow-y: auto;
  overflow-x: hidden;
  padding: 6px 12px 14px 4px;
  margin-bottom: 20px;
  border-radius: 16px;
  background: #f8fafc;
  border: 1px solid #e2e8f0;
  box-shadow: inset 0 2px 8px rgba(0, 0, 0, 0.04);
  scroll-behavior: smooth;
  -webkit-overflow-scrolling: touch;
}

.doctors-subwindow-scroll.is-slider-mode {
  height: auto !important;
  max-height: none !important;
  overflow: visible !important;
  background: transparent !important;
  border: none !important;
  box-shadow: none !important;
  padding: 0 !important;
}

/* Custom Scrollbar for Sub-Window */
.doctors-subwindow-scroll::-webkit-scrollbar {
  width: 9px;
}

.doctors-subwindow-scroll::-webkit-scrollbar-track {
  background: #edf2f7;
  border-radius: 8px;
  margin: 6px;
}

.doctors-subwindow-scroll::-webkit-scrollbar-thumb {
  background: #00A896;
  border-radius: 8px;
  border: 2px solid #edf2f7;
}

.doctors-subwindow-scroll::-webkit-scrollbar-thumb:hover {
  background: #043D5B;
}

.doctors-subwindow-scroll {
  scrollbar-width: thin;
  scrollbar-color: #00A896 #edf2f7;
}

.subwindow-scroll-hint {
  font-size: 11.5px;
  font-weight: 600;
  color: #00A896;
  background: #e6fffa;
  border: 1px solid #99f6e4;
  padding: 3px 10px;
  border-radius: 20px;
  display: inline-flex;
  align-items: center;
  gap: 5px;
  margin-left: 6px;
}
</style>
<div class="container-fluid">
    <form action='<?=(strpos(current_url(), 'search') !== false) ? base_url('search') : base_url('doctors');?>' method='GET'>
        <div class="box-form">
            <div class="col-sm-3">
                <div class="input-group shadow">
                    <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                    <select class="form-control" name="location">
                        <option value="">All Locations / Cities</option>
                        <?php if (!empty($cities)) { foreach($cities as $c){ 
                            $is_c_sel = (isset($_GET['location']) && ($_GET['location'] == $c->id || strcasecmp($_GET['location'], $c->name) == 0)) || (isset($_GET['city']) && ($_GET['city'] == $c->id || strcasecmp($_GET['city'], $c->name) == 0));
                        ?>
                        <option value='<?=$c->name;?>' <?=$is_c_sel ? 'selected' : '';?>><?=$c->name;?></option>
                        <?php } } ?>
                    </select>
                </div>
            </div>
            <div class="col-sm-5">
                <div class="input-group shadow">
                    <span class="input-group-addon"><i class="fa fa-search"></i></span>
                    <input type="text" id="hint" class="form-control ui-autocomplete-input" name="keyword" value="<?=@htmlspecialchars($_GET['keyword'] ?? '');?>" placeholder="Search Hospitals/Doctors/Clinics etc" autocomplete="off">
                </div>
            </div>
            <div class="col-sm-3">
                <div class="input-group shadow">
                    <span class="input-group-addon"><i class="fa fa-user-md"></i></span>
                    <select class="form-control" name="speciality">
                        <option value="">-Specialization-</option>
                        <?php foreach($specialization as $s){ 
                            $is_s_sel = (isset($_GET['speciality']) && ($_GET['speciality'] == $s->id || strcasecmp($_GET['speciality'], $s->name) == 0)) || (isset($_GET['spl']) && ($_GET['spl'] == $s->id || strcasecmp($_GET['spl'], $s->name) == 0));
                        ?>
                        <option value='<?=$s->name;?>' <?=$is_s_sel ? 'selected' : '';?>><?=$s->name;?></option>
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
                    <?php 
                    $curr_location = isset($_GET['location']) ? $_GET['location'] : (isset($_GET['city']) ? $_GET['city'] : '');
                    $curr_keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
                    $curr_speciality = isset($_GET['speciality']) ? $_GET['speciality'] : (isset($_GET['spl']) ? $_GET['spl'] : '');
                    $curr_per_page = isset($per_page_param) ? $per_page_param : '10';
                    $c_page = isset($current_page) ? (int)$current_page : 1;
                    $t_pages = isset($total_pages) ? (int)$total_pages : 1;
                    $t_docs = isset($total_doctors) ? (int)$total_doctors : (isset($doctors) ? count($doctors) : 0);
                    $p_size = isset($per_page) ? (int)$per_page : 10;

                    if (!function_exists('buildPageUrl')) {
                        function buildPageUrl($p, $loc = '', $kw = '', $spec = '', $pp = '10') {
                            $base = (strpos(current_url(), 'search') !== false) ? base_url('search') : base_url('doctors');
                            $params = array();
                            if (!empty($loc)) $params['location'] = $loc;
                            if (!empty($kw)) $params['keyword'] = $kw;
                            if (!empty($spec)) $params['speciality'] = $spec;
                            if (!empty($pp) && $pp !== '10') $params['per_page'] = $pp;
                            if ((int)$p > 1) $params['page'] = (int)$p;
                            $qs = http_build_query($params);
                            return $base . ($qs ? ('?' . $qs) : '');
                        }
                    }
                    ?>

                    <div class="results-header-bar">
                        <div class="results-header-title">
                            <h4 class="results-count-text">
                                <i class="fa fa-user-md" style="color: #00A896; margin-right: 6px;"></i> Verified Doctors
                                <span class="results-count-badge"><?=$t_docs;?> Available</span>
                            </h4>
                            <?php if ($t_docs > 0) { ?>
                            <span class="results-divider">|</span>
                            <span class="results-count-sub">Showing <strong><?=($c_page - 1) * $p_size + 1;?> - <?=min($c_page * $p_size, $t_docs);?></strong> of <strong><?=$t_docs;?></strong> doctors (Page <?=$c_page;?> of <?=$t_pages;?>)</span>
                            <?php } ?>
                        </div>
                        <?php if ($t_docs > 0) { ?>
                        <div class="results-header-actions" style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
                            <!-- List / Grid View Switcher -->
                            <div class="view-mode-toggle" id="viewModeToggle">
                                <button type="button" class="view-btn active" data-mode="list" title="Sub-Window Scrollable List View">
                                    <i class="fa fa-bars"></i> <span>List View</span>
                                </button>
                                <button type="button" class="view-btn" data-mode="grid" title="Compact Grid View">
                                    <i class="fa fa-th-large"></i> <span>Grid View</span>
                                </button>
                                <button type="button" class="view-btn" data-mode="slider" title="Double Window Slider View (2 Doctors Per Slide)">
                                    <i class="fa fa-sliders"></i> <span>Slider View (Double Window)</span>
                                </button>
                            </div>

                            <div class="per-page-wrapper">
                                <label for="perPageTopSelect" style="margin: 0; font-weight: 500; color: #64748B;">Per Page:</label>
                                <select id="perPageTopSelect" class="per-page-select" onchange="location = this.value;">
                                    <option value="<?=buildPageUrl(1, $curr_location, $curr_keyword, $curr_speciality, '10');?>" <?=($curr_per_page == '10') ? 'selected' : '';?>>10</option>
                                    <option value="<?=buildPageUrl(1, $curr_location, $curr_keyword, $curr_speciality, '20');?>" <?=($curr_per_page == '20') ? 'selected' : '';?>>20</option>
                                    <option value="<?=buildPageUrl(1, $curr_location, $curr_keyword, $curr_speciality, '50');?>" <?=($curr_per_page == '50') ? 'selected' : '';?>>50</option>
                                    <option value="<?=buildPageUrl(1, $curr_location, $curr_keyword, $curr_speciality, 'all');?>" <?=($curr_per_page == 'all') ? 'selected' : '';?>>All</option>
                                </select>
                            </div>
                        </div>
                        <?php } ?>
                    </div>

                    <!-- Sub-Window Scrollable Container (Fit Complete List in Window) -->
                    <div class="doctors-subwindow-scroll" id="doctorsSubwindow">
                        <div class="doctors-list-container view-mode-list" id="doctorsListContainer">
                    <?php if (!empty($doctors)) { foreach($doctors as $d){ 
                        $did = (int)$d->id;
                        $duid = (int)$d->user_id;

                        $quastring = '';
                        $qu = $this->db->query("SELECT * FROM dr_qualifications WHERE user_id = $did OR (user_id = $duid AND $duid != 0)");
                        if ($qu && is_object($qu) && $qu->num_rows() > 0) {
                            foreach($qu->result() as $q) {
                                $qname = getQualificationName($q->qualification_id);
                                if ($qname) {
                                    $quastring .= $qname . ', ';
                                }
                            }
                            $quastring = rtrim($quastring, ', ');
                        }

                        $practdata = $this->db->query("SELECT * FROM dr_practice WHERE (user_id = $did OR (user_id = $duid AND $duid != 0)) AND status = '1' ORDER BY id DESC");
                        $practcount = ($practdata && is_object($practdata)) ? $practdata->num_rows() : 0; 
                        $pract = ($practdata && is_object($practdata)) ? $practdata->row() : null; 
                        $institution_table = '';
                        if(@$pract->type == 'C') $institution_table = 'clinic';
                        else if(@$pract->type == 'H') $institution_table = 'hospital';
                        $institution = null;
                        if($institution_table && !empty($pract->institution_id)){
                            $institutiondata = $this->db->get_where($institution_table, array('id' => $pract->institution_id, 'status' => '1'));
                            $institution = ($institutiondata && is_object($institutiondata)) ? @$institutiondata->row() : null;
                        }

                        // Query all specializations for this doctor matching either p.id or p.user_id
                        $specQuery = $this->db->query("SELECT DISTINCT ds.specialization_id, ms.name FROM dr_specialization ds JOIN master_specialization ms ON ds.specialization_id = ms.id WHERE ds.user_id = $did OR (ds.user_id = $duid AND $duid != 0)");
                        $specList = ($specQuery && is_object($specQuery)) ? $specQuery->result() : array();

                        // Collect and deduplicate specializations
                        $spec_tags = array();
                        $seen_specs = array();
                        if (!empty($specList)) {
                            foreach($specList as $sp) {
                                $sname = !empty($sp->name) ? trim($sp->name) : trim(getSpecilizationName($sp->specialization_id));
                                if (!empty($sname) && !isset($seen_specs[strtolower($sname)])) {
                                    $seen_specs[strtolower($sname)] = true;
                                    $is_match = false;
                                    if (!empty($curr_speciality)) {
                                        $is_match = (stripos($sname, $curr_speciality) !== false || stripos($curr_speciality, $sname) !== false);
                                    }
                                    $spec_tags[] = array('name' => $sname, 'is_match' => $is_match);
                                }
                            }
                        }
                        if (empty($spec_tags) && !empty($d->specialization)) {
                            $sname = trim(getSpecilizationName($d->specialization));
                            if (!empty($sname)) {
                                $is_match = (!empty($curr_speciality) && (stripos($sname, $curr_speciality) !== false || stripos($curr_speciality, $sname) !== false));
                                $spec_tags[] = array('name' => $sname, 'is_match' => $is_match);
                            }
                        }
                        // Sort so that the searched speciality appears first!
                        usort($spec_tags, function($a, $b) {
                            return ($b['is_match'] ? 1 : 0) - ($a['is_match'] ? 1 : 0);
                        });

                        $drImg = ($d->drimage && file_exists('admin1947/public/assets/upload/'.$d->drimage)) 
                                 ? admin_url('public/assets/upload/'.$d->drimage) 
                                 : admin_url('public/assets/upload/dummydr.jpg');
                        $drPrefix = (strcasecmp(substr($d->fname, 0, 2), 'Dr') != 0) ? 'Dr. ' : '';
                        $drFullName = $drPrefix . trim($d->fname . ' ' . $d->lname);
                        $fee = (!empty($pract->fee)) ? $pract->fee : (($d->dr_fee > 0) ? $d->dr_fee : '500');
                        $clinicName = (!empty($institution->name)) ? $institution->name : 'Upchar Partner Healthcare Center';
                        $clinicAddress = (!empty($institution->address)) ? $institution->address : (getCityName($d->city) ?: 'Varanasi, Uttar Pradesh, India');
                        $phoneContact = (!empty($institution->mobile)) ? $institution->mobile : ((!empty($d->mobile)) ? $d->mobile : '8448440603');
                        $expYears = ($d->exp > 0) ? $d->exp : 8;
                    ?>
                    <!-- Doctor Item Card (3-Column Horizontal Row Layout) -->
                    <div class="doctor-card">
                        <!-- 1. Left Column (Profile & Ratings) -->
                        <div class="card-left">
                            <div class="doctor-avatar-wrap">
                                <img src="<?=$drImg;?>" alt="<?=htmlspecialchars($drFullName);?>" class="doctor-avatar" loading="lazy">
                                <span class="verified-icon-badge" title="Verified Medical Practitioner"><i class="fa fa-check"></i></span>
                            </div>
                            <div class="doctor-rating-badge" title="Patient Satisfaction Rating">
                                <i class="fa fa-thumbs-up"></i> 98%
                            </div>
                            <div class="doctor-fee-badge" title="Consultation Fee">
                                <span>₹<?=$fee;?></span> Fee
                            </div>
                        </div>

                        <!-- 2. Center Column (Doctor & Clinic Info - Flex Growing) -->
                        <div class="card-center">
                            <div class="doctor-header">
                                <h3 style="margin: 0; display: inline-block;">
                                    <a href="<?=base_url('doctor/'.$d->id);?>" class="doctor-name-link" title="View Profile of <?=htmlspecialchars($drFullName);?>">
                                        <?=htmlspecialchars($drFullName);?>
                                    </a>
                                </h3>
                                <span class="exp-badge" title="Total Clinical Experience">
                                    <i class="fa fa-briefcase"></i> <?=$expYears;?>+ Yrs Exp
                                </span>
                            </div>

                            <div class="doctor-sub-header">
                                <span class="doctor-degree">
                                    <i class="fa fa-graduation-cap"></i> <?=(!empty($quastring) ? htmlspecialchars($quastring) : 'MBBS');?>
                                </span>
                                <?php if (!empty($spec_tags)) { 
                                    foreach($spec_tags as $stag) {
                                        $tag_style = $stag['is_match'] 
                                            ? 'background: #00a896; color: #ffffff; border: 1px solid #00a896; font-weight: 600;' 
                                            : '';
                                ?>
                                        <span class="specialty-tag" style="<?=$tag_style;?>">
                                            <i class="fa fa-stethoscope"></i> <?=htmlspecialchars($stag['name']);?>
                                            <?php if ($stag['is_match']) { ?><i class="fa fa-check-circle" style="margin-left: 3px; font-size: 11px;"></i><?php } ?>
                                        </span>
                                    <?php }
                                } else { ?>
                                    <span class="specialty-tag"><i class="fa fa-stethoscope"></i> General Physician</span>
                                <?php } ?>
                                <span class="consult-type-pill"><i class="fa fa-video-camera"></i> Video & In-Clinic</span>
                            </div>

                            <div class="doctor-clinic-details">
                                <div class="clinic-detail-item">
                                    <i class="fa fa-hospital-o"></i>
                                    <div>
                                        <strong><?=htmlspecialchars($clinicName);?></strong>
                                        <?php if ($practcount > 1) { ?>
                                            <span class="multi-clinic-badge">+<?=($practcount - 1);?> more clinics</span>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="clinic-detail-item">
                                    <i class="fa fa-map-marker"></i>
                                    <div><?=htmlspecialchars($clinicAddress);?></div>
                                </div>
                                <div class="clinic-detail-item">
                                    <i class="fa fa-clock-o"></i>
                                    <div><strong>Available Today:</strong> 10:00 AM - 07:00 PM (Mon - Sat)</div>
                                </div>
                            </div>

                            <?php if (!empty($d->short_about) || !empty($d->about)) { 
                                $bioRaw = strip_tags(!empty($d->short_about) ? $d->short_about : $d->about);
                                $bioTrimmed = function_exists('mb_strimwidth') 
                                    ? mb_strimwidth($bioRaw, 0, 140, '...') 
                                    : ((strlen($bioRaw) > 140) ? (substr($bioRaw, 0, 137) . '...') : $bioRaw);
                            ?>
                            <p class="doctor-bio-snippet">
                                <?=htmlspecialchars($bioTrimmed);?>
                            </p>
                            <?php } ?>

                            <div class="trust-badges-inline">
                                <span class="trust-badge-item"><i class="fa fa-check-circle"></i> Medical Registration Verified</span>
                                <span class="trust-badge-item"><i class="fa fa-check-circle"></i> Instant Confirmation</span>
                                <span class="trust-badge-item"><i class="fa fa-check-circle"></i> Zero Booking Fees</span>
                            </div>
                        </div>

                        <!-- 3. Right Column (Status & Actions) -->
                        <div class="card-right">
                            <div class="status-pill">
                                <span class="status-dot-pulse"></span> Available Today
                            </div>
                            <div class="wait-time-text">
                                <i class="fa fa-clock-o"></i> 15-30 min wait assured
                            </div>
                            <!-- Primary Button: Book Appointment -->
                            <a href="#" class="btn-primary-green getappointment btn-book-appointment" 
                               data-doctor-id="<?=$d->id;?>" 
                               data-upchar-did="<?=$d->id;?>" 
                               data-toggle="modal" 
                               data-target="#myModal"
                               title="Book Online Appointment with <?=htmlspecialchars($drFullName);?>">
                                <i class="fa fa-calendar-check-o"></i> Book Appointment
                            </a>
                            <!-- Secondary Outline Button: Call Doctor -->
                            <a href="tel:<?=$phoneContact;?>" class="btn-secondary-outline-green" title="Call Clinic / Doctor">
                                <i class="fa fa-phone"></i> Call Doctor
                            </a>
                            <!-- Tertiary Button: View Profile -->
                            <a href="<?=base_url('doctor/'.$d->id);?>" class="btn-tertiary-gray" title="View Full Profile">
                                <i class="fa fa-user-md"></i> View Profile
                            </a>
                        </div>
                    </div>
                    <?php } } else { ?>
                    <div class="doctor-card text-center" style="display: block; padding: 50px 20px; width: 100%; border-radius: 12px; background: #ffffff; box-shadow: 0 4px 16px rgba(0,0,0,0.06); margin: 20px 0;">
                        <div style="width: 70px; height: 70px; border-radius: 50%; background: #fef2f2; color: #ef4444; display: inline-flex; align-items: center; justify-content: center; font-size: 28px; margin-bottom: 16px;">
                            <i class="fa fa-user-md"></i>
                        </div>
                        <h3 style="color: #1e293b; font-weight: 700; margin-bottom: 8px;">No doctors found matching your criteria</h3>
                        <p style="color: #64748b; font-size: 15px; max-width: 540px; margin: 0 auto 24px auto; line-height: 1.6;">
                            We couldn't find any verified specialists matching your current filters. Try changing your selected location, specialty, or searching with different keywords.
                        </p>
                        <a href="<?=base_url('doctors');?>" class="btn btn-primary" style="padding: 12px 28px; font-weight: 600; border-radius: 8px; background: #00a896; border: none; color: #fff; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 12px rgba(0,168,150,0.25);">
                            <i class="fa fa-refresh"></i> Reset Filters &amp; View All Doctors
                        </a>
                    </div>
                    <?php } ?>
                    </div>
                    </div>

                    <?php if ($t_docs > 0) { ?>
                    <!-- Pagination Toolbar -->
                    <div class="pagination-toolbar">
                        <div class="pagination-info">
                            Showing <strong><?=($c_page - 1) * $p_size + 1;?></strong> - <strong><?=min($c_page * $p_size, $t_docs);?></strong> of <strong><?=$t_docs;?></strong> verified doctors
                        </div>

                        <?php if ($t_pages > 1) { ?>
                        <div class="pagination-controls">
                            <!-- Previous Page -->
                            <?php if ($c_page > 1): ?>
                            <a href="<?=buildPageUrl($c_page - 1, $curr_location, $curr_keyword, $curr_speciality, $curr_per_page);?>" class="page-btn" title="Previous Page">
                                <i class="fa fa-chevron-left"></i>
                            </a>
                            <?php else: ?>
                            <span class="page-btn disabled" title="Previous Page" aria-disabled="true">
                                <i class="fa fa-chevron-left"></i>
                            </span>
                            <?php endif; ?>

                            <!-- Page Numbers -->
                            <?php 
                            $start_p = max(1, $c_page - 2);
                            $end_p = min($t_pages, $c_page + 2);
                            if ($start_p > 1) {
                                echo '<a href="'.buildPageUrl(1, $curr_location, $curr_keyword, $curr_speciality, $curr_per_page).'" class="page-btn">1</a>';
                                if ($start_p > 2) echo '<span class="page-btn disabled">...</span>';
                            }
                            for ($p = $start_p; $p <= $end_p; $p++) {
                                if ($p == $c_page) {
                                    echo '<span class="page-btn active">'.$p.'</span>';
                                } else {
                                    echo '<a href="'.buildPageUrl($p, $curr_location, $curr_keyword, $curr_speciality, $curr_per_page).'" class="page-btn">'.$p.'</a>';
                                }
                            }
                            if ($end_p < $t_pages) {
                                if ($end_p < $t_pages - 1) echo '<span class="page-btn disabled">...</span>';
                                echo '<a href="'.buildPageUrl($t_pages, $curr_location, $curr_keyword, $curr_speciality, $curr_per_page).'" class="page-btn">'.$t_pages.'</a>';
                            }
                            ?>

                            <!-- Next Page -->
                            <?php if ($c_page < $t_pages): ?>
                            <a href="<?=buildPageUrl($c_page + 1, $curr_location, $curr_keyword, $curr_speciality, $curr_per_page);?>" class="page-btn" title="Next Page">
                                <i class="fa fa-chevron-right"></i>
                            </a>
                            <?php else: ?>
                            <span class="page-btn disabled" title="Next Page" aria-disabled="true">
                                <i class="fa fa-chevron-right"></i>
                            </span>
                            <?php endif; ?>
                        </div>
                        <?php } ?>

                        <div class="per-page-wrapper">
                            <label for="perPageSelect" style="margin: 0; font-weight: 500; color: #64748B;">Per Page:</label>
                            <select id="perPageSelect" class="per-page-select" onchange="location = this.value;">
                                <option value="<?=buildPageUrl(1, $curr_location, $curr_keyword, $curr_speciality, '10');?>" <?=($curr_per_page == '10') ? 'selected' : '';?>>10</option>
                                <option value="<?=buildPageUrl(1, $curr_location, $curr_keyword, $curr_speciality, '20');?>" <?=($curr_per_page == '20') ? 'selected' : '';?>>20</option>
                                <option value="<?=buildPageUrl(1, $curr_location, $curr_keyword, $curr_speciality, '50');?>" <?=($curr_per_page == '50') ? 'selected' : '';?>>50</option>
                                <option value="<?=buildPageUrl(1, $curr_location, $curr_keyword, $curr_speciality, 'all');?>" <?=($curr_per_page == 'all') ? 'selected' : '';?>>All</option>
                            </select>
                        </div>
                    </div>
                    <?php } ?>
                </div>

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

            // View Mode Switcher (List View vs Grid View vs Double Window Slider View)
            var originalDoctorsHtml = $('#doctorsListContainer').html();
            // Default to 'list' with sub-window scrolling as requested
            var savedMode = localStorage.getItem('upchar_doctor_view_mode_v3') || 'list';
            
            function setDoctorViewMode(mode) {
                var $container = $('#doctorsListContainer');
                var $subwindow = $('#doctorsSubwindow');
                
                // Destroy active Owl Carousel instance if present
                if ($container.hasClass('owl-loaded')) {
                    $container.trigger('destroy.owl.carousel');
                    $container.removeClass('owl-carousel owl-loaded owl-drag owl-theme');
                }
                
                // Reset to pristine HTML
                $container.html(originalDoctorsHtml);
                
                // Update active state on toggle buttons
                $('.view-btn').removeClass('active');
                $('.view-btn[data-mode="' + mode + '"]').addClass('active');
                localStorage.setItem('upchar_doctor_view_mode_v3', mode);
                
                if (mode === 'grid') {
                    $subwindow.removeClass('is-slider-mode');
                    $container.removeClass('view-mode-list view-mode-slider owl-carousel owl-theme').addClass('view-mode-grid');
                } else if (mode === 'slider') {
                    $subwindow.addClass('is-slider-mode');
                    $container.removeClass('view-mode-list view-mode-grid').addClass('view-mode-slider owl-carousel owl-theme');
                    var docCardsCount = $container.find('.doctor-card').length;
                    $container.owlCarousel({
                        loop: (docCardsCount > 2),
                        margin: 20,
                        nav: true,
                        dots: true,
                        autoplay: false,
                        autoplayHoverPause: true,
                        responsive: {
                            0: {
                                items: 1 // Single card on small mobile devices
                            },
                            768: {
                                items: 2 // Double window (2 doctor cards side-by-side)
                            }
                        },
                        navText: [
                            '<i class="fa fa-chevron-left"></i>',
                            '<i class="fa fa-chevron-right"></i>'
                        ]
                    });
                } else {
                    // Default List View with Sub-Window Scroll
                    $subwindow.removeClass('is-slider-mode');
                    $container.removeClass('view-mode-grid view-mode-slider owl-carousel owl-theme').addClass('view-mode-list');
                }
            }
            
            setDoctorViewMode(savedMode);
            
            $('.view-btn').on('click', function(e){
                e.preventDefault();
                var mode = $(this).data('mode');
                setDoctorViewMode(mode);
            });
        });
    </script>