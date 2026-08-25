<head>
    <link rel="icon" href="images/logo.png" type="image/gif" sizes="16x16">

    <style>
    .bg-back:hover{
    background: #1c3a4a;
}
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

.Links {
    background: #9bc03c;
    color: white;
    font-weight: bold;
    padding: 4px 18px;
    border-radius: 23px;
}
.rightsmallicons {
    color: white;
    border-radius: 23px;
    font-size: 18px !important;
    margin-right: 9px;
}
.doc-info-details li:first-child {
    border-radius: 12px 0px 0px 0px;
}
.BackHeight{
    height:465px;
    overflow-y:scroll;
}
.sliderImg {
    width: 86%;
    box-shadow: 0px -3px 7px #9c9898;
    height: 253px;
    border-radius: 173px;
}
.BtnAds {
    background: white;
    color: #9bc03c;
    border-radius: 23px;
    font-size: 29px !important;
    position: relative;
    margin: 10px 0px;
}
.advrtzmnt {
    background: #ffffff;
    margin-top: 24px;
    border-radius: 8px;
    padding: 20px 12px;
}
.doc-info-details li:last-child {
    border-radius: 0px 0px 12px 0px;
}
.doc-info{
    padding:9px;
}
.doc-info-details{margin-top:12px;}
.doc-info-details li {
    background: #9bc03c;
    text-align: center;
    color: white;
    margin-bottom: 1px;
    text-transform: capitalize;
 
}
.doc-info-details li a{
    color:white;
}
    .doc-info-details li:hover{
        font-size: 15px;
        transition: 0.3s;

    }
.hospitaltagname {
   
    color: #9bc03c;
    border-radius: 53px;
    text-transform: capitalize;
    font-size: 14px;
    font-family: verdana;
    font-weight: bold;
}  

.hospitaltagname2 {
    border-radius: 23px;
    margin: 6px;
   
    color: #9bc03c;
    font-weight: bold;
}
.label-tag {
    padding: 5px 16px !important;
    border-radius: 61px !important;
    margin: 0px !important;
    line-height: 32px !important;
    transition: 0.6s !important;
    cursor: pointer;
    border: 1px solid #295771;
    color: #295771 !important;
    font-size: 10px !important;
}

.label-tag:hover {
    background: #295771 !important;
    color: white !important;
}

.secondmenuicon{
    font-size:31px;
    color:white;
    display:none !important;
    
}

.hospitalbox{
            background:white;
            margin:3px;
        }
.imghospital {
    width: 100%;
    box-shadow: 0px -3px 7px #9c9898;
    height: 253px;
}

#searchBTN {
    width: 100%;
    margin-top: 0px;
    box-shadow: 0px -4px 6px #244c63;
    padding: 12px;
    border: none;
    background-color: #9bc03c;
    color: white;
    margin-top: 11px;
}
.label-default {
    background-color: #295771;
    padding: 8px 8px;
}
.bg-back {
    background: #8daf35;
    color: white;
    border-radius: 20px !important;
    transition: 0.3s;
    font-weight: bold !important;
    width: 156px !important;
    float: right;
}

@media screen and (max-width: 786px) {
#sidebartab{position:absolute;z-index:432;margin:5px 0px; width: 263px;}
.careplus-main-content {
    padding: 0px 0px 60px 0px;
}
.mobilesearchicons{
    width:46px;
}

#sidebartab{position:absolute;z-index:432;margin:5px 0px; width: 263px;transition:0.3s;display:none;}


#searchBTN {
    width: 100%;
    margin-top: 0px;
    box-shadow: 0px -4px 6px #244c63;
    padding: 12px;
    border: none;
    background-color: #043d5b;
    color: white;
    margin-top: 11px;
    margin-bottom: 0px;
}
.menutab {
    background: #ffffff;
    margin-bottom: 3px;
}
.nav > li > a {
    color: black !important;
}
.nav > li > a:hover, .nav > li > a:focus {
    text-decoration: none;
    background-color: #295771;
    border-radius:0px 0px;
    color: white !important;
}

.secondmenuicon {
    font-size: 31px !important;
    color: white ;
    display: block !important;
    width: 41px;
    padding: 6px ;
    margin: 7px;
    cursor: pointer;
    background: #22495f !important;
}

.mobileimage{
    text-align: center;
}

}

    </style>
</head>

<?php include("sidebar.php");?>
        <!--// Header \\-->
       <?php include ('includes/header_new.php'); ?>
        <!--// Header \\-->

  
