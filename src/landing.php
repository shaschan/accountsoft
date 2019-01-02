<?php
//    include_once dirname(__FILE__,2).'/config.php';
//    $conf = new config();
?>
<div class="landing_bg"></div>
<script>
  setTimeout(function(){
    var heightLandingBG = window.innerHeight-($(".panel-footer").innerHeight())-($(".jumbotron").innerHeight());
    $(".landing_bg").css("height",heightLandingBG+'px')
  }, 0);
</script>
