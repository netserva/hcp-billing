
            <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                <?php foreach ($slider as $key => $row) { ?>
                    <li data-target="#carousel-example-generic" data-slide-to="<?php echo $key; ?> <?php echo (0 == $key) ? 'active' : ''; ?> "></li> 
                    <?php }  ?>
                </ol>
                <div class="carousel-inner">

                <?php foreach ($slider as $key => $row) { ?>
                  <div class="item <?php echo (0 == $key) ? 'active' : ''; ?>">
                    <img src="<?php echo base_url(); ?>resource/uploads/<?php echo $row->image; ?>"/>
                        <div class="carousel-caption">
                            <h3><?php echo $row->title; ?></h3>
                            <p><?php echo $row->description; ?></p>
                        </div>
                    </div> 
                 <?php }  ?>
 
                </div>
                <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left"></span></a><a class="right carousel-control"
                        href="#carousel-example-generic" data-slide="next"><span class="glyphicon glyphicon-chevron-right">
                        </span></a>
            </div>
        
 