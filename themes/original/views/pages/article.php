<div class="row">
        <div class="col-md-12">
             <?php blocks('full_width_top', get_slug()); ?>
     </div>
 </div>
  

<!-- container -->
<div class="container inner">
        <div class="row">

            <!-- Sidebar -->
            <?php if (1 == $article->sidebar_left) { ?>
            <aside class="col-sm-3 sidebar_left">
            <?php blocks('sidebar_left', get_slug()); ?>
            </aside>
            <?php } ?>
            <!-- /Sidebar -->

            <!-- main content -->
            <section class="<?php if (1 == $article->sidebar_right && 1 == $article->sidebar_left) {
    echo 'col-md-6';
} elseif (1 == $article->sidebar_right || 1 == $article->sidebar_left) {
                    echo 'col-md-9';
                } else {
                    echo 'col-md-12 0';
                }
                ?>">

              <?php blocks('content_top', get_slug()); ?>

              <div class="kb-popular view_article"> 

              <?php echo $article->body; ?> 

              <?php if (!empty($article->video)) { ?>

              <hr>
              
              <div class="video-container">
                <iframe src="<?php echo $article->video; ?>" allow="autoplay; encrypted-media" allowfullscreen="allowfullscreen" width="640" height="480" frameborder="0">
                </iframe>
            </div>
                <?php } ?>

              <hr>
              <div class="small">Last Updated: <?php echo $article->modified; ?>
              <span class="pull-right"><i class="fa fa-eye"></i> <?php echo $article->views; ?></span>
            </div>
              
              
            </div>

              <div class="inner">
               <?php blocks('content_bottom', get_slug()); ?>
            </div>
            
            </section>
            <!-- /main -->

            <!-- Sidebar -->
            <?php if (1 == $article->sidebar_right) { ?>
            <aside class="col-sm-3 sidebar_right">
            <div class="kb-latest">              
                    <h3 class="">Latest Articles</h3>  
                       <ul>
                        <?php foreach ($latest as $article) { ?>
                        <li>
                        <a href="<?php echo base_url(); ?>knowledge/article/<?php echo $article->slug; ?>"><?php echo $article->title; ?></a>                          
                        </li>
                        <?php } ?>
                    </ul>
                </div> 


                <h3 class="">Categories</h3>  
                <ul class="list_group">
                    <?php foreach ($categories as $category) { ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <a
                            href="<?php echo base_url(); ?>knowledge/category/<?php echo strtolower(str_replace(' ', '_', $category->cat_name)); ?>">
                            <?php echo $category->cat_name; ?></a>
                        <span class="badge badge-primary badge-pill"><?php echo $category->num; ?></span>
                    </li>
                    <?php } ?>
                </ul> 
            </aside>
            <?php } ?>
            <!-- /Sidebar -->

        </div>
    </div>


     <!-- Full width -->   
    <section class="white-wrapper">
         <div class="row">
              <div class="col-md-12">
              <?php blocks('full_width_content_bottom', get_slug()); ?>
              </div>
            </div>
   </section>

 

 <!-- Normal width -->    
 <section class="whitesmoke-wrapper">	
      <div class="container inner">
        <div class="row">
          <div class="col-md-12">
          <?php blocks('page_bottom', get_slug()); ?>
          </div>
        </div>
      </div>
  </section>


<!-- Normal width -->  
  <section class="white-wrapper">
    <div class="container inner">
         <div class="row">
              <div class="col-md-12">
              <?php blocks('footer_top', get_slug()); ?>
              </div>
            </div>
        </div>
   </section>

 