<form action='<?=base_url();?>search' method='GET'>
                <div class="box-form">
                      
      
                    <div class="col-sm-3">
                        <div class="input-group shadow">
                            <span class="input-group-addon"><i class="fa fa-map-marker" aria-hidden="true"></i></span>
                            <input type="text" class="form-control ui-autocomplete-input" name="location" placeholder="Location" id="hintcity" autocomplete="off">
                            <input type="hidden" class="form-control" name="city" id="city">
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <div class="input-group shadow">
                            <span class="input-group-addon"><i class="fa fa-search"></i></span>
                            <input type="text" id="hint" class="form-control ui-autocomplete-input" name="keyword" placeholder="Search Hospitals/Doctors/Clinics etc" autocomplete="off">
                        </div>
                        
                    </div>
                    <div class="col-sm-3">
                        <div class="input-group shadow">
                            <span class="input-group-addon"><i class="fa fa-user-md"></i></span>
                            <select class="form-control" name="spl">
              <option value="">-Specialization-</option>
                                              <?php foreach($specialization as $s){ ?>
                                <option value='<?=$s->id;?>'><?=$s->name;?></option>
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
       
		<!--// Main Banner \\-->



<div class="container">


  <div class="row">
  <div class="col-xs-3 text-center advrtzmnt">

  <div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Wrapper for slides -->
    <div class="carousel-inner">

      <div class="item active">
        <div class="col-md-12 text-center">
        <img class="sliderImg" src="<?=admin_url();?>public/assets/upload/<?=($institution->drimage)? $institution->drimage : 'dummyhospital.jpg';?>" width="200" align="center">
        </div>
         <div class="col-md-12 text-center">
            <span class="hospitaltagname"><i class="fa fa-hospital-o" aria-hidden="true"></i> <?=$institution->name;?></span>                                        
		 <p class="hospitaltagname2">Welcome to Invoation Of Upchar</p>
         </div>
         
         
        <div class="col-md-12 text-center">
           <a href="<?=base_url();?>hospital/<?=$institution->id;?>" class="btn btn-block bg-back book-btn">SHOW DETAILS</a >
        </div>
      </div>
      <?php foreach($hospital as $institution){ ?>
            <div class="item">
        <div class="col-md-12 text-center">
        <img class="imghospital" src="<?=admin_url();?>public/assets/upload/<?=($institution->drimage)? $institution->drimage : 'dummyhospital.jpg';?>" width="200" align="center">
        </div>
        <div class="col-md-12 text-center">
         <span class="hospitaltagname"><i class="fa fa-hospital-o" aria-hidden="true"></i> <?=$institution->name;?></span>                                        
		 <p class="hospitaltagname2">1 Dentist, 1 Implantologist</p>
         </div>
         
        <div class="col-md-12 text-center">
           <a href="<?=base_url();?>hospital/<?=$institution->id;?>" class="btn btn-block bg-back book-btn">SHOW DETAILS</a >
        </div>
        
  
        
      </div>
      
   <?php } ?>
    
  
            <a href="#myCarousel" data-slide="prev">
      <i class="fa fa-arrow-circle-left BtnAds" aria-hidden="true"></i>
      
    </a>
    <a href="#myCarousel" data-slide="next">
      <i class="fa fa-arrow-circle-right BtnAds" aria-hidden="true"></i>
    </a>   
    
    </div>
  </div>
</div>

    <div class="col-sm-9 BackHeight">
             <?php foreach($hospital as $institution){ ?>
		<div class="col-xs-12 box_sh_bg hospitalbox">
		 
		 <div class="col-sm-3 text-center mobileimage">                                        
		 <img class="imghospital" src="<?=admin_url();?>public/assets/upload/<?=($institution->drimage)? $institution->drimage : 'dummyhospital.jpg';?>" width="200" align="center">
		 </div>

		 <div class="col-sm-9 doc-info">                                        
		 <span class="hospitaltagname"><i class="fa fa-hospital-o" aria-hidden="true"></i> <?=$institution->name;?></span>                                        
		 <!--//<p class="hospitaltagname2">1 Dentist, 1 Implantologist</p> <!--//<h6>1 Dentist, 1 Implantologist</h6>      Header \\--> 
		 
		 <a href="#" class="Links">Doctors</a>
		 <a href="#" class="Links">Hospital</a>		                                      
		 <a href="#" class="Links">pathology</a>
		 <a href="#" class="Links">others</a>		 
		 
		 	 <ul class="col-sm-12 doc-info-details">                                            
		 <li class="col-sm-4"><a href="#"><i class="fa fa-thumbs-o-up rightsmallicons"></i> 99% (1311 votes)</a></li>
		 
		 <li class="col-sm-4"><a href="#"><i class="fa fa-inr rightsmallicons" ></i> 500 Fee</a></li>
		 <li class="col-sm-4"><a href="#"><i class="fa fa-calendar-check-o rightsmallicons" ></i> MON-SAT  MON-SUN 24/7 call +091-8448440603</a></li>
		 <li class="col-sm-4"><a href="#"><i class="fa fa-clock-o rightsmallicons" ></i> 9:00 AM-8:05 PM</a></li>
		 <li class="col-sm-8"><a href="#"><i class="fa fa-commenting-o rightsmallicons"></i> 155 Feedback for 5 Doctors</a></li>
		 <li class="col-sm-12"><a href="#"><i class="fa fa-map-marker rightsmallicons"></i> <?=$institution->address;?></a></li>
		 </ul>
		 <div class="col-md-12">
		 	 <a href="<?=base_url();?>hospital/<?=$institution->id;?>" class="btn btn-block bg-back book-btn">SHOW DETAILS</a >
		 <!--	  <a class="btn btn-block bg-back" style="margin-top: 8px;" href="#">view</a>-->
		 </div>
		 
		 </div> 

		 </div>
	           <?php } ?> 
    </div>
   
  </div>
</div>
    
    

	<div class="container-fluid">
	    		<div class="col-xs-12">
         
	           
	</div>
</div>
        <!--// Footer \\-->
        <?php include ('includes/footer.php'); ?>
        
        
        
         
     <script> 
$(document).ready(function(){
  $(".secondmenuicon").click(function(){
    $("#sidebartab").slideToggle("slow");
  });
  
  
});


</script>
