<head>
    <link rel="icon" href="<?=base_url();?>images/logo.png" type="image/gif" sizes="16x16">
    <style>
	.newsCont {
		background: white;
		padding: 25px;
		border-radius: 12px;
		margin-top: 25px;
		margin-bottom: 30px;
		box-shadow: 0px 2px 10px rgba(0,0,0,0.08);
	}
	.newsCard {
		background: #fdfdfd;
		border: 1px solid #e0e0e0;
		border-radius: 8px;
		padding: 15px;
		margin-bottom: 20px;
		transition: all 0.3s ease;
	}
	.newsCard:hover {
		box-shadow: 0px 4px 15px rgba(0,0,0,0.12);
		transform: translateY(-2px);
	}
	.newsImg {
		width: 100%;
		height: 180px;
		object-fit: cover;
		border-radius: 6px;
	}
	.newsTitle {
		font-size: 18px;
		font-weight: 600;
		color: #043d5b;
		margin-top: 10px;
		margin-bottom: 8px;
	}
	.newsDesc {
		font-size: 14px;
		color: #555;
		line-height: 1.5;
	}
	.readMoreBtn {
		background-color: #9bc03c;
		color: white !important;
		padding: 6px 16px;
		border-radius: 4px;
		font-size: 13px;
		display: inline-block;
		margin-top: 10px;
		text-decoration: none !important;
	}
	.readMoreBtn:hover {
		background-color: #88a834;
	}
	#searchBTN {
		width: 100%;
		box-shadow: 0px -4px 6px #00000091;
		padding: 12px;
		border: none;
		background-color: #043d5b;
		color: white;
		margin-top: 5px;
	}
    </style>
</head>
<?php include ("includes/header.php"); ?>
<div class="clearfix"></div>
<form action='<?=base_url();?>search' method='GET'>
    <div class="box-form">
		<div class="col-sm-2 col-sm-offset-1">
			<div class="input-group shadow">
				<span class="input-group-addon"> <i class="fa fa-map-marker"> &nbsp; &nbsp; </i></span>
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
		<div class="col-sm-2">
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

<div class="container">
	<div class="col-md-12 newsCont">  
		<h2 class="text-center" style="color: #043d5b; margin-bottom: 25px;"><b>Latest Healthcare News & Updates</b></h2>
		<div class="row">
			<?php if(!empty($news)){ 
				foreach($news as $item){ ?>
				<div class="col-md-4 col-sm-6">
					<div class="newsCard">
						<?php if($item->type == '1' || empty($item->video_url)){ ?>
							<img src="<?=admin_url();?>public/assets/upload/<?=($item->image)? $item->image : 'dummy.jpg';?>" class="newsImg" alt="<?=htmlspecialchars($item->title);?>">
						<?php } else { ?>
							<iframe width="100%" height="180" src="<?=$item->video_url;?>" frameborder="0" allowfullscreen style="border-radius:6px;"></iframe>
						<?php } ?>
						<h4 class="newsTitle"><?=htmlspecialchars(substr($item->title, 0, 50));?><?=strlen($item->title) > 50 ? '...' : '';?></h4>
						<p class="newsDesc"><?=htmlspecialchars(substr(strip_tags($item->description), 0, 100));?>...</p>
						<a href="<?=base_url();?>news/<?=mybase64_encode($item->id);?>" class="readMoreBtn">Read More <i class="fa fa-arrow-right"></i></a>
					</div>
				</div>
			<?php } } else { ?>
				<div class="col-md-12 text-center">
					<p>No news articles found at this time.</p>
				</div>
			<?php } ?>
		</div>
	</div>
</div>

<!-- Footer Code-->
<?php include ('includes/footer.php'); ?>
<div class="clearfix"></div>
