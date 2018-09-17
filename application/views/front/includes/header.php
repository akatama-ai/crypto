<nav class="top-bar">
	<div class="container-fluid">
		<div class="logo">
			<a href="<?php echo base_url();?>">
				<img src="<?php echo base_url()."assets/images/".($nightMode?$lightLogo:$darkLogo);?>" alt="Cryptolio">
			</a>
		</div><!-- .logo -->
		<a class="menuBtn trimUser user-button <?php echo isset($this->session->user)?'active':"";?>" <?php echo !isset($this->session->user)?'data-toggle="modal" data-target="#addPortfolioModal"':"";?>><?php $username=$this->session->user['name'];$subUser=substr($username,0,1);
		if(isset($this->session->user)){
			echo $subUser;
		} else {?>
			&nbsp;
		<?php } ?>
		</a>
		<?php if(isset($this->session->user)){?>
		<div class="menu">
			<div class="users_modal modal--light modal--small">
				<div class="modal__header">
					<div class="modal__left">
						<div class="trimUser menu__badge">
							<?php echo $subUser;?>
						</div>
					</div>
					<div class="modal__middle">
						<h1 class="modal__title"><?php echo $username;?></h1>
						<input data-name="<?php echo $username;?>" class="hide user_edit_input" value="<?php echo $username;?>">
						<a class="title_edit">
							<span class="top_tooltip_dp"><?php echo showLangVal($activeLanguage,"edit_account_tooltip"); ?></span>
						</a>
					</div>
					<div class="modal__right">
						<div class="close-button">
							<a class="close-button__link"><span class="close-button__holder"><img class="close-button__img" src="<?php echo base_url()."assets/images/cross_black.svg";?>" alt="Close"></span></a>
						</div>
					</div>
				</div>
				<div class="modal__body">
					<ul class="menu__list">
						<li class="menu__item">
							<span class="packupPhrase_detailText menu__link">
							<?php echo showLangVal($activeLanguage,"restore_account_description"); ?>
							</span>
						</li>
						<li class="menu__item">
							<span class="menu__link">
								<?php echo showLangVal($activeLanguage,"backup_phrase"); ?>:
								<span class="packupPhrase"><?php echo $this->session->user['hash'];?></span>
								<a id="clip" data-clipboard-text="<?php echo $this->session->user['hash'];?>" class="backpharse_copy">
									<span class="top_tooltip_dp copy_phareas"><?php echo showLangVal($activeLanguage,"copy"); ?></span>
								</a>
							</span>
						</li>
					</ul>
					<a href="<?php echo base_url()."logout"?>" class="menu__switch"><?php echo showLangVal($activeLanguage,"logout"); ?></a>
				</div>
			</div>
		</div>
		<?php } ?>
		<div class="crcChn currency_menu_setting"></div>
		<div class="menu_settings_header">
			<select id="header_currency" class="selectpicker header_currency pull-right" data-live-search="true">
			<?php foreach($currencies as $index=>$value){ ?>
				<option data-value="<?php echo $value['currency']; ?>" <?php echo($value['currency'] == $activeCurrency['currency'] ? "selected" : ""); ?> data-content="<img width='26' src='<?php echo base_url("assets/images/flags/".$value['countryCode'].".svg"); ?>' /> <?php echo $value['currency']; ?>"></option>
			<?php } ?>
			</select>
			<!-- .currency-menu -->
			<div class="language-menu" tabindex="0">
				<?php echo $defaultLanguage['name'];?>
				<div class="language-append">
				<?php foreach($languages as $index=>$value){
					$selected=$value['code']==$defaultLanguage['code']?"selected":"";?>
					<a class="langChange" data-perma="<?php echo $value['code'];?>"> <?php echo $value['name'];?></a>
					<?php } ?>
				</div>
			</div><!-- .language-menu -->
			<label class="switch"> 
				<input <?php echo $nightMode?"checked":"";?>  class="lightsonoff" type="checkbox">
				<span class="slider round"></span>
			</label>
			<div class="night_mode_text"><?php echo showLangVal($activeLanguage,"night_mode"); ?></div>
		</div>
		
		<div class="market-cap-area">
			<div class="market-cap-text">
				<span class="cap-ttl"><?php echo showLangVal($activeLanguage,"market_cap"); ?></span>
				<span class="cap-desc"><?php echo $activeCurrency['symbol']." ".number_format($coinStats['totalMarketCap']*$activeCurrency['rate'], 0, '.', ',');?></span>
			</div>
			<div class="market-cap-text">
				<span class="cap-ttl"><?php echo showLangVal($activeLanguage,"24h_volume"); ?></span>
				<span class="cap-desc"><?php echo $activeCurrency['symbol']." ".number_format($coinStats['totalVolume']*$activeCurrency['rate'], 0, '.', ',');?> </span>
			</div>
			
		</div>
	</div>
	<div class="clearfix"></div>
