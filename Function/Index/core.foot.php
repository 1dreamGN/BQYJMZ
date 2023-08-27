</section>
    <!-- footer -->
    <div class="app-footer wrapper b-t bg-light">
      <span class="pull-right">Powered by  <?= C('webname') ?></span>
	  &copy; 2015-2016  <?= C('webname') ?>  All rights reserved.
    </div>
    <!-- / footer -->
  </div>
    <!-- jQuery -->
  <script src="../../Template/admin/jquery.min.js"></script>
  <script src="../../Template/admin/bootstrap.js"></script>
<script type="text/javascript" src="http://lib.sinaapp.com/js/jquery/1.9.0/jquery.js"></script> 
<script src="../../Template/admin/sweetalert.min.js"></script>
<?php if(C("music")=='1'){ ?>
<script src="../../Template/admin/pjax.js"></script>
  <script>
		$(document).pjax('a[target!=_blank][pjax!=no][href!=#]', '#container', {fragment:'#container', timeout:5000});
		$(document).on('pjax:send', function() { //pjax链接点击后显示加载动画；
			$("#Loading").css("display", "block");
		});
		$(document).on('pjax:complete', function() { //pjax链接加载完成后隐藏加载动画；
			$("#Loading").css("display", "none");
window.prettyPrint && window.prettyPrint();
		});
	</script>
	<?php } ?>
<?php if ($userrow['player'] == 1) {?>
<script src="../../Template/admin/pjax.js"></script>
  <script>
		$(document).pjax('a[target!=_blank][pjax!=no][href!=#]', '#container', {fragment:'#container', timeout:5000});
		$(document).on('pjax:send', function() { //pjax链接点击后显示加载动画；
			$("#Loading").css("display", "block");
		});
		$(document).on('pjax:complete', function() { //pjax链接加载完成后隐藏加载动画；
			$("#Loading").css("display", "none");
window.prettyPrint && window.prettyPrint();
		});
	</script>
	<?php } ?>
  <script type="text/javascript">
    +function ($) {
      $(function(){
        // class
        $(document).on('click', '[data-toggle^="class"]', function(e){
          e && e.preventDefault();
          console.log('abc');
          var $this = $(e.target), $class , $target, $tmp, $classes, $targets;
          !$this.data('toggle') && ($this = $this.closest('[data-toggle^="class"]'));
          $class = $this.data()['toggle'];
          $target = $this.data('target') || $this.attr('href');
          $class && ($tmp = $class.split(':')[1]) && ($classes = $tmp.split(','));
          $target && ($targets = $target.split(','));
          $classes && $classes.length && $.each($targets, function( index, value ) {
            if ( $classes[index].indexOf( '*' ) !== -1 ) {
              var patt = new RegExp( '\\s' + 
                  $classes[index].
                    replace( /\*/g, '[A-Za-z0-9-_]+' ).
                    split( ' ' ).
                    join( '\\s|\\s' ) + 
                  '\\s', 'g' );
              $($this).each( function ( i, it ) {
                var cn = ' ' + it.className + ' ';
                while ( patt.test( cn ) ) {
                  cn = cn.replace( patt, ' ' );
                }
                it.className = $.trim( cn );
              });
            }
            ($targets[index] !='#') && $($targets[index]).toggleClass($classes[index]) || $this.toggleClass($classes[index]);
          });
          $this.toggleClass('active');
        });

        // collapse nav
        $(document).on('click', 'nav a', function (e) {
          var $this = $(e.target), $active;
          $this.is('a') || ($this = $this.closest('a'));
          
          $active = $this.parent().siblings( ".active" );
          $active && $active.toggleClass('active').find('> ul:visible').slideUp(200);
          
          ($this.parent().hasClass('active') && $this.next().slideUp(200)) || $this.next().slideDown(200);
          $this.parent().toggleClass('active');
          
          $this.next().is('ul') && e.preventDefault();

          setTimeout(function(){ $(document).trigger('updateNav'); }, 300);      
        });
      });
    }(jQuery);
  </script>
   <?php if(!empty($msg))echo "<script type='text/javascript'>{$msg}</script>";
?>
</body>
</html>