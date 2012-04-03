<dl class="tweet-list slidedeck">
    
    <?php foreach( $formatted_rss_items as $key => $value ): ?>
        <?php 
            if( preg_match( '/\/slidedeck/i', $value['permalink'] ) ){
                $icon = 'slidedeck-icon';
            }elseif( preg_match( '/\/dtelepathy/i', $value['permalink'] ) ){
                $icon = 'dtelepathy-icon';
            }
        ?>
        
        <dd class="tweet">
            <div class="tweet-inner">
                <div class="slidedeck-vertical-center-outer">
                    <div class="slidedeck-vertical-center-middle">
                        <div class="slidedeck-vertical-center-inner">
                            <div class="tweet"><?php echo $value['tweet']; ?></div>
                            <a class="time-ago" href="<?php echo $value['permalink']; ?>" target="_blank"><div class="icon <?php echo $icon; ?>"></div><?php echo $value['time_ago']; ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </dd>
    <?php endforeach; ?>
    
</dl>
<div class="nav-wrapper"></div>
<a class="prev navigation" href="#prev">Prev</a>
<a class="next navigation" href="#next">Next</a>
