
        <div id="content">
            <div id="primary">
                <section id="archive" class="archive">
                    <?php foreach($this->noteIndex as $year => $note){?>
                    <div class="collection-title">
                        <h2 class="archive-year"><?php echo $year;?></h2>
                    </div>

                    <div class="archive-post">
                        <span class="archive-post-time"><?php echo $note['mouth'];?></span>
                        <span class="archive-post-title">
                        <a href="<?php echo $note['url'];?>" class="archive-post-link">
                            <?php echo $note['title'];?>
                        </a>
                    </span>
                    </div>
                    <?php }?>
                </section>
            </div>
        </div>