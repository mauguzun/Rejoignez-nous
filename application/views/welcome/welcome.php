
<div class="col-md-12" style="margin-bottom: 130px;     margin-top: 25px;">
	<div class="row">
		<div class="col-md-7 col-lg-8">
			<div class="your-class">
				<?
				foreach($slides as $slide) :?>
				<div><img class="slide" src="<?= $slide['file']?>" alt=""></div>
				<? endforeach ;?>
			</div>
		</div>
		<div class="col-md-5 col-lg-4 menu">
			<div class="inner-menu">
				<h3 style="padding:21px; margin-left:10px;" class="offers_heading"><?= lang('our_offers')?></h3>
				<ul class="menu-candidate">
					<? foreach($offers as  $offer):?>
					
						<? if ($offer === reset($offers)):?>
						
						
						<li 
							onclick="location.replace('<?= base_url().'user/offer/'.$offer['id'] ?>')"
						 class="list-item-menu" style="background-color:white;
    /* border-color: #105497; */
    border: 1px solid #105497;"><span style="color:#105497;"><b><?= $offer['title']?></b></span><br><span style="color:#105497;"><b><?= $offer['type']?></b></span></li>
			
						<? else :?>
      
					
						<li 	onclick="location.replace('<?= base_url().'user/offer/'.$offer['id'] ?>')" class="list-item-menu">
						<span>
						<b><?= $offer['title']?></b>
						</span>
						<br>
						<span><b><?= $offer['type']?></b></span></li>
						
						<? endif;?>

				<? endforeach ;?>
					
					
					
						</ul>
			</div>
		</div>
	</div>
	
	
	<? if (isset($news) && is_array($news)):?>
	<div class="row">
		<div class="col-md-12">
			<div class="news_feed">
				<h4 class="news_title"><?= lang('news')?></h4>
				<div class="row">
					<? foreach($news as $new) : ?>
					<div class="col-md-4 col-sm-6 col-12 article">
						<div class="row">
							<div class="col-md-1 col-sm-0 col-0"></div>
							<div class="col-md-2 col-sm-2 col-2 ">
								<div class="news_date">
									<div class="news_month" style="text-transform: capitalize;"><?= date("M", strtotime($new['date']))  ?></div>
									<div class="month_year"><?= date("Y", strtotime($new['date']))  ?></div>
								</div>
							</div>
							<div class="col-md-9 col-sm-10 col-10">
								<div class="article_title">
									<a href="<?= base_url().'news/'.$new['id']?>"><?= $new['title']?></a>
								</div>
								<div class="article_snippet">
									 <?= $new['description']?>
								</div>
							</div>
						</div>
					</div>
					<? endforeach ;?>
					
				</div>
			</div>
		</div>
	</div>
	<? endif ;?>
</div>
</body>