</nav><!-- .top-bar -->
<?php 
if(isset($adPageHeader) && !empty($adPageHeader)) {
	$this->load->view("front/includes/ad-show",['currentPage' => $adPageHeader, "className" => "header_add"]);
}
?>
<div class="container-fluid">
	<div class="se search-area">

		<div class="search_btns">
			<div class="search-icon-main">
				<span class="search-icon"></span>
				<span class="search-spinner hide"></span>
				<span class="search-cross hide"><i class="ti-close"></i></span>
			</div>
		</div>
		
		<input id="query" type="text" placeholder="<?php echo showLangVal($activeLanguage,"search"); ?>" autocomplete="off">
		<div class="search-position appendDivSearch">
			
		</div>
		
	</div><!-- .search-area -->
	
	<div class="top-tabs-area">
		<div class="top-tabs">
			<a class="<?php echo $url=="" || $this->uri->segment(1)=="coin"?"active":"";?>" href="<?php echo base_url();?>"><?php echo showLangVal($activeLanguage,"market"); ?></a>
			<a class="<?php echo $url=="watch-list"?"active":"";?>" href="<?php echo base_url()."watch-list";?>"><?php echo showLangVal($activeLanguage,"watchlist"); ?></a>
			<a class="<?php echo ($url=="portfolio" || $this->uri->segment(1)=="portfolio")?"active":"";?>" href="<?php echo base_url()."portfolio";?>"><?php echo showLangVal($activeLanguage,"portfolio"); ?></a>
			<a class="top_tabs_more dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
			<?php 
				if($url=="calculator" || $url=="movers")
				{
					echo $pageName;
				}
				else
				{
					echo "More";
				}
			?>
			</a>
			<ul class="dropdown-menu tabs_more_ul" role="menu">
				<li class="<?php echo $url=="movers"?"active":"";?>"><a class="<?php echo $url=="movers"?"active":"";?>" href="<?php echo base_url()."movers";?>"><?php echo showLangVal($activeLanguage,"movers"); ?></a></li>
				<li class="<?php echo $url=="calculator"?"active":"";?>" href="<?php echo base_url()."watch-list";?>"><a href="<?php echo base_url()."calculator";?>">Calculator</a></li>
			</ul>
		</div><!-- .top-tabs -->
	</div><!-- .text-center -->
	
</div><!-- .container-fluid -->

<?php if(!isset($this->session->secure)){?> 
<div id="addPortfolioModal" class="modal fade " role="dialog">
	<div class="modal-dialog add_portfolio_lg">
		<!-- Modal content-->
		<div class="modal-content">
			<button class="modal_cross" data-dismiss="modal"></button>
			<div class="watchlist_area">
				<div id="rep" class="line_row">
					<div class="portfolio_add_area">
						<div class="icon_image"></div>
						<div class="icon_title portfolio_title"><?php echo showLangVal($activeLanguage,"add_new_account"); ?></div>
						<div class="icon_dec portfolio_short_desc">
							<b>&#9734; <?php echo showLangVal($activeLanguage,"add_account_line_1"); ?></b><br>
							<b>&#9734; <?php echo showLangVal($activeLanguage,"add_account_line_2"); ?></b>
						</div>
						<div class="profile_name_label_input">
							<div class="profile_name_label"><?php echo showLangVal($activeLanguage,"account_name"); ?></div>
							<input id="pName" placeholder="<?php echo showLangVal($activeLanguage,"account_name"); ?>" class="text-center profile_name_input form-control" type="text">
						</div>
						<div class="clearfix"></div>
						<a class="add_portofolio_btn check_btn_header" id="createNewPortfolio"><?php echo showLangVal($activeLanguage,"create_account"); ?></a>
						<div class="clearfix"></div>
						<a class="res-btn restore_portfolio_btn"><?php echo showLangVal($activeLanguage,"restore_account"); ?></a>
					</div>
					<div class="clearfix"></div>
				</div>
					
			</div>
			
		</div>
	</div>
</div>
<?php } ?>