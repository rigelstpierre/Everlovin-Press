<script type="text/javascript">
    (function($){
        $(document).ready(function(){
            
            <?php foreach( $pointers as &$pointer ): ?>
            
                $('<?php echo $pointer['selector']; ?>').pointer({
                    content: '<?php echo $pointer['content']; ?>',
                    position: {
                        edge: '<?php echo $pointer['position']['edge']; ?>',
                        align: '<?php echo $pointer['position']['align']; ?>'
                    },
                    close: function(){
                        $.post( ajaxurl, {
                            pointer: '<?php echo $pointer['id']; ?>',
                            action: 'dismiss-wp-pointer'
                        });
                    }
                }).pointer('open');
            
            <?php endforeach; ?>
            
        });
    })(jQuery);
</script>
