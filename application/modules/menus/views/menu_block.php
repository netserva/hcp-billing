<ul <?php echo (1 == $menu->id) ? 'class="nav navbar-nav"' : 'class="menu-'.$menu->id.'"'; ?>>
    <?php

              for ($i = 0; $i < count($menu->main_menu, true); ++$i) {
                  if (str_contains($menu->main_menu[$i]->url, 'http')) {
                      $url = $menu->main_menu[$i]->url;
                  } else {
                      $url = ('/' == $menu->main_menu[$i]->url) ? base_url() : base_url().$menu->main_menu[$i]->url;
                  }

                  if (0 == count($menu->main_menu[$i]->parent_menu, true)) { ?>
    <li><a href="<?php echo ('/' != $url) ? $url : base_url(); ?>">
            <?php echo $menu->main_menu[$i]->title; ?></a></li>
    <?php } else { ?>
    <li class="has-dropdown">
        <a href="<?php echo base_url().$url; ?>" class="dropdown-toggle" data-toggle="dropdown"><?php
                              echo $menu->main_menu[$i]->title; ?></a>
        <ul class="dropdown-menu">
            <?php for ($b = 0; $b < count($menu->main_menu[$i]->parent_menu, true); ++$b) {
                                  if (str_contains($menu->main_menu[$i]->parent_menu[$b]->url, 'http')) {
                                      $url = $menu->main_menu[$i]->parent_menu[$b]->url;
                                  } else {
                                      $url = base_url().$menu->main_menu[$i]->parent_menu[$b]->url;
                                  }

                                  if (!isset($menu->main_menu[$i]->parent_menu[$b]->parent_submenu)) { ?>
            <li><a href="<?php echo $url; ?>"><?php echo $menu->main_menu[$i]->parent_menu[$b]->title; ?></a></li>
            <?php } else { ?>
            <li class="has-dropdown dropdown-submenu">
                <a href="<?php echo base_url().
                                              $url; ?>"><?php echo $menu->main_menu[$i]->parent_menu[$b]->title; ?></a>
                <?php if (isset($menu->main_menu[$i]->parent_menu[$b]->parent_submenu)) {
                                                  ?>
                <ul class="dropdown-menu">
                    <?php foreach ($menu->main_menu[$i]->parent_menu[$b]->parent_submenu
                                            as $par_sub) {
                                                      if (str_contains($par_sub->url, 'http')) {
                                                          $url = $par_sub->url;
                                                      } else {
                                                          $url = base_url().$par_sub->url;
                                                      } ?>
                    <li><a href="<?php echo $url; ?>"><?php echo $par_sub->title; ?>
                        </a></li>
                    <?php
                                                  } ?>
                </ul>
                <?php
                                              } ?>

            </li>
            <?php } ?>
            <?php
                              } ?>
        </ul>
    </li>
    <?php } ?>
    <?php
              } ?>
</ul>