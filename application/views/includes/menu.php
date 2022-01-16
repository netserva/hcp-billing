<nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/">
            <?php $display = config_item('logo_or_icon'); ?>
            <?php if ('logo' == $display || 'logo_title' == $display) { ?>
            <img src="<?php echo base_url(); ?>resource/images/<?php echo config_item('company_logo'); ?>" class="img-responsive <?php echo ('logo' == $display ? '' : 'thumb-sm m-r-sm'); ?>">
            <?php } elseif ('icon' == $display || 'icon_title' == $display) { ?>
            <i class="fa <?php echo config_item('site_icon'); ?>"></i>
            <?php } ?>
            <?php
                    if ('logo_title' == $display || 'icon_title' == $display) {
                        if ('' == config_item('website_name')) {
                            echo config_item('company_name');
                        } else {
                            echo config_item('website_name');
                        }
                    }
                ?>
          </a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">        
          <div class="navbar-right">
          <ul class="nav navbar-nav">
            <li <?php echo ('' == $this->uri->segment(1)) ? 'class="active"' : ''; ?>><a href="<?php echo base_url(); ?>"><i class="fa fa-fw fa-home"></i> <?php echo lang('home'); ?></a></li>
            <li <?php echo ('' == $this->uri->segment(1)) ? 'class="active"' : ''; ?>><a href="<?php echo base_url(); ?>contact" ><i class="fa fa-fw fa-envelope"></i> <?php echo lang('contact'); ?></a></li>
            
            <?php if (!$this->session->userdata('user_id')) { ?>
            <li <?php echo ('' == $this->uri->segment(1)) ? 'class="active"' : ''; ?>><a href="<?php echo base_url(); ?>login"><i class="fa fa-fw fa-user"></i> <?php echo lang('login'); ?></a></li>
            <?php } else { ?>

              <li><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-fw fa-dashboard"></i> <?php echo lang('dashboard'); ?></a></li>

            <?php } ?>

            <li <?php echo ('' == $this->uri->segment(1)) ? 'class="active"' : ''; ?>> <?php if ('js' == config_item('cart')) { ?>
           <a href="#" id="shopping_cart"><i class="fa fa-fw fa-shopping-cart"></i> <?php echo lang('cart'); ?> <span class="badge badge-warning" id="cart_count">0</span></a>
        <?php } else { ?>
            <a href="<?php echo base_url(); ?>home/shopping_cart"><i class="fa fa-fw fa-shopping-cart"></i> <?php echo lang('cart'); ?> <span class="badge badge-warning"><?php echo count($this->session->userdata('cart')); ?></span></a>
          <?php } ?></li>
          <?php if ('TRUE' == config_item('enable_languages')) { ?>
            <li>
            <div class="btn-group dropdown">                                
                                
						<button type="button" class="btn btn-sm dropdown-toggle btn-<?php echo config_item('theme_color'); ?>" data-toggle="dropdown" btn-icon="" title="<?php echo lang('languages'); ?>"><i class="fa fa-globe"></i></button>
						<button type="button" class="btn btn-sm btn-primary dropdown-toggle  hidden-nav-xs" data-toggle="dropdown"><?php echo lang('languages'); ?> <span class="caret"></span></button>
              <!-- Load Languages -->
                    <ul class="dropdown-menu text-left">
                    <?php $languages = App::languages(); foreach ($languages as $lang) {
                    if (1 == $lang->active) { ?>
                    <li>
                        <a href="<?php echo base_url(); ?>set_language?lang=<?php echo $lang->name; ?>" title="<?php echo ucwords(str_replace('_', ' ', $lang->name)); ?>">
                            <img src="<?php echo base_url(); ?>resource/images/flags/<?php echo $lang->icon; ?>.gif" alt="<?php echo ucwords(str_replace('_', ' ', $lang->name)); ?>"  /> <?php echo ucwords(str_replace('_', ' ', $lang->name)); ?>
                        </a>
                    </li>
                    <?php }
                } ?>
                    </ul>
                  </div>
                  </li>
          <?php } ?>
          </ul>            
         
        </div>
        </div><!--/.navbar-collapse -->
      </div>
    </nav>